<?php
	
	// Starts the session

	session_start(); 

	include_once '../functionality/Database.php';
	include_once '../functionality/Post.php';
	include_once '../functionality/Comment.php';

	include_once '../functionality/functions.php';

	// Instantiate DB & connect

	$database      = new Database();
	$db            = $database -> connect();

	$post 	       = new Post($db);

	$comments 	   = new Comment($db);

	$id 	       = $_GET['id'];

	$list_comments = $comments -> get_comments($id);

	$the_post = $post -> get_post($id);

	$pagetitle = 'Edit post: ' . $the_post['title'];

	get_header('..', $pagetitle);

	// Checks if the user is logged in

	if (isset($_SESSION['logged_in'])) {

		// For editor and higher level

		if ($_SESSION['access_level'] > 1) {

			
			// Save on button press

			if (isset($_POST['save_btn'])) {

				if (isset($_POST['title'], $_POST['content'])) {

					$title 				= $_POST['title'];
					$content 			= $_POST['content'];
					$comments_status 	= 0;

					if (isset($_POST['comments_status'])) {
						$comments_status = 1;
					}

					if (empty($title) or empty($content)) {

						$error = "All fields are required!";

					}
					else {
						
						$edit_post = $post -> edit_post($id, $title, $content, $comments_status);

						echo "<meta http-equiv='refresh' content='0'>";

					}

				}

			}

			// Delete on button press

			if (isset($_POST['delete_btn'])) {

				$delet_post = $post -> delete_post($id);

				header('Location: ./index');

			}

			?>
		
			<div class="container">

				<?php if (isset($error)) { ?>
					<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
				<?php } ?>

				<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
					<h3>Title</h3>
					<input type="text" name="title" placeholder="Title" value="<?php echo $the_post['title']; ?>" class="add-title">
					<p><small>by <?php echo $the_post['author']; ?></small></p>
					<textarea rows="15" cols="20" placeholder="Content" name="content" class="add-content"><?php echo $the_post['content']; ?></textarea>
					<?php
						if ($the_post['comments_status'] == 1) {

							?>

							<input type="checkbox" name="comments_status" value="comments-status" checked>Allow comments? (disabled by default)

							<?php

						}
						else {

							?>
							
							<input type="checkbox" name="comments_status" value="comments-status">Allow comments? (disabled by default)

							<?php

						}
					?>
					<input type="submit" value="Save" name="save_btn">
					<input type="submit" value="Delete" name="delete_btn">
				</form>

				<h3>Comments</h3>

					<?php
						foreach ($list_comments as $comment) {

							?>

							<ol>
								<li>
									<p class="comment"><?php echo $comment['comment_content']; ?><small> by <?php echo $comment['author'];?> - on <?php echo date('d-m-Y', strtotime($comment['comment_date'])); ?></small></p>
								</li>
							</ol>
							
							<?php
						
						}
					?>
			</div>
	
			<?php


		}

		// Author level

		elseif ($_SESSION['access_level'] == 1) {

			$the_post = $post -> get_post($id);

			// Check if user is the owner of the post

			if ($_SESSION['display_name'] == $the_post['author']) {

				// Save on button press

				if (isset($_POST['save_btn'])) {

					if (isset($_POST['title'], $_POST['content'])) {

						$title 				= $_POST['title'];
						$content 			= $_POST['content'];
						$comments_status 	= 0;

						if (isset($_POST['comments_status'])) {
							$comments_status = 1;
						}

						if (empty($title) or empty($content)) {

							$error = "All fields are required!";

						}
						else {
							
							$edit_post = $post -> edit_post($id, $title, $content, $comments_status);

							echo "<meta http-equiv='refresh' content='0'>";

						}

					}

				}

				// Delete on button press

				if (isset($_POST['delete_btn'])) {

					$delet_post = $post -> delete_post($id);

					header('Location: ./index');

				}

				?>
			
				<div class="container">

					<?php if (isset($error)) { ?>
						<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
					<?php } ?>

					<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
						<h3>Title</h3>
						<input type="text" name="title" placeholder="Title" value="<?php echo $the_post['title']; ?>" class="add-title">
						<p><small>by <?php echo $the_post['author']; ?></small></p>
						<textarea rows="15" cols="20" placeholder="Content" name="content" class="add-content"><?php echo $the_post['content']; ?></textarea>
						<?php
							if ($the_post['comments_status'] == 1) {

								?>

								<input type="checkbox" name="comments_status" value="comments-status" checked>Allow comments? (disabled by default)

								<?php

							}
							else {

								?>
								
								<input type="checkbox" name="comments_status" value="comments-status">Allow comments? (disabled by default)

								<?php

							}
						?>
						<input type="submit" value="Save" name="save_btn">
						<input type="submit" value="Delete" name="delete_btn">
					</form>

					<h3>Comments</h3>

					<?php
						foreach ($list_comments as $comment) {

							?>

							<ol>
								<li>
									<p class="comment"><?php echo $comment['comment_content']; ?><small> by <?php echo $comment['author'];?> - on <?php echo date('d-m-Y', strtotime($comment['comment_date'])); ?></small></p>
								</li>
							</ol>
							<?php
						
						}
					?>

				</div>
		
				<?php

			}
			else {

				?>

				<div class="container">
					<p>You can not edit or delete posts you do not own.</p>
				</div>

				<?php

			}

		}

		// Simple user

		else {

			?>

			<div class="container">
				<p>You can not create, edit or delete posts.</p>
			</div>

			<?php

		}

	}

	// If not logged in
	else {

		?>

		<div class="container">
			<p>You must be logged in to edit or delete a post.</p>
		</div>

		<?php

	}

	get_footer('..');