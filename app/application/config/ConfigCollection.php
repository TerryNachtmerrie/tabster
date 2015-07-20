<?php
namespace Tabster\Application\Config;

use Tabster\Application\Config\Config;

class ConfigCollection {
    private $configs = [];

    public function addConfig(Config $config)
    {
        $this->configs[$config->getName()] = $config;
    }

    public function getConfig($name)
    {
        if(!isset($this->configs[$name])) {
            throw new \Exception('No config found with name: ' . $name);
        }
        return $this->configs[$name];
    }

    public function __get($name)
    {
        if(!isset($this->configs[$name])) {
            throw new \Exception('No config found with name: ' . $name);
        }
        return $this->configs[$name];
    }

    public function changeSettings($name, $values)
    {
        if(!isset($this->configs[$name])) {
            throw new \Exception('No config found with name: ' . $name);
        }
        $this->configs[$name]->changeSettings($values);
    }

    public function addSettings($name, $values)
    {
        if(!isset($this->configs[$name])) {
            throw new \Exception('No config found with name: ' . $name);
        }
        $this->configs[$name]->addSettings($values);
    }
}
