<?php
/** Processes the vote casting for a poll */

if (!isset($_GET['id'])) {
	header('Location: index.php?display=error');
	exit;
}

$pollID = htmlentities($_GET['id']);

if (!isset($_POST['choice_list'])) {
	header('Location: viewpoll.php?id=' . $pollID);
	exit;
}

if (!empty($_POST['choice_list'])) {
	require_once('classes/poll.php');
	Poll::updateVotes($pollID, array_filter($_POST['choice_list'], 'is_numeric'));
	
	// Set a 'voted' cookie for one year so that the visitor cannot vote again
	setcookie("$pollID", "voted", time() + 60*60*24*30*12);
	header('Location: viewpoll.php?id=' . $pollID . '&display=results');
}

?>
