<?php

use agitatie\taal as taal;


function ag_vp_print_nieuws_hook()
{
    $rider_stories = new WP_Query(array(
        'post_type' => 'story',
        'posts_per_page' => 6
    ));

    $vp_posts = new WP_Query(array(
        'posts_per_page' => 6
    ));

    if (count($rider_stories->posts) > 0) :
        echo "<section class='vp-stories verpakking verpakking-klein'>
		<h2>Rider stories</h2>
        
        <div class='art-lijst'>";

        foreach ($rider_stories->posts as $story) :
            if (!isset($a)) {
                $a = new Ag_article_c(array(
                    'class' => 'in-lijst',
                    'htype' => 3,
                    'geen_datum' => true,
                    'geen_afb' => false
                ), $story);
            } else {
                $a->art = $story;
            }

            $a->gecontroleerd = false;
            $a->print();

        endforeach;

        echo "</div>"; //art lijst
        archive_footer_link('story', 'More stories');
        echo "</section>";

    endif; //if stories


    echo "<section class='vp-nieuws verpakking verpakking-klein'>
	<h2>News</h2>";

    if (count($vp_posts->posts)) :
        echo "<div class='art-lijst'>";

        foreach ($vp_posts->posts as $vp_post) :

            if (!isset($a)) {
                $a = new Ag_article_c(array(
                    'class'         => 'in-lijst',
                    'htype'            => 3,
                    'geen_tekst'    => true,
                    'geen_datum' => false,
                    'datum' => true,
                    'geen_afb'        => false
                ), $vp_post);
            } else {
                $a->art = $vp_post;
            }

            $a->gecontroleerd = false;
            $a->print();

        endforeach;
        echo "</div>"; //art lijst
        archive_footer_link('post', 'More news');
        echo "</section>";

    endif;
}

function ag_kop_links()
{
    echo "<div class='stek-kop-links'><a href='" . taal\home_url() . "' class='radical-riders-title '>Radical Riders</a></div><!--koplinks-->";
}
function ag_logo_in_footer_hook()
{
    echo "<a href='" . taal\home_url() . "' class='radical-riders-title radical-riders-title--footer'>Radical Riders</a>";
}

function ag_no_date_stories_single()
{

    if (!array_key_exists('story', $_GET)) return;

    remove_action('ag_pagina_voor_tekst', 'ag_print_datum_ctrl');
}

add_action('after_setup_theme', 'ag_no_date_stories_single');

function ag_zoek_en_menu_footer()
{
    $menu_locations = get_nav_menu_locations();

    echo "<section  class='footer-section'>";

    if (array_key_exists('footer-taal', $menu_locations)) {
        echo "<h3>" . taal\streng('Schakel van taal') . "</h3>";
        $a = array(
            'theme_location'             => 'footer-taal',
            'menu_class'                => 'footer-taal',
            'container_class'            => 'footer-taal-container',
        );
        wp_nav_menu($a);
    }

    echo "    <h3>" . taal\streng('Zoeken') . "</h3>";
    get_search_form();


    echo "</section>";


    echo "<section  class='footer-section'>";

    if (array_key_exists('footer-menu', $menu_locations)) {

        echo "<h3>" . taal\streng('Menu') . "</h3>";
        $a = array(
            'theme_location'             => 'footer-menu',
            'menu_class'                => 'footer-menu',
            'container_class'            => 'footer-menu-container',
        );
        wp_nav_menu($a);
    }


    echo "</section>";
}

add_action('ag_footer_voor_velden_action', 'ag_zoek_en_menu_footer', 30);
