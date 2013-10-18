<?php
require_once("include/submit.inc.php");

$input = "This is an interface to the mcrypt library, which supports a wide variety of block algorithms such as DES, TripleDES, Blowfish (default), 3-WAY, SAFER-SK64, SAFER-SK128, TWOFISH, TEA, RC2 and GOST in CBC, OFB, CFB and ECB cipher modes. Additionally, it supports RC6 and IDEA which are considered non-free. CFB/OFB are 8bit by default. ";// text to encrypt

//$submit->submitpaste("some titles", $input);


if ($submit->grabpaste(5,"Ay/Mii3R/zMYgcENEpGgazNcZHKwpw==","pe9gbDW+r5wiE1MMBk+DqjjS3PtLCg==") === "E10"){
	echo "You are not logged in";
}