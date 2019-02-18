<?php

/**
* Automatically transform output charset
* ======================================
*
* I18Nv2 provides an easy way to utilize the ob_iconv_handler() through
* I18Nv2::autoConv($output_charset, $input_charset).
*
* $Id$
*/

require_once dirname(dirname(__DIR__)).'/vendor/autoload.php';

// Writing a shell app that should also display nicely in a DOS box
if (I18Nv2::isWindows()) {
    I18Nv2::autoConv('CP850');
}

// output some latin1 stuff
echo "δόφί\n";

?>