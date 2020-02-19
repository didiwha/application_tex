<?php
	//*************************************************************************************************
	//************************* FONCTIONS ASSOCIATION DES TABLES **************************************
	//*************************************************************************************************
	//*************************************************************
	/************ main_database_loader Function *******************
	** - Retourne la nom de la base de données principale
	** - Définis dans Application/config/database.php
	**************************************************************/
	function main_database_loader(){
		return "tex";
	}
	//-----------------------------------------------------------
	//************************ USER_TABLE ***********************
	//-----------------------------------------------------------
	function get_user_table(){
		return "adm_ent_user";
	}
	function create_table_user(){
		$requete = "CREATE TABLE `".get_user_table()."` (
						  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
						  `poste` varchar(10) NOT NULL,
						  `password` varchar(50) NOT NULL,
						  `statut_id` varchar(20) NOT NULL,
						  `image` varchar(20) NOT NULL,
						  `avatar` varchar(20) NOT NULL,
						  `service_id` int(11) NOT NULL,
						  `etablissement_id` int(11) NOT NULL,
						  `nom` varchar(30) NULL,
						  `prenom` varchar(30) NULL,
						  `fonction` varchar(50) NULL,
						  `email` varchar(30) NOT NULL,
						  `date_last_connection` datetime DEFAULT NULL,
						  `date_last_update_password` datetime DEFAULT NULL,
						  `type_compte_id` int(11) NOT NULL DEFAULT '0'
						) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		return $requete;
	}
	function insert_defaul_data_table_user(){
		$requete = "INSERT INTO `".get_user_table()."` (`id`, `poste`, `password`, `statut_id`, `image`, `avatar`, `service_id`, `etablissement_id`, `nom`, `prenom`, `fonction`, `email`, `date_last_connection`, `date_last_update_password`, `type_compte_id`) 
			VALUES (2, 'admin', '$2y$05$dccmp8hQQapRZc1i0aTiKOegi3lfgE4y7qNXMMBExG5', '1', 'empty_image.png', 'empty_avatar.jpg', 0, 0, NULL, NULL, NULL, 'admin@email.com', '2016-03-06 13:00:59', NULL, 1);";
	    return $requete;
	}
	//-----------------------------------------------------------
	//********************** SCANER_TABLE ***********************
	//-----------------------------------------------------------
	function get_scaner_table(){
		return "adm_ent_scaner";
	}
	function create_scaner_table(){
		$requete = "CREATE TABLE `".get_scaner_table()."` (
					  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					  `libelle` varchar(50) NOT NULL,
					  `libelle_short` varchar(4) NOT NULL,
					  `image` varchar(50) NULL,
					  `service_id` int(11) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		return $requete;
	}
	//-----------------------------------------------------------
	//********************* SERVICE_TABLE ***********************
	//-----------------------------------------------------------
	function get_service_table(){
		return "adm_ent_service";
	}
	function create_service_table(){
		$requete = "CREATE TABLE `".get_service_table()."` (
					   `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					   `libelle` varchar(200) NOT NULL,
					   `libelle_short` varchar(4) NOT NULL,
					   `statut_id` int(11) NOT NULL,
					   `service_cible_id` int(11) NOT NULL,
					   `code_correspondant` varchar(10) NOT NULL,
					   `etablissement_id` int(11) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8";

		return $requete;
	}
	//-----------------------------------------------------------
	//******************** ETABLISSEMENT_TABLE ******************
	//-----------------------------------------------------------
	function get_etablissement_table(){
		return "adm_ent_etablissement";
	}
	function create_etablissement_table(){
		$requete = "CREATE TABLE `".get_etablissement_table()."` (
					   `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					   `libelle` varchar(40) NOT NULL,
					   `libelle_short` varchar(4) NOT NULL,
					   `code` varchar(15) DEFAULT NULL,
					   `adresse` varchar(150) NOT NULL,
					   `code_postal` varchar(5) NOT NULL,
					   `ville` varchar(50) NOT NULL,
					   `telephone` varchar(10) NOT NULL,
					   `email` varchar(50) NOT NULL,
					   `date_enregistrement` datetime NOT NULL,
					   `identifiant` varchar(15) NOT NULL,
					   `password` varchar(100) NOT NULL,
					   `source` int(11) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		return $requete;
	}
	//-----------------------------------------------------------
	//******************* FONCTION_TABLE ************************
	//-----------------------------------------------------------
	function get_fonction_table(){
		return "adm_ent_fonction";
	}
	function create_fonction_table(){
		$requete = "CREATE TABLE `".get_fonction_table()."` (
					   `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					   `libelle` varchar(15) NOT NULL,
					   `libelle_short` varchar(30) NOT NULL,
					   `statut` int(11) NOT NULL,
					   `image` varchar(30) NOT NULL,
					   `controller` varchar(30) NOT NULL,
					   `ordre` int(11) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		return $requete;
	}
	function insert_defaul_data_table_fonction(){
		$requete = "INSERT INTO `".get_fonction_table()."` (`id`, `libelle`, `libelle_short`, `statut`, `image`, `controller`, `ordre`) 
			VALUES (1, 'horodateur', 'Horodateur', 1, 'image_fonction_1.png', 'horodateur_controller', 1),
				   (2, 'tracabilite', 'Tracabilité', 1, 'image_fonction_2.png', 'tracabilite_controller', 1);";
	    return $requete;
	}
	//-----------------------------------------------------------
	//****************** FONCTION_HAB_TABLE *********************
	//-----------------------------------------------------------
	function get_fonction_hab_table(){
		return "adm_hab_fonction";
	}
	function create_fonction_hab_table(){
		$requete = "CREATE TABLE `".get_fonction_hab_table()."` (
				    	`user_id` int(11) NOT NULL,
				    	`fonction_id` int(11) NOT NULL,
  						`permission` int(11) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		return $requete;
	}
	//-----------------------------------------------------------
	//****************** SCANER_HAB_TABLE ***********************
	//-----------------------------------------------------------
	function get_scaner_hab_table(){
		return "adm_hab_scaner";
	}
	function create_scaner_hab_table(){
		$requete = "CREATE TABLE `".get_scaner_hab_table()."` (
				    	`user_id` int(11) NOT NULL,
				    	`scaner_id` int(11) NOT NULL,
  						`permission` int(11) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		return $requete;
	}
	//-----------------------------------------------------------
	//****************** SERVICE_HAB_TABLE ***********************
	//-----------------------------------------------------------
	function get_service_hab_table(){
		return "adm_hab_service";
	}
	function create_service_hab_table(){
		$requete = "CREATE TABLE `".get_service_hab_table()."` (
				    	`user_id` int(11) NOT NULL,
				    	`service_id` int(11) NOT NULL,
  						`permission` int(11) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		return $requete;
	}
	//-----------------------------------------------------------
	//****************** ETABLISSEMENT_HAB_TABLE ***********************
	//-----------------------------------------------------------
	function get_etablissement_hab_table(){
		return "adm_hab_etablissement";
	}
	function create_etablissement_hab_table(){
		$requete = "CREATE TABLE `".get_etablissement_hab_table()."` (
				    	`user_id` int(11) NOT NULL,
				    	`etablissement_id` int(11) NOT NULL,
  						`permission` int(11) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		return $requete;
	}
	//-----------------------------------------------------------
	//****************** HORODATEUR_TABLE *********************
	//-----------------------------------------------------------
	function get_horodateur_table(){
		return "fnct_horodateur";
	}
	function create_horodateur_table(){
		$requete = "CREATE TABLE `".get_horodateur_table()."` (
					  `id` int(11) NOT NULL,
					  `numero` varchar(12) NOT NULL,
					  `date` datetime NOT NULL,
					  `commentaire` varchar(50) NOT NULL,
					  `user_id` int(11) NOT NULL,
					  `scaner_id` int(11) NOT NULL,
					  `horodatage_type_id` int(1) NOT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		return $requete;
	}
	//-----------------------------------------------------------
	//************* HORODATEUR_COMMENTAIRE_TABLE ****************
	//-----------------------------------------------------------
	function get_horodateur_commentaire_table(){
		return "fnct_horodateur_commentaire";
	}
	function create_horodateur_commentaire_table(){
		$requete = "CREATE TABLE `".get_horodateur_commentaire_table()."` (
					  `com_id` int(11) NOT NULL,
					  `com_numero_demande` varchar(10) NOT NULL,
					  `com_id_scaner` varchar(3) NOT NULL,
					  `com_coursier` varchar(50) DEFAULT NULL,
					  `com_secretaire` varchar(50) DEFAULT NULL,
					  `com_temperature` varchar(50) DEFAULT NULL,
					  `com_examens` varchar(100) DEFAULT NULL,
					  `com_commentaire` varchar(100) DEFAULT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		return $requete;
	}
	//-----------------------------------------------------------
	//************* DEFAULT_DATA_TABLE ******************
	//-----------------------------------------------------------
	function get_default_data_table(){
		return "adm_default_data";
	}
	function create_default_data_table(){
		$requete = "CREATE TABLE `".get_default_data_table()."` (
					 `id` int(11) NOT NULL,
					 `data_value` varchar(30) NOT NULL,
					 `data_reference` varchar(10) DEFAULT NULL,
					 `data_type` varchar(10) DEFAULT NULL,
					 `data_parameter` varchar(10) DEFAULT NULL
					) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		return $requete;
	}
	//*************************************************************************************************
	//********************** SCRIPTS DE CREATION DE BASE/TABLES/COLONNES ******************************
	//*************************************************************************************************
?>