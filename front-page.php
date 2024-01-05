<?php

use agitatie\taal as taal;

global $post;

get_header();

set_query_var('klassen_bij_primary', "voorpagina");

get_template_part('/sja/open-main');

set_query_var('veel_margin', true);

do_action('voorpagina_voor_tekst_action');

$cta = new Ag_knop(array(
    'tekst'		=> ucfirst(taal\streng('events')),
    'class'		=> 'in-wit',
    'link'		=> get_post_type_archive_link('agenda')
));
$cta->maak();

ag_tekstveld_ctrl(array(
    'formaat'		=> 'klein',
    'titel' 		=> ag_hero_model() === false ? $post->post_title : false,
    'titel_el'      => 'h1',
    'tekst'			=> $post->post_content . "\n\n". $cta->html,
));

ag_uitgelichte_afbeelding_ctrl();

do_action('voorpagina_na_tekst_action');

get_template_part('/sja/sluit-main');
get_footer();
