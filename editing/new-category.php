<?php
	
	// Creates new category for editor level and higher

	// Session
	
	session_start();

	include_once '../functionality/Database.php';
	include_once '../functionality/Category.php';

	include_once '../functionality/functions.php';

	// Instantiate DB & connect

	$database = new Database();
	$db       = $database -> connect();

	$categories = new Category($db);

	$pagetitle = 'Add new category';

	get_header('..');

	?>

	<div class="container">

	<?php

	// If user is logged in
	if (isset($_SESSION['logged_in'])) {

		// Check the user access level

		// If editor and higher
		if($_SESSION['access_level'] > 1) {

			// If user set the name
			if(isset($_POST['cat_name'])) {

				$cat_name = $_POST['cat_name'];

				// If no name is set
				if (empty($cat_name)) {
					$error = "You didn't set a name for the new category!";
				}
				else {

					try{
						$category = $categories -> new_category($cat_name);

						echo "<meta http-equiv='refresh' content='0'>";
					}
					catch(Exception $e) {
						die('
							<p>This category name already exists!</p>
							<a href="./new-category">Try again</a>	
							');
					}

				}
			}

			?>

			<h4 class="article-title">Create new category</h4>

			<?php if (isset($error)) { ?>
				<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
			<?php } ?>

			<form action="./new-category" method="post" autocomplete="off">
				<input type="text" name="cat_name" placeholder="Category Name" class="add-title">
				<input type="submit" value="Create category">
			</form>
			
			<br>

			<?php

		}
		// Rest of the users
		else {
			echo '<p>You cannot create, edit or delete categories.</p>';
		}

	}
	else {
		header('Location: ../pf-login');
	}

	?>

	</div>

	<?php

	get_footer('..');