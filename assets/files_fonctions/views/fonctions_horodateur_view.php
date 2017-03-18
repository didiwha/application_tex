<script language="javascript">
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
	$("button[bt-change-scaner]").click(function() {
		bootbox.dialog({
                title: "Modification du Scaner par défaut",
                message: '<div class="row">  ' +
		                    '<div class="col-md-12"> ' +
			                    '<form class="form-horizontal" action="<?=base_url();?>index.php/fonctions/horodateur_controller/update_default_scaner" method="post"> ' +
				                    '<div class="form-group"> ' +
					                    '<label class="col-md-1 control-label" for="name"></label> ' +
					                    '<div class="col-md-10"> ' +
					                    	'<select name="scaner" class="form-control" required>' +
					                    		<?php if(!empty(get_session_user_scaners_array($this))): ?>
						                    		<?php foreach (get_session_user_scaners_array($this) as $scaner): ?>
						                    			<?php if($scaner->scaner_id === get_session_default_scaner_array($this)[0]->id): ?>				'<option value="<?=$scaner->scaner_id;?>" selected><?=$scaner->etablissement_short;?> - <?=$scaner->service_short;?> - <?=$scaner->libelle;?></option>' +
						                    			<?php else: ?>
						                    					'<option value="<?=$scaner->scaner_id;?>"><?=$scaner->etablissement_short;?> - <?=$scaner->service_short;?> - <?=$scaner->libelle;?></option>' +
														<?php endif; ?>
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
	//$("#bt-change-type-scan").click(function() {
	$("button[bt-change-type-scan]").click(function() {
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
						                    			<?php if($horodatage_type["id"] == get_session_horodateur_filter_horodatage_type($this)):?>
													    '<option value="<?=$horodatage_type["id"];?>" selected><?=$horodatage_type["value"];?></option>' +
													    <? else: ?>
													    '<option value="<?=$horodatage_type["id"];?>"><?=$horodatage_type["value"];?></option>' +
													    <?endif; ?>
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