<?php
require_once("include/paste.inc.php");
if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = null;
	$input = "This is an interface to the mcrypt library, which supports a wide variety of block algorithms such as DES, TripleDES, Blowfish (default), 3-WAY, SAFER-SK64, SAFER-SK128, TWOFISH, TEA, RC2 and GOST in CBC, OFB, CFB and ECB cipher modes. Additionally, it supports RC6 and IDEA which are considered non-free. CFB/OFB are 8bit by default. ";// text to encrypt
	//$submit->submitpaste("some titles", $input);
	if ($submit->submitpaste("mCrypt paste",$input)==="E10"){
		echo "You are not logged in";
	}
}
if ($action == 'submit') {
	$title = (isset($_POST['title']))?$_POST['title']:'';
	$data = (isset($_POST['paste']))?$_POST['paste']:'E99_ND';
	if($data === 'E99_ND') echo "No data was submited"; else $submit->submitpaste($title,$data);
	echo $title,$data;
} elseif ($action == 'getpaste'){
	$iv = (isset($_GET['iv']))?$_GET['iv']:'';
	$id = (isset($_GET['id']))?$_GET['id']:'';
	$key = (isset($_GET['key']))?$_GET['key']:null;
	$key = str_replace(" ", "+", $key);
	echo "1</br>";
	if (null != @$key){
		echo "3</br>";
		echo $iv."</br>".$id."</br>".$key;
		if ($submit->grabpaste($id,$iv,$key) === "E10"){
			echo "You are not logged in";
		}
	} else {
		echo "2</br>";
		echo $iv."</br>".$id;
		if ($submit->grabpaste($id,$iv) === "E10"){
			echo "You are not logged in";
		}
	}
}