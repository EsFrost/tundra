<?php

	// Starts the session

	session_start(); 

	include_once './functionality/Database.php';
	include_once './functionality/Post.php';
	include_once './functionality/Comment.php';

	include_once './functionality/functions.php';

	get_header('.');

	// Instantiate DB & connect
	$database = new Database();
	$db       = $database -> connect();

	$post = new Post($db);

	$comments = new Comment($db);

	// Tests if the url is right
	if (isset($_GET['id']) && isset($_GET['comid'])) {

		$id = $_GET['id'];
		$comid = $_GET['comid'];
		$single_post = $post -> get_post($id);

		// Form
		if (isset($_POST['delete_btn'])) {
			$del_com = $comments -> remove_comment($comid);

			header('Location: ./single-post?id='.$id);
		}

		if (isset($_POST['edit_btn'])) {

			if(isset($_POST['comment_status'])) {
				$comment_status = 1;
			}
			else {
				$comment_status = 0;
			}

			if (empty($_POST['comment_content'])) {
				$error = "Comment content can't be empty";
			}
			else {
				$edit_com = $comments -> edit_comment($comment_status, $_POST['comment_content'], $comid);

				echo "<meta http-equiv='refresh' content='0'>";
			}
		}
		
		// Test if the user is logged in
		if (isset($_SESSION['logged_in'])) {

			?>

			<div class="container">

				<h2>
					<?php echo $single_post['title']; ?>
				</h2>
				<small>posted on: <?php echo date('d-m-Y', strtotime($single_post['date'])); ?> by <?php echo $single_post['author']; ?></small>
				

				<p class="article-content"><?php echo $single_post['content']; ?></p>
				
				<?php

				// Comments loop
				$coms = $comments -> get_comments($id);

				$num = $coms -> rowCount();

				if ($num > 0) {

					?>

					<h3>Comments</h3>

					<?php

					if ($_SESSION['access_level'] > 1) {

						foreach ($coms as $com) {

							
							// The form
							if ($com['comment_id'] == $comid) {
								?>

								<?php if (isset($error)) { ?>
									<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
								<?php } ?>
								<form action="" method="POST" autocomplete="off">
									<textarea name="comment_content" class="add-content" cols="20" rows="3" placeholder="Comment"><?php echo $com['comment_content']; ?></textarea>
									<small> by <?php echo $com['author'];?> - on <?php echo date('d-m-Y', strtotime($com['comment_date'])); ?></small>
									<?php
									if ($com['status'] == 1) {
										?>
										<input type="checkbox" name="comment_status" value="comment-status" checked> Is comment approved?
										<?php
									}
									else {
										?>
										<input type="checkbox" name="comment_status" value="comment-status"> Is comment approved?
										<?php
									}
								?>
									<input type="submit" value="Save" name="edit_btn">
									<input type="submit" value="Delete" name="delete_btn">	
								</form>

								<?php
							}
							else {
								// The loop
								?>

								<p class="comment"><?php echo $com['comment_content']; ?><small> by <?php echo $com['author'];?> - on <?php echo date('d-m-Y', strtotime($com['comment_date'])); ?></small></p>

								<?php
							}

						}

					}
					elseif ($_SESSION['access_level'] < 2) {

						// The loop
						foreach ($coms as $com) {
							// If user id and status 0
							if ($_SESSION['user_id'] == $com['uid'] && $com['status'] == 0) {

								// If comid == comment_id
								if ($comid == $com['comment_id']) {
									?>

									<?php if (isset($error)) { ?>
										<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
									<?php } ?>
									<form action="" method="POST" autocomplete="off">
										<textarea name="comment_content" class="add-content" cols="20" rows="3" placeholder="Comment"><?php echo $com['comment_content']; ?></textarea>
										<small> by <?php echo $com['author'];?> - on <?php echo date('d-m-Y', strtotime($com['comment_date'])); ?></small>
										<input type="submit" value="Save" name="edit_btn">
										<input type="submit" value="Delete" name="delete_btn">	
									</form>

									<?php
								}
								// show
								else {

									?>

									<p class="comment"><?php echo $com['comment_content']; ?><small> by <?php echo $com['author'];?> - on <?php echo date('d-m-Y', strtotime($com['comment_date'])); ?></small></p>

									<?php

								}
							}
							// If status 1 show
							elseif ($com['status'] == 1) {

								// If comid == comment_id
								if ($comid == $com['comment_id'] && $_SESSION['user_id'] == $com['uid']) {
									?>

									<?php if (isset($error)) { ?>
										<div class="error-container"><small class="error"><?php echo $error; ?></small></div>
									<?php } ?>
									<form action="" method="POST" autocomplete="off">
										<textarea name="comment_content" class="add-content" cols="20" rows="3" placeholder="Comment"><?php echo $com['comment_content']; ?></textarea>
										<small> by <?php echo $com['author'];?> - on <?php echo date('d-m-Y', strtotime($com['comment_date'])); ?></small>
										<input type="submit" value="Save" name="edit_btn">
										<input type="submit" value="Delete" name="delete_btn">	
									</form>

									<?php
								}
								else {
									// The loop
									?>

									<p class="comment"><?php echo $com['comment_content']; ?><small> by <?php echo $com['author'];?> - on <?php echo date('d-m-Y', strtotime($com['comment_date'])); ?></small></p>

									<?php
								}
							}
							else {
								continue;
							}
								
						}
							
					}

				}

				?>

			</div>

			<?php
		}
		else {
			header('Location: ./single-post?id='.$id);

			exit();
		}

	}
	else {

		header('Location: ./index');

		exit();
	}

	get_footer('.');