		</div>
		<div class="footer-container">
			<div class="footer-bloc">
				______FOOTER______
			</div>
		</div>
		<!-- ************************************************* -->
		<!-- ****** CHARGEMENT FICHIER ASSOCIES A LA VUE ***** -->
		<!-- ************************************************* -->
		<?php if(isset($files)):?>
			<?php foreach ($files as $key => $file):?>
				<?php switch ($file[0]) {
					case 'php':
						require($file[1]);
						break;
					case 'js':
						echo '<script type="text/javascript" src="'.$file[1].'"></script>';
						break;
					default:
						break;
				} ?>
			<?php endforeach;?>
		<?php endif;?>
	</body>
</html>