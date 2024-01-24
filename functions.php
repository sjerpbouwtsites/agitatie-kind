<?php

global $wp_query;

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

function create_hexagon_grid($hexagon_list)
{
    echo "<style>
    #hexGrid {
        overflow: visible;
        width: 100%;
        margin: 0 -60px;
        padding: 0.866% 0;
        font-family: 'Raleway', sans-serif;
        font-size: 15px;
      }
      
      #hexGrid:after {
        content: '';
        display: block;
        clear: both;
      }
      
      .hex {
        position: relative;
        list-style-type: none;
        float: left;
        overflow: hidden;
        visibility: hidden;
        outline: 1px solid transparent;  /* fix for jagged edges in FF on hover transition */
        transform: rotate(-60deg) skewY(30deg) translatez(-1px);
      }
      
      .hex * {
        position: absolute;
        visibility: visible;
        outline: 1px solid transparent;  /* fix for jagged edges in FF on hover transition */
      }
      
      .hexIn {
        display: block;
        width: 100%;
        height: 100%;
        text-align: center;
        color: #fff;
        overflow: hidden;
        transform: skewY(-30deg) rotate(60deg);
      }
      
      
      /*** HEX CONTENT **********************************************************************/
      
      .hex img {
        left: -100%;
        right: -100%;
        width: auto;
        height: 100%;
        margin: 0 auto;
        object-fit: cover;
      }
      
      .hex .hex-title,
      .hex p {
        margin: 0;
        width: 102%;
        left: -1%;  /* prevent line on the right where background doesn't cover image */
        padding: 5%;
        box-sizing: border-box;
        background-color: rgba(0, 128, 128, 0.8);
        font-weight: 300;
        transition: transform .2s ease-out, opacity .3s ease-out;
      }
      
      .hex .hex-title {
        bottom: 50%;
        padding-top: 50%;
        font-size: 1.5em;
        z-index: 1;
        transform: translateY(-100%) translatez(-1px);
      }
      
      .hex .hex-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 45%;
        width: 10%;
        text-align: center;
        border-bottom: 1px solid #fff;
      }
      
      .hex p {
        top: 50%;
        padding-bottom: 50%;
        transform: translateY(100%) translatez(-1px);
      }
      
      
      /*** HOVER EFFECT  **********************************************************************/
      
      .hexIn:hover .hex-title, .hexIn:focus .hex-title, .hexIn:hover p, .hexIn:focus p {
        transform: translateY(0%) translatez(-1px);
      }
      
      
      /*** SPACING AND SIZING *****************************************************************/
      
      @media (min-width:1201px) {  /* <- 2-3  hexagons per row */
        .hex {
          width: 32.666%;    /* = (100-2) / 3 */
          padding-bottom: 37.720%;    /* =  width / sin(60) */
        }
        .hex:nth-child(5n+1),
        .hex:nth-child(5n+2) {
          transform: translateX(50%) rotate(-60deg) skewY(30deg);
        }
        .hex:nth-child(5n+3),
        .hex:nth-child(5n+4),
        .hex:nth-child(5n+5) {
          margin-top: -8.564%;
          margin-bottom: -8.564%;
        }
        .hex:nth-child(5n+2),
        .hex:nth-child(5n+4) {
          margin-right: 1%;
          margin-left: 1%;
        }
        .hex:nth-child(5n+1) {
          margin-left: 0.5%;
        }
        .hex:nth-child(5n+3),
        .hex:nth-child(5n+6) {
          clear: left;
        }
      }
      
      @media (max-width: 1200px) {  /* <- 1-2  hexagons per row */
        .hex {
          width: 49.5%;    /* = (100-1) / 2 */
          padding-bottom: 57.158%;    /* =  width / sin(60) */
        }
        .hex:nth-child(3n+1) {
          transform: translateX(50%) rotate(-60deg) skewY(30deg);
        }
        .hex:nth-child(3n+2),
        .hex:nth-child(3n+3) {
          margin-top: -13.423%;
          margin-bottom: -13.423%;
        }
        .hex:nth-child(3n+1) {
          margin-left: 0.5%
        }
        .hex:nth-child(3n+3) {
          margin-left: 1%;
        }
        .hex:nth-child(3n+2),
        .hex:nth-child(3n+4) {
          clear: left;
        }
      }
      
      @media (max-width: 400px) {
        #hexGrid {
          font-size: 13px;
        }
      }
      
      /* End Hexagons */
      /* fork on github button */
      #fork{
        font-family: 'Raleway', sans-serif;
        position:fixed;
        top:0;
        left:0;
        color:#000;
        text-decoration:none;
        border:1px solid #000;
        padding:.5em .7em;
        margin:1%;
        transition: color .5s;
        overflow:hidden;
      }
      #fork:before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 130%; height: 100%;
        background: #000;
        z-index: -1;
        transform-origin:0 0 ;
        transform:translateX(-100%) skewX(-45deg);
        transition: transform .5s;
      }
      #fork:hover {
        color: #fff;
      }
      #fork:hover:before {
        transform: translateX(0) skewX(-45deg);
      }
    </style>";
    $hexagon_list = array_map(function ($vp_post) {
        $text = $vp_post->post_excerpt;
        $text = substr(substr($text, 0, 135), 0, strrpos($text, ' ')+1);
        return array(
            'url' => $vp_post->guid,
            'title' => $vp_post->post_title,
            'img_html' => get_the_post_thumbnail($vp_post, 'medium'),
            'text' => $text
        );
    }, $vp_posts->posts);
    echo "<section class='vp-nieuws verpakking'>
    <h2>" . ucfirst(\agitatie\taal\streng('nieuws')) . "</h2>";
    create_hexagon_grid($hexagon_list);
    echo '<ul id="hexGrid">';
    foreach($hexagon_list as $item) {
        $url = $item['url'];
        $title = $item['title'];
        $img_html = $item['img_html'];
        $text = $item['text'];
        echo "<li class='hex'>
	  <a class='hexIn' href='$url'>
      <h3 class='hex-title tekst-wit'>$title</h3>
        $img_html
		<p class='tekst-wit'>$text</p>
	  </a>
	</li>";
    }

    echo "</ul>";
    echo "<footer>";
    $footerknop->print();
    echo "</footer>";

    echo "</section>";
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

// Deactivate the Stats module.
add_filter(
    'jetpack_active_modules',
    function ($modules) {
        $stats_index = array_search('stats', $modules, true);
        if (false !== $stats_index) {
            unset($modules[ $stats_index ]);
        }
        return $modules;
    },
    11
);

// Remove the Stats module from the list of available modules.
add_filter(
    'jetpack_get_available_modules',
    function ($modules) {
        unset($modules['stats']);
        return $modules;
    },
    11
);



// Then, remove each CSS file, one at a time
function jeherve_remove_all_jp_css()
{
    wp_dequeue_style('social-logos');
    wp_dequeue_style('jetpack_css');
}
add_action('wp_print_styles', 'jeherve_remove_all_jp_css', 99);

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
