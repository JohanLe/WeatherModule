<?php

namespace Anax\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;




/**
 * Style chooser controller loads available stylesheets from a directory and
 * lets the user choose the stylesheet to use.
 */
class ApiController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexAction() : string
    {
        $request = $this->di->get("request");
        $validate = $this->di->get("validate");
        $weatherHandler = new WeatherHandler();
        $geoMap = new GeoMap();
        
        $ipa = $request->getGet("ip");
        $valid = $validate->validateIpAdress($ipa);
        $allData = "";

        if($valid){
            $cords = json_decode($geoMap->get($ipa));
            if($cords){
                $weather = $weatherHandler->getDailyForecast($cords->latitude,$cords->longitude);
                $observedWeather = $weatherHandler->getObservedWeather($cords->latitude,$cords->longitude);

                if($weather && $observedWeather){
                    $weather = $weatherHandler->formatDailyForecast($weather->daily->data);
                    $observedWeather = $weatherHandler->formatPreviusWeatherData($observedWeather);

                    $allWeatherData = [
                        "forecast"=> $weather,
                        "observedWeather"=> $observedWeather
                    ];

                    $allData = json_encode($allWeatherData, JSON_PRETTY_PRINT);


                }else{
                    return "Failed to gather weather data";
                }
            }else{

                return "Failed to get cordinates";
            }
        }else{

            return "Ip adress is not valid";
        }

        return $allData;
    }

    public function observedWeatherAction() : object
    {
        $page = $this->di->get("page");

        $page->add("weather/apiDocumentation");
        
  
        return $page->render([  
            "title" => "Api",
        ]);
    }

    






    public function documentationAction() : object
    {
        $page = $this->di->get("page");

        $page->add("weather/apiDocumentation");
        
  
        return $page->render([  
            "title" => "Api",
        ]);
    }



}

