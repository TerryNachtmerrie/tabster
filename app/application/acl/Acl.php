<?php
namespace Tabster\Application\Acl;

use Tabster\Application\Database;

class Acl {
	private $db;
	
	private function __construct(Database $database)
	{
		$this->db  = $database;
	}
}