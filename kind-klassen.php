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

    // public function maak_titel()
    // {
    //     $video_url = get_field('trailer_voor_overzicht', $post->ID);
    //     $this->art->post_title = "<button class='open-festival-trailer' data-youtube='$video_url'>".$this->art->post_title."<span data-youtube='$video_url' class='camera-span'>📽️</span></button>";
    // }
}
