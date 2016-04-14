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
	var_dump($this->session);
?>
<!-- ** ZONE ENTETE ONGLET/RECHERCHE PAR NUMERO ET FORMULAIRE RECHERCHE DATE/SCANER ** -->
<div class="container-fluid container-first">
    <div class="row">
        <div class="col-xs-3 col-xs-offset-1 col-sm-3 col-sm-offset-1 col-md-2 col-md-offset-2 bloc-onglet">
			<div class="content-onglet">
				Tracabilité
			</div>
		</div>
    </div>
</div>
<!-- ** ZONE FORMULAIRE RECHERCHE SCANER/DATE ** -->
<div class="container-fluid">
    <div class="row">
    	<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" id="bloc-correspondants-titre" style="background:#2FA9C7;height:60px;padding:0px">
			<?php echo form_open('fonctions/tracabilite_controller'); ?>
			<form action="tracabilite_controller" method="post" name="formpost">
				<div class="row" style="width:100%;height:100%;padding:0px;margin:0px">
					<!-- ** ZONE IMAGE BLANCHE RAPPEL ** -->
					<div class="col-sm-3 col-md-3" id="bloc-image" style="background:#2FA9C7;height:100%;padding-top:10px">
						<div id="content-image" style="width:100%;height:100%;">
							<img src="<?=assets_images_icones_route().'icone_fonction_horodateur.png'?>" class="icone-fonction" alt="Fonction Scan"/>
						</div>
					</div>
					<!-- ** ZONE CHAMP SCANER ** -->
					<div class="col-sm-3 col-md-3" id="bloc-numero" style="background:#2FA9C7;height:100%;padding-top:10px">
						<div id="content-scaners" style="width:100%;height:100%;">
							<select name="scaner_id" class="form-control">
								<?php //** Scaner Filtre **
									if(!empty(get_session_tracability_filter_scaner_id($this))){ ?>
										<option value="<?php echo get_session_tracability_filter_scaner_id($this); ?>" selected><?php echo get_session_tracability_filter_scaner_libelle($this);?></option>
								<?php } //** Scaner Défaut
									if(!empty(get_session_default_scaner_array($this)) && empty(get_session_tracability_filter_scaner_id($this))){ ?>
										<option value="<?php echo get_session_default_scaner_id($this); ?>" selected><?php echo get_session_default_scaner_libelle($this);?></option>
								<?php }
									elseif(!empty(get_session_default_scaner_array($this)) && get_session_default_scaner_id($this) != get_session_tracability_filter_scaner_id($this)){ ?>
										<option value="<?php echo get_session_default_scaner_id($this); ?>"><?php echo get_session_default_scaner_libelle($this);?></option>
								<?php } //** Habilitations Scaners **
									if(!empty(get_session_user_scaners_array($this))){
										foreach (get_session_user_scaners_array($this) as $key => $value) { 
											if($value->scaner_id != get_session_tracability_filter_scaner_id($this)){?>
												<option value="<?php echo $value->scaner_id;?>">
													<?php echo $value->libelle;?>
												</option>';
										<?php }
										}
									} ?>
							</select>
						</div>
					</div>
					<!-- ** ZONE CHAMP COMMENTAIRE ** -->
					<div class="col-sm-4 col-md-4" id="bloc-commentaire" style="background:#2FA9C7;height:100%;padding-right:0px;padding-left:0px;padding-right:15px;padding-top:10px">
						<div class="row" style="width:100%;height:100%">
							<div id="bloc-date" style="width:70%;height:100%;float:left;">
								<div id="content-date" style="width:100%;height:100%;margin:auto">
									<input type="text" id="date" name="date" class="form-control" value="<?php echo get_session_tracability_filter_date($this) ? get_session_tracability_filter_date($this) : date('d.m.Y');?>" style="width:80%;margin:auto"/>
								</div>
							</div>
						</div>
					</div>
					<!-- **** ZONE BOUTON OK **** -->
					<div class="col-sm-2 col-md-2" id="bloc-bt-ok" style="background:#2FA9C7;height:100%;border-radius:0 10px 0 0;padding-left:0px;">
						<div id="content-bt-ok" style="width:100%;height:100%;padding-top:10px;">
							<button type="submit" class="btn btn-default" style="width:60px;height:35px;font-weight:bold">OK</button>
						</div>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>
<!-- ** ZONE CONTENT BLOC LIGNE SCAN ** -->
<div class="container-fluid">
    <div class="row">
		<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" id="contentBloc" style="height:400px;padding:0px;overflow:auto">
			<?php
				$compteur = 0;
				if(!empty($scans)){
					foreach ($scans as $scan) {
						//***** Assignation de la classe de la ligne ******
						if($compteur%2 == 1){
							$classe = "row-scan-1";
						}else{
							$classe = "row-scan-2";
						} ?>
						<div class="row <?php echo $classe; ?>">
							<div class="col-sm-2 col-md-2" style="text-align:left">
								<img src="<?php echo ressources_images_scaners_route().$scan->image;?>" class="icone">
								<?php echo $scan->numero; ?>
							</div>
							<div class="col-sm-2 col-md-2" style="text-align:left">
								<?php echo get_date_from_datetime($scan->date); ?>
							</div>
							<div class="col-sm-2 col-md-2" style="text-align:left">
								<?php echo get_heure_from_datetime($scan->date); ?>
							</div>
							<div class="col-sm-4 col-md-4" style="text-align:left">
								<?php echo $scan->commentaire; ?>
							</div>
							<div class="col-sm-2 col-md-2" style="text-align:right">
	                        	<input type="image" src="<?php echo assets_images_icones_route().'icone_modification.png'?>" data-dialog="dialog" id-scan="<?php echo $scan->id;?>" commentaire="<?php echo $scan->commentaire; ?>" class="icone" alt="Submit"/>
								<!--<form action="horodateur_controller/delete_entry" method="post">-->
								<form action="<?php echo base_url();?>index.php/fonctions/horodateur_controller/delete_entry" method="post">
	                                <input type="hidden" name="id_scan" value="<?php echo $scan->id;?>">
	                            	<input type="image" src="<?php echo assets_images_icones_route().'icone_suppression.png'?>" class="icone" alt="Submit" onclick="return confirm('Confirmer la suppression ?')"/>
	                            </form>
							</div>
						</div>
					<?php 
						$compteur++;
					} 
				}else{ ?>
					<div class="row row-no-answers">Aucun Scan ne correspond aux filtres sélectionnés</div>
			<?php } ?>
		</div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		jQuery.datepicker.setDefaults(jQuery.datepicker.regional['fr']);
		$('#date').datepicker({dateFormat:'dd.mm.yy'});
	});
</script>