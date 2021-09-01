<?php

function ag_logo_in_footer_hook() {

	echo "
			<a class='vw-footer-logo' href='".site_url()."'>
		<img src='https://vloerwerk.org/wp-content/uploads/2018/03/solidariteitsnetwerk-vloerwerk-logo-deels-wit.png' alt='solidariteitsnetwerk vloerwerk logo deels wit'/></a>";
}

/*
function ag_print_share () {
	sharing_display( '', true );
}

function ag_wrap_datum_en_share_start() {
	echo "<div class='art-meta'>";
}

function ag_wrap_datum_en_share_eind() {
	echo "</div>";
}

function jptweak_remove_share() {

    remove_filter( 'the_content', 'sharing_display', 19 );
    remove_filter( 'the_excerpt', 'sharing_display', 19 );


    if ( function_exists( 'sharing_display' ) ) {

    	add_action('ag_pagina_voor_tekst', 'ag_print_share', 20);

	}

	add_action('ag_pagina_voor_tekst', 'ag_wrap_datum_en_share_start', 5);
	add_action('ag_pagina_voor_tekst', 'ag_wrap_datum_en_share_eind', 99);

}

add_action( 'loop_start', 'jptweak_remove_share' );

*/