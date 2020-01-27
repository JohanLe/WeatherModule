<?php

namespace Anax\Weather;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class GeoMapTest extends TestCase
{
    /**
     * Just assert something is true.
     */
    public function testTrue()
    {
        $this->assertTrue(true);
    }

    public function testGet()
    {
        $geoMap = new GeoMap();
        $res = $geoMap->get("2a03:2880:f106:83:face:b00c::25de");

        $this->assertIsString($res);
    }

    public function testGetUserData()
    {
        $geoMap = new GeoMap();
        $res = $geoMap->getUserData();

        $this->assertIsObject($res);
    }
    public function testGetUserDataWithFilter()
    {
        $geoMap = new GeoMap();
        $res = $geoMap->getUserData('ip,country_code,type,longitude');

        $this->assertIsObject($res);
    }
}
