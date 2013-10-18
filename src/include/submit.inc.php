<?php
/* submit page */
/* Include Class */
include("class/database.class.php");
include("class/submit.class.php");
include("class/member.class.php");
/* Start an instance of the Database Class */
$database = new database("127.0.0.1", "cryptbin", "root", "root");
/* Create an instance of the Member Class */
$submit = new submit_paste();
$member = new member();
