<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Etablissement_controller extends CI_Controller {
		//***********************************************************
		//************************ FONCTIONS ************************
		//***********************************************************
		/**
		 * index function -*-*-*-*-*
		 * - Récupère les données des etablissements
		 * - Charge la vue tableau des etablissements [array_etablissements_view] avec les données associées
		 */
		public function index(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Etablissement_model"));
			//** Chargement Données **
			$data['etablissements'] = $this->Etablissement_model->get_array_etablissements_infos();
			//** Chargement Vue **
			admin_view_loader($this, "administration/arrays/array_etablissements_view", $data);
		}
		/**
		 * insert_entry function
		 * - Vérifie la conformité des informations saisies
		 * - Appel la methode insert_etablissement du modele etablissement si passage de la validation
		 * - Charge la vue tableau des etablissements [array_etablissements_view] avec le resultat de l'operation
		 */
		public function insert_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Etablissement_model"));
			//*** LOADING VALIDATION RULES ***
			load_form_insert_etablissement_rules($this);
			if ($this->form_validation->run() == FALSE){
				//** Redirection vers le formulaire
                admin_view_loader($this, "administration/forms/new_etablissement_form", null);
            }else{
                //** Appel Méthode d'Insertion **
				if($this->Etablissement_model->insert_etablissement()){
					$this->session->set_flashdata('info', "Etablissement ajouté avec succès");
				}else{
					$this->session->set_flashdata('error', "Erreur lors de l'ajout de l'etablissement");
				}
				redirect('administration/etablissement_controller', 'refresh');
            }
		}
		/**
		 * update_entry function
		 * - Vérifie la conformité des informations saisies
		 * - Appel la methode update_etablissement du modele etablissement si passage de la validation
		 * - Charge la vue tableau des etablissements [array_etablissements_view] avec le resultat de l'operation
		 */
		public function update_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Etablissement_model"));
			if($this->uri->segment(4)){
				//** Récupération Paramétre **
				$id_etablissement = $this->uri->segment(4);
				//** Appel Méthode get_etablissement **
				$data['etablissement'] = $this->Etablissement_model->get_etablissement_by_parameter($id_etablissement);
			}else{
				//** Appel Méthode get_etablissement **
				$data['etablissement'] = $this->Etablissement_model->get_etablissement();
			}
			//*** LOADING VALIDATION RULES ***
			load_form_update_etablissement_rules($this);
			if ($this->form_validation->run() == FALSE){
				//** Redirection vers le formulaire
                admin_view_loader($this, "administration/forms/update_etablissement_form", $data);
            }else{
                //** Appel Méthode de modification **
				if($this->Etablissement_model->update_etablissement()){
					$this->session->set_flashdata('info', "Etablissement modifié avec succès");
				}else{
					$this->session->set_flashdata('error', "Erreur lors de la modification de l'etablissement");
				}
				redirect('administration/etablissement_controller', 'refresh');
            }
		}
		/**
		 * delete_entry function
		 * - Appel la methode delete_etablissement du modele etablissement_model avec l'id etablissement en post
		 * - Charge la vue tableau des etablissements [array_etablissements_view] avec le resultat de l'operation
		 */
		public function delete_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Etablissement_model", "Service_model"));
			//** Verification des dépendances scaners **
			if($this->Service_model->dependance_services_etablissement($this->input->post('id_etablissement'))){
				//** Appel Méthode de Suppression **
				if($this->Etablissement_model->delete_etablissement()){
					$this->session->set_flashdata('info', "Etablissement supprimé avec succès");
				}else{
					$this->session->set_flashdata('error', "Erreur lors de la suppression de l'etablissement");
				}
			}else{
				$this->session->set_flashdata('error', "Il existe des dépendances de services à cet etablissement, vous ne pouvez pas le supprimer");
			}
			redirect('administration/etablissement_controller', 'refresh');
		}
		/**
		 * verification_source function callback
		 * - Vérifie si un établiseement peut-être inséré ou mis à jour avec le statut source = 1
		 */
		public function verification_source(){
			if($this->input->post('source') == 1){
				//*** LOADING MODELS ***
				models_loader($this, array("Etablissement_model"));
				$response = $this->Etablissement_model->verification_etablissement_source($this->input->post('id_etablissement'));
				//var_dump($response);
				if ($response){
	                $this->form_validation->set_message('verification_source', 'Un Etablissement est déjà référencé comme étant Source ['.$response[0]->libelle.']');
	                return FALSE;
	            }else{
	                return TRUE;
	            }
	        }else{
	        	return TRUE;
	        }
		}
	}