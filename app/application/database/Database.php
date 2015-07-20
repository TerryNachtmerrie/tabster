<?php
namespace Tabster\Application\Database;

use Tabster\Application\Config\Config;
use Tabster\Application\Model\Model;
use PDO;
use FluentPDO;

class Database {
    private $PDO;
    private $FPDO;

    public function __construct(Config $config)
    {
        $dsn = sprintf('%s:host=%s;dbname=%s;charset=%s', $config->type, $config->hostname, $config->database, $config->charset);
        $this->PDO = new PDO($dsn, $config->username, $config->password);
        $this->FPDO = new FluentPDO($this->PDO);
    }

    public function beginTransaction() {
        $this->PDO->beginTransaction();
    }

    public function rollBack() {
        $this->PDO->rollBack();
    }

    public function commit() {
        $this->PDO->commit();
    }

    public function insert(Model $model) {
        $insertables = [];
        $columns = [];

        foreach($model->getColumns() as $column) {
            if(in_array($column, $model->getBlockedFromInsert())) continue;

            if(isset($model->defaults[$column]) && empty($model->$column)) {
                $model->$column = $model->defaults[$column];
            }

            $insertables[$column] = $model->$column;
            $columns[$column] = $column;
        }

        $query_columns = join(', ', $columns);
        $query_values  = ':' . join(', :', $columns);

        $stmt = $this->PDO->prepare('INSERT INTO ' . $model->getTable() . ' (' . $queryColumns . ') VALUES (' . $queryValues . ')');

        foreach($insertables as $column => $value) {
            $stmt->bindValue(':' . $column, $value);
        }

        return $stmt->execute();
    }

    private function select() {

    }

}
