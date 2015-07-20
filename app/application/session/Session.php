<?php
namespace Tabster\Application\Session;

class Session {

    public function __construct($session_name)
    {
        if(ini_set('session.use_only_cookies', 1) === false) {
            throw new \Exception('Could not start safe session.');
        }
        if(!is_string($session_name)) {
            throw new \Exception('Session name should be a string. ' . gettype($session_name) . ' given.');
        }

        $cookieParams = session_get_cookie_params();
        session_name($session_name);
        session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], false, true);
        $this->start();
        if(!$this->has('auth')) {
            $this->regenerate_id();
        }
    }

    public function regenerate_id()
    {
        return session_regenerate_id();
    }

    public function start()
    {
        return session_start();
    }

    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function __get($name)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public function destroy()
    {
        return session_destroy();
    }

    public function has($name)
    {
        return isset($_SESSION[$name]);
    }

    public function reset()
    {
        session_reset();
    }

    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

}
