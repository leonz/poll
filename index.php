<?php
// Form is submitted

function quickSanitize($str) {
	return htmlentities(str_replace('=', '', $str));
}

if (isset($_POST['submit'])) {

	$errors = array();
	
	// Make $form into a sanitized version of $_POST
	
	$form['question'] = quickSanitize($_POST['question']);
	$form['choices'] = array_map('quickSanitize', $_POST['choiceList']);  
	
	$form['isRadio'] = 1;
	if (isset($_POST['type'])) $form['isRadio'] = 0;

	// Check that there are no form errors

	if (isset($_COOKIE['created'])) {
		$errors['cookie'] = 'You just created a poll! Please wait a few minutes before making another one.';
	}

        if (empty($form['question'])) {
                $errors['question'] = 'You must provide a question.';
        }
	
	$count = count(array_diff($form['choices'], array('')));		
	if ($count < 2) {
		$errors['count'] = 'You must provide at least two choices.';
	}

	if (!empty($errors)) { // { There are errors }
		$errorMessages = '';

		foreach ($errors as $e) {
			$errorMessages .= '<li>' . $e . '</li>' . "\n";
		}

		$checked = '';
		if ($form['isRadio'] == 0) $checked = 'checked';
		
		// Create a "condensed" array of values where all filled
		// values are shifted to the front of the array $value
	
		$value = array_fill(0, 10, '');
		$previousVals = array_filter($form['choices']);
		reset($previousVals);

		for ($i = 0; $i < sizeof($previousVals); $i++) {
			$value[$i] = current($previousVals);
			next($previousVals);
		}


		// Prepopulate visible textboxes from previous submission values 
		// Always make visible at least three textboxes

		$visibleFields = '';
		$boxesDone = 0;
	
		for ($i = 0; $i < max(3, sizeof($previousVals)); $i++) {
			$visibleFields .= 'Choice ' . $i . ':' . "\n";
			$visibleFields .= '<input type="text" name="choiceList[]" class="choice" value="' . $value[$i] . '"><br>' . "\n";
			$boxesDone++;
		}

		// Create the remainder of the empty textboxes
		// These will be hidden using Javascript
		
		$hiddenFields = '';
		for ($i = $boxesDone; $i < 10; $i++) {
			$hiddenFields .= 'Choice ' . $i . ':' . "\n";
                        $hiddenFields .= '<input type="text" name="choiceList[]" class="choice" value="' . $value[$i] . '"><br>' . "\n";
		}	
		if ($hiddenFields != '') {
			$hiddenFields = '<a href="#">Add more choices</a><br>' . "\n" . $hiddenFields;
		}

		$formArea = <<<CONTENT
<ul>
$errorMessages
</ul>

<form class="form" name="create" method="post" action="index.php">

Question:
<input type="text" name="question" id="question" value="{$form['question']}"><br>

$visibleFields
$hiddenFields

<input type="checkbox" name="type" {$checked}> Allow people to vote for multiple choices?<br>


<input type="submit" name="submit" class="submit" value="Make My Poll!">

CONTENT;

	} else { // { No errors - submit the poll }

		require_once('classes/database.php');
		$db = new Database();
	
		$sForm['question'] = $db->sanitize($form['question']);
		
		/* Form choices will be escaped AFTER serialization in classes/poll
		for ($i = 0; $i < sizeof($form['choices']); $i++) {
			$sForm['choices'][$i] = $db->sanitize($form['choices'][$i]);
		}
		*/

		require_once('classes/poll.php');
		
		$p = new Poll($sForm['question'], $form['choices'], $form['isRadio']);
		$id = $p->save();
		$pollID = Poll::urlID($id);

	        setcookie('created', "$pollID", time() + 60*5);
		header('Location: viewpoll.php?id=' . $pollID . '&display=created');

		}
} else { // { The form is not submitted - default view }

	$formArea = <<<CONTENT
<form class="form" name="create" method="post" action="index.php">

Question:
<input type="text" name="question" id="question"><br>

Choice 0:
<input type="text" name="choiceList[]" class="choice" value=""><br>
Choice 1:
<input type="text" name="choiceList[]" class="choice" value=""><br>
Choice 2:
<input type="text" name="choiceList[]" class="choice" value=""><br>

<a href="#">Add more choices...</a><br>

Choice 3:
<input type="text" name="choiceList[]" class="choice" value=""><br>
Choice 4:
<input type="text" name="choiceList[]" class="choice" value=""><br>
Choice 5:
<input type="text" name="choiceList[]" class="choice" value=""><br>
Choice 6:
<input type="text" name="choiceList[]" class="choice" value=""><br>
Choice 7:
<input type="text" name="choiceList[]" class="choice" value=""><br>
Choice 8:
<input type="text" name="choiceList[]" class="choice" value=""><br>
Choice 9:
<input type="text" name="choiceList[]" class="choice" value=""><br>

<input type="checkbox" name="type"> Allow people to vote for multiple choices?<br>


<input type="submit" name="submit" class="submit" value="Make My Poll!">

</form>

CONTENT;


}

/**** EVERYTHING BELOW IS NOW DEPRECATED AND WILL BE REMOVED Dec 23 2013 ****/


// check that at least two choice fields are filled
// htmlentities() question and each choice
// remove = from question and each choice

// is the form successful?

// mysqlescaperealstrings and submit the poll to the database
// create a made-poll cookie
// extract the new poll's id
// forward to viewpoll.php?id=urlID


// is the form NOT successful?

// show errors that it wasn't successful
// populate form with previous fields
// show choice boxes if they are populated, hide if not
// only fill the top choice boxes? (push all answers up)

/******************8

for each filled answer in array of choices_list, create a visible textbox and ++ variable
hide 10 - variable textboxes and include link

*/

// is the form not even submitted?

// check for a cookie that a poll wasn't recently made
// check for the display=error to create an error banner
// display the poll form with 3 textboxes, 7 hidden 



$title = 'Create your own poll with Make My Poll!';
require('includes/header.php');

if (isset($_GET['display']) && htmlentities($_GET['display']) == 'error') {
	echo '<div id="error">There was an error trying to access that page.</div>';
}

?>

<h1>Make My Poll</h1>

<p>Create your own poll and share it with your friends.  Get started now - no registration needed!</p>

<?php
// Contains the form and error messages (formatting is above)
echo $formArea;

require('includes/footer.php');
?>

