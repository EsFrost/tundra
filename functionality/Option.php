<?php

	class Option {

		// Database connection
		private $conn;
		private $table = 'options';

		// Constructor
		public function __construct($db) {
			$this -> conn = $db;
		}

		// Read posts
		public function get_options() {
			
			// Query
			$query = 'SELECT * FROM	' . $this ->  table;

			// Statement
			$stmt = $this -> conn -> prepare($query);

			// Query execution
			$stmt -> execute();
			return $stmt;
		}

		public function get_sitename() {

			// Query
			$query = 'SELECT content FROM ' . $this -> table . ' WHERE title = "Site name"';

			$stmt = $this -> conn -> prepare($query);
			$stmt -> execute();
			$res = $stmt -> fetch();
			return $res;

		}

	}