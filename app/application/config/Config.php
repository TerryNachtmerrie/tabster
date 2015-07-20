<?php
namespace Tabster\Application\Config;

class Config {
    private $name   = '';
    private $config = [];

    const CONFIG_ARRAY = 1;
    const CONFIG_JSON  = 2;
    const CONFIG_INI   = 3;
    const CONFIG_EMPTY = 4;

    public function __construct($filename = false, $configType = self::CONFIG_ARRAY)
    {
        if($filename) {
            switch($configType) {
                case static::CONFIG_ARRAY:
                    $this->loadArray($filename);
                    break;
                case static::CONFIG_JSON:
                    $this->loadJson($filename);
                    break;
                case static::CONFIG_INI:
                    $this->loadIni($filename);
                    break;
                case static::CONFIG_EMPTY:
                    $this->name = $filename;
                default:
                    return;
                    break;
            }
        } else {

        }
    }

    public function __get($name)
    {
        if(!isset($this->config[$name])) {
            throw new \Exception('Index ' . $name . ' has not been set.');
        }
        return $this->config[$name];
    }

    private function loadArray($filename)
    {
        if(file_exists($filename)) {
            $config = require $filename;
            $this->name = $config['name'];
            $this->config = $config['config'];
        } else {
            throw new \Exception($filename . ' does not exist.');
        }
    }

    private function loadJson($filename)
    {
        if(file_exists($filename)) {
            $json = file_get_contents($filename);
            $config = json_decode($json, true);
            $this->name = $config['name'];
            $this->config = $config['config'];
        } else {
            throw new \Exception($filename . ' does not exist.');
        }
    }

    private function loadIni($filename)
    {
        if(file_exists($filename)) {
            $config = parse_ini_file($filename);
            $this->name = $config['name'];
            $this->config = $config['config'];
        } else {
            throw new \Exception($filename . ' does noet exist.');
        }
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getName()
    {
        return $this->name;
    }

    public function changeSetting($values)
    {
        if(!is_array($values)) {
            throw new \Exception('changeSettings expects argument to be of type Array. ' . gettype($values) . ' was given.');
        }
        foreach($values as $index => $value) {
            if(!isset($this->config[$index])) {
                throw new \Exception('Unknown setting ' . $index . '. Use addSetting to add new settings');
            }
            $this->config[$index] = $value;
        }
    }

    public function addSettings($values)
    {
        if(!is_array($values)) {
            throw new \Exception('addSettings expects argument to be of type Array. ' . gettype($values) . ' was given.');
        }
        foreach($values as $index => $value) {
            if(isset($this->config[$index])) {
                throw new \Exception($index . ' has already been set. Use changeSettings to change settings.');
            }
            $this->config[$index] = $value;
        }

    }

}
