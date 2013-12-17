<?php

$title = "Create your own poll with Make My Poll!";
require("includes/header.php");

if (isset($_GET['display']) && htmlentities($_GET['display']) == "results") {
	echo '<div id="error">There was an error trying to access that page.</div>';
}

?>

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

<input type="submit" name="submit" value="Create my poll" />

</form>
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
