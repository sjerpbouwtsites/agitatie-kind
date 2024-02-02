<?php

global $wp_query;

use agitatie\taal as taal;

define('KIND_DIR', get_stylesheet_directory());
define('KIND_URI', get_stylesheet_directory_uri());

add_image_size('vierkant-480', 480, 480, true);

//deze klassen extenden die van de parent theme. Moet dus later geladen worden. functions.php wordt geladen in 'setup theme' dus daar wachten we op.
function kinder_klassen()
{
    include_once KIND_DIR . '/kind-klassen.php';
}

add_action('after_setup_theme', 'kinder_klassen');

include_once KIND_DIR . '/kind-gereedschap.php';
include_once KIND_DIR . '/kind-hooks.php';
include_once KIND_DIR . '/kind-vp-hooks.php';
include_once KIND_DIR . '/ctrl/agenda.php';
include_once KIND_DIR . '/overschrijvingen.php';
include_once KIND_DIR . '/event-shortcode.php';

function add_favicon_to_header()
{
    get_template_part('/sja/header/icons');
}

add_action('wp_head', 'add_favicon_to_header');

function add_search_to_header()
{
    get_template_part('/sja/header/search');
}

add_action('ag_kop_rechts_action', 'add_search_to_header');

function ag_kop_menu_ctrl()
{
    // 		global $wpdb;
    // 		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options WHERE option_id = 1", OBJECT );

    // 		SELECT *
    //   FROM wp_posts
    //  WHERE post_type = 'nav_menu_item';

    $menu_locations = get_nav_menu_locations();

    if (!array_key_exists('openklap-menu', $menu_locations)) {
        $adm_url = get_admin_url('nav-menus.php');
        echo "<p class='foutmelding'><a href='$adm_url'>👉 Todo: menu maken & aan kop toekennen.</a></p>";
        return;
    }

    if (array_key_exists('prio-menu', $menu_locations)) {
        $a = array(
            'theme_location' 			=> 'prio-menu',
            'menu_class'					=> 'prio-menu menu',
            'container_class'			=> 'prio-menu-container',
        );
        wp_nav_menu($a);
    }

    echo "
    <div class='stek-kop-knoppen'>
    <button
        id='zoekveldschakel'
        href='#'
        class='schakel kopmenu-mobiel'
        data-toon='#zoekveld'
        data-toon-soort='flex'
        data-anti='#menuschakel'
        aria-label='Zoeken'
        aria-haspopup='true'
        aria-expanded='false'
        data-f='focusZoekveld'>
        <span class='kop-in-button-text'>Zoeken</span>
        <i class='mdi mdi-magnify'></i>
        <i class='mdi mdi-window-close'></i>
    </button>
    <button
        id='menuschakel'
        href='#'
        aria-label='open menu'
        class='schakel kopmenu-mobiel'
        aria-haspopup='true'
        data-toon='.openklap-menu-container'
        aria-label='Open navigatie'
        aria-expanded='false'
        data-anti='#zoekveldschakel'>
        <span class='kop-in-button-text'>Menu</span>
        <i class='mdi mdi-menu'></i>
        <i class='mdi mdi-window-close'></i>
        
    </button>
    </div>
    ";
    // echo "<a id='mobiele-menu-schakel' href='#' class='schakel kopmenu-mobiel' data-toon='.stek-kop-rechts .openklap-menu-container'>
    // 			<span class='menu-menu-tekst'>Menu</span>";
    // ag_mdi('menu', true);
    // ag_mdi('close', true);
    // echo "</a>";

    $a = array(
        'theme_location' 			=> 'openklap-menu',
        'menu_class'					=> 'openklap-menu menu',
        'container_class'			=> 'openklap-menu-container',
    );
    wp_nav_menu($a);
}



function do_favicon_ag()
{
    wp_redirect(get_site_icon_url(32, KIND_URI."/icons/favicon-32x32.png"));
    exit;
}

add_action('do_faviconico', 'do_favicon_ag');

function agitatie_stijl_en_script()
{
    wp_enqueue_style('agitatie-stijl', THEME_URI . '/style.css', array(), null);
    wp_enqueue_style('kind-stijl', get_stylesheet_uri(), array('agitatie-stijl'), null);
    // wp_enqueue_script('kind-script', KIND_URI . '/resources/build/js/kind-bundel.js', array(), null, true);
}

add_action('wp_head', 'agitatie_stijl_en_script', 5);

$kind_config = array(
    // 'support'                      => array(
    //     'custom-logo'              => array(
    //        'height'                => 169,
    //        'width'                 => 400,
    //        'flex-width'            => true,
    //     ),
    // ),
    'archief'                      => array(
        'post' => array(
          'afb_formaat'             => 'vierkant-480'
        ),
        // 'story'                      => array(
        //     // 'geen_afb'             => true,
        //     'geen_datum'           => true,
        //     'exc_lim'              => 300
        // ),
        // 'download'                 => array(
        //     'geen_datum'           => true,
        //     'exc_lim'              => 300
        // )
    ),
    'agenda' => true,
    'downloads' => true,
    'post'                     => array(
        'taxonomieen'          => false
    )
    // 'content_width'                => 760

);
$kind_menus = array(
    //'voorpagina'
    'footer-menu' => esc_html__('footer-menu', 'agitatie'),
    'footer-taal' => esc_html__('footer-taal', 'agitatie'),
);
if (!function_exists('ag_config_agenda')) : function ag_config_agenda()
{
    $kind_config = $GLOBALS['kind_config'];

    if (!empty($kind_config) || (array_key_exists('agenda', $kind_config) && $kind_config['agenda'])) :

        // echo "a";
        // die();

        $agenda = new Posttype_voorb('event', 'events');
        $agenda->pas_args_aan(array(
            'has_archive' => true,
            'public' => true,
            'show_in_nav_menus' => true,

            'menu_icon' => 'dashicons-calendar-alt',
        ));

        $agenda->registreer();

        $tax_meervoud = 'locaties';
        $tax_enkelvoud = 'locatie';
        $agenda->maak_taxonomie($tax_enkelvoud, $tax_meervoud);
        register_taxonomy(
            $tax_enkelvoud,
            'event',
            array(
                'labels' => array(
                    'name' => _x($tax_meervoud, 'taxonomy general name'),
                    'singular_name' 	=> _x($tax_enkelvoud, 'taxonomy singular name'),
                ),
                'public' 	=> true,
                // 'rewrite'	=> array('slug'=>'agenda-plek'),
                'show_ui'   => true,
                'show_in_menu'=> true,
                'show_in_nav_menus'=> true,
            )
        );
        $tax_meervoud = 'soorten';
        $tax_enkelvoud = 'soort';
        $agenda->maak_taxonomie($tax_enkelvoud, $tax_meervoud);
        register_taxonomy(
            $tax_enkelvoud,
            'event',
            array(
                'labels' => array(
                    'name' => _x($tax_meervoud, 'taxonomy general name'),
                    'singular_name' 	=> _x($tax_enkelvoud, 'taxonomy singular name'),
                ),
                'public' 	=> true,
                // 'rewrite'	=> array('slug'=>'agenda-type'),
                'show_ui'   => true,
                'show_in_menu'=> true,
                'show_in_nav_menus'=> true,
            )
        );



    endif;
}
endif;

function preload_logo()
{
    $src = KIND_URI."/img/oy-vey-logo-anim.gif";
    echo "<link rel='preload' href='$src' as='image' type='image/gif' />";
}

add_action('wp_head', 'preload_logo');

add_action('after_setup_theme', 'ag_config_agenda');

function create_oyvey_team()
{
    $team = new Posttype_voorb('team', 'teams');

    $team->pas_args_aan(array(
        // 'publicly_queryable' => true,
        // 'show_in_nav_menus'	=> true,
        // 'show_in_menu'		=> true,
        // 'add_to_menu'		=> true,
        // 'public'			=> true,
        // 'has_archive' 		=> true,
        // 'exclude_from_search' => true,
        'supports' =>
            array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
            ),
    ));

    $team->registreer();
}

add_action('after_setup_theme', 'create_oyvey_team');

$kind_thumbs = array(
    /*	'voorpagina' => array(
        'naam'             => 'voorpagina',
        'breedte'          => 2000,
        'hoogte'           => 1000,
        'crop'             => true,
    )*/);



function registreer_posttypes()
{
    // ter voorbeeld

    // $story = new Posttype_voorb('story', 'stories');
    // $story->pas_args_aan(array(
    //     'menu_icon'           => 'dashicons-editor-quote',
    //     'description'         => "<div class='bericht-tekst'>
    //         <p>These are the stories of some of our riders.</p>
    //     </div>"
    // ));
    // $story->registreer();
}



function enable_svg_upload($upload_mimes)
{
    $upload_mimes['svg'] = 'image/svg+xml';



    $upload_mimes['svgz'] = 'image/svg+xml';



    return $upload_mimes;
}

add_filter('upload_mimes', 'enable_svg_upload', 10, 1);

function schakel_debug()
{
    if (is_user_logged_in()) :

        global $wp;
        $current_url = home_url(add_query_arg(array(), $wp->request));

        $is_debug = array_key_exists('debug', $_GET);

        $url = $is_debug ? str_replace('debug', '', $current_url) : "$current_url?debug=true";

        echo "<a class='schakel-debug' href='$url'>schakel debug</a>";
        $is_localhost = str_contains($current_url, 'localhost');
        $schakel_naar = $is_localhost ? 'staging' : 'localhost';
        $pad = str_replace('https://sjerpvanwouden.nl/oyvey', '', str_replace('http://localhost/oyvey', '', $current_url));
        $naar_url = $is_localhost ? "https://sjerpvanwouden.nl/oyvey$pad" : "http://localhost/oyvey$pad";
        echo "<a class='schakel-localhost' href='$naar_url'>schakel naar $schakel_naar</a>";

    endif;
}


add_action('wp_footer', 'schakel_debug');


function smartwp_remove_wp_block_library_css()
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_deregister_script('wp-mediaelement');
    wp_deregister_style('wp-mediaelement');
    wp_dequeue_style('classic-themes');
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100);

// Remove tags support from posts
function myprefix_unregister_tags()
{
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action('init', 'myprefix_unregister_tags');

// function register_media_tax()
// {
//     register_taxonomy(
//         'media-category',
//         'attachment',
//         array(
//             'labels' => array(
//                 'name' => _x('media categories', 'taxonomy general name'),
//                 'singular_name' 	=> _x('media category', 'taxonomy singular name'),
//             ),
//             'public' 	=> true,
//             // 'rewrite'	=> array('slug'=>'agenda-plek'),
//             'show_ui'   => true,
//             'show_in_menu'=> true,
//             'show_in_nav_menus'=> true,
//         )
//     );
// }

// add_action('after_setup_theme', 'register_media_tax');

// function column_id($columns)
// {
//     $terms = wp_get_post_terms(__('ID'), 'media-category');
//     ag_pre_dump($terms);
//     $columns['media-category'] = 'harry';
//     return $columns;
// }
// add_filter('manage_media_columns', 'column_id');

// function column_id_row($columnName, $columnID)
// {
//     if($columnName == 'media-category') {
//         echo $columnID;
//     }
// }
// add_filter('manage_media_custom_column', 'column_id_row', 10, 2);
