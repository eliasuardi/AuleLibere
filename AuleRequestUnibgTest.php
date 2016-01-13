<?php

//phpinfo();
//exit;

require_once "AuleConfig.php";
require_once "AuleRequestUnibg.1.3.php";

date_default_timezone_set('Europe/Rome');

$idfacolt['a'] = '1';

$request = new AuleRequestUnibg($config);
$result = $request->get_classroom_free_hours('orario_giornaliero.php', 'IN', $idfacolt, 'oggi');


if ($request->error)
{
    echo($request->error);
}
echo "<PRE>".print_r($result, true)."</PRE>";
$request->debug_echo_dom(null, 0, null, null);
