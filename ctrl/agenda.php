<?php

use agitatie\taal as taal;

// if (!function_exists('ag_agenda_filter_ctrl')) :
//     function ag_agenda_filter_ctrl()
//     {
//         $models_ans = ag_agenda_filter_model();

//         ag_agenda_filter(...$models_ans);

//         return $m;
//     }
// endif;


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
            <div class='agenda-filter-inner-flex'>

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
