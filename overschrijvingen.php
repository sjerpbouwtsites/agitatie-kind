<?php


// TODO DIT IS BEHOORLIJK OVERDONE

function ag_uitgelichte_afbeelding_ctrl() {

	global $post;
	global $wp_query;

	// volgende pagina's hebben MOGELIJK een afbeelding.
	// page / page-template
	// single
	// categorie / taxonomie

	if (!in_array('true', array(
		$wp_query->is_singular,
		$wp_query->is_category,
		$wp_query->is_tax,
	))) {
		return false;
	}

    set_query_var('overschrijf_thumb_grootte', 'volle_breedte');

	if (!$hero_ar = ag_hero_model()) {
		set_query_var('heeft_hero', $hero_ar);
	} else {
		$hero_ar['heeft_hero'] = true;
		ag_array_naar_queryvars($hero_ar);
	}


	//op post met afbeelding
	if (!$wp_query->is_category and has_post_thumbnail($post)) {
		get_template_part('sja/afb/uitgelichte-afbeelding-buiten');
	} else {

		//op cat of op post zonder afbeelding
		//heeft cat afb?
		$afb_verz = get_field('cat_afb', 'category_'.$wp_query->queried_object_id);

		if ($afb_verz and $afb_verz !== '') {

			$img = "<img
				src='{$afb_verz['sizes']['lijst']}'
				alt='{$afb_verz['alt']}'
				height='{$afb_verz['sizes']['lijst-width']}'
				width='{$afb_verz['sizes']['lijst-height']}'
			/>";

			set_query_var('expliciete_img', $img);
			get_template_part('sja/afb/uitgelichte-afbeelding-buiten');
		} else {
			get_template_part('sja/afb/geen-uitgelichte-afbeelding');
		}

	}

}



function ag_vp_print_menu()
	{

		$locaties = get_nav_menu_locations();

		if (array_key_exists('voorpagina', $locaties)) {

			$menu = wp_get_nav_menu_object($locaties['voorpagina']);

			if (empty($menu)) {
				return;
			}
			$menu_stukken = wp_get_nav_menu_items($menu->term_id);

			if ($menu_stukken and count($menu_stukken)) :

				echo "<section class='vp-menu verpakking paddingveld marginveld veel normale-padding achtergrond-hoofdkleur'>";
				echo "<h2 class='tekst-wittig geen-margin-top lineheight-fix' >" . \agitatie\taal\streng('Nieuw bij de Vrije Teelt?') . "</h2>";

				echo "<nav class='knoppendoos groot'>";
				foreach ($menu_stukken as $menu_stuk) {
					$k = new Ag_knop(array(
						'link' 		=> $menu_stuk->url,
						'tekst'		=> $menu_stuk->title,
						'class'		=> 'in-kleur'
					));
					$k->print();
				}
				echo "</nav>"; //Ag_knoppendoos

				echo "</section>";

			endif;
		}
	}

