<?php
	/* ---------------------------------------------------------------------------------------
	* ---------------------------------- FONCTIONS GLOABLES ----------------------------------
	* --------------------------------------------------------------------------------------*/
	//--------------------------------------------------------------------------
	//------------------------- FORMATAGE DONNEES ------------------------------
	//--------------------------------------------------------------------------
	//*************************************************************
	/*********** formate_date_to_datetimeMySQL function ***********
    *** Formate une date passée en parametre ***
    * @PARAM: $date -> dd/mm/yyyy *********************************
    * @PARAM: $date_type -> 1 debut jour; 2 fin jour **************
    * @m_return: $datetimeMySQL -> yyyy-mm-dd hh:mm:ss ************
    **************************************************************/
	function formate_date_to_datetimeMySQL($date, $date_type){
		$array_date = explode('/', $date);
		$datetimeMySQL = $array_date[2].'-'.$array_date[1].'-'.$array_date[0];
		
		if($date_type == 1){
			$datetimeMySQL .= ' 00:00:00';
		}
		else if($date_type == 2){
			$datetimeMySQL .= ' 23:59:59';
		}

		return $datetimeMySQL;
	}