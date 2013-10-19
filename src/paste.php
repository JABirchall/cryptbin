<?php
require_once("include/paste.inc.php");
if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	echo '<FORM action="'.$member->currentPath().'paste.php?action=submit" method="post">
		<P>
		Title: <INPUT style="width: 860px;" type="text" name="title"></br>
		Text: <textarea style="width: 1280px; height: 470px;" type=text" name="paste"></textarea></br>
		<INPUT type="submit"></form>';
}
if (@$action == 'submit') {
	$title = (isset($_POST['title']))?$_POST['title']:'';
	$data = (isset($_POST['paste']))?$_POST['paste']:'E99_ND';
	if($data === 'E99_ND') echo "No data was submited";
	else $submit->submitpaste($title,$data);

} elseif (@$action == 'getpaste'){
	//$iv = (isset($_GET['iv']))?$_GET['iv']:'';
	$id = (isset($_GET['id']))?$_GET['id']:'';
	$key = (isset($_GET['key']))?$_GET['key']:null;
	$key = str_replace(" ", "+", $key);
	//$iv = str_replace(" ", "+", $iv);
	$key = explode(":", $key);
	//echo "Key: ".$key[0]."</br>IV: ".$key[1];
	if (null === @$key){
		$paste = $submit->grabpaste($id,$key[0]);
		if ($paste === "E10") {
			echo "You are not logged in";
		} elseif ($paste === "E1") {
			echo "Database error";
		}

	} else {

		$paste = $submit->grabpaste($id,$key[1],$key[0]);
		if ($paste === "E10") {
			echo "You are not logged in";
		} elseif ($paste === "E1") {

			echo "Database error 2";
		} else {
			echo "Title: ".htmlentities($paste['title'])."</br>Text: <textarea style=\"width: 1280px; height: 470px;\">".htmlentities($paste['paste'])."</textarea>";
		}
	}
}