<script type="text/javascript">
	$(document).ready(function(){
		//*** RECUPERATION ARRAY FILTRES ***
		var array_filtres = <?php if ( isset($filtres) ) echo json_encode($filtres) ;?>;
		if ( array_filtres.length != 0 ){
			get_data_filtre_type(array_filtres['filtre_type'], array_filtres['filtre']);
		}

		//*** INPUT DATE ***
		$( '#date-debut, #date-fin').datepicker({
	        showOn: "both",
	        beforeShow: custom_range_datepicker,
	        dateFormat: "dd/mm/yy",
	        firstDay: 1, 
	        changeFirstDay: false
	    });
	    //*** SUPPRESSION BOUTONS TRIGGER DATEPICKER ***
	    $( 'button[class=ui-datepicker-trigger]' ).css("display", "none");
	});

	//***********************************
	//** SELECTION D'UN FILTRE TYPE *****
	//***********************************
	$('select[name="filtre-type"]').change(function(){
		var filtre_type = $(this).val()
		if(filtre_type != 0){
			get_data_filtre_type(filtre_type, '');
		}
	});

	//*************************************************************************
	//** FOCNTION DE RECUPERATION DE DONNEES EN FONCTION D'UN FILTRE TYPE *****
	//*************************************************************************
	function get_data_filtre_type(filtre_type, filtre){
		var user_id = '<?=get_session_user_id($this)?>';
		var method_called = "";
		switch(filtre_type){
			case '1':
			method_called = 'getFullHabilitationScaner';
				break;
			case '2':
			method_called = 'getFullHabilitationService';
				break;
			case '3':
			method_called = 'getFullHabilitationEtablissement';
				break;
			default:
				break;
		}
		$.ajax({
			url: '<?=base_url();?>index.php/ajax_caller_controller/' + method_called,
			type: 'POST',
			datatype: 'json',
			data: { user_id: user_id },
			success:function(response){
				var obj = JSON.parse(response);
				construct_select_filtre('filtre', obj['data'], filtre_type, filtre);
			},
			error: function(error){
				console.log('Erreur: ' + error);
			}
		});
	}

	//************************************************
	//** GESTION PERMISSION INPUT HIDDEN FORMULAIRE **
	//************************************************
	$('select[name="filtre"]').change(function(){
		var permission = $('option:selected', this).attr('permission');
		$( 'input[name=permission]' ).attr("value", permission);
	});

	//************************************************
	//** GESTION SELECT APRES SELECTION FILTRE TYPE **
	//************************************************
	function construct_select_filtre(select_name, array_options, filtre_type, filtre){
		//*** SUPPRESSION OPTIONS EXISTANTES ***
		$('select[name='+select_name+']').empty();

		//*** SI VARIABLE NON VIDE ***
		if ( array_options ){
			$('select[name='+select_name+']').append($('<option>', { 
		        value: "",
		        text: 'Selectionner',
		        permission: 0 
		    }));
			for ( var index in array_options ){
				//****************************
				//*** FILTRE ETABLISSEMENT ***
				//****************************
				if ( filtre_type == 3 ){
					$('select[name='+select_name+']').append($('<option>', { 
				        value: array_options[index]['etablissement_id'],
				        text: array_options[index]['libelle'],
				        permission: array_options[index]['permission']
				    }));
				    //*** RECHERCHE FILTRE ***
				    if ( filtre['id'] != '' && array_options[index]['etablissement_id'] == filtre['id'] ){
				    	
				    	$( 'select[name='+select_name+'] option[value='+array_options[index]['etablissement_id']+']' ).attr("selected", "selected");
					}
				}
				//****************************
				//****** FILTRE SERVICE ******
				//****************************
				else if ( filtre_type == 2 ){
					$('select[name='+select_name+']').append($('<option>', { 
				        value: array_options[index]['service_id'],
				        text: array_options[index]['libelle_short'] + ' ' + array_options[index]['libelle'],
				        permission: array_options[index]['permission']
				    }));
				    //*** RECHERCHE FILTRE ***
				    if ( filtre['id'] != '' && array_options[index]['service_id'] == filtre['id'] ){
				    	
				    	$( 'select[name='+select_name+'] option[value='+array_options[index]['service_id']+']' ).attr("selected", "selected");
					}
				}
				//****************************
				//****** FILTRE SCANER *******
				//****************************
				else if ( filtre_type == 1 ){
					$('select[name='+select_name+']').append($('<option>', { 
				        value: array_options[index]['scaner_id'],
				        text: array_options[index]['libelle_short_etablissement'] + ' ' + array_options[index]['libelle_short_service'] + ' ' + array_options[index]['libelle'],
				        permission: array_options[index]['permission']
				    }));
				    //*** RECHERCHE FILTRE ***
				    if ( filtre['id'] != '' && array_options[index]['scaner_id'] == filtre['id'] ){
				    	
				    	$( 'select[name='+select_name+'] option[value='+array_options[index]['scaner_id']+']' ).attr("selected", "selected");
					}
				}
			}
		}else{
			$('select[name='+select_name+']').append($('<option>', { 
		        value: -1,
		        text: 'Aucun',
		        permission: 0 
		    }));
		}
	}

	//****************************************
	//*** CONTROLE ECART DATE DEBUT ET FIN ***
	//****************************************
	function custom_range_datepicker(input) {
	    var min = new Date(2008, 11 - 1, 1), //Set this to your absolute minimum date
	        dateMin = min,
	        dateMax = null,
	        dayRange = 30; // Set this to the range of days you want to restrict to

	    if (input.id === "date-debut") {
	        if ( $( '#date-fin' ).datepicker("getDate") != null ) {
	            dateMax = $( '#date-fin' ).datepicker("getDate");
	            dateMin = $( '#date-fin' ).datepicker("getDate");
	            dateMin.setDate(dateMin.getDate() - dayRange);
	            if (dateMin < min) {
	                dateMin = min;
	            }
	        }
	        else {
	            dateMax = new Date; //Set this to your absolute maximum date
	        }                      
	    }
	    else if (input.id === "date-fin") {
	        dateMax = new Date; //Set this to your absolute maximum date
	        if ( $( '#date-debut' ).datepicker("getDate") != null ) {
	            dateMin = $( '#date-debut' ).datepicker("getDate");
	            var rangeMax = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + dayRange);

	            if(rangeMax < dateMax) {
	                dateMax = rangeMax; 
	            }
	        }
	    }
	    return {
	        minDate: dateMin, 
	        maxDate: dateMax
	    };     
	}
</script>