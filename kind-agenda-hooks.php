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

        $locatie_optie = get_field('locatie_optie', $post->ID);

        if ($locatie_optie === 'online') {
            echo "<address class='agenda-address'>";
            echo "<h3 class='agenda-address__titel tekst-zijkleur serif-letter'>Online event</h3>";
            echo "<span class='agenda-address__regel'>".\agitatie\taal\streng('Locatie wordt gemaild')."</span>";
            echo "</address>";
            return;
        }

        $plekken = wp_get_post_terms($post->ID, 'locatie');
        if (count($plekken) < 1) {
            return;
        }

        $p = $plekken[0];
        $stad = get_field('stad', 'locatie_' . $p->term_id);

        if ($locatie_optie === 'prive') {
            echo "<address class='agenda-address'>";
            echo "<h3 class='agenda-address__titel tekst-zijkleur serif-letter'>".\agitatie\taal\streng('Privé event')." in  $stad</h3>";
            echo "<span class='agenda-address__regel'>".\agitatie\taal\streng('Locatie wordt gemaild')."</span>";
            echo "</address>";
            return;
        }

        $straat = get_field('straat', 'locatie_' . $p->term_id);
        $huisnummer = get_field('huisnummer', 'locatie_' . $p->term_id);
        $tijd = get_field('datum');

        echo "<address class='agenda-address'>";
        echo "<h3 class='agenda-address__titel tekst-zijkleur serif-letter'>$p->name in $stad</h3>";
        echo "<span class='agenda-address__regel'>$straat $huisnummer</span>";
        echo "<span class='agenda-address__regel'>$tijd</span>";
        echo "</address>";
    }
endif;
