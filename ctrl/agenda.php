<?php

use agitatie\taal as taal;

if (!function_exists('ag_agenda_filter_ctrl')) :
    function ag_agenda_filter_ctrl()
    {
        $models_ans = ag_agenda_filter_model();

        ag_agenda_filter(...$models_ans);

        return $m;
    }
endif;



class Ag_agenda extends Ag_basis_class
{
    public $omgeving;

    public function __construct($a = array())
    {
        parent::__construct($a);
        $omgeving = $this->omgeving;

        $this->zet_is_widget();
        $this->zet_agendastukken();
    }

    public function zet_is_widget()
    {
        $this->is_widget = $this->omgeving === "widget";
    }

    public function in_pagina_queryarg()
    {
        $this->console = [];

        $archief = array_key_exists('archief', $_POST) || array_key_exists('archief', $_GET);

        $datum_vergelijking = ($archief ? '<' : '>=');

        $datum_sortering = ($archief ? 'DESC' : 'ASC');

        $args = array(
            'post_type'         => 'agenda',
            'post_status'       => 'publish',
            'posts_per_page'    => $this->aantal,
            'meta_key'          => 'datum',
            'orderby'           => 'meta_value',
            'order'             => $datum_sortering,
            'meta_query'        => array(
                array(
                    'key' => 'datum',
                    'value' => date('Ymd'),
                    'type' => 'DATE',
                    'compare' => $datum_vergelijking
                )
            ),
        );

        $tax_query = array();
        $tax_namen = array('plek', 'type',);

        foreach ($tax_namen as $t) {
            if (array_key_exists($t, $_POST) && $_POST[$t] !== '') {
                $tax_query[] = array(
                    'taxonomy' => $t,
                    'field'    => 'slug',
                    'terms'    => $_POST[$t],
                );
            }
        }

        if (count($tax_query)) {
            $args['tax_query'] = $tax_query;
        }

        $args_paged = $args;

        $args['posts_per_page'] = -1;
        $args_paged['posts_per_page'] = $this->aantal;

        $this->query_args = array($args_paged, $args);
    }

    public function widget_queryarg()
    {
        $args = array(
            'post_type'         => 'agenda',
            'post_status'       => 'publish',
            'posts_per_page'    => $this->aantal,
            'meta_key'          => 'datum',
            'orderby'           => 'meta_value',
            'order'             => 'ASC',
            'meta_query'        => array(
                array(
                    'key' => 'datum',
                    'value' => date('Ymd'),
                    'type' => 'DATE',
                    'compare' => '>='
                )
            ),
        );

        $this->query_args = array($args, $args);
    }

    public function zet_agendastukken()
    {
        $this->is_widget ? $this->widget_queryarg() : $this->in_pagina_queryarg();

        $this->console[] = $this->is_widget;
        $this->console[] = $this->query_args[0];

        $this->agendastukken = get_posts($this->query_args[0]);

        $this->is_widget ? null : $this->zet_totaal_aantal();
    }

    public function nalopen()
    {
        if (!ag_cp_truthy('aantal', $this)) {
            $this->aantal = 5;
        }
        if (!ag_cp_truthy('agenda_link', $this)) {
            $this->agenda_link = get_post_type_archive_link('agenda');
        }
    }

    public function zet_totaal_aantal()
    {
        $query_voor_tellen = get_posts($this->query_args[1]);
        //echo count($query_voor_tellen) . " / " . $this->aantal . " = " . $wp_query->max_num_pages;
        global $wp_query;
        $wp_query->max_num_pages = ceil(count($query_voor_tellen) / $this->aantal);
    }

    public function print()
    {
        $this->nalopen();

        $verpakking_el = $this->is_widget ? "section" : "div";

        ?>
        <<?= $verpakking_el ?> class='agenda-lijst__wrapper agenda-lijst__wrapper--<?= $this->omgeving ?>'>
            <?= ($this->omgeving === "widget" ? "<h3 class='widget-title'>Agenda</h3>" : "") ?>

            <div class='agenda-lijst__buiten agenda-lijst__buiten--<?= $omgeving ?>'>
                <ul class='agenda-lijst agenda-lijst--<?= $omgeving ?>'>
                    <?php

                            foreach ($this->agendastukken as $a) :

                                $tax_strings = taal\verwijder_meertaligheids_tax(get_post_taxonomies($a));
                                $post_taxonomieen = wp_get_post_terms($a->ID, $tax_strings);
                                if (!$this->is_widget) {
                                    $content = ag_maak_excerpt($a, 320);

                                    // midden is in links gezet.
                                    $midden = "";
                                    foreach ($post_taxonomieen as $pt) :

                                        $prefix = count($post_taxonomieen) > 1
                                            ? "<span 
                                        class='agenda-lijst__taxonomie-prefix 
                                        tekst-zwart
                                        kop-letter
                                        agenda-lijst__taxonomie-prefix--$omgeving 
                                        agenda-lijst__taxonomie-prefix--$pt->taxonomy
                                        '>$pt->taxonomy:</span>"
                                            : '';

                                        $midden .= "<span
                                        class='agenda-lijst__taxonomie kop-letter tekst-zwart agenda-lijst__taxonomie--$omgeving agenda-lijst__taxonomie--$pt->taxonomy'>
                                        $prefix $pt->name
                                    </span>";
                                    endforeach;
                                    $rechts = "<div 
                                class='agenda-lijst__cel 
                                    agenda-lijst__cel--$omgeving 
                                    kleine-letter
                                    tekst-wit
                                    agenda-lijst__rechts 
                                    agenda-lijst__rechts--" . $omgeving . "'>
                                    <span>" . $content . "</span>
                                </div>";
                                } else {
                                    $rechts = '';
                                    $midden = '';
                                }


                                $afb = wp_get_attachment_image_src(get_post_thumbnail_id($a->ID), 'large');
                                $datum = get_field('datum', $a->ID);

                                $datum = preg_replace("/\s/i", "<br>", $datum);

                                $datum = preg_replace("/\//i", "<span class='agenda-lijst__tijd-spacer agenda-lijst__tijd-spacer--$omgeving'>/</span>", $datum);

                                $datum = preg_replace("/:/i", "<span class='agenda-lijst__tijd-spacer agenda-lijst__tijd-spacer--$omgeving'>:</span>", $datum);



                                echo
                                "<li class='agenda-lijst__stuk agenda-lijst__stuk--" . $omgeving . "'>
                            <a class='agenda-lijst__link agenda-lijst__link--" . $omgeving . "' href='" . get_the_permalink($a->ID) . "'>
                                <div 
                                    class='agenda-lijst__links 
                                        agenda-lijst__cel 
                                        agenda-lijst__cel--$omgeving 
                                        agenda-lijst__datum 
                                        zwarte-letter
                                        accent-letter
                                        
                                        agenda-lijst__links--" . $omgeving . " 
                                        agenda-lijst__datum--" . $omgeving . "'>

                                    <span class='agenda-lijst__titel tekst-zwart kop-letter agenda-lijst__titel--" . $omgeving . "' >" . $a->post_title . "</span>
                                    <time class='tekst-wittig kleine-letter agenda-lijst__tijd agenda-lijst__tijd--$omgeving'>$datum</time>
                                    $midden
                                </div>
                                {$rechts}
                            </a>
						</li>";
                            endforeach; //agendastukken

        ?>

                </ul>


                <?php

                if ($this->is_widget) {
                    echo "<footer class='agenda-lijst__footer'>";

                    $agenda_Ag_knop = new Ag_knop(array(
                        'class' => 'in-kleur',
                        'link' => $this->agenda_link,
                        'tekst' => 'Agenda'
                    ));
                    $agenda_Ag_knop->print();
                    echo "</footer>";
                }


        ?>


            </div>
        </<?= $verpakking_el ?>>
    <?php
    }
}


if (!function_exists('ag_agenda_filter_model')) :
    function ag_agenda_filter_model()
    {
        $agenda_taxen = get_terms(array('type', 'plek'));
        $filters_inst = array();

        $archief = array_key_exists('archief', $_GET);

        $datum_vergelijking = ($archief ? '<' : '>=');

        $datum_sortering = ($archief ? 'DESC' : 'ASC');

        foreach ($agenda_taxen as $at) {
            if (!array_key_exists($at->taxonomy, $filters_inst)) {
                $filters_inst[$at->taxonomy] = array();
            }

            $test_posts = get_posts(array(
                'posts_per_page'    => -1,
                'post_type'         => 'agenda',
                $at->taxonomy       =>  $at->slug,
                'meta_key'          => 'datum',
                'orderby'           => 'meta_value',
                'order'             => $datum_sortering,
                'meta_query'        => array(
                    array(
                        'key' => 'datum',
                        'value' => date('Ymd'),
                        'type' => 'DATE',
                        'compare' => $datum_vergelijking
                    )
                ),
            ));

            $print[] = array($at->taxonomy . "-" . $at->slug => count($test_posts));

            $test_count = count($test_posts);

            //geen lege taxen.
            if ($test_count > 0) {
                $filters_inst[$at->taxonomy][] = array(
                    'slug' => $at->slug,
                    'name' => ucfirst($at->name),
                    'count' => $test_count
                );
            }
        }

        $filters_actief = false;

        foreach ($filters_inst as $n => $w) {
            if (array_key_exists($n, $_POST)) {
                $filters_actief = true;
                break;
            }
        }

        return array(
            $filters_actief,
            $filters_inst
        );
    }
endif;


if (!function_exists('ag_agenda_filter')) : function ag_agenda_filter($filters_actief, $filters_inst)
{
    $filter_text = "";

    if (
        count($_POST) and
        (array_key_exists('type', $_POST) and $_POST['type'] !== '') ||
        (array_key_exists('plek', $_POST) and $_POST['plek'] !== '')
    ) {
        $filter_t_ar = array();
        if (array_key_exists('type', $_POST) and $_POST['type'] !== '') {
            $filter_t_ar[] = $_POST['type'];
        }
        if (array_key_exists('plek', $_POST) and $_POST['plek'] !== '') {
            $filter_t_ar[] = $_POST['plek'];
        }
        $filter_text = "Je zocht op " . implode(', ', $filter_t_ar) . ".";
    }

    ?>



        <p><?= $filter_text ?></p>

        <form class='doos' id='agenda-filter' action='<?php echo get_post_type_archive_link('agenda'); ?>' method='POST'>
            <div class=''>

                <?php
                foreach ($filters_inst as $tax_naam => $opts) {
                    $prio = false;
                    echo "<section class='flex'>";
                    echo "<h3>" . $tax_naam . "</h3>";

                    if (array_key_exists($tax_naam, $_POST)) {
                        $prio = $_POST[$tax_naam];
                        $prio_naam = '';
                        foreach ($opts as $o) {
                            if ($o['slug'] === $prio) {
                                $prio_naam = $o['name'];
                                break;
                            }
                        }
                    }

                    echo "<select class='agenda-filters " . ($prio ? "geklikt" : "") . "' name='$tax_naam'>";
                    if ($prio) {
                        echo "<option value='$prio'>$prio_naam</option>";
                    }
                    echo "<option value=''>geen keuze</option>";
                    foreach ($opts as $o) {
                        if ($o['slug'] === $prio) {
                            continue;
                        }

                        $count_print = $filters_actief ? "" : "(" . $o['count'] . ")";

                        echo "<option value='" . $o['slug'] . "'>" . $o['name'] . "$count_print</option>";
                    }

                    echo "</select>";
                    echo "</section>";
                } ?>

                <input type='submit' value='filter'>
            </div>

            <!--WEG IN PRODUCTIE -->
            <input type='hidden' name='pag' value='agenda'>
        </form>
<?php }
endif;
