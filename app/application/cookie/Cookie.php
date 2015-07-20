<?php
namespace Tabster\Application\Cookie;

use Tabster\Application\Config\Config;
use Crypto;


class Cookie {

    const DAY      =    86400;
    const WEEK     =   604800;
    const MONTH    =  2592000;
    const YEAR     = 31536000;

    private $cookies;
    private $config;

    public function __construct(Config $config) {
        $this->config = $config;

        foreach($_COOKIE as $index => $value) {
            if($index == 'TabsterSession') {
                continue;
            }
            $value = hex2bin($value);
            $value = Crypto::Decrypt($value, $this->config->key);
            $value = unserialize($value);
            $this->cookies[$index] = $value;
        }
    }

    public function get($index) {
        return isset($this->cookies[$index]) ? $this->cookies[$index] : null;
    }

    public function getAll() {
        return $this->cookies;
    }

    public function has($index) {
        return isset($this->cookies[$index]);
    }

    public function isempty($index) {
        return isset($this->cookies[$index]) ? empty($this->cookies[$index]) : null;
    }

    public function set($name, $value = null) {

        $cookie_value = serialize($value);
        $cookie_value = Crypto::Encrypt($cookie_value, $this->config->key);
        $cookie_value = bin2hex($cookie_value);

        if(setcookie(
            $name,
            $cookie_value,
            time() + $this->config->expire,
            $this->config->path,
            $this->config->domain,
            $this->config->secure,
            $this->config->httponly
        )) {
            $this->cookies[$name] = $value;
            return true;
        } else {
            return false;
        }
    }

    public function delete($name) {
        if(setcookie(
            $name,
            '',
            time() - self::DAY,
            $this->config->path,
            $this->config->domain,
            $this->config->secure,
            $this->config->httponly
        )) {
            unset($this->cookies[$name]);
        } else {
            return false;
        }
    }
}
