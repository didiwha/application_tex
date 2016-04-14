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
	echo form_open('administration/service_controller/update_entry'); ?>
<form action="service_controller/update_entry" method="post">
	<div class="container-fluid form-container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<input type="hidden" name="id_service" value="<?=$service[0]->id;?>">
				<div class="group-input">
					<div class="input-group">
						<span class="input-group-addon">Etablissement</span>
						<select name="etablissement_id" class="form-control">
							<?php foreach ($etablissements as $etablissement):
									if ($etablissement->id == $service[0]->etablissement_id) {?>
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
						<span class="input-group-addon">Libelle</span>
						<input type="text" name="libelle" class="form-control" placeholder="Libelle" value="<?=$service[0]->libelle;?>" />
					</div>
					<div class="input-group">
						<span class="input-group-addon">Libelle Court</span>
						<input type="text" name="libelle_short" class="form-control" placeholder="Libelle Court" value="<?=$service[0]->libelle_short;?>" />
					</div>
					<div class="input-group">
						<span class="input-group-addon">Code</span>
						<input type="text" name="code_correspondant" class="form-control" placeholder="Code" value="<?=$service[0]->code_correspondant;?>"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Service Cible</span>
						<select name="service_cible_id" class="form-control">
							<?php if($service[0]->service_cible_id == 0){ ?>
										<option value="0" selected>Aucun</option>
								<?php }else{ ?>
										<option value="0">Aucun</option>
								<?php }
								foreach ($services_cible as $service_cible):
									if($service_cible->id == $service[0]->service_cible_id){?>
										<option value="<?=$service_cible->id;?>" selected>
											<?=$service_cible->Etablissement.' - '.$service_cible->Service;?>
										</option>
									<?php }else{ ?>
										<option value="<?=$service_cible->id;?>">
											<?=$service_cible->Etablissement.' - '.$service_cible->Service;?>
										</option>
									<?php }
								endforeach;
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="containe-fluid button-container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<a href="<?=base_url();?>index.php/administration/service_controller">
					<button type="button" class="btn btn-primary bouton-form">Retour Liste</button>
				</a>
				<button type="submit" class="btn btn-success bouton-form">Modifier</button>
			</div>
		</div>
	</div>
</form>