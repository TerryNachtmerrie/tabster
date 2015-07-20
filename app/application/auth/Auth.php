<?php
namespace Tabster\Application\Auth;

use Tabster\Application\Cookie\Cookie;
use Tabster\Application\Database\Database;
use Tabster\Application\Session\Session;
use Tabster\Models\Users;

class Auth {
    private $database;
    private $session;
    private $cookie;

    public function __construct(Database $database, Session $session, Cookie $cookie)
    {
        $this->database = $database;
        $this->session = $session;
        $this->cookie = $cookie;
    }

    public function getCurrentUser()
    {
        $user = new Users();
        if($this->session->has('auth')) {
            if($this->session->auth['role'] === 0) {
                $user->setDefaultValues();
            }
        } elseif($this->cookie->has('auth')) {
            echo 'has cookie auth, create user from cookie info.';
            var_dump($this->cookie->auth);
        } else {
            $user->setDefaultValues();
        }
        return $user;
    }
}
