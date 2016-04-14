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
<?php 
	}
	echo form_open('administration/user_controller/insert_entry'); ?>
<form id="new_user_form" action="user_controller/insert_entry" method="post">
	<!-- BLOC RENSEIGNEMENTS -->
	<div class="container-fluid form-container">
		<div class="row">
			<div class="col-md-4 col-md-offset-2">
				<div class="group-input full">
					<div class="input-group">
						<span class="input-group-addon">POSTE</span>
						<input type="text" name="poste" class="form-control" placeholder="Poste" value="<?=set_value('poste'); ?>"/>
					</div>
					<div class="input-group full">
						<span class="input-group-addon">ETABLISSEMENT</span>
						<select id="etablissement_id" name="etablissement_id" class="form-control" onchange="load_services()">
							<option value="" selected="">Selectionner</option>
							<?php foreach ($etablissements as $etablissement):?>
								<option value="<?=$etablissement->id;?>">
									<?=$etablissement->libelle;?>
								</option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon">SERVICE</span>
						<select id="service_id" name="service_id" class="form-control">
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon">STATUT</span>
						<select name="statut_id" class="form-control">
							<option value="" selected="">Selectionner</option>
							<?php foreach ($statuts as $statut):?>
								<option value="<?=$statut["id"];?>">
									<?=$statut["value"];?>
								</option>
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
							<option value="" selected="">Selectionner</option>
							<?php foreach ($account_types as $account_type):?>
								<option value="<?=$account_type["id"];?>">
									<?=$account_type["value"];?>
								</option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon">PASSWORD</span>
						<input type="password" name="password" class="form-control" placeholder="Password"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">CONFIRMATION</span>
						<input type="password" name="password_confirmation" class="form-control" placeholder="Confirmation"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">EMAIL</span>
						<input type="email" name="email" class="form-control" placeholder="Email" value="<?=set_value('email'); ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- BLOC HABILITATIONS -->
	<div class="container-fluid form-container" id="bloc-habilitations">
		<div class="row">
			<!-- HABILITATIONS FONCTIONS -->
			<div class="col-md-5 col-md-offset-1 bloc-habilitations-fonctions">
				<div class="row bloc-titre">
					Habilitations Fonctions
				</div>
				<div class="row">
					<div class="col-md-12 bloc-content">
						<?php foreach ($fonctions as $fonction) { ?>
							<div class="row" style="margin-top:5px">
								<div class="col-md-9 bloc-input-fonction">
									<div class="input-group" style="width:100%">
										<span class="input-group-addon" style="width:5%">
											<input type="checkbox" name="fonctions[]" value="<?=$fonction->id;?>">
										</span>
										<input type="text" class="form-control" value="<?=$fonction->libelle_short;?>" readonly/>
									</div>
								</div>
								<div class="col-md-3 bloc-permission-fonction">
									<select class="form-control" name="permission-fonction-<?=$fonction->id;?>">
										<option value="3" selected>3</option>								
										<option value="2">2</option>								
										<option value="1">1</option>								
										<option value="0">0</option>								
									</select>
								</div>
							</div>
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
						<?php foreach ($scaners as $scaner) { ?>
							<div class="row" style="margin-top:5px">
								<div class="col-md-9 bloc-input-scaner">
									<div class="input-group" style="width:100%">
										<span class="input-group-addon" style="width:5%">
											<input type="checkbox" name="scaners[]" value="<?=$scaner->id;?>" service-id="<?=$scaner->service_id;?>">
										</span>
										<input type="text" class="form-control" value="[<?=$scaner->Libelle_short_service;?>] <?=$scaner->libelle;?>" readonly/>
										<span class="input-group-addon radio-0" style="width:5%">
											<input type="radio" name="permission-scaner-<?=$scaner->id;?>" value="0"/>
										</span>
										<span class="input-group-addon radio-1" style="width:5%">
											<input type="radio" name="permission-scaner-<?=$scaner->id;?>" value="1"/>
										</span>
										<span class="input-group-addon radio-2" style="width:5%">
											<input type="radio" name="permission-scaner-<?=$scaner->id;?>" value="2"/>
										</span>
										<span class="input-group-addon radio-3" style="width:5%">
											<input type="radio" name="permission-scaner-<?=$scaner->id;?>" value="3" checked/>
										</span>
									</div>
								</div>
							</div>
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
						<?php foreach ($services as $service) { ?>
							<div class="row" style="margin-top:5px">
								<div class="col-md-9 bloc-input-service">
									<div class="input-group" style="width:100%">
										<span class="input-group-addon" style="width:5%">
											<input type="checkbox" name="services[]" value="<?=$service->id;?>">
										</span>
										<input type="text" class="form-control" value="[<?=$service->Libelle_short_etablissement;?>] <?=$service->libelle;?> [<?=$service->libelle_short;?>]" readonly/>
										<span class="input-group-addon radio-0" style="width:5%">
											<input type="radio" name="permission-service-<?=$service->id;?>" value="0"/>
										</span>
										<span class="input-group-addon radio-1" style="width:5%">
											<input type="radio" name="permission-service-<?=$service->id;?>" value="1"/>
										</span>
										<span class="input-group-addon radio-2" style="width:5%">
											<input type="radio" name="permission-service-<?=$service->id;?>" value="2"/>
										</span>
										<span class="input-group-addon radio-3" style="width:5%">
											<input type="radio" name="permission-service-<?=$service->id;?>" value="3" checked/>
										</span>
									</div>
								</div>
							</div>
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
						<?php foreach ($etablissements as $etablissement) { ?>
							<div class="row" style="margin-top:5px">
								<div class="col-md-9 bloc-input-etablissement">
									<div class="input-group" style="width:100%">
										<span class="input-group-addon" style="width:5%">
											<input type="checkbox" name="etablissements[]" value="<?=$etablissement->id;?>">
										</span>
										<input type="text" class="form-control" value="<?=$etablissement->libelle;?> [<?=$etablissement->libelle_short;?>]" readonly/>
										<span class="input-group-addon radio-0" style="width:5%">
											<input type="radio" name="permission-etablissement-<?=$etablissement->id;?>" value="0"/>
										</span>
										<span class="input-group-addon radio-1" style="width:5%">
											<input type="radio" name="permission-etablissement-<?=$etablissement->id;?>" value="1"/>
										</span>
										<span class="input-group-addon radio-2" style="width:5%">
											<input type="radio" name="permission-etablissement-<?=$etablissement->id;?>" value="2"/>
										</span>
										<span class="input-group-addon radio-3" style="width:5%">
											<input type="radio" name="permission-etablissement-<?=$etablissement->id;?>" value="3" checked/>
										</span>
									</div>
								</div>
							</div>
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
					<button type="button" class="btn btn-primary bouton-form">Retour Liste</button>
				</a>
				<button type="submit" class="btn btn-success bouton-form">Ajouter</button>
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