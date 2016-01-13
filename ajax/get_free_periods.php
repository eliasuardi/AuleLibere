<?php
	require_once '../AuleConfig.php';
	require_once '../AuleRequestUnibg.1.2.php';
	require_once '../AuleAjax.php';
	
	// set timezone
	date_default_timezone_set('Europe/Rome');
	
	$facolta = $_REQUEST["facolta"];
	
	$data = $_REQUEST['data'];
	
	// create jenti request unibg object
	$request = new AuleRequestUnibg($config);
	
	// get day user wants to visualize
	$result["free_hours"] = $request->get_classroom_free_hours($config[$facolta]["file_name"], $config[$facolta]["db"], $config[$facolta]["idfacolt"], $data);
	$result["source"] = $request->url;
	$result["next_update"] = $config["refresh_interval"] - $request->cache_age;
		
	echo ajax_json_response($result);