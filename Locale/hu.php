<?php
/**
* $Id$
*/

$this->_dateFormats = array(
    I18Nv2_DATETIME_SHORT     =>  '%Y-%m-%d',
    I18Nv2_DATETIME_DEFAULT   =>  '%Y. %b. %d.',
    I18Nv2_DATETIME_MEDIUM    =>  '%Y. %b. %d.',
    I18Nv2_DATETIME_LONG      =>  '%Y. %B %d.',
    I18Nv2_DATETIME_FULL      =>  '%Y. %B %d., %A'
);
$this->_timeFormats = array(
    I18Nv2_DATETIME_SHORT     =>  '%H:%M',
    I18Nv2_DATETIME_DEFAULT   =>  '%T',
    I18Nv2_DATETIME_MEDIUM    =>  '%T',
    I18Nv2_DATETIME_LONG      =>  '%T %Z',
    I18Nv2_DATETIME_FULL      =>  'id�: %H:%M %Z'
);
$this->_currencyFormats[I18Nv2_CURRENCY_LOCAL][0] = 'Ft';
$this->_currencyFormats[I18Nv2_CURRENCY_LOCAL][1] = '2';
$this->_currencyFormats[I18Nv2_CURRENCY_LOCAL][2] = ',';
$this->_currencyFormats[I18Nv2_CURRENCY_LOCAL][3] = '.';
$this->_currencyFormats[I18Nv2_CURRENCY_INTERNATIONAL][0] = 'HUF';
$this->_currencyFormats[I18Nv2_CURRENCY_INTERNATIONAL][1] = '2';
$this->_currencyFormats[I18Nv2_CURRENCY_INTERNATIONAL][2] = '.';
$this->_currencyFormats[I18Nv2_CURRENCY_INTERNATIONAL][3] = ',';
?>
