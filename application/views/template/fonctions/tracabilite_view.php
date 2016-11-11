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
	//var_dump($this->session);
?>
<!-- VIEW CONTAINER -->
<div class="tracabilite-container">
	<!-- CONTAINER ONGLET ENTETE -->
	<div class="onglet-container">
		<div class="onglet-entete">
			Tracabilité
		</div>
	</div>
	<!-- CONTAINER FORMULAIRE DE RECHERCHE -->
	<div class="entete-container">
		<!-- CONTAINER DES BARRES DE PROGRESSION -->
		<div class="progress-container">
			<div class="bar-container">
				<div class="header-result">
					65 Résultats
				</div>
			</div>
			<div class="bar-container">
				<div class="result-container">34</div>
				<div class="progress-bar-container">
					<div class="progress">
						<div class="progress-bar">
							<span>Terminés</span>
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
		<!-- CONTAINER DES LISTES FILTRES DE RECHERCHE -->
		<div class="lists-container">
			<div class="list-container">
				<select name="filtre-type" class="form-control">
					<option value="0">Selectionner</option>
					<option value="1">Scaner</option>
					<option value="2">Service</option>
					<option value="3">Etablissement</option>
				</select>
			</div>
			<div class="list-container">
				<select name="filtre" class="form-control">
					<option value="0">Selectionner un type</option>
				</select>
			</div>
		</div>
		<!-- CONTAINER DES INPUTS DE DATES DE RECHERCHE -->
		<div class="dates-container">
			<div class="date-container">
				<input type="text" name="date-debut" class="form-control">
			</div>
			<div class="date-container">
				<input type="text" name="date-debut" class="form-control">
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
	</div>
</div>