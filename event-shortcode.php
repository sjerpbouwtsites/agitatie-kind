<?php

function ag_event_shortcode($atts)
{
    $default = array(
        'id' => '',
    );
    $a = shortcode_atts($default, $atts);
    if ($a['id'] === '') {
        return 'Geen ID opgegeven';
    }

    $agenda_post = get_post($a['id']);

    if (!$agenda_post) {
        return 'no post found';
    }


    $tax_strings = taal\verwijder_meertaligheids_tax(get_post_taxonomies($agenda_post));
    $post_taxonomieen = wp_get_post_terms($agenda_post->ID, $tax_strings);

    $l = ag_maak_excerpt($agenda_post, 320);
    $content = $l[0];

    // midden is in links gezet.
    $midden = "<div class='agenda-lijst__taxonomieen agenda-lijst__taxonomieen--pagina '>";
    foreach ($post_taxonomieen as $pt) :

        if ($pt->taxonomy === 'locatie') {
            continue;
        }

        $ptt = $pt->taxonomy;
        if ($pt->taxonomy === 'locatie') {
            $ptt = ucfirst(\agitatie\taal\streng('waar'));
        }
        if ($pt->taxonomy === 'soort') {
            $ptt = ucfirst(\agitatie\taal\streng('wat'));
        }

        $prefix = count($post_taxonomieen) > 1
            ? "<span 
          class='agenda-lijst__taxonomie-prefix 
          tekst-wit
          kop-letter
          agenda-lijst__taxonomie-prefix--pagina 
          agenda-lijst__taxonomie-prefix--$pt->taxonomy
          '>$ptt:</span>"
            : '';

        $midden .= "<span
          class='agenda-lijst__taxonomie kop-letter tekst-wit agenda-lijst__taxonomie--pagina agenda-lijst__taxonomie--$pt->taxonomy'>
          $prefix $pt->name
      </span>";
    endforeach;
    $midden .= "</div>";
    $rechts = "<div 
  class='agenda-lijst__cel 
      agenda-lijst__cel--pagina 
      kleine-letter
      tekst-wit
      agenda-lijst__rechts 
      agenda-lijst__rechts--pagina'>
      " . wpautop($content) . "
  </div>";




    $datum = get_field('datum', $agenda_post->ID);

    //$datum = preg_replace("/\s/i", "<br>", $datum);

    $datum = preg_replace("/\//i", "<span class='agenda-lijst__tijd-spacer agenda-lijst__tijd-spacer--pagina'>/</span>", $datum);

    $datum = preg_replace("/:/i", "<span class='agenda-lijst__tijd-spacer agenda-lijst__tijd-spacer--pagina'>:</span>", $datum);

    $afb = get_the_post_thumbnail($agenda_post->ID, 'thumbnail');

    return
    "
    
    <div class='agenda-lijst__wrapper agenda-lijst__wrapper--pagina agenda-via-shortcode'>
            
            <div class='agenda-lijst__buiten agenda-lijst__buiten--pagina'>
                <ul class='agenda-lijst agenda-lijst--pagina'>
    
    
    <li class='agenda-lijst__stuk agenda-lijst__stuk--pagina'>
  <article>
<a class='agenda-lijst__link agenda-lijst__link--pagina' href='" . get_the_permalink($agenda_post->ID) . "'>

  ".$afb."
  
  <div 
      class='agenda-lijst__links 
          agenda-lijst__cel 
          agenda-lijst__cel--pagina 
          agenda-lijst__datum 
          zwarte-letter
          accent-letter
          agenda-lijst__links--pagina 
          agenda-lijst__datum--pagina'>

          

      <h3 class='agenda-lijst__titel tekst-wit kop-letter agenda-lijst__titel--pagina' >" . $agenda_post->post_title . " <time class='tekst-wittig kleine-letter agenda-lijst__tijd agenda-lijst__tijd--pagina'>$datum</time></h3>
      
      $midden
  </div>
  {$rechts}
  </a>
  </article>  
  </li></ul></div></div>
  ";
}
add_shortcode('agitatie-event', 'ag_event_shortcode');
