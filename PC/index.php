<?php 
	require_once '../AuleConfig.php';
?>
<html>
	<head>
        <title><?php echo $config["application"]; ?></title>
 		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>		
		<div class="title">
			<h1><?php echo $config["application"]; ?></h1>
		</div>
		
		<div class="choose-course">
			<div class="course">
				<ul id="course">
					<li><a href="aule.1.2.php?facolta=GIU">Giurisprudenza</a></li>
					<li><a href="aule.1.2.php?facolta=ING">Ingegneria</a></li>
					<li><a href="aule.1.2.php?facolta=LETT">Lettere Filosofia Comunicazione</a></li>
					<li><a href="aule.1.2.php?facolta=LING">Lingue Letterature Culture Straniere</a></li>
					<li><a href="aule.1.2.php?facolta=SCAE">Scienze Aziendali Economiche Metodi Quantitativi</a></li>
					<li><a href="aule.1.2.php?facolta=SCUS">Scienze Umane Sociali</a></li>
				</ul>
			</div>
		</div>
		
		<?php echo $config["footer"]; ?>

	</body>
</html>
