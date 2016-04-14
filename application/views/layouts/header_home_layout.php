<!DOCTYPE html>
<html>
	<head>
		<!-- BALISES META -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
		<!-- JQUERY -->
		<script type="text/javascript" src="<?php echo assets_modules_slider_route()?>libs/jquery-1.11.0.min.js"></script>
		<!-- SLIDER PRO -->
		<script type="text/javascript" src="<?php echo assets_modules_slider_route()?>dist/js/jquery.sliderPro.min.js"></script>
		<!-- BOOSTRAP -->
		<link href="<?php echo assets_css_route()?>bootstrap/bootstrap.css" rel="stylesheet">
		<link href="<?php echo assets_css_route()?>bootstrap/bootstrap-theme.css" rel="stylesheet">
		<script src="<?php echo assets_javascript_route()?>bootstrap/bootstrap.js"></script>
		<!-- CSS -->
		<link href="<?php echo assets_css_route()?>css.css" rel="stylesheet">
		<link href="<?php echo assets_css_route()?>css_home.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?php echo assets_modules_slider_route()?>dist/css/slider-pro.min.css" media="screen"/>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'/>
		<script type="text/javascript">
			$( document ).ready(function($){
				$( '#my-slider' ).sliderPro({
					width: 900,
					height: 350,
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