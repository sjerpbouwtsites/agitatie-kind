<?php

/* Template Name: page-with-cards */

get_header();
set_query_var('klassen_bij_primary', "singular");
get_template_part('/sja/open-main');

echo "<article class='bericht'>";

ag_uitgelichte_afbeelding_ctrl();

while (have_posts()) : the_post();
    echo "<div class='verpakking verpakking-klein marginveld titel-over-afbeelding-indien-aanwezig'>";

    do_action('ag_pagina_titel');

    do_action('ag_pagina_voor_tekst');

    echo "<div class='bericht-tekst'>";
    the_content();

    if(have_rows('kaart')):
        echo '<div class="art-lijst">';
        while(have_rows('kaart')) : the_row();

            $titel = get_sub_field('titel');
            $tekst = get_sub_field('tekst');
            $afbeelding = get_sub_field('afbeelding');
            $slug = sanitize_title($titel);

            echo '<article id="'.$slug.'" class="flex art-c in-lijst geen-datum">';
            var_dump($afbeelding);
            echo "<div class='art-links'>
        <img src='' alt='' width='' height='' />
        </div>";

            echo "<div class='art-rechts'>
                <header>
                    <h3 class='tekst-hoofdkleur'>$title</h3>
                </header>
                <p class='tekst-zwart'>
                    $tekst
                </p>
            </div>";

        endwhile;
        echo "</div";
    endif;

    echo "</div>";

    echo "</div>";
endwhile; // End of the loop.

echo "</article>";

do_action('ag_singular_na_artikel');

get_template_part('/sja/sluit-main');
get_footer();