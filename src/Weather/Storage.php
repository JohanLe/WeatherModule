<?php

namespace Anax\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class Storage implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @param Array to save, key (optional))
     */
    public function saveForecast($data, $key = false, $session){
        //$session = $this->di->get("session");
        $session->set($key, $data);
    }
    
    /**
     * @param Data to save, key (optional)
     */
    public function saveLocation($data, $key = false, $session){
        //$session = $this->di->get("session");

        $session->set($key, $data);
    }

    /**
     * @param String - Key name to gather
     * @return Array - Returns array
     */
    public function getForecast($key = "forecast"){
        $session = $this->di->get("session");
        $data = $session->get($key);
        return $data;
    }

        /**
     * @param String - Key name to gather
     * @return Array - Returns array
     */
    public function getLocation($key = "forecast"){
        $session = $this->di->get("session");
        $data = $session->get($key);
        return $data;
    }

}