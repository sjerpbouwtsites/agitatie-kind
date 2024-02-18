<?php

if (!function_exists('ag_agenda_singular_hooks')) :
    function ag_agenda_singular_hooks()
    {
        if (!is_singular()) {
            return;
        }
        global $post;

        if ($post->post_type !== 'event') {
            return;
        }


        add_action('ag_singular_na_artikel', 'ag_agenda_singular_back_to_agenda', 20);
        remove_action('ag_singular_na_artikel', 'ag_singular_taxonomieen', 20);

        add_action('ag_pagina_voor_tekst', 'ag_agenda_plek_adres', 1);
    }
endif;

if (!function_exists('ag_agenda_plek_adres')) :
    function ag_agenda_plek_adres()
    {
        global $post;

        $plekken = wp_get_post_terms($post->ID, 'locatie');
        if (count($plekken) < 1) {
            return;
        }


        $is_engels = str_contains($_SERVER["HTTP_REFERER"], "\/en\/");
        if (!$is_engels) {
            setlocale(LC_ALL, array('Dutch_Netherlands', 'Dutch', 'nl_NL', 'nl', 'nl_NL.ISO8859-1', 'nld_NLD'));
        }

        foreach ($plekken as $p) {
            //$straat = get_field('straat', 'locatie_' . $p->term_id);
            //$huisnummer = get_field('huisnummer', 'locatie_' . $p->term_id);
            //$postcode = get_field('postcode', 'locatie_' . $p->term_id);
            $stad = get_field('stad', 'locatie_' . $p->term_id);
            $tijd_r = get_field('datum');
            if ($is_engels) {
                $tijd_a = DateTime::createFromFormat('d/m/Y H:i', $tijd_r);
                $tijd = $tijd_a->format('l \t\h\e jS \o\f F Y \a\t h:i');
            } else {
                $tijd = $tijd_r;
            }


            echo "<address class='agenda-address'>";
            //<span class='agenda-address__regel'>$straat $huisnummer</span>
            //<span class='agenda-address__regel'>$postcode $stad</span>
            echo "<span class='agenda-address__regel'>$stad</span>";
            echo "<span class='agenda-address__regel'>$tijd</span>";
            echo "</address>";
        }
    }
endif;
