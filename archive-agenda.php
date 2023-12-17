<?php

get_header();

set_query_var('klassen_bij_primary', "agenda-pag");
get_template_part('/sja/open-main');

?>
<div class='verpakking'>
	<div class='agenda'>
		<h1>Agenda hallo</h1>

		<?php

        //$afm = ag_agenda_filter_ctrl();

        if (have_posts()) :

            $agenda = new Ag_agenda(array(
                'aantal' => 10,
                'omgeving' => 'pagina'
            ));

            $agenda->print();

            ?>

		<?php ag_paginering_ctrl();

        else :

            echo "<p>Niets gevonden met deze opdracht.</p>";

        endif;

// echo "<div class='Ag_knoppen-doos'>";

// 	$archief = array_key_exists('archief', $_GET);
// 	$agenda_link = get_post_type_archive_link('agenda');

// 	//wat als er uberhaupt geen GET zijn => andere link
// 	$archief_Ag_knop = new Ag_knop(array(
// 		'ikoon'=> ($archief ? "arrow-right-thick"  : "step-backward-2"),
// 		'class'=> 'in-kleur '.($archief ? ""  : "ikoon-links"),
// 		'link' => $agenda_link . ($archief ? ""  : "?archief=ja"),
// 		'tekst'=> $archief ? "normale agenda" : "agenda archief"
// 	));

// 	$archief_Ag_knop->print();

// 	//als filters actief Ag_knop terug naar begin.
// 	if ( $afm['filters_actief'] ) {

// 		$agenda_begin = new Ag_knop(array(
// 			'ikoon' => 'replay',
// 			'class'=> 'in-wit',
// 			'link' => $agenda_link,
// 			'tekst'=> "Verwijder filters",
// 		));
// 		$agenda_begin->print();

// 	}

// echo "</div>";

?>
	</div>
</div>

<?php

get_template_part('/sja/sluit-main');
get_footer();
