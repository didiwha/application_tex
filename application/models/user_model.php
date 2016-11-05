<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	//******************************
	//******** ATTRIBUTS ***********
	//******************************
	public $id;
	public $poste;
    public $password;
    public $statut_id;
    public $image;
    public $avatar;
    public $service_id;
    public $etablissement_id;
    public $nom;
    public $prenom;
    public $fonction;
    public $email;
    public $date_last_connection;
    public $type_compte_id;
    //******************************
	//******* CONSTRUCTEUR *********
	//******************************
	public function __construct(){
		parent::__construct();
		try{
			//*** CONNEXION A LA BASE DE DONNEES ***
            $this->db = $this->load->database(main_database_loader(), TRUE);
            //*** DEFINITION DES TABLES
            $this->table_user = get_user_table();
            $this->table_scaner = get_scaner_table();
            $this->table_service = get_service_table();
            $this->table_etablissement = get_etablissement_table();
            $this->table_scaner_hab = get_scaner_hab_table();
        }catch (ErrorException $e){
            die("Erreur Connexion Database - User_model : ".$e->getMessage());
        }
	}
	//******************************
	//********* FONCTIONS **********
	//******************************
	/**
	 * get_user_by_parameter function
	 * - Retourne le user correspondant de l'id passé en paramètre
	 * @param : $id_user
	 * @return : row OR Exception
	 */
	public function get_user_by_parameter($id_user){
        try{
        	$query = $this->db->get_where($this->table_user, array('id' => $id_user));
        	$resultat = $query->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_user function
	 * - Retourne le user correspondant de l'id posté
	 * @param : post->$id_user
	 * @return : row OR Exception
	 */
	public function get_user(){
        try{
        	$query = $this->db->get_where($this->table_user, 
        									array('id' => $this->input->post('id_user')));
        	$resultat = $query->result();
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_default_scaner function
	 * - Retourne les informations du scaner par defaut du user
	 * @param : post->$id_user
	 * @return : row OR Exception
	 */
	public function get_default_scaner($id_user){
        try{
			$requete = "SELECT A.`id`, A.`libelle`, A.`image` 
    					FROM $this->table_scaner A, $this->table_scaner_hab B
    					WHERE A.`id` = B.`scaner_id`
    					AND B.`user_id` = '$id_user'
    					AND B.`permission`='0'";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;

        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * majLastConnection function
	 * - Modifie la date de derniere connectioh en base de données
	 * @return : TRUE OR FALSE
	 */
	public function majLastConnection($id_user){
		//** RECUPERATION DONNEES FORMULAIRE **
        $data = array('date_last_connection' => Date("Y-m-d H:i:s"));
		$this->db->where('id', $id_user);

        if($this->db->update($this->table_user, $data)){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * check_poste_unicity function
	 * - Verifie qu'un nom de poste n'est pas existant 
	 * @return : true OR false
	 */
	public function check_poste_unicity(){
		try{
			$query = $this->db->get_where($this->table_user, array('poste' => $this->input->post("poste")));
	    	if($query->num_rows() !== 0){
	    		return FALSE;
	    	}else{
	    		return TRUE;
	    	}
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
	}
	/**
	 * check_poste_unicity function
	 * - Verifie qu'un nom de poste n'est pas existant pour la mise a jour d'un user
	 * @return : true OR false
	 */
	public function check_poste_unicity_update(){
		$poste = $this->input->post('poste');
		$id_user = $this->input->post('id_user');
		try{
			$requete = "SELECT `poste` FROM $this->table_user
						WHERE `poste`='$poste' AND `id`!='$id_user'";
            $res = $this->db->query($requete);
	    	if($res->num_rows() !== 0){
	    		return FALSE;
	    	}else{
	    		return TRUE;
	    	}
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
	}
	/**
	 * verification_identifiant function
	 * - Verifie les informations de connexion d'un utilisateur
	 * @param : $identifiant
	 * @param : $password
	 * @return : row OR Exception
	 */
	public function verification_identifiant(){
		try{
			/*$query = $this->db->get_where($this->table_user, 
											array('poste' => $this->input->post('identifiant')),
										    array('password' => encode_password($this->input->post('password'))));*/
			$query = "SELECT * FROM $this->table_user A
					  WHERE A.`poste` = '".$this->input->post('identifiant')."'
					  AND A.`password` = '".encode_password($this->input->post('password'))."'";
		    $res = $this->db->query($query);
            $resultat = $res->num_rows();

			//die(var_dump($query));
	    	//$resultat = $query->num_rows();	    	
	    	if($resultat !== 0){
	    		return $query->result();
	    	}else{
	    		return FALSE;
	    	}
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * insert_user function
	 * - Ajoute un user en base de données
	 * @return : TRUE OR FALSE
	 */
	public function insert_user(){
		//** RECUPERATION DONNEES FORMULAIRE **
        $data = array(
				        'poste' => $this->input->post('poste'),
				        'password' => encode_password($this->input->post('password')),
				        'image' => 'empty_image.png',
				        'avatar' => 'empty_avatar.jpg',
				        'statut_id' => $this->input->post('statut_id'),
				        'service_id' => $this->input->post('service_id'),
				        'etablissement_id' => $this->input->post('etablissement_id'),
				        'email' => $this->input->post('email'),
				        'type_compte_id' => $this->input->post('account_type_id')
					);

        if($this->db->insert($this->table_user, $data)){
        	return $this->db->insert_id();
        }else{
        	return FALSE;
        }
	}
	/**
	 * update_user function
	 * - Modifie un user en base de données
	 * @return : TRUE OR FALSE
	 */
	public function update_user(){
		//** RECUPERATION DONNEES FORMULAIRE **
        $data = array(
				        'poste' => $this->input->post('poste'),
				        'password' => encode_password($this->input->post('password')),
				        'image' => 'empty_image.png',
				        'avatar' => 'empty_avatar.jpg',
				        'statut_id' => $this->input->post('statut_id'),
				        'service_id' => $this->input->post('service_id'),
				        'etablissement_id' => $this->input->post('etablissement_id'),
				        'email' => $this->input->post('email'),
				        'type_compte_id' => $this->input->post('account_type_id')
					);
		$this->db->where('id', $this->input->post('id_user'));

        if($this->db->update($this->table_user, $data)){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * delete_user function
	 * - Supprime un user de la base de données
	 * @return : TRUE OR FALSE
	 */
	public function delete_user(){
		//** TENTATIVE DE SUPPRESSION D'UN USER **
        if($this->db->delete($this->table_user, array('id' => $this->input->post('id_user')))){
        	return TRUE;
        }else{
        	return FALSE;
        }
	}
	/**
	 * dependance_scaners_service function
	 * - Vérifie s'il existe des users associés à un scaner en vue d'une suppression de scaner
	 * @return : TRUE OR FALSE
	 */
	public function dependance_users_scaner(){
		$query = $this->db->get_where($this->table_scaner_hab, array('scaner_id' => $this->input->post('id_scaner')));
    	$resultat = $query->num_rows();
    	if($resultat !== 0){
    		return FALSE;
    	}else{
    		return TRUE;
    	}
	}
	/**
	 * get_all_users function
	 * - Retourne tous les users
	 * @return : row OR Exception
	 */
	public function get_all_users_infos(){
        try{
            $requete = "SELECT * FROM $this->table_user";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}
	/**
	 * get_all_users function
	 * - Retourne tous les users
	 * @return : row OR Exception
	 */
	public function get_array_users_infos(){
        try{
			$requete = "SELECT distinct A.`id`, A.`poste`, A.`date_last_connection`, A.`statut_id`, 
						C.`libelle` as 'Service', D.`libelle` as 'Etablissement'
						FROM $this->table_user A
						LEFT JOIN $this->table_service C ON A.service_id = C.id
						LEFT JOIN $this->table_etablissement D ON A.etablissement_id = D.id";
            $res = $this->db->query($requete);
            $row = $res->result();
            $resultat = $row;
        }catch (PDOException $e){
            die("Erreur : ".$e->getMessage());
        }
        return $resultat;
	}

}
