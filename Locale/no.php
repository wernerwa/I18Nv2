<?php
/**
* $Id$
* @author   Asgeir Frimannsson <asgeir(@)frimannsson.com>
*/

$this->_dateFormats = array(
    I18Nv2_DATETIME_SHORT     =>  '%d.%m.%y',
    I18Nv2_DATETIME_DEFAULT   =>  '%d.%b.%Y',
    I18Nv2_DATETIME_MEDIUM    =>  '%d.%b.%Y',
    I18Nv2_DATETIME_LONG      =>  '%d. %B %Y',
    I18Nv2_DATETIME_FULL      =>  '%A %d. %B %Y'
);
$this->_timeFormats = array(
    I18Nv2_DATETIME_SHORT     =>  '%H:%M',
    I18Nv2_DATETIME_DEFAULT   =>  '%H:%M:%S',
    I18Nv2_DATETIME_MEDIUM    =>  '%H:%M:%S',
    I18Nv2_DATETIME_LONG      =>  '%H:%M:%S %Z',
    I18Nv2_DATETIME_FULL      =>  'kl %H.%M %Z'
);
?>