<?php if(validation_errors()): ?>
	<div class="container-fluid form-error-validation-container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1 bloc-form-error-validation">
				<div class="row row-bloc-form-error">
					<div class="col-md-6 col-md-offset-3 content-form-error-validation">
						<?=validation_errors();?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php 
	//var_dump($scans); 
	// var_dump(get_session_horodateur_filter_horodatage_type($this));
	// var_dump($horodatage_types);
?>
<!-- ** ZONE ENTETE ONGLET/RECHERCHE PAR NUMERO ET FORMULAIRE RECHERCHE DATE/SCANER ** -->
<div class="container-fluid container-first visible-xs visible-sm visible-md visible-lg">
    <div class="row">
    	<div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 bloc-entete">
    		<div class="row row-full">
    			<div class="col-xs-3 col-sm-3 col-md-3 bloc-onglet">
					<div class="content-onglet">
						Horodateur
					</div>
				</div>
				<div class="col-xs-2 col-xs-offset-7 col-sm-2 col-sm-offset-7 col-md-2 col-md-offset-7 bloc-entete-boutons">
					<button class="btn" id="bt-change-scaner" bt-change-scaner>
						<img src="<?=assets_images_icones_route().'icone_douchette_rotation.png'?>" alt="Changement Scaner"/>
					</button>
					<button class="btn" id="bt-change-type-scan" bt-change-type-scan>
						<img src="<?=assets_images_icones_route().'icone_horodatage_rotation.png'?>" alt="Changement Type Horodatage"/>
					</button>
				</div>
    		</div>
    	</div>
    </div>
</div>
<!-- ** ZONE FORMULAIRE RECHERCHE SCANER/DATE ** -->
<div class="container-fluid visible-xs visible-sm visible-md visible-lg">
    <div class="row">
    	<div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 content-entete-1">
			<?php echo form_open('fonctions/horodateur_controller/insert_entry');?>
			<form action="horodateur_controller/insert_entry" method="post" name="formpost">
				<input type="hidden" name="scaner_id" value="<?=get_session_default_scaner_id($this);?>"/>
				<input type="hidden" name="horodatage_type_id" value="<?=get_session_horodateur_filter_horodatage_type($this);?>">
				<div class="row row-full">
					<!-- ** ZONE IMAGE BLANCHE RAPPEL ** -->
					<div class="col-sm-3 col-md-3 bloc-image-entete-1">
						<div id="content-image full">
							<img src="<?=assets_images_icones_route().'icone_fonction_horodateur.png'?>" class="icone-fonction" alt="Fonction Scan"/>
						</div>
					</div>
					<!-- ** ZONE CHAMP COMMENTAIRE ** -->
					<div class="col-sm-4 col-md-4 bloc-commentaire">
						<input type="text" class="form-control full t-right" name="commentaire" placeholder="Commentaire" list="lst_commentaires">
						<datalist id="lst_commentaires">
							<?php if(!empty($default_commentaires)):?>
								<?php foreach ($default_commentaires as $commentaire):?>
								    <option id="<?=$commentaire->id?>" value="<?=$commentaire->data_value;?>"/>
								<?php endforeach; ?>
							<?php endif; ?>
						</datalist>
					</div>
					<div class="col-sm-1 col-md-1 bloc-boutons">
						<input type="button" id="add-comment" value="+" class="btn btn-primary"/>
						<input type="button" id="del-comment" value="-" class="btn btn-warning"/>
					</div>
					<!-- ** ZONE CHAMP NUMERO ** -->
					<div class="col-sm-3 col-md-3 bloc-numero">
						<input type="text" class="form-control" name="numero" placeholder="Numero" pattern="[0-9]{7,10}">
					</div>
					<!-- **** ZONE BOUTON OK **** -->
					<div class="col-sm-1 col-md-1 bloc-entete-right">
						<button id="bt-submit" type="submit" class="btn btn-success btn-1">OK</button>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>
<!-- ** ZONE CONTENT BLOC LIGNE SCAN ** -->
<div class="container-fluid visible-xs visible-sm visible-md visible-lg">
    <div class="row">
		<div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 content-rows-1">
			<?php
				if(!empty($scans)){
					$compteur = 0;
					foreach ($scans as $scan) {
						//***** Assignation de la classe de la ligne ******
						if($compteur%2 == 1){
							$classe = "row-scan-1";
						}else{
							$classe = "row-scan-2";
						} ?>
						<div class="row <?=$classe;?>" numero="<?=$scan->numero;?>" id-scaner="<?=$scan->scaner_id;?>">
							<div class="col-sm-4 col-md-4 t-left row-zone-1">
								<div class="icone-container">
									<img src="<?=ressources_images_scaners_route().$scan->image;?>" class="icone">
								</div>
								<div class="text-container">
									<?=$scan->numero;?>
								</div>
							</div>
							<div class="col-sm-2 col-md-2 row-zone-2">
								<?=get_date_from_datetime($scan->date);?>
							</div>
							<div class="col-sm-2 col-md-2 row-zone-3">
								<?=get_heure_from_datetime($scan->date);?>
							</div>
							<!--<div class="col-sm-2 col-md-2 t-left row-zone-4">
								<?=$scan->commentaire;?>
							</div>-->
							<div class="col-sm-4 col-md-4 row-zone-5">
	                        	<input type="image" src="<?=assets_images_icones_route().'icone_modification.png'?>" data-dialog="dialog" id-scan="<?=$scan->id;?>" commentaire="<?=$scan->commentaires;?>" class="icone" alt="Submit"/>
								<!--<form action="horodateur_controller/delete_entry" method="post">-->
								<form action="<?=base_url();?>index.php/fonctions/horodateur_controller/delete_entry" method="post">
	                                <input type="hidden" name="id_horodatage" value="<?=$scan->id;?>">
	                                <input type="hidden" name="numero_demande" value="<?=$scan->numero;?>">
		                            <input type="hidden" name="id_scaner" value="<?=$scan->scaner_id;?>">
	                            	<input type="image" src="<?=assets_images_icones_route().'icone_suppression.png'?>" class="icone" alt="Submit" onclick="return confirm('Confirmer la suppression ?')"/>
	                            </form>
							</div>
						</div>
					<?php 
						$compteur++;
					} 
				}elseif (empty(get_session_default_scaner_id($this))){ ?>
					<div class="row row-no-answers-1">
						Aucun Scaner par défaut ne vous attribué, vous ne pouvez pas utiliser cette fonction, contacter un administrateur
					</div>
			<?php }else{ ?>
					<div class="row row-no-answers-1">
						Aucune donnée n'a pu être récupérée
					</div>
			<?php } ?>
		</div>
    </div>
</div>
<!-- ********************************** -->
<!-- ** ZONE CONTENT VISIBLE XS ONLY ** -->
<!-- **********************************
<div class="container-fluid visible-xs">
	<div class="row">
		<div class="col-xs-7">
			<div class="row row-full">
    			<div class="col-xs-12 bloc-onglet">
					<div class="content-onglet">
						Horodateur
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-5">
			<div class="row row-full">
				<div class="col-xs-12 bloc-entete-boutons">
					<button class="btn" id="bt-change-scaner-xs" bt-change-scaner>
						<img src="<?=assets_images_icones_route().'icone_douchette_rotation.png'?>" alt="Changement Scaner"/>
					</button>
					<button class="btn" id="bt-change-type-scan-xs" bt-change-type-scan>
						<img src="<?=assets_images_icones_route().'icone_horodatage_rotation.png'?>" alt="Changement Type Horodatage"/>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
    	<div class="col-xs-12 content-entete-1">
			<?php echo form_open('fonctions/horodateur_controller/insert_entry');?>
			<form action="horodateur_controller/insert_entry" method="post" name="formpost">
				<input type="hidden" name="scaner_id" value="<?=get_session_default_scaner_id($this);?>"/>
				<input type="hidden" name="horodatage_type_id" value="<?=get_session_horodateur_filter_horodatage_type($this);?>">
				<div class="row row-full">
					<!-- ** ZONE CHAMP COMMENTAIRE ** 
					<div class="col-xs-5 bloc-commentaire">
						<input type="text" class="form-control full t-right" name="commentaire" placeholder="Commentaire" list="lst_commentaires">
						<datalist id="lst_commentaires">
							<?php if(!empty($default_commentaires)):?>
								<?php foreach ($default_commentaires as $commentaire):?>
								    <option id="<?=$commentaire->id?>" value="<?=$commentaire->data_value;?>"/>
								<?php endforeach; ?>
							<?php endif; ?>
						</datalist>
					</div>
					<!-- ** ZONE CHAMP NUMERO ** 
					<div class="col-xs-5 bloc-numero">
						<input type="text" class="form-control" name="numero" placeholder="Numero" pattern="[0-9]{7,10}">
					</div>
					<!-- **** ZONE BOUTON OK **** 
					<div class="col-xs-2 bloc-entete-right">
						<button id="bt-submit" type="submit" class="btn btn-success btn-1">OK</button>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>-->
