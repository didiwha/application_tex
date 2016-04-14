<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etablissement_model extends CI_Model {

	//* Doivent porter les mêmes noms que les colonnes de la table pour une persistence simplifiée *
	//******************************
	//******** ATTRIBUTS ***********
	//******************************
	public $id;
    public $libelle;
    public $libelle_short;
    public $code;
    public $adresse;
    public $code_postal;
    public $ville;
    public $telephone;
    public $email;
    public $date_enregistrement;
    public $source;
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
            $this->table_etablissement = get_etablissement_table();
        }catch (ErrorException $e){
            die("Erreur Connexion Database - Etablissement_model : ".$e->getMessage());
        }
	}
	//******************************
	//********* FONCTIONS **********
	//******************************
	/**
	 * get_etablissement function
	 * - Retourne l'etablissement correspondant de l'id passé en paramètre
	 *
	 * @param : $id_etablissement
	 * @return : row OR Exception
	 */
	public function get_etablissement_by_parameter($id_etablissement){
        try{
        	$query = $this->db->get_where($this->table_etablissement, 
        									array('id' => $id_etablissement));
        	$resultat = $query->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_etablissement function
	 * - Retourne l'etablissement correspondant de l'id posté
	 *
	 * @param : post->$id_etablissement
	 * @return : row OR Exception
	 */
	public function get_etablissement(){
        try{
        	$query = $this->db->get_where($this->table_etablissement, 
        									array('id' => $this->input->post('id_etablissement')));
        	$resultat = $query->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * verification_etablissement_source function
	 * - Verifie si un autre etablissement source existe déja
	 * - Un seul etablissement peut-être en statut source=1
	 * @param : $etablissement_id
	 * @return : row OR Exception
	 */
	public function verification_etablissement_source($etablissement_id){
		try{
			if($etablissement_id == ""){
				$requete = "SELECT A.id, A.libelle FROM $this->table_etablissement A
	    					WHERE A.source = 1";
			}else{
				$requete = "SELECT A.id, A.libelle FROM $this->table_etablissement A
	    					WHERE A.source = 1
	    					AND A.id != $etablissement_id";
			}
			$res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
	    	

	    	if($resultat !== 0){
	    		return $resultat;
	    	}else{
	    		return FALSE;
	    	}
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * insert_etablissement function
	 * - Ajoute un nouvel etablissement en base de données
	 */
	public function insert_etablissement(){
		//** RECUPERATION DONNEES FORMULAIRE **
        $data = array(
				        'libelle' => $this->input->post('libelle'),
				        'libelle_short' => $this->input->post('libelle_short'),
				        'code' => $this->input->post('code'),
				        'adresse' => $this->input->post('adresse'),
				        'code_postal' => $this->input->post('code_postal'),
				        'ville' => $this->input->post('ville'),
				        'telephone' => $this->input->post('telephone'),
				        'email' => $this->input->post('email'),
				        'date_enregistrement' => Date("Y-m-d H:i:s"),
				        'source' => $this->input->post('source')
					);

        if($this->db->insert($this->table_etablissement, $data)){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * insert_etablissement function
	 * - Ajoute un nouvel etablissement en base de données
	 */
	public function update_etablissement(){
		//** RECUPERATION DONNEES FORMULAIRE **
        $data = array(
				        'libelle' => $this->input->post('libelle'),
				        'libelle_short' => $this->input->post('libelle_short'),
				        'code' => $this->input->post('code'),
				        'adresse' => $this->input->post('adresse'),
				        'code_postal' => $this->input->post('code_postal'),
				        'ville' => $this->input->post('ville'),
				        'telephone' => $this->input->post('telephone'),
				        'email' => $this->input->post('email'),
				        'source' => $this->input->post('source')
					);

		$this->db->where('id', $this->input->post('id_etablissement'));

        if($this->db->update($this->table_etablissement, $data)){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * delete_etablissement function
	 * - Supprime un etablissement de la base de données
	 * Table : tex_etablissement
	 */
	public function delete_etablissement(){
		//** RECUPERATION DONNEES FORMULAIRE **
		$this->id = $this->input->post('id_etablissement');

        if($this->db->delete($this->table_etablissement, array('id' => $this->id))){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * get_all_etablissement_infos function
	 * - Retourne tous les etablissements
	 *
	 * @return : row OR Exception
	 */
	public function get_all_etablissements_infos(){
        try{
            $requete = "SELECT * FROM $this->table_etablissement";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_array_etablissements_infos function
	 * - Retourne tous les etablissements avec leurs informations pour mise en page Array
	 *
	 * @return : row OR Exception
	 */
	public function get_array_etablissements_infos(){
        try{
            $requete = "SELECT * FROM $this->table_etablissement";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_etablissements_main_infos function
	 * - Retourne les principales informations d'un etablissement, afin de l'associer à d'autres objets
	 *
	 * @return : row OR Exception
	 */
	public function get_etablissements_main_infos(){
        try{
            $requete = "SELECT id, libelle, libelle_short FROM $this->table_etablissement";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
}
