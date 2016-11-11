<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Main_controller extends CI_Controller {
		//***********************************************************
		//************************ FONCTIONS ************************
		//***********************************************************
		/**
		 * index function
		 * - Charge la vue home [home_view]
		 */
		public function index(){
			//** CHARGEMENT DES VUES **
            view_portail_loader($this, "template/", "portail_view", null);
			//** PROFILING **
			$this->output->enable_profiler(TRUE);
		}
		/**
		 * accueil function
		 * - Charge la vue accueil [accueil_view]
		 */
		public function accueil(){
			getSession($this);
			//** CHARGEMENT DES VUES **
            view_loader($this, "template/", "accueil_view", null);
		}
		/**
		 * connexion function
		 * - Verifie les informations de connexion d'un utilisateur
		 * - Renvoi les posts du formulaire vers le methode verification_identifiant du model User_model
		 * - En cas de succès : ^ Redirecion page accueil [accueil_view]
		 *						^ Mise en session Infos User et Habilitations
		 						^ Inititalisation des filtres		
		 * - En cas d'echec : Redirection page accueil [home_view]
		 */
		public function connexion(){
			//*** LOADING MODELS ***
			models_loader($this, array("User_model", "Habilitations_model"));
			if ($this->User_model->verification_identifiant() !== FALSE){
				//************************************
				//** VERIFICATION VALIDITE PASSWORD **
				//************************************
				// ** $$$$$ **
				//**************************
				//** RECUPERATION DONNEES **
				//**************************
				$data['user'] = $this->User_model->verification_identifiant();
				$data['default_scaner'] = $this->User_model->get_default_scaner($data["user"][0]->id);
				$data['droits_fonctions'] = $this->Habilitations_model->get_hab_fonctions_by_user($data["user"][0]->id);
				$data['droits_scaners'] = $this->Habilitations_model->get_hab_scaners_by_user_full($data["user"][0]->id);
				$data['droits_services'] = $this->Habilitations_model->get_hab_services_by_user($data["user"][0]->id);
				$data['droits_etablissements'] = $this->Habilitations_model->get_hab_etablissements_by_user($data["user"][0]->id);
				//**************************************
				//** AJOUT D'INFORMATION A LA SESSION **
				//**************************************
				update_session_userdata($this, get_user_id_var_libelle(), $data["user"][0]->id);
				update_session_userdata($this, get_poste_var_libelle(), $data["user"][0]->poste);
				update_session_userdata($this, get_statut_id_var_libelle(), $data["user"][0]->statut_id);
				update_session_userdata($this, get_default_scaner_var_libelle(), $data["default_scaner"]);
				update_session_userdata($this, get_fonctions_array_var_libelle(), $data["droits_fonctions"]);
				update_session_userdata($this, get_scaners_array_var_libelle(), $data["droits_scaners"]);
				update_session_userdata($this, get_services_array_var_libelle(), $data["droits_services"]);
				update_session_userdata($this, get_etablissements_array_var_libelle(), $data["droits_etablissements"]);
				update_session_userdata($this, get_logged_in_var_libelle(), true);
				//*************************************************************
				//** Initialisation Tableau des filtres Fonction Tracabilité **
				//*************************************************************
				update_session_userdata($this, get_tracability_filters_array_var_libelle(), construct_tracability_filters_array('','',''));
				//************************************************************
				//** Initialisation Tableau des filtres Fonction Horodateur **
				//************************************************************
				update_session_userdata($this, get_horodateur_filters_array_var_libelle(), construct_horodateur_filters_array($this->data_location->searchKeyInArray($this->data_location->get_horodatage_types(), 'parametre', 'default')));
				//*****************************
                //** MAJ DERNIERE CONNECTION **
                //*****************************
                if(!$this->User_model->majLastConnection($data["user"][0]->id)){
                	$this->session->set_flashdata('error', "Erreur lors de la mise à jour de la derniere connexion");
                }
                //*************************
				//** CHARGEMENT DES VUES **
				//*************************
                view_loader($this, "template/", "accueil_view", null);
			}else{
				$this->session->set_flashdata('error', 'Erreur d\'identifiant et/ou de mot de passe');
                redirect('main_controller', 'refresh');
			}	   
		}
		/**
	     * deconnexion function
	     * - Déconnecte l'utilisateur en détruisant sa session
	     * - redirige vers la page d'accueil [home_view]
	     */
	    public function deconnexion(){
	        if ($this->session){
	            $this->session->sess_destroy();
	        }
	        redirect('main_controller', 'refresh');
	    }
	}
