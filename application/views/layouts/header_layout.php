<!DOCTYPE html>
<html>
	<head>
		<!-- BALISES META -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<!-- JQUERY -->
		<!--<script src="<?php echo assets_javascript_route()?>jquery/jquery-1.10.2.js" type="text/javascript"></script>-->
		<script type="text/javascript" src="<?php echo assets_modules_slider_route()?>libs/jquery-1.11.0.min.js"></script>
		<!-- BOOSTRAP -->
		<link href="<?php echo assets_css_route()?>bootstrap/bootstrap.css" rel="stylesheet">
		<link href="<?php echo assets_css_route()?>bootstrap/bootstrap-theme.css" rel="stylesheet">
		<script src="<?php echo assets_javascript_route()?>bootstrap/bootstrap.js"></script>
		<!-- FICHIERS JAVASCRIPT RESPOND CSS IE8 AND UNDER -->
	    <script src="<?php echo assets_modules_respond_route()?>html5shiv.min.js"></script>
		<script src="<?php echo assets_modules_respond_route()?>respond.min.js"></script>
		<!-- DATATABLES -->
		<link href="<?php echo assets_modules_datatables_route()?>media/css/jquery.dataTables.css" rel="stylesheet" type="text/css" >	  
		<script src="<?php echo assets_modules_datatables_route()?>media/js/jquery.dataTables.js" type="text/javascript"></script>
		<!-- DATEPICKER JQUERY-UI -->
		<link href="<?php echo assets_javascript_route()?>jquery-ui/css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" >	  
		<script src="<?php echo assets_javascript_route()?>jquery-ui/jquery-ui-1.11.4/jquery-ui.min.js" type="text/javascript"></script>
		<script src="<?php echo assets_modules_datepicker_route()?>jquery.ui.datepicker-fr.js" type="text/javascript"></script>
		<!-- BOOTBOX -->
		<script src="<?php echo assets_modules_bootbox_route()?>bootbox.min.js"></script>
		<!-- CSS -->
		<link href="<?php echo assets_css_route()?>styles.css" rel="stylesheet">

		<!-- SLIDER PRO -->
		<script type="text/javascript" src="<?php echo assets_modules_slider_route()?>dist/js/jquery.sliderPro.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo assets_modules_slider_route()?>dist/css/slider-pro.min.css" media="screen"/>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'/>
		<script type="text/javascript">
			$( document ).ready(function($){
				$( '#my-slider' ).sliderPro({
					width: 660,
					height: 450,
					arrows: true,
					buttons: false,
					waitForLayers: true,
					thumbnailWidth: 200,
					thumbnailHeight: 100,
					thumbnailPointer: true,
					autoplay: false,
					autoScaleLayers: false,
					breakpoints: {
						500: {
							thumbnailWidth: 120,
							thumbnailHeight: 50
						}
					}
				});
			});
		</script>
	</head>
	<body>