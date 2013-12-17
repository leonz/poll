<?php

// USE HEREDOCS for each of the three scenarios

/********** FORM IS SUBMITTED */

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

<form name="create" method="post" action="create.php">

Question: 
<input type="text" name="question" id="question" /><br />

Choice 0:
<input type="text" name="choice_list[]" class="choice" value="" /><br />
Choice 1:
<input type="text" name="choice_list[]" class="choice" value="" /><br />
Choice 2:
<input type="text" name="choice_list[]" class="choice" value="" /><br />
Choice 3:
<input type="text" name="choice_list[]" class="choice" value="" /><br />
Choice 4:
<input type="text" name="choice_list[]" class="choice" value="" /><br />
Choice 5:
<input type="text" name="choice_list[]" class="choice" value="" /><br />
Choice 6:
<input type="text" name="choice_list[]" class="choice" value="" /><br />
Choice 7:
<input type="text" name="choice_list[]" class="choice" value="" /><br />
Choice 8:
<input type="text" name="choice_list[]" class="choice" value="" /><br />
Choice 9:
<input type="text" name="choice_list[]" class="choice" value="" /><br />

<input type="checkbox" name="type" value"checkbox" /> Allow people to vote for multiple choices?<br />


<input type="submit" name="submit" value="Make My Poll!" />

</form>

<?php

}

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
