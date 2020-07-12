<?php
	
	// Displays all options
	
	// Starts the session

	session_start(); 

	include_once '../functionality/Database.php';
	include_once '../functionality/Option.php';

	include_once '../functionality/functions.php';

	get_header('..', null);

	?>

	<div class="container">
		<h2>Options</h2>

	<?php

	// Instantiate DB & connect
	$database = new Database();
	$db       = $database -> connect();

	$option   = new Option($db);

	if (isset($_SESSION['logged_in'])) {
		if ($_SESSION['access_level'] > 2) {
			$options = $option -> get_options();

			$num = $options -> rowCount();

			if ($num > 0) {
				?>
				<ol>
				<?php
				foreach($options as $opt) {
					?>

					<li>

						<?php echo $opt['title']; ?>: <?php echo $opt['content']; ?>

					</li>

					<?php
				}
				?>
				</ol>
				<?php
			}
			else {
				echo '<p>No options set.</p>';
			}
		}
		else {

			?>

			<p>You don't have access to this page.</p>
		
			<?php

		}
	}
	else {
		header('Location: ../pf-login');
	}

	?>

	</div>

	<?php

	$path = '/control-panel/index.php';
	$file = basename($path, ".php");
	echo $file;

	get_footer('..');