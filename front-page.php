<?php

use agitatie\taal as taal;

global $post;

get_header();

set_query_var('klassen_bij_primary', "voorpagina");

get_template_part('/sja/open-main');

set_query_var('veel_margin', false);

do_action('voorpagina_voor_tekst_action');

$cta2 = new Ag_knop(array(
    'tekst'		=> ucfirst(taal\streng('pak nieuwsbrief')),
    'class'		=> 'scroll nieuwsbrief-knop',
    'link'		=> '#mc4wp-form-1'
));
$cta2->maak();

$cta = new Ag_knop(array(
    'tekst'		=> ucfirst(taal\streng('events')),
    'class'		=> 'evenementen-knop',
    'link'		=> get_post_type_archive_link('event')
));
$cta->maak();

$knoppendoos = "<div class='knoppendoos groot'>$cta2->html $cta->html</div>";

ob_start();
set_query_var('afbeeldingen', get_field('afbeeldingen', $post->ID));
get_template_part('sja/fader-video');
$fader_html = ob_get_clean();

ag_pre_dump(ag_hero_model());

ag_tekstveld_ctrl(array(
    'formaat'		=> 'groot',
    'titel' 		=> ag_hero_model() === false ? $post->post_title : false,
    'titel_el'      => 'h1',
    'tekst'			=> $post->post_content . $knoppendoos,
    'class'         => 'is-voorpagina-titel-en-tekst',
    'html_onder' => $fader_html
));

//ag_uitgelichte_afbeelding_ctrl();

do_action('voorpagina_na_tekst_action');

get_template_part('/sja/sluit-main');
get_footer();
