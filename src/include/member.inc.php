<?php
/* Member Page */
/* Include Class */
include("class/database.class.php");
include("class/member.class.php");
include("include/hash.inc.php");
/* Start an instance of the Database Class */
$database = new database("127.0.0.1", "cryptbin", "root", "root");
/* Create an instance of the Member Class */
$member = new member();
?>