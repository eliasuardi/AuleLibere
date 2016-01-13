<?php
    require_once '../AuleConfig.php';
    
    $access = date("d/m/Y").' '.$_SERVER["REMOTE_ADDR"]."\n";
    
    file_put_contents('access_log.txt', $access, FILE_APPEND);
    
    $lines = file('ajax/access_log.txt', FILE_IGNORE_NEW_LINES);    
    file_put_contents('ajax/access_log.txt', implode("\n",array_unique($lines)));