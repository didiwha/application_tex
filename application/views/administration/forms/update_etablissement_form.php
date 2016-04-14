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
	echo form_open('administration/etablissement_controller/update_entry'); ?>
<form action="etablissement_controller/update_entry" method="post">
	<div class="container-fluid form-container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<input type="hidden" name="id_etablissement" value="<?=$etablissement[0]->id;?>">
				<div class="group-input">
					<div class="input-group">
						<span class="input-group-addon">Nom</span>
						<input type="text" name="libelle" class="form-control" placeholder="Libelle" value="<?=$etablissement[0]->libelle;?>" />
					</div>
					<div class="input-group">
						<span class="input-group-addon">Nom Court</span>
						<input type="text" name="libelle_short" class="form-control" placeholder="Libelle Court" value="<?=$etablissement[0]->libelle_short;?>" />
					</div>
					<div class="input-group">
						<span class="input-group-addon">Code</span>
						<input type="text" name="code" class="form-control" placeholder="Code" value="<?=$etablissement[0]->code;?>"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Telephone</span>
						<input type="text" name="telephone" class="form-control" placeholder="Telephone" value="<?=$etablissement[0]->telephone;?>"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Email</span>
						<input type="text" name="email" class="form-control" placeholder="Email" value="<?=$etablissement[0]->email;?>"/>
					</div>
				</div>
				<div class="group-input">
					<div class="input-group">
						<span class="input-group-addon">Adresse</span>
						<input type="text" name="adresse" class="form-control" placeholder="Adresse" value="<?=$etablissement[0]->adresse;?>"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Code Postal</span>
						<input type="text" name="code_postal" class="form-control" placeholder="Code Postal" value="<?=$etablissement[0]->code_postal;?>"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Ville</span>
						<input type="text" name="ville" class="form-control" placeholder="Ville" value="<?=$etablissement[0]->ville;?>"/>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Source</span>
						<select name="source" class="form-control">
							<?php if($etablissement[0]->source == 0){ ?>
								<option value="0" selected>Non</option>
								<option value="1">Oui</option>
							<?php }else{ ?>
								<option value="1" selected>Oui</option>
								<option value="0">Non</option>
							<?php } ?>
						</select>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="containe-fluid button-container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<a href="<?=base_url();?>index.php/administration/etablissement_controller">
					<button type="button" class="btn btn-primary bouton-form">Retour Liste</button>
				</a>
				<button type="submit" class="btn btn-success bouton-form">Modifier</button>
			</div>
		</div>
	</div>
</form>