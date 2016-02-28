<?php
	require_once '../AuleConfig.php';
	require_once "../AuleAjax.php";

	echo ajax_json_response($config);
	