<?php
	/* ---------------------------------------------------------------------------------------
	* ----------------------------------- UTILITY FONCTIONS ----------------------------------
	* --------------------------------------------------------------------------------------*/
	/***************************************************************
	****************** XMLRPC_SERVER ******************************
	*** Défini vers quel server on va chercher les informations ***
	* ******* Par défaut c'est l'url du server local : ************
	*      return $server_url = site_url('xmlrpc_server');
	* ****** Par défaut c'est le port 80 :*************************
	*             return $server_port = 80;
	********* SYNTAXE DIFFERENTE POUR LES APPELS AJAX *************
	* ******* Par défaut c'est l'url du server local : ************
	*  return $server_url = base_url().'index.php/xmlrpc_server';
	**************************************************************/
	function xmlRpc_server(){
	    return $server_url = site_url('xmlrpc_server');
	}
	function xmlRpc_port(){
	    return $server_port = 8888;
	}
	function getXmlRpc_Server_Ajax(){
	    return $server_url = base_url().'index.php/xmlrpc_server';
	}
	//*************************************************************
	/****************** getSession function ***********************
    *** Vérifie que l'utilisateur est bien identifié ***
    * - Check du champ "logged_in" de la session courante
    * - Redirection vers page accueil [home_view] si FALSE
    **************************************************************/
    function getSession($controller){
        $session = $controller->session;
        if (!get_session_logged_in($controller)){
            redirect('main_controller', 'refresh');
        }
        //var_dump($controller->router->fetch_class());
        //var_dump($controller->session);
    }
    //*************************************************************
	/**************** requiredStatut function *********************
    *** Vérifie que l'utilisateur est bien habilité à accèder  ****
    *** à une fonction qui require un statut particulier **********
    * - Check du champ "statut_id" de la session courante
    * - Redirection vers page accueil [home_view] si FALSE
    **************************************************************/
    function requiredStatut($required_statut_id, $controller){
        $session = $controller->session;
        if (get_session_user_statut_id($controller) !== $required_statut_id){
            redirect('main_controller', 'refresh');
        }
    }
    //*************************************************************
	/****************** delete_file Function **********************
	** - Supprime un fichier s'il existe
	* @param: $file (chemin complet du fichier)
	**************************************************************/
    function delete_file($file){
    	if(file_exists($file)){
    		unlink($file);
		}
    }
	//*************************************************************
	/************ set_image_scaner_name Function ******************
	** - Nomme l'image d'un scaner avec son id 
	* @param: $scaner_id
	**************************************************************/
	function set_image_scaner_name($scaner_id){
		return "image_scaner_".$scaner_id.".png";
	}
	//*************************************************************
	/********** get_image_scaner_temp_name Function ***************
	** - Retourne le nom temproraire de l'image d'un scaner 
	** - à partir de son id 
	* @param: $scaner_id
	**************************************************************/
	function get_image_scaner_temp_name($scaner_id){
		return "temp_".set_image_scaner_name($scaner_id);
	}
	//*************************************************************
	/********** set_temp_image_scaner_name Function ***************
	** - Renomme l'image d'un scaner avec son id de facon temporaire
	* @param: $scaner_id
	**************************************************************/
	function set_temp_image_scaner_name($scaner_id){
		$image_name = set_image_scaner_name($scaner_id);
		$image_name_temp = "temp_".$image_name;
		rename(ressources_images_scaners_path().$image_name, ressources_images_scaners_path().$image_name_temp);
	}
	//*************************************************************
	/********** set_temp_image_scaner_name Function ***************
	** - Renomme l'image d'un scaner avec son id de facon temporaire
	* @param: $scaner_id
	**************************************************************/
	function set_no_temp_image_scaner_name($scaner_id){
		$image_name = set_image_scaner_name($scaner_id);
		$image_name_temp = "temp_".$image_name;
		rename(ressources_images_scaners_path().$image_name_temp, ressources_images_scaners_path().$image_name);
	}
	//*************************************************************
	/************** get_date_from_datetime Function ***************
	** - Retourne la date seule d'un format datetime
	* @param: $datetime TYPE: yyyy-mm-dd hh:mm:ss
	* @return: string dd-mm-yyyy
	**************************************************************/
	function get_date_from_datetime($datetime){
		$array_1 = explode('-',explode(' ', $datetime)[0]);
		return $array_1[2].'-'.$array_1[1].'-'.$array_1[0];
	}
	//*************************************************************
	/************** get_date_from_datetime Function ***************
	** - Retourne la date seule d'un format datetime
	* @param: $datetime TYPE: yyyy-mm-dd hh:mm:ss
	* @return: string hh:mm:ss
	**************************************************************/
	function get_heure_from_datetime($datetime){
		$array_1 = explode(':',explode(' ', $datetime)[1]);
		return $array_1[0].':'.$array_1[1].':'.$array_1[2];
	}
	//*************************************************************
	/************* getColorFromDateTimeDelay Function *************
	** - Retourne une couleur en fonction de l'ecart 
	** - entre une date passée en parametre et la date courante
	* @param: $datetime TYPE: yyyy-mm-dd hh:mm:ss
	* @return: string couleur_code ex:#000000
	**************************************************************/
	function getColorFromDateTimeDelay($datetime){
		$PhpDate = strtotime($datetime);
		$FormattedPhpDate = date('Y-m-d H:i:s', $PhpDate );
		$FormattedDate = date("Y-m-d H:i:s", $PhpDate );
		$dateNow = date('Y-m-d H:i:s');

		list($annee,$mois,$jour,$h,$m,$s) = sscanf($dateNow,"%d-%d-%d %d:%d:%d");
		$jour = $jour-2;
		$timestamp = mktime($h,$m,$s,$mois,$jour,$annee);
		$dateJours = date('Y-m-d H:i:s',$timestamp);
		
		list($annee,$mois,$jour,$h,$m,$s) = sscanf($dateNow,"%d-%d-%d %d:%d:%d");
		$jour = $jour-7;
		$timestamp = mktime($h,$m,$s,$mois,$jour,$annee);
		$dateSemaine = date('Y-m-d H:i:s',$timestamp);

		list($annee,$mois,$jour,$h,$m,$s)=sscanf($dateNow,"%d-%d-%d %d:%d:%d");
		$mois--;
		$timestamp = mktime($h,$m,$s,$mois,$jour,$annee);
		$dateMois = date('Y-m-d H:i:s',$timestamp);
		
		list($annee,$mois,$jour,$h,$m,$s)=sscanf($dateNow,"%d-%d-%d %d:%d:%d");
		$annee--;
		$timestamp = mktime($h,$m,$s,$mois,$jour,$annee);
		$dateAnnee = date('Y-m-d H:i:s',$timestamp);

		//*** Couleur de base: noire ***
		$color = "#000000";

		if ($FormattedPhpDate > $dateAnnee)
		{
			//*** Couleur durée supérieure à une année **
			$color = "#B25107";
			if ($FormattedPhpDate > $dateMois)
			{
				//*** Couleur durée supérieure à un mois **
				$color = "#E8820F";
				if ($FormattedPhpDate > $dateSemaine)
				{
					//*** Couleur durée supérieure à une semaine **
					$color = "#B9DC2A";
					if ($FormattedPhpDate > $dateJours){
						//*** Couleur durée supérieure à deux jours **
						$color = "#2ED445";
					}
				}
			}
		}
		return $color;
	}

	//------------------------------------------------------------------------------------------------
	// include_controller    *******   Like render_controller Symfony
	//------------------------------------------------------------------------------------------------
    function include_controller($chemin, $class = "menu_controller", $method = NULL, $arguments = array()) {

        $chemin_complet = $_SERVER["DOCUMENT_ROOT"] . '/site_test/application/controllers/' . $chemin . '.php';
        //$chemin_complet = base_url().'application/controllers/'.$chemin.'.php';

        // On verifie que le fichier existe et on l'inclue
        if (is_file($chemin_complet)) {
            include_once($chemin_complet);
        } else {
            show_error('Le fichier ' . $chemin_complet . ' n\'existe pas');
            return FALSE;
        }

        //$class = ($class == NULL) ? ucfirst(array_pop(explode('/', $chemin))) : $class;
        $method = ($method == NULL) ? 'index' : $method;

        // on instancie un objet de la classe
        $object = new $class();

        // on retourne le resultat de la methode avec les arguments 
        return $object->$method(implode(', ', $arguments));
    }
?>