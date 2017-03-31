<?php if(validation_errors()){ ?>
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
<?php }
	//var_dump(get_session_tracability_filter_date($this));
	//var_dump(get_session_tracability_filter_scaner_id($this));
	// var_dump($this->session);
	//var_dump($array_horodatages);
	

	//****************************
	//*** RECUPERATION FILTRES ***
	//****************************
	if ( $filtres ){
		$filtre_type = $filtres["filtre_type"];
		$date_debut = $filtres["date_debut"];
		$date_fin = $filtres["date_fin"];
	}else{
		$filtre_type = '';
		$date_debut = '01/01/2016';
		$date_fin = '16/01/2016';
	}
?>
<!-- VIEW CONTAINER -->
<div class="tracabilite-container">
	<!-- CONTAINER ONGLET ENTETE -->
	<div class="onglet-container">
		<div class="onglet-entete">
			Tracabilite
		</div>
	</div>
	<!-- CONTAINER FORMULAIRE DE RECHERCHE -->
	<div class="entete-container">
		<!-- CONTAINER DES BARRES DE PROGRESSION -->
		<div class="progress-container">
			<div class="bar-container">
				<div class="header-result">
					65 Resultats
				</div>
			</div>
			<div class="bar-container">
				<div class="result-container">34</div>
				<div class="progress-bar-container">
					<div class="progress">
						<div class="progress-bar">
							<span>Termines</span>
						</div>
					</div>
				</div>
			</div>
			<div class="bar-container">
				<div class="result-container">34</div>
				<div class="progress-bar-container">
					<div class="progress">
						<div class="progress-bar">
							<span>En cours</span>
						</div>
					</div>
				</div>
			</div>
			<div class="bar-container">
				<div class="result-container">34</div>
				<div class="progress-bar-container">
					<div class="progress">
						<div class="progress-bar">
							<span>En attente</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo form_open('fonctions/tracabilite_controller/load_data');?>
		<form action="tracabilite_controller/load_data" method="post" name="formpost">
			<!-- CONTAINER DES LISTES FILTRES DE RECHERCHE -->
			<div class="lists-container">
				<div class="list-container">
					<select name="filtre-type" class="form-control" required/>
						<option value="">Selectionner</option>
						<option value="1" <?php if($filtre_type==1) echo 'selected';?>>Scaner</option>
						<option value="2" <?php if($filtre_type==2) echo 'selected';?>>Service</option>
						<option value="3" <?php if($filtre_type==3) echo 'selected';?>>Etablissement</option>
					</select>
				</div>
				<div class="list-container">
					<select name="filtre" class="form-control" required/>
						<option value="">Selectionner un type</option>
					</select>
				</div>
				<input type="hidden" name="permission" value="0"/>
			</div>
			<!-- CONTAINER DES INPUTS DE DATES DE RECHERCHE -->
			<div class="dates-container">
				<div class="date-container">
					<input type="text" id="date-debut" name="date-debut" class="form-control" value="<?=$date_debut?>" Placeholder="Date Debut" required/>
				</div>
				<div class="date-container">
					<input type="text" id="date-fin" name="date-fin" class="form-control" value="<?=$date_fin?>" Placeholder="Date Fin" required/>
				</div>
			</div>
			<div class="nc-compteur-container">
				<div class="result-container">2</div>
				<div class="img-compteur-container">
					<img src="<?=assets_images_icones_route().'icone_compteur.png'?>" alt="Changement Scaner"/>
				</div>
				<div class="content-container">
					<input type="checkbox" name="non-conformite"> NC
				</div>
			</div>
			<div class="validation-container">
				<button>OK</button>
			</div>
		</form>
	</div>
	<!-- CONTAINER HORODATAGES -->
	<div class="horodatages-container">
		<!-- ** ZONE CONTENT BLOC LIGNE SCAN ** -->
		<?php
			if(!empty($array_horodatages)){
				$compteur = 0;
				foreach ($array_horodatages as $scan) {
					//***** Assignation de la classe de la ligne ******
					if($compteur%2 == 1){
						$classe = "row-horodatage-1";
					}else{
						$classe = "row-horodatage-2";
					} ?>
					<div class="horodatage-row <?=$classe;?>" numero="<?=$scan->numero;?>" id-scaner="<?=$scan->scaner_id;?>">
						<div class="icone-container">
							<img src="<?=ressources_images_scaners_route().$scan->image;?>" class="icone">
						</div>
						<div class="text-container">
							<?=$scan->numero;?>
						</div>
						<div class="date-container">
							<?=get_date_from_datetime($scan->date);?>
						</div>
						<div class="heure-container">
							<?=get_heure_from_datetime($scan->date);?>
						</div>
						<div class="endline-container">
							<div class="img-container">
								<input type="image" src="<?=assets_images_icones_route().'icone_modification.png'?>" data-dialog="dialog" id-scan="<?=$scan->id;?>" commentaire="<?=$scan->commentaire;?>" class="icone" alt="Submit"/>
							</div>
							<?php if (1 == 1):?>
	                        	<div class="img-container">
									<form action="<?=base_url();?>index.php/fonctions/horodateur_controller/delete_entry" method="post">
		                                <input type="hidden" name="id_horodatage" value="<?=$scan->id;?>">
		                                <input type="hidden" name="numero_demande" value="<?=$scan->numero;?>">
		                                <input type="hidden" name="id_scaner" value="<?=$scan->scaner_id;?>">
		                            	<input type="image" src="<?=assets_images_icones_route().'icone_suppression.png'?>" class="icone" alt="Submit" onclick="return confirm('Confirmer la suppression ?')"/>
		                            </form>
	                            </div>
                        	<?php endif;?>
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