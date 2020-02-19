<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sil_interface_model extends CI_Model {

    //******************************
	//******* CONSTRUCTEUR *********
	//** CONNEXION BASE DE DONNEES *
	//******************************
	public function __construct(){
		parent::__construct();
		try{
            //*** CONNEXION A LA BASE DE DONNEES ***
            $this->db = $this->load->database("tex", TRUE);
            //*** DEFINITION DES TABLES
            $this->table_user = get_user_table();
            $this->table_service = get_service_table();
            $this->table_etablissement = get_etablissement_table();
            $this->table_fonction = get_fonction_table();
            $this->table_fonction_hab = get_fonction_hab_table();
            $this->table_scaner = get_scaner_table();
            $this->table_scaner_hab = get_scaner_hab_table();
            $this->table_service_hab = get_service_hab_table();
            $this->table_etablissement_hab = get_etablissement_hab_table();
        }catch (ErrorException $e){
            die("Erreur Connexion Database - Sil_interface_model : ".$e->getMessage());
        }
	}
	//*****************************
	//******** MÉTHODES ***********
	//*****************************
    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------
    //------------------------------------- SELECT NON CONFORMITES------------------------------------------------
    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------
	/**
	 * get_nc_statut_by_liste_demandes function
	 * - Retourne les demandes avec un statut nc ou non
	 *
	 * @param : $array_demandes
	 * @return : row OR Exception
	 */
	public function get_nc_statut_by_liste_demandes($array_demandes){
		//********************************
		//*** INITIALISATION VARIABLES ***
		//********************************
		$array_return = [];
		$array_data = [];
		$array_errors = [];
		$array_requests = [];
        try{
        	// $requete = "SELECT A.`fonction_id`, A.`permission`, B.`libelle_short`, B.`image`, B.`controller` 
    					// FROM $this->table_fonction_hab A
        	// 			LEFT JOIN $this->table_fonction B ON A.`fonction_id` = B.`id`
        	// 			WHERE A.`user_id` = $id_user
        	// 			AND B.`statut` = '1'
        	// 			ORDER BY B.`ordre`";
         //    $res = $this->db->query($requete);
         //    $row = $res->result();
         //    $resultat = $row;

            foreach ($array_demandes as $key => $demande) {
            	unset($array_demandes[$key]);
            	$array_demandes[$demande] = 0;
            }
            $array_data = $array_demandes;
        }catch (PDOException $e){
        	array_push($array_errors, "Erreur - get_nc_statut_by_liste_demandes - : ".$e->getMessage());
        }
        //********************************
		//*** FORMATTAGE DONNEES RETOUR **
		//********************************
		$array_return["response_data"] = $array_data;
		$array_return["response_errors"] = $array_errors;
		$array_return["response_requests"] = $array_requests;
        return $array_return;
	}
}