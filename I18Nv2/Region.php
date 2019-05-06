<?php
// +----------------------------------------------------------------------+
// | PEAR :: I18Nv2 :: Region                                             |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is available at http://www.php.net/license/3_0.txt              |
// | If you did not receive a copy of the PHP license and are unable      |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 Michael Wallner <mike@iworks.at>                  |
// +----------------------------------------------------------------------+
//
// $Id$

/**
 * I18Nv2::Region
 *
 * @package     I18Nv2
 * @category    Internationalization
 */

/**
 * I18Nv2_Region
 *
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision$
 * @access      public
 * @package     I18Nv2
 */
class I18Nv2_Region extends I18Nv2_SpecialList
{
    /**
     * Load language file
     *
     * @return  bool
     * @param   string  $language
     */
    protected function loadLanguage($language)
    {
        return @include __DIR__.'/Region/'. $this->key .'/'. $language .'.php';
    }

    /**
     * Change case of code key
     *
     * @return  string
     * @param   string  $code
     */
    public function changeKeyCase($code)
    {
        return strToUpper($code);
    }
}
