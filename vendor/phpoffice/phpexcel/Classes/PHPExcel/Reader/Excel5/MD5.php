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
 * @package    PHPExcel_Reader_Excel5
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt        LGPL
 * @version    ##VERSION##, ##DATE##
 */
/**
 * PHPExcel_Reader_Excel5_MD5
 *
 * @category        PHPExcel
 * @package                PHPExcel_Reader_Excel5
 * @copyright        Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Reader_Excel5_MD5
{
    // Context
    private $a;
    private $b;
    private $c;
    private $d;
    /**
     * MD5 stream constructor
     */
    public function __construct()
    {
        $this->reset();
    }
    /**
     * Reset the MD5 stream context
     */
    public function reset()
    {
        $this->a = 0x67452301;
        $this->b = 0.0;
        $this->c = 0.0;
        $this->d = 0x10325476;
    }
    /**
     * Get MD5 stream context
     * 
     * @return string
     */
    public function getContext()
    {
        $s = '';
        foreach (array('a', 'b', 'c', 'd') as $i) {
            $v = $this->{$i};
            $s .= chr($v & 0xff);
            $s .= chr($v >> 8 & 0xff);
            $s .= chr($v >> 16 & 0xff);
            $s .= chr($v >> 24 & 0xff);
        }
        return $s;
    }
    /**
     * Add data to context
     * 
     * @param string $data Data to add
     */
    public function add($data)
    {
        $words = array_values(unpack('V16', $data));
        $A = $this->a;
        $B = $this->b;
        $C = $this->c;
        $D = $this->d;
        $F = array('PHPExcel_Reader_Excel5_MD5', 'F');
        $G = array('PHPExcel_Reader_Excel5_MD5', 'G');
        $H = array('PHPExcel_Reader_Excel5_MD5', 'H');
        $I = array('PHPExcel_Reader_Excel5_MD5', 'I');
        /* ROUND 1 */
        self::step($F, $A, $B, $C, $D, $words[0], 7, 3614090360.0);
        self::step($F, $D, $A, $B, $C, $words[1], 12, 0.0);
        self::step($F, $C, $D, $A, $B, $words[2], 17, 0x242070db);
        self::step($F, $B, $C, $D, $A, $words[3], 22, 0.0);
        self::step($F, $A, $B, $C, $D, $words[4], 7, 4118548399.0);
        self::step($F, $D, $A, $B, $C, $words[5], 12, 0x4787c62a);
        self::step($F, $C, $D, $A, $B, $words[6], 17, 2821735955.0);
        self::step($F, $B, $C, $D, $A, $words[7], 22, 4249261313.0);
        self::step($F, $A, $B, $C, $D, $words[8], 7, 0x698098d8);
        self::step($F, $D, $A, $B, $C, $words[9], 12, 2336552879.0);
        self::step($F, $C, $D, $A, $B, $words[10], 17, 4294925233.0);
        self::step($F, $B, $C, $D, $A, $words[11], 22, 0.0);
        self::step($F, $A, $B, $C, $D, $words[12], 7, 0x6b901122);
        self::step($F, $D, $A, $B, $C, $words[13], 12, 4254626195.0);
        self::step($F, $C, $D, $A, $B, $words[14], 17, 0.0);
        self::step($F, $B, $C, $D, $A, $words[15], 22, 0x49b40821);
        /* ROUND 2 */
        self::step($G, $A, $B, $C, $D, $words[1], 5, 0.0);
        self::step($G, $D, $A, $B, $C, $words[6], 9, 3225465664.0);
        self::step($G, $C, $D, $A, $B, $words[11], 14, 0x265e5a51);
        self::step($G, $B, $C, $D, $A, $words[0], 20, 0.0);
        self::step($G, $A, $B, $C, $D, $words[5], 5, 3593408605.0);
        self::step($G, $D, $A, $B, $C, $words[10], 9, 0x2441453);
        self::step($G, $C, $D, $A, $B, $words[15], 14, 0.0);
        self::step($G, $B, $C, $D, $A, $words[4], 20, 0.0);
        self::step($G, $A, $B, $C, $D, $words[9], 5, 0x21e1cde6);
        self::step($G, $D, $A, $B, $C, $words[14], 9, 3275163606.0);
        self::step($G, $C, $D, $A, $B, $words[3], 14, 4107603335.0);
        self::step($G, $B, $C, $D, $A, $words[8], 20, 0x455a14ed);
        self::step($G, $A, $B, $C, $D, $words[13], 5, 0.0);
        self::step($G, $D, $A, $B, $C, $words[2], 9, 0.0);
        self::step($G, $C, $D, $A, $B, $words[7], 14, 0x676f02d9);
        self::step($G, $B, $C, $D, $A, $words[12], 20, 2368359562.0);
        /* ROUND 3 */
        self::step($H, $A, $B, $C, $D, $words[5], 4, 4294588738.0);
        self::step($H, $D, $A, $B, $C, $words[8], 11, 2272392833.0);
        self::step($H, $C, $D, $A, $B, $words[11], 16, 0x6d9d6122);
        self::step($H, $B, $C, $D, $A, $words[14], 23, 0.0);
        self::step($H, $A, $B, $C, $D, $words[1], 4, 0.0);
        self::step($H, $D, $A, $B, $C, $words[4], 11, 0x4bdecfa9);
        self::step($H, $C, $D, $A, $B, $words[7], 16, 4139469664.0);
        self::step($H, $B, $C, $D, $A, $words[10], 23, 0.0);
        self::step($H, $A, $B, $C, $D, $words[13], 4, 0x289b7ec6);
        self::step($H, $D, $A, $B, $C, $words[0], 11, 0.0);
        self::step($H, $C, $D, $A, $B, $words[3], 16, 0.0);
        self::step($H, $B, $C, $D, $A, $words[6], 23, 0x4881d05);
        self::step($H, $A, $B, $C, $D, $words[9], 4, 3654602809.0);
        self::step($H, $D, $A, $B, $C, $words[12], 11, 0.0);
        self::step($H, $C, $D, $A, $B, $words[15], 16, 0x1fa27cf8);
        self::step($H, $B, $C, $D, $A, $words[2], 23, 3299628645.0);
        /* ROUND 4 */
        self::step($I, $A, $B, $C, $D, $words[0], 6, 4096336452.0);
        self::step($I, $D, $A, $B, $C, $words[7], 10, 0x432aff97);
        self::step($I, $C, $D, $A, $B, $words[14], 15, 2878612391.0);
        self::step($I, $B, $C, $D, $A, $words[5], 21, 4237533241.0);
        self::step($I, $A, $B, $C, $D, $words[12], 6, 0x655b59c3);
        self::step($I, $D, $A, $B, $C, $words[3], 10, 2399980690.0);
        self::step($I, $C, $D, $A, $B, $words[10], 15, 0.0);
        self::step($I, $B, $C, $D, $A, $words[1], 21, 2240044497.0);
        self::step($I, $A, $B, $C, $D, $words[8], 6, 0x6fa87e4f);
        self::step($I, $D, $A, $B, $C, $words[15], 10, 0.0);
        self::step($I, $C, $D, $A, $B, $words[6], 15, 2734768916.0);
        self::step($I, $B, $C, $D, $A, $words[13], 21, 0x4e0811a1);
        self::step($I, $A, $B, $C, $D, $words[4], 6, 0.0);
        self::step($I, $D, $A, $B, $C, $words[11], 10, 3174756917.0);
        self::step($I, $C, $D, $A, $B, $words[2], 15, 0x2ad7d2bb);
        self::step($I, $B, $C, $D, $A, $words[9], 21, 0.0);
        $this->a = $this->a + $A & 4294967295.0;
        $this->b = $this->b + $B & 4294967295.0;
        $this->c = $this->c + $C & 4294967295.0;
        $this->d = $this->d + $D & 4294967295.0;
    }
    private static function F($X, $Y, $Z)
    {
        return $X & $Y | ~$X & $Z;
        // X AND Y OR NOT X AND Z
    }
    private static function G($X, $Y, $Z)
    {
        return $X & $Z | $Y & ~$Z;
        // X AND Z OR Y AND NOT Z
    }
    private static function H($X, $Y, $Z)
    {
        return $X ^ $Y ^ $Z;
        // X XOR Y XOR Z
    }
    private static function I($X, $Y, $Z)
    {
        return $Y ^ ($X | ~$Z);
        // Y XOR (X OR NOT Z)
    }
    private static function step($func, &$A, $B, $C, $D, $M, $s, $t)
    {
        $A = $A + call_user_func($func, $B, $C, $D) + $M + $t & 4294967295.0;
        $A = self::rotate($A, $s);
        $A = $B + $A & 4294967295.0;
    }
    private static function rotate($decimal, $bits)
    {
        $binary = str_pad(decbin($decimal), 32, "0", STR_PAD_LEFT);
        return bindec(substr($binary, $bits) . substr($binary, 0, $bits));
    }
}

?>