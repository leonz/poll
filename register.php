<?php

require_once('classes/poll.php');
$questions = { "Choice 1", "Choice 2", "Choices 3" };
$votes = { 1 , 2, 3 };
$p = new $Poll("This is a sample question", $questions, $votes);

$p->save();

}
