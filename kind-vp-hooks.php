<?php

function vp_preload_video_images()
{
    global $post;
    if (is_front_page()) {
        $preload = get_field('preload', $post->ID);
        if (!$preload) {
            return;
        }
        echo "<link rel='preload' href='".$preload['sizes']['portfolio']."' as='image' type='image/webp' />";
    }
}

add_action('wp_head', 'vp_preload_video_images', 50);



if (!function_exists('ag_vp_print_nieuws_hook')) : function ag_vp_print_nieuws_hook()
{
    $vp_posts = new WP_Query(array(
        'posts_per_page' => 3
    ));

    if (count($vp_posts->posts)) :

        echo "<section class='verpakking marginveld vp-nieuws voorpagina-sectie'>";

        echo "<h2 class='gecentreerde-titel serif-letter tekst-zijkleur'>" . ucfirst(\agitatie\taal\streng('nieuws')) . "</h2>";

        $footerknop = new Ag_knop(array(
            'link' 		=> get_post_type_archive_link('post'),
            'tekst' 	=> ucfirst(\agitatie\taal\streng('alle')) . ' ' . \agitatie\taal\streng('berichten'),
            'class'		=> 'in-wit'
        ));

        echo  "<div class='art-lijst'>";

        foreach ($vp_posts->posts as $vp_post) :
            if (!isset($a)) {
                $a = new Ag_article_c(array(
                    'class' 		=> 'in-lijst',
                    'htype'			=> 3,
                    'geen_afb'		=> false,
                    'afb_formaat'   => 'vierkant-480'
                ), $vp_post);
            } else {
                $a->art = $vp_post;
            }
            $a->gecontroleerd = false;

            $a->print();
        endforeach;

    echo "</div>"; //art lijst
    echo "<footer class='voorpagina-sectie-footer'>";
    $footerknop->print();
    echo "</footer>";

    echo "</section>";

    endif;
}
endif;


function ag_vp_print_joods_genoeg_afb_in_post_content()
{
    global $post;
    $post->post_content .= "
    <figure class='element-naast-tekst element-naast-tekst-links joods-genoeg-afbeelding-buiten'>
        <img src='".site_url('wp-content/uploads/2023/08/Am-I-Jewish-Enough.png')."' width='1080' height='1080' alt='Je bent Joods genoeg grafiek'>
    </figure>
    <figure class='element-naast-tekst element-naast-tekst-rechts oy-vey-logo-in-tekst'>
        <img src='".site_url('wp-content/uploads/2023/12/New-Oy-Vey-Logo1.svg')."' alt='Wapen van joodse culturele verenging Oy Vey' width='500' height='500' />
    </figure>
    ";
}

//add_action('voorpagina_voor_tekst_action', 'ag_vp_print_joods_genoeg_afb_in_post_content', 01);

function oyvey_vp_agenda()
{
    //$afm = ag_agenda_filter_ctrl();

    $agenda = new Ag_agenda(array(
        'aantal' => 6,
        'omgeving' => 'pagina'
    ));

    // $types_id_verz = [];
    // $types = [];
    // $type_counts = [];

    // foreach ($agenda->agendastukken as $a) {
    //     $types_hier = wp_get_post_terms($a->ID, 'soort');
    //     foreach($types_hier as $t) {
    //         $types_id_verz[] = $t->term_taxonomy_id;
    //         $cur_count = $type_counts[$t->term_taxonomy_id] || 0;
    //         $type_counts[$t->term_taxonomy_id] = $cur_count + 1;
    //         $types[$t->term_taxonomy_id] = $t;
    //     }
    // }

    echo "<section class='verpakking marginveld oyvey-agenda-voorpagina voorpagina-sectie'>";

    echo "<h2 class='serif-letter tekst-zijkleur gecentreerde-titel'>" . ucfirst(\agitatie\taal\streng('onze events')) . "</h2>";

    echo "<div class='art-lijst'>";

    foreach ($agenda->agendastukken as $as) {
        $a = new Ag_article_c(array(
            'class' 		=> 'in-lijst',
            'htype'			=> 3,
            'afb_formaat'   => 'vierkant-480'
        ), $as);
        $a->print();
    }

    // $types_set = array_splice(array_unique($types_id_verz), 0, 6);

    // foreach ($types_set as $type_id) {
    //     $type = $types[$type_id];
    //     $type->name = $type->name . "<br><small class='tekst-grijs'>" .$type_counts[$type_id]." ".\agitatie\taal\streng('gepland')."</small>";
    //     $a = new Ag_article_c(array(
    //         'class' 		=> 'in-lijst',
    //         'htype'			=> 3,
    //         'is_categorie'	=> true,
    //         'afb_formaat'   => 'portfolio'
    //     ), $type);
    //     $a->print();
    // }


    echo "</div>";

    $footerknop = new Ag_knop(array(
        'link' 		=> get_post_type_archive_link('event'),
        'tekst' 	=> ucfirst(\agitatie\taal\streng('volledige agenda')),
        'class'		=> 'in-wit'
    ));
    echo "<footer class='voorpagina-sectie-footer'>";
    $footerknop->print();
    echo "</footer>";

    echo "</section>";

    // if (count($agenda->agendastukken) > 0) :

    //     echo "<section class='verpakking verpakking-klein marginveld'>";
    //     echo "<div class='agenda'>
    // 		<h2>Agenda</h2>";

    //     $agenda->print();
    //     echo "</div>";
    //     echo "</section>";

    // endif; // als agendastukken
}

add_action('voorpagina_na_tekst_action', 'oyvey_vp_agenda', 25);

function oyvey_vp_extra_tekst()
{
    global $post;


    $content = apply_filters('the_content', get_field('voorpagina_onder_video', $post->ID));

    $content = str_replace('<h2>', '<h2 class="gecentreerde-titel serif-letter tekst-zijkleur">', $content);

    echo "<section class='verpakking verpakking marginveld tekstveld oyvey-extra-tekst-voorpagina voorpagina-sectie'>";

    //echo "<h2 class='serif-letter tekst-zijkleur gecentreerde-titel'>" . ucfirst(\agitatie\taal\streng('onze events')) . "</h2>";

    echo $content;

    echo "</section>";
}

add_action('voorpagina_na_tekst_action', 'oyvey_vp_extra_tekst', 1);
