<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Tracabilite_controller extends CI_Controller {
		//***********************************************************
		//************************ FONCTIONS ************************
		//***********************************************************
		/**
		 * index function
		 * - Fonction de transition, pouvant gérer des droits
		 */
		public function index(){
			getSession($this);
			//** RECUPERATION DES FLASHDATA APRES LA PREMIERE REDIRECTION **
			$this->session->set_flashdata('info', $this->session->flashdata('info'));
			$this->session->set_flashdata('error', $this->session->flashdata('error'));
			//*** LOADING MODELS ***
			models_loader($this, array("Scaner_model"));
			/********************************* 
			* EVENTUELLE GESTION DES DROITS **
			*/
			/*********************************
			* GESTION DES FILTRES ************
			**** Récupération des posts *****/
			$scaner_id_filter = $this->input->post('scaner_id') ? $this->input->post('scaner_id') : '';
			$date_filter = $this->input->post('date') ? $this->input->post('date') : date('d.m.y');
			if($scaner_id_filter != ''){
				$scaner_libelle_filter = $this->Scaner_model->get_scaner_by_parameter($scaner_id_filter)[0]->libelle;
				/** Mise en session des filtres **/
				update_session_userdata($this, get_filters_array_var_libelle(), construct_tracability_filters_array($date_filter,$scaner_id_filter,$scaner_libelle_filter));
			}
			redirect('fonctions/tracabilite_controller/load_view', 'refresh');
		}
		/**
		 * load_view function
		 * - Charge la vue tracabilité [tracabilite_view]
		 */
		public function load_view(){
			getSession($this);
			$data['filtres'] = [];
			view_loader($this, "template/fonctions/", "tracabilite_view", $data);
		}

		/**
		 * load_data function
		 * - Charge la vue tracabilité avec les information 
		 *  du formulaire de recherche [tracabilite_view]
		 */
		public function load_data(){
			getSession($this);

			//*** LOADING MODELS ***
			models_loader($this, array("Horodateur_model"));
			
			//*******************************
			//*** RECUPERATION PARAMETRES ***
			//*******************************
			$filtre_type = $this->input->post('filtre-type');
			$filtre = $this->input->post('filtre');
			$permission = $this->input->post('permission');
			$date_debut = $this->input->post('date-debut');
			$date_fin = $this->input->post('date-fin');

			//*******************************
			//***** FORMATAGE DATE **********
			//*******************************
			$date_debut_mysql = formate_date_to_datetimeMySQL($date_debut, 1);
			$date_fin_mysql = formate_date_to_datetimeMySQL($date_fin, 2);

			//*******************************
			//*** RECONSTRUCTION POUR VUE ***
			//*******************************
			$data['filtres']['filtre_type'] = $filtre_type;
			$data['filtres']['filtre']['id'] = $filtre;
			$data['filtres']['filtre']['permission'] = $permission;
			$data['filtres']['date_debut'] = $date_debut;
			$data['filtres']['date_fin'] = $date_fin;
			
			//**** RECHERCHE PAR SCANER ****
			if ( $filtre_type == 1 ){
				$data['array_horodatages'] = $this->Horodateur_model->get_horodatages_by_scaner($filtre, $date_debut_mysql, $date_fin_mysql);
			}
			//**** RECHERCHE PAR SERVICE ****
			else if ( $filtre_type == 2){
				$data['array_horodatages'] = $this->Horodateur_model->get_horodatages_by_service($filtre, $date_debut_mysql, $date_fin_mysql);
			}
			//**** RECHERCHE PAR ETABLISSEMENT ****
			else if ( $filtre_type == 3 ){
				$data['array_horodatages'] = $this->Horodateur_model->get_horodatages_by_etablissement($filtre, $date_debut_mysql, $date_fin_mysql);
			}

			view_loader($this, "template/fonctions/", "tracabilite_view", $data);
		}
	}
