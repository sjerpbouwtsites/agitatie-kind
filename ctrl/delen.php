<?php

function ag_print_socials()
{
    global $post;

    $obj_id = get_queried_object_id();
    $current_url = get_permalink($obj_id);
    $is_engels = str_contains($current_url, "\/en\/");
    $taal_str = $is_engels ? 'en' : 'nl';

    $queried_object = null;


    $post_meta = get_post_meta($post->ID);

    $is_archive = is_archive();
    $is_post_type_archive = is_post_type_archive();

    if ($is_archive) {
        $queried_object = get_queried_object();
    }

    $svg_facebook = "<svg class='agitatie-socials__svg agitatie-socials__svg--facebook' xmlns='http://www.w3.org/2000/svg' width='36' height='36' viewBox='0 0 36 36'> <g fill='none' fill-rule='evenodd'> <circle cx='18' cy='18' r='18' fill='#0866FF'></circle> <path fill='#FFF' d='M22.7 15.38h-3.5v-1.15c0-1.73.68-2.39 2.44-2.39.54 0 .98.01 1.23.04V8.92a11.8 11.8 0 0 0-2.32-.27c-3.57 0-5.21 1.69-5.21 5.32v1.41h-2.21v3.27h2.2v10.21h3.88V18.65h2.9l.59-3.27Z'></path> </g> </svg>";
    $svg_x = "<svg class='agitatie-socials__svg agitatie-socials__svg--twitter' xmlns='http://www.w3.org/2000/svg' width='36' height='36' viewBox='0 0 36 36'> <g fill='none' fill-rule='evenodd'> <circle cx='18' cy='18' r='18' fill='#0F1419'></circle> <path fill='#FFF' fill-rule='nonzero' d='M20.12 16.2 26.45 9h-1.5l-5.5 6.25L15.06 9H10l6.64 9.45L10 26h1.5l5.8-6.6 4.64 6.6H27l-6.88-9.8Zm-2.06 2.33-.67-.94-5.35-7.49h2.3l4.32 6.05.67.94 5.62 7.86h-2.3l-4.59-6.41Z'></path> </g> </svg>";
    $svg_email = "<svg class='agitatie-socials__svg agitatie-socials__svg--email' xmlns='http://www.w3.org/2000/svg' width='36' height='36' viewBox='0 0 36 36'> <g fill='none' fill-rule='evenodd'> <circle cx='18' cy='18' r='18' fill='#FFB700'></circle> <g fill='#FFF' fill-rule='nonzero'> <path d='M18.1 21 16 19.2l-6.5 5.5c.2.2.6.3 1 .3h15.5c.4 0 .7-.1 1-.3L20.3 19l-2.3 2Z'></path> <path d='M26.8 12.4c-.2-.2-.5-.3-.9-.3H10.3c-.3 0-.7 0-.9.3l8.7 7.4 8.7-7.4ZM9 13.2v10.7l6.3-5.3L9 13.2zM20.9 18.6l6.3 5.3V13.2l-6.3 5.4z'></path> </g> </g> </svg>";
    $svg_whatsapp = "<svg class='agitatie-socials__svg agitatie-socials__svg--whatsapp' xmlns='http://www.w3.org/2000/svg' width='36' height='36' viewBox='0 0 36 36'> <g fill='none' fill-rule='evenodd'> <circle cx='18' cy='18' r='18' fill='#00E676'></circle> <g fill-rule='nonzero'> <path fill='#FFF' d='M18.5 8.16c-5.44 0-9.86 4.19-9.86 9.34 0 2.04.7 3.94 1.88 5.48l-1.23 3.47 3.79-1.15c1.56.98 3.41 1.54 5.42 1.54 5.45 0 9.86-4.19 9.86-9.34 0-5.15-4.41-9.34-9.85-9.34h-.02Z'></path> <path fill='#00E676' d='M15.7 12.79c-.2-.44-.33-.46-.61-.47l-.33-.01c-.37 0-.75.1-.98.34-.29.28-.99.94-.99 2.29s1.01 2.66 1.15 2.84c.14.18 1.96 3 4.8 4.14 2.21.9 2.87.81 3.37.7.74-.15 1.66-.68 1.9-1.32.23-.64.23-1.2.16-1.32-.07-.12-.26-.18-.54-.32a40.7 40.7 0 0 0-1.92-.9c-.25-.08-.49-.05-.7.21-.26.37-.53.75-.75.97-.15.18-.43.2-.67.11-.31-.13-1.18-.43-2.26-1.36a8.02 8.02 0 0 1-1.56-1.9c-.16-.28-.01-.44.11-.58.14-.17.28-.3.42-.46.15-.16.22-.24.32-.43s.02-.37-.04-.5l-.87-2.04h-.01Z'></path> </g> </g> </svg>";

    $url_facebook = "https://www.facebook.com/sharer/sharer.php?u=$current_url";
    $twitter_desc = '';

    if (!$is_post_type_archive) {
        if (array_key_exists("_yoast_wpseo_twitter-description", $post_meta)) {
            $twitter_desc = $post_meta["_yoast_wpseo_twitter-description"][0];
        } elseif (array_key_exists("_yoast_wpseo_metadesc", $post_meta)) {
            $twitter_desc = $post_meta["_yoast_wpseo_metadesc"][0];
        } elseif (!$is_archive) {
            $twitter_desc = $post->post_excerpt;
        } else {
            $twitter_desc = $queried_object->description;
        }
    } elseif ($is_post_type_archive) {
        $pt = $queried_object->name;
        $key = $pt."_seo_beschrijving_$taal_str";
        $twitter_desc = get_field($key, 'option');
    }

    $whatsapp_title = '';
    if (!$is_post_type_archive) {
        if (array_key_exists("_yoast_wpseo_opengraph-title", $post_meta)) {
            $whatsapp_title = $post_meta["_yoast_wpseo_opengraph-title"][0];
        } elseif (array_key_exists("_yoast_wpseo_twitter-title", $post_meta)) {
            $whatsapp_title = $post_meta["_yoast_wpseo_twitter-title"][0];
        } elseif (array_key_exists("_yoast_wpseo_title", $post_meta)) {
            $whatsapp_title = $post_meta["_yoast_wpseo_title"][0];
        } elseif (!$is_archive) {
            $whatsapp_title = $post->post_title;
        } else {
            $whatsapp_title = $queried_object->name;
        }
    } elseif ($is_post_type_archive) {
        $pt = $queried_object->name;
        $key = $pt."_seo_titel_$taal_str";
        $whatsapp_title = get_field($key, 'option');
    }

    $url_x = "https://twitter.com/intent/tweet/?url=$current_url&via=oy vey&text=$twitter_desc";
    $url_email = "mailto:?subject=".$whatsapp_title." | oyvey.nl&body=Hoi, ik zag dit bij Oy Vey! %0D%0A%0D%0A$whatsapp_title%0D%0A$current_url";

    $url_whatsapp = "https://api.whatsapp.com/send?text=$whatsapp_title $current_url";

    ?>
    <aside class='agitatie-socials__buiten verpakking verpakking-klein'>
        <h3 class='agitatie-socials__titel serif-letter tekst-zijkleur'><?=$is_engels ? "Share this" : "Deel dit"?></h3>
        <ul class='agitatie-socials__lijst'>
            <li class='agitatie-socials__lijst-item'>
                <a class='agitatie-socials__link agitatie-socials__link--facebook' href='<?=$url_facebook?>'>
                <?=$svg_facebook?>
            </a>
            </li>
            <li class='agitatie-socials__lijst-item'>
                <a class='agitatie-socials__link agitatie-socials__link--twitter' href='<?=$url_x?>'>
                <?=$svg_x?>
            </a>
            </li>
            <li class='agitatie-socials__lijst-item'>
                <a class='agitatie-socials__link agitatie-socials__link--email' href='<?=$url_email?>'>
                <?=$svg_email?>
            </a>
            </li>        
            <li class='agitatie-socials__lijst-item'>
                <a class='agitatie-socials__link agitatie-socials__link--whatsapp' href='<?=$url_whatsapp?>'>
                <?=$svg_whatsapp?>
            </a>
            </li>                
        </ul>
    </aside>

<?php }
