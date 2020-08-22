<?php
/**
 * Created by PhpStorm.
 * @author: Alexey Tishchenko
 * @email: tischenkoalexey1@gmail.com
 * @UpWork: https://www.upwork.com/freelancers/~01ad7ed1a6ade4e02e
 * @date: 08.02.16
 */
namespace sjoorm\yii\components\helpers;
use yii\base\InvalidConfigException;
use yii\base\BaseObject;
use yii\helpers\Html;

/**
 * Class PhoneNumber is a helper which allows you to validate phone numbers,
 * detect countries where it belongs to and output it in different formats
 * @package sjoorm\yii\components\helpers
 *
 * @property boolean $isValid shows if the phone number is valid or not
 * @property string $asInternational returns phone number as international dial number
 * @property string $asLink returns phone number as HTML dial <a> tag (skype: by default)
 * @property string $asHtml returns phone number as HTML <span> tag (bootstrap label by default)
 */
class PhoneNumber extends BaseObject {

    /** @var array list of available country dial codes [ISO => 123]  */
    private static $_codes = [
        'AF' => '93',
        'AL' => '355',
        'DZ' => '213',
        'AS' => '1684',
        'AD' => '376',
        'AO' => '244',
        'AI' => '1264',
        'AQ' => '672',
        'AG' => '1268',
        'AR' => '54',
        'AM' => '374',
        'AW' => '297',
        'AU' => '61',
        'AT' => '43',
        'AZ' => '994',
        'BS' => '1242',
        'BH' => '973',
        'BD' => '880',
        'BB' => '1246',
        'BY' => '375',
        'BE' => '32',
        'BZ' => '501',
        'BJ' => '229',
        'BM' => '1441',
        'BT' => '975',
        'BO' => '591',
        'BQ' => '599',
        'BA' => '387',
        'BW' => '267',
        'BV' => '47',
        'BR' => '55',
        'IO' => '246',
        'BN' => '673',
        'BG' => '359',
        'BF' => '226',
        'BI' => '257',
        'KH' => '855',
        'CM' => '237',
        'CA' => '1',
        'CV' => '238',
        'KY' => '1345',
        'CF' => '236',
        'TD' => '235',
        'CL' => '56',
        'CN' => '86',
        'CX' => '61',
        'CC' => '61',
        'CO' => '57',
        'KM' => '269',
        'CG' => '242',
        'CD' => '243',
        'CK' => '682',
        'CR' => '506',
        'HR' => '385',
        'CU' => '53',
        'CW' => '599',
        'CY' => '357',
        'CZ' => '420',
        'CI' => '225',
        'DK' => '45',
        'DJ' => '253',
        'DM' => '1767',
        'DO' => ['1809','1829','1849'],
        'EC' => '593',
        'EG' => '20',
        'SV' => '503',
        'GQ' => '240',
        'ER' => '291',
        'EE' => '372',
        'ET' => '251',
        'FK' => '500',
        'FO' => '298',
        'FJ' => '679',
        'FI' => '358',
        'FR' => '33',
        'GF' => '594',
        'PF' => '689',
        'TF' => '262',
        'GA' => '241',
        'GM' => '220',
        'GE' => '995',
        'DE' => '49',
        'GH' => '233',
        'GI' => '350',
        'GR' => '30',
        'GL' => '299',
        'GD' => '1473',
        'GP' => '590',
        'GU' => '1671',
        'GT' => '502',
        'GG' => '44',
        'GN' => '224',
        'GW' => '245',
        'GY' => '592',
        'HT' => '509',
        'HM' => '672',
        'VA' => '3906',
        'HN' => '504',
        'HK' => '852',
        'HU' => '36',
        'IS' => '354',
        'IN' => '91',
        'ID' => '62',
        'IR' => '98',
        'IQ' => '964',
        'IE' => '353',
        'IM' => '44',
        'IL' => '972',
        'IT' => '39',
        'JM' => '1876',
        'JP' => '81',
        'JE' => '44',
        'JO' => '962',
        'KZ' => '7',
        'KE' => '254',
        'KI' => '686',
        'KP' => '850',
        'KR' => '82',
        'KW' => '965',
        'KG' => '996',
        'LA' => '856',
        'LV' => '371',
        'LB' => '961',
        'LS' => '266',
        'LR' => '231',
        'LY' => '218',
        'LI' => '423',
        'LT' => '370',
        'LU' => '352',
        'MO' => '853',
        'MK' => '389',
        'MG' => '261',
        'MW' => '265',
        'MY' => '60',
        'MV' => '960',
        'ML' => '223',
        'MT' => '356',
        'MH' => '692',
        'MQ' => '596',
        'MR' => '222',
        'MU' => '230',
        'YT' => '262',
        'MX' => '52',
        'FM' => '691',
        'MD' => '373',
        'MC' => '377',
        'MN' => '976',
        'ME' => '382',
        'MS' => '1664',
        'MA' => '212',
        'MZ' => '258',
        'MM' => '95',
        'NA' => '264',
        'NR' => '674',
        'NP' => '977',
        'NL' => '31',
        'NC' => '687',
        'NZ' => '64',
        'NI' => '505',
        'NE' => '227',
        'NG' => '234',
        'NU' => '683',
        'NF' => '672',
        'MP' => '1670',
        'NO' => '47',
        'OM' => '968',
        'PK' => '92',
        'PW' => '680',
        'PS' => '970',
        'PA' => '507',
        'PG' => '675',
        'PY' => '595',
        'PE' => '51',
        'PH' => '63',
        'PN' => '870',
        'PL' => '48',
        'PT' => '351',
        'PR' => '1',
        'QA' => '974',
        'RO' => '40',
        'RU' => '7',
        'RW' => '250',
        'RE' => '262',
        'BL' => '590',
        'SH' => '290',
        'KN' => '1869',
        'LC' => '1758',
        'MF' => '590',
        'PM' => '508',
        'VC' => '1784',
        'WS' => '685',
        'SM' => '378',
        'ST' => '239',
        'SA' => '966',
        'SN' => '221',
        'RS' => '381',
        'SC' => '248',
        'SL' => '232',
        'SG' => '65',
        'SX' => '1721',
        'SK' => '421',
        'SI' => '386',
        'SB' => '677',
        'SO' => '252',
        'ZA' => '27',
        'GS' => '500',
        'SS' => '211',
        'ES' => '34',
        'LK' => '94',
        'SD' => '249',
        'SR' => '597',
        'SJ' => '47',
        'SZ' => '268',
        'SE' => '46',
        'CH' => '41',
        'SY' => '963',
        'TW' => '886',
        'TJ' => '992',
        'TZ' => '255',
        'TH' => '66',
        'TL' => '670',
        'TG' => '228',
        'TK' => '690',
        'TO' => '676',
        'TT' => '1868',
        'TN' => '216',
        'TR' => '90',
        'TM' => '993',
        'TC' => '1649',
        'TV' => '688',
        'UG' => '256',
        'UA' => '380',
        'AE' => '971',
        'GB' => '44',
        'US' => '1',
        //'UM' => '', // no phone code
        'UY' => '598',
        'UZ' => '998',
        'VU' => '678',
        'VE' => '58',
        'VN' => '84',
        'VG' => '1284',
        'VI' => '1340',
        'WF' => '681',
        'EH' => '212',
        'YE' => '967',
        'ZM' => '260',
        'ZW' => '263',
        'AX' => '358',
    ];

    /** @var array trunc codes replacements */
    private $_trunkExpressions = [
        //TODO: complete
        0 => '/^0+/',
        'RU' => '/^8/',
    ];

    /** @var string raw input phone number string */
    public $raw;
    /**
     * @var boolean if an invalid config exception should be thrown
     * while parsing incorrect international number
     */
    public $throwException = false;
    public $templateValid = "<span class='label label-success'>+{code}{number}</span>";
    public $templateInvalid = "<span class='label label-danger'>+{code}{number}</span>";

    /** @var string XX ISO 3166 country code */
    public $iso;
    /** @var string dial country code */
    public $code;
    /** @var string national number */
    public $number;

    /**
     * Gets country phone codes list
     * @return array
     */
    public static function getCodes() {
        return static::$_codes;
    }

    /**
     * Removes non-digit symbols from phone number string
     * @param string $number
     * @return string
     */
    public static function purify($number) {
        return preg_replace(['/\D/', '/^0+/'], '', $number);
    }

    /**
     * Removes local trunk prefix from a phone number string
     * @param string $number
     * @return string
     */
    private function removeTrunkPrefix($number) {
        return preg_replace(
            isset($this->_trunkExpressions[$this->iso]) ?
                $this->_trunkExpressions[$this->iso] : $this->_trunkExpressions[0],
            '',
            $number
        );
    }

    /**
     * Parses given international phone number
     */
    private function parseInternational() {
        // remove non-digit symbols
        $number = static::purify($this->raw);

        // find out international dial code
        foreach(static::$_codes as $iso => $codes) {
            if(!is_array($codes)) {
                $codes = [$codes];
            }
            // if multiple codes (for example Dominican Republic)
            foreach($codes as $code) {
                if(strpos($number, $code) === 0) {
                    $this->iso = $iso;
                    $this->code = $code;
                    $this->number = $this->removeTrunkPrefix(substr($number, strlen($code)));
                    break;
                }
            }
            if(isset($this->iso)) {
                break;
            }
        }

        // check if dial code was found
        if(empty($this->iso)) {
            $this->number = $number;

            if($this->throwException) {
                throw new InvalidConfigException('Invalid international phone number provided.');
            }
        }
    }

    /**
     * Parses given local phone number
     * @return string
     */
    private function parseLocal() {
        // remove non-digit symbols
        $number = static::purify($this->raw);

        $this->number = $this->removeTrunkPrefix($number);
    }

    /** @inheritdoc */
    public function init() {
        if(empty($this->raw)) {
            throw new InvalidConfigException('Input phone number is required!');
        }

        if($this->iso) { // national format
            if(!isset(static::$_codes[$this->iso])) {
                throw new InvalidConfigException('Invalid ISO country code provided.');
            }

            $this->code = static::$_codes[$this->iso];
            $this->parseLocal();
        } elseif($this->code) { // national format
            $iso = array_search($this->code, static::$_codes);
            if(!$iso) {
                throw new InvalidConfigException('Invalid country dial code provided.');
            }

            $this->iso = $iso;
            $this->parseLocal();
        } else { // international format
            $this->parseInternational();
        }

        parent::init();
    }

    /**
     * Checks if parsing was successful
     * @return boolean
     */
    public function getIsValid() {
        return $this->iso && $this->code && $this->number;
    }

    /** Formatting */

    /**
     * Outputs fully-qualified phone number digits
     * @return string
     */
    public function __toString() {
        return $this->code . $this->number;
    }

    /**
     * Gets phone number in E164 international dialing format
     * @return string
     */
    public function getAsInternational() {
        return "+{$this->code}{$this->number}";
    }

    /**
     * Gets phone number in E164 international dialing format
     * @param string $href href attr template with "{number}" placeholder
     * @param array $options Html::a() options
     * @return string
     */
    public function getAsLink($href = 'skype:{number}?call', array $options = []) {
        return Html::a(
            $this->asInternational,
            str_replace('{number}', $this->asInternational, $href),
            $options
        );
    }

    /**
     * Generates HTML string using configured templates for valid and invalid phone numbers
     * @return string
     */
    public function getAsHtml() {
        return str_replace(
            ['{iso}', '{code}', '{number}'],
            [$this->iso, $this->code, $this->number],
            $this->isValid ? $this->templateValid : $this->templateInvalid
        );
    }
}
