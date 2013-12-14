<?php
/****************************************************
 View Poll
 Shows a poll specified by a unique ID, can be voted
 on depending on visitor history.
 Version 0.1 - LZ - 12/6/2013
 ***************************************************/

require_once('classes/poll.php');

$pollID = htmlspecialchars($_GET['id']);

$poll = Poll::load($pollID);


// { $poll is an array of values extracted from the database
//   or FALSE if pollID could not be found  }


if ($poll == FALSE) {
        $title = "We couldn't find the poll!";
} else {
        $title = $poll['question'];
}
require_once('includes/header.php');

for ($i = 0; $i < 10; $i++) {
	if ($poll['choices'][$i] === "") break;
	echo $poll['choices'][$i];
}

echo "COMPLETE";


require_once('includes/footer.php');

?>

