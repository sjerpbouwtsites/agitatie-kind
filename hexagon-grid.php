<?php

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
    foreach ($hexagon_list as $item) {
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