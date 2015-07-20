<?php
namespace Tabster\Application\Model;

abstract class Model {
    abstract function __construct();

    public function getBlockFromInsert() {
        return (array) $this->_blockFromInsert;
    }

    public function getColumns() {
        return (array) $this->_columns;
    }

    public function getDefaults() {
        return (array) $this->_defaults;
    }

    public function getTable() {
        return (string) $this->_table;
    }

    public function save(Database $db) {
        return $db->insert($this);
    }

    public function getFirstById() {

    }
}
