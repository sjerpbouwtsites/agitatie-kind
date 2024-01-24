<?php

if (function_exists('pll_the_languages')) :

    echo "<div class='multi-lang-vlaggen__buiten'>";
    echo "<ul class='multi-lang-vlaggen'>";
    pll_the_languages(array('show_flags' => 0, 'show_names' => 1, 'display_names_as'=>'slug','dropdown'=> 1));
    echo "</ul>";
    echo "</div>";
    echo "<script>
    document.querySelectorAll('#lang_choice_1 option').forEach(option => {
      if (option.textContent.includes('nl')) {
        option.setAttribute('aria-label', 'Nederlands');
      }
      if (option.textContent.includes('en')) {
        option.setAttribute('aria-label', 'English');
      }      
    });
  </script>";
endif; // pll_the_languages exists
