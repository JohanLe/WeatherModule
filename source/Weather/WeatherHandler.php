<?php 

namespace Anax\Weather;

class WeatherHandler {
    public $url = "https://api.darksky.net/forecast/26ef698985dfe0ef5692b30380a51e04/";

    /**
     * Multicurl
     */
    public function getObservedWeather($latitude = 56.67446, $longitude = 12.85676){
  
        /* TODO: 
        -  Multi curl anrop. Kolla in time machine request från darksky.
        -  Leverera resultatet till view och api.
        */
        $baseUrl = "https://api.darksky.net/forecast/26ef698985dfe0ef5692b30380a51e04/";
        $latLong = "$latitude,$longitude";
        $dates = $this->getPreviusThirtyDays(time());
        $settings = "?units=si&exclude=[hourly,minutely,alerts,daily,flags]";
        $testUrl = "https://api.darksky.net/forecast/26ef698985dfe0ef5692b30380a51e04/42.3601,-71.0589,255657600?exclude=currently,flags";
        
        $mh = curl_multi_init();
        $chAll = [];


        foreach($dates as $day){
            $ch = curl_init($baseUrl.$latLong.",$day".$settings);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($mh, $ch);
            $chAll[] = $ch;
        }
   
        $running = null;
        do {
          curl_multi_exec($mh, $running);
        } while ($running);
        
        foreach($chAll as $ch){
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);
       
        $result = [];
        foreach($chAll as $ch){
            $data = curl_multi_getcontent($ch);
            $result[] = $data;
        }

        if(array_key_exists("error", $result)){
            // Returnera variabel med felmeddelande.
            return false;
        }
        return $result;
    }

    public function getDailyForecast($latitude, $longitude) {
        $settings = "?units=si&exclude=[hourly,minutely,alerts,flags]";
        $params = "$latitude,$longitude";

        $cUrl = curl_init();

        curl_setopt($cUrl, CURLOPT_URL, $this->url . $params . $settings);
        curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($cUrl);
        curl_close($cUrl);

        $result = json_decode($result);
        if(array_key_exists("error", $result)){
            // Returnera variabel med felmeddelande.
            return false;
        }
        return $result;
    }

    public function formatDailyForecast($data){
        $formated = [];
        $index = 0;
        $day = "";
        foreach ($data as $value){
            if($index == 0){
                $day = "Today";
            }elseif ($index == 1){
                $day = "Tomorrow";
            }else {
                $day = date("D", $value->time);
            }
            
            $forcast = [
                "day" => $day,
                "date" => date("d M", $value->time),
                "summary" => $value->summary,
                "temperatureHigh" => round($value->temperatureHigh, 1),
                "temperatureLow" => round($value->temperatureLow, 1),
                "windSpeed"=> $value->windSpeed
            ];
            array_push($formated, $forcast);
            $index ++;
        } 
        
        return $formated;
    }
    
    public function formatPreviusWeatherData($data){
        $formated = [];
  
        
        foreach ($data as $value){
            $value = json_decode($value);
            $currently = $value->currently;  
            $forcast = [
                "date" => date("d M", $currently->time),
                "summary" => $currently->summary,
                "temperature" => round($currently->temperature, 1),
                "windSpeed" => $currently->windSpeed,
                "cloudCover" => $currently->cloudCover
            ];
            array_push($formated, $forcast);
        } 
        
        return $formated;
    }

    /**
     * @param INT - unix timestamp
     * Returns array of unix time stamps of 30 days prior to $date
     * @return Array[int]
     */
    public function getPreviusThirtyDays($date){
        $previusDays = [];
        $current = $date;
        for($i=0; $i<30; $i++){
            array_push($previusDays, $current);
            $current -= 86400;
        }
        return $previusDays;
    }

}