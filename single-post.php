<?php
	
	// Starts the session

	session_start(); 

	include_once './functionality/Database.php';
	include_once './functionality/Post.php';
	include_once './functionality/Comment.php';

	include_once './functionality/functions.php';

	// Instantiate DB & connect
	$database = new Database();
	$db       = $database -> connect();

	$post = new Post($db);

	$comments = new Comment($db);

	$single_post = $post -> get_post($_GET['id']);

	$pagetitle = $single_post['title'];

	get_header('.', $pagetitle);	

	if (isset($_GET['id'])) {

		$id = $_GET['id'];

		$single_post = $post -> get_post($id);

		?>

			<div class="container">

				<h2>
					<?php echo $single_post['title']; ?>
				</h2>
				<small>posted on: <?php echo date('d-m-Y', strtotime($single_post['date'])); ?> by <?php echo $single_post['author']; ?></small>
				

				<p class="article-content"><?php echo $single_post['content']; ?></p>			

	<?php

	// If comments are enabled on post
	if ($single_post['comments_status'] == 1) { 

		// Comments loop
		$coms = $comments -> get_comments($id);

		$num = $coms -> rowCount();

		if ($num > 0) {

			?>

			<h3>Comments</h3>

			<?php

			// Check if user logged in
			if (isset($_SESSION['logged_in'])) {

				// Submit
				if (isset($_POST['comment_content'])) {

					$comment_content = $_POST['comment_content'];

					if (empty($comment_content)) {
						$error = "You can't add an empty comment.";
					}
					else {

						$new_comment = $comments -> new_comment($id, $_SESSION['user_id'], $_SESSION['display_name'], $comment_content);

						echo "<meta http-equiv='refresh' content='0'>";
						
					}

				}	
				
				// Add comment
				?>

					<?php if (isset($error)) { ?>
						<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
					<?php } ?>
					<form action="" method="POST" autocomplete="off">
						<textarea name="comment_content" class="add-content" cols="20" rows="3" placeholder="Comment"></textarea>
						<input type="submit" value="Add comment">
					</form>

				<?php

			}

			foreach ($coms as $com) {

				// Checks if logged in and access level
				if (isset($_SESSION['access_level'])) {
					// Editor or higher with unapproved comment
					if ($_SESSION['access_level'] > 1 && $com['status'] == 0) {
						?>

						<p class="comment"><?php echo $com['comment_content']; ?><small> by <?php echo $com['author'];?> - on <?php echo date('d-m-Y', strtotime($com['comment_date'])); ?> Awaiting approval <a href="./edit-delete-comment?id=<?php echo $id; ?>&comid=<?php echo $com['comment_id']; ?>">Edit</a></small></p>

						<?php
					}
					// Editor or higher with approved comment
					elseif ($_SESSION['access_level'] > 1 && $com['status'] == 1) {
						?>

						<p class="comment"><?php echo $com['comment_content']; ?><small> by <?php echo $com['author'];?> - on <?php echo date('d-m-Y', strtotime($com['comment_date'])); ?> <a href="./edit-delete-comment?id=<?php echo $id; ?>&comid=<?php echo $com['comment_id']; ?>">Edit</a></small></p>

						<?php
					}
					// Author or lower with unapproved comment
					elseif ($_SESSION['access_level'] < 2 && $com['status'] == 0) {

						if ($_SESSION['user_id'] == $com['uid']) {
							?>

							<p class="comment"><?php echo $com['comment_content']; ?><small> by <?php echo $com['author'];?> - on <?php echo date('d-m-Y', strtotime($com['comment_date'])); ?> Awaiting approval <a href="./edit-delete-comment?id=<?php echo $id; ?>&comid=<?php echo $com['comment_id']; ?>">Edit</a></small></p>

							<?php
						}

					}
					// Author or lower with approved comment
					elseif ($_SESSION['access_level'] < 2 && $com['status'] == 1) {

						if ($_SESSION['user_id'] == $com['uid']) {
							?>

							<p class="comment"><?php echo $com['comment_content']; ?><small> by <?php echo $com['author'];?> - on <?php echo date('d-m-Y', strtotime($com['comment_date'])); ?> <a href="./edit-delete-comment?id=<?php echo $id; ?>&comid=<?php echo $com['comment_id']; ?>">Edit</a></small></p>

							<?php
						}
						else {
							?>

							<p class="comment"><?php echo $com['comment_content']; ?><small> by <?php echo $com['author'];?> - on <?php echo date('d-m-Y', strtotime($com['comment_date'])); ?></small></p>

							<?php

						}
					}
				}
				// If not logged in
				else {
					if ($com['status'] == 1) {

						?>

						<p class="comment"><?php echo $com['comment_content']; ?><small> by <?php echo $com['author'];?> - on <?php echo date('d-m-Y', strtotime($com['comment_date'])); ?></small></p>

						<?php

					}
				}

			}

		}

	}

		

	?>

	<a href="./index">&larr; Back</a>

	</div>

	<?php

	}
	else {

		header('Location: ./index');

		exit();

	}

	get_footer('.');