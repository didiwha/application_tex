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
	if(isset($upload_errors)){ ?>
	<div class="container-fluid form-error-validation-container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1 bloc-form-error-validation">
				<div class="row">
					<div class="col-md-6 col-md-offset-3 content-form-error-validation">
						<?php foreach($upload_errors as $upload_error): ?>
							<?=$upload_error;?>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php 
	}
	echo form_open_multipart('administration/scaner_controller/insert_entry'); ?>
<form action="scaner_controller/insert_entry" method="post">
	<div class="container-fluid form-container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="group-input">
					<div class="input-group">
						<span class="input-group-addon">Etablissement</span>
						<select id="etablissement_id" name="etablissement_id" class="form-control" onchange="load_services()">
							<option value="" selected="">Selectionner</option>
							<?php foreach ($etablissements as $etablissement):?>
								<?php if ($etablissement->id == set_value('etablissement_id')): ?>
									<option value="<?=$etablissement->id;?>" selected>
										<?=$etablissement->libelle;?>
									</option>	
								<?php else: ?>
									<option value="<?=$etablissement->id;?>">
										<?=$etablissement->libelle;?>
									</option>
								<?php endif;?>
							<?php endforeach;?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Service</span>
						<select id="service_id" name="service_id" class="form-control">
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Libellé</span>
						<input type="text" name="libelle" class="form-control" placeholder="Libellé" value="<?=set_value('libelle'); ?>"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Libellé Court</span>
						<input type="text" name="libelle_short" class="form-control" placeholder="Libellé Court" value="<?=set_value('libelle_short'); ?>"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Image</span>
						<input type="file" name="image" class="form-control" placeholder="Image"/>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="containe-fluid button-container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<a href="<?=base_url();?>index.php/administration/scaner_controller">
					<button type="button" class="btn btn-primary bouton-form">Retour Liste</button>
				</a>
				<button type="submit" class="btn btn-success bouton-form">Ajouter</button>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	function load_services(id_service_loaded){
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