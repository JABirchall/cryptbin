<?php

$config['db'] = array(
	'host'	=>		'127.0.0.1',  	 //Your mysql hostname
	'user'	=>		'root',       	//Your mysql user
	'db'	=>		'database',   	 //Your mysql Database
	'pass'	=>		''            	//Your mysql Password
);
$db = new PDO('mysql:host='.$config['db']['host'].';dbname='.$config['db']['db'],$config['db']['user'],$config['db']['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);