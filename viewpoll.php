<?php
/****************************************************
 View Poll
 Shows a poll specified by a unique ID, can be voted
 on depending on visitor history.
 Version 0.1 - LZ - 12/6/2013
 ***************************************************/

require_once('classes/poll.php');

$pollID = htmlspecialchars($_GET['id']);

$p = new Poll(null,null,null);
$poll = $p->load($pollID);

// { $poll is an array of values extracted from the database
//   or FALSE if pollID could not be found  }


if ($poll == FALSE) {
        $title = "We couldn't find the poll!";
} else {
        $title = $poll['question'];
}
require_once('includes/header.php');


// Test the database connection
require_once('classes/database.php');
$db = new Database();
if ($db) echo "Database successfully connected!";


// Print the choices for the poll
for ($i = 0; $i < count($poll['choices']); $i++) {
        if ($poll['choices'][$i] != '') {
                echo $poll['choices'][$i] . " " . $poll['votes'][$i];
        }
}


echo "This is proof that it's working! " .  $_GET['id'];

require_once('includes/footer.php');

?>

