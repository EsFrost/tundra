<?php
	class Database {

		// Parameters

		private $host     = 'localhost';
		private $db_name  = 'simple_cms';
		private $username = 'root';
		private $pwd      = '';
		private $conn; // represents the connection

		// Connection

		public function connect() {
			$this -> conn = null;

			try {
				$this -> conn = new PDO('mysql:host=' . $this -> host . ';dbname=' . $this -> db_name, $this -> username, $this -> pwd);
				$this -> conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // enables error mode to get exceptions
			}
			catch(PDOException $e) {
				echo 'Connection error: ' . $e -> getMessage();
			}

			return $this -> conn;
		}
	}