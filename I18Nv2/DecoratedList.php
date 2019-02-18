<?php
// +----------------------------------------------------------------------+
// | PEAR :: I18Nv2 :: DecoratedList                                      |
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
 * I18Nv2::DecoratedList
 *
 * Decorator for I18Nv2_CommonList objects.
 *
 * @package     I18Nv2
 * @category    Internationalization
 */

/**
 * I18Nv2_DecoratedList
 *
 * @author      Michael Wallner <mike@php.net>
 * @version     $Revision$
 * @package     I18Nv2
 * @access      public
 */
class I18Nv2_DecoratedList
{
    /**
     * I18Nv2_(Common|Decorated)List
     *
     * @var     object
     */
    protected $list = null;

    /**
     * Constructor
     *
     * @param   object  $list   I18Nv2_DecoratedList or I18Nv2_CommonList
     */
    public function __construct(&$list)
    {
        if (is_a($list, 'I18Nv2_CommonList') ||
            is_a($list, 'I18Nv2_DecoratedList')) {
            $this->list = &$list;
        }
    }

    /**
     * Get all codes
     *
     * @return  array
     */
    public function getAllCodes()
    {
        return $this->decorate($this->list->getAllCodes());
    }

    /**
     * Check if code is valid
     *
     * @return  bool
     * @param   string  $code
     */
    public function isValidCode($code)
    {
        return $this->decorate($this->list->isValidCode($code));
    }

    /**
     * Get name for code
     *
     * @return  string
     * @param   string  $code
     */
    public function getName($code)
    {
        return $this->decorate($this->list->getName($code));
    }

    /**
     * Decorate
     *
     * @abstract
     * @return  mixed
     * @param   mixed   $value
     */
    protected function decorate($value)
    {
        return $value;
    }

    /**
     * Decorate this list
     *
     * @return  object  I18NV2_DecoratedList
     * @param   string  $type
     */
    public function &toDecoratedList($type)
    {
        $decoratedList = 'I18Nv2_DecoratedList_' . $type;
        $obj = new $decoratedList($this);
        return $obj;
    }

    /**
     * Change Key Case
     *
     * @return  string
     * @param   string  $code
     */
    public function changeKeyCase($code)
    {
        return $this->list->changeKeyCase($code);
    }

    /**
     * Set active language
     *
     * Note that each time you set a different language the corresponding
     * language file has to be loaded again, too.
     *
     * @return  bool
     * @param   string  $language
     */
    public function setLanguage($language)
    {
        return $this->list->setLanguage($language);
    }

    /**
     * Get current language
     *
     * @return  string
     */
    public function getLanguage()
    {
        return $this->list->getLanguage();
    }

    /**
     * Set active encoding
     *
     * @return  bool
     * @param   string  $encoding
     */
    public function setEncoding($encoding)
    {
        return $this->list->setEncoding($encoding);
    }

    /**
     * Get current encoding
     *
     * @return  string
     */
    public function getEncoding()
    {
        return $this->list->getEncoding();
    }
}
