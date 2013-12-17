<?php
/****************************************************
 View Poll
 Shows a poll specified by a unique ID, can be voted
 on depending on visitor history.
 Version 0.2 - LZ - 12/16/2013
 ***************************************************/

require_once('classes/poll.php');

if (!isset($_GET['id'])) {
	header('Location: index.php?display=error');
	exit;
}


// if a cookie is set that the user has already voted 
// && display is not set to results
// redirect them to display=results

$pollID = htmlentities($_GET['id']);
$poll = Poll::load($pollID);

// { $poll is an array of values extracted from the database
//   or FALSE if pollID could not be found  }

if ($poll == FALSE) {
	header('Location: index.php?display=error');
	exit;
} else {
        $title = $poll['question'];
}

if (isset($_COOKIE["$pollID"]) && htmlentities($_GET['display']) != 'results') {
	header('Location: viewpoll.php?id=' . $pollID . '&display=results');
	exit;
}
	
require_once('includes/header.php');

echo '<h1>' . $poll['question'] . '</h1>' . "\n";

if (isset($_GET['display']) && htmlentities($_GET['display']) == 'results') {

	// Show the voting results of the poll

	$totalVotes = array_sum($poll['votes']);
	for ($i = 0; $i < count($poll['choices']); $i++) {
		if ($poll['choices'][$i] == "") break;
	
		$votePercentage = $poll['votes'][$i] / $totalVotes * 100;		

		echo '<div class="choice" id="choice' . $i . '">' . "\n";
		echo '<div class="vote-backdrop" style="width: ' . $votePercentage . '%">' . "\n";
		echo $poll['choices'][$i] . ' - ' . $poll['votes'][$i] . ' Votes' . "\n";
		echo '</div>' . "\n";
		echo '</div>' . "\n";
	}

} else { // Show a form to allow the visitor to vote

	echo '<form name="vote" method="post" action="process.php?id=' . $pollID . '">' . "\n";
        
        for ($i = 0; $i < count($poll['choices']); $i++) {
		if ($poll['choices'][$i] == "") break;
			
		$type = 'radio';
		if ($poll['isRadio'] == 0) {
			$type = 'checkbox';
		}

		echo '<div class="choice" id="choice' . $i . '">' . "\n";
		echo '<input type="' . $type . '" name="choice_list[]" value="' . $i . '"> ';
		echo $poll['choices'][$i];
		echo '</div>' . "\n";

	}

	echo '<input type="submit" value="Cast My Vote" />' . "\n"; 
	echo '</form>' . "\n";
	
	// If visitors are allowed to view the results without voting:
	echo '<a href="viewpoll.php?id=' . $pollID . '&display=results">View Poll Results</a>';
		
}

require_once('includes/footer.php');

?>

