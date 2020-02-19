<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Horodateur_model extends CI_Model {

    //******************************
	//******* CONSTRUCTEUR *********
	//** CONNEXION BASE DE DONNEES *
	//******************************
	public function __construct(){
		parent::__construct();
		try{
            //*** CONNEXION A LA BASE DE DONNEES ***
            $this->db = $this->load->database(main_database_loader(), TRUE);
            //*** DEFINITION DES TABLES ***
            $this->table_horodateur = get_horodateur_table();
            $this->table_scaner = get_scaner_table();
            $this->table_service = get_service_table();
            $this->table_etablissement = get_etablissement_table();
        }catch (ErrorException $e){
            die("Erreur Connexion Database - Horodateur_model : ".$e->getMessage());
        }
	}
	//*****************************
	//******** MÉTHODES ***********
	//*****************************
    //------------------------------------------------------------------------------
    //-------------------- ACTIONS SUR LES DONNEES EN TABLE ------------------------
    //------------------------------------------------------------------------------
    /**
     * insert_entry function
     * - Ajoute un nouvel horodatage en base de données
     * @return : TRUE OR FALSE
     */
    public function insert_entry(){
        //** RECUPERATION DONNEES FORMULAIRE **
        $data = array(
                        'numero' => $this->input->post('numero'),
                        'date' => Date("Y-m-d H:i:s"),
                        'commentaire' => $this->input->post('commentaire'),
                        'user_id' => $this->input->post('user_id'),
                        'scaner_id' => $this->input->post('scaner_id'),
                        'horodatage_type_id' => $this->input->post('horodatage_type_id')
                    );

        if($this->db->insert($this->table_horodateur, $data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    /**
     * update_entry function
     * - Modifie le commentaire d'un scan en base de données
     * @return : TRUE OR FALSE
     */
    public function update_entry(){
        //** RECUPERATION DONNEES FORMULAIRE **
        $data = array(
                        'commentaire' => $this->input->post('commentaire')
                    );
        $this->db->where('id', $this->input->post('id_scan'));

        if($this->db->update($this->table_horodateur, $data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    /**
     * delete_entry function
     * - Supprime un horodatage de la base de données
     * @param : $id_horodatage
     */
    public function delete_entry($id_horodatage){
        //** RECUPERATION DONNEES FORMULAIRE **
        // $this->id = $this->input->post('id_scan');

        if($this->db->delete($this->table_horodateur, array('id' => $id_horodatage))){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    //------------------------------------------------------------------------------
    //--------------------- RECUPERATION DE DONNEES PAR ENTITE ---------------------
    //------------------------------------------------------------------------------
    /**
     * get_scans_by_scaner function
     * - Retourne les horodatages en fonction d'un scaner donné entre deux dates
     * __ OLD get_scans_by_scaner
     * @param : $id_scaner
     * @param : $int_limit
     * @return : row OR Exception
     */
    public function get_horodatages_by_scaner_limited($id_scaner, $int_limit){
        try{
            $requete = "SELECT A.`id`, A.`numero`, A.`date`, A.`commentaire`, A.`scaner_id`,
                        group_concat(`commentaire`) AS 'commentaires', B.`image` 
                        FROM $this->table_horodateur A 
                        LEFT JOIN $this->table_scaner B on A.`scaner_id` = B.`id` 
                        WHERE numero in (SELECT numero FROM $this->table_horodateur WHERE scaner_id ='$id_scaner')
                        GROUP BY A.`numero`
                        ORDER BY A.`date` DESC
                        LIMIT ".$int_limit."";
            $res = $this->db->query($requete);
            $resultat = $res->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    } //
	/**
	 * get_scans_by_scaner function
	 * - Retourne les horodatages en fonction d'un scaner donné entre deux dates
	 * __ OLD get_scans_by_scaner
     * @param : $id_scaner
     * @param : $date_debut
	 * @param : $date_fin
	 * @return : row OR Exception
	 */
	public function get_horodatages_by_scaner($id_scaner, $date_debut, $date_fin){
        try{
            $requete = "SELECT A.`id`, A.`numero`, A.`date`, A.`commentaire`, A.`scaner_id`,
                        group_concat(`commentaire`) AS 'commentaires', B.`image` 
                        FROM $this->table_horodateur A 
                        LEFT JOIN $this->table_scaner B on A.`scaner_id` = B.`id` 
                        WHERE numero in (SELECT numero FROM $this->table_horodateur WHERE scaner_id ='$id_scaner')
                        AND A.`date` BETWEEN ('".$date_debut."') AND ('".$date_fin."')
                        GROUP BY A.`numero`
                        ORDER BY A.`date` DESC";
            $res = $this->db->query($requete);
            $resultat = $res->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
    /**
     * get_horodatages_by_service function
     * - Retourne les horodatages en fonction d'un service et de deux dates
     * @param : $id_service
     * @param : $date_debut
     * @param : $date_fin
     * @return : row OR Exception
     */
    public function get_horodatages_by_service($id_service, $date_debut, $date_fin){
        try{
            $requete = "SELECT A.`id`, A.`numero`, A.`date`, A.`commentaire`, A.`scaner_id`, B.`image` 
                        FROM $this->table_horodateur A 
                        LEFT JOIN $this->table_scaner B on A.`scaner_id` = B.`id` 
                        WHERE A.`scaner_id` IN (SELECT `id` FROM $this->table_scaner WHERE `service_id` = '$id_service')
                        AND A.`date` BETWEEN ('".$date_debut."') AND ('".$date_fin."')
                        ORDER BY A.`date` DESC";
            $res = $this->db->query($requete);
            $resultat = $res->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
    /**
     * get_horodatages_by_etablissement function
     * - Retourne les horodatages en fonction d'un etablissement et de deux dates
     * @param : $id_etablissement
     * @param : $date_debut
     * @param : $date_fin
     * @return : row OR Exception
     */
    public function get_horodatages_by_etablissement($id_etablissement, $date_debut, $date_fin){
        try{
            $requete = "SELECT A.`id`, A.`numero`, A.`date`, A.`commentaire`, A.`scaner_id`, B.`image` 
                        FROM $this->table_horodateur A 
                        LEFT JOIN $this->table_scaner B on A.`scaner_id` = B.`id` 
                        WHERE A.`scaner_id` IN (SELECT `id` FROM $this->table_scaner WHERE 
                                                `service_id` IN (SELECT `id` FROM $this->table_service WHERE `etablissement_id` = '$id_etablissement'))
                        AND A.`date` BETWEEN ('".$date_debut."') AND ('".$date_fin."')
                        ORDER BY A.`date` DESC";
            $res = $this->db->query($requete);
            $resultat = $res->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
    //------------------------------------------------------------------------------
    //-------------------------- FONCTIONS DE CONTROLE -----------------------------
    //------------------------------------------------------------------------------
    /**
     * dependance_scaners_service function
     * - Vérifie s'il existe des scaners associés à un service en vue d'une suppression de service
     * @return : TRUE OR FALSE
     */
    public function dependance_scans_scaner(){
        $query = $this->db->get_where($this->table_horodateur, array('scaner_id' => $this->input->post('id_scaner')));
        $resultat = $query->num_rows();
        if($resultat !== 0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    //------------------------------------------------------------------------------
    //--------------- FONCTIONS RELATIVES AU SUIVI DES HORODATAGES -----------------
    //------------------------------------------------------------------------------
    /**
     * get_suivi_by_numero function
     * - Retourne le suivi, tous les scans effectué sur un numéro
     * @param : $numero
     * @return : row OR Exception
     */
    public function get_suivi_by_numero($numero){
        try{
            $requete = "SELECT A.`date`, A.`commentaire`, B.`libelle` AS 'Scaner', B.`image`,
                        C.`libelle` AS 'Service', D.`libelle` AS 'Etablissement'
                        FROM $this->table_horodateur A
                        LEFT JOIN $this->table_scaner B ON A.`scaner_id` = B.`id`
                        LEFT JOIN $this->table_service C ON B.`service_id` = C.`id`
                        LEFT JOIN $this->table_etablissement D ON C.`etablissement_id` = D.`id`
                        WHERE A.`numero` = '$numero'
                        ORDER BY A.`date` DESC";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;

        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
}
