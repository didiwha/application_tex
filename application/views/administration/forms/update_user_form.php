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
	echo form_open('administration/user_controller/update_entry'); ?>
<form id="update_user_form" action="user_controller/update_entry" method="post">
	<!-- BLOC RENSEIGNEMENTS -->
	<div class="container-fluid form-container">
		<div class="row">
			<input type="hidden" name="id_user" value="<?=$user[0]->id;?>">
			<div class="col-md-4 col-md-offset-2">
				<div class="group-input full">
					<div class="input-group">
						<span class="input-group-addon">POSTE</span>
						<input type="text" name="poste" class="form-control" placeholder="Poste" value="<?=$user[0]->poste;?>"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">ETABLISSEMENT</span>
						<select id="etablissement_id" name="etablissement_id" class="form-control" onchange="load_services()">
							<?php foreach ($etablissements as $etablissement):?>
								<?php if($etablissement->id == $user[0]->etablissement_id){ ?>
										<option value="<?=$etablissement->id;?>" selected>
											<?=$etablissement->libelle;?>
										</option>
									<?php }else{ ?>
										<option value="<?=$etablissement->id;?>">
											<?=$etablissement->libelle;?>
										</option>
									<?php } ?>
							<?php endforeach;?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon">SERVICE</span>
						<select id="service_id" name="service_id" class="form-control" onchange="reinit_habilitations_scaner()">
							<?php foreach ($services as $service):?>
								<?php if($service->id == $user[0]->service_id){ ?>
										<option value="<?=$service->id;?>" selected>
											<?=$service->libelle;?>
										</option>
									<?php }else if($service->etablissement_id == $user[0]->etablissement_id){ ?>
										<option value="<?=$service->id;?>">
											<?=$service->libelle;?>
										</option>
									<?php } ?>
							<?php endforeach;?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon">DROIT</span>
						<select name="statut_id" class="form-control">
							<?php foreach ($statuts as $statut):?>
								<?php if($statut["id"] == $user[0]->statut_id){ ?>
										<option value="<?=$statut["id"];?>" selected>
											<?=$statut["value"];?>
										</option>
									<?php }else{ ?>
										<option value="<?=$statut["id"];?>">
											<?=$statut["value"];?>
										</option>
									<?php } ?>
							<?php endforeach;?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="group-input full">
					<div class="input-group">
						<span class="input-group-addon">TYPE COMPTE</span>
						<select name="account_type_id" class="form-control">
							<?php foreach ($account_types as $account_type):?>
								<?php if($account_type["id"] == $user[0]->type_compte_id){ ?>
										<option value="<?=$account_type["id"];?>" selected>
											<?=$account_type["value"];?>
										</option>
									<?php }else{ ?>
										<option value="<?=$account_type["id"];?>">
											<?=$account_type["value"];?>
										</option>
									<?php } ?>
							<?php endforeach;?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon">PASSWORD</span>
						<input type="password" name="password" class="form-control" placeholder="Nouveau"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">CONFIRMATION</span>
						<input type="password" name="password_confirmation" class="form-control" placeholder="Confirmation"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">EMAIL</span>
						<input type="email" name="email" class="form-control" placeholder="Email" value="<?=$user[0]->email; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- BLOC HABILITATIONS -->
	<div class="container-fluid form-container">
		<div class="row">
			<!-- HABILITATIONS FONCTIONS -->
			<div class="col-md-5 col-md-offset-1 bloc-habilitations-fonctions">
				<div class="row bloc-titre">
					Habilitations Fonctions
				</div>
				<div class="row">
					<div class="col-md-12 bloc-content">
						<?php if(!empty($fonctions)){
							foreach ($fonctions as $fonction) { 
								if ($fonction->user_id !== NULL){
									$checked = "checked";
								}else{
									$checked = "";
								}?>
								<div class="row" style="margin-top:5px" id="bloc-fonctions">
									<div class="col-md-9 bloc-input-fonction">
										<div class="input-group" style="width:100%">
											<span class="input-group-addon" style="width:5%">
												<input type="checkbox" name="fonctions[]" value="<?=$fonction->id;?>" <?=$checked;?>/>
											</span>
											<input type="text" class="form-control" value="<?=$fonction->libelle_short;?>" readonly/>
										</div>
									</div>
									<div class="col-md-3 bloc-permission-fonction">
										<select class="form-control" name="permission-fonction-<?=$fonction->id;?>">
											<?php for ($i=3; $i >= 0; $i--) { 
												if ($i == $fonction->permission){ ?>
													<option value="<?=$i;?>" selected><?=$i;?></option>
												<?php }else{ ?>
													<option value="<?=$i;?>"><?=$i;?></option>
												<?php }
											} ?>								
										</select>
									</div>
								</div>
							<?php }
						}else{ ?>
							Aucune fonction n'est repertoriée
						<?php } ?>
					</div>
				</div>
			</div>
			<!-- HABILITATIONS SCANERS -->
			<div class="col-md-5 bloc-habilitations-scaners">
				<div class="row bloc-titre">
					Habilitations Scaners
				</div>
				<div class="row">
					<div class="col-md-12 bloc-content" id="bloc_scaner">
						<?php if(!empty($scaners_habilitations)){
							foreach ($scaners_habilitations as $scaner) {
								//*** Determine si le user a une permission sur le scaner ***
								if($scaner->id == $scaner->scaner_id){
									$checked = "checked";
								}else{
									$checked = "";
								}
								//*** Check automatique de la permission 3 Si pas de permission ***
								if($scaner->permission == NULL){
									$permission_checked = "checked";
								}else{
									$permission_checked = "";
								}?>
								<div class="row" style="margin-top:5px">
									<div class="col-md-9 bloc-input-scaner">
										<div class="input-group" style="width:100%">
											<!-- CheckBox//Input -->
											<span class="input-group-addon" style="width:5%">
												<input type="checkbox" name="scaners[]" value="<?=$scaner->id;?>" service-id="<?=$scaner->service_id;?>" <?=$checked;?>/>
											</span>
											<input type="text" class="form-control" value="[<?=$scaner->Libelle_short_service;?>] <?=$scaner->libelle;?>" readonly/>
											<!-- RadioBoutons -->
											<span class="input-group-addon radio-0" style="width:5%">
												<input type="radio" name="permission-scaner-<?=$scaner->id;?>" value="0" <?php if($scaner->permission == "0") echo "checked";?>/>
											</span>
											<span class="input-group-addon radio-1" style="width:5%">
												<input type="radio" name="permission-scaner-<?=$scaner->id;?>" value="1" <?php if($scaner->permission == "1") echo "checked";?>/>
											</span>
											<span class="input-group-addon radio-2" style="width:5%">
												<input type="radio" name="permission-scaner-<?=$scaner->id;?>" value="2" <?php if($scaner->permission == "2") echo "checked";?>/>
											</span>
											<span class="input-group-addon radio-3" style="width:5%">
												<input type="radio" name="permission-scaner-<?=$scaner->id;?>" value="3" <?=$permission_checked;if($scaner->permission == "3") echo "checked";?>/>
											</span>
										</div>
									</div>
								</div>
							<?php } 
						}else{ ?>
							Aucun scaner n'est repertorié
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<!-- HABILITATIONS SERVICES -->
			<div class="col-md-5 col-md-offset-1 bloc-habilitations-services">
				<div class="row bloc-titre">
					Habilitations Services
				</div>
				<div class="row">
					<div class="col-md-12 bloc-content">
						<?php if(!empty($services_habilitations)){
							foreach ($services_habilitations as $service_habilitation) {
								if ($service_habilitation->user_id !== NULL){
									$checked = "checked";
								}else{
									$checked = "";
								}
								if($service_habilitation->permission == NULL){
									$permission_checked = "checked";
								}else{
									$permission_checked = "";
								}?>
								<div class="row" style="margin-top:5px">
									<div class="col-md-9 bloc-input-service">
										<div class="input-group" style="width:100%">
											<!-- CheckBox//Input -->
											<span class="input-group-addon" style="width:5%">
												<input type="checkbox" name="services[]" value="<?=$service_habilitation->id;?>" <?=$checked;?>/>
											</span>
											<input type="text" class="form-control" value="[<?=$service_habilitation->Libelle_short_etablissement;?>] <?=$service_habilitation->libelle;?> [<?=$service_habilitation->libelle_short;?>]" readonly/>
											<!-- RadioBoutons -->
											<span class="input-group-addon radio-0" style="width:5%">
												<input type="radio" name="permission-service-<?=$service_habilitation->id;?>" value="0" <?php if($service_habilitation->permission == "0") echo "checked";?>/>
											</span>
											<span class="input-group-addon radio-1" style="width:5%">
												<input type="radio" name="permission-service-<?=$service_habilitation->id;?>" value="1" <?php if($service_habilitation->permission == "1") echo "checked";?>/>
											</span>
											<span class="input-group-addon radio-2" style="width:5%">
												<input type="radio" name="permission-service-<?=$service_habilitation->id;?>" value="2" <?php if($service_habilitation->permission == "2") echo "checked";?>/>
											</span>
											<span class="input-group-addon radio-3" style="width:5%">
												<input type="radio" name="permission-service-<?=$service_habilitation->id;?>" value="3" <?=$permission_checked;if($service_habilitation->permission == "3") echo "checked";?>/>
											</span>
										</div>
									</div>
								</div>
							<?php } 
						}else{ ?>
							Aucun scaner n'est repertorié
						<?php } ?>
					</div>
				</div>
			</div>
			<!-- HABILITATIONS ETABLISSEMENTS -->
			<div class="col-md-5 bloc-habilitations-etablissements">
				<div class="row bloc-titre">
					Habilitations Etablissements
				</div>
				<div class="row">
					<div class="col-md-12 bloc-content">
						<?php if(!empty($etablissements_habilitations)){
							foreach ($etablissements_habilitations as $etablissement_habilitation) {
								if ($etablissement_habilitation->user_id !== NULL){
									$checked = "checked";
								}else{
									$checked = "";
								}
								if($etablissement_habilitation->permission == NULL){
									$permission_checked = "checked";
								}else{
									$permission_checked = "";
								}?>
								<div class="row" style="margin-top:5px">
									<div class="col-md-9 bloc-input-etablissement">
										<div class="input-group" style="width:100%">
											<!-- CheckBox//Input -->
											<span class="input-group-addon" style="width:5%">
												<input type="checkbox" name="etablissements[]" value="<?=$etablissement_habilitation->id;?>" <?=$checked;?>/>
											</span>
											<input type="text" class="form-control" value="<?=$etablissement_habilitation->libelle;?> [<?=$etablissement_habilitation->libelle_short;?>]" readonly/>
											<!-- RadioBoutons -->
											<span class="input-group-addon radio-0" style="width:5%">
												<input type="radio" name="permission-etablissement-<?=$etablissement_habilitation->id;?>" value="0" <?php if($etablissement_habilitation->permission == "0") echo "checked";?>/>
											</span>
											<span class="input-group-addon radio-1" style="width:5%">
												<input type="radio" name="permission-etablissement-<?=$etablissement_habilitation->id;?>" value="1" <?php if($etablissement_habilitation->permission == "1") echo "checked";?>/>
											</span>
											<span class="input-group-addon radio-2" style="width:5%">
												<input type="radio" name="permission-etablissement-<?=$etablissement_habilitation->id;?>" value="2" <?php if($etablissement_habilitation->permission == "2") echo "checked";?>/>
											</span>
											<span class="input-group-addon radio-3" style="width:5%">
												<input type="radio" name="permission-etablissement-<?=$etablissement_habilitation->id;?>" value="3" <?=$permission_checked;if($etablissement_habilitation->permission == "3") echo "checked";?>/>
											</span>
										</div>
									</div>
								</div>
							<?php } 
						}else{ ?>
							Aucun scaner n'est repertorié
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- BLOC BOUTONS -->
	<div class="container-fluid button-container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<a href="<?=base_url();?>index.php/administration/user_controller">
					<button type="button" class="btn btn-primary bouton-form">Retour liste</button>
				</a>
				<button type="submit" class="btn btn-success bouton-form">Modifier</button>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	//***********************************************
	//***** FONCTION EVENEMENTS CLICK CHECKBOX ******
	//***********************************************
	$("#bloc_scaner input[type=checkbox]").click(function(event){
		//******************************
		//** RECUPERATION PARAMETRES ***
		//******************************
		var service_id = $("#service_id").val();
		var current_scaner_service_id = $(this).attr("service-id");
		var current_checkbox = $(this);
		//*** On vérifie que la checkbox cochées à une value de 0, Sinon pas de controle ***
		if($(this).closest('.row').find("input[type=radio][value=0]").prop("checked") == true){
			//*** Vérification du nombre de checkbox cochées ***
			if($("#bloc_scaner input[type=checkbox]:checked").length > 1){
				//*** ON COMPARE TOUTES LES CHECKBOX COCHÉES AYANT UN RADIO DE VALUE 0 AVEC CELUI COURANT ***
				var cptCheckbox = 0;
				$("#bloc_scaner input[type=checkbox]:checked").each(function(index){
					if($(this).closest('.row').find("input[type=radio][value=0]").prop("checked") == true){
						cptCheckbox++;
					}
				});
				//*** REINITIALISE LE RADIO A VALUE = 3 ***
				if(cptCheckbox > 1){
					alert("Vous ne pouvez avoir qu'un seul Scaner par défaut");
					//*** On decoche la radio ***
					$(this).attr("checked", false);
					//*** On recoche la radio 3 ***
					$(this).closest('.row').find("input[type=radio][value=3]").prop("checked", true);
				}
			}
			//*** Vérification dépendance du scaner au service selectionné ***
			else if(service_id != current_scaner_service_id){
				alert("Votre Scaner par défaut doit appartenir à votre service");
				//*** On decoche la radio ***
				$(this).attr("checked", false);
				//*** On recoche la radio 3 ***
				$(this).closest('.row').find("input[type=radio][value=3]").prop("checked", true);
			}
		}
	});
	//***********************************************
	//****** FONCTION EVENEMENTS CLICK RADIO ********
	//* NE SE DECLENCHE QUE SI LA CHECKBOX EST COCHEE
	//***********************************************
	$("#bloc_scaner input[type=radio]").click(function(event){
		if($(this).parent().closest('div').find("input[type=checkbox]").prop("checked") == true){
			//******************************
			//** RECUPERATION PARAMETRES ***
			//******************************
			var service_id = $("#service_id").val();
			var current_scaner_service_id = $(this).parent().closest('div').find("input[type=checkbox]").attr("service-id");
			//*** Vérification du nombre de radio value = 0 de coché, un seul autorisé ***
			if($("#bloc_scaner input[type=radio][value=0]:checked").length > 1){
				alert("Vous ne pouvez avoir qu'un seul Scaner par défaut");
				$(this).attr("checked", false);
				//*** On recoche la radio 3 ***
				$(this).closest('.row').find("input[type=radio][value=3]").prop("checked", true);
			}
			//*** Vérification appartenance scaner au service selectionné si radio value = 0 ***
			else if($(this).val() == 0 && service_id != current_scaner_service_id){
				alert("Votre Scaner par défaut doit appartenir à votre service");
				$(this).attr("checked", false);
				//*** On recoche la radio 3 ***
				$(this).closest('.row').find("input[type=radio][value=3]").prop("checked", true);
			}

		}
	});
	//****************************************************
	//*** FONCTION DE REINITIALISATION DU BLOC SCANER ****
	//****************************************************
	function reinit_habilitations_scaner(){
		//*** REINITIALISE TOUS LES RADIOS -> VALUE = 3 ***
		$("#bloc_scaner input[type=radio]").each(function(index){
			if($(this).attr("value") == 3){
				$(this).prop("checked", true);
			}
		});
		//*** REINITIALISE TOUTES LES CHECKBOX -> NON COCHÉE ***
		$("#bloc_scaner input[type=checkbox]").each(function(index){
			$(this).prop("checked", false);
		});
		animate_bloc_habilitations_scaner();
	}
	//****************************************************
	//****** FONCTION D'ANIMATION DU BLOC SCANER *********
	//****************************************************
	function animate_bloc_habilitations_scaner(){
		$("#bloc_scaner").switchClass( "", "animate", 1000, "easeInOutQuad" );
		$("#bloc_scaner").switchClass( "animate", "", 1000, "easeInOutQuad" );
	}
	//**********************************************************************
	//* FONCTION DE CHARGEMENT DE LA LISTE DES SERVICES D'UN ETABLISSEMENT *
	//**********************************************************************
	function load_services(){
		reinit_habilitations_scaner();
		//** Clear de la liste des services **
		$('#service_id')
		    .find('option')
		    .remove()
		    .end()
		    .append('<option value="">Selectionner</option>')
		    .val('whatever');
		var services = <?php echo json_encode($services); ?>;
		var id_etablissement = $("#etablissement_id").val();
		for (var i = 0; i < services.length; i++) {
			if(services[i]["etablissement_id"] == id_etablissement){
				//** Ajout a la liste des services disponibles **
				$("#service_id").append('<option value='+services[i]["id"]+'>'+services[i]["libelle"]+'</option>');
			}
		}
	}
</script>
<style type="text/css">
	.animate{
		opacity: 0.4;
		background: #F5D0A9;
	}
</style>