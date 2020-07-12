<?php
	
	class Category {

		// Database Connection

		private $conn;
		private $table = 'categories';

		// Constructor

		public function __construct($db) {
			$this -> conn = $db;
		}

		// Show categories

		public function get_categories() {

			// Query

			$query = 'SELECT * FROM ' . $this -> table;

			// Prepare statement

			$stmt = $this -> conn -> prepare($query);

			// Execute query

			$stmt -> execute();

			return $stmt;

		}

		public function get_category($cid) {

			// Query

			$query = 'SELECT * FROM ' . $this -> table . ' WHERE cid = ?';

			// Prepare statement

			$stmt = $this -> conn -> prepare($query);

			// Bind value

			$stmt -> bindValue(1, $cid);

			// Execute query

			$stmt -> execute();

			return $stmt -> fetch();

		}

		public function new_category($cat_name) {

			// Query

			$query = 'INSERT INTO ' . $this -> table . ' (cat_name) VALUES (?)';

			$stmt = $this -> conn -> prepare($query);
			$stmt -> bindValue(1, $cat_name);
			$stmt -> execute();

			return $stmt;

		}

		public function delete_category($cid) {

			// Query

			$query = 'DELETE FROM ' . $this -> table . ' WHERE cid = ?';

			$stmt = $this -> conn -> prepare($query);
			$stmt -> bindValue(1, $cid);
			$stmt -> execute();

			return $stmt;

		}

		public function edit_category($cid, $cat_name) {

			// Query
			// Categoreis table

			$query = 'UPDATE ' . $this -> table . ' SET cat_name = ? WHERE cid = ?';

			$stmt = $this -> conn -> prepare($query);
			$stmt -> bindValue(1, $cat_name);
			$stmt -> bindValue(2, $cid);
			$stmt -> execute();

			// Posts and categories table

			$query_c = 'UPDATE posts_categories SET cat_name = ? WHERE cid = ?';

			$stmt_c = $this -> conn -> prepare($query);
			$stmt_c -> bindValue(1, $cat_name);
			$stmt_c -> bindValue(2, $cid);
			$stmt_c -> execute();

		}

	}