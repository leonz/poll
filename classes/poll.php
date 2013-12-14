<?php
/***************************************************
 Poll Class
 Defines the class skeleton for polls.
 Version 0.0 - LZ - 12/6/2013
 ***************************************************/

require_once('database.php');

class Poll {

	// Unique identifier for the poll, integer
	private $id;

	// Question for the poll, string
	private $question;

	// Each one of the poll choices, array of strings
	private $choices = array(10);

	// Corresponding vote values for each poll choice, array of integers
	private $votes = array(10);

	/** Create a poll, sanitize and initialize all of the fields */
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

        /** Convert the poll's URL ID into its unique sequential ID */
        public function id() {
                $decreasedID = $this->id - 239000;
                return base_convert($decreasedID, 62, 10);
        }

	// Database Methods

	/** Saves this instance of Poll to the database, and updates the id
	 *  Precondition: All variables are already sanitized.
	 */
	public function save() {

		$sChoices = serialize($this->choices);
		$sVotes = serialize($this->votes);
		
		$query = "INSERT INTO Polls (Question, Choices, Votes)
VALUES ($this->question, $sChoices, $sVotes)";

		$db = new Database();
	        $isSuccess = $db->query($query);	
		$this->id = mysqli_insert_id();
		
		return $isSuccess;
	}

	/** Loads from the database the Poll with id and returns an array
	 *  of its values.  Precondition: All variables are already sanitized.
	 */
	public function load($urlID) {
		if ($urlID = "" || !is_numeric($urlID)) return 0;
		
		$id = id($urlID); // reconvert
		
		$query = "SELECT * FROM Polls WHERE id='$id'";

		$db = new Database();
		if ($result = $db->query($query)) {
			while ($row = mysqli_fetch_row($result)) {
				$pollInfo['question'] = $row[1];
				$pollInfo['choices'] = unserialize($row[2]);
				$pollInfo['votes'] = unserialize($row[3]); 
			}
			mysqli_free_result($result);
		}

		return $pollInfo;
	}
}

?>
