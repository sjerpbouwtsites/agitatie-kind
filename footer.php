<footer id='stek-voet' class='stek-voet'>
	<div class='verpakking verpakking-klein logo-en-tekst'>
		<div class='neg-marge'>
			<?php

            //do_action('ag_footer_voor_velden_action');

            $voet_velden = get_field('footervelden', 'option');
			if ($voet_velden and count($voet_velden)) :

			    foreach ($voet_velden as $v) :

			        if (array_key_exists('titel', $v) and $v['titel'] !== '') {
			            echo "<section  class='footer-section'>
						<h3>{$v['titel']}</h3>
						" . apply_filters('the_content', $v['veld']) . "
					</section>";
			        } else {
			            echo "<div class='footer-section'>
						" . apply_filters('the_content', $v['veld']) . "
					</div>";
			        }

			    endforeach;

			endif;

			?>
			
			<div id='zoekveld-footer'>

<form role="search" method="get" class="search-form search-form--footer" action="<?=SITE_URI?>">
    <label>
        <span class="screen-reader-text">Zoeken naar:</span>
        <input class="search-field invoerveld" placeholder="Zoeken …" value="" name="s" type="search">
    </label>
    <label for='footer-zoekveld' aria-label='Doe zoekopdracht'>
        <input id='footer-zoekveld' class="search-submit" style='display:none' value="Zoeken" type="submit">
        <i class='mdi mdi-arrow-right-thick'></i>
    </label>
</form>

</div>
			<?php

			//do_action('ag_footer_na_velden_action');

			?>
		</div>
	</div>

	<?php


    do_action('ag_footer_widget_action');

			get_template_part('sja/footer/colofon');

			?>

</footer>

<script>
	var BASE_URL = "<?= SITE_URI ?>",
		TEMPLATE_URL = "<?= THEME_URI ?>",
		IMG_URL = "<?= IMG_URI ?>",
		AJAX_URL = BASE_URL + "/wp-admin/admin-ajax.php";
		KIND_URL = "<?=KIND_URI?>";
</script>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type='module' src="<?= THEME_URI ?>/resources/build/js/bundel.js"></script>
<script type='module' src="<?= THEME_URI ?>/../agitatie-kind/resources/build/js/kind-bundel.js"></script>

<?php wp_footer(); ?>

</body>

</html>