<?php

	// Starts the session

	session_start();

	include_once './functionality/Database.php';
	include_once './functionality/Post.php';

	include_once './functionality/functions.php';

	$pagetitle = 'Homepage';

	get_header('.', $pagetitle);

	// Instantiate DB & connect

	$database = new Database();
	$db       = $database -> connect();

	// Post related

	$post = new Post($db);

	$results = $post -> get_posts();

	$num = $results -> rowCount();

	?>

	<div class="container">

		<a href="./index" id="logo">Tundra CMS</a>

	<?php

	// If something was found
	if ( $num > 0 ) {

		?>

		<ol>
			<?php foreach ($results as $result) { ?>

				<li>
					
					<a href="./single-post?id=<?php echo $result['pid']; ?>">
						<?php echo $result['title']; ?>
					</a>
					-
					<small>posted on: <?php echo date('d-m-Y', strtotime($result['date'])); ?></small>

				</li>

		<?php } ?>

		</ol>

		<br />

	<?php

	}
	else {

		echo 'No posts were found.';
	}

	if (isset($_SESSION['logged_in'])) {

		?>

		<small><a href="./editing/new-post">Add new</a></small>
		&nbsp;
		<small><a href="./logout.php">Logout</a></small>

		<?php

	}
	else {

	?>

	<small><a href="./login">Login</a></small>

	</div>

	<?php

	}

	get_footer('.');