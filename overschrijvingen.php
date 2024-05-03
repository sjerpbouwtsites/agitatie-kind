<?php


// TODO DIT IS BEHOORLIJK OVERDONE

function ag_uitgelichte_afbeelding_ctrl()
{
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

    $gebruikt_fader_video = get_field('gebruikt_fader_video_in_plaats_van_uitgelichte_afbeelding', $post->ID);

    if ($gebruikt_fader_video) {
        get_template_part('sja/fader-video');
        return;
    }



    set_query_var('overschrijf_thumb_grootte', 'volle_breedte');

    if (!$hero_ar = ag_hero_model()) {
        set_query_var('heeft_hero', $hero_ar);
    } else {
        $hero_ar['heeft_hero'] = true;
        ag_array_naar_queryvars($hero_ar);
    }

    //op post met afbeelding
    if (!ag_is_festival()) {
        get_template_part('sja/afb/uitgelichte-afbeelding-buiten');
    } else {
        //op cat of op post zonder afbeelding
        //heeft cat afb?

        $afb_verz = get_field('cat_afb', 'category_'.$wp_query->queried_object_id);

        if (ag_is_festival()) {
            set_query_var('heeft_hero', true);
            $img = "<img
				src='{$afb_verz['sizes']['bovenaan_art']}'
				alt='{$afb_verz['alt']}'
				height='{$afb_verz['sizes']['bovenaan_art-width']}'
				width='{$afb_verz['sizes']['bovenaan_art-height']}'
			/>";

            set_query_var('expliciete_img', $img);
            echo "<div class='uitgelichte-afbeelding-buiten hero'>";
            get_template_part('sja/afb/post-afb-met-desc');
            echo "</div>";
            return;
        }


        if ($afb_verz and $afb_verz !== '') {
            $img = "<img
				src='{$afb_verz['sizes']['lijst']}'
				alt='{$afb_verz['alt']}'
				height='{$afb_verz['sizes']['lijst-width']}'
				width='{$afb_verz['sizes']['lijst-height']}'
			/>";

            set_query_var('expliciete_img', $img);

            echo "<div class='uitgelichte-afbeelding-buiten hero'>";
            get_template_part('sja/afb/post-afb-met-desc');
            echo "</div>";
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
            //echo "<h2 class='tekst-wittig geen-margin-top lineheight-fix' >" . \agitatie\taal\streng('Nieuw bij de Vrije Teelt?') . "</h2>";

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

if (!function_exists('ag_archief_generiek_loop')) : function ag_archief_generiek_loop($post, $afb_formaat = 'lijst', $exc_lim_o = false)
{
    //@TODO dit naar functie hierboven
    global $wp_query;

    $basis_array = array(
        'exc_lim' 		=> $exc_lim_o ? $exc_lim_o : 230,
        'class'			=> 'in-lijst',
        'taxonomieen' 	=> true
    );


    global $kind_config;

    if (
        $kind_config and
        array_key_exists('archief', $kind_config) and
        array_key_exists($post->post_type, $kind_config['archief']) and
        count($kind_config['archief'][$post->post_type])
    ) {
        foreach ($kind_config['archief'][$post->post_type] as $s => $w) {
            $basis_array[$s] = $w;
        }
    }

    if (ag_is_festival()) {
        $m_art = new Ag_article_festival_c($basis_array, $post);

        if (isset($m_art)) {
            $m_art->afb_formaat	= $afb_formaat;
            $m_art->print();
        }
    } else {
        $m_art = new Ag_article_c($basis_array, $post);

        if (isset($m_art)) {
            $m_art->afb_formaat	= $afb_formaat;
            $m_art->print();
        }
    }
}
endif;
