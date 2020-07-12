<?php
	
	// Loop all posts according to access level
	// and have option to edit delete each post
	// on selected post go to edit-single-post
	// have option to either edit or delete

	// Starts the session

	session_start();

	include_once '../functionality/Database.php';
	include_once '../functionality/Post.php';

	include_once '../functionality/functions.php';

	// Instantiate DB & connect

	$database = new Database();
	$db       = $database -> connect();

	$post = new Post($db);

	$pagetitle = 'Posts editing';

	get_header('..', $pagetitle);
	
	?>

	<div class="container">

		<p>Edit - Delete post</p>

	<?php

	if (isset($_SESSION['logged_in'])) {


		if ($_SESSION['access_level'] > 1) {

			?>

			<button type="button" onclick="togglePosts('<?php echo $_SESSION['display_name']; ?>');">Toggle my posts</button>

			<?php

			// Post loop

			$results = $post -> get_posts_byauthor();

			$num = $results -> rowCount();

			if ($num > 0) {

				?>

			<ol id='posts-list'>
				<?php foreach ($results as $result) { ?>

					<li class='list-item <?php echo $result['author']; ?>'>
						
						<a href="./edit-delete-post?id=<?php echo $result['pid']; ?>">
							<?php echo $result['title']; ?>
						</a>
						-
						<small>posted by: <?php echo $result['author']; ?> - on: <?php echo date('d-m-Y', strtotime($result['date'])); ?></small>

					</li>

			<?php } ?>

			</ol>

			<br />

		<?php

		}
			else {

				echo '<p>No posts were found.</p>';
			}
			
		}
		elseif ($_SESSION['access_level'] == 1) {
			
			// Loop for logged in author

			$results = $post -> get_posts_id($_SESSION['user_id']);

			$num = $results -> rowCount();

			if ($num > 0) {

			?>

				<ol>
					<?php foreach ($results as $result) { ?>

						<li>
							
							<a href="./edit-delete-post?id=<?php echo $result['pid']; ?>">
								<?php echo $result['title']; ?>
							</a>

						</li>

				<?php } ?>

				</ol>

				<br />

			<?php

			}
			else {

				echo '<p>No posts were found.</p>';
			}

		}
		else {

			?>

			<div class="container">
				<p>You can not add, edit or delete posts.</p>
			</div>

			<?php

		}

		?>

		<small><a href="../logout.php">Logout</a></small>

		<?php

	}
	else {

		header('Location: ../pf-login');

	}

	get_footer('..');	