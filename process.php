<?php
/** Processes the vote casting for a poll */


/********

Goals for this page:

 - Extract the ID from the URL and all of the posted variables (voting results)
 - If the required variables aren't set OR an 'already voted' cookie is set - Redirect to viewpoll
 - Submit a query to the database to ++ the vote values for each voted on choice 
 - Set a cookie that the user has already voted on this poll
 - Redirect to viewpoll.php?id=pollid&display=results

********/

if (!isset($_GET['id'])) {
	header('Location: index.php?display=error');
}

$pollID = htmlentities($_GET['id']);

if (!isset($_POST['choice_list'])) {
	header('Location: viewpoll.php?id=' . $pollID);
}

if (!empty($_POST['choice_list'])) {
	require_once('classes/poll.php');
	Poll::updateVotes($pollID, array_filter($_POST['choice_list'], 'is_numeric'));
	header('Location: viewpoll.php?id=' . $pollID . '&display=results');
}



 

?>
