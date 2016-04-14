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
<?php var_dump($scans); ?>
<!-- ** ZONE ENTETE ONGLET/RECHERCHE PAR NUMERO ET FORMULAIRE RECHERCHE DATE/SCANER ** -->
<div class="container-fluid container-first">
    <div class="row">
    	<div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 bloc-entete">
    		<div class="row row-full">
    			<div class="col-xs-3 col-sm-3 col-md-3 bloc-onglet">
					<div class="content-onglet">
						Horodateur
					</div>
				</div>
				<div class="col-xs-2 col-xs-offset-7 col-sm-2 col-sm-offset-7 col-md-2 col-md-offset-7 bloc-entete-boutons">
					<button class="btn" id="bt-change-scaner">
						<img src="<?=assets_images_icones_route().'icone_douchette_rotation.png'?>" alt="Changement Scaner"/>
					</button>
					<button class="btn" id="bt-change-type-scan">
						<img src="<?=assets_images_icones_route().'icone_horodatage_rotation.png'?>" alt="Changement Typr Horodatage"/>
					</button>
				</div>
    		</div>
    	</div>
    </div>
</div>
<!-- ** ZONE FORMULAIRE RECHERCHE SCANER/DATE ** -->
<div class="container-fluid">
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
<div class="container-fluid">
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
						<div class="row <?=$classe;?>">
							<div class="col-sm-3 col-md-3 t-left row-zone-1">
								<img src="<?=ressources_images_scaners_route().$scan->image;?>" class="icone">
								<?=$scan->numero;?>
							</div>
							<div class="col-sm-2 col-md-2 row-zone-2">
								<?=get_date_from_datetime($scan->date);?>
							</div>
							<div class="col-sm-2 col-md-2 row-zone-3">
								<?=get_heure_from_datetime($scan->date);?>
							</div>
							<div class="col-sm-2 col-md-2 t-left row-zone-4">
								<?=$scan->commentaire;?>
							</div>
							<div class="col-sm-3 col-md-3 row-zone-5">
	                        	<input type="image" src="<?=assets_images_icones_route().'icone_modification.png'?>" data-dialog="dialog" id-scan="<?=$scan->id;?>" commentaire="<?=$scan->commentaires;?>" class="icone" alt="Submit"/>
								<!--<form action="horodateur_controller/delete_entry" method="post">-->
								<form action="<?=base_url();?>index.php/fonctions/horodateur_controller/delete_entry" method="post">
	                                <input type="hidden" name="id_scan" value="<?=$scan->id;?>">
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
<script language="JavaScript">
	$(document).ready(function(){
		//*** Placement Curseur ***
		$("input[name=numero]").focus();
		//*********************************************************************
		//*** GESTION DES COULEURS POUR DIFFERENCIER LES TYPES D'HORODATAGE ***
		//*********************************************************************
		//*** Récupération Type Horodatage en Session ***
		var type_horodatage = $("input[name=horodatage_type_id]").val();
		//*** Cas d'Horodatage de Demande ***
		if(type_horodatage == 1){
			$("input[name=numero]").attr("placeholder", "Numero Demande");
			$("input[name=numero]").css("background-color", "#E0F2F7");
			$("input[name=commentaire]").css("background-color", "#E0F2F7");
		}
		//*** Cas d'Horodatage de Prelevement ***
		else{
			$("input[name=numero]").attr("placeholder", "Numero Prélèvement");
			$("input[name=numero]").css("background-color", "#F5ECCE");
			$("input[name=commentaire]").css("background-color", "#F5ECCE");
		}
	});
	//***********************************************************
	//*** Desactivation Bouton Ok Si pas de scaner par défaut ***
	//*** Desactivation Bouton '+' d'ajout de commentaire *******
	//***********************************************************
	$("input[name=numero]").keypress(function( event ) {
		if ($("input[name=scaner_id]").val() == "") {
	    	$("#bt-submit").prop("disabled", true);
		}
	});
	$("input[name=commentaire]").keypress(function( event ) {
		if ($("input[name=scaner_id]").val() == "") {
	    	$("#add-comment").prop("disabled", true);
	    	$("#del-comment").prop("disabled", true);
		}
	});
	//*****************************************
	//*** Ajout d'un commentaire par défaut ***
	//*****************************************
	$("#add-comment").click(function(){
		if($("input[name=commentaire]").val() !== ""){
			$.ajax({
				url: '<?=base_url();?>index.php/fonctions/horodateur_controller/add_default_comment',
				type: 'POST',
				data: { scaner_id: $("input[name=scaner_id").val(),
						commentaire: $("input[name=commentaire").val() },
				success:function(response){
					location.reload();
				}
			});
		}else{
			alert("Vous devez renseigner un commentaire dans la zone de saisie");
			$("input[name=commentaire]").focus();
		}
	});
	//***********************************************
	//*** Suppression d'un commentaire par défaut ***
	//***********************************************
	$("#del-comment").click(function(){
		//*** Récupération Commentaire ***
		var commentaire = $("input[name=commentaire]").val();
		//*** Récupération id du Commentaire ***
		var commentaire_id = $("option[value="+commentaire+"]").attr("id");
		//*** Si l'id est bien défini et non null ***
		if (typeof commentaire_id !== "undefined" && commentaire_id !== "") {
			if(confirm("Voulez-vous vraiment supprimer ce commentaire ?")){
				$.ajax({
					url: '<?=base_url();?>index.php/fonctions/horodateur_controller/del_default_comment',
					type: 'POST',
					data: { commentaire_id: commentaire_id },
					success:function(response){
						location.reload();
					}
				});
			}
		}else{
			alert("L'id du commentaire n'est pas défini");
		}
	});
	//**************************************************
	//*** BOOTBOX Modification Commentaire d'un Scan ***
	//**************************************************
	$("input[data-dialog=dialog]").click(function() {
		bootbox.dialog({
                title: "Modification du Commentaire",
                message: '<div class="row">  ' +
		                    '<div class="col-md-12"> ' +
			                    '<form class="form-horizontal" action="<?=base_url();?>index.php/fonctions/horodateur_controller/update_commentaire" method="post"> ' +
				                    '<input type="hidden" name="id_scan" value="'+$(this).attr("id-scan")+'">' +
				                    '<div class="form-group"> ' +
					                    '<label class="col-md-3 control-label" for="name"></label> ' +
					                    '<div class="col-md-6"> ' +
					                    	'<input id="commentaire" name="commentaire" type="text" placeholder="Commentaire" value="'+$(this).attr("commentaire")+'" class="form-control input-md" maxlength="50"> ' +
				                    	'</div> ' +
			                    	'</div> ' +
				                    '<div class="form-group"> ' +
				                    	'<div class="col-md-4 col-md-offset-4"> ' +
				                    		'<button type="submit" class="btn btn-success">Enregistrer</button>' +
			                    		'</div> ' +
				                    '</div> ' +
			                    '</form>' +
	                    	'</div>' +
                    	'</div>',
                buttons: {
                    main:{
                    	label: "Annuler",
                    	className: "btn-default",
                    	callback: function(){}
                    }
                }
            }
        );
	});
	//***************************************************************
	//*** BOOTBOX Modification du Scaner par défaut de la session ***
	//***************************************************************
	$("#bt-change-scaner").click(function() {
		bootbox.dialog({
                title: "Modification du Scaner par défaut",
                message: '<div class="row">  ' +
		                    '<div class="col-md-12"> ' +
			                    '<form class="form-horizontal" action="<?=base_url();?>index.php/fonctions/horodateur_controller/update_default_scaner" method="post"> ' +
				                    '<div class="form-group"> ' +
					                    '<label class="col-md-3 control-label" for="name"></label> ' +
					                    '<div class="col-md-6"> ' +
					                    	'<select name="scaner" class="form-control" required>' +
					                    		<?php if(!empty(get_session_user_scaners_array($this))): ?>
						                    		<?php foreach (get_session_user_scaners_array($this) as $scaner): ?>
													    '<option value="<?=$scaner->scaner_id?>"><?=$scaner->libelle;?></option>' +
													<?php endforeach; ?>
												<?php endif; ?>
					                    	'</select>' +
				                    	'</div> ' +
			                    	'</div> ' +
				                    '<div class="form-group"> ' +
				                    	'<div class="col-md-4 col-md-offset-4"> ' +
				                    		'<button type="submit" class="btn btn-success">Valider</button>' +
			                    		'</div> ' +
				                    '</div> ' +
			                    '</form>' +
	                    	'</div>' +
                    	'</div>',
                buttons: {
                    main:{
                    	label: "Annuler",
                    	className: "btn-default",
                    	callback: function(){}
                    }
                }
            }
        );
	});
	//***************************************************************
	//*** BOOTBOX Modification du Type d'horodatage de la session ***
	//***************************************************************
	$("#bt-change-type-scan").click(function() {
		bootbox.dialog({
                title: "Modification du Type d'Horodatage",
                message: '<div class="row">  ' +
		                    '<div class="col-md-12"> ' +
			                    '<form class="form-horizontal" action="<?=base_url();?>index.php/fonctions/horodateur_controller" method="post"> ' +
				                    '<div class="form-group"> ' +
					                    '<label class="col-md-3 control-label" for="name"></label> ' +
					                    '<div class="col-md-6"> ' +
					                    	'<select name="horodatage_type" class="form-control" required>' +
					                    		<?php if(!empty($horodatage_types)): ?>
						                    		<?php foreach ($horodatage_types as $horodatage_type):?>
													    '<option value="<?=$horodatage_type["id"];?>"><?=$horodatage_type["value"];?></option>' +
													<?php endforeach; ?>
												<?php endif; ?>
					                    	'</select>' +
				                    	'</div> ' +
			                    	'</div> ' +
				                    '<div class="form-group"> ' +
				                    	'<div class="col-md-4 col-md-offset-4"> ' +
				                    		'<button type="submit" class="btn btn-success">Valider</button>' +
			                    		'</div> ' +
				                    '</div> ' +
			                    '</form>' +
	                    	'</div>' +
                    	'</div>',
                buttons: {
                    main:{
                    	label: "Annuler",
                    	className: "btn-default",
                    	callback: function(){}
                    }
                }
            }
        );
	});
</script>