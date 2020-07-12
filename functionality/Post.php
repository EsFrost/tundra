<?php

	class Post {

		// Database connection

		private $conn;
		private $table = 'posts';

		// Constructor

		public function __construct($db) {
			$this -> conn = $db;
		}

		// Read posts

		public function get_posts() {
			
			// Query

			$query = 'SELECT * FROM	' . $this ->  table . ' AS p ORDER BY p.date DESC';

			// Statement

				$stmt = $this -> conn -> prepare($query);

			// Query execution

				$stmt -> execute();

				return $stmt;
		}

		// Read posts

		public function get_posts_byauthor() {
			
			// Query

			$query = 'SELECT * FROM	' . $this ->  table . ' AS p ORDER BY p.author ASC';

			// Statement

				$stmt = $this -> conn -> prepare($query);

			// Query execution

				$stmt -> execute();

				return $stmt;
		}

		// Read posts from logged in user

		public function get_posts_id($uid) {
			
			// Query

			$query = 'SELECT * FROM	' . $this ->  table . ' WHERE author_id = ? ORDER BY date DESC ';

			// Statement

				$stmt = $this -> conn -> prepare($query);
				$stmt -> bindValue(1, $uid);

			// Query execution

				$stmt -> execute();

				return $stmt;
		}

		// Read specific post

		public function get_post($pid) {

			// Query

			$query = 'SELECT * FROM posts WHERE pid = ?';

			// Prepare the statement

			$stmt = $this -> conn -> prepare($query);

			// Bind the value

			$stmt -> bindValue(1, $pid);

			// Execute statement

			$stmt -> execute();

			return $stmt -> fetch();

		}

		// Add new post

		public function new_post($title, $content, $author, $author_id, $comments_status) {

			// Query and statement

			$query = 'INSERT INTO ' . $this -> table . '(title, content, author, author_id, comments_status) VALUES (?, ?, ?, ?, ?)';

			$stmt = $this -> conn -> prepare($query);
			$stmt -> bindValue(1, $title);
			$stmt -> bindValue(2, $content);
			$stmt -> bindValue(3, $author);
			$stmt -> bindValue(4, $author_id);
			$stmt -> bindValue(5, $comments_status);

			$stmt -> execute();

			return $stmt;

		}

		// Delete post

		public function delete_post($pid) {

			// The query

			$query = 'DELETE FROM ' . $this -> table . ' WHERE pid = ?';

			$stmt = $this -> conn -> prepare($query);
			$stmt -> bindValue(1, $pid);

			$stmt -> execute();

			// Comments deletion

			$query_c = 'DELETE FROM comments WHERE pid = ?';

			$stmt_c = $this -> conn -> prepare($query_c);
			$stmt_c -> bindValue(1, $pid);

			$stmt_c -> execute();

		}

		// Edit post

		public function edit_post($pid, $title, $content, $comments_status) {

			// The query

			$query = 'UPDATE ' . $this -> table . ' SET title = ?, content = ?, comments_status = ? WHERE pid = ?';

			$stmt = $this -> conn -> prepare($query);
			$stmt -> bindValue(1, $title);
			$stmt -> bindValue(2, $content);
			$stmt -> bindValue(3, $comments_status);
			$stmt -> bindValue(4, $pid);

			$stmt -> execute();

			return $stmt;

		}

	}