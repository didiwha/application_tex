<script type="text/javascript">
	$(document).ready(function(){
	});
	$('select[name="filtre-type"]').change(function(){
		var filtre_type = $(this).val()
		if(filtre_type != 0){
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
					construct_select_filtre('filtre', obj['data'], filtre_type);
				},
				error: function(error){
					console.log('Erreur: ' + error);
				}
			});
		}
		
	});

	function construct_select_filtre(select_name, array_options, filtre_type){
		for (var index in array_options){
			$('select[name='+select_name+']').append($('<option>', { 
		        value: array_options[index]['etablissement_id'],
		        text: array_options[index]['libelle'],
		        permission: array_options[index]['permission'] 
		    }));
		}
	}
</script>