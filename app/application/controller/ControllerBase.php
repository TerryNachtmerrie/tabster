<?php
namespace Tabster\Application\Controller;

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

class ControllerBase
{
	public $config;
	public $database;
	public $session;
	public $router;
	public $user;
	public $view;
	public $match;
	
	public function __construct(ConfigCollection $config, Database $database, Session $session, Router $router, Users $user, View $view, $match = '')
	{
		$this->config = $config;
		$this->database = $database;
		$this->session = $session;
		$this->router = $router;
		$this->user = $user;
		$this->view = $view;
		$this->view->setTemplate(str_replace('#', '/', $match['target']));
	}
}
	