<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Horodateur_controller extends CI_Controller {
		//***********************************************************
		//************************ FONCTIONS ************************
		//***********************************************************
		/**
		 * index function
		 * - Fonction de transition, pouvant gérer des droits
		 * - Récupère et transfère les flashdata
		 */
		public function index(){
			getSession($this);
			//** RECUPERATION DES FLASHDATA APRES LA PREMIERE REDIRECTION **
			$this->session->set_flashdata('info', $this->session->flashdata('info'));
			$this->session->set_flashdata('error', $this->session->flashdata('error'));
			/********************************* 
			* EVENTUELLE GESTION DES DROITS **
			*/
			/*********************************
			* GESTION DES FILTRES ************
			**** Récupération des posts *****/
			$horodatage_type = $this->input->post('horodatage_type') ? $this->input->post('horodatage_type') : '';
			if($horodatage_type != ''){
				/** Mise en session des filtres **/
				update_session_userdata($this, get_horodateur_filters_array_var_libelle(), construct_horodateur_filters_array($horodatage_type));
			}
			redirect('fonctions/horodateur_controller/load_view', 'refresh');
		}
		/**
		 * load_view function
		 * - Charge la vue accueil [home_view]
		 */
		public function load_view(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Horodateur_model", "Default_data_model"));
			//** Chargement Données **
			if(!empty(get_session_default_scaner_id($this))){
				$data['scans'] = $this->Horodateur_model->get_horodatages_by_scaner(get_session_default_scaner_id($this));
				$data['default_commentaires'] = $this->Default_data_model->get_default_comments_by_scaner(get_session_default_scaner_id($this));
				$data['horodatage_types'] = $this->data_location->get_horodatage_types();
			}
			//** TEST SUIVI NUMERO **
			$data['suiviNumero'] = $this->Horodateur_model->get_suivi_by_numero(98989898);
			view_loader($this, "template/fonctions/", "horodateur_view", $data);
		}
		/**
		 * insert_entry function
		 * - Vérifie la conformité des informations saisies
		 * - Appel la methode insert_scan du modele horodateur si passage de la validation
		 * - Charge la vue des scans [horodateur_view] avec le resultat de l'operation
		 */
		public function insert_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Horodateur_model"));
			//** Chargement Données **
			$data['scans'] = $this->Horodateur_model->get_horodatages_by_scaner(get_session_default_scaner_id($this));
			//*** LOADING VALIDATION RULES ***
			load_form_insert_scan_rules($this);
			if ($this->form_validation->run() == FALSE){
				//** Redirection vers le formulaire
                view_loader($this, "template/fonctions/", "horodateur_view", $data);
            }else{
                //** Appel Méthode d'Insertion **
				if($this->Horodateur_model->insert_scan()){
					$this->session->set_flashdata('info', "Scan enregistré");
				}else{
					$this->session->set_flashdata('error', "Erreur lors de l'enregistrement du scan");
				}
				redirect('fonctions/horodateur_controller', 'refresh');
            }
		}
		/**
		 * update_commentaire function
		 * - Vérifie la conformité des informations saisies
		 * - Appel la methode update_commentaire du modele horodateur
		 * - Charge la vue des scans [horodateur_view] avec le resultat de l'operation
		 */
		public function update_commentaire(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Horodateur_model"));
			//** Chargement Données **
			$data['scans'] = $this->Horodateur_model->get_horodatages_by_scaner(get_session_default_scaner_id($this));
			//** Appel Méthode de Suppression **
			if($this->Horodateur_model->update_commentaire()){
				$this->session->set_flashdata('info', "Commentaire modifié avec succès !");
			}else{
				$this->session->set_flashdata('error', "Erreur lors de la modification du commentaire");
			}
			redirect('fonctions/horodateur_controller', 'refresh');
		}
		/**
		 * delete_entry function
		 * - Appel la methode delete_etablissement du modele etablissement_model avec l'id etablissement en post
		 * - Charge la vue tableau des etablissements [array_etablissements_view] avec le resultat de l'operation
		 */
		public function delete_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Horodateur_model"));
			//** Chargement Données **
			$data['scans'] = $this->Horodateur_model->get_horodatages_by_scaner(get_session_default_scaner_id($this));
			//** Appel Méthode de Suppression **
			if($this->Horodateur_model->delete_scan()){
				$this->session->set_flashdata('info', "Scan supprimé avec succès");
			}else{
				$this->session->set_flashdata('error', "Erreur lors de la suppression du scan");
			}
			redirect('fonctions/horodateur_controller', 'refresh');
		}
		/**
		 * update_default_scaner function
		 * - Modifie la variable session default_scaner de la session courante
		 * - Charge la vue des scans [horodateur_view] avec le resultat de l'operation
		 */
		public function update_default_scaner(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Horodateur_model", "Scaner_model"));
			//** Appel Méthode de mise à jour de la variable session defaut_scaner **
			try{
				update_session_userdata($this, get_default_scaner_var_libelle(), $this->Scaner_model->get_scaner_by_parameter($this->input->post("scaner")));
				$this->session->set_flashdata('info', "Modification du scaner par défaut pour la session courante");
			}catch(Exception $e){
				$this->session->set_flashdata('error', "Erreur lors de la modification du du scaner par défaut de la session courante: ".$e->getMessage());
			}
			//** Chargement Données **
			$data['scans'] = $this->Horodateur_model->get_horodatages_by_scaner(get_session_default_scaner_id($this));
			redirect('fonctions/horodateur_controller', 'refresh');
		}
		/**
		 * add_default_comment function
		 * - Ajoute un commentaire par défaut par le scaner courant
		 * - Charge la vue des scans [horodateur_view] avec le resultat de l'operation
		 */
		public function add_default_comment(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Horodateur_model", "Default_data_model"));
			//** Chargement Données **
			$data['scans'] = $this->Horodateur_model->get_horodatages_by_scaner(get_session_default_scaner_id($this));
			//** Appel Méthode de Suppression **
			if($this->Default_data_model->insert_default_comment_by_scaner($this->input->post("scaner_id"), $this->input->post("commentaire"))){
				$this->session->set_flashdata('info', "Commentaire par défaut ajouté avec succès");
			}else{
				$this->session->set_flashdata('error', "Erreur lors de l'ajout du commentaire par défaut");
			}
			redirect('fonctions/horodateur_controller', 'refresh');
		}
		/**
		 * del_default_comment function
		 * - Supprime un commentaire par défaut pour le scaner courant
		 * - Charge la vue des scans [horodateur_view] avec le resultat de l'operation
		 */
		public function del_default_comment(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Horodateur_model", "Default_data_model"));
			//** Chargement Données **
			$data['scans'] = $this->Horodateur_model->get_horodatages_by_scaner(get_session_default_scaner_id($this));
			//** Appel Méthode de Suppression **
			if($this->Default_data_model->delete_default_comment_by_scaner($this->input->post("commentaire_id"))){
				$this->session->set_flashdata('info', "Commentaire par défaut supprimé avec succès");
			}else{
				$this->session->set_flashdata('error', "Erreur lors de la suppression du commentaire par défaut");
			}
			redirect('fonctions/horodateur_controller', 'refresh');
		}
	}
