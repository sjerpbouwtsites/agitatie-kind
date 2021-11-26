<?php

function ag_logo_in_footer_hook()
{
  $blogtitel = get_bloginfo();
  $blog_url = site_url();
  echo "<a href='$blog_url' class='heading-logo heading-logo--footer'>$blogtitel</a>";
}

function ag_vp_print_menu()
{

  $locaties = get_nav_menu_locations();

  if (array_key_exists('voorpagina', $locaties)) {

    $menu = wp_get_nav_menu_object($locaties['voorpagina']);
    $menu_stukken = wp_get_nav_menu_items($menu->term_id);

    if ($menu_stukken and count($menu_stukken)) :



      echo "<section class='vp-menu verpakking verpakking-veel paddingveld marginveld veel normale-padding achtergrond-hoofdkleur'>";
      echo "<h2 class='tekst-wittig geen-margin-top lineheight-fix' >" . \agitatie\taal\streng('Zie ook') . "</h2>";

      echo "<nav class='knoppendoos groot'>";
      foreach ($menu_stukken as $menu_stuk) {
        $k = new Ag_knop(array(
          'link'     => $menu_stuk->url,
          'tekst'    => $menu_stuk->title,
          'class'    => 'in-kleur'
        ));
        $k->print();
      }
      echo "</nav>"; //Ag_knoppendoos

      echo "</section>";

    endif;
  }
}
