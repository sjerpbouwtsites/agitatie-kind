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
            $soort = get_sub_field('soort');

            echo '<article id="'.$slug.'" class="flex art-c in-lijst geen-datum">';

            echo "<div class='art-links'>
        <img src='".$afbeelding['sizes']['medium']."' alt='".$afbeelding['alt']."' width='300' height='200' />
        </div>";

            echo "<div class='art-rechts'>
                <header>
                    <h3 class='tekst-hoofdkleur'>$titel</h3>
                </header>
                <p class='tekst-zwart'>
                    $tekst
                </p>
            </div>";
            if ($soort):

                echo "<div class='art-card-tax-list'>";
                $a = new Ag_article_c(array(
                    'class' 		=> 'in-lijst',
                    'htype'			=> 3,
                    'geen_afb'      => true,
                    'geen_datum'    => true,
                    'is_categorie'	=> true,
                    'geen_meer_tekst'=> true,
                    'geen_tekst'=> true,
                    'korte_titel'=> true
                ), $soort);
                $a->print();

                $agenda_model = new Ag_agenda(array(
                    'aantal' => 10,
                    'omgeving' => 'pagina',
                    'nep_post' => array(
                        'soort' => $soort->slug
                    )
                ));

                if (count($agenda_model->agendastukken) > 0) : foreach ($agenda_model->agendastukken as $as) :


                    $a = new Ag_article_c(array(
                        'class' 		=> 'in-lijst',
                        'htype'			=> 3,
                        // 'geen_afb'      => true,
                        // 'geen_datum'    => true,
                        // 'is_categorie'	=> true,
                        // 'geen_meer_tekst'=> true,
                        // 'geen_tekst'=> true,
                        // 'korte_titel'=> true
                    ), $as);

                    echo "<pre>";
                    var_dump($a);
                    echo "</pre>";

                    $a->print();
                endforeach; endif;




                echo "</div>";
            endif;
            echo "</article>";
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
