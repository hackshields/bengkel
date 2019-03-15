<?php

class Swift_CharacterStream_ArrayCharacterStreamTest extends \SwiftMailerTestCase
{
    public function testValidatorAlgorithmOnImportString()
    {
        $reader = $this->_getReader();
        $factory = $this->_getFactory($reader);
        $stream = new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8');
        $reader->shouldReceive('getInitialByteSize')->zeroOrMoreTimes()->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd1), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $stream->importString(pack('C*', 0xd0, 0x94, 0xd0, 0xb6, 0xd0, 0xbe, 0xd1, 0x8d, 0xd0, 0xbb, 0xd0, 0xb0));
    }
    public function testCharactersWrittenUseValidator()
    {
        $reader = $this->_getReader();
        $factory = $this->_getFactory($reader);
        $stream = new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8');
        $reader->shouldReceive('getInitialByteSize')->zeroOrMoreTimes()->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd1), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd1), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd1), 1)->andReturn(1);
        $stream->importString(pack('C*', 0xd0, 0x94, 0xd0, 0xb6, 0xd0, 0xbe));
        $stream->write(pack('C*', 0xd0, 0xbb, 0xd1, 0x8e, 0xd0, 0xb1, 0xd1, 0x8b, 0xd1, 0x85));
    }
    public function testReadCharactersAreInTact()
    {
        $reader = $this->_getReader();
        $factory = $this->_getFactory($reader);
        $stream = new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8');
        $reader->shouldReceive('getInitialByteSize')->zeroOrMoreTimes()->andReturn(1);
        //String
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        //Stream
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd1), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd1), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd1), 1)->andReturn(1);
        $stream->importString(pack('C*', 0xd0, 0x94, 0xd0, 0xb6, 0xd0, 0xbe));
        $stream->write(pack('C*', 0xd0, 0xbb, 0xd1, 0x8e, 0xd0, 0xb1, 0xd1, 0x8b, 0xd1, 0x85));
        $this->assertIdenticalBinary(pack('C*', 0xd0, 0x94), $stream->read(1));
        $this->assertIdenticalBinary(pack('C*', 0xd0, 0xb6, 0xd0, 0xbe), $stream->read(2));
        $this->assertIdenticalBinary(pack('C*', 0xd0, 0xbb), $stream->read(1));
        $this->assertIdenticalBinary(pack('C*', 0xd1, 0x8e, 0xd0, 0xb1, 0xd1, 0x8b), $stream->read(3));
        $this->assertIdenticalBinary(pack('C*', 0xd1, 0x85), $stream->read(1));
        $this->assertSame(false, $stream->read(1));
    }
    public function testCharactersCanBeReadAsByteArrays()
    {
        $reader = $this->_getReader();
        $factory = $this->_getFactory($reader);
        $stream = new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8');
        $reader->shouldReceive('getInitialByteSize')->zeroOrMoreTimes()->andReturn(1);
        //String
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        //Stream
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd1), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd1), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd1), 1)->andReturn(1);
        $stream->importString(pack('C*', 0xd0, 0x94, 0xd0, 0xb6, 0xd0, 0xbe));
        $stream->write(pack('C*', 0xd0, 0xbb, 0xd1, 0x8e, 0xd0, 0xb1, 0xd1, 0x8b, 0xd1, 0x85));
        $this->assertEquals(array(0xd0, 0x94), $stream->readBytes(1));
        $this->assertEquals(array(0xd0, 0xb6, 0xd0, 0xbe), $stream->readBytes(2));
        $this->assertEquals(array(0xd0, 0xbb), $stream->readBytes(1));
        $this->assertEquals(array(0xd1, 0x8e, 0xd0, 0xb1, 0xd1, 0x8b), $stream->readBytes(3));
        $this->assertEquals(array(0xd1, 0x85), $stream->readBytes(1));
        $this->assertSame(false, $stream->readBytes(1));
    }
    public function testRequestingLargeCharCountPastEndOfStream()
    {
        $reader = $this->_getReader();
        $factory = $this->_getFactory($reader);
        $stream = new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8');
        $reader->shouldReceive('getInitialByteSize')->zeroOrMoreTimes()->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $stream->importString(pack('C*', 0xd0, 0x94, 0xd0, 0xb6, 0xd0, 0xbe));
        $this->assertIdenticalBinary(pack('C*', 0xd0, 0x94, 0xd0, 0xb6, 0xd0, 0xbe), $stream->read(100));
        $this->assertSame(false, $stream->read(1));
    }
    public function testRequestingByteArrayCountPastEndOfStream()
    {
        $reader = $this->_getReader();
        $factory = $this->_getFactory($reader);
        $stream = new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8');
        $reader->shouldReceive('getInitialByteSize')->zeroOrMoreTimes()->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $stream->importString(pack('C*', 0xd0, 0x94, 0xd0, 0xb6, 0xd0, 0xbe));
        $this->assertEquals(array(0xd0, 0x94, 0xd0, 0xb6, 0xd0, 0xbe), $stream->readBytes(100));
        $this->assertSame(false, $stream->readBytes(1));
    }
    public function testPointerOffsetCanBeSet()
    {
        $reader = $this->_getReader();
        $factory = $this->_getFactory($reader);
        $stream = new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8');
        $reader->shouldReceive('getInitialByteSize')->zeroOrMoreTimes()->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $stream->importString(pack('C*', 0xd0, 0x94, 0xd0, 0xb6, 0xd0, 0xbe));
        $this->assertIdenticalBinary(pack('C*', 0xd0, 0x94), $stream->read(1));
        $stream->setPointer(0);
        $this->assertIdenticalBinary(pack('C*', 0xd0, 0x94), $stream->read(1));
        $stream->setPointer(2);
        $this->assertIdenticalBinary(pack('C*', 0xd0, 0xbe), $stream->read(1));
    }
    public function testContentsCanBeFlushed()
    {
        $reader = $this->_getReader();
        $factory = $this->_getFactory($reader);
        $stream = new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8');
        $reader->shouldReceive('getInitialByteSize')->zeroOrMoreTimes()->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $stream->importString(pack('C*', 0xd0, 0x94, 0xd0, 0xb6, 0xd0, 0xbe));
        $stream->flushContents();
        $this->assertSame(false, $stream->read(1));
    }
    public function testByteStreamCanBeImportingUsesValidator()
    {
        $reader = $this->_getReader();
        $factory = $this->_getFactory($reader);
        $os = $this->_getByteStream();
        $stream = new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8');
        $os->shouldReceive('setReadPointer')->between(0, 1)->with(0);
        $os->shouldReceive('read')->once()->andReturn(pack('C*', 0xd0));
        $os->shouldReceive('read')->once()->andReturn(pack('C*', 0x94));
        $os->shouldReceive('read')->once()->andReturn(pack('C*', 0xd0));
        $os->shouldReceive('read')->once()->andReturn(pack('C*', 0xb6));
        $os->shouldReceive('read')->once()->andReturn(pack('C*', 0xd0));
        $os->shouldReceive('read')->once()->andReturn(pack('C*', 0xbe));
        $os->shouldReceive('read')->zeroOrMoreTimes()->andReturn(false);
        $reader->shouldReceive('getInitialByteSize')->zeroOrMoreTimes()->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $stream->importByteStream($os);
    }
    public function testImportingStreamProducesCorrectCharArray()
    {
        $reader = $this->_getReader();
        $factory = $this->_getFactory($reader);
        $os = $this->_getByteStream();
        $stream = new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8');
        $os->shouldReceive('setReadPointer')->between(0, 1)->with(0);
        $os->shouldReceive('read')->once()->andReturn(pack('C*', 0xd0));
        $os->shouldReceive('read')->once()->andReturn(pack('C*', 0x94));
        $os->shouldReceive('read')->once()->andReturn(pack('C*', 0xd0));
        $os->shouldReceive('read')->once()->andReturn(pack('C*', 0xb6));
        $os->shouldReceive('read')->once()->andReturn(pack('C*', 0xd0));
        $os->shouldReceive('read')->once()->andReturn(pack('C*', 0xbe));
        $os->shouldReceive('read')->zeroOrMoreTimes()->andReturn(false);
        $reader->shouldReceive('getInitialByteSize')->zeroOrMoreTimes()->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0), 1)->andReturn(1);
        $stream->importByteStream($os);
        $this->assertIdenticalBinary(pack('C*', 0xd0, 0x94), $stream->read(1));
        $this->assertIdenticalBinary(pack('C*', 0xd0, 0xb6), $stream->read(1));
        $this->assertIdenticalBinary(pack('C*', 0xd0, 0xbe), $stream->read(1));
        $this->assertSame(false, $stream->read(1));
    }
    public function testAlgorithmWithFixedWidthCharsets()
    {
        $reader = $this->_getReader();
        $factory = $this->_getFactory($reader);
        $reader->shouldReceive('getInitialByteSize')->zeroOrMoreTimes()->andReturn(2);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd1, 0x8d), 2);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0, 0xbb), 2);
        $reader->shouldReceive('validateByteSequence')->once()->with(array(0xd0, 0xb0), 2);
        $stream = new Swift_CharacterStream_ArrayCharacterStream($factory, 'utf-8');
        $stream->importString(pack('C*', 0xd1, 0x8d, 0xd0, 0xbb, 0xd0, 0xb0));
        $this->assertIdenticalBinary(pack('C*', 0xd1, 0x8d), $stream->read(1));
        $this->assertIdenticalBinary(pack('C*', 0xd0, 0xbb), $stream->read(1));
        $this->assertIdenticalBinary(pack('C*', 0xd0, 0xb0), $stream->read(1));
        $this->assertSame(false, $stream->read(1));
    }
    // -- Creation methods
    private function _getReader()
    {
        return $this->getMockery('Swift_CharacterReader');
    }
    private function _getFactory($reader)
    {
        $factory = $this->getMockery('Swift_CharacterReaderFactory');
        $factory->shouldReceive('getReaderFor')->zeroOrMoreTimes()->with('utf-8')->andReturn($reader);
        return $factory;
    }
    private function _getByteStream()
    {
        return $this->getMockery('Swift_OutputByteStream');
    }
}

?>