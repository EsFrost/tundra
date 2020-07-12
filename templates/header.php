<?php

	// Headers
	header('Access-Contol-Allow-Origin: *'); // to be accessed by anyone

	function header_path($path, $site_name, $pagetitle) {

		?>
				<!DOCTYPE html>
				<html lang="en">

					<head>
						<?php

						if(isset($pagetitle)){
						 echo "<title>$pagetitle ". "-" ." $site_name</title>";
						} 
						  else {
						echo "<title>$site_name</title>";
						}
						?>

						<!-- Meta tags -->
						<meta charset="utf-8">
						<meta name="viewport" content="width=device-width, initial-scale=1.0">

						<!-- Site Icon -->
						<!--<link rel="icon" href="dynamically selected!">-->

						<!-- Css files -->
						<link rel="stylesheet" href="<?php echo $path; ?>/source/css/main.css">

					</head>

					<body>

		<?php

	}

