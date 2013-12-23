<?php
/****************************************************
 Database Class
 Manages database connections and queries.
 Version 0.0 - LZ - 12/6/2013
 Based on: http://stackoverflow.com/questions/9651038/oop-database-connect-disconnect-class
 ***************************************************/

class Database {

	private $host, $username, $password, $database;
	private $db;
	
	/** Opens a connection the database */
	public function __construct() {
		$this->host	= "localhost";
		$this->username	= "leondash";
		$this->password	= "password";
		$this->database	= "poll";

		$this->db = mysqli_connect($this->host, $this->username, $this->password, $this->database)
		or die('Error: Could not connect to the database');
		
		return true;
	}
	
	/** Runs the specified query on the database
	 *  Precondition: The query is already sanitized!
	 */
	public function query($query) {
		$result = mysqli_query($this->db, $query);
		if (!$result) die('Invalid query: ' . mysqli_error($this->db));
		return $result;
	}
	
	public function getDB() {
		return $this->db;
	}

	/**
	 * Return a string that is escaped for insertion into a database.
	 * The '=' is removed as a measure against SQL injection - we will look into better methods.
	 */
	public function sanitize($str) {
		return mysqli_real_escape_string($this->db, str_replace('=', '', $str));
	}
	
}

?>
