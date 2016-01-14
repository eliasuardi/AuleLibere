<?php 
	require_once 'AuleConfig.php';
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
		<link rel="stylesheet" href="aule.css">
		
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
        <script src="jquery-cookie-master/src/jquery.cookie.js"></script>
		
		<script src="javascript/AuleHome.js"></script>
	</head>
	<body>
		<div id="div-home-page" data-role="page" class="ui-responsive-panel">
             
			<div id="div-header" data-theme="b" data-role="header" data-position="fixed" class="aule-text-center">
				<h1><?php echo $config["application"]; ?></h1>
                <a href="#menu-panel" id="icon-menu" data-icon="bars" data-iconpos="notext">Menu</a>
                <!--<a href="#info-panel" id="icon-info" data-icon="info" data-iconpos="notext">Info</a>-->
			</div>
			
			<div id="div-main" data-role="main" class="ui-content aule-text-main aule-text-center">
			</div>
            
            <div data-role="panel" data-position="left" data-position-fixed="false" data-display="reveal" id="menu-panel" data-theme="b">
                <ul data-role="listview" data-theme="b" data-divider-theme="b" style="margin-top:-16px;" class="nav-search">
                    <li>
                        <a href="#" id="save">Salva Facolta&grave;</a>
                    </li>
                </ul>
            </div>
            
            <!--<div data-role="panel" data-position="right" data-position-fixed="false" data-display="reveal" id="info-panel" data-theme="b">
                <div id="img-container" style="display: inline-block;background: white;padding: 0;">
                    <img src="90degrees.gif">
                </div>
                <p>INFO</p>
            </div>-->

		</div>
	</body>
</html>
