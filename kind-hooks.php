<?php


function medestrijder_index_single_samen()
{

  if (is_singular() && get_post_type() === 'medestrijder') {

    remove_action('ag_archief_content_action', 'ag_archief_content_hook');
    remove_action('ag_pagina_voor_tekst', 'ag_print_datum_ctrl');
    remove_action('ag_pagina_voor_tekst', 'ag_print_datum_ctrl');
    remove_action('ag_archief_titel_action', 'ag_archief_titel_hook');
    add_action('ag_archief_titel_action', 'medestrijderen_overzicht_titel');
    add_action('ag_archief_intro_action', 'medestrijderen_overzicht_tekst', 10);
    add_action('ag_archief_content_action', 'medestrijderen_lijst_content', 20);
  } else {
    //ag_console($post);
  }


  add_action('voorpagina_na_tekst_action', 'medestrijders_carousel', 80);
}

add_action('pre_get_posts', 'medestrijder_index_single_samen');

function medestrijderen_overzicht_titel()
{
  $titel = get_field('medestrijders_titel', 'option');
  if ($titel && !empty($titel)) {
    echo "<h1>$titel</h1>";
  }
}

function medestrijderen_overzicht_tekst()
{
  $tekst = get_field('medestrijders_begeleidend', 'option');
  if ($tekst && !empty($tekst)) {
    $tekst = apply_filters('the_content', $tekst);
    $tekst = str_replace(']]>', ']]&gt;', $tekst);
    echo $tekst;
  }
}


function medestrijderen_lijst_content()
{

  echo "<style>";
  echo  "
  // body .uitgelichte-afbeelding-buiten {
  //   height: calc(100vh - 70px);
  // }  
  .sticky-sidebar {
    display: none !important;
  }
 
  .archief-medestrijder .vertikaal-op-archief.art-c {
    max-width: 100%;
    flex-basis: 100%;
    margin-right: 0;
    margin-top: 0;
    margin-left: 0;
    flex-direction: row;
    display: flex;
    flex-grow: 0;
    background-color: #c5c4b933;
  }

  .archief-medestrijder .vertikaal-op-archief.art-c .art-links {
    flex-basis: 300px;
    height: auto;
    margin-right: 0;
    flex-grow: 0;
flex-shrink: 0;
  }
  .archief-medestrijder .vertikaal-op-archief.art-c:nth-child(2n+2) .art-links {
    order: 2;
  }
  .archief-medestrijder .vertikaal-op-archief.art-c:nth-child(2n+2) .art-rechts {
    order: 1;
    text-align: right;
  }  
  
  .vertikaal-op-archief.art-c .art-links a {
    display: flex;
    min-height: 100%;
    width: 66vw;
    max-width: 500px;    
  }

  .vertikaal-op-archief.art-c .art-links img {
    height: auto;
    object-fit: cover;
  }
  
  .archief-medestrijder .vertikaal-op-archief .art-rechts {
    margin-top: 0;
    padding: 30px;
    font-size: 1.25em;
  }

  @media (max-width: 800px) {
    .archief-medestrijder .vertikaal-op-archief.art-c .art-links {
      flex-basis: initial;
    }
    .vertikaal-op-archief.art-c .art-links a {
      width: 33vw;
      max-height: 33vh;
      min-height: initial;
    }    
  }

  @media (max-width: 600px) {
    .archief-medestrijder .vertikaal-op-archief.art-c {
      background-color: transparent;
    }

    .archief-medestrijder .vertikaal-op-archief.art-c .art-links {
      flex-basis: 50%;
    }

    .vertikaal-op-archief.art-c .art-links a {
      width: 100%;
    }    

    .archief-medestrijder .vertikaal-op-archief .art-rechts {
      margin-top: 0;
      padding: 0;
      font-size: 1em;
      margin-left: 15px;
      margin-right: 15px;
      margin-top: -3px;
    }    

  }
  
  ";
  echo "</style>";

  //  ag_console($wp_query);

  echo "<div class='verpakking verpakking-klein marginveld titel-over-afbeelding-indien-aanwezig'>";

  //  do_action('ag_pagina_titel');

  do_action('ag_pagina_voor_tekst');

  echo "<div class='bericht-tekst'>";

  // while (have_posts()) : the_post();
  //   the_content();
  // endwhile;


  echo "</div>";

  echo "</div>";


  echo "<div id='archief-lijst' class='tekstveld art-lijst'>";

  $posts_rest = get_posts([
    'post_type' => 'medestrijder',
    'posts_per_page' => '-1',
    'orderby'     => 'menu_order',
    'order'     => 'ASC',
    'exclude'      => array(get_the_id()),
  ]);

  global $post;

  $posts = [$post, ...$posts_rest];

  if (count($posts) > 0) : foreach ($posts as $post) :

      //maakt post type objs aan en print @ controllers
      ag_archief_generiek_loop($post);

    endforeach;

    echo "<script>
      document.querySelectorAll('.vertikaal-op-archief').forEach(artikel => {
        artikel.querySelectorAll('a').forEach(anker => {
          anker.setAttribute('href', anker.href + '#' + artikel.id)
        });
      });
    </script>";

  else :
    get_template_part('sja/niets-gevonden');

  endif;
  echo "</div>";
}

function medestrijders_carousel()
{

  $posts = get_posts([
    'post_type' => 'medestrijder',
    'posts_per_page' => '-1',
    'orderby'     => 'menu_order',
    'order'     => 'ASC',
  ]);



  if (count($posts) > 0) :

    echo "<style>
    .medestrijders-carousel .art-lijst .art-c {
      margin-top: 0;
    }
    /* Slider */
.slick-slider
{
    position: relative;

    display: block;
    box-sizing: border-box;

    -webkit-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none;

    -webkit-touch-callout: none;
    -khtml-user-select: none;
    -ms-touch-action: pan-y;
        touch-action: pan-y;
    -webkit-tap-highlight-color: transparent;
}

.slick-list
{
    position: relative;

    display: block;
    overflow: hidden;

    margin: 0;
    padding: 0;
}
.slick-list:focus
{
    outline: none;
}
.slick-list.dragging
{
    cursor: pointer;
    cursor: hand;
}

.slick-slider .slick-track,
.slick-slider .slick-list
{
    -webkit-transform: translate3d(0, 0, 0);
       -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
         -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
}

.slick-track
{
    position: relative;
    top: 0;
    left: 0;

    display: block;
    margin-left: auto;
    margin-right: auto;
}
.slick-track:before,
.slick-track:after
{
    display: table;

    content: '';
}
.slick-track:after
{
    clear: both;
}
.slick-loading .slick-track
{
    visibility: hidden;
}

.slick-slide
{
    display: none;
    float: left;

    height: 100%;
    min-height: 1px;
}
[dir='rtl'] .slick-slide
{
    float: right;
}
.slick-slide img
{
    display: block;
}
.slick-slide.slick-loading img
{
    display: none;
}
.slick-slide.dragging img
{
    pointer-events: none;
}
.slick-initialized .slick-slide
{
    display: block;
}
.slick-loading .slick-slide
{
    visibility: hidden;
}
.slick-vertical .slick-slide
{
    display: block;

    height: auto;

    border: 1px solid transparent;
}
.slick-arrow.slick-hidden {
    display: none;
}

    </style>

";
    echo "<section class='verpakking medestrijders-carousel'>";
    $titel = get_field('medestrijders_titel', 'option');
    if ($titel && !empty($titel)) {
      echo "<h2>$titel</h2>";
    }
    echo "<div class='art-lijst medestrijders-carousel-buiten'>";
    foreach ($posts as $post) :
      //maakt post type objs aan en print @ controllers
      ag_archief_generiek_loop($post);

    endforeach;

    echo "</div>";
    echo "</section>";
    echo "    <script type='text/javascript' src='//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js'></script>    ";
    echo " <script defer>

       jQuery('.medestrijders-carousel-buiten').slick({
         slidesToShow: 3,
         infinite: true,
         slidesToShow: 3,
         slidesToScroll: 3,
         centerMode: true,
         centerPadding: '120px',
         arrows: false,
         responsive: [
          {
            breakpoint: 800,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2,
              infinite: true,
              centerPadding: '60px',
            }
          },    
          {
            breakpoint: 500,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
              centerPadding: '50px',
              adaptiveHeight: true
            }
          }]               
       });
     </script>";
  endif;
}



if (!function_exists('ag_archief_content_hook')) : function ag_archief_content_hook()
  {
    ag_archief_content_ctrl();
    ag_archief_sub_tax_ctrl();
  }
endif;

add_action('ag_archief_content_action', 'ag_archief_content_hook', 10);
