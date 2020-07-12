<?php

	class Comment {

		// Database Connection

		private $conn;
		private $table = 'comments';

		// Constructor

		public function __construct($db) {
			$this -> conn = $db;
		}

		// Read comments
		public function get_comments($pid) {

			// Checks if comments are enabled

			$query = 'SELECT comments_status FROM posts WHERE pid = ?';

			$stmt = $this -> conn -> prepare($query);

			$stmt -> bindValue(1, $pid);

			$stmt -> execute();

			$stmt -> fetch();

			if ($stmt) {

				// Query

				$query = 'SELECT * FROM	' . $this -> table . ' AS c WHERE c.pid = ?';

				// Prepare the statement

				$cstmt = $this -> conn -> prepare($query);

				// Bind value

				$cstmt -> bindValue(1, $pid);

				// Execute statement

				$cstmt -> execute();

				return $cstmt;

			}

		}

		// Add comment
		public function new_comment($pid, $uid, $author, $comment_content) {

			// Query
			$query = 'INSERT INTO ' . $this -> table . ' (pid, uid, author, comment_content) VALUES (?, ?, ?, ?)';

			$stmt = $this -> conn -> prepare($query);
			$stmt -> bindValue(1, $pid);
			$stmt -> bindValue(2, $uid);
			$stmt -> bindValue(3, $author);
			$stmt -> bindValue(4, $comment_content);

			$stmt -> execute();

			return $stmt;

		}

		public function remove_comment($comment_id) {

			// Query
			$query = 'DELETE FROM ' . $this -> table . ' WHERE comment_id = ?';

			$stmt = $this -> conn -> prepare($query);
			$stmt -> bindValue(1, $comment_id);

			$stmt -> execute();

			return $stmt;

		}

		public function edit_comment($status, $comment_content, $comid) {

			// Query
			$query = 'UPDATE ' . $this -> table . ' SET status = ?, comment_content = ? WHERE comment_id = ?';

			$stmt = $this -> conn -> prepare($query);
			$stmt -> bindValue(1, $status);
			$stmt -> bindValue(2, $comment_content);
			$stmt -> bindValue(3, $comid);

			$stmt -> execute();

			return $stmt;

		}

	}