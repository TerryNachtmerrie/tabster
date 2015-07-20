<?php
namespace Tabster\Application;

use Tabster\Application\Auth\Auth;
use Tabster\Application\Config\ConfigCollection;
use Tabster\Application\Cookie\Cookie;
use Tabster\Application\Database\Database;
use Tabster\Application\Session\Session;
use Tabster\Models\Users;
use \AltoRouter as Router;

class Application {

    private $auth;
    private $config;
    private $cookie;
    private $database;
    private $session;
    private $router;
    private $user;

    public function __construct(ConfigCollection $config) {
        $this->config = $config;
        $this->database = new Database($this->config->database);
        $this->session = new Session('TabsterSession');
        $this->cookie = new Cookie($this->config->cookie);
        $this->router = new Router(array(
            array('GET', '/users', 'UsersController#Index', 'users'),
            array('GET', '/', 'IndexController#Index', 'home'),
              /* array('DELETE','/users/[i:id]', 'users#delete', 'delete_user') */
        ));
        $this->auth = new Auth($this->database, $this->session, $this->cookie);
        $this->user = $this->auth->getCurrentUser();

        $this->session->auth = [
            'id' => $this->user->id,
            'banned' => $this->user->banned,
            'suspended' => $this->user->suspended,
            'active' => $this->user->active,
            'role' => $this->user->role
        ];

        var_dump($this->user);
        var_dump($this->session->auth);
    }
}
