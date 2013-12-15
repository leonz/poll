<?php
/****************************************************
 View Poll
 Shows a poll specified by a unique ID, can be voted
 on depending on visitor history.
 Version 0.1 - LZ - 12/6/2013
 ***************************************************/

require_once('classes/poll.php');

if (!isset($_GET['id'])) {
	header('Location: /poll/index.php');
}
	

$pollID = htmlentities($_GET['id']);
$poll = Poll::load($pollID);

// { $poll is an array of values extracted from the database
//   or FALSE if pollID could not be found  }

if ($poll == FALSE) {
        $title = "We couldn't find the poll!";
} else {
        $title = $poll['question'];
}
require_once('includes/header.php');

?>

<h1><?php echo $poll['question']; ?></h1>

<?php

if (isset($_GET['display']) && htmlentities($_GET['display']) === 'results') {

	for ($i = 0; $i < count($poll['choices']); $i++) {
		if ($poll['choices'][$i] == "") break;
		echo $poll['choices'][$i] . ' - ' . $poll['votes'][$i] . ' Votes<br />';
	}
}

echo "COMPLETE";


require_once('includes/footer.php');

?>

