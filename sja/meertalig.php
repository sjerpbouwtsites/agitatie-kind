<?php

if (function_exists('pll_the_languages')) :

    echo "<div class='multi-lang-vlaggen__buiten'>";
    echo "<ul class='multi-lang-vlaggen'>";
    pll_the_languages(array('show_flags' => 0, 'show_names' => 1, 'display_names_as'=>'slug','dropdown'=> 1));
    echo "</ul>";
    echo "</div>";

endif; // pll_the_languages exists
