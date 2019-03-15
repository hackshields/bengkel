<?php

class Swift_CharacterReader_Utf8ReaderTest extends \PHPUnit_Framework_TestCase
{
    private $_reader;
    public function setUp()
    {
        $this->_reader = new Swift_CharacterReader_Utf8Reader();
    }
    public function testLeading7BitOctetCausesReturnZero()
    {
        for ($ordinal = 0x0; $ordinal <= 0x7f; ++$ordinal) {
            $this->assertSame(0, $this->_reader->validateByteSequence(array($ordinal), 1));
        }
    }
    public function testLeadingByteOf2OctetCharCausesReturn1()
    {
        for ($octet = 0xc0; $octet <= 0xdf; ++$octet) {
            $this->assertSame(1, $this->_reader->validateByteSequence(array($octet), 1));
        }
    }
    public function testLeadingByteOf3OctetCharCausesReturn2()
    {
        for ($octet = 0xe0; $octet <= 0xef; ++$octet) {
            $this->assertSame(2, $this->_reader->validateByteSequence(array($octet), 1));
        }
    }
    public function testLeadingByteOf4OctetCharCausesReturn3()
    {
        for ($octet = 0xf0; $octet <= 0xf7; ++$octet) {
            $this->assertSame(3, $this->_reader->validateByteSequence(array($octet), 1));
        }
    }
    public function testLeadingByteOf5OctetCharCausesReturn4()
    {
        for ($octet = 0xf8; $octet <= 0xfb; ++$octet) {
            $this->assertSame(4, $this->_reader->validateByteSequence(array($octet), 1));
        }
    }
    public function testLeadingByteOf6OctetCharCausesReturn5()
    {
        for ($octet = 0xfc; $octet <= 0xfd; ++$octet) {
            $this->assertSame(5, $this->_reader->validateByteSequence(array($octet), 1));
        }
    }
}

?>