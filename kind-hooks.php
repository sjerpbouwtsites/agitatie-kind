<?php

use agitatie\taal as taal;

add_filter('the_content', 'voeg_auteur_toe_aan_content_op_single', 1);

function voeg_auteur_toe_aan_content_op_single($content)
{
    global $post;

    if (is_singular() && in_the_loop() && !is_front_page() && $post->post_type === 'post') {
        $a = get_the_author();
        return "<span class='auteur'>Door $a</span>" . $content;
    }

    return $content;
}

if (!function_exists('ag_archief_content_hook')) : function ag_archief_content_hook()
{
    // global $wp_query;
    // echo "<pre>";
    // var_dump($wp_query);
    // echo "</pre>";

    ag_archief_content_ctrl();
    ag_archief_sub_tax_ctrl();
}
endif;

// function vervang_singular_na_artikel(){
// 	remove_action('ag_singular_na_artikel', 'ag_singular_taxonomieen', 20);
// 	add_action('ag_singular_sna_artikel', 'ag_vp_print_nieuws_hook' );
// }

// add_action('after_setup_theme', 'vervang_singular_na_artikel');


function ag_logo_in_footer_hook()
{
    $blog_url = site_url();
    $img = $blog_url."/wp-content/uploads/2023/12/oy-vey-letters-white.svg";
    echo "<a 
        href='$blog_url' 
        class='custom-logo-link' 
        rel='home' 
        aria-current='page'>
            <img 
                width='280' 
                height='280' 
                src='$img' 
                class='custom-logo' 
                alt='logo joodse culturele vereniging oy vey' 
                decoding='async' 
            />
        </a>";
}


function print_tax_blok()
{
    if (!is_post_type_archive()) {
        return;
    }

    global $post;

    $tax_blok = new Ag_tax_blok(array(
        'post'		=> $post,
        'titel'		=> \agitatie\taal\streng('kijk verder bij').':',
        'reset'		=> false,
        'uitgesloten'=> ['locatie']
    ));
    $tax_blok->print();
}
add_action('ag_archief_na_content_action', 'print_tax_blok', 15);

if(!function_exists('ag_print_footer_widgets')) : function ag_print_footer_widgets()
{
    global $wp_registered_sidebars;

    if (array_key_exists('footer-sidebar', $wp_registered_sidebars)) { ?>
 
     <div class='verpakking verpakking-klein widgets'>
         <div class='neg-marge'>
             <?php dynamic_sidebar('footer'); ?>
         </div>
     </div>
     <?php
    }
} endif;

function zet_faders_in_post_content($content)
{
    global $post;
    $pt = $post->post_type;
    if ($pt !== 'post' && $pt !== 'page') {
        return $content;
    }

    $heeft_fader = get_field('gebruikt_fader_videos_in_tekst', $post->ID);
    if (!$heeft_fader) {
        return $content;
    }

    $faders = get_field('faders', $post->id);

    $faders_html = array();

    for ($i = 0; $i < count($faders); $i++) {
        $fa = $faders[$i];
        ob_start();
        set_query_var('afbeeldingen', $fa['afbeeldingen']);
        set_query_var('fader_counter', $i);
        get_template_part('sja/fader-video');
        $html = ob_get_clean();
        $j = $i +1;
        $str_to_replace = "%%FADER-$j%%";
        $content = str_replace($str_to_replace, $html, $content);
    }

    return $content;
}

add_filter('the_content', 'zet_faders_in_post_content');

if (!function_exists('ag_logo_ctrl')) : function ag_logo_ctrl($print = true)
{
    if (!has_custom_logo()) {
        // if (is_user_logged_in()) {
        // 	$logo_url = wp_customize_url();
        // 	echo "<p class='foutmelding'><a href='$logo_url'>👉Todo: logo</a></p>";
        // 	return;
        // }

        echo "<a href='" . taal\home_url() . "' class='custom-logo geen-logo' rel='home' itemprop='url'>";
        echo get_bloginfo();
        echo "</a>";
        return;
    }

    $logo = "<a 
        href='".home_url()."' 
        class='custom-logo-link' 
        rel='home' 
        aria-current='page'>
            <img 
            width='280' 
            height='280' 
            src='".KIND_URI."/img/oy-vey-logo-anim.gif' 
            class='custom-logo' 
            alt='Oy Vey radicaal inclusieve joodse cultuur' 
            decoding='async' 
            fetchpriority='high' />
        </a>";

    $str = "<span class='serif-letter tekst-hoofdkleur'>".taal\streng("Radicaal inclusieve Joodse cultuur")."</span>";
    if ($print) {
        //the_custom_logo();
        echo  $logo;
        echo $str;
    } else {
        //the_custom_logo();
        return $logo.$str;
    }
}
endif;

function ag_generieke_titel()
{
    global $post;
    global $wp_query;

    //als hero, dan geen titel.
    if (ag_hero_model()) {
        return;
    }

    if ($wp_query->is_home) {
        echo "<h1 class='gecentreerde-titel serif-letter tekst-zijkleur is-home-titel'>" . get_the_title(get_option('page_for_posts', true)) . "</h1>";
    } elseif ($wp_query->is_search) {
        $zocht = ucfirst(taal\streng('je zocht'));
        $watzoekje = ucfirst(taal\streng('wat zoek je'));
        echo "<h1 class='gecentreerde-titel serif-letter tekst-zijkleur is-search-titel'>" . ($_GET['s'] !== '' ? ucfirst($zocht) . ": " . $_GET['s'] : ucfirst($watzoekje) . "?") . "</h1>";
    } elseif ($post->post_type === 'post' || $post->post_type === 'page') {
        $heeft_fader = get_field('gebruikt_fader_video_in_plaats_van_uitgelichte_afbeelding', $post->ID);
        $heeft_fader_class = $heeft_fader ? 'heeft-fader' : '';
        echo "<h1 class='$heeft_fader_class gecentreerde-titel serif-letter tekst-zijkleur is-page-of-post-titel'>" . ucfirst($post->post_title) . "</h1>";
    } else {
        echo "<h1 class='gecentreerde-titel serif-letter tekst-zijkleur is-overige-titel'>" . ucfirst($post->post_title) . "</h1>";
    }
}

if (!function_exists('ag_archief_titel_ctrl')) : function ag_archief_titel_ctrl()
{
    if ($archief_titel = ag_archief_titel_model()) {
        if ($archief_titel === 'Teams') {
            $archief_titel = "Team Oy Vey";
        }
        echo "<h1 class='serif-letter tekst-zijkleur gecentreerde-titel is-archief-titel'>" . $archief_titel . "</h1>";
    }
}
endif;


if (!function_exists('ag_archief_content_ctrl')) : function ag_archief_content_ctrl()
{
    global $post;
    global $kind_config;

    $extra_class = '';

    if (
        isset($kind_config) and
        isset($post) &&
        property_exists($post, 'post_type') &&
        array_key_exists('archief', $kind_config) and
        array_key_exists($post->post_type, $kind_config['archief'])
    ) {
        if (
            array_key_exists('geen_afb', $kind_config['archief'][$post->post_type]) and
            $kind_config['archief'][$post->post_type]['geen_afb']
        ) {
            $extra_class = 'geen-afb-buiten';
        }
    }

    echo "<div id='archief-lijst' class='tekstveld marginveld art-lijst $extra_class'>";
    if (have_posts()) : while (have_posts()) : the_post();

        //maakt post type objs aan en print @ controllers
        ag_archief_generiek_loop($post, 'portfolio');

    endwhile;
    else :

        get_template_part('sja/niets-gevonden');

    endif;
    echo "</div>";
}
endif;
