<?php
	/* -------------------------------------
	* ---------- PATH FONCTIONS ------------
	* ------------------------------------*/
	//**** RESSOURCES ****
	function ressources_images_scaners_path(){
		return FCPATH."ressources/images/scaners/";
	}
	function ressources_images_users_path(){
		return FCPATH."ressources/images/users/";
	}
	function ressources_images_fonctions_path(){
		return FCPATH."ressources/images/fonctions/";
	}
	//**** ASSETS ****
	function assets_files_fonctions_views_path(){
		return APPPATH . "../assets/files_fonctions/views/";
	}
	function assets_javascript_bcrypt_path(){
		return APPPATH . "../assets/javascript/bCrypt/";
	}
	/* -------------------------------------
	* ---------- ROUTE FONCTIONS -----------
	* ------------------------------------*/
	/*********************************
	******* APPLICATION_PATH *********
	* base_url defined in url_helper *
	*********************************/
	function root_route(){
		return base_url();
	}
	/*********************
	**** RACINE STEP *****
	*********************/
	function application_route(){
		return root_route().'application/';
	}
	function assets_route(){
		return root_route().'assets/';
	}
	function ressources_route(){
		return root_route().'ressources/';
	}
	/*********************
	***** FIRST STEP *****
	*********************/
	//**** APPLICATION ****
	function application_controllers_route(){
		return application_route().'controllers/';
	}
	function application_models_route(){
		return application_route().'models/';
	}
	function application_helpers_route(){
		return application_route().'helpers/';
	}
	function application_views_route(){
		return application_route().'views/';
	}
	function application_ressources_route(){
		return application_route().'ressources/';
	}
	//**** ASSETS ****
	function assets_javascript_route(){
		return assets_route().'javascript/';
	}
	function assets_css_route(){
		return assets_route().'css/';
	}
	function assets_images_route(){
		return assets_route().'images/';
	}
	function assets_modules_route(){
		return assets_route().'modules/';
	}
	function assets_sass_route(){
		return assets_route().'sass/';
	}
	//**** RESSOURCES ****
	function ressources_images_route(){
		return ressources_route().'images/';
	}
	/********************
	**** SECOND STEP ****
	********************/
	//**** CONTROLLERS ****
	function controller_administration_route(){
		return application_controllers_route().'administration/';
	}
	//**** VIEWS *****
	function view_administration_route(){
		return application_views_route().'administration/';
	}
	function view_errors_route(){
		return application_views_route().'errors/';
	}
	function view_layouts_route(){
		return application_views_route().'layouts/';
	}
	function view_template_route(){
		return application_views_route().'template/';
	}
	//**** RESSOURCES ****
	function ressources_images_scaners_route(){
		return ressources_images_route().'scaners/';
	}
	function ressources_images_fonctions_route(){
		return ressources_images_route().'fonctions/';
	}
	//**** ASSETS ****
	function assets_images_icones_route(){
		return assets_images_route().'icones/';
	}
	/********************
	**** THIRD STEP *****
	********************/
	//**** JAVASCRIPT BCRYPT ***
	function assets_javascript_bcrypt_route(){
		return assets_javascript_route().'bCrypt/';
	}
	//**** SLIDER PRO ***
	function assets_modules_slider_route(){
		return assets_modules_route().'sliderPro/';
	}
	//**** HTML RESPOND ***
	function assets_modules_respond_route(){
		return assets_modules_route().'respond/';
	}
	//**** DATATABLES ***
	function assets_modules_datatables_route(){
		return assets_modules_route().'dataTables/';
	}
	//**** DATEPICKER ***
	function assets_modules_datepicker_route(){
		return assets_modules_route().'datePicker/';
	}
	//**** DIALOGEFFECTS ***
	function assets_modules_dialogEffects_route(){
		return assets_modules_route().'dialogEffects/';
	}
	//**** BOOTBOX ***
	function assets_modules_bootbox_route(){
		return assets_modules_route().'bootbox/';
	}
	//**** TABSTYLES ***
	function assets_modules_tabStyles_route(){
		return assets_modules_route().'tabStyles/';
	}
	//**** VIEWS ****
	function view_administration_arrays_route(){
		return view_administration_route().'arrays/';
	}
	function view_administration_forms_route(){
		return view_administration_route().'forms/';
	}
?>