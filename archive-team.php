<?php

get_header();

define('POST_TYPE_NAAM', ag_post_naam_model());

set_query_var('klassen_bij_primary', "archief archief-" . POST_TYPE_NAAM);
get_template_part('/sja/open-main');

ag_uitgelichte_afbeelding_ctrl();

echo "<div class='marginveld titel-over-afbeelding-indien-aanwezig  veel verpakking'>";

do_action('ag_archief_titel_action');

do_action('ag_archief_intro_action');

//do_action('ag_archief_content_action');
global $post;
global $kind_config;

$extra_class = '';

if (
    isset($kind_config) and
    array_key_exists('archief', $kind_config) and
    array_key_exists($post->post_type, $kind_config['archief'])
) {
    if (
        array_key_exists('geen_afb', $kind_config['archief'][$post->post_type]) and
        $kind_config['archief'][$post->post_type]['geen_afb']
    ) {
        $extra_class = 'geen-afb-buiten';
    }
}

echo "<div id='archief-lijst' class='tekstveld art-lijst $extra_class'>";
if (have_posts()) : while (have_posts()) : the_post();

    //maakt post type objs aan en print @ controllers
    //ag_archief_generiek_loop($post);

    $basis_array = array(
        'exc_lim' 		=> $exc_lim_o ? $exc_lim_o : 230,
        'class'			=> 'in-lijst',
        'geen_datum'    => true,
        'taxonomieen' 	=> true
    );

    global $kind_config;

    if (
        $kind_config and
        array_key_exists('archief', $kind_config) and
        array_key_exists($post->post_type, $kind_config['archief']) and
        count($kind_config['archief'][$post->post_type])
    ) {
        foreach ($kind_config['archief'][$post->post_type] as $s => $w) {
            $basis_array[$s] = $w;
        }
    }

    $m_art = new Ag_article_c($basis_array, $post);

    if (isset($m_art)) {
        $m_art->afb_formaat	= $afb_formaat;
        $m_art->print();
    }


endwhile;
else :

    get_template_part('sja/niets-gevonden');

endif;
echo "</div>";

do_action('ag_archief_na_content_action');

do_action('ag_archief_footer_action');

echo "</div>";


get_template_part('/sja/sluit-main');

get_footer();
