<?php
/**
* $Id$
*/

$this->formats['date'] = array(
    I18Nv2_DATETIME_SHORT     =>  '%d.%m.%y',
    I18Nv2_DATETIME_DEFAULT   =>  '%d.%m.%Y',
    I18Nv2_DATETIME_MEDIUM    =>  '%d. %b %Y',
    I18Nv2_DATETIME_LONG      =>  '%d. %B %Y',
    I18Nv2_DATETIME_FULL      =>  '%A, %d. %B %Y'
);
$this->formats['time'] = array(
    I18Nv2_DATETIME_SHORT     =>  '%H:%M',
    I18Nv2_DATETIME_DEFAULT   =>  '%H:%M:%S',
    I18Nv2_DATETIME_MEDIUM    =>  '%H:%M:%S',
    I18Nv2_DATETIME_LONG      =>  '%H:%M:%S %Z',
    I18Nv2_DATETIME_FULL      =>  '%H:%M Uhr %Z'
);
?>
