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
	/**
	 * get_scans_by_scaner function
	 * - Retourne les 20 derniers scans effectués par un scaner donné
	 * __ OLD get_scans_by_scaner
	 * @param : $id_scaner
	 * @return : row OR Exception
	 */
	public function get_horodatages_by_scaner($id_scaner){
        try{
        	/*$requete = "SELECT A.`id`, A.`numero`, A.`date`, A.`commentaire`, B.`image`, 
                        GROUP_CONCAT(A.`commentaire` separator ';') as `Commentaires`
                        FROM $this->table_horodateur A
                        LEFT JOIN $this->table_scaner B ON A.`scaner_id` = B.`id`
                        WHERE A.`scaner_id` = '$id_scaner'
                        GROUP BY A.`numero`
                        ORDER BY A.`date` DESC
                        LIMIT 20";*/
            $requete = "SELECT A.`id`, A.`numero`, A.`date`, A.`commentaire`, A.`scaner_id`,
                        group_concat(`commentaire`) AS 'commentaires', B.`image` 
                        FROM $this->table_horodateur A 
                        LEFT JOIN $this->table_scaner B on A.`scaner_id` = B.`id` 
                        WHERE numero in (SELECT numero FROM $this->table_horodateur WHERE scaner_id ='$id_scaner') 
                        GROUP BY A.`numero`
                        ORDER BY A.`date` DESC
                        LIMIT 20";
            /*$requete = "SELECT A.`id`, A.`numero`, A.`date`, A.`commentaire`, 
                        group_concat(commentaire),A.scaner_id, B.id, B.image
                        FROM fnct_horodateur A
                        LEFT JOIN adm_scaner B ON A.scaner_id = B.id
                        WHERE A.scaner_id='$id_scaner'
                        GROUP BY A.`numero`
                        ORDER BY A.`date` DESC";*/
            $res = $this->db->query($requete);
            $resultat = $res->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
    /**
     * get_horodatages_by_service function
     * - Retourne les horodatages en fonction d'un service
     *
     * @param : $id_service
     * @return : row OR Exception
     */
    public function get_horodatages_by_service($id_service){
        try{
            $requete = "SELECT A.`id`, A.`numero`, A.`date`, A.`commentaire`, A.`scaner_id`, B.`image` 
                        FROM $this->table_horodateur A 
                        LEFT JOIN $this->table_scaner B on A.`scaner_id` = B.`id` 
                        WHERE A.`scaner_id` IN (SELECT `id` FROM $this->table_scaner WHERE `service_id` = '$id_service')
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
     * - Retourne les horodatages en fonction d'un etablissement
     *
     * @param : $id_etablissement
     * @return : row OR Exception
     */
    public function get_horodatages_by_etablissement($id_etablissement){
        try{
            $requete = "SELECT A.`id`, A.`numero`, A.`date`, A.`commentaire`, A.`scaner_id`, B.`image` 
                        FROM $this->table_horodateur A 
                        LEFT JOIN $this->table_scaner B on A.`scaner_id` = B.`id` 
                        WHERE A.`scaner_id` IN (SELECT `id` FROM $this->table_scaner WHERE 
                                                `service_id` IN (SELECT `id` FROM $this->table_service WHERE `etablissement_id` = '$id_etablissement'))
                        ORDER BY A.`date` DESC";
            $res = $this->db->query($requete);
            $resultat = $res->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
    /**
     * insert_scan function
     * - Ajoute un nouveau scan en base de données
     */
    public function insert_scan(){
        //** RECUPERATION DONNEES FORMULAIRE **
        $data = array(
                        'numero' => $this->input->post('numero'),
                        'date' => Date("Y-m-d H:i:s"),
                        'commentaire' => $this->input->post('commentaire'),
                        'scaner_id' => $this->input->post('scaner_id'),
                        'prelevement_type_id' => $this->input->post('horodatage_type_id')
                    );

        if($this->db->insert($this->table_horodateur, $data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    /**
     * update_commentaire function
     * - Modifie le commentaire d'un scan en base de données
     * @return : TRUE OR FALSE
     */
    public function update_commentaire(){
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
     * delete_scan function
     * - Supprime un scan de la base de données
     */
    public function delete_scan(){
        //** RECUPERATION DONNEES FORMULAIRE **
        $this->id = $this->input->post('id_scan');

        if($this->db->delete($this->table_horodateur, array('id' => $this->id))){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    /**
     * dependance_scaners_service function
     * - Vérifie s'il existe des scaners associés à un service en vue d'une suppression de service
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
