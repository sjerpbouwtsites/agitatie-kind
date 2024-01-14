<?php

global $post;

if (!isset($afbeeldingen)) {
    echo "<h1>geen afbeeldingen!</h1>";
}

$fader_counter = (!isset($fader_counter)) ? '0' : $fader_counter;
$count = count($afbeeldingen);

if ($count > 0) :

    $overlay_url = "background-image: url(".KIND_URI . '/img/hexagon-overlay.png'.")";
    echo "<figure class='fader-video' data-current-index='0' data-count='$count' data-fader-index='$fader_counter'>";
    echo "<div class='fader-video-overlay' style='$overlay_url'></div>";
    for ($i = 0; $i < $count; $i++) :
        $fa = $afbeeldingen[$i];

        $src_fader_dbl = $i === 0 ? $fa['sizes']['fader-video'] : '';
        $data_src_fader_dbl = $fa['sizes']['fader-video'];
        $w_fader_dbl = $fa['sizes']['fader-video'];
        $h_fader_dbl = $fa['sizes']['fader-video'];

        $src_portfolio_dbl = $i === 0 ? $fa['sizes']['portfolio'] : '';
        $data_src_portfolio_dbl = $fa['sizes']['portfolio'];
        $w_portfolio_dbl = $fa['sizes']['portfolio'];
        $h_portfolio_dbl = $fa['sizes']['portfolio'];

        $alt = $fa['alt'];
        echo "<picture 
            class='fader-video-picture' 
            id='fader-video-picture-$fader_counter-$i'>";

        echo "<source 
            srcset='$data_src_portfolio_dbl' 
            media='(orientation: portrait)' />";

        echo "<source 
            srcset='$data_src_portfolio_dbl' 
            media='(max-width: 1460px)' />";

        echo "<source 
            srcset='$data_src_fader_dbl' 
            media='(min-width: 1461px)' />";

        echo "<img 
            loading='lazy'
            decoding='async'
            id='fader-video-image-$fader_counter-$i'
            class='fader-video-image'
            srcset='$src_portfolio_dbl' 
            data-srcset='$data_src_portfolio_dbl'
            alt='$alt' 
            height='$w_portfolio_dbl' 
            width='$h_portfolio_dbl' />";

        echo "</picture>";
    endfor;
    echo "</figure>";
endif;


// echo "<img
// id='fader-video-image-$fader_counter-$i'
// class='fader-video-image'
// src='$src_fader_dbl'
// data-src='$data_src_fader_dbl'
// alt='$alt'
// height='$w_fader_dbl'
// width='$h_fader_dbl' />";

?>


