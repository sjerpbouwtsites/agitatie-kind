<?php


function ag_vp_print_nieuws_hook()
	{
		$vp_posts = new WP_Query(array(
			'posts_per_page' => 18
		));

		if (count($vp_posts->posts)) : 

			// $footerknop = new Ag_knop(array(
			// 	'link' 		=> get_post_type_archive_link('post'),
			// 	'tekst' 	=> ucfirst(\agitatie\taal\streng('alle')) . ' ' . \agitatie\taal\streng('posts'),
			// 	'class'		=> 'in-wit'
			// ));

			echo "<section class='vp-nieuws verpakking'>
				<h2>" . ucfirst(\agitatie\taal\streng('Artikelen')) . "</h2>
					<div class='art-lijst'>";
					
					foreach ($vp_posts->posts as $vp_post) :
						if (!isset($a)) {
							$a = new Ag_article_c(array(
								'class' 		=> 'in-lijst',
								'htype'			=> 3,
								'geen_afb'		=> false,
                                'geen_datum'    => true
							), $vp_post);
						} else {
							$a->art = $vp_post;
						}
						$a->gecontroleerd = false;
										
						$a->print();
					endforeach;
			
				echo "</div>"; //art lijst
				// echo "<footer>";
				// 	$footerknop->print();
				// echo "</footer>";

			echo "</section>";

		endif;

		//$afm = ag_agenda_filter_ctrl();

	}

add_filter( 'the_content', 'voeg_auteur_toe_aan_content_op_single', 1 );

function voeg_auteur_toe_aan_content_op_single( $content ) {

	global $post;

    if ( is_singular() && in_the_loop(  ) && !is_front_page() && $post->post_type === 'post'  ) {
		$a = get_the_author();
        return "<span class='auteur'>Door $a</span>" . $content;
    }

    return $content;
}