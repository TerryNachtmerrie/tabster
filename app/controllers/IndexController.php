<?php
namespace Tabster\Controllers;

use Tabster\Application\Controller\ControllerBase;

class IndexController extends ControllerBase
{
	public function index()
	{
		$this->view->render();
	}
}