<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xmlrpc_server extends CI_Controller {
        
    /*
    ** La méthode index regroupe toutes les fonctions du controleur **
    ** et redirige les demandes entrantes sur ces fonctions **
    */
    function index(){
        $config['functions']['Connexion'] = array('function' => 'Xmlrpc_server.connexion');
        
        $config['object'] = $this;

        $this->xmlrpcs->initialize($config);
        $this->xmlrpcs->serve();
    }
    
    /******************************************************************************
    ******************* LISTE DES ACTIONS DE CE CONTROLEUR ************************
    ******************************************************************************/
    /*
     ** Controleur - HOME **
     * Vérification identifiants de Connexion *
     */
    public function connexion($request){
        $parameters = $request->output_parameters();
        $this->load->model('User_model');
        $ligneSession = $this->User_model->verification_identifiant($parameters[0]['identifiant'],$parameters[0]['password']);
        var_dump($ligneSession);
        if($ligneSession !== ""){
            $response = array(array('poste'  => $ligneSession[0]->poste),
                                    'struct');
        }else{
            $response = "erreur";
        }
        /*if ($parameters[0]['identifiant'] == "JOSE" && $parameters[0]['password'] == "je"){
            $response = TRUE;
        }else{
            $response = FALSE;
        }*/
        return $this->xmlrpc->send_response($response);
    }    
}