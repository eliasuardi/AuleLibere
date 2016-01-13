<?php
    require_once '../AuleConfig.php';
    require_once '../AuleRequestUnibg.1.3.php';
    require_once '../AuleAjax.php';
    
    $facolta = $_REQUEST["facolta"];
    $data = $_REQUEST['data'];
	
    // create jenti request unibg object
    $request = new AuleRequestUnibg($config);
        
    $result = $request->get_lessons($config[$facolta]["file_name"], $config[$facolta]["db"], $config[$facolta]["idfacolt"], $data);
    
    echo ajax_json_response($result);