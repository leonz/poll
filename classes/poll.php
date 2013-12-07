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
		// add a row to the polls table
		// save the arrays using serialize()
		// set the poll ID
	}

	/** Loads from the database the Poll with id and returns an array of its values */
	public function load($id) {
		// return an array of poll with id $id
		// remember to unserialize() choices/votes
	}


}

?>
