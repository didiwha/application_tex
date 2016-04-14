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
		 * index function
		 * - Charge la vue accueil [home_view]
		 */
		public function load_view(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Horodateur_model"));
			$scaner_id = get_session_tracability_filter_scaner_id($this) ? get_session_tracability_filter_scaner_id($this) : get_session_default_scaner_id($this);
			//** Chargement Données **
			$data['scans'] = $this->Horodateur_model->get_scans_by_scaner($scaner_id);
			//** TEST SUIVI NUMERO **
			$data['suiviNumero'] = $this->Horodateur_model->get_suivi_by_numero(98989898);
			view_loader($this, "template/fonctions/tracabilite_view", $data);
		}
	}
