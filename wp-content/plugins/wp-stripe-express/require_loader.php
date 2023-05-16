<?php
if ( ! function_exists('it_stripe_express_require_handler')) {
  function it_stripe_express_require_handler($dir) {
    $dh = opendir($dir);
    while (($filename = readdir($dh)) != null) {
      if ($filename == '.' || $filename == '..') continue;
      $_dir = $dir . $filename;
      if (is_file($_dir)) {
        $extension = pathinfo($_dir, PATHINFO_EXTENSION);
        if (strtolower($extension) == 'php') {
          require_once $_dir;
        }
      } else if (is_dir($_dir)) {
        it_stripe_express_require_handler($_dir . '/');
      }
    }
    closedir($dh);
  }
}

if (function_exists('it_stripe_express_require_handler')) {
  it_stripe_express_require_handler(IT_STRIPE_EXPRESS_INC . '/');
}
