<?php

global $post;
$fader_afb = get_field('afbeeldingen', $post->ID);
// echo "<pre>";
// var_dump($fader_afb);
// echo "</pre>";
$count = count($fader_afb);
if ($count > 0) :

    $overlay_url = "background-image: url(".KIND_URI . '/img/hexagon-overlay.png'.")";
    echo "<figure class='fader-video' data-current-index='0' data-count='$count'>";
    echo "<div class='fader-video-overlay' style='$overlay_url'></div>";
    for ($i = 0; $i < $count; $i++) :
        $fa = $fader_afb[$i];
        $src_port_dbl = $i === 0 ? $fa['sizes']['fader-video'] : '';
        $data_src_port_dbl = $fa['sizes']['fader-video'];
        $w_port_dbl = $fa['sizes']['fader-video'];
        $h_port_dbl = $fa['sizes']['fader-video'];
        $alt = $fa['alt'];
        echo "<picture 
            class='fader-video-picture' 
            id='fader-video-picture-$i'>";
        echo "<img 
            id='fader-video-image-$i'
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


