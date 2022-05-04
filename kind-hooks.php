<?php

use agitatie\taal as taal;

function ag_kop_links()
{
    echo "<div class='stek-kop-links'><a href='" . taal\home_url() . "' class='horeca-united-title '>Horeca United</a></div><!--koplinks-->";
}
function ag_logo_in_footer_hook()
{
    echo "<a href='" . taal\home_url() . "' class='horeca-united-title horeca-united-title--footer'>Horeca United</a>";
}

function ag_no_date_stories_single()
{

    if (!array_key_exists('story', $_GET)) return;

    remove_action('ag_pagina_voor_tekst', 'ag_print_datum_ctrl');
}

add_action('after_setup_theme', 'ag_no_date_stories_single');
