<?php

	// Header function
	function get_header($path, $pagetitle) {

		include_once $path.'/templates/header.php';
		include_once $path.'/functionality/Database.php';
		include_once $path.'/functionality/Option.php';

		// Instantiate DB & connect
		$database = new Database();
		$db       = $database -> connect();

		$option   = new Option($db);

		$site_name = $option -> get_sitename();
		header_path($path, $site_name['content'], $pagetitle);

	}

	// Footer function
	function get_footer($path) {

		include_once $path.'/templates/footer.php';

		footer_path($path);

	}

	// Input validation
	function test_input($data) {

	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  
	  return $data;

	}