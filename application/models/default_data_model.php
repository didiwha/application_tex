<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Default_data_model extends CI_Model {

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
            $this->table_default_data = get_default_data_table();
        }catch (ErrorException $e){
            die("Erreur Connexion Database - Default_data_model : ".$e->getMessage());
        }
	}
	//*****************************
	//******** MÉTHODES ***********
	//*****************************
	/**
	 * get_default_comments_by_scaner function
	 * - Retourne les commentaires d'un scaner
	 * - à partir de son id
	 *
	 * @param : $id_scaner
	 * @return : row OR Exception
	 */
	public function get_default_comments_by_scaner($id_scaner){
        try{
        	$requete = "SELECT A.`id`, A.`data_value` 
                        FROM $this->table_default_data A
                        WHERE A.`default_data_column_id` = '".$this->data_location->searchKeyInArray($this->data_location->get_default_data_columns(), 'value', 'default_comment')."'
                        AND A.`data_reference` = '".$id_scaner."'
                        ORDER BY A.`data_value`";
            $res = $this->db->query($requete);
            $resultat = $res->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
    /**
     * insert_default_comment_by_scaner function
     * - Ajoute un nouveau commentaire en base pour un scaner passé en parametre
     * @param : $scaner_id
     * @param : $commentaire
     */
    public function insert_default_comment_by_scaner($scaner_id, $commentaire){
        //** RECUPERATION DONNEES FORMULAIRE **
        $data = array(
                        'data_value' => $commentaire,
                        'data_reference' => $scaner_id,
                        'default_data_column_id' => $this->data_location->searchKeyInArray($this->data_location->get_default_data_columns(), 'value', 'default_comment')
                    );
        if($this->db->insert($this->table_default_data, $data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    /**
     * delete_default_comment_by_scaner function
     * - Supprime un commentaire par défaut en base
     * @param : $commentaire_id
     */
    public function delete_default_comment_by_scaner($commentaire_id){
        if($this->db->delete($this->table_default_data, array('id' => $commentaire_id))){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
