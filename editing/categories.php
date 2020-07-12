<?php
	
	// Loop all categories for users with access
	// level more than 1 (editor and higher)
	// links to category names take the user
	// to edit-delete category

	// Starts the session

	session_start();

	include_once '../functionality/Database.php';
	include_once '../functionality/Category.php';

	include_once '../functionality/functions.php';

	// Instantiate DB & connect

	$database = new Database();
	$db       = $database -> connect();

	$categories = new Category($db);

	$results = $categories -> get_categories();

	$num = $results -> rowCount();

	$pagetitle = 'Categories editing';

	get_header('..', $pagetitle);

	?>

	<div class="container">

	<?php

	// If user is logged in
	if (isset($_SESSION['logged_in'])) {

		// Check the user access level

		// If editor and higher
		if($_SESSION['access_level'] > 1) {

			// If categories were found
			if ($num > 0) {

				?>

				<ol>
					<?php foreach ($results as $category) { ?>
					<li>
						<a href="./edit-delete-category?id=<?php echo $category['cid']; ?>">
							<?php echo $category['cat_name']; ?>
						</a>
					</li>
					<?php } ?>
				</ol>
				<br />

				<?php

			}
			else {

				echo '<p>No categories are created yet</p>';

			}

		}
		// If author
		elseif ($_SESSION['access_level'] == 1) {

			// If categories were found
			if ($num > 0) {

				?>

				<ol>
					<?php foreach ($results as $category) { ?>
					<li>
						<?php echo $category['cat_name']; ?>
					</li>
					<?php } ?>
				</ol>
				<br />

				<?php

			}
			else {

				echo '<p>No categories are created yet</p>';

			}

		}
		// Rest of the users
		else {
			echo '<p>You cannot create, edit or delete categories.</p>';
		}

	}
	// If not logged in prompt to log in
	else {

		header('Location: ../pf-login');

	}

	?>
	
	</div>

	<?php

	get_footer('..');