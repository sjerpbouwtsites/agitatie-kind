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
        $src_port_dbl = $i === 0 ? $fa['sizes']['fader-video'] : '';
        $data_src_port_dbl = $fa['sizes']['fader-video'];
        $w_port_dbl = $fa['sizes']['fader-video'];
        $h_port_dbl = $fa['sizes']['fader-video'];
        $alt = $fa['alt'];
        echo "<picture 
            class='fader-video-picture' 
            id='fader-video-picture-$fader_counter-$i'>";
        echo "<img 
            id='fader-video-image-$fader_counter-$i'
            class='fader-video-image'
            src='$src_port_dbl' 
            data-src='$data_src_port_dbl'
            alt='$alt' 
            height='$w_port_dbl' 
            width='$h_port_dbl' />";
        echo "</picture>";
    endfor;
    echo "</figure>";
endif;

?>


