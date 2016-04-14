<!--<nav class="nav-bar">
	<h1 id="tex-logo">
		<a id="link-logo" class="full" href="<?=base_url();?>index.php/main_controller/accueil">
			<div class="full" style="padding-top: 7px">Tex</div>
		</a>
	</h1>
</nav>-->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1 bloc-menu">
			<div class="row">
				<a href="<?=base_url();?>index.php/main_controller/accueil">
					<div class="col-xs-12 col-md-1 col-md-offset-3 bloc-fonction">
		                <div class="row">
		                    <img src="<?=ressources_images_fonctions_route().'image_default_accueil.png';?>" title="Accueil"/>
		                    <div class="row">
		                        <div class="col-xs-12 col-md-12 date">Accueil</div>
		                    </div>
		                </div>
		            </div>
				</a>
				<?php if(!empty(get_session_user_fonctions_array($this))):?>
					<?php foreach (get_session_user_fonctions_array($this) as $fonction):?>
							<a href="<?=base_url().'index.php/fonctions/'.$fonction->controller;?>">
								<div class="col-xs-12 col-md-1 bloc-fonction">
					                <div class="row">
					                    <img src="<?=ressources_images_fonctions_route().$fonction->image;?>" title="<?=$fonction->libelle_short;?>"/>
					                    <div class="row">
					                        <div class="col-xs-12 col-md-12 img-title"><?=$fonction->libelle_short;?></div>
					                    </div>
					                </div>
					            </div>
				            </a>
		            <?php endforeach;?>
	        	<?php endif;?>
	            <?php if(get_session_user_statut_id($this) == 1):?>
		            <a href="<?=base_url();?>index.php/administration/user_controller">
						<div class="col-xs-12 col-md-1 bloc-fonction">
			                <div class="row">
			                    <img src="<?=ressources_images_fonctions_route().'image_default_parameter.png';?>" title="Parametres"/>
			                    <div class="row">
			                        <div class="col-xs-12 col-md-12">Parametres</div>
			                    </div>
			                </div>
			            </div>
					</a>
				<?php endif;?>
				<a href="<?=base_url();?>index.php/main_controller/accueil">
					<div class="col-xs-12 col-md-1 bloc-fonction">
		                <div class="row">
		                    <img src="<?=ressources_images_fonctions_route().'image_default_compte.png';?>" title="Mon Compte"/>
		                    <div class="row">
		                        <div class="col-xs-12 col-md-12">Mon Compte</div>
		                    </div>
		                </div>
		            </div>
				</a>
				<a href="<?=base_url();?>index.php/main_controller/deconnexion">
					<div class="col-xs-12 col-md-1 bloc-fonction">
		                <div class="row">
		                    <img src="<?=ressources_images_fonctions_route().'image_default_disconnect.png';?>" title="Deconnexion"/>
		                    <div class="row">
		                        <div class="col-xs-12 col-md-12">Deconnexion</div>
		                    </div>
		                </div>
		            </div>
				</a>
            </div>
		</div>
	</div>
</div>
<?php if ($this->session->flashdata('error') !== null):?>
        <div class="container-fluid message-error-container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 bloc-message-error">
					<div class="row">
						<div class="col-md-8 col-md-offset-2 content-message-error">
							<?=$this->session->flashdata('error');?>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php elseif ($this->session->flashdata('info') !== null):?>
    	<div class="container-fluid message-info-container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 bloc-message-info">
					<div class="row">
						<div class="col-md-8 col-md-offset-2 content-message-info">
							<?=$this->session->flashdata('info');?>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php endif;?>