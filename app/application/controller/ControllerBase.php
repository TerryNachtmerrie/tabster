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
	private $config;
	private $database;
	private $session;
	private $router;
	private $user;
	private $view;
	
	public function __construct(ConfigCollection $config, Database $database, Session $session, Router $router, Users $user, View $view)
	{
		$this->config = $config;
		$this->database = $database;
		$this->session = $session;
		$this->router = $router;
		$this->user = $user;
		$this->view = $view;
	}
}
	