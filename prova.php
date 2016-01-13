<?php
    $lines = file('ajax/access_log.txt', FILE_IGNORE_NEW_LINES);
    
    //echo "<PRE>".print_r($lines, true)."</PRE>";
    
    foreach($lines as $line)
    {
        if(preg_match('/[0-9][0-9]:[0-9][0-9]\s+/', $line))
        {
            $new_lines[] = preg_replace('/[0-9][0-9]:[0-9][0-9]\s+/', ' ', $line);
        }
    }
    
    file_put_contents('ajax/access_log.txt', implode("\n",array_unique($new_lines)));