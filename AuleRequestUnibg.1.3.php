<?php

// Copyright 2006-2015 - NINETY-DEGREES

require_once "AuleRequest.php";

///////////////////////////////////////////////////////////////////
// HTTP GET requests to UNIBG
///////////////////////////////////////////////////////////////////
class   AuleRequestUnibg
extends AuleRequest
{
    
    function __construct( $args=null)
    { 
        parent::__construct( $args);

        $this->service_endpoint = "http://www03.unibg.it/orari/";
        $this->service_name = "Orario Unibg";
    }



    //////// get word request
    function get_classroom_free_hours( $url_param, $date)
    {
        if(!array_key_exists("idfacolt", $url_param))
            $url = $this->service_endpoint . "orario_giornaliero.php?";
        else
            $url = $this->service_endpoint;
        
        foreach($url_param as $key => $val)
        {
            if($key == "file_name")
                $url .= $val . "?";
            else if($key == "idfacolt")
            {
                foreach($val as $fkey => $fval)
                    $url .= $fkey . "=" . $fval . "&";
            }
            else 
                $url .= $key . "=" . $val . "&";
        }
        
        $url .= "data=" . urlencode( $date);
        $this->url_data = $url;
        
        if ($this->get_web_page( $url))
        { 
            if (!$this->unibg_error())
            {
            	$lesson_array = $this->get_lesson_data( $date);
            	if(isset($lesson_array["LESSON_ARRAY"]))
            	{
            		$classroom_array = $this->parse_lesson_data($lesson_array["LESSON_ARRAY"]);
            		return( $this->free_periods($classroom_array));
                }
            }
        }

        return(array());
    }
    
    
    private function free_periods( $classroom_array)
    {
    	$free_periods = array();
    	
    	foreach($classroom_array as $key_class => $value_class)
    	{
    		if(strpos(strtolower($key_class), 'utenza'))
    		{
    			$free_periods[$key_class][] = str_replace('-', ' - ', $value_class);
    			continue;
    		}
    			
    		reset($value_class);
    		$curr_value_hour = current($value_class);
    		$last_key_hour = key($value_class);
    		unset($value_class[$last_key_hour]);
    			    			
    		$string = '';
    		if($curr_value_hour)
    			$string = $last_key_hour . ' - ' . $last_key_hour;
    			
    		foreach($value_class as $key_hour => $value_hour)
    		{
    	
    			if($value_hour && strlen($string) > 0)
    			{
    				substr_replace($string, $key_hour, 8);
    				$last_key_hour = $key_hour;
    			}
    			else if(!$value_hour && strlen($string) > 0)
    			{
    				//echo $curr_key_hour.' '.$key_hour.' '.$last_key_hour;
    				$string = substr_replace($string, $key_hour, 8);
    				//str_replace($last_key_hour, $key_hour, $string);
    				$free_periods[$key_class][] = $string;
    				$string = '';
    					
    				//exit;
    			}
    			else if($value_hour && strlen($string) == 0)
    			{
    				$string = $key_hour . ' - ' . $key_hour;
    			}
    	
    			$curr_value_hour = $value_hour;
    			$curr_key_hour = $key_hour;
    		}
    		if(strlen($string) > 0)
    		{
    			$string = substr_replace($string, '20:00', 8);
    			$free_periods[$key_class][] = $string;
    		}
       	}
       	
       	$this->free_periods = $free_periods;
       	
       	return $free_periods;
    }
    
    /////////////////////////////////////////////////////
    function free_classrooms_per_hour()
    {
    	$hour = array("08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00");
    	
    	foreach($hour as $val)
    	{
	    	foreach($this->free_periods as $class_key => $periods)
	    	{
	    		foreach($periods as $period)
	    		{
	    			$time_period = explode('-', $period);
	    			
	    			//if(strcmp($time_period[0], $val) == 0 && strcmp($time_period[1], next($val)) == 0)
	    				
	    		}
	    	}
    	}
    }
    
    function get_lessons( $file_name, $db, $idfacolt, $date)
    {
        $url = $this->service_endpoint . $file_name . "?db=" . $db;
        foreach($idfacolt as $key => $val)
        {
        	$url = $url . "&idfacolt" . $key . "=" . $val;
        }
        $url = $url . "&data=" . urlencode( $date);

        $this->url_data = $url;
        
        if ($this->get_web_page( $url))
        { 
            if (!$this->unibg_error())
            {
            	$lesson_array = $this->get_lesson_data( $date);
                return $lesson_array["LESSON_ARRAY"];
            }
        }
        
        return array();
    }

    //////// parse UNIBG results and return relevant data
    private function get_lesson_data( $date)
    {
        $lesson_array = array();

        $time_table = $this->get_lesson_times_from_tr_td(
            $this->xpath->query("/html/body/table/tr/td"));
        if (count($time_table) > 0)
        {
            $lesson_array["DATE"] = $date;
            $lesson_array["LESSON_ARRAY"] = $time_table;
        }

        if (count($lesson_array) == 0)
        { 
            $this->error = "JentiRequestUnibg: Did not find date at url " . $this->url;
        }

        return($lesson_array);
    }
    
    ///////// returns age of cache
    public function get_cache_age()
    {	
    	return( $this->cache_age($this->cache_path));
    }

  
  
    //////// parse html span that contains classroom
    // e.g. /html/body/table/tr/td
    private function get_lesson_times_from_tr_td( $span)
    {
        $lessons_array = array();

        if ($span->length > 0)
        {        
        	for($i=0; $i<$span->length; $i++)
        	{
        		
        		$children = $span->item($i)->childNodes;
        		if(!in_array(trim($children->item(0)->textContent), $this->unwanted) && $children->length == 4)
        		{
                    $lesson_description = $span->item($i-3);
        			$lessons_array["classroom"][] = strtolower(preg_replace('/\s\s+/', ' ', trim($this->generate_classroom_key($children->item(0)->textContent))));
                    $lessons_array["lesson_period"][] = strtolower(preg_replace('/\s\s+/', ' ', trim($children->item(2)->textContent)));
                    $lessons_array["lesson_description"][] = trim($lesson_description->textContent);
                }
        		else if($children->length == 1 && strpos(strtolower($children->item(0)->textContent), 'utenza'))
        		{
        			$classroom = $span->item($i+3)->childNodes;
        			if(strpos($this->generate_classroom_key($classroom->item(0)->textContent), 'infor'))
                        $lessons_array["classroom"][] = strtolower(preg_replace('/\s\s+/', ' ', trim(preg_replace('/inform.|infor./', '( '.trim($children->item(0)->textContent).')', $this->generate_classroom_key($classroom->item(0)->textContent)))));
        			else 
        			    $lessons_array["classroom"][] = trim($this->generate_classroom_key($classroom->item(0)->textContent)) . ' ( ' . trim($span->item($i)->textContent) . ' )';
                    $lessons_array["lesson_period"][] = strtolower(preg_replace('/\s\s+/', ' ', trim($classroom->item(2)->textContent)));
                    $lessons_array["lesson_description"][] = trim($span->item($i)->textContent);
                }
        	}
        }
        
        return $lessons_array;
    }
    
    private function generate_classroom_key( $key)
    {	
	    if(preg_match('/[0-9][0-9]/', $key, $matches) == 0 && preg_match('/[0-9]/', $key, $matches) == 1)
		{
			$key = preg_replace('/[0-9]/', '0'.$matches[0], $key);
		}
		
		return( $key);
    }
    
    private function parse_lesson_data( $lesson_array)
    {
    	$classroom_array = array();
    	for($i=0;$i<sizeof($lesson_array["classroom"]);$i++)
    	{
    		$key = $lesson_array["classroom"][$i];
    		if(!array_key_exists($key, $classroom_array) && !strpos(strtolower($key), 'utenza'))
    		{
    			$classroom_array[$key] = $this->create_time_table();
    		}
    		else if(strpos(strtolower($key), 'utenza'))
    		{
    			$classroom_array[$key] = $lesson_array["lesson_period"][$i];
    			continue;
    		}
    		
    		$busy_hour = $lesson_array["lesson_period"][$i];
    		$this->update_time_table($classroom_array[$key], $busy_hour);
    	}
    	
    	ksort($classroom_array);
    	return $classroom_array;
    }
    
    private function create_time_table()
    {
    	$time_table = array();
    	for($i=8; $i<20; $i++)
    	{
	    	$hour = sprintf("%'.02d", $i);
	    	$key = $hour.":00";
	    	$time_table[$key] = true;
	    	$key = $hour.":30";
	    	$time_table[$key] = true;
    	}
    	
    	return( $time_table);
    }
    
    private function update_time_table(&$time_table, $busy_hour)
    {
    	// 17.00-19.00
    	$busy_hour = str_replace('.', ':', $busy_hour);
    	$begin_end = explode('-', $busy_hour);
    	$begin = trim($begin_end[0]);
    	$end = trim($begin_end[1]);
    	
    	reset($time_table);
    	
    	$update = false;
		while (list($key, $val) = each($time_table))
		{
			if($key == $end)
				break;
			
		    if($key == $begin)
		    	$update = true;
		    
		   	if($update)
		   		$time_table[$key] = false;
		}
    }
    
  
    //////// check HTML for errors from UNIBG
    function unibg_error()
    {
        $body = $this->xpath->query( '//html/body');
        $text = @strtolower( $body->item(0)->textContent);
        if (substr_count( $text, 'automated requests'))
        { $this->error = "UNIBG ERROR";
          return( TRUE);
        } 
        $this->error = "";
        return( FALSE);
    }

}
