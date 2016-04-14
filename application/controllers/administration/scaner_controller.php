<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Scaner_controller extends CI_Controller {
		//***********************************************************
		//************************ FONCTIONS ************************
		//***********************************************************
		/**
		 * index function
		 * - Récupère les données des scaners
		 * - Charge la vue tableau des users [array_scaners_view] avec les données associées
		 */
		public function index(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Scaner_model"));
			//** Chargement Données **
			$data['scaners'] = $this->Scaner_model->get_array_scaners_infos();
			//** Chargement Vue **
			admin_view_loader($this, "administration/arrays/array_scaners_view", $data);
		}
		/**
		 * insert_entry function
		 * - Appel la methode insert_scaner du modele scaner avec les informations du post
		 * - Tente d'upload l'image du scaner s'il y en a une
		 * - Renomme l'image du scaner en base si l'upload a réussi
		 * - Charge la vue tableau des etablissements [array_scaners_view] avec le resultat de l'operation
		 */
		public function insert_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Etablissement_model", "Service_model", "Scaner_model"));
			//** Chargement Données **
			$data['etablissements'] = $this->Etablissement_model->get_etablissements_main_infos();
			$data['services'] = $this->Service_model->get_services_main_infos();
			//*** LOADING VALIDATION RULES ***
			load_form_insert_scaner_rules($this);
			if ($this->form_validation->run() == FALSE){
				//** Redirection vers le formulaire
                admin_view_loader($this, "administration/forms/new_scaner_form", $data);
            }else{
            	if($this->Scaner_model->insert_scaner()){
            		//*** RECUPERATION DERNIER ID SCANER ***
            		$last_id = $this->Scaner_model->get_last_id();
            		//*** NOMMAGE DE L'IMAGE DU SCANER AVEC SON ID ***
            		$image_name = set_image_scaner_name($last_id);
            		//*** CHARGEMENT CONFIGURATION UPLOADING IMAGE SCANER ***
	                $this->load->library('upload', get_config_uploading_image_scaner($last_id));
	                //*** TENTATIVE D'UPLOAD DE L'IMAGE ***
	                if (!$this->upload->do_upload('image')){
	                	//** SUPPRESSION DU SCANER **
	                	$this->Scaner_model->delete_scaner_param($last_id);
	                	//*** STOCKAGE UPLOAD ERRORS ***
	                	$this->session->set_flashdata('error', $this->upload->display_errors());
	                }else{
	                	//** MODIFICATIONS CHAMP IMAGE TABLE SCANER **
	                	if($this->Scaner_model->update_image_scaner($last_id, $image_name)){
	                		$this->session->set_flashdata('info', "Scaner ajouté avec succès");
	                	}else{
	                		//** SUPPRESSION DU SCANER **
	                		$this->Scaner_model->delete_scaner_param($last_id);
	                		//** SUPPRESSION IMAGE UPLOADED **
	                		delete_file(ressources_images_scaners_path().$image_name);
	                		$this->session->set_flashdata('error', "Erreur lors de l'ajout du scaner/mise a jour image_name");
	                	}
	                }
            	}else{
					$this->session->set_flashdata('error', "Erreur lors de l'ajout du scaner/premiere insertion");
				}
            	redirect('administration/scaner_controller', 'refresh');
            }
		}
		/**
		 * update_entry function
		 * - Appel la methode update_scaner du modele scaner_model avec les informations postées
		 * - Charge la vue tableau des scaners [array_scaners_view] avec le resultat de l'operation
		 */
		public function update_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Etablissement_model", "Service_model", "Scaner_model"));
			//** Chargement Données **
			$data['etablissements'] = $this->Etablissement_model->get_etablissements_main_infos();
			$data['services'] = $this->Service_model->get_services_main_infos();
			if($this->uri->segment(4)){
				//** Récupération Paramétre **
				$id_scaner = $this->uri->segment(4);
				//** Récupération des dépendances du scaner **
				$data['dependances'] = $this->Scaner_model->get_scaner_dependances($id_scaner);
				//** Appel Méthode get_scaner_by_parameter **
				$data['scaner'] = $this->Scaner_model->get_scaner_by_parameter($id_scaner);
			}else{
				//** Récupération des dépendances du scaner **
				$data['dependances'] = $this->Scaner_model->get_scaner_dependances($this->input->post("scaner_id"));
				//** Appel Méthode get_scaner **
				$data['scaner'] = $this->Scaner_model->get_scaner();
			}
			//*** LOADING VALIDATION RULES ***
			load_form_update_scaner_rules($this);
            if ($this->form_validation->run() == FALSE){
				//** Redirection vers le formulaire **
                admin_view_loader($this, "administration/forms/update_scaner_form", $data);
            }else{
            	$scaner_id = $this->input->post('id_scaner');
            	//*** MISE A JOUR DU SCANER ***
            	if($this->Scaner_model->update_scaner()){
            		//*** TEST DU POST D'UNE IMAGE ***
            		if ($_FILES['image']['name'] != ""){
            			//*** RENOMMAGE TEMPORAIRE IMAGE ACTUELLE DU SCANER ***
            			set_temp_image_scaner_name($scaner_id);
	            		//*** CHARGEMENT CONFIGURATION UPLOADING IMAGE SCANER ***
		                $this->load->library('upload', get_config_uploading_image_scaner($scaner_id));
		                if (!$this->upload->do_upload('image')){
		                	//*** RENOMMAGE ANCIENNE IMAGE ***
		                	set_no_temp_image_scaner_name($scaner_id);
		                	//*** STOCKAGE UPLOAD ERRORS ***
		                	$this->session->set_flashdata('error', $this->upload->display_errors());
		                }else{
		                	//** SUPPRESSION IMAGE TEMPORAIRE **
		                	delete_file(ressources_images_scaners_path().get_image_scaner_temp_name($scaner_id));
	                		$this->session->set_flashdata('info', "Scaner modifié avec succès");
		                }
		            }else{
		            	$this->session->set_flashdata('info', "Scaner modifié avec succès");
		            }
            	}else{
					$this->session->set_flashdata('error', "Erreur lors de la modification du scaner");
				}
				redirect('administration/scaner_controller', 'refresh');
            }
		}
		/**
		 * delete_entry function
		 * - Appel la methode delete_scaner du modele scaner_model avec l'id scaner en post
		 * - Charge la vue tableau des scaners [array_scaners_view] avec le resultat de l'operation
		 */
		public function delete_entry(){
			getSession($this);
			//*** LOADING MODELS ***
			models_loader($this, array("Scaner_model", "User_model", "Horodateur_model"));
			//** Verification des dépendances scaners **
			if($this->User_model->dependance_users_scaner()){
				//** Verification des dépendances horodatages **
				if($this->Horodateur_model->dependance_scans_scaner()){
					//** Récupération image name **
					$image_name = $this->Scaner_model->get_scaner()[0]->image;
					//** Appel Méthode de Suppression **
					if($this->Scaner_model->delete_scaner()){
						//** SUPPRESSION IMAGE UPLOADED **
						delete_file(ressources_images_scaners_path().$image_name);
						$this->session->set_flashdata('info', "Scaner supprimé avec succès");
					}else{
						$this->session->set_flashdata('error', "Erreur lors de la suppression du scaner");
					}
				}else{
					$this->session->set_flashdata('error', "Il existe des dépendances d'horodatage à ce scaner, vous ne pouvez pas le supprimer");
				}
			}else{
				$this->session->set_flashdata('error', "Il existe des dépendances de postes à ce scaner, vous ne pouvez pas le supprimer");
			}
			redirect('administration/scaner_controller', 'refresh');
		}
	}
