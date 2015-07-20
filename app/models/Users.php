<?php
namespace Tabster\Models;

use Tabster\Application\Model\Model;
use Tabster\Library\Tools;

class Users extends Model{
    public $id;
    public $email;
    public $password;
    public $salt;
    public $banned;
    public $suspended;
    public $active;
    public $created;
    public $role;

    protected $_blockFromInsert;
    protected $_columns;
    protected $_defaults;
    protected $_table;

    public function __construct()
    {
        $this->_blockFromInsert = ['id'];

        $this->_columns = [
            'id',
            'email',
            'password',
            'salt',
            'banned',
            'suspended',
            'active',
            'created',
            'role'
        ];

        $this->_defaults = [
            'banned'    => 0,
            'suspended' => 0,
            'active'    => 1,
            'created'   => Tools::getMysqlDateTimeString(new \DateTime()),
            'role'      => 1
        ];

        $this->_table = 'users';
    }

    public function setDefaultValues()
    {
        $this->id = 0;
        $this->banned = false;
        $this->suspended = false;
        $this->active = true;
        $this->role = 0;
    }

}
