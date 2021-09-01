<?php

global $wp_query;

define('KIND_DIR',get_stylesheet_directory());
define('KIND_URI',get_stylesheet_directory_uri());

//deze klassen extenden die van de parent theme. Moet dus later geladen worden. functions.php wordt geladen in 'setup theme' dus daar wachten we op.
function kinder_klassen(){
	include_once KIND_DIR . '/kind-klassen.php';
}

add_action('after_setup_theme', 'kinder_klassen');

include_once KIND_DIR . '/kind-hooks.php';
include_once KIND_DIR . '/overschrijvingen.php';


function agitatie_stijl_en_script() {
    wp_enqueue_style( 'agitatie-stijl', THEME_URI.'/style.css', array(), null );
    wp_enqueue_style( 'kind-stijl', get_stylesheet_uri(), array('agitatie-stijl'), null );
    wp_enqueue_script( 'agitatie-script', JS_URI.'/all.js', array(), null, true );
    wp_enqueue_script( 'kind-script', KIND_URI.'/js/kind.js', array(), null, true );
}

add_action( 'wp_enqueue_scripts', 'agitatie_stijl_en_script' );

$kind_config = array(
    'support'                      => array(
        'custom-logo'              => array(
           'height'                => 169,
           'width'                 => 400,
           'flex-width'            => true,
        ),
    ),
    'archief'                      => array(
        'faq'                      => array(
            'geen_afb'             => true,
            'geen_datum'           => true,
            'exc_lim'              => 300
        ),
        'post'                     => array(
            'taxonomieen'          => true
        )
    ),
    'content_width'                => 760

);
$kind_menus = array(
	//'voorpagina'
);

$kind_thumbs = array(
/*	'voorpagina' => array(
        'naam'             => 'voorpagina',
        'breedte'          => 2000,
        'hoogte'           => 1000,
        'crop'             => true,
    )*/
);



function registreer_posttypes() {

    $faq = new Posttype_voorb('faq', 'faqs');
    $faq->pas_args_aan(array(
        'menu_icon'           => 'dashicons-editor-quote',
    ));
    $faq->registreer();

    $download = new Posttype_voorb('download', 'downloads');
    $download->pas_args_aan(array(
        'menu_icon'             => 'dashicons-download'
    ));
    $download->registreer();

}

