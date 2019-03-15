<?php

/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Shared
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */
/**
 * PHPExcel_Shared_String
 *
 * @category   PHPExcel
 * @package    PHPExcel_Shared
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Shared_String
{
    /**	Constants				*/
    /**	Regular Expressions		*/
    //	Fraction
    const STRING_REGEXP_FRACTION = '(-?)(\\d+)\\s+(\\d+\\/\\d+)';
    /**
     * Control characters array
     *
     * @var string[]
     */
    private static $_controlCharacters = array();
    /**
     * SYLK Characters array
     *
     * $var array
     */
    private static $_SYLKCharacters = array();
    /**
     * Decimal separator
     *
     * @var string
     */
    private static $_decimalSeparator;
    /**
     * Thousands separator
     *
     * @var string
     */
    private static $_thousandsSeparator;
    /**
     * Currency code
     *
     * @var string
     */
    private static $_currencyCode;
    /**
     * Is mbstring extension avalable?
     *
     * @var boolean
     */
    private static $_isMbstringEnabled;
    /**
     * Is iconv extension avalable?
     *
     * @var boolean
     */
    private static $_isIconvEnabled;
    /**
     * Build control characters array
     */
    private static function _buildControlCharacters()
    {
        for ($i = 0; $i <= 31; ++$i) {
            if ($i != 9 && $i != 10 && $i != 13) {
                $find = '_x' . sprintf('%04s', strtoupper(dechex($i))) . '_';
                $replace = chr($i);
                self::$_controlCharacters[$find] = $replace;
            }
        }
    }
    /**
     * Build SYLK characters array
     */
    private static function _buildSYLKCharacters()
    {
        self::$_SYLKCharacters = array(
            "\33 0" => chr(0),
            "\33 1" => chr(1),
            "\33 2" => chr(2),
            "\33 3" => chr(3),
            "\33 4" => chr(4),
            "\33 5" => chr(5),
            "\33 6" => chr(6),
            "\33 7" => chr(7),
            "\33 8" => chr(8),
            "\33 9" => chr(9),
            "\33 :" => chr(10),
            "\33 ;" => chr(11),
            "\33 <" => chr(12),
            "\33 :" => chr(13),
            "\33 >" => chr(14),
            "\33 ?" => chr(15),
            "\33!0" => chr(16),
            "\33!1" => chr(17),
            "\33!2" => chr(18),
            "\33!3" => chr(19),
            "\33!4" => chr(20),
            "\33!5" => chr(21),
            "\33!6" => chr(22),
            "\33!7" => chr(23),
            "\33!8" => chr(24),
            "\33!9" => chr(25),
            "\33!:" => chr(26),
            "\33!;" => chr(27),
            "\33!<" => chr(28),
            "\33!=" => chr(29),
            "\33!>" => chr(30),
            "\33!?" => chr(31),
            "\33'?" => chr(127),
            "\33(0" => '€',
            // 128 in CP1252
            "\33(2" => '‚',
            // 130 in CP1252
            "\33(3" => 'ƒ',
            // 131 in CP1252
            "\33(4" => '„',
            // 132 in CP1252
            "\33(5" => '…',
            // 133 in CP1252
            "\33(6" => '†',
            // 134 in CP1252
            "\33(7" => '‡',
            // 135 in CP1252
            "\33(8" => 'ˆ',
            // 136 in CP1252
            "\33(9" => '‰',
            // 137 in CP1252
            "\33(:" => 'Š',
            // 138 in CP1252
            "\33(;" => '‹',
            // 139 in CP1252
            "\33Nj" => 'Œ',
            // 140 in CP1252
            "\33(>" => 'Ž',
            // 142 in CP1252
            "\33)1" => '‘',
            // 145 in CP1252
            "\33)2" => '’',
            // 146 in CP1252
            "\33)3" => '“',
            // 147 in CP1252
            "\33)4" => '”',
            // 148 in CP1252
            "\33)5" => '•',
            // 149 in CP1252
            "\33)6" => '–',
            // 150 in CP1252
            "\33)7" => '—',
            // 151 in CP1252
            "\33)8" => '˜',
            // 152 in CP1252
            "\33)9" => '™',
            // 153 in CP1252
            "\33):" => 'š',
            // 154 in CP1252
            "\33);" => '›',
            // 155 in CP1252
            "\33Nz" => 'œ',
            // 156 in CP1252
            "\33)>" => 'ž',
            // 158 in CP1252
            "\33)?" => 'Ÿ',
            // 159 in CP1252
            "\33*0" => ' ',
            // 160 in CP1252
            "\33N!" => '¡',
            // 161 in CP1252
            "\33N\"" => '¢',
            // 162 in CP1252
            "\33N#" => '£',
            // 163 in CP1252
            "\33N(" => '¤',
            // 164 in CP1252
            "\33N%" => '¥',
            // 165 in CP1252
            "\33*6" => '¦',
            // 166 in CP1252
            "\33N'" => '§',
            // 167 in CP1252
            "\33NH " => '¨',
            // 168 in CP1252
            "\33NS" => '©',
            // 169 in CP1252
            "\33Nc" => 'ª',
            // 170 in CP1252
            "\33N+" => '«',
            // 171 in CP1252
            "\33*<" => '¬',
            // 172 in CP1252
            "\33*=" => '­',
            // 173 in CP1252
            "\33NR" => '®',
            // 174 in CP1252
            "\33*?" => '¯',
            // 175 in CP1252
            "\33N0" => '°',
            // 176 in CP1252
            "\33N1" => '±',
            // 177 in CP1252
            "\33N2" => '²',
            // 178 in CP1252
            "\33N3" => '³',
            // 179 in CP1252
            "\33NB " => '´',
            // 180 in CP1252
            "\33N5" => 'µ',
            // 181 in CP1252
            "\33N6" => '¶',
            // 182 in CP1252
            "\33N7" => '·',
            // 183 in CP1252
            "\33+8" => '¸',
            // 184 in CP1252
            "\33NQ" => '¹',
            // 185 in CP1252
            "\33Nk" => 'º',
            // 186 in CP1252
            "\33N;" => '»',
            // 187 in CP1252
            "\33N<" => '¼',
            // 188 in CP1252
            "\33N=" => '½',
            // 189 in CP1252
            "\33N>" => '¾',
            // 190 in CP1252
            "\33N?" => '¿',
            // 191 in CP1252
            "\33NAA" => 'À',
            // 192 in CP1252
            "\33NBA" => 'Á',
            // 193 in CP1252
            "\33NCA" => 'Â',
            // 194 in CP1252
            "\33NDA" => 'Ã',
            // 195 in CP1252
            "\33NHA" => 'Ä',
            // 196 in CP1252
            "\33NJA" => 'Å',
            // 197 in CP1252
            "\33Na" => 'Æ',
            // 198 in CP1252
            "\33NKC" => 'Ç',
            // 199 in CP1252
            "\33NAE" => 'È',
            // 200 in CP1252
            "\33NBE" => 'É',
            // 201 in CP1252
            "\33NCE" => 'Ê',
            // 202 in CP1252
            "\33NHE" => 'Ë',
            // 203 in CP1252
            "\33NAI" => 'Ì',
            // 204 in CP1252
            "\33NBI" => 'Í',
            // 205 in CP1252
            "\33NCI" => 'Î',
            // 206 in CP1252
            "\33NHI" => 'Ï',
            // 207 in CP1252
            "\33Nb" => 'Ð',
            // 208 in CP1252
            "\33NDN" => 'Ñ',
            // 209 in CP1252
            "\33NAO" => 'Ò',
            // 210 in CP1252
            "\33NBO" => 'Ó',
            // 211 in CP1252
            "\33NCO" => 'Ô',
            // 212 in CP1252
            "\33NDO" => 'Õ',
            // 213 in CP1252
            "\33NHO" => 'Ö',
            // 214 in CP1252
            "\33-7" => '×',
            // 215 in CP1252
            "\33Ni" => 'Ø',
            // 216 in CP1252
            "\33NAU" => 'Ù',
            // 217 in CP1252
            "\33NBU" => 'Ú',
            // 218 in CP1252
            "\33NCU" => 'Û',
            // 219 in CP1252
            "\33NHU" => 'Ü',
            // 220 in CP1252
            "\33-=" => 'Ý',
            // 221 in CP1252
            "\33Nl" => 'Þ',
            // 222 in CP1252
            "\33N{" => 'ß',
            // 223 in CP1252
            "\33NAa" => 'à',
            // 224 in CP1252
            "\33NBa" => 'á',
            // 225 in CP1252
            "\33NCa" => 'â',
            // 226 in CP1252
            "\33NDa" => 'ã',
            // 227 in CP1252
            "\33NHa" => 'ä',
            // 228 in CP1252
            "\33NJa" => 'å',
            // 229 in CP1252
            "\33Nq" => 'æ',
            // 230 in CP1252
            "\33NKc" => 'ç',
            // 231 in CP1252
            "\33NAe" => 'è',
            // 232 in CP1252
            "\33NBe" => 'é',
            // 233 in CP1252
            "\33NCe" => 'ê',
            // 234 in CP1252
            "\33NHe" => 'ë',
            // 235 in CP1252
            "\33NAi" => 'ì',
            // 236 in CP1252
            "\33NBi" => 'í',
            // 237 in CP1252
            "\33NCi" => 'î',
            // 238 in CP1252
            "\33NHi" => 'ï',
            // 239 in CP1252
            "\33Ns" => 'ð',
            // 240 in CP1252
            "\33NDn" => 'ñ',
            // 241 in CP1252
            "\33NAo" => 'ò',
            // 242 in CP1252
            "\33NBo" => 'ó',
            // 243 in CP1252
            "\33NCo" => 'ô',
            // 244 in CP1252
            "\33NDo" => 'õ',
            // 245 in CP1252
            "\33NHo" => 'ö',
            // 246 in CP1252
            "\33/7" => '÷',
            // 247 in CP1252
            "\33Ny" => 'ø',
            // 248 in CP1252
            "\33NAu" => 'ù',
            // 249 in CP1252
            "\33NBu" => 'ú',
            // 250 in CP1252
            "\33NCu" => 'û',
            // 251 in CP1252
            "\33NHu" => 'ü',
            // 252 in CP1252
            "\33/=" => 'ý',
            // 253 in CP1252
            "\33N|" => 'þ',
            // 254 in CP1252
            "\33NHy" => 'ÿ',
        );
    }
    /**
     * Get whether mbstring extension is available
     *
     * @return boolean
     */
    public static function getIsMbstringEnabled()
    {
        if (isset(self::$_isMbstringEnabled)) {
            return self::$_isMbstringEnabled;
        }
        self::$_isMbstringEnabled = function_exists('mb_convert_encoding') ? true : false;
        return self::$_isMbstringEnabled;
    }
    /**
     * Get whether iconv extension is available
     *
     * @return boolean
     */
    public static function getIsIconvEnabled()
    {
        if (isset(self::$_isIconvEnabled)) {
            return self::$_isIconvEnabled;
        }
        // Fail if iconv doesn't exist
        if (!function_exists('iconv')) {
            self::$_isIconvEnabled = false;
            return false;
        }
        // Sometimes iconv is not working, and e.g. iconv('UTF-8', 'UTF-16LE', 'x') just returns false,
        if (!@iconv('UTF-8', 'UTF-16LE', 'x')) {
            self::$_isIconvEnabled = false;
            return false;
        }
        // Sometimes iconv_substr('A', 0, 1, 'UTF-8') just returns false in PHP 5.2.0
        // we cannot use iconv in that case either (http://bugs.php.net/bug.php?id=37773)
        if (!@iconv_substr('A', 0, 1, 'UTF-8')) {
            self::$_isIconvEnabled = false;
            return false;
        }
        // CUSTOM: IBM AIX iconv() does not work
        if (defined('PHP_OS') && @stristr(PHP_OS, 'AIX') && defined('ICONV_IMPL') && @strcasecmp(ICONV_IMPL, 'unknown') == 0 && defined('ICONV_VERSION') && @strcasecmp(ICONV_VERSION, 'unknown') == 0) {
            self::$_isIconvEnabled = false;
            return false;
        }
        // If we reach here no problems were detected with iconv
        self::$_isIconvEnabled = true;
        return true;
    }
    public static function buildCharacterSets()
    {
        if (empty(self::$_controlCharacters)) {
            self::_buildControlCharacters();
        }
        if (empty(self::$_SYLKCharacters)) {
            self::_buildSYLKCharacters();
        }
    }
    /**
     * Convert from OpenXML escaped control character to PHP control character
     *
     * Excel 2007 team:
     * ----------------
     * That's correct, control characters are stored directly in the shared-strings table.
     * We do encode characters that cannot be represented in XML using the following escape sequence:
     * _xHHHH_ where H represents a hexadecimal character in the character's value...
     * So you could end up with something like _x0008_ in a string (either in a cell value (<v>)
     * element or in the shared string <t> element.
     *
     * @param 	string	$value	Value to unescape
     * @return 	string
     */
    public static function ControlCharacterOOXML2PHP($value = '')
    {
        return str_replace(array_keys(self::$_controlCharacters), array_values(self::$_controlCharacters), $value);
    }
    /**
     * Convert from PHP control character to OpenXML escaped control character
     *
     * Excel 2007 team:
     * ----------------
     * That's correct, control characters are stored directly in the shared-strings table.
     * We do encode characters that cannot be represented in XML using the following escape sequence:
     * _xHHHH_ where H represents a hexadecimal character in the character's value...
     * So you could end up with something like _x0008_ in a string (either in a cell value (<v>)
     * element or in the shared string <t> element.
     *
     * @param 	string	$value	Value to escape
     * @return 	string
     */
    public static function ControlCharacterPHP2OOXML($value = '')
    {
        return str_replace(array_values(self::$_controlCharacters), array_keys(self::$_controlCharacters), $value);
    }
    /**
     * Try to sanitize UTF8, stripping invalid byte sequences. Not perfect. Does not surrogate characters.
     *
     * @param string $value
     * @return string
     */
    public static function SanitizeUTF8($value)
    {
        if (self::getIsIconvEnabled()) {
            $value = @iconv('UTF-8', 'UTF-8', $value);
            return $value;
        }
        if (self::getIsMbstringEnabled()) {
            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            return $value;
        }
        // else, no conversion
        return $value;
    }
    /**
     * Check if a string contains UTF8 data
     *
     * @param string $value
     * @return boolean
     */
    public static function IsUTF8($value = '')
    {
        return $value === '' || preg_match('/^./su', $value) === 1;
    }
    /**
     * Formats a numeric value as a string for output in various output writers forcing
     * point as decimal separator in case locale is other than English.
     *
     * @param mixed $value
     * @return string
     */
    public static function FormatNumber($value)
    {
        if (is_float($value)) {
            return str_replace(',', '.', $value);
        }
        return (string) $value;
    }
    /**
     * Converts a UTF-8 string into BIFF8 Unicode string data (8-bit string length)
     * Writes the string using uncompressed notation, no rich text, no Asian phonetics
     * If mbstring extension is not available, ASCII is assumed, and compressed notation is used
     * although this will give wrong results for non-ASCII strings
     * see OpenOffice.org's Documentation of the Microsoft Excel File Format, sect. 2.5.3
     *
     * @param string  $value    UTF-8 encoded string
     * @param mixed[] $arrcRuns Details of rich text runs in $value
     * @return string
     */
    public static function UTF8toBIFF8UnicodeShort($value, $arrcRuns = array())
    {
        // character count
        $ln = self::CountCharacters($value, 'UTF-8');
        // option flags
        if (empty($arrcRuns)) {
            $opt = self::getIsIconvEnabled() || self::getIsMbstringEnabled() ? 0x1 : 0x0;
            $data = pack('CC', $ln, $opt);
            // characters
            $data .= self::ConvertEncoding($value, 'UTF-16LE', 'UTF-8');
        } else {
            $data = pack('vC', $ln, 0x9);
            $data .= pack('v', count($arrcRuns));
            // characters
            $data .= self::ConvertEncoding($value, 'UTF-16LE', 'UTF-8');
            foreach ($arrcRuns as $cRun) {
                $data .= pack('v', $cRun['strlen']);
                $data .= pack('v', $cRun['fontidx']);
            }
        }
        return $data;
    }
    /**
     * Converts a UTF-8 string into BIFF8 Unicode string data (16-bit string length)
     * Writes the string using uncompressed notation, no rich text, no Asian phonetics
     * If mbstring extension is not available, ASCII is assumed, and compressed notation is used
     * although this will give wrong results for non-ASCII strings
     * see OpenOffice.org's Documentation of the Microsoft Excel File Format, sect. 2.5.3
     *
     * @param string $value UTF-8 encoded string
     * @return string
     */
    public static function UTF8toBIFF8UnicodeLong($value)
    {
        // character count
        $ln = self::CountCharacters($value, 'UTF-8');
        // option flags
        $opt = self::getIsIconvEnabled() || self::getIsMbstringEnabled() ? 0x1 : 0x0;
        // characters
        $chars = self::ConvertEncoding($value, 'UTF-16LE', 'UTF-8');
        $data = pack('vC', $ln, $opt) . $chars;
        return $data;
    }
    /**
     * Convert string from one encoding to another. First try mbstring, then iconv, finally strlen
     *
     * @param string $value
     * @param string $to Encoding to convert to, e.g. 'UTF-8'
     * @param string $from Encoding to convert from, e.g. 'UTF-16LE'
     * @return string
     */
    public static function ConvertEncoding($value, $to, $from)
    {
        if (self::getIsIconvEnabled()) {
            return iconv($from, $to, $value);
        }
        if (self::getIsMbstringEnabled()) {
            return mb_convert_encoding($value, $to, $from);
        }
        if ($from == 'UTF-16LE') {
            return self::utf16_decode($value, false);
        } else {
            if ($from == 'UTF-16BE') {
                return self::utf16_decode($value);
            }
        }
        // else, no conversion
        return $value;
    }
    /**
     * Decode UTF-16 encoded strings.
     *
     * Can handle both BOM'ed data and un-BOM'ed data.
     * Assumes Big-Endian byte order if no BOM is available.
     * This function was taken from http://php.net/manual/en/function.utf8-decode.php
     * and $bom_be parameter added.
     *
     * @param   string  $str  UTF-16 encoded data to decode.
     * @return  string  UTF-8 / ISO encoded data.
     * @access  public
     * @version 0.2 / 2010-05-13
     * @author  Rasmus Andersson {@link http://rasmusandersson.se/}
     * @author vadik56
     */
    public static function utf16_decode($str, $bom_be = TRUE)
    {
        if (strlen($str) < 2) {
            return $str;
        }
        $c0 = ord($str[0]);
        $c1 = ord($str[1]);
        if ($c0 == 0xfe && $c1 == 0xff) {
            $str = substr($str, 2);
        } elseif ($c0 == 0xff && $c1 == 0xfe) {
            $str = substr($str, 2);
            $bom_be = false;
        }
        $len = strlen($str);
        $newstr = '';
        for ($i = 0; $i < $len; $i += 2) {
            if ($bom_be) {
                $val = ord($str[$i]) << 4;
                $val += ord($str[$i + 1]);
            } else {
                $val = ord($str[$i + 1]) << 4;
                $val += ord($str[$i]);
            }
            $newstr .= $val == 0x228 ? "\n" : chr($val);
        }
        return $newstr;
    }
    /**
     * Get character count. First try mbstring, then iconv, finally strlen
     *
     * @param string $value
     * @param string $enc Encoding
     * @return int Character count
     */
    public static function CountCharacters($value, $enc = 'UTF-8')
    {
        if (self::getIsMbstringEnabled()) {
            return mb_strlen($value, $enc);
        }
        if (self::getIsIconvEnabled()) {
            return iconv_strlen($value, $enc);
        }
        // else strlen
        return strlen($value);
    }
    /**
     * Get a substring of a UTF-8 encoded string. First try mbstring, then iconv, finally strlen
     *
     * @param string $pValue UTF-8 encoded string
     * @param int $pStart Start offset
     * @param int $pLength Maximum number of characters in substring
     * @return string
     */
    public static function Substring($pValue = '', $pStart = 0, $pLength = 0)
    {
        if (self::getIsMbstringEnabled()) {
            return mb_substr($pValue, $pStart, $pLength, 'UTF-8');
        }
        if (self::getIsIconvEnabled()) {
            return iconv_substr($pValue, $pStart, $pLength, 'UTF-8');
        }
        // else substr
        return substr($pValue, $pStart, $pLength);
    }
    /**
     * Convert a UTF-8 encoded string to upper case
     *
     * @param string $pValue UTF-8 encoded string
     * @return string
     */
    public static function StrToUpper($pValue = '')
    {
        if (function_exists('mb_convert_case')) {
            return mb_convert_case($pValue, MB_CASE_UPPER, "UTF-8");
        }
        return strtoupper($pValue);
    }
    /**
     * Convert a UTF-8 encoded string to lower case
     *
     * @param string $pValue UTF-8 encoded string
     * @return string
     */
    public static function StrToLower($pValue = '')
    {
        if (function_exists('mb_convert_case')) {
            return mb_convert_case($pValue, MB_CASE_LOWER, "UTF-8");
        }
        return strtolower($pValue);
    }
    /**
     * Convert a UTF-8 encoded string to title/proper case
     *    (uppercase every first character in each word, lower case all other characters)
     *
     * @param string $pValue UTF-8 encoded string
     * @return string
     */
    public static function StrToTitle($pValue = '')
    {
        if (function_exists('mb_convert_case')) {
            return mb_convert_case($pValue, MB_CASE_TITLE, "UTF-8");
        }
        return ucwords($pValue);
    }
    public static function mb_is_upper($char)
    {
        return mb_strtolower($char, "UTF-8") != $char;
    }
    public static function mb_str_split($string)
    {
        # Split at all position not after the start: ^
        # and not before the end: $
        return preg_split('/(?<!^)(?!$)/u', $string);
    }
    /**
     * Reverse the case of a string, so that all uppercase characters become lowercase
     *    and all lowercase characters become uppercase
     *
     * @param string $pValue UTF-8 encoded string
     * @return string
     */
    public static function StrCaseReverse($pValue = '')
    {
        if (self::getIsMbstringEnabled()) {
            $characters = self::mb_str_split($pValue);
            foreach ($characters as &$character) {
                if (self::mb_is_upper($character)) {
                    $character = mb_strtolower($character, 'UTF-8');
                } else {
                    $character = mb_strtoupper($character, 'UTF-8');
                }
            }
            return implode('', $characters);
        }
        return strtolower($pValue) ^ strtoupper($pValue) ^ $pValue;
    }
    /**
     * Identify whether a string contains a fractional numeric value,
     *    and convert it to a numeric if it is
     *
     * @param string &$operand string value to test
     * @return boolean
     */
    public static function convertToNumberIfFraction(&$operand)
    {
        if (preg_match('/^' . self::STRING_REGEXP_FRACTION . '$/i', $operand, $match)) {
            $sign = $match[1] == '-' ? '-' : '+';
            $fractionFormula = '=' . $sign . $match[2] . $sign . $match[3];
            $operand = PHPExcel_Calculation::getInstance()->_calculateFormulaValue($fractionFormula);
            return true;
        }
        return false;
    }
    //	function convertToNumberIfFraction()
    /**
     * Get the decimal separator. If it has not yet been set explicitly, try to obtain number
     * formatting information from locale.
     *
     * @return string
     */
    public static function getDecimalSeparator()
    {
        if (!isset(self::$_decimalSeparator)) {
            $localeconv = localeconv();
            self::$_decimalSeparator = $localeconv['decimal_point'] != '' ? $localeconv['decimal_point'] : $localeconv['mon_decimal_point'];
            if (self::$_decimalSeparator == '') {
                // Default to .
                self::$_decimalSeparator = '.';
            }
        }
        return self::$_decimalSeparator;
    }
    /**
     * Set the decimal separator. Only used by PHPExcel_Style_NumberFormat::toFormattedString()
     * to format output by PHPExcel_Writer_HTML and PHPExcel_Writer_PDF
     *
     * @param string $pValue Character for decimal separator
     */
    public static function setDecimalSeparator($pValue = '.')
    {
        self::$_decimalSeparator = $pValue;
    }
    /**
     * Get the thousands separator. If it has not yet been set explicitly, try to obtain number
     * formatting information from locale.
     *
     * @return string
     */
    public static function getThousandsSeparator()
    {
        if (!isset(self::$_thousandsSeparator)) {
            $localeconv = localeconv();
            self::$_thousandsSeparator = $localeconv['thousands_sep'] != '' ? $localeconv['thousands_sep'] : $localeconv['mon_thousands_sep'];
            if (self::$_thousandsSeparator == '') {
                // Default to .
                self::$_thousandsSeparator = ',';
            }
        }
        return self::$_thousandsSeparator;
    }
    /**
     * Set the thousands separator. Only used by PHPExcel_Style_NumberFormat::toFormattedString()
     * to format output by PHPExcel_Writer_HTML and PHPExcel_Writer_PDF
     *
     * @param string $pValue Character for thousands separator
     */
    public static function setThousandsSeparator($pValue = ',')
    {
        self::$_thousandsSeparator = $pValue;
    }
    /**
     *	Get the currency code. If it has not yet been set explicitly, try to obtain the
     *		symbol information from locale.
     *
     * @return string
     */
    public static function getCurrencyCode()
    {
        if (!isset(self::$_currencyCode)) {
            $localeconv = localeconv();
            self::$_currencyCode = $localeconv['currency_symbol'] != '' ? $localeconv['currency_symbol'] : $localeconv['int_curr_symbol'];
            if (self::$_currencyCode == '') {
                // Default to $
                self::$_currencyCode = '$';
            }
        }
        return self::$_currencyCode;
    }
    /**
     * Set the currency code. Only used by PHPExcel_Style_NumberFormat::toFormattedString()
     *		to format output by PHPExcel_Writer_HTML and PHPExcel_Writer_PDF
     *
     * @param string $pValue Character for currency code
     */
    public static function setCurrencyCode($pValue = '$')
    {
        self::$_currencyCode = $pValue;
    }
    /**
     * Convert SYLK encoded string to UTF-8
     *
     * @param string $pValue
     * @return string UTF-8 encoded string
     */
    public static function SYLKtoUTF8($pValue = '')
    {
        // If there is no escape character in the string there is nothing to do
        if (strpos($pValue, '') === false) {
            return $pValue;
        }
        foreach (self::$_SYLKCharacters as $k => $v) {
            $pValue = str_replace($k, $v, $pValue);
        }
        return $pValue;
    }
    /**
     * Retrieve any leading numeric part of a string, or return the full string if no leading numeric
     *	(handles basic integer or float, but not exponent or non decimal)
     *
     * @param	string	$value
     * @return	mixed	string or only the leading numeric part of the string
     */
    public static function testStringAsNumeric($value)
    {
        if (is_numeric($value)) {
            return $value;
        }
        $v = floatval($value);
        return is_numeric(substr($value, 0, strlen($v))) ? $v : $value;
    }
}

?>