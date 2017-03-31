<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application_version {
    //**************************************************
    //************ get_application_version *************
    //*** Retourne le tableau du type et version appli *
    //**************************************************
    public function get_application_version(){
        $arrayVersion  = array(   
                                'type' => 'developpement', 'version' => '1.0'
                              );
        return $arrayVersion;
    }
}