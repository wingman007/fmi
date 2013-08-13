<?php
namespace AlbumTest\Model;

use Album\Model\Album;
use PHPUnit_Framework_TestCase;

class AlbumTest extends PHPUnit_Framework_TestCase
{
    public function testAlbumInitialState()
    {
        $album = new Album();

        $this->assertNull(
            $album->artist,
            '"artist" should initially be null'
        );
        $this->assertNull(
            $album->id,
            '"id" should initially be null'
        );
        $this->assertNull(
            $album->title,
            '"title" should initially be null'
        );
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $album = new Album();
        $data  = array('artist' => 'some artist',
                       'id'     => 123,
                       'title'  => 'some title');

        $album->exchangeArray($data);

        $this->assertSame(
            $data['artist'],
            $album->artist,
            '"artist" was not set correctly'
        );
        $this->assertSame(
            $data['id'],
            $album->id,
            '"id" was not set correctly'
        );
        $this->assertSame(
            $data['title'],
            $album->title,
            '"title" was not set correctly'
        );
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $album = new Album();

        $album->exchangeArray(array('artist' => 'some artist',
                                    'id'     => 123,
                                    'title'  => 'some title'));
        $album->exchangeArray(array());

        $this->assertNull(
            $album->artist, '"artist" should have defaulted to null'
        );
        $this->assertNull(
            $album->id, '"id" should have defaulted to null'
        );
        $this->assertNull(
            $album->title, '"title" should have defaulted to null'
        );
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
        $album = new Album();
        $data  = array('artist' => 'some artist',
                       'id'     => 123,
                       'title'  => 'some title');

        $album->exchangeArray($data);
        $copyArray = $album->getArrayCopy();

        $this->assertSame(
            $data['artist'],
            $copyArray['artist'],
            '"artist" was not set correctly'
        );
        $this->assertSame(
            $data['id'],
            $copyArray['id'],
            '"id" was not set correctly'
        );
        $this->assertSame(
            $data['title'],
            $copyArray['title'],
            '"title" was not set correctly'
        );
    }

    public function testInputFiltersAreSetCorrectly()
    {
        $album = new Album();

        $inputFilter = $album->getInputFilter();

        $this->assertSame(3, $inputFilter->count());
        $this->assertTrue($inputFilter->has('artist'));
        $this->assertTrue($inputFilter->has('id'));
        $this->assertTrue($inputFilter->has('title'));
    }
}