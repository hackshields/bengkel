<?php

class HTMLPurifier_EncoderTest extends HTMLPurifier_Harness
{
    protected $_entity_lookup;
    public function setUp()
    {
        $this->_entity_lookup = HTMLPurifier_EntityLookup::instance();
        parent::setUp();
    }
    public function assertCleanUTF8($string, $expect = null)
    {
        if ($expect === null) {
            $expect = $string;
        }
        $this->assertIdentical(HTMLPurifier_Encoder::cleanUTF8($string), $expect, 'iconv: %s');
        $this->assertIdentical(HTMLPurifier_Encoder::cleanUTF8($string, true), $expect, 'PHP: %s');
    }
    public function test_cleanUTF8()
    {
        $this->assertCleanUTF8('Normal string.');
        $this->assertCleanUTF8("Test\tAllowed\nControl\rCharacters");
        $this->assertCleanUTF8("null byte: \0", 'null byte: ');
        $this->assertCleanUTF8("\1\2\3\4\5\6\7", '');
        $this->assertCleanUTF8("", '');
        // one byte invalid SGML char
        $this->assertCleanUTF8("", '');
        // two byte invalid SGML
        $this->assertCleanUTF8("󿿿");
        // valid four byte
        $this->assertCleanUTF8("��", '');
        // malformed UTF8
        // invalid codepoints
        $this->assertCleanUTF8("���", '');
    }
    public function test_convertToUTF8_noConvert()
    {
        // UTF-8 means that we don't touch it
        $this->assertIdentical(
            HTMLPurifier_Encoder::convertToUTF8("�", $this->config, $this->context),
            "�",
            // this is invalid
            'Expected identical [Binary: F6]'
        );
    }
    public function test_convertToUTF8_spuriousEncoding()
    {
        if (!HTMLPurifier_Encoder::iconvAvailable()) {
            return;
        }
        $this->config->set('Core.Encoding', 'utf99');
        $this->expectError('Invalid encoding utf99');
        $this->assertIdentical(HTMLPurifier_Encoder::convertToUTF8("�", $this->config, $this->context), '');
    }
    public function test_convertToUTF8_iso8859_1()
    {
        $this->config->set('Core.Encoding', 'ISO-8859-1');
        $this->assertIdentical(HTMLPurifier_Encoder::convertToUTF8("�", $this->config, $this->context), "ö");
    }
    public function test_convertToUTF8_withoutIconv()
    {
        $this->config->set('Core.Encoding', 'ISO-8859-1');
        $this->config->set('Test.ForceNoIconv', true);
        $this->assertIdentical(HTMLPurifier_Encoder::convertToUTF8("�", $this->config, $this->context), "ö");
    }
    public function getZhongWen()
    {
        return "中文 (Chinese)";
    }
    public function test_convertFromUTF8_utf8()
    {
        // UTF-8 means that we don't touch it
        $this->assertIdentical(HTMLPurifier_Encoder::convertFromUTF8("ö", $this->config, $this->context), "ö");
    }
    public function test_convertFromUTF8_iso8859_1()
    {
        $this->config->set('Core.Encoding', 'ISO-8859-1');
        $this->assertIdentical(HTMLPurifier_Encoder::convertFromUTF8("ö", $this->config, $this->context), "�", 'Expected identical [Binary: F6]');
    }
    public function test_convertFromUTF8_iconvNoChars()
    {
        if (!HTMLPurifier_Encoder::iconvAvailable()) {
            return;
        }
        $this->config->set('Core.Encoding', 'ISO-8859-1');
        $this->assertIdentical(HTMLPurifier_Encoder::convertFromUTF8($this->getZhongWen(), $this->config, $this->context), " (Chinese)");
    }
    public function test_convertFromUTF8_phpNormal()
    {
        // Plain PHP implementation has slightly different behavior
        $this->config->set('Core.Encoding', 'ISO-8859-1');
        $this->config->set('Test.ForceNoIconv', true);
        $this->assertIdentical(HTMLPurifier_Encoder::convertFromUTF8("ö", $this->config, $this->context), "�", 'Expected identical [Binary: F6]');
    }
    public function test_convertFromUTF8_phpNoChars()
    {
        $this->config->set('Core.Encoding', 'ISO-8859-1');
        $this->config->set('Test.ForceNoIconv', true);
        $this->assertIdentical(HTMLPurifier_Encoder::convertFromUTF8($this->getZhongWen(), $this->config, $this->context), "?? (Chinese)");
    }
    public function test_convertFromUTF8_withProtection()
    {
        // Preserve the characters!
        $this->config->set('Core.Encoding', 'ISO-8859-1');
        $this->config->set('Core.EscapeNonASCIICharacters', true);
        $this->assertIdentical(HTMLPurifier_Encoder::convertFromUTF8($this->getZhongWen(), $this->config, $this->context), "&#20013;&#25991; (Chinese)");
    }
    public function test_convertFromUTF8_withProtectionButUtf8()
    {
        // Preserve the characters!
        $this->config->set('Core.EscapeNonASCIICharacters', true);
        $this->assertIdentical(HTMLPurifier_Encoder::convertFromUTF8($this->getZhongWen(), $this->config, $this->context), "&#20013;&#25991; (Chinese)");
    }
    public function test_convertToASCIIDumbLossless()
    {
        // Uppercase thorn letter
        $this->assertIdentical(HTMLPurifier_Encoder::convertToASCIIDumbLossless("Þorn"), "&#222;orn");
        $this->assertIdentical(HTMLPurifier_Encoder::convertToASCIIDumbLossless("an"), "an");
        // test up to four bytes
        $this->assertIdentical(HTMLPurifier_Encoder::convertToASCIIDumbLossless("󠀠"), "&#917536;");
    }
    public function assertASCIISupportCheck($enc, $ret)
    {
        $test = HTMLPurifier_Encoder::testEncodingSupportsASCII($enc, true);
        if ($test === false) {
            return;
        }
        $this->assertIdentical(HTMLPurifier_Encoder::testEncodingSupportsASCII($enc), $ret);
        $this->assertIdentical(HTMLPurifier_Encoder::testEncodingSupportsASCII($enc, true), $ret);
    }
    public function test_testEncodingSupportsASCII()
    {
        if (HTMLPurifier_Encoder::iconvAvailable()) {
            $this->assertASCIISupportCheck('Shift_JIS', array("¥" => '\\', "‾" => '~'));
            $this->assertASCIISupportCheck('JOHAB', array("₩" => '\\'));
        }
        $this->assertASCIISupportCheck('ISO-8859-1', array());
        $this->assertASCIISupportCheck('dontexist', array());
        // canary
    }
    public function testShiftJIS()
    {
        if (!HTMLPurifier_Encoder::iconvAvailable()) {
            return;
        }
        $this->config->set('Core.Encoding', 'Shift_JIS');
        // This actually looks like a Yen, but we're going to treat it differently
        $this->assertIdentical(HTMLPurifier_Encoder::convertFromUTF8('\\~', $this->config, $this->context), '\\~');
        $this->assertIdentical(HTMLPurifier_Encoder::convertToUTF8('\\~', $this->config, $this->context), '\\~');
    }
    public function testIconvTruncateBug()
    {
        if (!HTMLPurifier_Encoder::iconvAvailable()) {
            return;
        }
        if (HTMLPurifier_Encoder::testIconvTruncateBug() !== HTMLPurifier_Encoder::ICONV_TRUNCATES) {
            return;
        }
        $this->config->set('Core.Encoding', 'ISO-8859-1');
        $this->assertIdentical(HTMLPurifier_Encoder::convertFromUTF8("中" . str_repeat('a', 10000), $this->config, $this->context), str_repeat('a', 10000));
    }
    public function testIconvChunking()
    {
        if (!HTMLPurifier_Encoder::iconvAvailable()) {
            return;
        }
        if (HTMLPurifier_Encoder::testIconvTruncateBug() !== HTMLPurifier_Encoder::ICONV_TRUNCATES) {
            return;
        }
        $this->assertIdentical(HTMLPurifier_Encoder::iconv('utf-8', 'iso-8859-1//IGNORE', "a󠀠b", 4), 'ab');
        $this->assertIdentical(HTMLPurifier_Encoder::iconv('utf-8', 'iso-8859-1//IGNORE', "aa中b", 4), 'aab');
        $this->assertIdentical(HTMLPurifier_Encoder::iconv('utf-8', 'iso-8859-1//IGNORE', "aaaαb", 4), 'aaab');
        $this->assertIdentical(HTMLPurifier_Encoder::iconv('utf-8', 'iso-8859-1//IGNORE', "aaaa󠀠b", 4), 'aaaab');
        $this->assertIdentical(HTMLPurifier_Encoder::iconv('utf-8', 'iso-8859-1//IGNORE', "aaaa中b", 4), 'aaaab');
        $this->assertIdentical(HTMLPurifier_Encoder::iconv('utf-8', 'iso-8859-1//IGNORE', "aaaaαb", 4), 'aaaab');
    }
}
// vim: et sw=4 sts=4

?>