<?php

function ag_kop_links()
{
  $blogtitel = get_bloginfo();
  $blog_url = site_url();
  echo "<a href='$blog_url' class='heading-logo'>$blogtitel</a>";
}

function ag_logo_in_footer_hook()
{
  $blogtitel = get_bloginfo();
  $blog_url = site_url();
  echo "<a href='$blog_url' class='heading-logo heading-logo--footer'>$blogtitel</a>";
}
