<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scaner_model extends CI_Model {
	//******************************
	//******** ATTRIBUTS ***********
	//******************************
	public $id;
    public $libelle;
    public $libelle_short;
    public $image;
    public $service_id;
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
            $this->table_scaner = get_scaner_table();
            $this->table_service = get_service_table();
            $this->table_etablissement = get_etablissement_table();
        }catch (ErrorException $e){
            die("Erreur Connexion Database - Scaner_model : ".$e->getMessage());
        }
	}
	//******************************
	//********* FONCTIONS **********
	//******************************
	/**
	 * get_last_id function
	 * - Retourne le dernier id entré
	 * @return : row OR Exception
	 */
	public function get_last_id(){
        try{
        	$last_id = $this->db->insert_id();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $last_id;
	}
	/**
	 * get_scaner_by_parameter function
	 * - Retourne le scaner correspondant de l'id passé en paramètre
	 * @param : $id_scaner
	 * @return : row OR Exception
	 */
	public function get_scaner_by_parameter($id_scaner){
        try{
        	$query = $this->db->get_where($this->table_scaner, array('id' => $id_scaner));
        	$resultat = $query->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_scaner function
	 * - Retourne le scaner correspondant de l'id posté
	 * @param : post->$id_scaner
	 * @return : row OR Exception
	 */
	public function get_scaner(){
        try{
        	$query = $this->db->get_where($this->table_scaner, 
        									array('id' => $this->input->post('id_scaner')));
        	$resultat = $query->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * insert_scaner function
	 * - Ajoute un nouveau scaner en base de données
	 */
	public function insert_scaner(){
		//** RECUPERATION DONNEES FORMULAIRE **
        $data = array(
				        'libelle' => $this->input->post('libelle'),
				        'libelle_short' => $this->input->post('libelle_short'),
				        'image' => $this->input->post('image'),
				        'service_id' => $this->input->post('service_id')
					);

        if($this->db->insert($this->table_scaner, $data)){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * update_scaner function
	 * - Modifie un scaner en base de données
	 * @param : post->$id_scaner
	 */
	public function update_scaner(){
		//** RECUPERATION SCANER **
		$scaner = $this->get_scaner($this->input->post('id_scaner'));
		//** RECUPERATION DONNEES FORMULAIRE **
        $data = array(
				        'libelle' => $this->input->post('libelle'),
				        'libelle_short' => $this->input->post('libelle_short'),
				        'image' => $scaner[0]->image,
				        'service_id' => $this->input->post('service_id')
					);

		$this->db->where('id', $this->input->post('id_scaner'));

        if($this->db->update($this->table_scaner, $data)){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * update_scaner function
	 * - Modifie un scaner en base de données
	 * @param : $last_id
	 * @param : $image_name
	 */
	public function update_image_scaner($last_id, $image_name){
		//** RECUPERATION SCANER **
		$scaner = $this->get_scaner_by_parameter($last_id);
		//** RECUPERATION DONNEES FORMULAIRE **
		$data = array(
				        'libelle' => $scaner[0]->libelle,
				        'libelle_short' => $scaner[0]->libelle_short,
				        'image' => $image_name,
				        'service_id' => $scaner[0]->service_id
					);

		$this->db->where('id', $last_id);

        if($this->db->update($this->table_scaner, $data)){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * delete_scaner function
	 * - Supprime un scaner de la base de données
	 * @param : post->$id_scaner
	 */
	public function delete_scaner(){
		//** TENTATIVE DE SUPPRESSION DU SCANER **
        if($this->db->delete($this->table_scaner, array('id' => $this->input->post('id_scaner')))){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * delete_scaner_param function
	 * - Supprime un scaner de la base de données
	 * @param : $id_scaner
	 */
	public function delete_scaner_param($id_scaner){
        if($this->db->delete($this->table_scaner, array('id' => $id_scaner))){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * dependance_scaners_service function
	 * - Vérifie s'il existe des scaners associés à un service en vue d'une suppression de service
	 * @param : $service_id
	 */
	public function dependance_scaners_service($service_id){
		$query = $this->db->get_where($this->table_scaner, array('service_id' => $service_id));
    	$resultat = $query->num_rows();
    	if($resultat !== 0){
    		return FALSE;
    	}else{
    		return TRUE;
    	}
	}
	/**
	 * get_scaner_dependances function
	 * - Retourne tous les infos du service et etablissement d'un scaner
	 * @param : $scaner_id
	 * @return : row OR Exception
	 */
	public function get_scaner_dependances($scaner_id){
        try{
            $requete = "SELECT A.`id` as 'Scaner', B.`id` as 'Service', C.`id` as 'Etablissement'
            			FROM $this->table_scaner A, $this->table_service B, $this->table_etablissement C
			            WHERE A.`service_id` = B.`id`
			            AND B.`etablissement_id` = C.`id`
			            AND A.`id` = '$scaner_id'";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_all_scaners_infos function
	 * - Retourne tous les scaners
	 * @return : row OR Exception
	 */
	public function get_all_scaners_infos(){
        try{
            $requete = "SELECT * FROM $this->table_scaner";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_array_scaners_infos function
	 * - Retourne tous les scaners avec leurs informations pour mise en page Array
	 *
	 * @return : row OR Exception
	 */
	public function get_array_scaners_infos(){
        try{
            $requete = "SELECT A.`id`, A.`libelle` as 'Scaner', A.`libelle_short`, A.`image`,
            			B.`libelle` as 'Service', C.`libelle` as 'Etablissement' 
            			FROM $this->table_scaner A, $this->table_service B, $this->table_etablissement C
			            WHERE A.`service_id` = B.`id`
			            AND B.`etablissement_id` = C.`id`";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_scaners_main_infos function
	 * - Retourne les principales informations d'un scaner, afin de l'associer à d'autres objets
	 *
	 * @return : row OR Exception
	 */
	public function get_scaners_main_infos(){
        try{
            $requete = "SELECT A.`id`, A.`libelle`, A.`libelle_short`, A.`service_id`, B.`libelle` AS 'Service', 
            			B.`libelle_short` as 'Libelle_short_service'
            			FROM $this->table_scaner A
            			LEFT JOIN $this->table_service B ON A.`service_id` = B.`id`";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
}
