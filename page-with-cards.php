<?php

/* Template Name: page-with-cards */

get_header();
set_query_var('klassen_bij_primary', "singular");
get_template_part('/sja/open-main');

echo "<article class='bericht'>";


while (have_posts()) : the_post();
    echo "<div class='verpakking verpakking-klein marginveld titel-over-afbeelding-indien-aanwezig'>";

    do_action('ag_pagina_titel');
    ag_uitgelichte_afbeelding_ctrl();

    do_action('ag_pagina_voor_tekst');

    echo "<div class='bericht-tekst'>";
    the_content();

    if(have_rows('kaart')):
        echo '<div class="art-lijst art-lijst__cards">';
        while(have_rows('kaart')) : the_row();

            $titel = get_sub_field('titel');
            $tekst = get_sub_field('tekst');
            $afbeelding = get_sub_field('afbeelding');
            $slug = sanitize_title($titel);
            $soort = get_sub_field('soort');

            echo '<article id="'.$slug.'" class="flex art-c in-lijst geen-datum card-artikel">';

            echo "<div class='art-links'>
        <img src='".$afbeelding['sizes']['portfolio']."' alt='".$afbeelding['alt']."' width='600' height='600' />
        </div>";

            echo "<div class='art-rechts'>
                <header>
                    <h3 class='tekst-hoofdkleur'>$titel</h3>
                </header>
                <div class='tekst-hoofdkleur'>
                    $tekst
                </div>
            </div>";
            if ($soort):


                $a = new Ag_article_c(array(
                    'class' 		=> 'in-lijst in-card tekst-hoofdkleur-wit event-title-link',
                    'htype'			=> 4,
                    'geen_afb'      => true,
                    'geen_datum'    => true,
                    'is_categorie'	=> true,
                    'afb_formaat'   => 'portfolio',
                    'geen_meer_tekst'=> true,
                    'geen_tekst'=> true,
                    'korte_titel'=> true
                ), $soort);
                $a->art->name = $a->art->name . " " . ucfirst(\agitatie\taal\streng('events'));


                $agenda_model = new Ag_agenda(array(
                    'aantal' => 10,
                    'omgeving' => 'pagina',
                    'nep_post' => array(
                        'soort' => $soort->slug
                    )
                ));

                if (count($agenda_model->agendastukken) > 0) :

                    echo "<div class='art-card-tax-list art-lijst'>";

                    $a->print();

                    foreach ($agenda_model->agendastukken as $as) :

                        $a = new Ag_article_c(array(
                            'class' 		=> 'in-lijst in-card tekst-hoofdkleur-wit',
                            'htype'			=> 5,
                            'afb_formaat'   => 'portfolio',
                             'geen_afb'      => true,
                             'geen_datum'    => true,
                             'geen_meer_tekst'=> true,
                             'geen_tekst'=> true,
                        ), $as);

                        $datum = "<span class='datum-float-rechts tekst-lichtgrijs'>".explode(' ', get_field('datum', $as->ID))[0] . "</span>";
                        $a->art->post_title = $a->art->post_title . " " . $datum;

                        $a->print();



                    endforeach;

                    echo "</div>";

                endif;




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
