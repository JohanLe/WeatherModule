<?php 

namespace Anax\Weather;

// Api key a4a9e6e55eec168b4fb53d89f3ebbaf5
// example : http://api.ipstack.com/213.112.139.9?access_key=a4a9e6e55eec168b4fb53d89f3ebbaf5
class GeoMap {

    public $accessKey = "a4a9e6e55eec168b4fb53d89f3ebbaf5";
    public $geoUrl = "http://api.ipstack.com/";


    /**
     *  @return $geoResult - string formated as json
     * 
     */
public function get($ipa, $filter = null){

    if($filter){
        $geoResult = file_get_contents($this->geoUrl . $ipa . "?access_key=". $this->accessKey ."&output=json&fields=".$filter);
    }
    else {
        $geoResult = file_get_contents($this->geoUrl . $ipa . "?access_key=". $this->accessKey ."&output=json");
    }
 
    return $geoResult;
}   

/**
 * @param $filter a string with fields to be retreived.
 * e.g "ip,country_code,type,longitude"
 * @return $userData as array
 */
public function getUserData($filter = null){
    if($filter){
        $userData = file_get_contents("http://api.ipstack.com/check?access_key=" . $this->accessKey . "&output=json&fields=".$filter);
    }
    else {
        $userData = file_get_contents("http://api.ipstack.com/check?access_key=" . $this->accessKey . "&output=json");
    }
    $userData = json_decode($userData);
    if(array_key_exists("error" ,$userData)){
        return false;
    }
    return $userData;
}





}