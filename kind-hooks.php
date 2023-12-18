<?php


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

if (!function_exists('ag_vp_print_nieuws_hook')) : function ag_vp_print_nieuws_hook()
{
    $vp_posts = new WP_Query(array(
        'posts_per_page' => 6
    ));

    if (count($vp_posts->posts)) :

        echo "<section class='verpakking marginveld vp-nieuws'>";

        echo "<h2>" . ucfirst(\agitatie\taal\streng('nieuws')) . "</h2>";

        $footerknop = new Ag_knop(array(
            'link' 		=> get_post_type_archive_link('post'),
            'tekst' 	=> ucfirst(\agitatie\taal\streng('alle')) . ' ' . \agitatie\taal\streng('berichten'),
            'class'		=> 'in-wit'
        ));

        echo  "<div class='art-lijst'>";

        foreach ($vp_posts->posts as $vp_post) :
            if (!isset($a)) {
                $a = new Ag_article_c(array(
                    'class' 		=> 'in-lijst',
                    'htype'			=> 3,
                    'geen_afb'		=> false
                ), $vp_post);
            } else {
                $a->art = $vp_post;
            }
            $a->gecontroleerd = false;

            $a->print();
        endforeach;

    echo "</div>"; //art lijst
    echo "<footer>";
    $footerknop->print();
    echo "</footer>";

    echo "</section>";

    endif;
}
endif;


function ag_vp_print_joods_genoeg_afb_in_post_content()
{
    global $post;
    $post->post_content .= "
    <figure class='element-naast-tekst element-naast-tekst-links joods-genoeg-afbeelding-buiten'>
        <img src='".site_url('wp-content/uploads/2023/08/Am-I-Jewish-Enough.png')."' width='1080' height='1080' alt='Je bent Joods genoeg grafiek'>
    </figure>
    <figure class='element-naast-tekst element-naast-tekst-rechts oy-vey-logo-in-tekst'>
        <img src='".site_url('wp-content/uploads/2023/12/New-Oy-Vey-Logo1.svg')."' alt='Wapen van joodse culturele verenging Oy Vey' width='500' height='500' />
    </figure>
    ";
}

add_action('voorpagina_voor_tekst_action', 'ag_vp_print_joods_genoeg_afb_in_post_content', 01);

function oyvey_vp_agenda()
{
    //$afm = ag_agenda_filter_ctrl();

    $agenda = new Ag_agenda(array(
        'aantal' => 100,
        'omgeving' => 'pagina'
    ));

    $types_id_verz = [];
    $types = [];
    $type_counts = [];

    foreach ($agenda->agendastukken as $a) {
        $types_hier = wp_get_post_terms($a->ID, 'soort');
        foreach($types_hier as $t) {
            $types_id_verz[] = $t->term_taxonomy_id;
            $cur_count = $type_counts[$t->term_taxonomy_id] || 0;
            $type_counts[$t->term_taxonomy_id] = $cur_count + 1;
            $types[$t->term_taxonomy_id] = $t;
        }
    }

    echo "<section class='verpakking marginveld oyvey-agenda-voorpagina'>";

    echo "<h2>" . ucfirst(\agitatie\taal\streng('onze events')) . "</h2>";

    echo "<div class='art-lijst'>";

    $types_set = array_splice(array_unique($types_id_verz), 0, 6);

    foreach ($types_set as $type_id) {
        $type = $types[$type_id];
        $type->name = $type->name . "<br><small class='tekst-grijs'>" .$type_counts[$type_id]." ".\agitatie\taal\streng('gepland')."</small>";
        $a = new Ag_article_c(array(
            'class' 		=> 'in-lijst',
            'htype'			=> 3,
            'is_categorie'	=> true,
        ), $type);
        $a->print();
    }


    echo "</div>";

    $footerknop = new Ag_knop(array(
        'link' 		=> get_post_type_archive_link('agenda'),
        'tekst' 	=> ucfirst(\agitatie\taal\streng('bekijk de volledige agenda')),
        'class'		=> 'in-wit'
    ));
    echo "<footer>";
    $footerknop->print();
    echo "</footer>";

    echo "</section>";

    // if (count($agenda->agendastukken) > 0) :

    //     echo "<section class='verpakking verpakking-klein marginveld'>";
    //     echo "<div class='agenda'>
    // 		<h2>Agenda</h2>";

    //     $agenda->print();
    //     echo "</div>";
    //     echo "</section>";

    // endif; // als agendastukken
}

add_action('voorpagina_na_tekst_action', 'oyvey_vp_agenda', 25);

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
