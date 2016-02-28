<?php
	require_once '../AuleConfig.php';
	require_once '../AuleRequestUnibg.1.3.php';
	require_once '../AuleAjax.php';
	
	$elemento = $_REQUEST["url_elemento"];
	
	$data = $_REQUEST["url_data"];
	
	// create jenti request unibg object
	$request = new AuleRequestUnibg($config);
	
	// get day user wants to visualize
	$result["free_hours"] = $request->get_classroom_free_hours($config[$elemento]["url_params"], $data);
	$result["source"] = $request->url;
	$result["next_update"] = $config["refresh_interval"] - $request->cache_age;
		
	echo ajax_json_response($result);