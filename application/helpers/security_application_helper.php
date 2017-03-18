<?php
	//*************************************************************
	/***** get_int_limit_horodateur_fonction Function *************
	** - Retourne le nombre limite d'horodatages 
	** - pour la vue horodateur
	**************************************************************/
	function get_int_limit_horodateur_fonction(){
		return 20;
	}
	//*************************************************************
	/********** get_delay_update_password Function ****************
	** - Retourne le delai en JOURS pour la procédure
	** - de changement automatique de mot de passe
	**************************************************************/
	function get_delay_update_password(){
		return 180;
	}
	//*************************************************************
	/**************** encode_password Function ********************
	** - Encode un string avec bCrypt
	* @param: $password
	**************************************************************/
	function encode_password($password){
		$options = array('cost' => 5);
		$options = array();
		return password_hash($password, PASSWORD_BCRYPT);
	}