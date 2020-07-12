<?php

	// Starts the session
		
	session_start();

	// Database related

	include_once './functionality/Database.php';
	include_once './functionality/functions.php';

	$database = new Database();
	$db       = $database -> connect();

	$pagetilte = 'Register account';

	get_header('.', $pagetilte);

	?>

	<div class="container">

	<?php

	// If already logged in
	if (isset($_SESSION['logged_in'])) {
		
	?>

		<p>You are already signed in!</p>

		<ol>
			<li><a href="./logout.php">Logout</a></li>
		</ol>

		<a href="./index.php">&larr; Back</a>
		
	<?php

	}

	// If not logged in
	else {

		// Checks the form
		if (isset($_POST['username'], $_POST['password'], $_POST['display_name'], $_POST['email'])) {

		$username 		= $_POST['username'];
		$password 		= $_POST['password'];
		$display_name 	= $_POST['display_name'];
		$email 			= test_input($_POST["email"]);

			// Error handling
			if (empty($username) or empty($password) or empty($display_name) or empty($email)) {

				$error = "All fields are required!";

			}
			// If fields are complete
			else {

				// If email is wrong
			    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

			    	$error = "Invalid email format";

				}
				// If everything is okay, the query
				else {

					try{

						$query = $db -> prepare("INSERT INTO users ( username, display_name, pwd, user_email, access_level ) VALUES ( ?, ?, ?, ?, 0 )");
					
						$query -> bindValue(1, $username);
						$query -> bindValue(2, $display_name);
						$query -> bindValue(3, $password);
						$query -> bindValue(4, $email);

						$query -> execute();

						header("Location: ./pf-login.php");
						exit();

					}
					catch(Exception $e) {
						die('<div class="error-container"><small class="error">Username or email already in use!</small></div>
							<a href="./register">Try again</a>
							');
					}

				}

			}

		}

		?>

			<?php if (isset($error)) { ?>
				<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
			<?php } ?>

			<form action="./register.php" method="post" autocomple="off">
				<input type="text" name="username" placeholder="Username">
				<input type="text" name="display_name" placeholder="Display Name">
				<input type="text" name="email" placeholder="Email">
				<input type="password" name="password" placeholder="Password">
				<input type="submit" value="Register account">
			</form>

			<a href="./index">&larr; Back</a>


	<?php

	}

	?>

	</div>

	<?php

	get_footer('.');