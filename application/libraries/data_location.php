<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_location {
	//------------------------------------------------------------------------
	//------------------------------------------------------------------------
	//--- LIBRAIRIE DEFINISSANT DES INFORMATIONS RELATIVES A L'APPLICATION ---
	//------------------------------------------------------------------------
	//-------------- Il est possible de completer les tableaux ---------------
	//---------------- mais sans modifier les index existants ----------------
	//------------------------------------------------------------------------
	//**************************************************
	//************ get_horodatage_types ****************
	//*** Retourne le tableau des types d'horodatage ***
	//**************************************************
    public function get_horodatage_types(){
    	$arrayTypes  = array(
    							1 => array('id' => 1, 'value' => 'Demande', 'parametre' => 'default'),
    							2 => array('id' => 2, 'value' => 'Prélèvement', 'parametre' => '')
							);
    	return $arrayTypes;
    }
    //**************************************************
	//************** get_user_statuts ******************
	//** Retourne le tableau des statuts d'utilisateur *
	//**************************************************
    public function get_user_statuts(){
    	$arrayTypes  = array(
    							1 => array('id' => 1, 'value' => 'Admin'),
    							2 => array('id' => 2, 'value' => 'Laboratoire'),
    							3 => array('id' => 3, 'value' => 'Biologiste'),
    							4 => array('id' => 4, 'value' => 'Transporteur'),
    							5 => array('id' => 5, 'value' => 'Technicien')
							);
    	return $arrayTypes;
    }
    //**************************************************
	//************ get_user_account_types **************
	//********* Retourne le tableau des types **********
	//************ de comptes d'utilisateur ************
	//**************************************************
    public function get_user_account_types(){
    	$arrayTypes  = array(
    							1 => array('id' => 1, 'value' => 'Personnel'),
    							2 => array('id' => 2, 'value' => 'Générique')
							);
    	return $arrayTypes;
    }
    //**************************************************
	//************ get_default_data_columns ************
	// Retourne le tableau des colonnes des default_data
	// - default_comment: Colonne pour les commentaires 
	//**** par défaut des scaners **********************
	//**************************************************
    public function get_default_data_columns(){
    	$arrayTypes  = array(
    							1 => array('id' => 1, 'value' => 'default_comment')
							);
    	return $arrayTypes;
    }
    //**************************************************
	//************** searchKeyInArray ******************
	//*** Retourne l'index correspondant à une valeur **
	//**** donnée dans un tableau multidimensionel *****
	//@param: $table->array
	//@param: $colonne->la colonne de la valeur cherchée
	//@param: $val->la valeur recherchée
	//**************************************************
    function searchKeyInArray($table, $colonne, $val){
        foreach ($table as $key => $row){
            if ($row[$colonne] == $val){
                return $key;
            }
        }
        return -1;
    }
}