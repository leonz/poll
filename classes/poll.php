<?php
/***************************************************
 Poll Class
 Defines the class skeleton for polls.
 Version 0.0 - LZ - 12/6/2013
 ***************************************************/

class Poll {

	// Unique identifier for the poll, integer
	private $id;

	// Question for the poll, string
	private $question;

	// Each one of the poll choices, array of strings
	private $choices = array(10);

	// Corresponding vote values for each poll choice, array of integers
	private $votes = array(10);

	/** Create a poll and initialize all of the fields */
	public function __construct($q, $c, $v) {
		$this->question = $q;
		$this->choices = c;
		$this->votes = v;
	}
	
	/** Return this poll's question */
	public function getQuestion() {
		return $this->question;
	}

	/** Return this poll's choices */
	public function getChoices() {
		return $this->choices;
	}

	/** Return this poll's vote values */
	public function getVotes() {
		return $this->votes;
	}

	/** Convert the poll's unique ID into a 4+ digit URL identifier */
	public function urlID() {
		$largeID = $this->id + 239000;
		return base_convert($largeID, 10, 62);
	}

	// Database Methods

	/** Saves this instance of Poll to the database, and updates the id */
	public function save() {

		// 1. Open connection to database
		// 2. serialize choices and votes
		// 3. create a new row using all properties
		// 4. retrieve id of new row
		// 5. set this->id to new id
		// 6. return true 
	}

	/** Loads from the database the Poll with id and returns an array of its values */
	public function load($id) {
		if ($id = "" || !is_numeric($id)) return 0;

		// 1. Open connection to database
		// 2. MYSQL escape $id
		// 3. result = query (get row with $id)		
		// 4. get each column as a single array
		// 5. votes =  unserialize(votes)
		// 6. choices = unserialize(choices)
		// 7. return array
	}


}

?>
