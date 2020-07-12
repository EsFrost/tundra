<?php
	
	// If user logged in show links to posts and categories

	
	// Starts the session

	session_start();

	include_once '../functionality/functions.php';

	$pagetitle = 'Editing';

	get_header('..', $pagetitle);

	?>

	<div class="container">

	<?php

	if (isset($_SESSION['logged_in'])) {
		?>
		
		<ul>
			<li><a href="./posts">Posts</a></li>
			<li><a href="./categories">Categories</a></li>
		</ul>
	
		<?php
	}
	else {
		header('Location: ../pf-login');
	}

	?>

	</div>

	<?php

	get_footer('..');