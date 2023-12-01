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

        $footerknop = new Ag_knop(array(
            'link' 		=> get_post_type_archive_link('post'),
            'tekst' 	=> ucfirst(\agitatie\taal\streng('alle')) . ' ' . \agitatie\taal\streng('posts'),
            'class'		=> 'in-wit'
        ));

        echo "<section class='vp-nieuws verpakking'>
				<h2>" . ucfirst(\agitatie\taal\streng('nieuws')) . "</h2>
					<div class='art-lijst'>";

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

add_action('voorpagina_na_tekst_action', 'ag_vp_print_nieuws_hook', 20);

function oyvey_vp_agenda()
{
    //$afm = ag_agenda_filter_ctrl();

    $agenda = new Ag_agenda(array(
        'aantal' => 100,
        'omgeving' => 'pagina'
    ));

    $types_verz = [];

    foreach ($agenda as $a) {
        $types_hier = wp_get_post_terms($a->ID, 'type');
        foreach($types_hier as $t) {
            $types_verz[] = $t;
        }
    }
    $types_set = array_unique($types_verz);

    var_dump($types_set);

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
// 	add_action('ag_singular_na_artikel', 'ag_vp_print_nieuws_hook' );
// }

// add_action('after_setup_theme', 'vervang_singular_na_artikel');
