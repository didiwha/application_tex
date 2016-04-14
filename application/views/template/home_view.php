
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1 bloc-header">
			<div class="content-header">
				<h1>BANNIERE DE LA PAGE</h1>
			</div>
		</div>
	</div>
</div>
<?php 
    $error_msg = $this->session->flashdata('error');
    $info_msg = $this->session->flashdata('info');
    if (isset($error_msg)){
        echo'<div class="container-fluid message-error-container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 bloc-message-error">
						<div class="row">
							<div class="col-md-8 col-md-offset-2 content-message-error">
								'.$error_msg.'
							</div>
						</div>
					</div>
				</div>
			</div>';
    }elseif (isset($info_msg)){
    	echo'<div class="container-fluid message-info-container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 bloc-message-info">
						<div class="row">
							<div class="col-md-8 col-md-offset-2 content-message-info">
								'.$info_msg.'
							</div>
						</div>
					</div>
				</div>
			</div>';
    }
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2 col-md-offset-1 bloc-connexion">
			<div class="content-connexion">
				<form method="post" accept-charset="utf-8" action="<?php echo base_url();?>index.php/main_controller/connexion">
					<input type="text" name="identifiant" placeholder="Identifiant" required/>
					<input type="password" name="password" placeholder="Password" required/>
					<input type="submit" value="Se Connecter"/>
					Nouveau ?
				</form>
			</div>
		</div>
		<div class="col-md-8 bloc-titre">
			<div class="content-titre">
				<h1>Le titre de la page</h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-md-offset-1 bloc-left">
			<div class="content-left">
				<div class="bloc-liens">
					<div class="content-liens">
						<h3>Liens utiles</h3>
						<ul>
							<li>Lien1</li>
							<li>Lien2</li>
							<li>Lien3</li>
						</ul>
					</div>
				</div>
				<div class="bloc-documents">
					<div class="content-documents">
						<h3>Documents utiles</h3>
						<ul>
							<li>Doc1</li>
							<li>Doc2</li>
							<li>Doc3</li>
						</ul>
					</div>
				</div>
				<div class="bloc-publicite-top">
					<div class="content-publicite-top">
						<h3>Logo Pub#1</h3>
					</div>
				</div>
				<div class="bloc-publicite-bottom">
					<div class="content-publicite-bottom">
						<h3>Logo Pub#2</h3>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-4 bloc-evenements">
			<div class="content-evenements">
				<h2>Bloc Evenements</h2>
			</div>
		</div>
		<div class="col-md-4 bloc-billets">
			<div class="content-billets">
				<h2>Bloc Billets</h2>
			</div>
		</div>
		
		<div class="col-md-8">
			<!------- SLIDER IMAGES/INFORMATIONS ------>
			<div id="my-slider" class="slider-pro">
				<div class="sp-slides">
					<div class="sp-slide">
						<img class="sp-image" src="_assets/sliderPro/src/css/images/blank.gif"
							data-src="http://bqworks.com/slider-pro/images/image1_medium.jpg"
							data-retina="http://bqworks.com/slider-pro/images/image1_large.jpg"/>
						
						<p class="sp-layer sp-white sp-padding"
							data-horizontal="50" data-vertical="50"
							data-show-transition="left" data-hide-transition="up" data-show-delay="400" data-hide-delay="200">
							Lorem ipsum
						</p>

						<p class="sp-layer sp-black sp-padding hide-small-screen"
							data-horizontal="180" data-vertical="50"
							data-show-transition="left" data-hide-transition="up" data-show-delay="600" data-hide-delay="100">
							dolor sit amet
						</p>

						<p class="sp-layer sp-white sp-padding hide-medium-screen"
							data-horizontal="315" data-vertical="50"
							data-show-transition="left" data-hide-transition="up" data-show-delay="800">
							consectetur adipisicing elit.
						</p>
					</div>

					<div class="sp-slide">
						<img class="sp-image" src="sliderPro/src/css/images/blank.gif"
							data-src="http://bqworks.com/slider-pro/images/image2_medium.jpg"
							data-retina="http://bqworks.com/slider-pro/images/image2_large.jpg"/>

						<h3 class="sp-layer sp-black sp-padding" 
							data-horizontal="40" data-vertical="10%" 
							data-show-transition="left" data-hide-transition="left">
							Lorem ipsum dolor sit amet
						</h3>

						<p class="sp-layer sp-white sp-padding hide-medium-screen" 
							data-horizontal="40" data-vertical="22%" 
							data-show-transition="left" data-show-delay="200" data-hide-transition="left" data-hide-delay="200">
							consectetur adipisicing elit
						</p>

						<p class="sp-layer sp-black sp-padding hide-small-screen" 
							data-horizontal="40" data-vertical="34%" data-width="350" 
							data-show-transition="left" data-show-delay="400" data-hide-transition="left" data-hide-delay="500">
							sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
						</p>
					</div>

					<div class="sp-slide">
						<img class="sp-image" src="sliderPro/src/css/images/blank.gif"
							data-src="http://bqworks.com/slider-pro/images/image3_medium.jpg"
							data-retina="http://bqworks.com/slider-pro/images/image3_large.jpg"/>

						<p class="sp-layer sp-white sp-padding" 
							data-position="centerCenter" data-vertical="-50" 
							data-show-transition="right" data-hide-transition="left" data-show-delay="500" >
							Lorem ipsum dolor sit amet
						</p>

						<p class="sp-layer sp-black sp-padding hide-small-screen" 
							data-position="centerCenter" data-vertical="50" 
							data-show-transition="left" data-show-delay="700" data-hide-transition="right" data-hide-delay="200">
							consectetur adipisicing elit
						</p>
					</div>

					<div class="sp-slide">
						<img class="sp-image" src="sliderPro/src/css/images/blank.gif"
							data-src="http://bqworks.com/slider-pro/images/image4_medium.jpg"
							data-retina="http://bqworks.com/slider-pro/images/image4_large.jpg"/>

						<p class="sp-layer sp-black sp-padding" 
							data-position="bottomLeft"
							data-show-transition="up" data-hide-transition="down">
							Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
						</p>
					</div>

					<div class="sp-slide">
						<img class="sp-image" src="sliderPro/src/css/images/blank.gif"
							data-src="http://bqworks.com/slider-pro/images/image5_medium.jpg"
							data-retina="http://bqworks.com/slider-pro/images/image5_large.jpg"/>

						<p class="sp-layer sp-white sp-padding" 
							data-vertical="10" data-horizontal="2%" data-width="96%" 
							data-show-transition="down" data-show-delay="400" data-hide-transition="up">
							Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
						</p>
					</div>

					<div class="sp-slide">
						<img class="sp-image" src="sliderPro/src/css/images/blank.gif"
							data-src="http://bqworks.com/slider-pro/images/image6_medium.jpg"
							data-retina="http://bqworks.com/slider-pro/images/image6_large.jpg"/>

						<p class="sp-layer sp-white sp-padding" 
							data-horizontal="10" data-vertical="10" data-width="35%">
							Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
						</p>
					</div>

					<div class="sp-slide">
						<img class="sp-image" src="sliderPro/src/css/images/blank.gif"
							data-src="http://bqworks.com/slider-pro/images/image7_medium.jpg"
							data-retina="http://bqworks.com/slider-pro/images/image7_large.jpg"/>

						<p class="sp-layer sp-black sp-padding" 
							data-position="bottomLeft" data-vertical="10" data-horizontal="2%" data-width="96%" 
							data-show-transition="up" data-show-delay="400" data-hide-transition="down">
							Lorem ipsum dolor sit amet <span class="hide-small-screen">, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span> <span class="hide-medium-screen">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span>
						</p>
					</div>

					<div class="sp-slide">
						<img class="sp-image" src="sliderPro/src/css/images/blank.gif"
							data-src="http://bqworks.com/slider-pro/images/image8_medium.jpg"
							data-retina="http://bqworks.com/slider-pro/images/image8_large.jpg"/>
					</div>

					<div class="sp-slide">
						<img class="sp-image" src="sliderPro/src/css/images/blank.gif"
							data-src="http://bqworks.com/slider-pro/images/image9_medium.jpg"
							data-retina="http://bqworks.com/slider-pro/images/image9_large.jpg"/>

						<p class="sp-layer sp-black sp-padding" 
							data-position="bottomLeft" data-horizontal="50" data-vertical="100"
							data-show-transition="down" data-show-delay="500" data-hide-transition="up">
							Lorem ipsum dolor sit amet
						</p>

						<p class="sp-layer sp-white sp-padding hide-small-screen" 
							data-position="bottomLeft" data-horizontal="50" data-vertical="50"
							data-show-transition="up" data-show-delay="500" data-hide-transition="down">
							consectetur adipisicing elit <span class="hide-medium-screen">, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
						</p>
					</div>

					<div class="sp-slide">
						<img class="sp-image" src="sliderPro/src/css/images/blank.gif"
							data-src="http://bqworks.com/slider-pro/images/image10_medium.jpg"
							data-retina="http://bqworks.com/slider-pro/images/image10_large.jpg"/>
					</div>
				</div>
			</div>
			<!------- FIN SLIDER IMAGES/INFORMATIONS ------>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1 bloc-footer">
			<div class="content-footer">
				<h1>Le pied de la page</h1>
			</div>
		</div>
	</div>
</div>