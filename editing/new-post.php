<?php

	session_start();

	include_once '../functionality/Database.php';
	include_once '../functionality/Post.php';
	include_once '../functionality/functions.php';

	// Instantiate DB & connect

	$database = new Database();
	$db       = $database -> connect();

	$pagetitle = 'Add new post';

	get_header('..', $pagetitle);

	// Checks if the user is logged in

	if (isset($_SESSION['logged_in'])) {

		if ($_SESSION['access_level'] < 1) {

			?>

			<div class="container">
				<p>You are not allowed to use this feature.</p>
			</div>

			<?php

		}
		else {

			$post = new Post($db);

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

					$new_post 	= $post -> new_post($title, $content, $_SESSION['display_name'], $_SESSION['user_id'], $comments_status);

					header('Location: ./index');
				}

			}

		?>

		<div class="container">

			<h4 class="article-title">Add new post</h4>

			<?php if (isset($error)) { ?>
				<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
			<?php } ?>

			<form action="./new-post.php" method="post" autocomplete="off">
				<input type="text" name="title" placeholder="Title" class="add-title">
				<textarea rows="15" cols="20" placeholder="Content" name="content" class="add-content"></textarea>
				<input type="checkbox" name="comments_status" value="comments-status">Allow comments? (disabled by default)
				<input type="submit" value="Create post">
			</form>
			
			<br>

			<a href="#" onclick="goBack();">&larr; Back</a>

		</div>

		<?php
		
		}

	}
		else {

			?>

			<div class="container">

				<p>You must be logged in to access this page.</p>

				<small><a href="../login">Login</a></small>

			</div>

			<?php

		}


	get_footer('..');