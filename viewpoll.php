<?php
/****************************************************
 View Poll
 Shows a poll specified by a unique ID, can be voted
 on depending on visitor history.
 Version 0.0 - LZ - 12/6/2013
 ***************************************************/

require_once("classes/poll.php");

$pollID = htmlspecialchars($_GET["id"]); 
 
$p = new Poll();
$poll = $p->load($pollID);
 
// { $poll is an array of values extracted from the database
//   or FALSE if pollID could not be found  }


if ($poll == FALSE) {
	$title = "We couldn't find the poll!"
} else {
	$title = $poll["question"];
} 
require_once("includes/header.php");





// Print the choices for the poll
for ($i = 0; i < count($poll["choices"]); i++) {
	if ($poll["choices"][i] != "") {
		echo $poll["choices"][i] . " " . $poll["votes"][i];
	}
}




require_once("includes/footer.php");

?>

