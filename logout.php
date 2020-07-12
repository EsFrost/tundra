<?php

	session_start();

	session_destroy();

	header('Location: ./index'); // Return to home page
	die;

?>