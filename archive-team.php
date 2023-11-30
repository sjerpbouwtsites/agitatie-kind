<?php

get_header();

define('POST_TYPE_NAAM', ag_post_naam_model());

set_query_var('klassen_bij_primary', "archief archief-" . POST_TYPE_NAAM);
get_template_part('/sja/open-main');

ag_uitgelichte_afbeelding_ctrl();

echo "<div class='marginveld titel-over-afbeelding-indien-aanwezig  veel verpakking'>";

do_action('ag_archief_titel_action');

do_action('ag_archief_intro_action');

//do_action('ag_archief_content_action');
global $post;


class OyveyTeam extends Ag_article_c
{
    public function __construct($config, $post)
    {
        parent::__construct($config, $post);
        $this->art = $post;
    }

    public function maak_artikel($maak_html = false)
    {
        if (!$this->gecontroleerd) {
            $this->controleer();
        }

        if ($maak_html) {
            ob_start();
        }

        $link_target = $this->target_blank ? "_blank" : "_self";
        $download_attr = $this->download_link ? "download" : "";

        ?>

		<article id='<?= $this->art->post_name ?>' class="flex art-c <?= $this->class ?> <?= $this->extra_class() ?>" <?= $this->data_src ?>>

			<?php if (!$this->geen_afb) : ?>
				<div class='art-links'>
					
						<?php $this->print_afb(); ?>
					
				</div>
			<?php endif; ?>

			<div class='art-rechts'>
				
					<header>
						<h<?= $this->htype ?> class='tekst-hoofdkleur'>
							<?= $this->art->post_title ?>
						</h<?= $this->htype ?>>
						<?php $this->datum();
        $this->taxonomieen(); ?>
					</header>
					<?php

                    if (!$this->geen_tekst) :
                        echo $this->maak_tekst();
                    endif;  ?>
				
			</div>
            <div class='oyvey-team-volle-tekst'>
                <?php wpautop($this->art->post_content); ?>
            </div>

		</article>
<?php

        if ($maak_html) {
            $this->html = ob_get_clean();
        }
    }
}

$extra_class = '';

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

echo "<div id='archief-lijst' class='tekstveld art-lijst $extra_class'>";
if (have_posts()) : while (have_posts()) : the_post();

    //maakt post type objs aan en print @ controllers
    //ag_archief_generiek_loop($post);

    $basis_array = array(
        'exc_lim' 		=> 150,
        'class'			=> 'in-lijst oyvey-team',
        'geen_datum'    => true,
        'taxonomieen' 	=> true
    );

    global $kind_config;

    if (
        $kind_config and
        array_key_exists('archief', $kind_config) and
        array_key_exists($post->post_type, $kind_config['archief']) and
        count($kind_config['archief'][$post->post_type])
    ) {
        foreach ($kind_config['archief'][$post->post_type] as $s => $w) {
            $basis_array[$s] = $w;
        }
    }

    $m_art = new OyveyTeam($basis_array, $post);

    if (isset($m_art)) {
        $m_art->afb_formaat	= $afb_formaat;
        $m_art->print();
    }


endwhile;
else :

    get_template_part('sja/niets-gevonden');

endif;
echo "</div>";

do_action('ag_archief_na_content_action');

do_action('ag_archief_footer_action');

echo "</div>";


get_template_part('/sja/sluit-main');

get_footer();
