<?php

	// Starts the session
	
	session_start();

	// Database related

	include_once './functionality/Database.php';
	include_once './functionality/functions.php';

	$database = new Database();
	$db       = $database -> connect();

	$pagetitle = 'Login';

	get_header('.', $pagetitle);

	// If already logged in

	if (isset($_SESSION['logged_in'])) {
	
	?>

	<div class="container">

		<ol>
			<li><a href="./logout.php">Logout</a></li>
		</ol>

		<a href="#" onclick="goBack();">&larr; Back</a>

	</div>
		
	<?php

	}

	// If not logged in
	else {

		// Checks if the form is completed
		if (isset($_POST['username'], $_POST['password'])) {

			$username = $_POST['username'];
			$password = $_POST['password'];

			// Error handling
			if (empty($username) or empty($password)) {

				$error = "All fields are required!";

			}

			// If there is no error it executes the query
			else {

				$query = $db -> prepare("SELECT * FROM users WHERE username = ? AND pwd = ?");
				
				$query -> bindValue(1, $username);
				$query -> bindValue(2, $password);
				$query -> execute();

				$num = $query -> rowCount();

				// If everything is fine
				if ($num == 1) {

					$_SESSION['logged_in'] = true;
					$user = $query -> fetch();
					$_SESSION['user_id']   = $user['uid'];
					$_SESSION['display_name'] = $user['display_name'];
					$_SESSION['access_level'] = $user['access_level'];

					header("Location: ./index");
					exit();

				}

				// Error handling
				else {

					$error = "Incorrect credentials. Try again.";

				}
			}
		}

	?>

	<!-- Default layout (form) -->

	<div class="container">

		<?php if (isset($error)) { ?>
			<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
		<?php } ?>

		<form action="./pf-login.php" method="post" autocomple="off">
			<input type="text" name="username" placeholder="Username">
			<input type="password" name="password" placeholder="Password">
			<input type="submit" value="Login">
		</form>

		<a href="#" onclick="goBack();">&larr; Back</a>	

	</div>
		
	<?php

		}

	get_footer('.');