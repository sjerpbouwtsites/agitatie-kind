<?php

global $wp_query;

define('KIND_DIR', get_stylesheet_directory());
define('KIND_URI', get_stylesheet_directory_uri());

//deze klassen extenden die van de parent theme. Moet dus later geladen worden. functions.php wordt geladen in 'setup theme' dus daar wachten we op.
function kinder_klassen()
{
    include_once KIND_DIR . '/kind-klassen.php';
}

add_action('after_setup_theme', 'kinder_klassen');

include_once KIND_DIR . '/kind-hooks.php';
include_once KIND_DIR . '/overschrijvingen.php';


function agitatie_stijl_en_script()
{
    wp_enqueue_style('agitatie-stijl', THEME_URI . '/style.css', array(), null);
    wp_enqueue_style('kind-stijl', get_stylesheet_uri(), array('agitatie-stijl'), null);
    // wp_enqueue_script( 'agitatie-script', JS_URI.'/all.js', array(), null, true );
}

add_action('wp_enqueue_scripts', 'agitatie_stijl_en_script');

$kind_config = array(
    'agenda'                        => true,
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
        'medestrijder' => array(
            'geen_datum'            => true,
            'exc_lim'               => 800,
            'class'                 => 'vertikaal-op-archief art-c',
            'geen_meer_tekst'       => true,

        )
        // 'post'                     => array(
        //     'taxonomieen'          => true
        // )
    ),
    // 'content_width'                => 760

);
$_GLOBALS['kind_config'] = $kind_config;
$kind_menus = array(
    //'voorpagina'
);

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

    // $faq = new Posttype_voorb('faq', 'faqs');
    // $faq->pas_args_aan(array(
    //     'menu_icon'           => 'dashicons-editor-quote',
    //     'supports' =>
    //     array(
    //         'title',
    //         'editor'
    //     ),
    // ));
    // $faq->registreer();

    $oproepers = new Posttype_voorb('medestrijder', 'medestrijders');
    $oproepers->pas_args_aan(array(
        'menu_icon'           => 'dashicons-megaphone',
        'supports' =>
        array(
            'title',
            'editor',
            'thumbnail',
            'page-attributes'
        ),
    ));
    $oproepers->registreer();

    // $download = new Posttype_voorb('download', 'downloads');
    // $download->pas_args_aan(array(
    //     'menu_icon'             => 'dashicons-download'
    // ));
    // $download->registreer();

}

if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_61ee203517c59',
        'title' => 'medestrijders',
        'fields' => array(
            array(
                'key' => 'field_61ee204967d03',
                'label' => 'medestrijders achtergrond',
                'name' => 'medestrijders_achtergrond',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
                'preview_size' => 'bovenaan_art',
                'library' => 'all',
                'min_width' => 2000,
                'min_height' => 700,
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
            array(
                'key' => 'field_61ee22806b2fe',
                'label' => 'medestrijders titel',
                'name' => 'medestrijders_titel',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_61ee21be65e42',
                'label' => 'medestrijders begeleidend',
                'name' => 'medestrijders_begeleidend',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

endif;
