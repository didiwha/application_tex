<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model extends CI_Model {

	//******************************
	//******** ATTRIBUTS ***********
	//******************************
	public $id;
    public $libelle;
    public $libelle_short;
    public $statut_id;
    public $service_cible_id;
    public $code_correspondant;
    public $etablissement_id;
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
            $this->table_service = get_service_table();
            $this->table_etablissement = get_etablissement_table();
        }catch (ErrorException $e){
            die("Erreur Connexion Database - Service_model : ".$e->getMessage());
        }
	}
	//******************************
	//********* FONCTIONS **********
	//******************************
	/**
	 * get_service_by_parameter function
	 * - Retourne le service correspondant de l'id passé en paramètre
	 *
	 * @param : $id_service
	 * @return : row OR Exception
	 */
	public function get_service_by_parameter($id_service){
        try{
        	$query = $this->db->get_where($this->table_service, array('id' => $id_service));
        	$resultat = $query->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_service function
	 * - Retourne le service correspondant de l'id posté
	 *
	 * @param : post->$id_service
	 * @return : row OR Exception
	 */
	public function get_service(){
        try{
        	$query = $this->db->get_where($this->table_service, 
        									array('id' => $this->input->post('id_service')));
        	$resultat = $query->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * verification_identifiant function
	 * - Verifie les informations de connexion d'un utilisateur
	 *
	 * @param : $identifiant
	 * @param : $password
	 * @return : row OR Exception
	 */
	public function insert_service(){
		//** RECUPERATION DONNEES FORMULAIRE **
        $data = array(
				        'libelle' => $this->input->post('libelle'),
				        'libelle_short' => $this->input->post('libelle_short'),
				        'statut_id' => 1,
				        'service_cible_id' => $this->input->post('service_cible_id'),
				        'code_correspondant' => $this->input->post('code_correspondant'),
				        'etablissement_id' => $this->input->post('etablissement_id')
					);

        if($this->db->insert($this->table_service, $data)){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * insert_etablissement function
	 * - Ajoute un nouvel etablissement en base de données
	 * Table : tex_etablissement
	 */
	public function update_service(){
		//** RECUPERATION DONNEES FORMULAIRE **
        $data = array(
				        'libelle' => $this->input->post('libelle'),
				        'libelle_short' => $this->input->post('libelle_short'),
				        'statut_id' => 1,
				        'service_cible_id' => $this->input->post('service_cible_id'),
				        'code_correspondant' => $this->input->post('code_correspondant'),
				        'etablissement_id' => $this->input->post('etablissement_id')
					);

		$this->db->where('id', $this->input->post('id_service'));

        if($this->db->update($this->table_service, $data)){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * delete_service function
	 * --- Si aucun Scaner ne lui est rattaché ---
	 * - Supprime un service de la base de données 
	 * Table : tex_service
	 */
	public function delete_service(){
		//** Tentative de Suppression **
		if($this->db->delete($this->table_service, array('id' => $this->input->post('id_service')))){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * dependance_scaners_service function
	 * - Vérifie s'il existe des scaners associés à un service en vue d'une suppression de service
	 * Table : tex_scaner
	 */
	public function dependance_services_etablissement($etablissement_id){
		$query = $this->db->get_where($this->table_service, array('etablissement_id' => $etablissement_id));
    	$resultat = $query->num_rows();
    	if($resultat !== 0){
    		return FALSE;
    	}else{
    		return TRUE;
    	}
	}
	/**
	 * get_all_services_infos function
	 * - Retourne tous les services
	 *
	 * @return : row OR Exception
	 */
	public function get_all_services_infos(){
        try{
            $requete = "SELECT * FROM $this->table_service";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_array_services_infos function
	 * - Retourne tous les services avec les informations de leur etablissement
	 *
	 * @return : row OR Exception
	 */
	public function get_array_services_infos(){
        try{
            $requete = "SELECT A.id, A.libelle as 'Service', A.libelle_short,
            			B.libelle as 'Etablissement', code_correspondant, service_cible_id 
			            FROM $this->table_service A, $this->table_etablissement B
			            WHERE A.etablissement_id = B.id";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_services_main_infos function
	 * - Retourne les principales informations d'un service, afin de l'associer à d'autres objets
	 *
	 * @return : row OR Exception
	 */
	public function get_services_main_infos(){
        try{
            $requete = "SELECT A.`id`, A.`libelle`, A.`libelle_short`, A.`etablissement_id`, B.`libelle_short` as 'Libelle_short_etablissement'
            			FROM $this->table_service A
            			LEFT JOIN $this->table_etablissement B ON A.`etablissement_id` = B.`id`";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_services_cible function
	 * - Retourne les services associés à leur etablissement
	 *
	 * @return : row OR Exception
	 */
	public function get_services_cible(){
        try{
            $requete = "SELECT A.id as 'id', A.libelle as 'Service', A.libelle_short, B.libelle as 'Etablissement' 
            			FROM $this->table_service A, $this->table_etablissement B
            			WHERE A.etablissement_id = B.id";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
}
