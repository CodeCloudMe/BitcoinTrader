<?php

	
	//include the db functions - dbMassData and dbData
	require_once($_SERVER['DOCUMENT_ROOT'].'cloud/models/db/db.php');

	
	//include (require) db shortcus for fast record insertion.
	require_once($_SERVER['DOCUMENT_ROOT']."cloud/models/db/dbShortcuts.php");


	function genRand($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
	}	
	



?>