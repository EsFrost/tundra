<?php
	
	// Starts the session

	session_start(); 

	include_once '../functionality/Database.php';
	include_once '../functionality/Category.php';

	include_once '../functionality/functions.php';

	// Instantiate DB & connect

	$database      = new Database();
	$db            = $database -> connect();

	$categories    = new Category($db);

	$id 	       = $_GET['id'];

	$category = $categories -> get_category($id);

	$pagetitle = 'Edit category: ' . $category['cat_name'];

	get_header('..', $pagetitle);

	?>

	<div class="container">

	<?php

	

	// Checks if the user is logged in

	if (isset($_SESSION['logged_in'])) {

		// For editor and higher level

		if ($_SESSION['access_level'] > 1) {

			// Save on button press

			if (isset($_POST['save_btn'])) {

				if (isset($_POST['title'])) {

					$title = $_POST['title'];

					if (empty($title)) {

						$error = "The category must have a name!";

					}
					else {

						// try catch here!!!!!!!!!!!!!!!!

						try{

							$edit_category = $categories -> edit_category($id, $title);

							echo "<meta http-equiv='refresh' content='0'>";
						}
						catch(Exception $e) {

							die('
								<p>This category name already exists!</p>
								<a href="./edit-delete-category?id=' . $id . '">Try again</a>	
								');
						}

					}

				}

			}

			// Delete on button press

			if (isset($_POST['delete_btn'])) {

				$delete_category = $categories -> delete_category($id);

				header('Location: ./categories');

			}

			?>

				<?php if (isset($error)) { ?>
					<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
				<?php } ?>

				<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
					<h3>Category name</h3>
					<input type="text" name="title" placeholder="Title" value="<?php echo $category['cat_name']; ?>" class="add-title">
					<input type="submit" value="Save" name="save_btn">
					<input type="submit" value="Delete" name="delete_btn">
				</form>
	
			<?php

			}
			else {

				?>

					<p>You can not edit or delete categories.</p>

				<?php

			}

	}

	// If not logged in
	else {

		?>

			<p>You must be logged in to edit or delete a category.</p>

		<?php

	}

	?>

	</div>

	<?php

	get_footer('..');