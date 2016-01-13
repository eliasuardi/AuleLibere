
<?php
	require_once "AuleConfig.php";
	require_once "AuleRequestUnibg.1.1.php";
	
	// set timezone
	date_default_timezone_set('Europe/Rome');
	
	//$ip_addr = $_SERVER['REMOTE_ADDR'] . ' ' . php_uname('n') . ' ' . date('d-m-Y  H:m') . "\n";
	//file_put_contents('addr.txt', $ip_addr, FILE_APPEND);
	
	$file_name = $_REQUEST['file_name'];
	
	$db = $_REQUEST['db'];
	
	$url_params = 'file_name=' . $file_name . '&db=' . $db;
	
	$fac = 'a';
	while(true)
	{
		if(isset($_REQUEST['idfacolt'.$fac]))
			$idfacolt[$fac] = $_REQUEST['idfacolt'.$fac];
		else
			break;
		
		$url_params .= '&idfacolt' . $fac . '=' . $idfacolt[$fac];
		$fac = chr(ord($fac)+1);
	}
		
	if(isset($_REQUEST['data']))
		$data = $_REQUEST['data'];
	else
		$data = 'oggi';

	// create jenti request unibg object
	$request = new AuleRequestUnibg($config);
	
	// get day user wants to visualize
	$result = $request->get_classroom_free_hours($file_name, $db, $idfacolt, $data);
	
?>
<html>
	<head>
        <title>AULELIBERE 1.0 - INGEGNERIA</title>
        <link href="http://s3.amazonaws.com/codecademy-content/courses/ltp/css/shift.css" rel="stylesheet">
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div class="choose-course">
			<div class="course">
				<ul id="course">
					<li><a href="index.1.1.php?file_name=orario_giornaliero.php&db=IN&idfacolta=1">Ingegneria</a></li>
					<li><a href="index.1.1.php?file_name=orario_giornaliero.php&db=EC&idfacolta=4">Giurisprudenza</a></li>
				</ul>
			</div>
		</div>
		
		<div class="title">
			<h1>AULELIBERE 1.1 - UNIBG INGEGNERIA</h1>
		</div>
			
		<p>
			Lista delle aule con le ore libere.
		</p>
		
		<div class="nav">
	      <div class="container">
	        <ul class="menu">
	          
	          <?php 
	          	echo '<li id="oggi"';
	          	
	          	if($data == 'oggi')
	          		echo 'class="btn-bckgd"';

	          	echo '><a href="' . $_SERVER['PHP_SELF'] . '?' . $url_params . '&data=oggi">OGGI';
	          	
	          	echo '</a></li>';
	          	
	          	echo '<li id="domani"';
	          	
	          	if($data == 'domani')
	          		echo 'class="btn-bckgd"';
	          	
	          	echo '><a href="' . $_SERVER['PHP_SELF'] . '?' . $url_params . '&data=domani">DOMANI';
	          	
	          	echo '</a></li>';
	          ?>
	        </ul>
	      </div>
	    </div>
<?php 
            if ($request->error)
	        {
	        	echo '<div class="error>';
	        	echo '<div class="container">';
		        echo '<p>NON CI SONO LEZIONI '.strtoupper($data).'!</p>';
	        	echo '</div></div>';
	        }
	        else
	        {
				echo '<table border="0" cellpadding="5px" cellspacing="5px">';
				
				foreach($result as $key_class => $value_class)
				{
					echo '<tr>';
					echo '<td class="class"><b>'.$key_class.'</b></td>';
					
					if(strpos($key_class, 'utenza'))
					{
						echo '<td class="hours">'.str_replace('-', ' - ', $value_class).'</td>';
						continue;
					}
					
					reset($value_class);
					$curr_value_hour = current($value_class);
					$last_key_hour = key($value_class);
					unset($value_class[$last_key_hour]);
					
					//print_r($value_class);
					
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
							echo '<td class="hours">'.$string.'</td>';
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
						echo '<td class="hours">'.$string.'</td>';
					}
					
					echo '</tr>';
				}
				
				echo '</table>';
				
	        }
	        
	        // get cache age
	        $cache_age = $request->get_cache_age();
?>
                <div class="info">
                    <div class="container">
                        Per informazioni o feedback : ZZZe.suardi5@studenti.unibg.it (senza ZZZ)
                        <br>
                        Sorgente dati : <?php
                    		echo '<a href="'.$request->url.'">qui</a>';
                        ?>
                    	<br>
                    	Eta&grave; dati sorgenti (in secondi) : <?php echo $cache_age; ?> s
                    </div>
                </div>
		<script src="jquery.min.js"></script>
		<script src="jquery.color-2.1.2.min.js"></script>
		<script src="app.js" type="text/javascript"></script>
	</body>
</html>
