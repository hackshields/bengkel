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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @category	PHPExcel
 * @package		PHPExcel_Calculation
 * @copyright	Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license		http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version		##VERSION##, ##DATE##
 */
/** PHPExcel root directory */
if (!defined('PHPEXCEL_ROOT')) {
    /**
     * @ignore
     */
    define('PHPEXCEL_ROOT', dirname(__FILE__) . '/../../');
    require PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php';
}
/** EULER */
define('EULER', 2.718281828459045);
/**
 * PHPExcel_Calculation_Engineering
 *
 * @category	PHPExcel
 * @package		PHPExcel_Calculation
 * @copyright	Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Calculation_Engineering
{
    /**
     * Details of the Units of measure that can be used in CONVERTUOM()
     *
     * @var mixed[]
     */
    private static $_conversionUnits = array('g' => array('Group' => 'Mass', 'Unit Name' => 'Gram', 'AllowPrefix' => True), 'sg' => array('Group' => 'Mass', 'Unit Name' => 'Slug', 'AllowPrefix' => False), 'lbm' => array('Group' => 'Mass', 'Unit Name' => 'Pound mass (avoirdupois)', 'AllowPrefix' => False), 'u' => array('Group' => 'Mass', 'Unit Name' => 'U (atomic mass unit)', 'AllowPrefix' => True), 'ozm' => array('Group' => 'Mass', 'Unit Name' => 'Ounce mass (avoirdupois)', 'AllowPrefix' => False), 'm' => array('Group' => 'Distance', 'Unit Name' => 'Meter', 'AllowPrefix' => True), 'mi' => array('Group' => 'Distance', 'Unit Name' => 'Statute mile', 'AllowPrefix' => False), 'Nmi' => array('Group' => 'Distance', 'Unit Name' => 'Nautical mile', 'AllowPrefix' => False), 'in' => array('Group' => 'Distance', 'Unit Name' => 'Inch', 'AllowPrefix' => False), 'ft' => array('Group' => 'Distance', 'Unit Name' => 'Foot', 'AllowPrefix' => False), 'yd' => array('Group' => 'Distance', 'Unit Name' => 'Yard', 'AllowPrefix' => False), 'ang' => array('Group' => 'Distance', 'Unit Name' => 'Angstrom', 'AllowPrefix' => True), 'Pica' => array('Group' => 'Distance', 'Unit Name' => 'Pica (1/72 in)', 'AllowPrefix' => False), 'yr' => array('Group' => 'Time', 'Unit Name' => 'Year', 'AllowPrefix' => False), 'day' => array('Group' => 'Time', 'Unit Name' => 'Day', 'AllowPrefix' => False), 'hr' => array('Group' => 'Time', 'Unit Name' => 'Hour', 'AllowPrefix' => False), 'mn' => array('Group' => 'Time', 'Unit Name' => 'Minute', 'AllowPrefix' => False), 'sec' => array('Group' => 'Time', 'Unit Name' => 'Second', 'AllowPrefix' => True), 'Pa' => array('Group' => 'Pressure', 'Unit Name' => 'Pascal', 'AllowPrefix' => True), 'p' => array('Group' => 'Pressure', 'Unit Name' => 'Pascal', 'AllowPrefix' => True), 'atm' => array('Group' => 'Pressure', 'Unit Name' => 'Atmosphere', 'AllowPrefix' => True), 'at' => array('Group' => 'Pressure', 'Unit Name' => 'Atmosphere', 'AllowPrefix' => True), 'mmHg' => array('Group' => 'Pressure', 'Unit Name' => 'mm of Mercury', 'AllowPrefix' => True), 'N' => array('Group' => 'Force', 'Unit Name' => 'Newton', 'AllowPrefix' => True), 'dyn' => array('Group' => 'Force', 'Unit Name' => 'Dyne', 'AllowPrefix' => True), 'dy' => array('Group' => 'Force', 'Unit Name' => 'Dyne', 'AllowPrefix' => True), 'lbf' => array('Group' => 'Force', 'Unit Name' => 'Pound force', 'AllowPrefix' => False), 'J' => array('Group' => 'Energy', 'Unit Name' => 'Joule', 'AllowPrefix' => True), 'e' => array('Group' => 'Energy', 'Unit Name' => 'Erg', 'AllowPrefix' => True), 'c' => array('Group' => 'Energy', 'Unit Name' => 'Thermodynamic calorie', 'AllowPrefix' => True), 'cal' => array('Group' => 'Energy', 'Unit Name' => 'IT calorie', 'AllowPrefix' => True), 'eV' => array('Group' => 'Energy', 'Unit Name' => 'Electron volt', 'AllowPrefix' => True), 'ev' => array('Group' => 'Energy', 'Unit Name' => 'Electron volt', 'AllowPrefix' => True), 'HPh' => array('Group' => 'Energy', 'Unit Name' => 'Horsepower-hour', 'AllowPrefix' => False), 'hh' => array('Group' => 'Energy', 'Unit Name' => 'Horsepower-hour', 'AllowPrefix' => False), 'Wh' => array('Group' => 'Energy', 'Unit Name' => 'Watt-hour', 'AllowPrefix' => True), 'wh' => array('Group' => 'Energy', 'Unit Name' => 'Watt-hour', 'AllowPrefix' => True), 'flb' => array('Group' => 'Energy', 'Unit Name' => 'Foot-pound', 'AllowPrefix' => False), 'BTU' => array('Group' => 'Energy', 'Unit Name' => 'BTU', 'AllowPrefix' => False), 'btu' => array('Group' => 'Energy', 'Unit Name' => 'BTU', 'AllowPrefix' => False), 'HP' => array('Group' => 'Power', 'Unit Name' => 'Horsepower', 'AllowPrefix' => False), 'h' => array('Group' => 'Power', 'Unit Name' => 'Horsepower', 'AllowPrefix' => False), 'W' => array('Group' => 'Power', 'Unit Name' => 'Watt', 'AllowPrefix' => True), 'w' => array('Group' => 'Power', 'Unit Name' => 'Watt', 'AllowPrefix' => True), 'T' => array('Group' => 'Magnetism', 'Unit Name' => 'Tesla', 'AllowPrefix' => True), 'ga' => array('Group' => 'Magnetism', 'Unit Name' => 'Gauss', 'AllowPrefix' => True), 'C' => array('Group' => 'Temperature', 'Unit Name' => 'Celsius', 'AllowPrefix' => False), 'cel' => array('Group' => 'Temperature', 'Unit Name' => 'Celsius', 'AllowPrefix' => False), 'F' => array('Group' => 'Temperature', 'Unit Name' => 'Fahrenheit', 'AllowPrefix' => False), 'fah' => array('Group' => 'Temperature', 'Unit Name' => 'Fahrenheit', 'AllowPrefix' => False), 'K' => array('Group' => 'Temperature', 'Unit Name' => 'Kelvin', 'AllowPrefix' => False), 'kel' => array('Group' => 'Temperature', 'Unit Name' => 'Kelvin', 'AllowPrefix' => False), 'tsp' => array('Group' => 'Liquid', 'Unit Name' => 'Teaspoon', 'AllowPrefix' => False), 'tbs' => array('Group' => 'Liquid', 'Unit Name' => 'Tablespoon', 'AllowPrefix' => False), 'oz' => array('Group' => 'Liquid', 'Unit Name' => 'Fluid Ounce', 'AllowPrefix' => False), 'cup' => array('Group' => 'Liquid', 'Unit Name' => 'Cup', 'AllowPrefix' => False), 'pt' => array('Group' => 'Liquid', 'Unit Name' => 'U.S. Pint', 'AllowPrefix' => False), 'us_pt' => array('Group' => 'Liquid', 'Unit Name' => 'U.S. Pint', 'AllowPrefix' => False), 'uk_pt' => array('Group' => 'Liquid', 'Unit Name' => 'U.K. Pint', 'AllowPrefix' => False), 'qt' => array('Group' => 'Liquid', 'Unit Name' => 'Quart', 'AllowPrefix' => False), 'gal' => array('Group' => 'Liquid', 'Unit Name' => 'Gallon', 'AllowPrefix' => False), 'l' => array('Group' => 'Liquid', 'Unit Name' => 'Litre', 'AllowPrefix' => True), 'lt' => array('Group' => 'Liquid', 'Unit Name' => 'Litre', 'AllowPrefix' => True));
    /**
     * Details of the Multiplier prefixes that can be used with Units of Measure in CONVERTUOM()
     *
     * @var mixed[]
     */
    private static $_conversionMultipliers = array('Y' => array('multiplier' => 1.0E+24, 'name' => 'yotta'), 'Z' => array('multiplier' => 1.0E+21, 'name' => 'zetta'), 'E' => array('multiplier' => 1.0E+18, 'name' => 'exa'), 'P' => array('multiplier' => 1000000000000000.0, 'name' => 'peta'), 'T' => array('multiplier' => 1000000000000.0, 'name' => 'tera'), 'G' => array('multiplier' => 1000000000.0, 'name' => 'giga'), 'M' => array('multiplier' => 1000000.0, 'name' => 'mega'), 'k' => array('multiplier' => 1000.0, 'name' => 'kilo'), 'h' => array('multiplier' => 100.0, 'name' => 'hecto'), 'e' => array('multiplier' => 10.0, 'name' => 'deka'), 'd' => array('multiplier' => 0.1, 'name' => 'deci'), 'c' => array('multiplier' => 0.01, 'name' => 'centi'), 'm' => array('multiplier' => 0.001, 'name' => 'milli'), 'u' => array('multiplier' => 1.0E-6, 'name' => 'micro'), 'n' => array('multiplier' => 1.0E-9, 'name' => 'nano'), 'p' => array('multiplier' => 1.0E-12, 'name' => 'pico'), 'f' => array('multiplier' => 1.0E-15, 'name' => 'femto'), 'a' => array('multiplier' => 1.0E-18, 'name' => 'atto'), 'z' => array('multiplier' => 9.999999999999999E-22, 'name' => 'zepto'), 'y' => array('multiplier' => 9.999999999999999E-25, 'name' => 'yocto'));
    /**
     * Details of the Units of measure conversion factors, organised by group
     *
     * @var mixed[]
     */
    private static $_unitConversions = array('Mass' => array('g' => array('g' => 1.0, 'sg' => 6.85220500053478E-5, 'lbm' => 0.00220462291469134, 'u' => 6.02217E+23, 'ozm' => 0.0352739718003627), 'sg' => array('g' => 14593.8424189287, 'sg' => 1.0, 'lbm' => 32.1739194101647, 'u' => 8.788659999999999E+27, 'ozm' => 514.782785944229), 'lbm' => array('g' => 453.5923097488115, 'sg' => 0.0310810749306493, 'lbm' => 1.0, 'u' => 2.73161E+26, 'ozm' => 16.000002342941), 'u' => array('g' => 1.66053100460465E-24, 'sg' => 1.1378298853295E-28, 'lbm' => 3.66084470330684E-27, 'u' => 1.0, 'ozm' => 5.85735238300524E-26), 'ozm' => array('g' => 28.3495152079732, 'sg' => 0.00194256689870811, 'lbm' => 0.0624999908478882, 'u' => 1.707256E+25, 'ozm' => 1.0)), 'Distance' => array('m' => array('m' => 1.0, 'mi' => 0.000621371192237334, 'Nmi' => 0.000539956803455724, 'in' => 39.3700787401575, 'ft' => 3.28083989501312, 'yd' => 1.09361329797891, 'ang' => 10000000000.0, 'Pica' => 2834.64566929116), 'mi' => array('m' => 1609.344, 'mi' => 1.0, 'Nmi' => 0.868976241900648, 'in' => 63360.0, 'ft' => 5280.0, 'yd' => 1760.0, 'ang' => 16093440000000.0, 'Pica' => 4561919.99999971), 'Nmi' => array('m' => 1852.0, 'mi' => 1.15077944802354, 'Nmi' => 1.0, 'in' => 72913.3858267717, 'ft' => 6076.1154855643, 'yd' => 2025.37182785694, 'ang' => 18520000000000.0, 'Pica' => 5249763.77952723), 'in' => array('m' => 0.0254, 'mi' => 1.57828282828283E-5, 'Nmi' => 1.37149028077754E-5, 'in' => 1.0, 'ft' => 0.0833333333333333, 'yd' => 0.0277777777686643, 'ang' => 254000000.0, 'Pica' => 71.9999999999955), 'ft' => array('m' => 0.3048, 'mi' => 0.000189393939393939, 'Nmi' => 0.000164578833693305, 'in' => 12.0, 'ft' => 1.0, 'yd' => 0.333333333223972, 'ang' => 3048000000.0, 'Pica' => 863.999999999946), 'yd' => array('m' => 0.9144000003, 'mi' => 0.00056818181836823, 'Nmi' => 0.000493736501241901, 'in' => 36.000000011811, 'ft' => 3.0, 'yd' => 1.0, 'ang' => 9144000003.0, 'Pica' => 2592.00000085023), 'ang' => array('m' => 1.0E-10, 'mi' => 6.213711922373341E-14, 'Nmi' => 5.39956803455724E-14, 'in' => 3.93700787401575E-9, 'ft' => 3.28083989501312E-10, 'yd' => 1.09361329797891E-10, 'ang' => 1.0, 'Pica' => 2.83464566929116E-7), 'Pica' => array('m' => 0.0003527777777778, 'mi' => 2.19205948372629E-7, 'Nmi' => 1.90484761219114E-7, 'in' => 0.0138888888888898, 'ft' => 0.00115740740740748, 'yd' => 0.000385802469009251, 'ang' => 3527777.777778, 'Pica' => 1.0)), 'Time' => array('yr' => array('yr' => 1.0, 'day' => 365.25, 'hr' => 8766.0, 'mn' => 525960.0, 'sec' => 31557600.0), 'day' => array('yr' => 0.0027378507871321, 'day' => 1.0, 'hr' => 24.0, 'mn' => 1440.0, 'sec' => 86400.0), 'hr' => array('yr' => 0.000114077116130504, 'day' => 0.0416666666666667, 'hr' => 1.0, 'mn' => 60.0, 'sec' => 3600.0), 'mn' => array('yr' => 1.90128526884174E-6, 'day' => 0.000694444444444444, 'hr' => 0.0166666666666667, 'mn' => 1.0, 'sec' => 60.0), 'sec' => array('yr' => 3.16880878140289E-8, 'day' => 1.15740740740741E-5, 'hr' => 0.000277777777777778, 'mn' => 0.0166666666666667, 'sec' => 1.0)), 'Pressure' => array('Pa' => array('Pa' => 1.0, 'p' => 1.0, 'atm' => 9.86923299998193E-6, 'at' => 9.86923299998193E-6, 'mmHg' => 0.00750061707998627), 'p' => array('Pa' => 1.0, 'p' => 1.0, 'atm' => 9.86923299998193E-6, 'at' => 9.86923299998193E-6, 'mmHg' => 0.00750061707998627), 'atm' => array('Pa' => 101324.996583, 'p' => 101324.996583, 'atm' => 1.0, 'at' => 1.0, 'mmHg' => 760.0), 'at' => array('Pa' => 101324.996583, 'p' => 101324.996583, 'atm' => 1.0, 'at' => 1.0, 'mmHg' => 760.0), 'mmHg' => array('Pa' => 133.322363925, 'p' => 133.322363925, 'atm' => 0.00131578947368421, 'at' => 0.00131578947368421, 'mmHg' => 1.0)), 'Force' => array('N' => array('N' => 1.0, 'dyn' => 100000.0, 'dy' => 100000.0, 'lbf' => 0.224808923655339), 'dyn' => array('N' => 1.0E-5, 'dyn' => 1.0, 'dy' => 1.0, 'lbf' => 2.24808923655339E-6), 'dy' => array('N' => 1.0E-5, 'dyn' => 1.0, 'dy' => 1.0, 'lbf' => 2.24808923655339E-6), 'lbf' => array('N' => 4.448222, 'dyn' => 444822.2, 'dy' => 444822.2, 'lbf' => 1.0)), 'Energy' => array('J' => array('J' => 1.0, 'e' => 9999995.193432311, 'c' => 0.239006249473467, 'cal' => 0.238846190642017, 'eV' => 6.241457E+18, 'ev' => 6.241457E+18, 'HPh' => 3.72506430801E-7, 'hh' => 3.72506430801E-7, 'Wh' => 0.000277777916238711, 'wh' => 0.000277777916238711, 'flb' => 23.7304222192651, 'BTU' => 0.000947815067349015, 'btu' => 0.000947815067349015), 'e' => array('J' => 1.000000480657E-7, 'e' => 1.0, 'c' => 2.39006364353494E-8, 'cal' => 2.38846305445111E-8, 'eV' => 624146000000.0, 'ev' => 624146000000.0, 'HPh' => 3.72506609848824E-14, 'hh' => 3.72506609848824E-14, 'Wh' => 2.77778049754611E-11, 'wh' => 2.77778049754611E-11, 'flb' => 2.37304336254586E-6, 'BTU' => 9.47815522922962E-11, 'btu' => 9.47815522922962E-11), 'c' => array('J' => 4.18399101363672, 'e' => 41839890.0257312, 'c' => 1.0, 'cal' => 0.999330315287563, 'eV' => 2.61142E+19, 'ev' => 2.61142E+19, 'HPh' => 1.55856355899327E-6, 'hh' => 1.55856355899327E-6, 'Wh' => 0.0011622203053295, 'wh' => 0.0011622203053295, 'flb' => 99.28787331521021, 'BTU' => 0.00396564972437776, 'btu' => 0.00396564972437776), 'cal' => array('J' => 4.18679484613929, 'e' => 41867928.3372801, 'c' => 1.00067013349059, 'cal' => 1.0, 'eV' => 2.61317E+19, 'ev' => 2.61317E+19, 'HPh' => 1.55960800463137E-6, 'hh' => 1.55960800463137E-6, 'Wh' => 0.00116299914807955, 'wh' => 0.00116299914807955, 'flb' => 99.3544094443283, 'BTU' => 0.00396830723907002, 'btu' => 0.00396830723907002), 'eV' => array('J' => 1.60219000146921E-19, 'e' => 1.60218923136574E-12, 'c' => 3.82933423195043E-20, 'cal' => 3.82676978535648E-20, 'eV' => 1.0, 'ev' => 1.0, 'HPh' => 5.968260789123441E-26, 'hh' => 5.968260789123441E-26, 'Wh' => 4.45053000026614E-23, 'wh' => 4.45053000026614E-23, 'flb' => 3.80206452103492E-18, 'BTU' => 1.51857982414846E-22, 'btu' => 1.51857982414846E-22), 'ev' => array('J' => 1.60219000146921E-19, 'e' => 1.60218923136574E-12, 'c' => 3.82933423195043E-20, 'cal' => 3.82676978535648E-20, 'eV' => 1.0, 'ev' => 1.0, 'HPh' => 5.968260789123441E-26, 'hh' => 5.968260789123441E-26, 'Wh' => 4.45053000026614E-23, 'wh' => 4.45053000026614E-23, 'flb' => 3.80206452103492E-18, 'BTU' => 1.51857982414846E-22, 'btu' => 1.51857982414846E-22), 'HPh' => array('J' => 2684517.4131617, 'e' => 26845161228302.4, 'c' => 641616.438565991, 'cal' => 641186.7578458349, 'eV' => 1.67553E+25, 'ev' => 1.67553E+25, 'HPh' => 1.0, 'hh' => 1.0, 'Wh' => 745.6996531345929, 'wh' => 745.6996531345929, 'flb' => 63704731.6692964, 'BTU' => 2544.42605275546, 'btu' => 2544.42605275546), 'hh' => array('J' => 2684517.4131617, 'e' => 26845161228302.4, 'c' => 641616.438565991, 'cal' => 641186.7578458349, 'eV' => 1.67553E+25, 'ev' => 1.67553E+25, 'HPh' => 1.0, 'hh' => 1.0, 'Wh' => 745.6996531345929, 'wh' => 745.6996531345929, 'flb' => 63704731.6692964, 'BTU' => 2544.42605275546, 'btu' => 2544.42605275546), 'Wh' => array('J' => 3599.9982055472, 'e' => 35999964751.8369, 'c' => 860.422069219046, 'cal' => 859.845857713046, 'eV' => 2.2469234E+22, 'ev' => 2.2469234E+22, 'HPh' => 0.00134102248243839, 'hh' => 0.00134102248243839, 'Wh' => 1.0, 'wh' => 1.0, 'flb' => 85429.4774062316, 'BTU' => 3.41213254164705, 'btu' => 3.41213254164705), 'wh' => array('J' => 3599.9982055472, 'e' => 35999964751.8369, 'c' => 860.422069219046, 'cal' => 859.845857713046, 'eV' => 2.2469234E+22, 'ev' => 2.2469234E+22, 'HPh' => 0.00134102248243839, 'hh' => 0.00134102248243839, 'Wh' => 1.0, 'wh' => 1.0, 'flb' => 85429.4774062316, 'BTU' => 3.41213254164705, 'btu' => 3.41213254164705), 'flb' => array('J' => 0.0421400003236424, 'e' => 421399.80068766, 'c' => 0.0100717234301644, 'cal' => 0.0100649785509554, 'eV' => 2.63015E+17, 'ev' => 2.63015E+17, 'HPh' => 1.5697421114513E-8, 'hh' => 1.5697421114513E-8, 'Wh' => 1.17055614802E-5, 'wh' => 1.17055614802E-5, 'flb' => 1.0, 'BTU' => 3.99409272448406E-5, 'btu' => 3.99409272448406E-5), 'BTU' => array('J' => 1055.05813786749, 'e' => 10550576307.4665, 'c' => 252.165488508168, 'cal' => 251.99661713551, 'eV' => 6.5851E+21, 'ev' => 6.5851E+21, 'HPh' => 0.000393015941224568, 'hh' => 0.000393015941224568, 'Wh' => 0.293071851047526, 'wh' => 0.293071851047526, 'flb' => 25036.9750774671, 'BTU' => 1.0, 'btu' => 1.0), 'btu' => array('J' => 1055.05813786749, 'e' => 10550576307.4665, 'c' => 252.165488508168, 'cal' => 251.99661713551, 'eV' => 6.5851E+21, 'ev' => 6.5851E+21, 'HPh' => 0.000393015941224568, 'hh' => 0.000393015941224568, 'Wh' => 0.293071851047526, 'wh' => 0.293071851047526, 'flb' => 25036.9750774671, 'BTU' => 1.0, 'btu' => 1.0)), 'Power' => array('HP' => array('HP' => 1.0, 'h' => 1.0, 'W' => 745.701, 'w' => 745.701), 'h' => array('HP' => 1.0, 'h' => 1.0, 'W' => 745.701, 'w' => 745.701), 'W' => array('HP' => 0.00134102006031908, 'h' => 0.00134102006031908, 'W' => 1.0, 'w' => 1.0), 'w' => array('HP' => 0.00134102006031908, 'h' => 0.00134102006031908, 'W' => 1.0, 'w' => 1.0)), 'Magnetism' => array('T' => array('T' => 1.0, 'ga' => 10000.0), 'ga' => array('T' => 0.0001, 'ga' => 1.0)), 'Liquid' => array('tsp' => array('tsp' => 1.0, 'tbs' => 0.333333333333333, 'oz' => 0.166666666666667, 'cup' => 0.0208333333333333, 'pt' => 0.0104166666666667, 'us_pt' => 0.0104166666666667, 'uk_pt' => 0.008675585168219599, 'qt' => 0.00520833333333333, 'gal' => 0.00130208333333333, 'l' => 0.0049299940840071, 'lt' => 0.0049299940840071), 'tbs' => array('tsp' => 3.0, 'tbs' => 1.0, 'oz' => 0.5, 'cup' => 0.0625, 'pt' => 0.03125, 'us_pt' => 0.03125, 'uk_pt' => 0.0260267555046588, 'qt' => 0.015625, 'gal' => 0.00390625, 'l' => 0.0147899822520213, 'lt' => 0.0147899822520213), 'oz' => array('tsp' => 6.0, 'tbs' => 2.0, 'oz' => 1.0, 'cup' => 0.125, 'pt' => 0.0625, 'us_pt' => 0.0625, 'uk_pt' => 0.0520535110093176, 'qt' => 0.03125, 'gal' => 0.0078125, 'l' => 0.0295799645040426, 'lt' => 0.0295799645040426), 'cup' => array('tsp' => 48.0, 'tbs' => 16.0, 'oz' => 8.0, 'cup' => 1.0, 'pt' => 0.5, 'us_pt' => 0.5, 'uk_pt' => 0.416428088074541, 'qt' => 0.25, 'gal' => 0.0625, 'l' => 0.236639716032341, 'lt' => 0.236639716032341), 'pt' => array('tsp' => 96.0, 'tbs' => 32.0, 'oz' => 16.0, 'cup' => 2.0, 'pt' => 1.0, 'us_pt' => 1.0, 'uk_pt' => 0.832856176149081, 'qt' => 0.5, 'gal' => 0.125, 'l' => 0.473279432064682, 'lt' => 0.473279432064682), 'us_pt' => array('tsp' => 96.0, 'tbs' => 32.0, 'oz' => 16.0, 'cup' => 2.0, 'pt' => 1.0, 'us_pt' => 1.0, 'uk_pt' => 0.832856176149081, 'qt' => 0.5, 'gal' => 0.125, 'l' => 0.473279432064682, 'lt' => 0.473279432064682), 'uk_pt' => array('tsp' => 115.266, 'tbs' => 38.422, 'oz' => 19.211, 'cup' => 2.401375, 'pt' => 1.2006875, 'us_pt' => 1.2006875, 'uk_pt' => 1.0, 'qt' => 0.60034375, 'gal' => 0.1500859375, 'l' => 0.568260698087162, 'lt' => 0.568260698087162), 'qt' => array('tsp' => 192.0, 'tbs' => 64.0, 'oz' => 32.0, 'cup' => 4.0, 'pt' => 2.0, 'us_pt' => 2.0, 'uk_pt' => 1.66571235229816, 'qt' => 1.0, 'gal' => 0.25, 'l' => 0.946558864129363, 'lt' => 0.946558864129363), 'gal' => array('tsp' => 768.0, 'tbs' => 256.0, 'oz' => 128.0, 'cup' => 16.0, 'pt' => 8.0, 'us_pt' => 8.0, 'uk_pt' => 6.66284940919265, 'qt' => 4.0, 'gal' => 1.0, 'l' => 3.78623545651745, 'lt' => 3.78623545651745), 'l' => array('tsp' => 202.84, 'tbs' => 67.6133333333333, 'oz' => 33.8066666666667, 'cup' => 4.22583333333333, 'pt' => 2.11291666666667, 'us_pt' => 2.11291666666667, 'uk_pt' => 1.75975569552166, 'qt' => 1.05645833333333, 'gal' => 0.264114583333333, 'l' => 1.0, 'lt' => 1.0), 'lt' => array('tsp' => 202.84, 'tbs' => 67.6133333333333, 'oz' => 33.8066666666667, 'cup' => 4.22583333333333, 'pt' => 2.11291666666667, 'us_pt' => 2.11291666666667, 'uk_pt' => 1.75975569552166, 'qt' => 1.05645833333333, 'gal' => 0.264114583333333, 'l' => 1.0, 'lt' => 1.0)));
    /**
     * _parseComplex
     *
     * Parses a complex number into its real and imaginary parts, and an I or J suffix
     *
     * @param	string		$complexNumber	The complex number
     * @return	string[]	Indexed on "real", "imaginary" and "suffix"
     */
    public static function _parseComplex($complexNumber)
    {
        $workString = (string) $complexNumber;
        $realNumber = $imaginary = 0;
        //	Extract the suffix, if there is one
        $suffix = substr($workString, -1);
        if (!is_numeric($suffix)) {
            $workString = substr($workString, 0, -1);
        } else {
            $suffix = '';
        }
        //	Split the input into its Real and Imaginary components
        $leadingSign = 0;
        if (strlen($workString) > 0) {
            $leadingSign = $workString[0] == '+' || $workString[0] == '-' ? 1 : 0;
        }
        $power = '';
        $realNumber = strtok($workString, '+-');
        if (strtoupper(substr($realNumber, -1)) == 'E') {
            $power = strtok('+-');
            ++$leadingSign;
        }
        $realNumber = substr($workString, 0, strlen($realNumber) + strlen($power) + $leadingSign);
        if ($suffix != '') {
            $imaginary = substr($workString, strlen($realNumber));
            if ($imaginary == '' && ($realNumber == '' || $realNumber == '+' || $realNumber == '-')) {
                $imaginary = $realNumber . '1';
                $realNumber = '0';
            } else {
                if ($imaginary == '') {
                    $imaginary = $realNumber;
                    $realNumber = '0';
                } elseif ($imaginary == '+' || $imaginary == '-') {
                    $imaginary .= '1';
                }
            }
        }
        return array('real' => $realNumber, 'imaginary' => $imaginary, 'suffix' => $suffix);
    }
    //	function _parseComplex()
    /**
     * Cleans the leading characters in a complex number string
     *
     * @param	string		$complexNumber	The complex number to clean
     * @return	string		The "cleaned" complex number
     */
    private static function _cleanComplex($complexNumber)
    {
        if ($complexNumber[0] == '+') {
            $complexNumber = substr($complexNumber, 1);
        }
        if ($complexNumber[0] == '0') {
            $complexNumber = substr($complexNumber, 1);
        }
        if ($complexNumber[0] == '.') {
            $complexNumber = '0' . $complexNumber;
        }
        if ($complexNumber[0] == '+') {
            $complexNumber = substr($complexNumber, 1);
        }
        return $complexNumber;
    }
    /**
     * Formats a number base string value with leading zeroes
     *
     * @param	string		$xVal		The "number" to pad
     * @param	integer		$places		The length that we want to pad this value
     * @return	string		The padded "number"
     */
    private static function _nbrConversionFormat($xVal, $places)
    {
        if (!is_null($places)) {
            if (strlen($xVal) <= $places) {
                return substr(str_pad($xVal, $places, '0', STR_PAD_LEFT), -10);
            } else {
                return PHPExcel_Calculation_Functions::NaN();
            }
        }
        return substr($xVal, -10);
    }
    //	function _nbrConversionFormat()
    /**
     *	BESSELI
     *
     *	Returns the modified Bessel function In(x), which is equivalent to the Bessel function evaluated
     *		for purely imaginary arguments
     *
     *	Excel Function:
     *		BESSELI(x,ord)
     *
     *	@access	public
     *	@category Engineering Functions
     *	@param	float		$x		The value at which to evaluate the function.
     *								If x is nonnumeric, BESSELI returns the #VALUE! error value.
     *	@param	integer		$ord	The order of the Bessel function.
     *								If ord is not an integer, it is truncated.
     *								If $ord is nonnumeric, BESSELI returns the #VALUE! error value.
     *								If $ord < 0, BESSELI returns the #NUM! error value.
     *	@return	float
     *
     */
    public static function BESSELI($x, $ord)
    {
        $x = is_null($x) ? 0.0 : PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $ord = is_null($ord) ? 0.0 : PHPExcel_Calculation_Functions::flattenSingleValue($ord);
        if (is_numeric($x) && is_numeric($ord)) {
            $ord = floor($ord);
            if ($ord < 0) {
                return PHPExcel_Calculation_Functions::NaN();
            }
            if (abs($x) <= 30) {
                $fResult = $fTerm = pow($x / 2, $ord) / PHPExcel_Calculation_MathTrig::FACT($ord);
                $ordK = 1;
                $fSqrX = $x * $x / 4;
                do {
                    $fTerm *= $fSqrX;
                    $fTerm /= $ordK * ($ordK + $ord);
                    $fResult += $fTerm;
                } while (abs($fTerm) > 1.0E-12 && ++$ordK < 100);
            } else {
                $f_2_PI = 2 * M_PI;
                $fXAbs = abs($x);
                $fResult = exp($fXAbs) / sqrt($f_2_PI * $fXAbs);
                if ($ord & 1 && $x < 0) {
                    $fResult = -$fResult;
                }
            }
            return is_nan($fResult) ? PHPExcel_Calculation_Functions::NaN() : $fResult;
        }
        return PHPExcel_Calculation_Functions::VALUE();
    }
    //	function BESSELI()
    /**
     *	BESSELJ
     *
     *	Returns the Bessel function
     *
     *	Excel Function:
     *		BESSELJ(x,ord)
     *
     *	@access	public
     *	@category Engineering Functions
     *	@param	float		$x		The value at which to evaluate the function.
     *								If x is nonnumeric, BESSELJ returns the #VALUE! error value.
     *	@param	integer		$ord	The order of the Bessel function. If n is not an integer, it is truncated.
     *								If $ord is nonnumeric, BESSELJ returns the #VALUE! error value.
     *								If $ord < 0, BESSELJ returns the #NUM! error value.
     *	@return	float
     *
     */
    public static function BESSELJ($x, $ord)
    {
        $x = is_null($x) ? 0.0 : PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $ord = is_null($ord) ? 0.0 : PHPExcel_Calculation_Functions::flattenSingleValue($ord);
        if (is_numeric($x) && is_numeric($ord)) {
            $ord = floor($ord);
            if ($ord < 0) {
                return PHPExcel_Calculation_Functions::NaN();
            }
            $fResult = 0;
            if (abs($x) <= 30) {
                $fResult = $fTerm = pow($x / 2, $ord) / PHPExcel_Calculation_MathTrig::FACT($ord);
                $ordK = 1;
                $fSqrX = $x * $x / -4;
                do {
                    $fTerm *= $fSqrX;
                    $fTerm /= $ordK * ($ordK + $ord);
                    $fResult += $fTerm;
                } while (abs($fTerm) > 1.0E-12 && ++$ordK < 100);
            } else {
                $f_PI_DIV_2 = M_PI / 2;
                $f_PI_DIV_4 = M_PI / 4;
                $fXAbs = abs($x);
                $fResult = sqrt(M_2DIVPI / $fXAbs) * cos($fXAbs - $ord * $f_PI_DIV_2 - $f_PI_DIV_4);
                if ($ord & 1 && $x < 0) {
                    $fResult = -$fResult;
                }
            }
            return is_nan($fResult) ? PHPExcel_Calculation_Functions::NaN() : $fResult;
        }
        return PHPExcel_Calculation_Functions::VALUE();
    }
    //	function BESSELJ()
    private static function _Besselk0($fNum)
    {
        if ($fNum <= 2) {
            $fNum2 = $fNum * 0.5;
            $y = $fNum2 * $fNum2;
            $fRet = -log($fNum2) * self::BESSELI($fNum, 0) + (-0.57721566 + $y * (0.4227842 + $y * (0.23069756 + $y * (0.0348859 + $y * (0.00262698 + $y * (0.0001075 + $y * 7.4E-6))))));
        } else {
            $y = 2 / $fNum;
            $fRet = exp(-$fNum) / sqrt($fNum) * (1.25331414 + $y * (-0.07832358 + $y * (0.02189568 + $y * (-0.01062446 + $y * (0.00587872 + $y * (-0.0025154 + $y * 0.00053208))))));
        }
        return $fRet;
    }
    //	function _Besselk0()
    private static function _Besselk1($fNum)
    {
        if ($fNum <= 2) {
            $fNum2 = $fNum * 0.5;
            $y = $fNum2 * $fNum2;
            $fRet = log($fNum2) * self::BESSELI($fNum, 1) + (1 + $y * (0.15443144 + $y * (-0.6727857900000001 + $y * (-0.18156897 + $y * (-0.01919402 + $y * (-0.00110404 + $y * -4.686E-5)))))) / $fNum;
        } else {
            $y = 2 / $fNum;
            $fRet = exp(-$fNum) / sqrt($fNum) * (1.25331414 + $y * (0.23498619 + $y * (-0.0365562 + $y * (0.01504268 + $y * (-0.00780353 + $y * (0.00325614 + $y * -0.00068245))))));
        }
        return $fRet;
    }
    //	function _Besselk1()
    /**
     *	BESSELK
     *
     *	Returns the modified Bessel function Kn(x), which is equivalent to the Bessel functions evaluated
     *		for purely imaginary arguments.
     *
     *	Excel Function:
     *		BESSELK(x,ord)
     *
     *	@access	public
     *	@category Engineering Functions
     *	@param	float		$x		The value at which to evaluate the function.
     *								If x is nonnumeric, BESSELK returns the #VALUE! error value.
     *	@param	integer		$ord	The order of the Bessel function. If n is not an integer, it is truncated.
     *								If $ord is nonnumeric, BESSELK returns the #VALUE! error value.
     *								If $ord < 0, BESSELK returns the #NUM! error value.
     *	@return	float
     *
     */
    public static function BESSELK($x, $ord)
    {
        $x = is_null($x) ? 0.0 : PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $ord = is_null($ord) ? 0.0 : PHPExcel_Calculation_Functions::flattenSingleValue($ord);
        if (is_numeric($x) && is_numeric($ord)) {
            if ($ord < 0 || $x == 0.0) {
                return PHPExcel_Calculation_Functions::NaN();
            }
            switch (floor($ord)) {
                case 0:
                    return self::_Besselk0($x);
                    break;
                case 1:
                    return self::_Besselk1($x);
                    break;
                default:
                    $fTox = 2 / $x;
                    $fBkm = self::_Besselk0($x);
                    $fBk = self::_Besselk1($x);
                    for ($n = 1; $n < $ord; ++$n) {
                        $fBkp = $fBkm + $n * $fTox * $fBk;
                        $fBkm = $fBk;
                        $fBk = $fBkp;
                    }
            }
            return is_nan($fBk) ? PHPExcel_Calculation_Functions::NaN() : $fBk;
        }
        return PHPExcel_Calculation_Functions::VALUE();
    }
    //	function BESSELK()
    private static function _Bessely0($fNum)
    {
        if ($fNum < 8.0) {
            $y = $fNum * $fNum;
            $f1 = -2957821389.0 + $y * (7062834065.0 + $y * (-512359803.6 + $y * (10879881.29 + $y * (-86327.92757 + $y * 228.4622733))));
            $f2 = 40076544269.0 + $y * (745249964.8 + $y * (7189466.438 + $y * (47447.2647 + $y * (226.1030244 + $y))));
            $fRet = $f1 / $f2 + 0.636619772 * self::BESSELJ($fNum, 0) * log($fNum);
        } else {
            $z = 8.0 / $fNum;
            $y = $z * $z;
            $xx = $fNum - 0.785398164;
            $f1 = 1 + $y * (-0.001098628627 + $y * (2.734510407E-5 + $y * (-2.073370639E-6 + $y * 2.093887211E-7)));
            $f2 = -0.01562499995 + $y * (0.0001430488765 + $y * (-6.911147651E-6 + $y * (7.621095161000001E-7 + $y * -9.34945152E-8)));
            $fRet = sqrt(0.636619772 / $fNum) * (sin($xx) * $f1 + $z * cos($xx) * $f2);
        }
        return $fRet;
    }
    //	function _Bessely0()
    private static function _Bessely1($fNum)
    {
        if ($fNum < 8.0) {
            $y = $fNum * $fNum;
            $f1 = $fNum * (-4900604943000.0 + $y * (1275274390000.0 + $y * (-51534381390.0 + $y * (734926455.1 + $y * (-4237922.726 + $y * 8511.937935)))));
            $f2 = 24995805700000.0 + $y * (424441966400.0 + $y * (3733650367.0 + $y * (22459040.02 + $y * (102042.605 + $y * (354.9632885 + $y)))));
            $fRet = $f1 / $f2 + 0.636619772 * (self::BESSELJ($fNum, 1) * log($fNum) - 1 / $fNum);
        } else {
            $fRet = sqrt(0.636619772 / $fNum) * sin($fNum - 2.356194491);
        }
        return $fRet;
    }
    //	function _Bessely1()
    /**
     *	BESSELY
     *
     *	Returns the Bessel function, which is also called the Weber function or the Neumann function.
     *
     *	Excel Function:
     *		BESSELY(x,ord)
     *
     *	@access	public
     *	@category Engineering Functions
     *	@param	float		$x		The value at which to evaluate the function.
     *								If x is nonnumeric, BESSELK returns the #VALUE! error value.
     *	@param	integer		$ord	The order of the Bessel function. If n is not an integer, it is truncated.
     *								If $ord is nonnumeric, BESSELK returns the #VALUE! error value.
     *								If $ord < 0, BESSELK returns the #NUM! error value.
     *
     *	@return	float
     */
    public static function BESSELY($x, $ord)
    {
        $x = is_null($x) ? 0.0 : PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $ord = is_null($ord) ? 0.0 : PHPExcel_Calculation_Functions::flattenSingleValue($ord);
        if (is_numeric($x) && is_numeric($ord)) {
            if ($ord < 0 || $x == 0.0) {
                return PHPExcel_Calculation_Functions::NaN();
            }
            switch (floor($ord)) {
                case 0:
                    return self::_Bessely0($x);
                    break;
                case 1:
                    return self::_Bessely1($x);
                    break;
                default:
                    $fTox = 2 / $x;
                    $fBym = self::_Bessely0($x);
                    $fBy = self::_Bessely1($x);
                    for ($n = 1; $n < $ord; ++$n) {
                        $fByp = $n * $fTox * $fBy - $fBym;
                        $fBym = $fBy;
                        $fBy = $fByp;
                    }
            }
            return is_nan($fBy) ? PHPExcel_Calculation_Functions::NaN() : $fBy;
        }
        return PHPExcel_Calculation_Functions::VALUE();
    }
    //	function BESSELY()
    /**
     * BINTODEC
     *
     * Return a binary value as decimal.
     *
     * Excel Function:
     *		BIN2DEC(x)
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$x		The binary number (as a string) that you want to convert. The number
     *								cannot contain more than 10 characters (10 bits). The most significant
     *								bit of number is the sign bit. The remaining 9 bits are magnitude bits.
     *								Negative numbers are represented using two's-complement notation.
     *								If number is not a valid binary number, or if number contains more than
     *								10 characters (10 bits), BIN2DEC returns the #NUM! error value.
     * @return	string
     */
    public static function BINTODEC($x)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        if (is_bool($x)) {
            if (PHPExcel_Calculation_Functions::getCompatibilityMode() == PHPExcel_Calculation_Functions::COMPATIBILITY_OPENOFFICE) {
                $x = (int) $x;
            } else {
                return PHPExcel_Calculation_Functions::VALUE();
            }
        }
        if (PHPExcel_Calculation_Functions::getCompatibilityMode() == PHPExcel_Calculation_Functions::COMPATIBILITY_GNUMERIC) {
            $x = floor($x);
        }
        $x = (string) $x;
        if (strlen($x) > preg_match_all('/[01]/', $x, $out)) {
            return PHPExcel_Calculation_Functions::NaN();
        }
        if (strlen($x) > 10) {
            return PHPExcel_Calculation_Functions::NaN();
        } elseif (strlen($x) == 10) {
            //	Two's Complement
            $x = substr($x, -9);
            return '-' . (512 - bindec($x));
        }
        return bindec($x);
    }
    //	function BINTODEC()
    /**
     * BINTOHEX
     *
     * Return a binary value as hex.
     *
     * Excel Function:
     *		BIN2HEX(x[,places])
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$x		The binary number (as a string) that you want to convert. The number
     *								cannot contain more than 10 characters (10 bits). The most significant
     *								bit of number is the sign bit. The remaining 9 bits are magnitude bits.
     *								Negative numbers are represented using two's-complement notation.
     *								If number is not a valid binary number, or if number contains more than
     *								10 characters (10 bits), BIN2HEX returns the #NUM! error value.
     * @param	integer		$places	The number of characters to use. If places is omitted, BIN2HEX uses the
     *								minimum number of characters necessary. Places is useful for padding the
     *								return value with leading 0s (zeros).
     *								If places is not an integer, it is truncated.
     *								If places is nonnumeric, BIN2HEX returns the #VALUE! error value.
     *								If places is negative, BIN2HEX returns the #NUM! error value.
     * @return	string
     */
    public static function BINTOHEX($x, $places = NULL)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $places = PHPExcel_Calculation_Functions::flattenSingleValue($places);
        if (is_bool($x)) {
            if (PHPExcel_Calculation_Functions::getCompatibilityMode() == PHPExcel_Calculation_Functions::COMPATIBILITY_OPENOFFICE) {
                $x = (int) $x;
            } else {
                return PHPExcel_Calculation_Functions::VALUE();
            }
        }
        if (PHPExcel_Calculation_Functions::getCompatibilityMode() == PHPExcel_Calculation_Functions::COMPATIBILITY_GNUMERIC) {
            $x = floor($x);
        }
        $x = (string) $x;
        if (strlen($x) > preg_match_all('/[01]/', $x, $out)) {
            return PHPExcel_Calculation_Functions::NaN();
        }
        if (strlen($x) > 10) {
            return PHPExcel_Calculation_Functions::NaN();
        } elseif (strlen($x) == 10) {
            //	Two's Complement
            return str_repeat('F', 8) . substr(strtoupper(dechex(bindec(substr($x, -9)))), -2);
        }
        $hexVal = (string) strtoupper(dechex(bindec($x)));
        return self::_nbrConversionFormat($hexVal, $places);
    }
    //	function BINTOHEX()
    /**
     * BINTOOCT
     *
     * Return a binary value as octal.
     *
     * Excel Function:
     *		BIN2OCT(x[,places])
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$x		The binary number (as a string) that you want to convert. The number
     *								cannot contain more than 10 characters (10 bits). The most significant
     *								bit of number is the sign bit. The remaining 9 bits are magnitude bits.
     *								Negative numbers are represented using two's-complement notation.
     *								If number is not a valid binary number, or if number contains more than
     *								10 characters (10 bits), BIN2OCT returns the #NUM! error value.
     * @param	integer		$places	The number of characters to use. If places is omitted, BIN2OCT uses the
     *								minimum number of characters necessary. Places is useful for padding the
     *								return value with leading 0s (zeros).
     *								If places is not an integer, it is truncated.
     *								If places is nonnumeric, BIN2OCT returns the #VALUE! error value.
     *								If places is negative, BIN2OCT returns the #NUM! error value.
     * @return	string
     */
    public static function BINTOOCT($x, $places = NULL)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $places = PHPExcel_Calculation_Functions::flattenSingleValue($places);
        if (is_bool($x)) {
            if (PHPExcel_Calculation_Functions::getCompatibilityMode() == PHPExcel_Calculation_Functions::COMPATIBILITY_OPENOFFICE) {
                $x = (int) $x;
            } else {
                return PHPExcel_Calculation_Functions::VALUE();
            }
        }
        if (PHPExcel_Calculation_Functions::getCompatibilityMode() == PHPExcel_Calculation_Functions::COMPATIBILITY_GNUMERIC) {
            $x = floor($x);
        }
        $x = (string) $x;
        if (strlen($x) > preg_match_all('/[01]/', $x, $out)) {
            return PHPExcel_Calculation_Functions::NaN();
        }
        if (strlen($x) > 10) {
            return PHPExcel_Calculation_Functions::NaN();
        } elseif (strlen($x) == 10) {
            //	Two's Complement
            return str_repeat('7', 7) . substr(strtoupper(decoct(bindec(substr($x, -9)))), -3);
        }
        $octVal = (string) decoct(bindec($x));
        return self::_nbrConversionFormat($octVal, $places);
    }
    //	function BINTOOCT()
    /**
     * DECTOBIN
     *
     * Return a decimal value as binary.
     *
     * Excel Function:
     *		DEC2BIN(x[,places])
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$x		The decimal integer you want to convert. If number is negative,
     *								valid place values are ignored and DEC2BIN returns a 10-character
     *								(10-bit) binary number in which the most significant bit is the sign
     *								bit. The remaining 9 bits are magnitude bits. Negative numbers are
     *								represented using two's-complement notation.
     *								If number < -512 or if number > 511, DEC2BIN returns the #NUM! error
     *								value.
     *								If number is nonnumeric, DEC2BIN returns the #VALUE! error value.
     *								If DEC2BIN requires more than places characters, it returns the #NUM!
     *								error value.
     * @param	integer		$places	The number of characters to use. If places is omitted, DEC2BIN uses
     *								the minimum number of characters necessary. Places is useful for
     *								padding the return value with leading 0s (zeros).
     *								If places is not an integer, it is truncated.
     *								If places is nonnumeric, DEC2BIN returns the #VALUE! error value.
     *								If places is zero or negative, DEC2BIN returns the #NUM! error value.
     * @return	string
     */
    public static function DECTOBIN($x, $places = NULL)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $places = PHPExcel_Calculation_Functions::flattenSingleValue($places);
        if (is_bool($x)) {
            if (PHPExcel_Calculation_Functions::getCompatibilityMode() == PHPExcel_Calculation_Functions::COMPATIBILITY_OPENOFFICE) {
                $x = (int) $x;
            } else {
                return PHPExcel_Calculation_Functions::VALUE();
            }
        }
        $x = (string) $x;
        if (strlen($x) > preg_match_all('/[-0123456789.]/', $x, $out)) {
            return PHPExcel_Calculation_Functions::VALUE();
        }
        $x = (string) floor($x);
        $r = decbin($x);
        if (strlen($r) == 32) {
            //	Two's Complement
            $r = substr($r, -10);
        } elseif (strlen($r) > 11) {
            return PHPExcel_Calculation_Functions::NaN();
        }
        return self::_nbrConversionFormat($r, $places);
    }
    //	function DECTOBIN()
    /**
     * DECTOHEX
     *
     * Return a decimal value as hex.
     *
     * Excel Function:
     *		DEC2HEX(x[,places])
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$x		The decimal integer you want to convert. If number is negative,
     *								places is ignored and DEC2HEX returns a 10-character (40-bit)
     *								hexadecimal number in which the most significant bit is the sign
     *								bit. The remaining 39 bits are magnitude bits. Negative numbers
     *								are represented using two's-complement notation.
     *								If number < -549,755,813,888 or if number > 549,755,813,887,
     *								DEC2HEX returns the #NUM! error value.
     *								If number is nonnumeric, DEC2HEX returns the #VALUE! error value.
     *								If DEC2HEX requires more than places characters, it returns the
     *								#NUM! error value.
     * @param	integer		$places	The number of characters to use. If places is omitted, DEC2HEX uses
     *								the minimum number of characters necessary. Places is useful for
     *								padding the return value with leading 0s (zeros).
     *								If places is not an integer, it is truncated.
     *								If places is nonnumeric, DEC2HEX returns the #VALUE! error value.
     *								If places is zero or negative, DEC2HEX returns the #NUM! error value.
     * @return	string
     */
    public static function DECTOHEX($x, $places = null)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $places = PHPExcel_Calculation_Functions::flattenSingleValue($places);
        if (is_bool($x)) {
            if (PHPExcel_Calculation_Functions::getCompatibilityMode() == PHPExcel_Calculation_Functions::COMPATIBILITY_OPENOFFICE) {
                $x = (int) $x;
            } else {
                return PHPExcel_Calculation_Functions::VALUE();
            }
        }
        $x = (string) $x;
        if (strlen($x) > preg_match_all('/[-0123456789.]/', $x, $out)) {
            return PHPExcel_Calculation_Functions::VALUE();
        }
        $x = (string) floor($x);
        $r = strtoupper(dechex($x));
        if (strlen($r) == 8) {
            //	Two's Complement
            $r = 'FF' . $r;
        }
        return self::_nbrConversionFormat($r, $places);
    }
    //	function DECTOHEX()
    /**
     * DECTOOCT
     *
     * Return an decimal value as octal.
     *
     * Excel Function:
     *		DEC2OCT(x[,places])
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$x		The decimal integer you want to convert. If number is negative,
     *								places is ignored and DEC2OCT returns a 10-character (30-bit)
     *								octal number in which the most significant bit is the sign bit.
     *								The remaining 29 bits are magnitude bits. Negative numbers are
     *								represented using two's-complement notation.
     *								If number < -536,870,912 or if number > 536,870,911, DEC2OCT
     *								returns the #NUM! error value.
     *								If number is nonnumeric, DEC2OCT returns the #VALUE! error value.
     *								If DEC2OCT requires more than places characters, it returns the
     *								#NUM! error value.
     * @param	integer		$places	The number of characters to use. If places is omitted, DEC2OCT uses
     *								the minimum number of characters necessary. Places is useful for
     *								padding the return value with leading 0s (zeros).
     *								If places is not an integer, it is truncated.
     *								If places is nonnumeric, DEC2OCT returns the #VALUE! error value.
     *								If places is zero or negative, DEC2OCT returns the #NUM! error value.
     * @return	string
     */
    public static function DECTOOCT($x, $places = null)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $places = PHPExcel_Calculation_Functions::flattenSingleValue($places);
        if (is_bool($x)) {
            if (PHPExcel_Calculation_Functions::getCompatibilityMode() == PHPExcel_Calculation_Functions::COMPATIBILITY_OPENOFFICE) {
                $x = (int) $x;
            } else {
                return PHPExcel_Calculation_Functions::VALUE();
            }
        }
        $x = (string) $x;
        if (strlen($x) > preg_match_all('/[-0123456789.]/', $x, $out)) {
            return PHPExcel_Calculation_Functions::VALUE();
        }
        $x = (string) floor($x);
        $r = decoct($x);
        if (strlen($r) == 11) {
            //	Two's Complement
            $r = substr($r, -10);
        }
        return self::_nbrConversionFormat($r, $places);
    }
    //	function DECTOOCT()
    /**
     * HEXTOBIN
     *
     * Return a hex value as binary.
     *
     * Excel Function:
     *		HEX2BIN(x[,places])
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$x			the hexadecimal number you want to convert. Number cannot
     *									contain more than 10 characters. The most significant bit of
     *									number is the sign bit (40th bit from the right). The remaining
     *									9 bits are magnitude bits. Negative numbers are represented
     *									using two's-complement notation.
     *									If number is negative, HEX2BIN ignores places and returns a
     *									10-character binary number.
     *									If number is negative, it cannot be less than FFFFFFFE00, and
     *									if number is positive, it cannot be greater than 1FF.
     *									If number is not a valid hexadecimal number, HEX2BIN returns
     *									the #NUM! error value.
     *									If HEX2BIN requires more than places characters, it returns
     *									the #NUM! error value.
     * @param	integer		$places		The number of characters to use. If places is omitted,
     *									HEX2BIN uses the minimum number of characters necessary. Places
     *									is useful for padding the return value with leading 0s (zeros).
     *									If places is not an integer, it is truncated.
     *									If places is nonnumeric, HEX2BIN returns the #VALUE! error value.
     *									If places is negative, HEX2BIN returns the #NUM! error value.
     * @return	string
     */
    public static function HEXTOBIN($x, $places = null)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $places = PHPExcel_Calculation_Functions::flattenSingleValue($places);
        if (is_bool($x)) {
            return PHPExcel_Calculation_Functions::VALUE();
        }
        $x = (string) $x;
        if (strlen($x) > preg_match_all('/[0123456789ABCDEF]/', strtoupper($x), $out)) {
            return PHPExcel_Calculation_Functions::NaN();
        }
        $binVal = decbin(hexdec($x));
        return substr(self::_nbrConversionFormat($binVal, $places), -10);
    }
    //	function HEXTOBIN()
    /**
     * HEXTODEC
     *
     * Return a hex value as decimal.
     *
     * Excel Function:
     *		HEX2DEC(x)
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$x		The hexadecimal number you want to convert. This number cannot
     *								contain more than 10 characters (40 bits). The most significant
     *								bit of number is the sign bit. The remaining 39 bits are magnitude
     *								bits. Negative numbers are represented using two's-complement
     *								notation.
     *								If number is not a valid hexadecimal number, HEX2DEC returns the
     *								#NUM! error value.
     * @return	string
     */
    public static function HEXTODEC($x)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        if (is_bool($x)) {
            return PHPExcel_Calculation_Functions::VALUE();
        }
        $x = (string) $x;
        if (strlen($x) > preg_match_all('/[0123456789ABCDEF]/', strtoupper($x), $out)) {
            return PHPExcel_Calculation_Functions::NaN();
        }
        return hexdec($x);
    }
    //	function HEXTODEC()
    /**
     * HEXTOOCT
     *
     * Return a hex value as octal.
     *
     * Excel Function:
     *		HEX2OCT(x[,places])
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$x			The hexadecimal number you want to convert. Number cannot
     *									contain more than 10 characters. The most significant bit of
     *									number is the sign bit. The remaining 39 bits are magnitude
     *									bits. Negative numbers are represented using two's-complement
     *									notation.
     *									If number is negative, HEX2OCT ignores places and returns a
     *									10-character octal number.
     *									If number is negative, it cannot be less than FFE0000000, and
     *									if number is positive, it cannot be greater than 1FFFFFFF.
     *									If number is not a valid hexadecimal number, HEX2OCT returns
     *									the #NUM! error value.
     *									If HEX2OCT requires more than places characters, it returns
     *									the #NUM! error value.
     * @param	integer		$places		The number of characters to use. If places is omitted, HEX2OCT
     *									uses the minimum number of characters necessary. Places is
     *									useful for padding the return value with leading 0s (zeros).
     *									If places is not an integer, it is truncated.
     *									If places is nonnumeric, HEX2OCT returns the #VALUE! error
     *									value.
     *									If places is negative, HEX2OCT returns the #NUM! error value.
     * @return	string
     */
    public static function HEXTOOCT($x, $places = null)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $places = PHPExcel_Calculation_Functions::flattenSingleValue($places);
        if (is_bool($x)) {
            return PHPExcel_Calculation_Functions::VALUE();
        }
        $x = (string) $x;
        if (strlen($x) > preg_match_all('/[0123456789ABCDEF]/', strtoupper($x), $out)) {
            return PHPExcel_Calculation_Functions::NaN();
        }
        $octVal = decoct(hexdec($x));
        return self::_nbrConversionFormat($octVal, $places);
    }
    //	function HEXTOOCT()
    /**
     * OCTTOBIN
     *
     * Return an octal value as binary.
     *
     * Excel Function:
     *		OCT2BIN(x[,places])
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$x			The octal number you want to convert. Number may not
     *									contain more than 10 characters. The most significant
     *									bit of number is the sign bit. The remaining 29 bits
     *									are magnitude bits. Negative numbers are represented
     *									using two's-complement notation.
     *									If number is negative, OCT2BIN ignores places and returns
     *									a 10-character binary number.
     *									If number is negative, it cannot be less than 7777777000,
     *									and if number is positive, it cannot be greater than 777.
     *									If number is not a valid octal number, OCT2BIN returns
     *									the #NUM! error value.
     *									If OCT2BIN requires more than places characters, it
     *									returns the #NUM! error value.
     * @param	integer		$places		The number of characters to use. If places is omitted,
     *									OCT2BIN uses the minimum number of characters necessary.
     *									Places is useful for padding the return value with
     *									leading 0s (zeros).
     *									If places is not an integer, it is truncated.
     *									If places is nonnumeric, OCT2BIN returns the #VALUE!
     *									error value.
     *									If places is negative, OCT2BIN returns the #NUM! error
     *									value.
     * @return	string
     */
    public static function OCTTOBIN($x, $places = null)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $places = PHPExcel_Calculation_Functions::flattenSingleValue($places);
        if (is_bool($x)) {
            return PHPExcel_Calculation_Functions::VALUE();
        }
        $x = (string) $x;
        if (preg_match_all('/[01234567]/', $x, $out) != strlen($x)) {
            return PHPExcel_Calculation_Functions::NaN();
        }
        $r = decbin(octdec($x));
        return self::_nbrConversionFormat($r, $places);
    }
    //	function OCTTOBIN()
    /**
     * OCTTODEC
     *
     * Return an octal value as decimal.
     *
     * Excel Function:
     *		OCT2DEC(x)
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$x		The octal number you want to convert. Number may not contain
     *								more than 10 octal characters (30 bits). The most significant
     *								bit of number is the sign bit. The remaining 29 bits are
     *								magnitude bits. Negative numbers are represented using
     *								two's-complement notation.
     *								If number is not a valid octal number, OCT2DEC returns the
     *								#NUM! error value.
     * @return	string
     */
    public static function OCTTODEC($x)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        if (is_bool($x)) {
            return PHPExcel_Calculation_Functions::VALUE();
        }
        $x = (string) $x;
        if (preg_match_all('/[01234567]/', $x, $out) != strlen($x)) {
            return PHPExcel_Calculation_Functions::NaN();
        }
        return octdec($x);
    }
    //	function OCTTODEC()
    /**
     * OCTTOHEX
     *
     * Return an octal value as hex.
     *
     * Excel Function:
     *		OCT2HEX(x[,places])
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$x			The octal number you want to convert. Number may not contain
     *									more than 10 octal characters (30 bits). The most significant
     *									bit of number is the sign bit. The remaining 29 bits are
     *									magnitude bits. Negative numbers are represented using
     *									two's-complement notation.
     *									If number is negative, OCT2HEX ignores places and returns a
     *									10-character hexadecimal number.
     *									If number is not a valid octal number, OCT2HEX returns the
     *									#NUM! error value.
     *									If OCT2HEX requires more than places characters, it returns
     *									the #NUM! error value.
     * @param	integer		$places		The number of characters to use. If places is omitted, OCT2HEX
     *									uses the minimum number of characters necessary. Places is useful
     *									for padding the return value with leading 0s (zeros).
     *									If places is not an integer, it is truncated.
     *									If places is nonnumeric, OCT2HEX returns the #VALUE! error value.
     *									If places is negative, OCT2HEX returns the #NUM! error value.
     * @return	string
     */
    public static function OCTTOHEX($x, $places = null)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        $places = PHPExcel_Calculation_Functions::flattenSingleValue($places);
        if (is_bool($x)) {
            return PHPExcel_Calculation_Functions::VALUE();
        }
        $x = (string) $x;
        if (preg_match_all('/[01234567]/', $x, $out) != strlen($x)) {
            return PHPExcel_Calculation_Functions::NaN();
        }
        $hexVal = strtoupper(dechex(octdec($x)));
        return self::_nbrConversionFormat($hexVal, $places);
    }
    //	function OCTTOHEX()
    /**
     * COMPLEX
     *
     * Converts real and imaginary coefficients into a complex number of the form x + yi or x + yj.
     *
     * Excel Function:
     *		COMPLEX(realNumber,imaginary[,places])
     *
     * @access	public
     * @category Engineering Functions
     * @param	float		$realNumber		The real coefficient of the complex number.
     * @param	float		$imaginary		The imaginary coefficient of the complex number.
     * @param	string		$suffix			The suffix for the imaginary component of the complex number.
     *										If omitted, the suffix is assumed to be "i".
     * @return	string
     */
    public static function COMPLEX($realNumber = 0.0, $imaginary = 0.0, $suffix = 'i')
    {
        $realNumber = is_null($realNumber) ? 0.0 : PHPExcel_Calculation_Functions::flattenSingleValue($realNumber);
        $imaginary = is_null($imaginary) ? 0.0 : PHPExcel_Calculation_Functions::flattenSingleValue($imaginary);
        $suffix = is_null($suffix) ? 'i' : PHPExcel_Calculation_Functions::flattenSingleValue($suffix);
        if (is_numeric($realNumber) && is_numeric($imaginary) && ($suffix == 'i' || $suffix == 'j' || $suffix == '')) {
            $realNumber = (double) $realNumber;
            $imaginary = (double) $imaginary;
            if ($suffix == '') {
                $suffix = 'i';
            }
            if ($realNumber == 0.0) {
                if ($imaginary == 0.0) {
                    return (string) '0';
                } elseif ($imaginary == 1.0) {
                    return (string) $suffix;
                } elseif ($imaginary == -1.0) {
                    return (string) '-' . $suffix;
                }
                return (string) $imaginary . $suffix;
            } elseif ($imaginary == 0.0) {
                return (string) $realNumber;
            } elseif ($imaginary == 1.0) {
                return (string) $realNumber . '+' . $suffix;
            } elseif ($imaginary == -1.0) {
                return (string) $realNumber . '-' . $suffix;
            }
            if ($imaginary > 0) {
                $imaginary = (string) '+' . $imaginary;
            }
            return (string) $realNumber . $imaginary . $suffix;
        }
        return PHPExcel_Calculation_Functions::VALUE();
    }
    //	function COMPLEX()
    /**
     * IMAGINARY
     *
     * Returns the imaginary coefficient of a complex number in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMAGINARY(complexNumber)
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$complexNumber	The complex number for which you want the imaginary
     * 										coefficient.
     * @return	float
     */
    public static function IMAGINARY($complexNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $parsedComplex = self::_parseComplex($complexNumber);
        return $parsedComplex['imaginary'];
    }
    //	function IMAGINARY()
    /**
     * IMREAL
     *
     * Returns the real coefficient of a complex number in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMREAL(complexNumber)
     *
     * @access	public
     * @category Engineering Functions
     * @param	string		$complexNumber	The complex number for which you want the real coefficient.
     * @return	float
     */
    public static function IMREAL($complexNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $parsedComplex = self::_parseComplex($complexNumber);
        return $parsedComplex['real'];
    }
    //	function IMREAL()
    /**
     * IMABS
     *
     * Returns the absolute value (modulus) of a complex number in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMABS(complexNumber)
     *
     * @param	string		$complexNumber	The complex number for which you want the absolute value.
     * @return	float
     */
    public static function IMABS($complexNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $parsedComplex = self::_parseComplex($complexNumber);
        return sqrt($parsedComplex['real'] * $parsedComplex['real'] + $parsedComplex['imaginary'] * $parsedComplex['imaginary']);
    }
    //	function IMABS()
    /**
     * IMARGUMENT
     *
     * Returns the argument theta of a complex number, i.e. the angle in radians from the real
     * axis to the representation of the number in polar coordinates.
     *
     * Excel Function:
     *		IMARGUMENT(complexNumber)
     *
     * @param	string		$complexNumber	The complex number for which you want the argument theta.
     * @return	float
     */
    public static function IMARGUMENT($complexNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $parsedComplex = self::_parseComplex($complexNumber);
        if ($parsedComplex['real'] == 0.0) {
            if ($parsedComplex['imaginary'] == 0.0) {
                return 0.0;
            } elseif ($parsedComplex['imaginary'] < 0.0) {
                return M_PI / -2;
            } else {
                return M_PI / 2;
            }
        } elseif ($parsedComplex['real'] > 0.0) {
            return atan($parsedComplex['imaginary'] / $parsedComplex['real']);
        } elseif ($parsedComplex['imaginary'] < 0.0) {
            return 0 - (M_PI - atan(abs($parsedComplex['imaginary']) / abs($parsedComplex['real'])));
        } else {
            return M_PI - atan($parsedComplex['imaginary'] / abs($parsedComplex['real']));
        }
    }
    //	function IMARGUMENT()
    /**
     * IMCONJUGATE
     *
     * Returns the complex conjugate of a complex number in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMCONJUGATE(complexNumber)
     *
     * @param	string		$complexNumber	The complex number for which you want the conjugate.
     * @return	string
     */
    public static function IMCONJUGATE($complexNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $parsedComplex = self::_parseComplex($complexNumber);
        if ($parsedComplex['imaginary'] == 0.0) {
            return $parsedComplex['real'];
        } else {
            return self::_cleanComplex(self::COMPLEX($parsedComplex['real'], 0 - $parsedComplex['imaginary'], $parsedComplex['suffix']));
        }
    }
    //	function IMCONJUGATE()
    /**
     * IMCOS
     *
     * Returns the cosine of a complex number in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMCOS(complexNumber)
     *
     * @param	string		$complexNumber	The complex number for which you want the cosine.
     * @return	string|float
     */
    public static function IMCOS($complexNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $parsedComplex = self::_parseComplex($complexNumber);
        if ($parsedComplex['imaginary'] == 0.0) {
            return cos($parsedComplex['real']);
        } else {
            return self::IMCONJUGATE(self::COMPLEX(cos($parsedComplex['real']) * cosh($parsedComplex['imaginary']), sin($parsedComplex['real']) * sinh($parsedComplex['imaginary']), $parsedComplex['suffix']));
        }
    }
    //	function IMCOS()
    /**
     * IMSIN
     *
     * Returns the sine of a complex number in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMSIN(complexNumber)
     *
     * @param	string		$complexNumber	The complex number for which you want the sine.
     * @return	string|float
     */
    public static function IMSIN($complexNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $parsedComplex = self::_parseComplex($complexNumber);
        if ($parsedComplex['imaginary'] == 0.0) {
            return sin($parsedComplex['real']);
        } else {
            return self::COMPLEX(sin($parsedComplex['real']) * cosh($parsedComplex['imaginary']), cos($parsedComplex['real']) * sinh($parsedComplex['imaginary']), $parsedComplex['suffix']);
        }
    }
    //	function IMSIN()
    /**
     * IMSQRT
     *
     * Returns the square root of a complex number in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMSQRT(complexNumber)
     *
     * @param	string		$complexNumber	The complex number for which you want the square root.
     * @return	string
     */
    public static function IMSQRT($complexNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $parsedComplex = self::_parseComplex($complexNumber);
        $theta = self::IMARGUMENT($complexNumber);
        $d1 = cos($theta / 2);
        $d2 = sin($theta / 2);
        $r = sqrt(sqrt($parsedComplex['real'] * $parsedComplex['real'] + $parsedComplex['imaginary'] * $parsedComplex['imaginary']));
        if ($parsedComplex['suffix'] == '') {
            return self::COMPLEX($d1 * $r, $d2 * $r);
        } else {
            return self::COMPLEX($d1 * $r, $d2 * $r, $parsedComplex['suffix']);
        }
    }
    //	function IMSQRT()
    /**
     * IMLN
     *
     * Returns the natural logarithm of a complex number in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMLN(complexNumber)
     *
     * @param	string		$complexNumber	The complex number for which you want the natural logarithm.
     * @return	string
     */
    public static function IMLN($complexNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $parsedComplex = self::_parseComplex($complexNumber);
        if ($parsedComplex['real'] == 0.0 && $parsedComplex['imaginary'] == 0.0) {
            return PHPExcel_Calculation_Functions::NaN();
        }
        $logR = log(sqrt($parsedComplex['real'] * $parsedComplex['real'] + $parsedComplex['imaginary'] * $parsedComplex['imaginary']));
        $t = self::IMARGUMENT($complexNumber);
        if ($parsedComplex['suffix'] == '') {
            return self::COMPLEX($logR, $t);
        } else {
            return self::COMPLEX($logR, $t, $parsedComplex['suffix']);
        }
    }
    //	function IMLN()
    /**
     * IMLOG10
     *
     * Returns the common logarithm (base 10) of a complex number in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMLOG10(complexNumber)
     *
     * @param	string		$complexNumber	The complex number for which you want the common logarithm.
     * @return	string
     */
    public static function IMLOG10($complexNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $parsedComplex = self::_parseComplex($complexNumber);
        if ($parsedComplex['real'] == 0.0 && $parsedComplex['imaginary'] == 0.0) {
            return PHPExcel_Calculation_Functions::NaN();
        } elseif ($parsedComplex['real'] > 0.0 && $parsedComplex['imaginary'] == 0.0) {
            return log10($parsedComplex['real']);
        }
        return self::IMPRODUCT(log10(EULER), self::IMLN($complexNumber));
    }
    //	function IMLOG10()
    /**
     * IMLOG2
     *
     * Returns the base-2 logarithm of a complex number in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMLOG2(complexNumber)
     *
     * @param	string		$complexNumber	The complex number for which you want the base-2 logarithm.
     * @return	string
     */
    public static function IMLOG2($complexNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $parsedComplex = self::_parseComplex($complexNumber);
        if ($parsedComplex['real'] == 0.0 && $parsedComplex['imaginary'] == 0.0) {
            return PHPExcel_Calculation_Functions::NaN();
        } elseif ($parsedComplex['real'] > 0.0 && $parsedComplex['imaginary'] == 0.0) {
            return log($parsedComplex['real'], 2);
        }
        return self::IMPRODUCT(log(EULER, 2), self::IMLN($complexNumber));
    }
    //	function IMLOG2()
    /**
     * IMEXP
     *
     * Returns the exponential of a complex number in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMEXP(complexNumber)
     *
     * @param	string		$complexNumber	The complex number for which you want the exponential.
     * @return	string
     */
    public static function IMEXP($complexNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $parsedComplex = self::_parseComplex($complexNumber);
        if ($parsedComplex['real'] == 0.0 && $parsedComplex['imaginary'] == 0.0) {
            return '1';
        }
        $e = exp($parsedComplex['real']);
        $eX = $e * cos($parsedComplex['imaginary']);
        $eY = $e * sin($parsedComplex['imaginary']);
        if ($parsedComplex['suffix'] == '') {
            return self::COMPLEX($eX, $eY);
        } else {
            return self::COMPLEX($eX, $eY, $parsedComplex['suffix']);
        }
    }
    //	function IMEXP()
    /**
     * IMPOWER
     *
     * Returns a complex number in x + yi or x + yj text format raised to a power.
     *
     * Excel Function:
     *		IMPOWER(complexNumber,realNumber)
     *
     * @param	string		$complexNumber	The complex number you want to raise to a power.
     * @param	float		$realNumber		The power to which you want to raise the complex number.
     * @return	string
     */
    public static function IMPOWER($complexNumber, $realNumber)
    {
        $complexNumber = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber);
        $realNumber = PHPExcel_Calculation_Functions::flattenSingleValue($realNumber);
        if (!is_numeric($realNumber)) {
            return PHPExcel_Calculation_Functions::VALUE();
        }
        $parsedComplex = self::_parseComplex($complexNumber);
        $r = sqrt($parsedComplex['real'] * $parsedComplex['real'] + $parsedComplex['imaginary'] * $parsedComplex['imaginary']);
        $rPower = pow($r, $realNumber);
        $theta = self::IMARGUMENT($complexNumber) * $realNumber;
        if ($theta == 0) {
            return 1;
        } elseif ($parsedComplex['imaginary'] == 0.0) {
            return self::COMPLEX($rPower * cos($theta), $rPower * sin($theta), $parsedComplex['suffix']);
        } else {
            return self::COMPLEX($rPower * cos($theta), $rPower * sin($theta), $parsedComplex['suffix']);
        }
    }
    //	function IMPOWER()
    /**
     * IMDIV
     *
     * Returns the quotient of two complex numbers in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMDIV(complexDividend,complexDivisor)
     *
     * @param	string		$complexDividend	The complex numerator or dividend.
     * @param	string		$complexDivisor		The complex denominator or divisor.
     * @return	string
     */
    public static function IMDIV($complexDividend, $complexDivisor)
    {
        $complexDividend = PHPExcel_Calculation_Functions::flattenSingleValue($complexDividend);
        $complexDivisor = PHPExcel_Calculation_Functions::flattenSingleValue($complexDivisor);
        $parsedComplexDividend = self::_parseComplex($complexDividend);
        $parsedComplexDivisor = self::_parseComplex($complexDivisor);
        if ($parsedComplexDividend['suffix'] != '' && $parsedComplexDivisor['suffix'] != '' && $parsedComplexDividend['suffix'] != $parsedComplexDivisor['suffix']) {
            return PHPExcel_Calculation_Functions::NaN();
        }
        if ($parsedComplexDividend['suffix'] != '' && $parsedComplexDivisor['suffix'] == '') {
            $parsedComplexDivisor['suffix'] = $parsedComplexDividend['suffix'];
        }
        $d1 = $parsedComplexDividend['real'] * $parsedComplexDivisor['real'] + $parsedComplexDividend['imaginary'] * $parsedComplexDivisor['imaginary'];
        $d2 = $parsedComplexDividend['imaginary'] * $parsedComplexDivisor['real'] - $parsedComplexDividend['real'] * $parsedComplexDivisor['imaginary'];
        $d3 = $parsedComplexDivisor['real'] * $parsedComplexDivisor['real'] + $parsedComplexDivisor['imaginary'] * $parsedComplexDivisor['imaginary'];
        $r = $d1 / $d3;
        $i = $d2 / $d3;
        if ($i > 0.0) {
            return self::_cleanComplex($r . '+' . $i . $parsedComplexDivisor['suffix']);
        } elseif ($i < 0.0) {
            return self::_cleanComplex($r . $i . $parsedComplexDivisor['suffix']);
        } else {
            return $r;
        }
    }
    //	function IMDIV()
    /**
     * IMSUB
     *
     * Returns the difference of two complex numbers in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMSUB(complexNumber1,complexNumber2)
     *
     * @param	string		$complexNumber1		The complex number from which to subtract complexNumber2.
     * @param	string		$complexNumber2		The complex number to subtract from complexNumber1.
     * @return	string
     */
    public static function IMSUB($complexNumber1, $complexNumber2)
    {
        $complexNumber1 = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber1);
        $complexNumber2 = PHPExcel_Calculation_Functions::flattenSingleValue($complexNumber2);
        $parsedComplex1 = self::_parseComplex($complexNumber1);
        $parsedComplex2 = self::_parseComplex($complexNumber2);
        if ($parsedComplex1['suffix'] != '' && $parsedComplex2['suffix'] != '' && $parsedComplex1['suffix'] != $parsedComplex2['suffix']) {
            return PHPExcel_Calculation_Functions::NaN();
        } elseif ($parsedComplex1['suffix'] == '' && $parsedComplex2['suffix'] != '') {
            $parsedComplex1['suffix'] = $parsedComplex2['suffix'];
        }
        $d1 = $parsedComplex1['real'] - $parsedComplex2['real'];
        $d2 = $parsedComplex1['imaginary'] - $parsedComplex2['imaginary'];
        return self::COMPLEX($d1, $d2, $parsedComplex1['suffix']);
    }
    //	function IMSUB()
    /**
     * IMSUM
     *
     * Returns the sum of two or more complex numbers in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMSUM(complexNumber[,complexNumber[,...]])
     *
     * @param	string		$complexNumber,...	Series of complex numbers to add
     * @return	string
     */
    public static function IMSUM()
    {
        // Return value
        $returnValue = self::_parseComplex('0');
        $activeSuffix = '';
        // Loop through the arguments
        $aArgs = PHPExcel_Calculation_Functions::flattenArray(func_get_args());
        foreach ($aArgs as $arg) {
            $parsedComplex = self::_parseComplex($arg);
            if ($activeSuffix == '') {
                $activeSuffix = $parsedComplex['suffix'];
            } elseif ($parsedComplex['suffix'] != '' && $activeSuffix != $parsedComplex['suffix']) {
                return PHPExcel_Calculation_Functions::VALUE();
            }
            $returnValue['real'] += $parsedComplex['real'];
            $returnValue['imaginary'] += $parsedComplex['imaginary'];
        }
        if ($returnValue['imaginary'] == 0.0) {
            $activeSuffix = '';
        }
        return self::COMPLEX($returnValue['real'], $returnValue['imaginary'], $activeSuffix);
    }
    //	function IMSUM()
    /**
     * IMPRODUCT
     *
     * Returns the product of two or more complex numbers in x + yi or x + yj text format.
     *
     * Excel Function:
     *		IMPRODUCT(complexNumber[,complexNumber[,...]])
     *
     * @param	string		$complexNumber,...	Series of complex numbers to multiply
     * @return	string
     */
    public static function IMPRODUCT()
    {
        // Return value
        $returnValue = self::_parseComplex('1');
        $activeSuffix = '';
        // Loop through the arguments
        $aArgs = PHPExcel_Calculation_Functions::flattenArray(func_get_args());
        foreach ($aArgs as $arg) {
            $parsedComplex = self::_parseComplex($arg);
            $workValue = $returnValue;
            if ($parsedComplex['suffix'] != '' && $activeSuffix == '') {
                $activeSuffix = $parsedComplex['suffix'];
            } elseif ($parsedComplex['suffix'] != '' && $activeSuffix != $parsedComplex['suffix']) {
                return PHPExcel_Calculation_Functions::NaN();
            }
            $returnValue['real'] = $workValue['real'] * $parsedComplex['real'] - $workValue['imaginary'] * $parsedComplex['imaginary'];
            $returnValue['imaginary'] = $workValue['real'] * $parsedComplex['imaginary'] + $workValue['imaginary'] * $parsedComplex['real'];
        }
        if ($returnValue['imaginary'] == 0.0) {
            $activeSuffix = '';
        }
        return self::COMPLEX($returnValue['real'], $returnValue['imaginary'], $activeSuffix);
    }
    //	function IMPRODUCT()
    /**
     *	DELTA
     *
     *	Tests whether two values are equal. Returns 1 if number1 = number2; returns 0 otherwise.
     *	Use this function to filter a set of values. For example, by summing several DELTA
     *	functions you calculate the count of equal pairs. This function is also known as the
     *	Kronecker Delta function.
     *
     *	Excel Function:
     *		DELTA(a[,b])
     *
     *	@param	float		$a	The first number.
     *	@param	float		$b	The second number. If omitted, b is assumed to be zero.
     *	@return	int
     */
    public static function DELTA($a, $b = 0)
    {
        $a = PHPExcel_Calculation_Functions::flattenSingleValue($a);
        $b = PHPExcel_Calculation_Functions::flattenSingleValue($b);
        return (int) ($a == $b);
    }
    //	function DELTA()
    /**
     *	GESTEP
     *
     *	Excel Function:
     *		GESTEP(number[,step])
     *
     *	Returns 1 if number >= step; returns 0 (zero) otherwise
     *	Use this function to filter a set of values. For example, by summing several GESTEP
     *	functions you calculate the count of values that exceed a threshold.
     *
     *	@param	float		$number		The value to test against step.
     *	@param	float		$step		The threshold value.
     *									If you omit a value for step, GESTEP uses zero.
     *	@return	int
     */
    public static function GESTEP($number, $step = 0)
    {
        $number = PHPExcel_Calculation_Functions::flattenSingleValue($number);
        $step = PHPExcel_Calculation_Functions::flattenSingleValue($step);
        return (int) ($number >= $step);
    }
    //	function GESTEP()
    //
    //	Private method to calculate the erf value
    //
    private static $_two_sqrtpi = 1.1283791670955126;
    public static function _erfVal($x)
    {
        if (abs($x) > 2.2) {
            return 1 - self::_erfcVal($x);
        }
        $sum = $term = $x;
        $xsqr = $x * $x;
        $j = 1;
        do {
            $term *= $xsqr / $j;
            $sum -= $term / (2 * $j + 1);
            ++$j;
            $term *= $xsqr / $j;
            $sum += $term / (2 * $j + 1);
            ++$j;
            if ($sum == 0.0) {
                break;
            }
        } while (abs($term / $sum) > PRECISION);
        return self::$_two_sqrtpi * $sum;
    }
    //	function _erfVal()
    /**
     *	ERF
     *
     *	Returns the error function integrated between the lower and upper bound arguments.
     *
     *	Note: In Excel 2007 or earlier, if you input a negative value for the upper or lower bound arguments,
     *			the function would return a #NUM! error. However, in Excel 2010, the function algorithm was
     *			improved, so that it can now calculate the function for both positive and negative ranges.
     *			PHPExcel follows Excel 2010 behaviour, and accepts nagative arguments.
     *
     *	Excel Function:
     *		ERF(lower[,upper])
     *
     *	@param	float		$lower	lower bound for integrating ERF
     *	@param	float		$upper	upper bound for integrating ERF.
     *								If omitted, ERF integrates between zero and lower_limit
     *	@return	float
     */
    public static function ERF($lower, $upper = NULL)
    {
        $lower = PHPExcel_Calculation_Functions::flattenSingleValue($lower);
        $upper = PHPExcel_Calculation_Functions::flattenSingleValue($upper);
        if (is_numeric($lower)) {
            if (is_null($upper)) {
                return self::_erfVal($lower);
            }
            if (is_numeric($upper)) {
                return self::_erfVal($upper) - self::_erfVal($lower);
            }
        }
        return PHPExcel_Calculation_Functions::VALUE();
    }
    //	function ERF()
    //
    //	Private method to calculate the erfc value
    //
    private static $_one_sqrtpi = 0.5641895835477563;
    private static function _erfcVal($x)
    {
        if (abs($x) < 2.2) {
            return 1 - self::_erfVal($x);
        }
        if ($x < 0) {
            return 2 - self::ERFC(-$x);
        }
        $a = $n = 1;
        $b = $c = $x;
        $d = $x * $x + 0.5;
        $q1 = $q2 = $b / $d;
        $t = 0;
        do {
            $t = $a * $n + $b * $x;
            $a = $b;
            $b = $t;
            $t = $c * $n + $d * $x;
            $c = $d;
            $d = $t;
            $n += 0.5;
            $q1 = $q2;
            $q2 = $b / $d;
        } while (abs($q1 - $q2) / $q2 > PRECISION);
        return self::$_one_sqrtpi * exp(-$x * $x) * $q2;
    }
    //	function _erfcVal()
    /**
     *	ERFC
     *
     *	Returns the complementary ERF function integrated between x and infinity
     *
     *	Note: In Excel 2007 or earlier, if you input a negative value for the lower bound argument,
     *		the function would return a #NUM! error. However, in Excel 2010, the function algorithm was
     *		improved, so that it can now calculate the function for both positive and negative x values.
     *			PHPExcel follows Excel 2010 behaviour, and accepts nagative arguments.
     *
     *	Excel Function:
     *		ERFC(x)
     *
     *	@param	float	$x	The lower bound for integrating ERFC
     *	@return	float
     */
    public static function ERFC($x)
    {
        $x = PHPExcel_Calculation_Functions::flattenSingleValue($x);
        if (is_numeric($x)) {
            return self::_erfcVal($x);
        }
        return PHPExcel_Calculation_Functions::VALUE();
    }
    //	function ERFC()
    /**
     *	getConversionGroups
     *	Returns a list of the different conversion groups for UOM conversions
     *
     *	@return	array
     */
    public static function getConversionGroups()
    {
        $conversionGroups = array();
        foreach (self::$_conversionUnits as $conversionUnit) {
            $conversionGroups[] = $conversionUnit['Group'];
        }
        return array_merge(array_unique($conversionGroups));
    }
    //	function getConversionGroups()
    /**
     *	getConversionGroupUnits
     *	Returns an array of units of measure, for a specified conversion group, or for all groups
     *
     *	@param	string	$group	The group whose units of measure you want to retrieve
     *	@return	array
     */
    public static function getConversionGroupUnits($group = NULL)
    {
        $conversionGroups = array();
        foreach (self::$_conversionUnits as $conversionUnit => $conversionGroup) {
            if (is_null($group) || $conversionGroup['Group'] == $group) {
                $conversionGroups[$conversionGroup['Group']][] = $conversionUnit;
            }
        }
        return $conversionGroups;
    }
    //	function getConversionGroupUnits()
    /**
     *	getConversionGroupUnitDetails
     *
     *	@param	string	$group	The group whose units of measure you want to retrieve
     *	@return	array
     */
    public static function getConversionGroupUnitDetails($group = NULL)
    {
        $conversionGroups = array();
        foreach (self::$_conversionUnits as $conversionUnit => $conversionGroup) {
            if (is_null($group) || $conversionGroup['Group'] == $group) {
                $conversionGroups[$conversionGroup['Group']][] = array('unit' => $conversionUnit, 'description' => $conversionGroup['Unit Name']);
            }
        }
        return $conversionGroups;
    }
    //	function getConversionGroupUnitDetails()
    /**
     *	getConversionMultipliers
     *	Returns an array of the Multiplier prefixes that can be used with Units of Measure in CONVERTUOM()
     *
     *	@return	array of mixed
     */
    public static function getConversionMultipliers()
    {
        return self::$_conversionMultipliers;
    }
    //	function getConversionGroups()
    /**
     *	CONVERTUOM
     *
     *	Converts a number from one measurement system to another.
     *	For example, CONVERT can translate a table of distances in miles to a table of distances
     *	in kilometers.
     *
     *	Excel Function:
     *		CONVERT(value,fromUOM,toUOM)
     *
     *	@param	float		$value		The value in fromUOM to convert.
     *	@param	string		$fromUOM	The units for value.
     *	@param	string		$toUOM		The units for the result.
     *
     *	@return	float
     */
    public static function CONVERTUOM($value, $fromUOM, $toUOM)
    {
        $value = PHPExcel_Calculation_Functions::flattenSingleValue($value);
        $fromUOM = PHPExcel_Calculation_Functions::flattenSingleValue($fromUOM);
        $toUOM = PHPExcel_Calculation_Functions::flattenSingleValue($toUOM);
        if (!is_numeric($value)) {
            return PHPExcel_Calculation_Functions::VALUE();
        }
        $fromMultiplier = 1.0;
        if (isset(self::$_conversionUnits[$fromUOM])) {
            $unitGroup1 = self::$_conversionUnits[$fromUOM]['Group'];
        } else {
            $fromMultiplier = substr($fromUOM, 0, 1);
            $fromUOM = substr($fromUOM, 1);
            if (isset(self::$_conversionMultipliers[$fromMultiplier])) {
                $fromMultiplier = self::$_conversionMultipliers[$fromMultiplier]['multiplier'];
            } else {
                return PHPExcel_Calculation_Functions::NA();
            }
            if (isset(self::$_conversionUnits[$fromUOM]) && self::$_conversionUnits[$fromUOM]['AllowPrefix']) {
                $unitGroup1 = self::$_conversionUnits[$fromUOM]['Group'];
            } else {
                return PHPExcel_Calculation_Functions::NA();
            }
        }
        $value *= $fromMultiplier;
        $toMultiplier = 1.0;
        if (isset(self::$_conversionUnits[$toUOM])) {
            $unitGroup2 = self::$_conversionUnits[$toUOM]['Group'];
        } else {
            $toMultiplier = substr($toUOM, 0, 1);
            $toUOM = substr($toUOM, 1);
            if (isset(self::$_conversionMultipliers[$toMultiplier])) {
                $toMultiplier = self::$_conversionMultipliers[$toMultiplier]['multiplier'];
            } else {
                return PHPExcel_Calculation_Functions::NA();
            }
            if (isset(self::$_conversionUnits[$toUOM]) && self::$_conversionUnits[$toUOM]['AllowPrefix']) {
                $unitGroup2 = self::$_conversionUnits[$toUOM]['Group'];
            } else {
                return PHPExcel_Calculation_Functions::NA();
            }
        }
        if ($unitGroup1 != $unitGroup2) {
            return PHPExcel_Calculation_Functions::NA();
        }
        if ($fromUOM == $toUOM && $fromMultiplier == $toMultiplier) {
            //	We've already factored $fromMultiplier into the value, so we need
            //		to reverse it again
            return $value / $fromMultiplier;
        } elseif ($unitGroup1 == 'Temperature') {
            if ($fromUOM == 'F' || $fromUOM == 'fah') {
                if ($toUOM == 'F' || $toUOM == 'fah') {
                    return $value;
                } else {
                    $value = ($value - 32) / 1.8;
                    if ($toUOM == 'K' || $toUOM == 'kel') {
                        $value += 273.15;
                    }
                    return $value;
                }
            } elseif (($fromUOM == 'K' || $fromUOM == 'kel') && ($toUOM == 'K' || $toUOM == 'kel')) {
                return $value;
            } elseif (($fromUOM == 'C' || $fromUOM == 'cel') && ($toUOM == 'C' || $toUOM == 'cel')) {
                return $value;
            }
            if ($toUOM == 'F' || $toUOM == 'fah') {
                if ($fromUOM == 'K' || $fromUOM == 'kel') {
                    $value -= 273.15;
                }
                return $value * 1.8 + 32;
            }
            if ($toUOM == 'C' || $toUOM == 'cel') {
                return $value - 273.15;
            }
            return $value + 273.15;
        }
        return $value * self::$_unitConversions[$unitGroup1][$fromUOM][$toUOM] / $toMultiplier;
    }
}
//	class PHPExcel_Calculation_Engineering

?>