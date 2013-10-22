<?php
require_once("include/paste.inc.php");
$form =  '<FORM action="'.$member->currentPath().'paste.php?action=submit" method="post"><P>
		Title: <INPUT style="width: 860px;" type="text" name="title"></br>
		Text: <textarea style="width: 1280px; height: 470px;" type=text" name="paste"></textarea></br>
		<INPUT type="submit"></form>';
if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	echo $form;
}
if (@$action == 'submit') {
	$title = (isset($_POST['title']))?$_POST['title']:'';
	$data = (isset($_POST['paste']))?$_POST['paste']:'E99_ND';
	if($data === 'E99_ND') {
		echo "No data to submit.";
		echo $form;
	}
	else $submit->submitpaste($title,$data);
	//echo "We are submiting</br>";

} elseif (@$action == 'getpaste'){
	$id = (isset($_GET['id']))?$_GET['id']:null;
	if($id === null) {
		echo $form;
	} else {
		if (isset($_GET['key'])) {
			$key = str_replace(" ", "+", $_GET['key']);
			$key = explode(":", $key);
		} else {
			$key = null;
		}
	
		//echo "Key: ".$key[0]."</br>IV: ".$key[1];
		if (null === $key){
			$paste = $submit->grabpaste($id);
			if ($paste === "E10")
				echo "You are not logged in";
			elseif ($paste === "E1")
				echo "Database error";
			elseif ($paste['err'] === "E3")
				echo "You did no supply a key, Decryption was not attempted.</br>Title: ".$paste['title']."</br>Paste:</br><textarea style=\"width: 1280px; height: 470px;\">".$paste['paste']."</textarea>";
	
		} else {
	
			$paste = $submit->grabpaste($id,$key[1],$key[0]);
			if ($paste === "E10")
				echo "You are not logged in";
			elseif ($paste === "E1") 
				echo "Database error 2";
			else
				echo "Title: ".htmlentities($paste['title'])."</br>Paste: </br><textarea style=\"width: 1280px; height: 470px;\">".htmlentities($paste['paste'])."</textarea>";
		}
	}
}