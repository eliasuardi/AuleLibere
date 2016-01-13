<?php

// Copyright 2006-2015 - NINETY-DEGREES

///////////////////////////////////////////////////////////////////////////
////////// CONFIGURATION ITEMS ARE DEFINED IN PHP SYNTAX!        ////////// 
////////// INTERNAL DEFAULTS ARE USED WHEN ITEMS ARE NOT DEFINED ////////// 
///////////////////////////////////////////////////////////////////////////

// set timezone
date_default_timezone_set('Europe/Rome');

global $config;

// debug flag
$config["debug"] = 0;

$config["application"] = "AULELIBERE UNIBG";
$config["version"] = "1.1";
$config["footer"] = 'Contatto</br>e.suardi5 @ studenti.unibg.it';

// info facolt�
$config["facolta"] = array("GIU", "ING", "LETT", "LING", "SCAE", "SCUS");

$config["GIU"]["title"] = "GIURISPRUDENZA";
$config["GIU"]["file_name"] = "orario_giornaliero.php";
$config["GIU"]["db"] = "EC";
$config["GIU"]["idfacolt"]["a"] = "4";

$config["ING"]["title"] = "INGEGNERIA";
$config["ING"]["file_name"] = "orario_giornaliero.php";
$config["ING"]["db"] = "IN";
$config["ING"]["idfacolt"]["a"] = "1";

$config["LETT"]["title"] = "LETTERE FILOSOFIA COMUNICAZIONE";
$config["LETT"]["file_name"] = "orario_giornaliero.php";
$config["LETT"]["db"] = "UM";
$config["LETT"]["idfacolt"]["a"] = "10";

$config["LING"]["title"] = "LINGUE LETTERATURE CULTURE STRANIERE";
$config["LING"]["file_name"] = "orario_giornaliero3.php";
$config["LING"]["db"] = "LL";
$config["LING"]["idfacolt"]["a"] = "1";
$config["LING"]["idfacolt"]["b"] = "3";
$config["LING"]["idfacolt"]["c"] = "8";

$config["SCAE"]["title"] = "SCIENZE AZIENDALI ECONOMICHE METODI QUANTITATIVI";
$config["SCAE"]["file_name"] = "orario_giornaliero.php";
$config["SCAE"]["db"] = "EC";
$config["SCAE"]["idfacolt"]["a"] = "1";

$config["SCUS"]["title"] = "SCIENZE UMANE E SOCIALI";
$config["SCUS"]["file_name"] = "orario_giornaliero.php";
$config["SCUS"]["db"] = "UM";
$config["SCUS"]["idfacolt"]["a"] = "2";

$config["wait"] = 6;
$config["cache_on"] = true;
//$config["refresh_interval"] = 60 * 60 * 4;
$config["refresh_interval"] = 60 * 60 * 4;
$config["row_count"] = 10;


if (php_uname('n') == "ELIASUARDI-PC")
{
	// local development system
	$config["hostname"] = "localhost";
	$config["user_name"] = "root";
	$config["user_pswd"] = "root";
	$config["user_db"] = "jenti";
	$config["docroot"] = str_replace( "\\", "/", $_SERVER['DOCUMENT_ROOT']) . "/unibg/aule";
}
else
{
    // hostmonster system
    //$config["cache_root"] = "/home1/ninetyde/public_html/jenti/dev/cache";
    //$config["log_file"] = "/home1/ninetyde/public_html/jenti/dev/log.txt";
    $config["hostname"] = "localhost";
    $config["user_name"] = "ninetyde_jenti01";
    $config["user_pswd"] = "Rondin@2015";
    $config["user_db"] = "ninetyde_jenti";
    $config["docroot"] = str_replace( "\\", "/", $_SERVER['DOCUMENT_ROOT']) . "/unibg/aule";
}

$config["cache_root"] = $config["docroot"]."/cache";
$config["log_file"] = $config["docroot"]."/logs/log.txt";

?>