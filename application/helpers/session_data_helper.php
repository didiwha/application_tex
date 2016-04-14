<?php
	/***************************************************
	****************************************************
	* HELPER D'INTERACTION AVEC LES DONNEES EN SESSION *
	****************************************************
	***************************************************/
	/**********************************
	****** GESTION NOMS VARIABLES *****
	**********************************/
	function get_logged_in_var_libelle(){
		return 'logged_in';
	}
	function get_poste_var_libelle(){
		return 'poste';
	}
	function get_statut_id_var_libelle(){
		return 'statut_id';
	}
	function get_default_scaner_var_libelle(){
		return 'default_scaner';
	}
	/* ----- Tableaux des habilitations aux fonctions ----- */
	function get_fonctions_array_var_libelle(){
		return 'fonctions_array';
	}
	/* ----- Tableaux des habilitations aux scaners ----- */
	function get_scaners_array_var_libelle(){
		return 'scaners_array';
	}
	/* ----- Tableaux des habilitations aux services ----- */
	function get_services_array_var_libelle(){
		return 'services_array';
	}
	/* ----- Tableaux des habilitations aux etablissements ----- */
	function get_etablissements_array_var_libelle(){
		return 'etablissements_array';
	}
	//**************************************************
	//************ GESTION DES FILTRES *****************
	//**************************************************
	/* ----- Tableaux des filtres fonctions tracabilité ----- */
	function get_tracability_filters_array_var_libelle(){
		return 'filters_tracability';
	}
	/* ----- Tableaux des filtres fonctions horodateur ----- */
	function get_horodateur_filters_array_var_libelle(){
		return 'filters_horodateur';
	}
	/* ----- Filtre Date fonction Tracabilité ----- */
	function get_tracability_filter_date_var_libelle(){
		return 'date';
	}
	/* ----- Filtre Scaner_id fonction Tracabilité ----- */
	function get_tracability_filter_scaner_id_var_libelle(){
		return 'scaner_id';
	}
	/* ----- Filtre Scaner_libelle fonction Tracabilité ----- */
	function get_tracability_filter_scaner_libelle_var_libelle(){
		return 'scaner_libelle';
	}
	/* ----- Filtre Scaner_libelle fonction Tracabilité ----- */
	function get_horodateur_filter_horodatage_type_var_libelle(){
		return 'horodatage_type';
	}

	//*************************************************************
	/*********** update_session_userdata Function *******************
	** - Permet d'ajouter des données en session
	* @param: $controller -> Controller courant lors de l'appel
	* @param: $var_libelle -> Nom de la variable en session
	* @param: $data -> Données associées à la variable
	**************************************************************/
	function update_session_userdata($controller, $var_libelle, $data){
		try{
			$controller->session->set_userdata(array($var_libelle => $data));
		}catch(Exception $e){
			return $e;
		}
	}
	//*************************************************************
	/*********** get_session_logged_in Function *******************
	** - Retourne la valeur du logged in de la session courante
	**************************************************************/
	function get_session_logged_in($controller){
		return $controller->session->userdata(get_logged_in_var_libelle());
	}
	//*************************************************************
	/*********** get_session_user_poste Function ******************
	** - Retourne le poste de l'utilisateur de la session courante
	**************************************************************/
	function get_session_user_poste($controller){
		return $controller->session->userdata(get_poste_var_libelle());
	}
	//*************************************************************
	/********** get_session_user_statut_id Function ***************
	* - Retourne l'id statut de l'utilisateur de la session courante
	**************************************************************/
	function get_session_user_statut_id($controller){
		return $controller->session->userdata(get_statut_id_var_libelle());
	}
	//*************************************************************
	/******* get_session_default_scaner_array Function ************
	** - Retourne le scaner par défaut de la session courante
	**************************************************************/
	function get_session_default_scaner_array($controller){
		return $controller->session->userdata[get_default_scaner_var_libelle()];
	}
	//*************************************************************
	/******** get_session_user_fonctions_array Function ***********
	* - Retourne le tableau des habilitations fonctions 
	* - de l'utilisateur de la session courante
	**************************************************************/
	function get_session_user_fonctions_array($controller){
		return $controller->session->userdata[get_fonctions_array_var_libelle()];
	}
	//*************************************************************
	/******** get_session_user_scaners_array Function *************
	* - Retourne le tableau des habilitations scaners 
	* - de l'utilisateur de la session courante
	**************************************************************/
	function get_session_user_scaners_array($controller){
		return $controller->session->userdata[get_scaners_array_var_libelle()];
	}
	//*************************************************************
	/******** get_session_user_services_array Function ************
	* - Retourne le tableau des habilitations services 
	* - de l'utilisateur de la session courante
	**************************************************************/
	function get_session_user_services_array($controller){
		return $controller->session->userdata[get_services_array_var_libelle()];
	}
	//*************************************************************
	/****** get_session_user_etablissements_array Function ********
	* - Retourne le tableau des habilitations services 
	* - de l'utilisateur de la session courante
	**************************************************************/
	function get_session_user_etablissements_array($controller){
		return $controller->session->userdata[get_etablissements_array_var_libelle()];
	}
	//*************************************************************
	/******** get_session_default_scaner_id Function **************
	** - Retourne l'id du scaner par défaut de la session courante
	**************************************************************/
	function get_session_default_scaner_id($controller){
		if(!empty($controller->session->userdata[get_default_scaner_var_libelle()])){
			return $controller->session->userdata[get_default_scaner_var_libelle()][0]->id;
		}else{
			return false;
		}
	}
	//*************************************************************
	/******** get_session_default_scaner_libelle Function *********
	** - Retourne l'id du scaner par défaut de la session courante
	**************************************************************/
	function get_session_default_scaner_libelle($controller){
		if(!empty($controller->session->userdata[get_default_scaner_var_libelle()])){
			return $controller->session->userdata[get_default_scaner_var_libelle()][0]->libelle;
		}else{
			return false;
		}
	}
	//*************************************************************
	/****** get_session_tracability_filters_array Function ********
	** - Retourne le tableau des filtres de la fonction tracabilité
	**************************************************************/
	function get_session_tracability_filters_array($controller){
		return $controller->session->userdata[get_tracability_filters_array_var_libelle()];
	}
	//*************************************************************
	/******* get_session_horodateur_filters_array Function ********
	** - Retourne le tableau des filtres de la fonction horodateur
	**************************************************************/
	function get_session_horodateur_filters_array($controller){
		return $controller->session->userdata[get_horodateur_filters_array_var_libelle()];
	}
	//*************************************************************
	/******** get_session_tracability_filter_date Function ********
	** - Retourne le filtre date de la fonction tracabilité *******
	**************************************************************/
	function get_session_tracability_filter_date($controller){
		return $controller->session->userdata[get_tracability_filters_array_var_libelle()][get_tracability_filter_date_var_libelle()];
	}
	//*************************************************************
	/******** get_session_tracability_filter_scaner_id Function ***
	** - Retourne le filtre scaner id de la fonction tracabilité **
	**************************************************************/
	function get_session_tracability_filter_scaner_id($controller){
		return $controller->session->userdata[get_tracability_filters_array_var_libelle()][get_tracability_filter_scaner_id_var_libelle()];
	}
	//*************************************************************
	/** get_session_tracability_filter_scaner_libelle Function ****
	*- Retourne le filtre scaner libellé de la fonction tracabilité
	**************************************************************/
	function get_session_tracability_filter_scaner_libelle($controller){
		return $controller->session->userdata[get_tracability_filters_array_var_libelle()][get_tracability_filter_scaner_libelle_var_libelle()];
	}
	//*************************************************************
	/** get_session_horodateur_filter_horodatage_type Function ****
	*- Retourne le filtre scaner libellé de la fonction tracabilité
	**************************************************************/
	function get_session_horodateur_filter_horodatage_type($controller){
		return $controller->session->userdata[get_horodateur_filters_array_var_libelle()][get_horodateur_filter_horodatage_type_var_libelle()];
	}

	//*************************************************************
	/******** construct_tracability_filters_array Function ********
	*- Construit le tableau des filtres de la fonction tracabilité 
	*@param: $date
	*@param: $scaner_id
	*@param: $scaner_libelle
	**************************************************************/
	function construct_tracability_filters_array($date, $scaner_id, $scaner_libelle){
		//$tracability_filters = array(get_tracability_filters_array_var_libelle() => array(get_tracability_filter_date_var_libelle() => $date, get_tracability_filter_scaner_id_var_libelle() => $scaner_id, get_tracability_filter_scaner_libelle_var_libelle() => $scaner_libelle));
		$tracability_filters = array(get_tracability_filter_date_var_libelle() => $date, get_tracability_filter_scaner_id_var_libelle() => $scaner_id, get_tracability_filter_scaner_libelle_var_libelle() => $scaner_libelle);
		return $tracability_filters;
	}
	//*************************************************************
	/******** construct_tracability_filters_array Function ********
	*- Construit le tableau des filtres de la fonction horodateur 
	*@param: $horodatage_type
	**************************************************************/
	function construct_horodateur_filters_array($horodatage_type){
		//$horodateur_filters = array(get_horodateur_filters_array_var_libelle() => array(get_horodateur_filter_horodatage_type_var_libelle() => $horodatage_type));
		$horodateur_filters = array(get_horodateur_filter_horodatage_type_var_libelle() => $horodatage_type);
		return $horodateur_filters;
	}



