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

// function vervang_singular_na_artikel(){
// 	remove_action('ag_singular_na_artikel', 'ag_singular_taxonomieen', 20);
// 	add_action('ag_singular_na_artikel', 'ag_vp_print_nieuws_hook' );
// }

// add_action('after_setup_theme', 'vervang_singular_na_artikel');
