<?php
namespace Tabster\Application;

use Tabster\Application\Acl\Acl;
use Tabster\Application\Auth\Auth;
use Tabster\Application\Config\ConfigCollection;
use Tabster\Application\Cookie\Cookie;
use Tabster\Application\Database\Database;
use Tabster\Application\Session\Session;
use Tabster\Application\View\View;
use Tabster\Controllers;
use Tabster\Models\Users;
use \AltoRouter as Router;

class Application {

    private $auth;
    private $acl;
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
        $this->router = new Router($this->config->routes->getConfig());
        $this->auth = new Auth($this->database, $this->session, $this->cookie);
        $this->user = $this->auth->getCurrentUser();
        $this->acl = new Acl($this->database);
        $this->view = new View($this->config->view);

        $this->session->auth = [
            'id' => $this->user->id,
            'banned' => $this->user->banned,
            'suspended' => $this->user->suspended,
            'active' => $this->user->active,
            'role' => $this->user->role
        ];
    }
    
    public function run()
    {
        $match = $this->router->match();
        if($match === false) {
            throw new \Exception('No route found');
        }
        
        list($class, $method) = explode('#', $match['target']);
        
        $class = ucFirst($class) . 'Controller';
        
        $namespace = 'Tabster\\Controllers\\';
                
        if(class_exists($namespace . $class)) {
            if(method_exists($namespace . $class, $method)) {
                $this->view = new View($this->config->view, $match);
                $callable = $namespace . $class;
                $controller = new $callable($this->config, $this->database, $this->session, $this->router, $this->user, $this->view, $match);
                $controller->$method();
            } else {
                throw new \Exception(sprintf('Action %s does not exist.', $method));
            }
        } else {
            throw new \Exception(sprintf('Controller %s does not exist.', $class));
        }     
        
    }
    
     
}
