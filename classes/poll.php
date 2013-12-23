<?php
/***************************************************
 Poll Class
 Defines the class skeleton for polls.
 Version 0.1 - LZ - 12/14/2013
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
	
	private $radio;
	/** Create a poll, sanitize and initialize all of the fields */
	public function __construct($q, $c, $r) {
		$this->question = $q;
		$this->choices = $c;
		$this->radio = $r;
		$this->votes = array_fill(0, 10, 0);
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

	/** Convert a poll's sequential ID into a 4+ digit URL identifier */
	public static function urlID($id) {
		return base_convert($id + 239000, 10, 36);
	}

        /** Convert a URL ID into its sequential ID */
        public static function sID($urlID) {
                return base_convert($urlID, 36, 10) - 239000;
        }

	// Database Methods

	/** Saves this instance of Poll to the database, and return's the sequential id
	 *  Precondition: All variables are already sanitized.
	 */
	public function save() {
		
		$sChoices = serialize($this->choices);
		$sVotes = serialize($this->votes);
		
		$db = new Database();
		
		$ssChoices = $db->sanitize($sChoices);
		
		$query = "INSERT INTO Polls (Question, Choices, Votes, isRadio)
			  VALUES ('$this->question', '$ssChoices', '$sVotes', '$this->radio')";
		
	       	$isSuccess = $db->query($query);	
		if ($isSuccess === TRUE) {
			return mysqli_insert_id($db->getDB());
		} else {
			return -1;
		}
	}

	/** Loads from the database the Poll with id and returns an array
	 *  of its values.  Precondition: All variables are already sanitized.
	 */
	public static function load($urlID) {
		if ($urlID === "" || !ctype_alnum($urlID)) return;
	
		$query = 'SELECT * FROM Polls WHERE id=\'' . self::sID($urlID) . '\'';

		$db = new Database();
		$pollInfo = array();	
		if ($result = $db->query($query)) {
			while ($row = mysqli_fetch_row($result)) {
				if ($row[4] === FALSE) return FALSE; 
				$pollInfo['question'] = $row[1];
				$pollInfo['choices'] = unserialize($row[2]);
				$pollInfo['votes'] = unserialize($row[3]);
				$pollInfo['isRadio'] = $row[5];
			}
			mysqli_free_result($result);
		}
		return $pollInfo;
	}

        /** Increases by 1 the vote values in vote[$i] where $i is an array of indices  
         *  Extracts the vote array, unserialize, update value, serialize, and update
         */
        public static function updateVotes($urlID, $list) {
		
		$pollInfo = self::load($urlID);

                foreach($list as $i) {
			$pollInfo['votes'][$i]++;
		}
		
		$sVotes = serialize($pollInfo['votes']);
		$id = self::sID($urlID);
                $query = "UPDATE Polls SET Votes='$sVotes' WHERE id='$id'";  

                $db = new Database();
		return $db->query($query);
	}

}

?>
