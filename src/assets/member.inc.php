<?php
/* Member Page */
/* Include Class */
include("database.class.php");
include("member.class.php");
/* Start an instance of the Database Class */
$database = new database("127.0.0.1", "cryptbin", "root", "root");
/* Create an instance of the Member Class */
$member = new member();
?>