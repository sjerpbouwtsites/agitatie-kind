<?php

function archive_footer_link($post_type, $link_text)
{
    echo "<footer>";
    
    $k = new Ag_knop(array(
        'link' => get_post_type_archive_link($post_type),
        'tekst' => $link_text,
        'class' => 'in-wit'
    ));
    $k->print();
    
    echo "</footer>";
}
