<?php 
    $error_msg = $this->session->flashdata('error');
    $info_msg = $this->session->flashdata('info');
    if (isset($error_msg)){
        echo'<div class="container-fluid message-error-container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 bloc-message-error">
						<div class="row">
							<div class="col-md-8 col-md-offset-2 content-message-error">
								'.$error_msg.'
							</div>
						</div>
					</div>
				</div>
			</div>';
    }elseif (isset($info_msg)){
    	echo'<div class="container-fluid message-info-container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 bloc-message-info">
						<div class="row">
							<div class="col-md-8 col-md-offset-2 content-message-info">
								'.$info_msg.'
							</div>
						</div>
					</div>
				</div>
			</div>';
    }
?>