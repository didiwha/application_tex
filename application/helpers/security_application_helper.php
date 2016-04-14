<?php
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
		return password_hash($password, PASSWORD_BCRYPT, $options);
	}