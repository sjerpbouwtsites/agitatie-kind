<?php

get_header();

define('POST_TYPE_NAAM', ag_post_naam_model());

set_query_var('klassen_bij_primary', "archief archief-" . POST_TYPE_NAAM);
get_template_part('/sja/open-main');

$afb_verz = get_field('medestrijders_achtergrond', 'option');

if ($afb_verz and $afb_verz !== '') {

  $img = "<img
    src='{$afb_verz['sizes']['lijst']}'
    alt='{$afb_verz['alt']}'
    height='{$afb_verz['sizes']['lijst-width']}'
    width='{$afb_verz['sizes']['lijst-height']}'
  />";

  set_query_var('heeft_hero', false);
  set_query_var('expliciete_img', $img);

  get_template_part('sja/afb/uitgelichte-afbeelding-buiten');
}

echo "<div class='marginveld titel-over-afbeelding-indien-aanwezig  veel verpakking'>";

do_action('ag_archief_titel_action');

do_action('ag_archief_intro_action');

do_action('ag_archief_content_action');

do_action('ag_archief_na_content_action');

do_action('ag_archief_footer_action');

echo "</div>";


get_template_part('/sja/sluit-main');

get_footer();
