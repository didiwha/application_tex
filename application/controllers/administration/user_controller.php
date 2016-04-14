<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class User_controller extends CI_Controller {
		//***********************************************************
		//************************ FONCTIONS ************************
		//***********************************************************
		/**
		 * index function
		 * - Récupère les données des users
		 * - Charge la vue tableau des users [array_users_view] avec les données associées
		 */
		public function index(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("User_model"));
			//** Chargement Données **
			$data['users'] = $this->User_model->get_array_users_infos();
			//** Chargement Vue **
			admin_view_loader($this, "administration/arrays/array_users_view", $data);
		}
		/**
		 * insert_entry function
		 * - Appel la methode insert_user du modele user avec les informations du post
		 * - Charge la vue tableau des users [array_users_view] avec le resultat de l'operation
		 */
		public function insert_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Etablissement_model", "Service_model", "Scaner_model", "User_model", "Fonction_model", "Habilitations_model"));
			//** Chargement Données **
			$data['etablissements'] = $this->Etablissement_model->get_etablissements_main_infos();
			$data['services'] = $this->Service_model->get_services_main_infos();
			$data['scaners'] = $this->Scaner_model->get_scaners_main_infos();
			//$data['statuts'] = $this->Default_data_model->get_user_statuts();
			$data['statuts'] = $this->data_location->get_user_statuts();
			//$data['account_types'] = $this->Default_data_model->get_user_account_types();
			$data['account_types'] = $this->data_location->get_user_account_types();
			$data['fonctions'] = $this->Fonction_model->get_all_fonctions();
			//*** LOADING VALIDATION RULES ***
			load_form_insert_user_rules($this);
			if ($this->form_validation->run() == FALSE){
				//** Redirection vers le formulaire
                admin_view_loader($this, "administration/forms/new_user_form", $data);
            }else{
            	//** Appel Méthode d'Insertion // Récupération id du user **
				if($last_id = $this->User_model->insert_user()){
					if ($this->Habilitations_model->add_hab_fonctions_by_user($last_id)){
						if ($this->Habilitations_model->add_hab_scaners_by_user($last_id)){
							if ($this->Habilitations_model->add_hab_services_by_user($last_id)){
								if ($this->Habilitations_model->add_hab_etablissements_by_user($last_id)){
									$this->session->set_flashdata('info', "User ajouté avec succès");
								}else{
									$this->session->set_flashdata('error', "Erreur lors de la création des habilitations etablissements du user");
								}
							}else{
								$this->session->set_flashdata('error', "Erreur lors de la création des habilitations services du user");
							}
						}else{
							$this->session->set_flashdata('error', "Erreur lors de la création des habilitations scaners du user");
						}
					}else{
						$this->session->set_flashdata('error', "Erreur lors de la création des habilitations fonctions du user");
					}
				}else{
					$this->session->set_flashdata('error', "Erreur lors de l'ajout du user");
				}
				redirect('administration/user_controller', 'refresh');
            }
		}
		/**
		 * update_entry function
		 * - Appel la methode update_user du modele user_model avec les informations postées
		 * - Charge la vue tableau des users [array_users_view] avec le resultat de l'operation
		 */
		public function update_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Etablissement_model", "Service_model", "Scaner_model", "User_model","Habilitations_model"));
			//** Chargement Données **
			$data['etablissements'] = $this->Etablissement_model->get_etablissements_main_infos();
			$data['services'] = $this->Service_model->get_services_main_infos();
			$data['statuts'] = $this->data_location->get_user_statuts();
			$data['account_types'] = $this->data_location->get_user_account_types();
			if($this->uri->segment(4)){
				//** Récupération Paramétre **
				$id_user = $this->uri->segment(4);
				//** Appel Méthode get_user_by_parameter **
				$data['user'] = $this->User_model->get_user_by_parameter($id_user);
				$data['fonctions'] = $this->Habilitations_model->get_fonctions_and_hab_by_user($id_user);
				$data['scaners_habilitations'] = $this->Habilitations_model->get_scaners_and_hab_by_user($id_user);
				$data['services_habilitations'] = $this->Habilitations_model->get_services_and_hab_by_user($id_user);
				$data['etablissements_habilitations'] = $this->Habilitations_model->get_etablissements_and_hab_by_user($id_user);
			}else{
				//** Récupération Paramétre **
				$id_user = $this->input->post('id_user');
				//** Appel Méthode get_user **
				$data['user'] = $this->User_model->get_user();
				$data['fonctions'] = $this->Habilitations_model->get_fonctions_and_hab_by_user($id_user);
				$data['scaners_habilitations'] = $this->Habilitations_model->get_scaners_and_hab_by_user($id_user);
				$data['services_habilitations'] = $this->Habilitations_model->get_services_and_hab_by_user($id_user);
				$data['etablissements_habilitations'] = $this->Habilitations_model->get_etablissements_and_hab_by_user($id_user);
			}
			//*** SETTING VALIDATION RULES ***
			load_form_update_user_rules($this);
			if ($this->form_validation->run() == FALSE){
				//** Redirection vers le formulaire
                admin_view_loader($this, "administration/forms/update_user_form", $data);
            }else{
            	//** MISE A JOUR INFORMATIONS **
            	if($this->User_model->update_user()){
            		//** SUPPRESSION HABILITATIONS FONCTIONS **
            		if($this->Habilitations_model->del_hab_fonctions_by_user($id_user)){
            			//** AJOUT NOUVELLES HABILITATIONS FONCTIONS **
            			if($this->Habilitations_model->add_hab_fonctions_by_user($id_user)){
            				//** SUPPRESSION HABILITATIONS SCANERS **
            				if ($this->Habilitations_model->del_hab_scaners_by_user($id_user)) {
            					//** AJOUT NOUVELLES HABILIATIONS SCANERS **
            					if ($this->Habilitations_model->add_hab_scaners_by_user($id_user)) {
            						//** SUPPRESSION HABILITATIONS SERVICES **
            						if ($this->Habilitations_model->del_hab_services_by_user($id_user)) {
            							//** AJOUT NOUVELLES HABILIATIONS SERVICES **
            							if ($this->Habilitations_model->add_hab_services_by_user($id_user)) {
            								//** SUPPRESSION HABILITATIONS ETABLISSEMENTS **
            								if ($this->Habilitations_model->del_hab_etablissements_by_user($id_user)) {
            									//** AJOUT NOUVELLES HABILIATIONS ETABLISSEMENTS **
            									if ($this->Habilitations_model->add_hab_etablissements_by_user($id_user)) {
            										$this->session->set_flashdata('info', "User modifié avec succès");
            									}else{
				            						$this->session->set_flashdata('error', "Erreur lors de la modification des habilitations etablissements du user (Ajout)");
				            					}	
            								}else{
			            						$this->session->set_flashdata('error', "Erreur lors de la modification des habilitations etablissements du user (Suppression)");
			            					}
            							}else{
		            						$this->session->set_flashdata('error', "Erreur lors de la modification des habilitations services du user (Ajout)");
		            					}
            						}else{
	            						$this->session->set_flashdata('error', "Erreur lors de la modification des habilitations services du user (Suppression)");
	            					}
            					}else{
            						$this->session->set_flashdata('error', "Erreur lors de la modification des habilitations scaners du user (Ajout)");
            					}
            				}else{
	            				$this->session->set_flashdata('error', "Erreur lors de la modification des habilitations scaners du user (Suppression)");
            				}
	            		}else{
	            			$this->session->set_flashdata('error', "Erreur lors de la modification des habilitations fonctions du user (Ajout)");
	            		}
            		}else{
            			$this->session->set_flashdata('error', "Erreur lors de la modification des habilitations fonctions du user (Suppression)");
            		}
            		
            	}else{
            		$this->session->set_flashdata('error', "Erreur lors de la modification du user");
            	}
            	redirect('administration/user_controller', 'refresh');
            }
		}
		/**
		 * delete_entry function
		 * - Appel la methode delete_user du modele user_model avec l'id//poste du user en post
		 * - Charge la vue tableau des users [array_users_view] avec le resultat de l'operation
		 */
		public function delete_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("User_model", "Habilitations_model"));
			//** Appel Méthode de Suppression des Habilitations Scaners **
			if($this->Habilitations_model->del_hab_scaners_by_user()){
				//** Appel Méthode de Suppression des Habilitations Services **
				if($this->Habilitations_model->del_hab_services_by_user()){
					//** Appel Méthode de Suppression des Habilitations Etablissements **
					if($this->Habilitations_model->del_hab_etablissements_by_user()){
						//** Appel Méthode de Suppression des Habilitations Fonctions **
						if($this->Habilitations_model->del_hab_fonctions_by_user()){
							//** Appel Méthode de Suppression User **
							if($this->User_model->delete_user()){
								$this->session->set_flashdata('info', "User supprimé avec succès");
							}else{
								$this->session->set_flashdata('error', "Erreur lors de la suppression du user");
							}
						}else{
							$this->session->set_flashdata('error', "Erreur lors de la suppression des habilitations Fonctions du user");
						}
					}else{
						$this->session->set_flashdata('error', "Erreur lors de la suppression des habilitations Etablissements du user");
					}
				}else{
					$this->session->set_flashdata('error', "Erreur lors de la suppression des habilitations Services du user");
				}
			}else{
				$this->session->set_flashdata('error', "Erreur lors de la suppression des habilitations Scaners du user");
			}
			redirect('administration/user_controller', 'refresh');
		}
	}
