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

// info sedi
$config["sede"] = array("CAN", "MOR", "DAL", "ROS", "SAL", "PIG", "SAG");

$config["esclusione"] = array("aula 15 can", "aula 16 can", "LAB 19 - can", "LAB. 7 - can", "LAB. 9 - can", "Sala Galeotti", "Lab. P. Rosate", "Sala Consiglio P. Rosate", "Sotto Tetto P. Rosate", "Lab. 5 Salv.", "AULA MAGNA  S. Agostino");

$config["CAN"]["title"] = "Via dei Caniana";
$config["CAN"]["url_params"]["db"] = "EC";
$config["CAN"]["url_params"]["codsede"] = "CN";

$config["MOR"]["title"] = "Via Moroni";
$config["MOR"]["url_params"]["db"] = "EC";
$config["MOR"]["url_params"]["codsede"] = "MR";

$config["DAL"]["title"] = "Dalmine";
$config["DAL"]["url_params"]["db"] = "IN";
$config["DAL"]["url_params"]["codsede"] = "DA";

$config["ROS"]["title"] = "Piazza Rosate";
$config["ROS"]["url_params"]["db"] = "LL";
$config["ROS"]["url_params"]["codsede"] = "PR";

$config["SAL"]["title"] = "Via Salvecchio";
$config["SAL"]["url_params"]["db"] = "LL";
$config["SAL"]["url_params"]["codsede"] = "SV";

$config["PIG"]["title"] = "Via Pignolo";
$config["PIG"]["url_params"]["db"] = "UM";
$config["PIG"]["url_params"]["codsede"] = "P";

$config["SAG"]["title"] = "Piazzale S.Agostino";
$config["SAG"]["url_params"]["db"] = "UM";
$config["SAG"]["url_params"]["codsede"] = "SA";

$config["facolta"] = array("GIU", "ING", "LETT", "LING", "SCAE", "SCUS");

$config["GIU"]["title"] = "GIURISPRUDENZA";
$config["GIU"]["url_params"]["file_name"] = "orario_giornaliero.php";
$config["GIU"]["url_params"]["db"] = "EC";
$config["GIU"]["url_params"]["idfacolt"]["a"] = "4";

$config["ING"]["title"] = "INGEGNERIA";
$config["ING"]["url_params"]["file_name"] = "orario_giornaliero.php";
$config["ING"]["url_params"]["db"] = "IN";
$config["ING"]["url_params"]["idfacolt"]["a"] = "1";

$config["LETT"]["title"] = "LETTERE FILOSOFIA COMUNICAZIONE";
$config["LETT"]["url_params"]["file_name"] = "orario_giornaliero.php";
$config["LETT"]["url_params"]["db"] = "UM";
$config["LETT"]["url_params"]["idfacolt"]["a"] = "10";

$config["LING"]["title"] = "LINGUE LETTERATURE CULTURE STRANIERE";
$config["LING"]["url_params"]["file_name"] = "orario_giornaliero3.php";
$config["LING"]["url_params"]["db"] = "LL";
$config["LING"]["url_params"]["idfacolt"]["a"] = "1";
$config["LING"]["url_params"]["idfacolt"]["b"] = "3";
$config["LING"]["url_params"]["idfacolt"]["c"] = "8";

$config["SCAE"]["title"] = "SCIENZE AZIENDALI ECONOMICHE METODI QUANTITATIVI";
$config["SCAE"]["url_params"]["file_name"] = "orario_giornaliero.php";
$config["SCAE"]["url_params"]["db"] = "EC";
$config["SCAE"]["url_params"]["idfacolt"]["a"] = "1";

$config["SCUS"]["title"] = "SCIENZE UMANE E SOCIALI";
$config["SCUS"]["url_params"]["file_name"] = "orario_giornaliero.php";
$config["SCUS"]["url_params"]["db"] = "UM";
$config["SCUS"]["url_params"]["idfacolt"]["a"] = "2";

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