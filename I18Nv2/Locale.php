<?php
// +----------------------------------------------------------------------+
// | PEAR :: I18Nv2 :: Locale                                             |
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
 * I18Nv2::Locale
 *
 * @package      I18Nv2
 * @category     Internationalisation
 */

/**#@+ Constants **/
define('I18Nv2_NUMBER',                     'number');
define('I18Nv2_CURRENCY',                   'currency');
define('I18Nv2_DATE',                       'date');
define('I18Nv2_TIME',                       'time');
define('I18Nv2_DATETIME',                   'datetime');

define('I18Nv2_NUMBER_FLOAT' ,              'float');
define('I18Nv2_NUMBER_INTEGER' ,            'integer');

define('I18Nv2_CURRENCY_LOCAL',             'local');
define('I18Nv2_CURRENCY_INTERNATIONAL',     'international');

define('I18Nv2_DATETIME_SHORT',             'short');
define('I18Nv2_DATETIME_DEFAULT',           'default');
define('I18Nv2_DATETIME_MEDIUM',            'medium');
define('I18Nv2_DATETIME_LONG',              'long');
define('I18Nv2_DATETIME_FULL',              'full');
/**#@-*/

require_once 'PEAR.php';

/**
 * I18Nv2_Locale
 *
 * @author       Michael Wallner <mike@php.net>
 * @version      $Revision$
 * @access       public
 * @package      I18Nv2
 */
class I18Nv2_Locale
{
    /**
     * Initialized Locale
     *
     * @var     string
     */
    protected $initialized = '';

    /**
     * Full day names
     *
     * @var     array
     */
    protected $days = array();

    /**
     * Full month names
     *
     * @var     array
     */
    protected $months = array();

    /**
     * Abbreviated day names
     *
     * @var     array
     */
    protected $abbrDays = array();

    /**
     * Abbreviated month names
     *
     * @var     array
     */
    protected $abbrMonths = array();

    /**
     * Registered date formats
     *
     * @var     array
     */
    protected $dateFormats = array();

    /**
     * Registered time formats
     *
     * @var     array
     */
    protected $timeFormats = array();

    /**
     * Registered datetime formats
     *
     * @var     array
     */
    protected $dateTimeFormats = array();

    /**
     * Registered number formats
     *
     * @var     array
     */
    protected $numberFormats = array();

    /**
     * Registered currency formats
     *
     * @var     array
     */
    protected $currencyFormats = array();

    /**
     * Current time format
     *
     * @var     mixed
     */
    protected $currentTimeFormat = null;

    /**
     * Current date format
     *
     * @var     mixed
     */
    protected $currentDateFormat = null;

    /**
     * Current datetime format
     *
     * @var     mixed
     */
    protected $currentDateTimeFormat = null;

    /**
     * Current number format
     *
     * @var     mixed
     */
    protected $currentNumberFormat = null;

    /**
     * Current currency format
     *
     * @var     mixed
     */
    protected $currentCurrencyFormat = null;

    /**
     * Custom formats
     *
     * @var     array
     */
    protected $customFormats = array();

    /**
     * Locale Data Cache
     *
     * @var     array
     */
    protected $cache = array();

    /**
     * Whether to reset the global locale after each call
     *
     * @var     bool
     */
    protected $paranoid = false;

    /**
     * Store system locale for paranoid mode
     *
     * @var     string
     */
    protected $usedLocale = '';

    /**
     * Constructor
     *
     * @param   string  $locale
     */
    public function __construct($locale = null, $paranoid = false)
    {
        $locale or $locale = I18Nv2::lastLocale(0, 'locale');
        $this->setLocale($locale);
        $this->setParanoid($paranoid);
    }

    /**
     * Set locale
     *
     * This automatically calls I18Nv2_Locale::initialize()
     *
     * @return  string  used system locale
     * @param   string  $locale
     * @param   bool    $force
     */
    public function setLocale($locale, $force = false)
    {
        if (!$force && $this->initialized == $locale) {
            $last = I18Nv2::lastLocale(0, true);
            if (is_array($last)) {
                if (    $locale == $last['syslocale']   ||
                        $locale == $last['locale']      ||
                        $locale == $last['language']) {
                    return $last['syslocale'];
                }
            } elseif ($last == $locale) {
                return $last;
            }
        }

        return $this->initialize($locale);
    }

    /**
     * Initialize
     *
     * @return  void
     */
    public function initialize($locale)
    {
        $this->initialized = $locale;
        $this->usedLocale = I18Nv2::setLocale($locale);

        $jan = $mon = mktime(1,1,1,1,1,1990);
        $feb = $tue = mktime(1,1,1,2,6,1990);
        $mar = $wed = mktime(1,1,1,3,7,1990);
        $apr = $thu = mktime(1,1,1,4,5,1990);
        $may = $fri = mktime(1,1,1,5,4,1990);
        $jun = $sat = mktime(1,1,1,6,2,1990);
        $jul = $sun = mktime(1,1,1,7,1,1990);
        $aug = mktime(1,1,1,8,1,1990);
        $sep = mktime(1,1,1,9,1,1990);
        $oct = mktime(1,1,1,10,1,1990);
        $nov = mktime(1,1,1,11,1,1990);
        $dec = mktime(1,1,1,12,1,1990);

        if (!$this->loadCache($this->usedLocale)) {
            $this->days = array(
                strftime('%A', $sun),
                strftime('%A', $mon),
                strftime('%A', $tue),
                strftime('%A', $wed),
                strftime('%A', $thu),
                strftime('%A', $fri),
                strftime('%A', $sat),
            );

            $this->abbrDays = array(
                strftime('%a', $sun),
                strftime('%a', $mon),
                strftime('%a', $tue),
                strftime('%a', $wed),
                strftime('%a', $thu),
                strftime('%a', $fri),
                strftime('%a', $sat),
            );

            $this->months = array(
                strftime('%B', $jan),
                strftime('%B', $feb),
                strftime('%B', $mar),
                strftime('%B', $apr),
                strftime('%B', $may),
                strftime('%B', $jun),
                strftime('%B', $jul),
                strftime('%B', $aug),
                strftime('%B', $sep),
                strftime('%B', $oct),
                strftime('%B', $nov),
                strftime('%B', $dec),
            );

            $this->abbrMonths = array(
                strftime('%b', $jan),
                strftime('%b', $feb),
                strftime('%b', $mar),
                strftime('%b', $apr),
                strftime('%b', $may),
                strftime('%b', $jun),
                strftime('%b', $jul),
                strftime('%b', $aug),
                strftime('%b', $sep),
                strftime('%b', $oct),
                strftime('%b', $nov),
                strftime('%b', $dec),
            );

            $info = I18Nv2::getInfo();

            /*
             * The currency symbol is old shit on Win2k, though.
             * Some get extended/overwritten with other local conventions.
             */
            $this->currencyFormats = array(
                I18Nv2_CURRENCY_LOCAL => array(
                    $info['currency_symbol'],
                    $info['int_frac_digits'],
                    $info['mon_decimal_point'],
                    $info['mon_thousands_sep'],
                    $info['negative_sign'],
                    $info['positive_sign'],
                    $info['n_cs_precedes'],
                    $info['p_cs_precedes'],
                    $info['n_sep_by_space'],
                    $info['p_sep_by_space'],
                    $info['n_sign_posn'],
                    $info['p_sign_posn'],
                ),
                I18Nv2_CURRENCY_INTERNATIONAL => array(
                    $info['int_curr_symbol'],
                    $info['int_frac_digits'],
                    $info['mon_decimal_point'],
                    $info['mon_thousands_sep'],
                    $info['negative_sign'],
                    $info['positive_sign'],
                    $info['n_cs_precedes'],
                    $info['p_cs_precedes'],
                    true,
                    true,
                    $info['n_sign_posn'],
                    $info['p_sign_posn'],
                ),
            );

            $this->numberFormats = array(
                I18Nv2_NUMBER_FLOAT => array(
                    $info['frac_digits'],
                    $info['decimal_point'],
                    $info['thousands_sep']
                ),
                I18Nv2_NUMBER_INTEGER => array(
                    '0',
                    $info['decimal_point'],
                    $info['thousands_sep']
                ),

            );

            $this->loadExtension();

            if (empty($this->dateTimeFormats) && !empty($this->dateFormats) && !empty($this->timeFormats)) {
                $this->dateTimeFormats = array(
                    I18Nv2_DATETIME_SHORT   =>
                        $this->dateFormats[I18Nv2_DATETIME_SHORT]
                        . ', ' .
                        $this->timeFormats[I18Nv2_DATETIME_SHORT],
                    I18Nv2_DATETIME_MEDIUM   =>
                        $this->dateFormats[I18Nv2_DATETIME_MEDIUM]
                        . ', ' .
                        $this->timeFormats[I18Nv2_DATETIME_MEDIUM],
                    I18Nv2_DATETIME_DEFAULT   =>
                        $this->dateFormats[I18Nv2_DATETIME_DEFAULT]
                        . ', ' .
                        $this->timeFormats[I18Nv2_DATETIME_DEFAULT],
                    I18Nv2_DATETIME_LONG   =>
                        $this->dateFormats[I18Nv2_DATETIME_LONG]
                        . ', ' .
                        $this->timeFormats[I18Nv2_DATETIME_LONG],
                    I18Nv2_DATETIME_FULL   =>
                        $this->dateFormats[I18Nv2_DATETIME_FULL]
                        . ', ' .
                        $this->timeFormats[I18Nv2_DATETIME_FULL],
                );
            }
            $this->updateCache($this->usedLocale);
        }

        $this->setDefaults();

        if ($this->paranoid) {
            setlocale(LC_ALL, 'C');
        }

        return $this->usedLocale;
    }

    /**
     * Update Cache
     *
     * @return  void
     * @param   string  $locale
     */
    protected function updateCache($locale)
    {
        if (!isset($this->cache[$locale])) {
            $cache = get_object_vars($this);
            $cvars = preg_grep(
                '/^(init|current|custom|cache)/',
                array_keys($cache),
                PREG_GREP_INVERT
            );
            foreach ($cvars as $var) {
                $this->cache[$locale][$var] = $cache[$var];
            }
        }
    }

    /**
     * Load Cache
     *
     * @return  bool
     * @param   string  $locale
     */
    protected function loadCache($locale)
    {
        if (!isset($this->cache[$locale])) {
            return false;
        }
        foreach ($this->cache[$locale] as $var => $value) {
            $this->$var = $value;
        }
        return true;
    }

    /**
     * Loads corresponding locale extension
     *
     * @return  void
     */
    public function loadExtension()
    {
        $locale = I18Nv2::lastLocale(0, true);
        if (isset($locale)) {
            $dir = dirname(__FILE__);
            foreach (array($locale['language'], $locale['locale']) as $lc) {
                if (is_file($dir . '/Locale/' . $lc . '.php')) {
                    include $dir . '/Locale/' . $lc . '.php';
                }
            }
        }
    }

    /**
     * Set defaults
     *
     * @return  void
     */
    public function setDefaults()
    {
        $this->currentTimeFormat     = null;
        $this->currentDateFormat     = null;
        $this->currentDateTimeFormat = null;
        $this->currentNumberFormat   = null;
        $this->currentCurrencyFormat = null;

        if (isset($this->timeFormats[I18Nv2_DATETIME_DEFAULT])) {
            $this->currentTimeFormat = $this->timeFormats[I18Nv2_DATETIME_DEFAULT];
        }

        if (isset($this->dateFormats[I18Nv2_DATETIME_DEFAULT])) {
            $this->currentDateFormat = $this->dateFormats[I18Nv2_DATETIME_DEFAULT];
        }

        if (isset($this->dateTimeFormats[I18Nv2_DATETIME_DEFAULT])) {
            $this->currentDateTimeFormat = $this->dateTimeFormats[I18Nv2_DATETIME_DEFAULT];
        }

        if (isset($this->numberFormats[I18Nv2_NUMBER_FLOAT])) {
            $this->currentNumberFormat = $this->numberFormats[I18Nv2_NUMBER_FLOAT];
        }

        if (isset($this->currencyFormats[I18Nv2_CURRENCY_INTERNATIONAL])) {
            $this->currentCurrencyFormat = $this->currencyFormats[I18Nv2_CURRENCY_INTERNATIONAL];
        }
    }

    /**
     * Set Paranoid Mode
     *
     * Whether to reset to the C-locale after every call.
     *
     * @return  void
     * @param   bool    $paranoid Whether to enable paranoid mode.
     */
    public function setParanoid($paranoid = false)
    {
        $this->paranoid = (bool) $paranoid;
        $paranoid and setLocale(LC_ALL, 'C');
    }

    /**
     * Set currency format
     *
     * @return  mixed   Returns &true; on success or <classname>PEAR_Error</classname> on failure.
     * @param   int     $format     a I18Nv2_CURRENCY constant
     * @param   bool    $custom     whether to use a defined custom format
     */
    public function setCurrencyFormat($format, $custom = false)
    {
        if ($custom) {
            if (!isset($this->customFormats[$format])) {
                return PEAR::raiseError('Custom currency format "'.$format.'" doesn\'t exist.');
            }
            $this->currentCurrencyFormat = $this->customFormats[$format];
        } else {
            if (!isset($this->currencyFormats[$format])) {
                return PEAR::raiseError('Currency format "'.$format.'" doesn\'t exist.');
            }
            $this->currentCurrencyFormat = $this->currencyFormats[$format];
        }
        return true;
    }

    /**
     * Set number format
     *
     * @return  mixed   Returns &true; on success or <classname>PEAR_Error</classname> on failure.
     * @param   int     $format     a I18Nv2_NUMBER constant
     * @param   bool    $custom     whether to use a defined custom format
     */
    public function setNumberFormat($format, $custom = false)
    {
        if ($custom) {
            if (!isset($this->customFormats[$format])) {
                return PEAR::raiseError('Custom number format "'.$format.'" doesn\'t exist.');
            }
            $this->currentNumberFormat = $this->customFormats[$format];
        } else {
            if (!isset($this->numberFormats[$format])) {
                return PEAR::raiseError('Number format "'.$format.'" doesn\'t exist.');
            }
            $this->currentNumberFormat = $this->numberFormats[$format];
        }
        return true;
    }

    /**
     * Set date format
     *
     * @return  mixed   Returns &true; on success or <classname>PEAR_Error</classname> on failure.
     * @param   int     $format     a I18Nv2_DATETIME constant
     * @param   bool    $custom     whether to use a defined custom format
     */
    public function setDateFormat($format, $custom = false)
    {
        if ($custom) {
            if (!isset($this->customFormats[$format])) {
                return PEAR::raiseError('Custom date fromat "'.$format.'" doesn\'t exist.');
            }
            $this->currentDateFormat = $this->customFormats[$format];
        } else {
            if (!isset($this->dateFormats[$format])) {
                return PEAR::raiseError('Date format "'.$format.'" doesn\'t exist.');
            }
            $this->currentDateFormat = $this->dateFormats[$format];
        }
        return true;
    }

    /**
     * Set time format
     *
     * @return  mixed
     * @param   int     $format     a I18Nv2_DATETIME constant
     * @param   bool    $custom     whether to use a defined custom format
     */
    public function setTimeFormat($format, $custom = false)
    {
        if ($custom) {
            if (!isset($this->customFormats[$format])) {
                return PEAR::raiseError('Custom time format "'.$format.'" doesn\'t exist.');
            }
            $this->currentTimeFormat = $this->customFormats[$format];
        } else {
            if (!isset($this->timeFormats[$format])) {
                return PEAR::raiseError('Time format "'.$format.'" doesn\'t exist.');
            }
            $this->currentTimeFormat = $this->timeFormats[$format];
        }
        return true;
    }

    /**
     * Set datetime format
     *
     * @return  mixed
     * @param   int     $format     a I18Nv2_DATETIME constant
     * @param   bool    $custom     whether to use a defined custom format
     */
    public function setDateTimeFormat($format, $custom = false)
    {
        if ($custom) {
            if (!isset($this->customFormats[$format])) {
                return PEAR::raiseError('Custom datetime format "'.$format.'" doesn\'t exist.');
            }
            $this->currentDateTimeFormat = $this->customFormats[$format];
        } else {
            if (!isset($this->dateTimeFormats[$format])) {
                return PEAR::raiseError('Datetime format "'.$format.'" doesn\'t exist.');
            }
            $this->currentDateTimeFormat = $this->dateTimeFormats[$format];
        }
        return true;
    }

    /**
     * Set custom format
     *
     * If <var>$format</var> is omitted, the custom format for <var>$type</var>
     * will be dsicarded - if both vars are omitted all custom formats will
     * be discarded.
     *
     * @return  void
     * @param   mixed   $type
     * @param   mixed   $format
     */
    public function setCustomFormat($type = null, $format = null)
    {
        if (!isset($format)) {
            if (!isset($type)) {
                $this->customFormats = array();
            } else {
                unset($this->customFormats[$type]);
            }
        } else {
            $this->customFormats[$type] = $format;
        }
    }

    /**
     * Format currency
     *
     * @return  string
     * @param   numeric $value
     * @param   int     $overrideFormat
     * @param   string  $overrideSymbol
     */
    public function formatCurrency($value, $overrideFormat = null, $overrideSymbol = null)
    {
        @list(
            $symbol,
            $digits,
            $decpoint,
            $thseparator,
            $sign['-'],
            $sign['+'],
            $precedes['-'],
            $precedes['+'],
            $separate['-'],
            $separate['+'],
            $position['-'],
            $position['+']
        ) = isset($overrideFormat) ?
            $this->currencyFormats[$overrideFormat] :
            $this->currentCurrencyFormat;

        if (isset($overrideSymbol)) {
            $symbol = $overrideSymbol;
        }

        // number_format the absolute value
        $amount = number_format(abs($value), $digits, $decpoint, $thseparator);

        $S = $value < 0 ? '-' : '+';

        // check posittion of the positive/negative sign(s)
        switch ($position[$S])
        {
            case 0: $amount  = '('. $amount .')';   break;
            case 1: $amount  = $sign[$S] . $amount; break;
            case 2: $amount .= $sign[$S];           break;
            case 3: $symbol  = $sign[$S] . $symbol; break;
            case 4: $symbol .= $sign[$S];           break;
        }

        // currency symbol precedes amount
        if ($precedes[$S]) {
            $amount = $symbol . ($separate[$S] ? ' ':'') . $amount;
        }
        // currency symbol succedes amount
        else {
            $amount .= ($separate[$S] ? ' ':'') . $symbol;
        }

        return $amount;
    }

    /**
     * Format a number
     *
     * @return  string
     * @param   numeric $value
     * @param   int     $overrideFormat
     */
    public function formatNumber($value, $overrideFormat = null)
    {
        list($dig, $dec, $sep) = isset($overrideFormat) ?
            $this->numberFormats[$overrideFormat] :
            $this->currentNumberFormat;
        return number_format($value, $dig, $dec, $sep);
    }

    /**
     * Format a date
     *
     * @return  string
     * @param   int     $timestamp
     * @param   int     $overrideFormat
     */
    public function formatDate($timestamp = null, $overrideFormat = null)
    {
        $format = isset($overrideFormat) ?
            $this->dateFormats[$overrideFormat] : $this->currentDateFormat;
        $this->paranoid and setLocale(LC_ALL, $this->usedLocale);
        $date = strftime($format, isset($timestamp) ? $timestamp : time());
        $this->paranoid and setLocale(LC_ALL, 'C');
        return $date;
    }

    /**
     * Format a time
     *
     * @return  string
     * @param   int     $timestamp
     * @param   int     $overrideFormat
     */
    public function formatTime($timestamp = null, $overrideFormat = null)
    {
        $format = isset($overrideFormat) ?
            $this->timeFormats[$overrideFormat] : $this->currentTimeFormat;
        $this->paranoid and setLocale(LC_ALL, $this->usedLocale);
        $time = strftime($format, isset($timestamp) ? $timestamp : time());
        $this->paranoid and setLocale(LC_ALL, 'C');
        return $time;
    }

    /**
     * Format a datetime
     *
     * @return  string
     * @param   int     $timestamp
     * @param   int     $overrideFormat
     */
    public function formatDateTime($timestamp = null, $overrideFormat = null)
    {
        $format = isset($overrideFormat) ?
            $this->dateTimeFormats[$overrideFormat] :
            $this->currentDateTimeFormat;
        $this->paranoid and setLocale(LC_ALL, $this->usedLocale);
        $date = strftime($format, isset($timestamp) ? $timestamp : time());
        $this->paranoid and setLocale(LC_ALL, 'C');
        return $date;
    }

    /**
     * Locale time
     *
     * @return  string
     * @param   int     $timestamp
     */
    public function time($timestamp = null)
    {
        $this->paranoid and setLocale(LC_ALL, $this->usedLocale);
        $time = strftime('%X', isset($timestamp) ? $timestamp : time());
        $this->paranoid and setLocale(LC_ALL, 'C');
        return $time;
    }

    /**
     * Locale date
     *
     * @return  string
     * @param   int     $timestamp
     */
    public function date($timestamp = null)
    {
        $this->paranoid and setLocale(LC_ALL, $this->usedLocale);
        $date = strftime('%x', isset($timestamp) ? $timestamp : time());
        $this->paranoid and setLocale(LC_ALL, 'C');
        return $date;
    }

    /**
     * Day name
     *
     * @return  mixed   Returns &type.string; name of weekday on success or
     *                  <classname>PEAR_Error</classname> on failure.
     * @param   int     $weekday    numerical representation of weekday
     *                              (0 = Sunday, 1 = Monday, ...)
     * @param   bool    $short  whether to return the abbreviation
     */
    public function dayName($weekday, $short = false)
    {
        if ($short) {
            if (!isset($this->abbrDays[$weekday])) {
                return PEAR::raiseError('Weekday "'.$weekday.'" is out of range.');
            }
            return $this->abbrDays[$weekday];
        } else {
            if (!isset($this->days[$weekday])) {
                return PEAR::raiseError('Weekday "'.$weekday.'" is out of range.');
            }
            return $this->days[$weekday];
        }
    }

    /**
     * Month name
     *
     * @return  mixed   Returns &type.string; name of month on success or
     *                  <classname>PEAR_Error</classname> on failure.
     * @param   int     $month  numerical representation of month
     *                          (0 = January, 1 = February, ...)
     * @param   bool    $short  whether to return the abbreviation
     */
    public function monthName($month, $short = false)
    {
        if ($short) {
            if (!isset($this->abbrMonths[$month])) {
                return PEAR::raiseError('Month "'.$month.'" is out of range.');
            }
            return $this->abbrMonths[$month];
        } else {
            if (!isset($this->months[$month])) {
                return PEAR::raiseError('Month "'.$month.'" is out of range.');
            }
            return $this->months[$month];
        }
    }
}
