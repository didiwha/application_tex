<?php 
    $error_msg = $this->session->flashdata('error');
    $info_msg = $this->session->flashdata('info');
    if (isset($error_msg)){
        echo'<div class="container-fluid message-error-container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 bloc-message-error">
						<div class="row">
							<div class="col-md-8 col-md-offset-2 content-message-error">
								'.$error_msg.'
							</div>
						</div>
					</div>
				</div>
			</div>';
    }elseif (isset($info_msg)){
    	echo'<div class="container-fluid message-info-container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 bloc-message-info">
						<div class="row">
							<div class="col-md-8 col-md-offset-2 content-message-info">
								'.$info_msg.'
							</div>
						</div>
					</div>
				</div>
			</div>';
    }
?>
<div class="page-container">
	<?=encode_password('sa');?>
	<?=encode_password('sa');?>
	<?=encode_password('sa');?>
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

