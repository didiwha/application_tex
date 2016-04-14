<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fonction_model extends CI_Model {

    //******************************
	//******* CONSTRUCTEUR *********
	//** CONNEXION BASE DE DONNEES *
	//******************************
	public function __construct(){
		parent::__construct();
		try{
            //*** CONNEXION A LA BASE DE DONNEES ***
            $this->db = $this->load->database(main_database_loader(), TRUE);
            //*** DEFINITION DES TABLES
            $this->table_fonction = get_fonction_table();
        }catch (ErrorException $e){
            die("Erreur Connexion Database - Etablissement_model : ".$e->getMessage());
        }
	}
	//*****************************
	//******** MÉTHODES ***********
	//*****************************
    /**
     * get_fonctions_main_infos function
     * - Retourne les fonctions de la base
     *
     * @return : row OR Exception
     */
    public function get_all_fonctions(){
        try{
            $requete = "SELECT * FROM $this->table_fonction
                        ORDER BY ordre";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;

        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
}
