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
* I18Nv2_DecoratedList
*
* @author       Michael Wallner <mike@php.net>
* @version      $Revision$
* @package      I18Nv2
*/
class I18Nv2_DecoratedList
{
    /**
    * I18Nv2_(Common|Decorated)List
    * 
    * @access   protected
    * @var      object
    */
    var $list;
    
    /**
    * Constructor
    * 
    * @access   public
    * @return   object
    * @param    object  $list   I18Nv2_DecoratedList or I18Nv2_CommonList
    */
    function I18Nv2_DecoratedList(&$list)
    {
        I18Nv2_DecoratedList::__construct($list);
    }
    
    /**
    * ZE2 Constructor
    * @ignore
    */
    function __construct(&$list)
    {
        if (is_a($list, 'I18Nv2_CommonList') ||
            is_a($list, 'I18Nv2_DecoratedList')) {
            $this->list = &$list;
        }
    }

    /** 
    * Get all codes
    * 
    * @access   public
    * @return   array
    */
    function getAllCodes()
    {
        return $this->decorate($this->list->getAllCodes());
    }
    
    /** 
    * Check if code is valid
    * 
    * @access   public
    * @return   bool
    * @param    string  $code
    */
    function isValidCode($code)
    {
        return $this->decorate($this->list->isValidCode($code));
    }
    
    /** 
    * Get name for code
    * 
    * @access   public
    * @return   string
    * @param    string  $code
    */
    function getName($code)
    {
        return $this->decorate($this->list->getName($code));
    }
    
    /**
    * decorate
    * 
    * @abstract
    * @access   protected
    * @return   mixed
    * @param    mixed   $value
    */
    function decorate($value)
    {
        return $value;
    }
}

?>