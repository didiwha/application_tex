<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Habilitations_model extends CI_Model {

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
            die("Erreur Connexion Database - Etablissement_model : ".$e->getMessage());
        }
	}
	//*****************************
	//******** MÉTHODES ***********
	//*****************************
	/**
	 * get_hab_fonctions_by_user function
	 * - Retourne les fonctions auxquelles
	 * - le user est habilité
	 *
	 * @param : $id_user
	 * @return : row OR Exception
	 */
	public function get_hab_fonctions_by_user($id_user){
        try{
        	$requete = "SELECT A.`fonction_id`, A.`permission`, B.`libelle_short`, B.`image`, B.`controller` 
    					FROM $this->table_fonction_hab A
        				LEFT JOIN $this->table_fonction B ON A.`fonction_id` = B.`id`
        				WHERE A.`user_id` = $id_user
        				AND B.`statut` = '1'
        				ORDER BY B.`ordre";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;

        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
    /**
     * get_fonctions_and_hab_by_user function
     * - Retourne les fonctions de la base et
     * - les habilitations fonctions du user
     *
     * @param : $id_user
     * @return : row OR Exception
     */
    public function get_fonctions_and_hab_by_user($id_user){
        try{
            $requete = "SELECT * FROM $this->table_fonction A 
                        LEFT JOIN $this->table_fonction_hab B 
                        ON A.`id` = B.`fonction_id`
                        AND B.`user_id` = '$id_user'";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;

        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
    /**
     * add_hab_fonctions_by_user function
     * - Retourne les fonctions auxquelles
     * - le user est habilité
     *
     * @param : $id_user
     * @return : row OR Exception
     */
    public function add_hab_fonctions_by_user($user_id){
        if (!empty($this->input->post('fonctions'))){
            foreach ($this->input->post('fonctions') as $habilitation => $id_fonction) {
                $data = array(
                            'user_id' => $user_id,
                            'fonction_id' => $id_fonction,
                            'permission' => $this->input->post('permission-fonction-'.$id_fonction)
                        );
                $this->db->insert($this->table_fonction_hab, $data);
            }
        }
        return true;
    }
    /**
     * del_hab_fonctions_by_user function
     * - Supprime les habilitations fonctions du user
     *
     * @return : row OR Exception
     */
    public function del_hab_fonctions_by_user(){
        //** TENTATIVE DE SUPPRESSION DES HABILITATIONS FONCTIONS D'UN USER **
        if($this->db->delete($this->table_fonction_hab, array('user_id' => $this->input->post('id_user')))){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    /**
     * get_hab_scaners_by_user function
     * - Retourne les scaners auxquels
     * - le user est habilité
     *
     * @param : $id_user
     * @return : row OR Exception
     */
    public function get_hab_scaners_by_user($id_user){
        try{
            $requete = "SELECT A.`scaner_id`, A.`permission`, B.`libelle`, B.`image`
                        FROM $this->table_scaner_hab A
                        LEFT JOIN $this->table_scaner B ON A.`scaner_id` = B.`id`
                        WHERE A.`user_id` = '$id_user'";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;

        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
    /**
     * get_hab_scaners_by_user_full function
     * - Retourne les scaners auxquels
     * - le user est habilité
     * - avec les dependances de services et etablissements
     * 
     * @param : $id_user
     * @return : row OR Exception
     */
    public function get_hab_scaners_by_user_full($id_user){
        try{
            $requete = "SELECT A.`scaner_id`, A.`permission`, B.`libelle`, B.`image`, 
                        C.libelle_short as 'service_short', D.libelle_short as 'etablissement_short'
                        FROM $this->table_scaner_hab A
                        LEFT JOIN $this->table_scaner B ON A.`scaner_id` = B.`id`
                        LEFT JOIN $this->table_service C ON B.`service_id` = C.`id`
                        LEFT JOIN $this->table_etablissement D ON C.`etablissement_id` = D.`id`
                        WHERE A.`user_id` = '$id_user'";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;

        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
    /**
     * get_scaners_and_hab_by_user function
     * - Retourne les scaners de la base et
     * - les habilitations scaners du user
     *
     * @param : $id_user
     * @return : row OR Exception
     */
    public function get_scaners_and_hab_by_user($id_user){
        try{
            $requete = "SELECT A.`id`, A.`libelle`, A.`service_id`,B.`user_id`,B.`scaner_id`,
                        B.`permission`, D.`libelle` AS 'service', D.`libelle_short` as 'Libelle_short_service'
                        FROM $this->table_scaner A
                        LEFT JOIN $this->table_service D ON A.`service_id` = D.`id`
                        LEFT JOIN $this->table_scaner_hab B  ON A.`id` = B.`scaner_id`
                        AND B.`user_id` = '$id_user'
                        LEFT JOIN $this->table_user C ON C.`id` = '$id_user'
                        ORDER BY B.`scaner_id` DESC, B.`permission` ASC";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;

        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
    /**
     * add_hab_scaners_by_user function
     * - Ajoute les habilitations scaner du user
     *
     * @param : $id_user
     * @return : row OR Exception
     */
    public function add_hab_scaners_by_user($user_id){
        if (!empty($this->input->post('scaners'))){
            foreach ($this->input->post('scaners') as $habilitation => $id_scaner) {
                //** Vérification du scaner par défaut **
                if($id_scaner != $this->input->post("scaner_id")){
                    $data = array(
                                'user_id' => $user_id,
                                'scaner_id' => $id_scaner,
                                'permission' => $this->input->post('permission-scaner-'.$id_scaner)
                            );
                    $this->db->insert($this->table_scaner_hab, $data);
                }
            }
        }
        return true;
    }
    /**
     * del_hab_scaners_by_user function
     * - Supprime les habilitations scaner du user
     *
     * @return : row OR Exception
     */
    public function del_hab_scaners_by_user(){
        //** TENTATIVE DE SUPPRESSION DES HABILITATIONS SCANERS D'UN USER **
        if($this->db->delete($this->table_scaner_hab, array('user_id' => $this->input->post('id_user')))){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    /**
     * get_hab_etablissements_by_user function
     * - Retourne les etablissements auxquels
     * - le user est habilité
     *
     * @param : $id_user
     * @return : row OR Exception
     */
    public function get_hab_etablissements_by_user($id_user){
        try{
            $requete = "SELECT A.`etablissement_id`, A.`permission`, B.`libelle`
                        FROM $this->table_etablissement_hab A
                        LEFT JOIN $this->table_etablissement B ON A.`etablissement_id` = B.`id`
                        WHERE A.`user_id` = '$id_user'";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;

        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
    /**
     * get_etablissements_and_hab_by_user function
     * - Retourne les etablissements de la base et
     * - les habilitations etablissements du user
     *
     * @param : $id_user
     * @return : row OR Exception
     */
    public function get_etablissements_and_hab_by_user($id_user){
        try{
            $requete = "SELECT A.`id`, A.`libelle`,A.`libelle_short`,B.`user_id`,B.`etablissement_id`,B.`permission`
                        FROM $this->table_etablissement A
                        LEFT JOIN $this->table_etablissement_hab B 
                        ON A.`id` = B.`etablissement_id`
                        AND B.`user_id` = '$id_user'
                        ORDER BY B.`etablissement_id` DESC";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;

        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
    /**
     * add_hab_etablissements_by_user function
     * - Ajoute les habilitations etablissements du user
     *
     * @param : $id_user
     * @return : row OR Exception
     */
    public function add_hab_etablissements_by_user($user_id){
        if (!empty($this->input->post('etablissements'))){
            foreach ($this->input->post('etablissements') as $habilitation => $id_etablissement) {
                $data = array(
                            'user_id' => $user_id,
                            'etablissement_id' => $id_etablissement,
                            'permission' => $this->input->post('permission-etablissement-'.$id_etablissement)
                        );
                $this->db->insert($this->table_etablissement_hab, $data);
            }
        }
        return true;
    }
    /**
     * del_hab_etablissements_by_user function
     * - Supprime les habilitations etablissements du user
     *
     * @return : row OR Exception
     */
    public function del_hab_etablissements_by_user(){
        //** TENTATIVE DE SUPPRESSION DES HABILITATIONS ETABLISSEMENTS D'UN USER **
        if($this->db->delete($this->table_etablissement_hab, array('user_id' => $this->input->post('id_user')))){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    /**
     * get_hab_services_by_user function
     * - Retourne les etablissements auxquels
     * - le user est habilité
     *
     * @param : $id_user
     * @return : row OR Exception
     */
    public function get_hab_services_by_user($id_user){
        try{
            $requete = "SELECT A.`service_id`, A.`permission`, B.`libelle`
                        FROM $this->table_service_hab A
                        LEFT JOIN $this->table_service B ON A.`service_id` = B.`id`
                        WHERE A.`user_id` = '$id_user'";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;

        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
    /**
     * get_services_and_hab_by_user function
     * - Retourne les services de la base et
     * - les habilitations services du user
     *
     * @param : $id_user
     * @return : row OR Exception
     */
    public function get_services_and_hab_by_user($id_user){
        try{
            $requete = "SELECT A.`id`, A.`libelle`,A.`libelle_short`,B.`user_id`,B.`service_id`,B.`permission`, 
                        D.`libelle` AS 'etablissement', D.`libelle_short` as 'Libelle_short_etablissement' 
                        FROM $this->table_service A
                        LEFT JOIN $this->table_etablissement D
                        ON A.`etablissement_id` = D.`id`
                        LEFT JOIN $this->table_service_hab B 
                        ON A.`id` = B.`service_id`
                        AND B.`user_id` = '$id_user'
                        ORDER BY B.`service_id` DESC";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;

        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
    }
    /**
     * add_hab_services_by_user function
     * - Ajoute les habilitations services du user
     *
     * @param : $id_user
     * @return : row OR Exception
     */
    public function add_hab_services_by_user($user_id){
        if (!empty($this->input->post('services'))){
            foreach ($this->input->post('services') as $habilitation => $id_service) {
                $data = array(
                            'user_id' => $user_id,
                            'service_id' => $id_service,
                            'permission' => $this->input->post('permission-service-'.$id_service)
                        );
                $this->db->insert($this->table_service_hab, $data);
            }
        }
        return true;
    }
    /**
     * del_hab_services_by_user function
     * - Supprime les habilitations services du user
     *
     * @return : row OR Exception
     */
    public function del_hab_services_by_user(){
        //** TENTATIVE DE SUPPRESSION DES HABILITATIONS SERVICES D'UN USER **
        if($this->db->delete($this->table_service_hab, array('user_id' => $this->input->post('id_user')))){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
