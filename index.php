<?php


// Form is submitted

if (isset($_POST['submit'])) {

	$errors = array();
	
	// Make $form into a sanitized version of $_POST
	
	$form['question'] = htmlentities($_POST['question']);
	$form['choices'] = array_map('htmlentities', $_POST['choiceList']);  

	// Check that there are no form errors

	if (isset($_COOKIE["a"])) {
//		$errors['cookie'] = 'You just created a poll! Please wait a few minutes before making another one.';
		echo "cookie is set";
	}

        if (empty($form['question'])) {
                $errors['question'] = 'You must provide a question.';
        }
	
	$count = count(array_diff($form['choices'], array('')));		
	if ($count < 2) {
		$errors['count'] = 'You must provide at least two choices.';
	}

	if (!empty($errors)) { // { There are errors }
		$errormessages = "";

		foreach ($errors as $e) {
			$errorMessages .= '<li>' . $e . '</li>' . "\n";
		}

		$formArea = <<<CONTENT
<ul>
$errorMessages
</ul>
CONTENT;

	} else { // { No errors - submit the poll }

		// Sanitize for MySQL insertion
		// We remove '=' to reduce change of injection, will find a better method in the future
		
		require_once('classes/database.php');
		$db = new Database();
	
		$sForm['question'] = $db->sanitize($form['question']);
		
		/* Form choices will be escaped AFTER serialization in classes/poll
		for ($i = 0; $i < sizeof($form['choices']); $i++) {
			$sForm['choices'][$i] = $db->sanitize($form['choices'][$i]);
		}
		*/

		$isRadio = 1;
		if (isset($_POST['type'])) {
			$isRadio = 0;
		}

		require_once('classes/poll.php');
		
		$p = new Poll($sForm['question'], $form['choices'], $isRadio);
		$id = $p->save();
		$pollID = Poll::urlID($id);

	        setcookie('a', "$pollID", time() + 60*5);
		header('Location: viewpoll.php?id=' . $pollID . '&display=created');

		}
}
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

if (isset($_GET['display']) && htmlentities($_GET['display']) == 'results') {
	echo '<div id="error">There was an error trying to access that page.</div>';
}


echo '<h1>Make My Poll</h1>';

if (isset($_COOKIE['made-poll'])) {
	echo '<p>We\'ve detected that you just made a poll.  Please wait a little bit before you make another one.</p>';

} else {

?>

<p>Create your own poll and share it with your friends.  Get started now - no registration needed!</p>

<form name="create" method="post" action="index.php">

Question: 
<input type="text" name="question" id="question"><br>

Choice 0:
<input type="text" name="choiceList[]" class="choice" value=""><br>
Choice 1:
<input type="text" name="choiceList[]" class="choice" value=""><br>
Choice 2:
<input type="text" name="choiceList[]" class="choice" value=""><br>
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

<input type="checkbox" name="type" value"checkbox"> Allow people to vote for multiple choices?<br>


<input type="submit" name="submit" value="Make My Poll!">

</form>

<?php

}

echo $formArea;

?>
<?php
/*

1.  Select box - Radio buttons or checkbox?

2. 3 Text boxes (choices)
 - If text box is empty = choice is removed
 - If text box is not empty = add as a choice to poll

3. Link "Add more choices"
 - When clicking this link, add another text box with another ID
 - Max out at 10 (remove link when 10 text boxes appear)

4. Submit button - create this poll

*/

?>
