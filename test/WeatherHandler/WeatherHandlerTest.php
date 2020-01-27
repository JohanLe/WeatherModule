<?php

namespace Anax\Weather;

use PHPUnit\Framework\TestCase;


class WeatherHandlerTest extends TestCase
{
    /**
     * Just assert something is true.
     */
    public function testGetObservedWeather()
    {
        $controller = new WeatherHandler();
        $res = $controller->getObservedWeather();
        $this->assertIsArray($res);
    }

    public function testGetDailyForecast()
    {
        $controller = new WeatherHandler();
        $res = $controller->getDailyForecast(56.67446, 12.85676);
        $this->assertIsObject($res);
    }

    public function testGetDailyForecastFail()
    {
        $controller = new WeatherHandler();
        $res = $controller->getDailyForecast("123123123", "123123123");
        $this->assertFalse($res);
    }
}


