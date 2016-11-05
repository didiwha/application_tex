<?php
	//*************************************************************
	/************** models_loader Function ************************
	** - Charge les fichiers associés de la vue dans un tableau
	** - Chaque fichier: Un Type déclaré dans le footer et un Path
	* @param: $view
	**************************************************************/
	function javascript_files_loader($view){
		$files = array();
		$array = array();
		switch ($view) {
			case 'horodateur_view':
				$files = array(
								array('php', assets_files_fonctions_views_path() . 'fonctions_horodateur_view.php')
							  );
				break;
			default:
				break;
		}
		$array['files'] = $files;
		return $array;
	}
	//*************************************************************
	/************** models_loader Function ************************
	** - Charge les models passé en parametres dans un tableau 
	** - de strings
	* @param: $controller
	* @param: $array_models
	**************************************************************/
	function models_loader($controller, $array_models){
		foreach ($array_models as $key => $model){
			$controller->load->model($model);
		}
	}
	//*************************************************************
	/************** admin_view_loader Function ********************
	** - Charge une vue avec header, menu, onglets admin et footer 
	* @param: $controller
	* @param: $view
	* @param: $data
	**************************************************************/
	function admin_view_loader($controller, $view, $data){
		$controller->load->view("layouts/header_layout");
		$controller->load->view("layouts/menu_layout");
		$controller->load->view("layouts/admin_onglets_layout");
		$controller->load->view($view, $data);
		$controller->load->view("layouts/footer_layout");
	}
	//*************************************************************
	/***************** view_home_loader Function ******************
	** - Charge une vue avec header_home et footer 
	* @param: $controller
	* @param: $view
	* @param: $data
	**************************************************************/
	function view_home_loader($controller, $view, $data){
		$controller->load->view("layouts/header_home_layout");
		$controller->load->view($view, $data);
		$controller->load->view('layouts/footer_layout');		
	}
	//*************************************************************
	/***************** view_home_loader Function ******************
	** - Charge une vue avec header_home et footer 
	* @param: $controller
	* @param: $view
	* @param: $data
	**************************************************************/
	function view_portail_loader($controller, $view, $data){
		$controller->load->view("layouts/header_layout");
		$controller->load->view($view, $data);
		$controller->load->view('layouts/footer_layout');		
	}
	//*************************************************************
	/******************* view_loader Function *********************
	** - Charge une vue avec header, menu, footer et fichiers js
	* @param: $controller
	* @param: $path
	* @param: $view
	* @param: $data
	**************************************************************/
	function view_loader($controller, $path, $view, $data){
		$controller->load->view("layouts/header_layout");
		$controller->load->view("layouts/menu_layout");
		$controller->load->view($path . $view, $data);
		$controller->load->view("layouts/footer_layout", javascript_files_loader($view));
	}
	//*************************************************************
	/********* get_config_uploading_image_scaner Function *********
	** - Charge les parametres de configuration pour l'upload 
	** - d'une image de scaner
	* @param: $scaner_id
	**************************************************************/
	function get_config_uploading_image_scaner($scaner_id){
		$config['upload_path']    = ressources_images_scaners_path();
        $config['allowed_types']  = 'gif|jpg|png|jpeg';
        $config['max_size']       = 1048576;
        $config['max_width']      = 128;
        $config['max_height']     = 128;
        $config['file_name']      = "image_scaner_".$scaner_id.".png";
        return $config;
	}
	//*************************************************************
	/********* load_form_insert_user_rules Function ***************
	** - Charge les regles de validation du formulaire d'insertion 
	** - d'un user 
	* @param: $controller
	**************************************************************/
	function load_form_insert_user_rules($controller){
		$controller->form_validation->set_rules('poste', 'Poste', array('required',
														                array('poste_unicity', 
													                			array($controller->User_model, 'check_poste_unicity'))
																        )
																);
		$controller->form_validation->set_message('poste_unicity', 'The {field} field should be unique');
		$controller->form_validation->set_rules('password', 'Password', 'required|trim|min_length[2]|xss_clean');
		$controller->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'required|matches[password]');
		$controller->form_validation->set_rules('statut_id', 'Statut', 'required');
		$controller->form_validation->set_rules('etablissement_id', 'Etablissement', 'required');
		$controller->form_validation->set_rules('service_id', 'Service', 'required');
		$controller->form_validation->set_rules('email', 'Email', 'required');
		$controller->form_validation->set_rules('account_type_id', 'Type Account', 'required');
		return $controller;
	}
	//*************************************************************
	/********* load_form_update_user_rules Function ***************
	** - Charge les regles de validation du formulaire de mise
	** - a jour d'un user 
	* @param: $controller
	**************************************************************/
	function load_form_update_user_rules($controller){
		$controller->form_validation->set_rules('poste', 'Poste', 'required');
		$controller->form_validation->set_rules('poste', 'Poste', array('required',
														                array('poste_unicity', 
													                			array($controller->User_model, 'check_poste_unicity_update'))
																        )
																);
		$controller->form_validation->set_message('poste_unicity', 'The {field} field should be unique');
		$controller->form_validation->set_rules('password','Password','trim|min_length[2]|xss_clean|matches[password_confirmation]');
		$controller->form_validation->set_rules('password_confirmation','Password Confirmation','trim|xss_clean');
		$controller->form_validation->set_rules('statut_id', 'Statut', 'required');
		$controller->form_validation->set_rules('etablissement_id', 'Etablissement', 'required');
		$controller->form_validation->set_rules('service_id', 'Service', 'required');
		$controller->form_validation->set_rules('email', 'Email', 'required');
		$controller->form_validation->set_rules('account_type_id', 'Type Account', 'required');
		return $controller;
	}
	//*************************************************************
	/******* load_form_insert_etablissement_rules Function ********
	** - Charge les regles de validation du formulaire d'insertion 
	** - d'un etablissement 
	* @param: $controller
	**************************************************************/
	function load_form_insert_etablissement_rules($controller){
		$controller->form_validation->set_rules('libelle', 'Libelle', 'required');
		$controller->form_validation->set_rules('libelle_short', 'Libelle Short', 'required|min_length[3]|max_length[4]');
		$controller->form_validation->set_rules('code', 'Code', 'required');
		$controller->form_validation->set_rules('telephone', 'Telephone', 'required|regex_match[/[0-9]{10}/]');
		$controller->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$controller->form_validation->set_rules('adresse', 'Adresse', 'required');
		$controller->form_validation->set_rules('code_postal', 'Code Postal', 'required|regex_match[/[0-9]{5}/]');
		$controller->form_validation->set_rules('ville', 'Ville', 'required');
		$controller->form_validation->set_rules('source', 'Source', 'callback_verification_source');
		return $controller;
	}
	//*************************************************************
	/******* load_form_update_etablissement_rules Function ********
	** - Charge les regles de validation du formulaire de mise
	** - a jour d'un etablissement 
	* @param: $controller
	**************************************************************/
	function load_form_update_etablissement_rules($controller){
		$controller->form_validation->set_rules('libelle', 'Libelle', 'required');
		$controller->form_validation->set_rules('libelle_short', 'Libelle Short', 'required|min_length[3]|max_length[4]');
		$controller->form_validation->set_rules('code', 'Code', 'required');
		$controller->form_validation->set_rules('telephone', 'Telephone', 'required|regex_match[/[0-9]{10}/]');
		$controller->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$controller->form_validation->set_rules('adresse', 'Adresse', 'required');
		$controller->form_validation->set_rules('code_postal', 'Code_postal', 'required|regex_match[/[0-9]{5}/]');
		$controller->form_validation->set_rules('ville', 'Ville', 'required');
		$controller->form_validation->set_rules('source', 'Source', 'callback_verification_source');
		return $controller;
	}
	//*************************************************************
	/*********** load_form_insert_service_rules Function *********
	** - Charge les regles de validation du formulaire d'insertion 
	** - d'un service 
	* @param: $controller
	**************************************************************/
	function load_form_insert_service_rules($controller){
		$controller->form_validation->set_rules('etablissement_id', 'Etablissement', 'required');
		$controller->form_validation->set_rules('libelle', 'Libelle', 'required');
		$controller->form_validation->set_rules('libelle_short', 'Libelle Short', 'required|min_length[3]|max_length[4]');
		$controller->form_validation->set_rules('code_correspondant', 'Code_correspondant', '');
		$controller->form_validation->set_rules('service_cible_id', 'Service Cible', 'required');
		return $controller;
	}
	//*************************************************************
	/*********** load_form_update_service_rules Function **********
	** - Charge les regles de validation du formulaire de mise
	** - a jour d'un service 
	* @param: $controller
	**************************************************************/
	function load_form_update_service_rules($controller){
		$controller->form_validation->set_rules('etablissement_id', 'Etablissement', 'required');
		$controller->form_validation->set_rules('libelle', 'Libelle', 'required');
		$controller->form_validation->set_rules('libelle_short', 'Libelle Short', 'required|min_length[3]|max_length[4]');
		$controller->form_validation->set_rules('code_correspondant', 'Code Correspondant', '');
		$controller->form_validation->set_rules('service_cible_id', 'Service Cible', 'required');
		return $controller;
	}
	//*************************************************************
	/*********** load_form_insert_scaner_rules Function ***********
	** - Charge les regles de validation du formulaire d'insertion 
	** - d'un scaner 
	* @param: $controller
	**************************************************************/
	function load_form_insert_scaner_rules($controller){
		$controller->form_validation->set_rules('etablissement_id', 'Etablissement', 'required');
		$controller->form_validation->set_rules('service_id', 'Service', 'required');
		$controller->form_validation->set_rules('libelle', 'Libelle', 'required');
		$controller->form_validation->set_rules('libelle_short', 'Libelle Short', 'required|min_length[3]|max_length[4]');
		return $controller;
	}
	//*************************************************************
	/*********** load_form_update_scaner_rules Function ***********
	** - Charge les regles de validation du formulaire de mise
	** - a jour d'un scaner 
	* @param: $controller
	**************************************************************/
	function load_form_update_scaner_rules($controller){
		$controller->form_validation->set_rules('etablissement_id', 'Etablissement', 'required');
		$controller->form_validation->set_rules('service_id', 'Service', 'required');
		$controller->form_validation->set_rules('libelle', 'Libelle', 'required');
		$controller->form_validation->set_rules('libelle_short', 'Libelle Short', 'required|min_length[3]|max_length[4]');
		return $controller;
	}
	//*************************************************************
	/*********** load_form_update_scaner_rules Function ***********
	** - Charge les regles de validation du formulaire d'insertion
	** - d'un scan
	* @param: $controller
	**************************************************************/
	function load_form_insert_scan_rules($controller){
		$controller->form_validation->set_rules('numero', 'Numero', 'required');
		return $controller;
	}
?>