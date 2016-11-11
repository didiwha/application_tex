<div class="page-container">
	<div class="formulaire-container">
		<form method="post" accept-charset="utf-8" action="<?php echo base_url();?>index.php/main_controller/connexion">
			<div class="label-container">
				<label for="identifiant">Identifiant</label>
			</div>
			<div class="input-container">
				<input type="text" name="identifiant" id="identifiant" placeholder="Identifiant" required/>
			</div>
			<div class="label-container">
				<label for="password">Password</label>
			</div>
			<div class="input-container">
				<input type="password" name="password" placeholder="*********" required/>
			</div>
			<div class="btn-container">
				<input type="submit" class="btn-form" value="Se Connecter"/>
				<input type="button" class="btn-form" name="signin" value="Sign In">
			</div>
		</form>
	</div>
</div>

