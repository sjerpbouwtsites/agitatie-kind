<?php



function ag_archief_content_ctrl()
{

  global $post;
  global $kind_config;

  $extra_class = '';

  $categorieen = get_the_category($post->ID);
  $categorieen_met_zijbalk = ['thuisbezorgd', 'gorillas', 'flink'];
  $heeft_zijbalk = false;
  $categorie_voor_zijbalk = '';
  foreach ($categorieen as $c) {
    if (in_array(strtolower($c->name), $categorieen_met_zijbalk)) {
      $heeft_zijbalk = true;
      $categorie_voor_zijbalk = $c;
      break;
    }
  }


  if (
    isset($kind_config) and
    array_key_exists('archief', $kind_config) and
    array_key_exists($post->post_type, $kind_config['archief'])
  ) {
    if (
      array_key_exists('geen_afb', $kind_config['archief'][$post->post_type]) and
      $kind_config['archief'][$post->post_type]['geen_afb']
    ) {
      $extra_class = 'geen-afb-buiten';
    }
  }

  echo "<div id='archief-lijst' class='tekstveld art-lijst in-kind-overschreven vol-scherm-veld $extra_class'>";
  echo "<div class='vol-scherm-veld__voorste'>";

  if (have_posts()) :

    if ($post->post_type === 'post') {
      echo "<h2>" . agitatie\taal\streng('berichten') . "</h2>";
    }
    while (have_posts()) : the_post();
      //maakt post type objs aan en print @ controllers
      ag_archief_generiek_loop($post);

    endwhile;
  else :

    get_template_part('sja/niets-gevonden');

  endif;
  echo "</div>";
  if ($heeft_zijbalk) {
    maak_tweede_kolom_archief($categorie_voor_zijbalk);
  }
  echo "</div>";
}

function maak_tweede_kolom_archief($categorie_voor_zijbalk)

{

  echo "<div class='vol-scherm-veld__tweede'>";

  tweede_kolom_sectie('story', 'stories', $categorie_voor_zijbalk);
  tweede_kolom_sectie('download', 'downloads', $categorie_voor_zijbalk);

  echo "</div>";
}

function tweede_kolom_sectie($sectie_post_type, $sectie_post_type_meervoud, $categorie_voor_zijbalk)
{
  wp_reset_query();

  $query = new WP_Query([
    'numberposts'      => -1,
    'orderby'          => 'date',
    'order'            => 'DESC',
    'post_type'        => array($sectie_post_type),
  ]);

  // TODO SLECHTE PERFORMANCE
  $query_filtered = [];
  foreach ($query->posts as $q) {
    $c = get_field('categorie', $q->ID);
    if (empty($c) || !$c) continue;
    if ($c->name === $categorie_voor_zijbalk->name) {
      $query_filtered[] = $q;
    }
  }


  if (count($query_filtered) > 0) :
    echo "<section class='vol-scherm-veld__tweede-sectie vol-scherm-veld__tweede-sectie--" . $sectie_post_type . "'>";

    if ($sectie_post_type === 'story') {
      echo "<h2>$categorie_voor_zijbalk->name rider " . agitatie\taal\streng($sectie_post_type_meervoud) . "</h2>";
    } else {
      echo "<h2>" . agitatie\taal\streng($sectie_post_type_meervoud) . "</h2>";
    }

    $counter = 0;
    foreach ($query_filtered as $post) :
      if ($counter >= 6) continue;
      //maakt post type objs aan en print @ controllers

      $basis_array = array(
        'exc_lim'     => 230,
        'class'      => 'in-lijst in-lijst-in-zijkant',
        'taxonomieen'   => false,
        'datum' => false
      );

      $m_art = new Ag_article_c($basis_array, $post);

      if (isset($m_art)) {
        $m_art->print();
      }

      $counter++;
    endforeach;
    if (count($query_filtered) > 6) {
      echo "<footer class='archief-zijveld-footer'>";
      $terug = new Ag_knop(array(
        'class'   => 'in-wit ikoon-links',
        'link'     => get_post_type_archive_link($sectie_post_type),
        'tekst'    => \agitatie\taal\streng('Alle') . ' ' . agitatie\taal\streng($sectie_post_type_meervoud),
        'ikoon'    => 'arrow-left-thick'
      ));

      $terug->print();

      echo "<footer>";
    }
    echo "</section>";
  endif;
}
