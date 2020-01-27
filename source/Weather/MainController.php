<?php

namespace Anax\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use Anax\Weather\Storage;


/**
 * Style chooser controller loads available stylesheets from a directory and
 * lets the user choose the stylesheet to use.
 */
class MainController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


        // 2a03:2880:f003:c07:face:b00c::2 Facebook
        // 2001:4860:4860::8888   |  2001:4860:4860::8844 google
    
        // dark sky 26ef698985dfe0ef5692b30380a51e04
        // https://api.darksky.net/forecast/26ef698985dfe0ef5692b30380a51e04/37.8267,-122.4233

    /**
     * Recive data,set data to view and render view.
     */

    public function indexAction() : object
    {

        $session = $this->di->get("session");
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $storage = new Storage();

        $forecast = $session->get("forecast") ?? [];
        $observedWeather = $session->get("observedWeather") ?? [];
        $location = $session->get("location") ?? " ";
        $cords = $request->getGet("cords") ?? false;

   
        $data = [
            "weather"=>$forecast,
            "location"=> $location,
            "observedWeather" =>$observedWeather
        ];

        $msg = [
            "msg" => $request->getGet("msg") ?? false
        ];
 
        
        $page->add("weather/index", $msg);
        
        if($cords != "false" && $cords){
            $getCords = explode(",", $cords);
            $cords = 
            [
            "lat"=> $getCords[0],
            "long"=>$getCords[1]
            ];
            $page->add("weather/weatherData", $data);
            $page->add("weather/map",$cords);
        }

        return $page->render([  
            "title" => "Weather",
        ]);
    }




    public function ipadressActionPost() : string {

        $response = $this->di->get("response");
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $validate = $this->di->get("validate");

        
        $weatherHandler = new WeatherHandler();
        $geoMap = new GeoMap();
        $storage = new Storage();

        $ipa = $request->getPost("ipadress");

        $valid = $validate->validateIpAdress($ipa);
        $cords;
        $weather;

        
       
        if($valid){
            $cords = json_decode($geoMap->get($ipa));
            if($cords){
                $weather = $weatherHandler->getDailyForecast($cords->latitude,$cords->longitude);
                
                $observedWeather = $weatherHandler->getObservedWeather($cords->latitude,$cords->longitude);
      
                if($weather && $observedWeather){
                    //             Data , (key) , saving method (temp)
                    $weather = $weatherHandler->formatDailyForecast($weather->daily->data);
                
                    $observedWeather = $weatherHandler->formatPreviusWeatherData($observedWeather);
                    $storage->saveForecast($weather, "forecast", $session);
                    $storage->saveForeCast($observedWeather, "observedWeather", $session);
              
                    $storage->saveLocation(
                        [
                        "latitude"=>$cords->latitude,
                        "longitude"=>$cords->longitude
                        ],
                        "location",
                        $session
                    );

                    return $response->redirect("weather?cords=$cords->latitude,$cords->longitude");
            }
                else{
                    return $response->redirect("weather?cords=false&msg=Failed to get weather data");
                }
            }else{
                return $response->redirect("weather?cords=false&msg=Failed to get cordinates");
            }
        }else{
            return $response->redirect("weather?cords=false&msg=Ip adress not valid.");
        }

       
        return $response->redirect("weather?cords=false");

    }





}

