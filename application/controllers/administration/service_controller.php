<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Service_controller extends CI_Controller {
		//***********************************************************
		//************************ FONCTIONS ************************
		//***********************************************************
		/**
		 * index function
		 * - Récupère les données des services
		 * - Charge la vue tableau des services [array_services_view] avec les données associées
		 */
		public function index(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Service_model"));
			//** Chargement Données **
			$data['services'] = $this->Service_model->get_array_services_infos();
			//** Chargement Vue **
			admin_view_loader($this, "administration/arrays/array_services_view", $data);
		}
		/**
		 * insert_entry function
		 * - Appel la methode insert_service du modele service avec les informations du post
		 * - Charge la vue tableau des etablissements [array_etablissements_view] avec le resultat de l'operation
		 */
		public function insert_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Etablissement_model","Service_model"));
			//** Chargement Données **
			$data['services_cible'] = $this->Service_model->get_services_cible();
			$data['etablissements'] = $this->Etablissement_model->get_etablissements_main_infos();
			//*** LOADING VALIDATION RULES ***
			load_form_insert_service_rules($this);
			if ($this->form_validation->run() == FALSE){
				//** Redirection vers le formulaire
                admin_view_loader($this, "administration/forms/new_service_form", $data);
            }else{
                //** Appel Méthode d'Insertion **
				if($this->Service_model->insert_service()){
					$this->session->set_flashdata('info', "Service ajouté avec succès");
				}else{
					$this->session->set_flashdata('error', "Erreur lors de l'ajout du service");
				}
				redirect('administration/service_controller', 'refresh');
            }
		}
		/**
		 * update_entry function
		 * - Vérifie la conformité des informations saisies
		 * - Appel la methode update_service du modele service si passage de la validation
		 * - Charge la vue tableau des services [array_services_view] avec le resultat de l'operation
		 */
		public function update_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Etablissement_model","Service_model"));
			//** Chargement Données **
			$data['services_cible'] = $this->Service_model->get_services_cible();
			$data['etablissements'] = $this->Etablissement_model->get_etablissements_main_infos();
			if($this->uri->segment(4)){
				//** Récupération Paramétre **
				$id_service = $this->uri->segment(4);
				//** Appel Méthode get_service_by_parameter **
				$data['service'] = $this->Service_model->get_service_by_parameter($id_service);
			}else{
				//** Appel Méthode get_etablissement **
				$data['service'] = $this->Service_model->get_service();
			}
			//*** LOADING VALIDATION RULES ***
			load_form_update_service_rules($this);
			if ($this->form_validation->run() == FALSE){
				//** Redirection vers le formulaire
                admin_view_loader($this, "administration/forms/update_service_form", $data);
            }else{
                //** Appel Méthode de modification **
				if($this->Service_model->update_service()){
					$this->session->set_flashdata('info', "Service modifié avec succès");
				}else{
					$this->session->set_flashdata('error', "Erreur lors de la modification du service");
				}
				redirect('administration/service_controller', 'refresh');
            }
		}
		/**
		 * delete_entry function
		 * - Appel la methode delete_service du modele service_model avec l'id service en post
		 * - Charge la vue tableau des services [array_services_view] avec le resultat de l'operation
		 */
		public function delete_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Service_model", "Scaner_model"));
			//** Verification des dépendances scaners **
			if($this->Scaner_model->dependance_scaners_service($this->input->post('id_service'))){
				//** Appel Méthode de Suppression **
				if($this->Service_model->delete_service()){
					$this->session->set_flashdata('info', "Service supprimé avec succès");
				}else{
					$this->session->set_flashdata('error', "Erreur lors de la suppression du service");
				}
			}else{
				$this->session->set_flashdata('error', "Il existe des dépendances de scaners à ce service, vous ne pouvez pas le supprimer");
			}
			redirect('administration/service_controller', 'refresh');
		}
	}
