<?php
namespace Tabster\Application\Acl;

use Tabster\Application\Database\Database;

class Acl {
	private $db;
	
	public function __construct(Database $database)
	{
		$this->db  = $database;
	}
}