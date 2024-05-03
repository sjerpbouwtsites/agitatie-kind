<?php

class Ag_article_festival_c extends Ag_article_c
{
    public function __construct($config, $post)
    {
        parent::__construct($config, $post);
        $this->art = $post;
    }

    public function datum()
    {
        $datum = get_field('datum', $post->ID);
        $maker = get_field('filmmaker', $post->ID);
        echo "<span class='post-datum filmmaker tekst-donkergrijs kleine-letter'>$maker</span>";
        echo "<time class='post-datum tekst-grijs kleine-letter'>" . $datum . "</time>";
    }

    public function maak_titel()
    {
        $video_url = get_field('trailer_voor_overzicht', $post->ID);
        if (!$video_url || $video_url === '') {
            return;
        }
        $this->art->post_title = "<button class='open-festival-trailer' data-youtube='$video_url'><span data-youtube='$video_url' class='camera-span'>trailer</span>".$this->art->post_title."</button>";
    }

    public function extra_class()
    {
        $r = '';
        if ($this->geen_afb) {
            $r .= 'geen-afb ';
        }
        if ($this->geen_tekst) {
            $r .= 'geen-tekst ';
        }
        if ($this->geen_datum) {
            $r .= 'geen-datum ';
        }

        $dd = get_field('datum', $this->art->ID);
        $php_date = date("d/m/Y");
        $datum1 = explode(' ', $dd);
        $datum2 = explode('/', $datum1[0]);
        $post_dag = $datum2[0];
        $post_maand = $datum2[1];
        $post_jaar = $datum2[2];
        $datum1 = explode(' ', $php_date);
        $datum2 = explode('/', $datum1[0]);
        $php_dag = $datum2[0];
        $php_maand = $datum2[1];
        $php_jaar = $datum2[2];


        $post_t = intval($post_jaar.$post_maand.$post_dag);
        $php_t = intval($php_jaar.$php_maand.$php_dag);

        if ($php_t > $post_t) {
            $r .= " reeds-geweest";
        }

        return trim($r);
    }
}
