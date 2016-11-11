<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_caller_controller extends CI_Controller {
        
    /*
    ** La méthode index regroupe toutes les fonctions du controleur **
    ** et redirige les demandes entrantes sur ces fonctions **
    */
    function index(){
        return null;
    }
    /******************************************************************************
    ******************* LISTE DES APPELS AJAX DU CONTROLEUR ***********************
    ******************************************************************************/
    /**
     * Fonction getFullHabilitationScaner
     * Retournant tous les scaners auquels
     * est habilité un utilisateur
     */
    public function getFullHabilitationScaner(){
        //$this->load->model('Etablissement_model');
        //$this->input->post('user_id');
        echo json_encode('Scaner');
    }
    /**
     * Fonction getFullHabilitationService
     * Retournant tous les services auquels
     * est habilité un utilisateur
     */
    public function getFullHabilitationService(){
        //$this->load->model('Etablissement_model');
        //$this->input->post('user_id');
        echo json_encode('Service');
    }
    /**
     * Fonction getFullHabilitationEtablissement
     * Retournant tous les etablissement auquels
     * est habilité un utilisateur
     */
    public function getFullHabilitationEtablissement(){
        $this->load->model('Habilitations_model');
        $data = $this->Habilitations_model->get_hab_etablissements_by_user($this->input->post('user_id'));
        $arrayReturn = [];
        $arrayReturn['data'] = $data;
        echo json_encode($arrayReturn);
    }    
}