<?php
/**
* $Id$
*/

$this->formats['date'] = array(
    I18Nv2_DATETIME_SHORT     =>  '%Y-%m-%d',
    I18Nv2_DATETIME_DEFAULT   =>  '%Y. %b. %d.',
    I18Nv2_DATETIME_MEDIUM    =>  '%Y. %b. %d.',
    I18Nv2_DATETIME_LONG      =>  '%Y. %B %d.',
    I18Nv2_DATETIME_FULL      =>  '%Y. %B %d., %A'
);
$this->formats['time'] = array(
    I18Nv2_DATETIME_SHORT     =>  '%H:%M',
    I18Nv2_DATETIME_DEFAULT   =>  '%H:%M:%S',
    I18Nv2_DATETIME_MEDIUM    =>  '%H:%M:%S',
    I18Nv2_DATETIME_LONG      =>  '%H:%M:%S %Z',
    I18Nv2_DATETIME_FULL      =>  'id�: %H:%M %Z'
);
$this->formats['currency'][I18Nv2_CURRENCY_LOCAL][0] = 'Ft';
$this->formats['currency'][I18Nv2_CURRENCY_LOCAL][1] = '2';
$this->formats['currency'][I18Nv2_CURRENCY_LOCAL][2] = ',';
$this->formats['currency'][I18Nv2_CURRENCY_LOCAL][3] = '.';
$this->formats['currency'][I18Nv2_CURRENCY_INTERNATIONAL][0] = 'HUF';
$this->formats['currency'][I18Nv2_CURRENCY_INTERNATIONAL][1] = '2';
$this->formats['currency'][I18Nv2_CURRENCY_INTERNATIONAL][2] = '.';
$this->formats['currency'][I18Nv2_CURRENCY_INTERNATIONAL][3] = ',';
?>