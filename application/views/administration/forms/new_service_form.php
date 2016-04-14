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
	echo form_open('administration/service_controller/insert_entry'); ?>
<form action="service_controller/insert_entry" method="post">
	<div class="container-fluid form-container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="group-input">
					<div class="input-group">
						<span class="input-group-addon">Etablissement</span>
						<select name="etablissement_id" class="form-control">
							<option value="">Séléctionner</option>
							<?php foreach ($etablissements as $etablissement):?>
								<option value="<?=$etablissement->id;?>">
									<?=$etablissement->libelle;?>
								</option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Nom</span>
						<input type="text" name="libelle" class="form-control" placeholder="Libelle" value="<?=set_value('libelle'); ?>"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Nom Court</span>
						<input type="text" name="libelle_short" class="form-control" placeholder="Libelle Court" value="<?=set_value('libelle_short'); ?>"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Code Correspondant</span>
						<input type="text" name="code_correspondant" class="form-control" placeholder="Code" value="<?=set_value('code_correspondant'); ?>"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Service Cible</span>
						<select name="service_cible_id" class="form-control">
							<option value="0" selected="">Aucun</option>
							<?php foreach ($services_cible as $service_cible):?>
								<option value="<?=$service_cible->id;?>">
									<?=$service_cible->Etablissement.' - '.$service_cible->Service;?>
								</option>
							<?php endforeach;?>
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
				<button type="submit" class="btn btn-success bouton-form">Ajouter</button>
			</div>
		</div>
	</div>
</form>