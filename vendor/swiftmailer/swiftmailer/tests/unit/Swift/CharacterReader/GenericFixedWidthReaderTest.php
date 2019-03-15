<?php

class Swift_CharacterReader_GenericFixedWidthReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testInitialByteSizeMatchesWidth()
    {
        $reader = new Swift_CharacterReader_GenericFixedWidthReader(1);
        $this->assertSame(1, $reader->getInitialByteSize());
        $reader = new Swift_CharacterReader_GenericFixedWidthReader(4);
        $this->assertSame(4, $reader->getInitialByteSize());
    }
    public function testValidationValueIsBasedOnOctetCount()
    {
        $reader = new Swift_CharacterReader_GenericFixedWidthReader(4);
        $this->assertSame(1, $reader->validateByteSequence(array(0x1, 0x2, 0x3), 3));
        //3 octets
        $this->assertSame(2, $reader->validateByteSequence(array(0x1, 0xa), 2));
        //2 octets
        $this->assertSame(3, $reader->validateByteSequence(array(0xfe), 1));
        //1 octet
        $this->assertSame(0, $reader->validateByteSequence(array(0xfe, 0x3, 0x67, 0x9a), 4));
        //All 4 octets
    }
    public function testValidationFailsIfTooManyOctets()
    {
        $reader = new Swift_CharacterReader_GenericFixedWidthReader(6);
        $this->assertSame(-1, $reader->validateByteSequence(array(0xfe, 0x3, 0x67, 0x9a, 0x10, 0x9, 0x85), 7));
        //7 octets
    }
}

?>