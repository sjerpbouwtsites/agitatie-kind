<?php

get_header();
set_query_var('klassen_bij_primary', "home verpakking");
get_template_part('/sja/open-main');


echo "<div class='marginveld veel'>";

do_action('ag_pagina_titel');

echo "<div class='art-lijst'>";

if (have_posts()) : while (have_posts()) : the_post();

    ag_print_lijst_ctrl($post, '3', 140);

endwhile; endif;

echo "</div>";//art-lijst

        //@ TODO @OPLEVERING ?

ag_paginering_ctrl();


echo "</div>"; //marginveld

get_template_part('/sja/sluit-main');
get_footer();
