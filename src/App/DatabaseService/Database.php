<?php

namespace App\DatabaseService;

use PDO;
use PDOException;
use Exception;

class Database {
    private $pdo;
    private $statement = null;
    private $params = array();
    private $from = null;
    const logDir = __DIR__ . '/../../../logs';
    const logFile = '/Database.log';

    /**
     * SBoostRepository constructor.
     * @param array $options
     */
    public function __construct($options) {
        $username = (array_key_exists('username',$options)?$options['username']:null);
        $password =(array_key_exists('password',$options)?$options['password']:null);
        $host = (array_key_exists('host',$options)?$options['host']:null);
        $dbname = (array_key_exists('dbname',$options)?$options['dbname']:null);
        $this->pdo = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
    }

    /**Form $columnsToUpdate like this
     * array(
     *  'column0'=>value0,
     *  'column1'=>value1,
     *  .
     *  .
     *  'columnN'=>valueN
     * )
     * @param string $tableName
     * @param array $columnsToUpdate
     * @return Database $this
     */
    public function Update($tableName, $columnsToUpdate) {
        $this->statement .= " UPDATE {$tableName} SET ";
        $index = 0;
        $columnsToUpdateQuantity=count($columnsToUpdate);
        foreach ($columnsToUpdate as $column => $value) {
            if ($index == $columnsToUpdateQuantity - 1) {
                $this->statement .= $column . ' =?';
            } else {
                $this->statement .= $column . ' =?,';
            }
            array_push($this->params, $value);
            $index++;
        }
        return $this;
    }

    /**Form $conditionColumns like this
     * array(
     *  'column0'=>value0,
     *  'column1'=>value1,
     *  .
     *  .
     *  'columnN'=>valueN
     * )
     * @param array $conditionColumns
     * @return Database $this
     */
    public function WhereEquals($conditionColumns) {
        $this->statement .= " WHERE ";
        $index = 0;
        foreach ($conditionColumns as $column => $value) {
            if ($value !== null) {
                array_push($this->params, $value);
            }
            if ($index == 0) {
                $this->statement .= $column . ($value === null ? ' IS NULL' : ' =?');
            } else {
                $this->statement .= ' AND ' . $column . ($value === null ? ' IS NULL' : ' =?');
            }
            $index++;
        }
        return $this;
    }

    /**Form $conditionColumns like this
     * array(
     *  'column0',
     *  'column1',
     *  .
     *  .
     *  'columnN'
     * )
     * @param $columns
     * @return Database $this
     */
    public function IsNull($columns) {
        $this->statement .= " AND ";
        $index = 0;
        $columnsQuantity = count($columns);
        foreach ($columns as $column) {
            if ($index == $columnsQuantity - 1) {
                $this->statement .= " {$column} IS NULL";
            } else {
                $this->statement .= " {$column} IS NULL AND";
            }
            $index++;
        }
        return $this;
    }

    /**Form $columns like this
     * array(
     *  'column0',
     *  'column1',
     *  .
     *  .
     *  'columnN'
     * )
     * @param $columns
     * @return Database $this
     */
    public function IsNotNull($columns) {
        $this->statement .= " AND ";
        $index = 0;
        $columnsQuantity = count($columns);
        foreach ($columns as $column) {
            if ($index == $columnsQuantity - 1) {
                $this->statement .= " {$column} IS NOT NULL";
            } else {
                $this->statement .= " {$column} IS NOT NULL AND";
            }
            $index++;
        }
        return $this;
    }

    /**
     * @param bool $all
     * @return Database $this
     */
    public function Union($all=true) {
        $this->statement .= ' UNION ' . ($all ? '' : 'DISTINCT ');
        return $this;
    }


    /**Form $valuesToInert like this
     * array(
     *  'column0'=>value0,
     *  'column1'=>value1,
     *  .
     *  .
     *  'columnN'=>valueN
     * )
     * @param string $tableName
     * @param $valuesToInert
     * @return Database $this
     */
    public function Insert($tableName, $valuesToInert) {
        $this->statement .= " INSERT INTO {$tableName}(";
        $index = 0;
        $valuesToInertKeysQuantity = count(array_keys($valuesToInert));
        foreach (array_keys($valuesToInert) as $column) {
            if ($index == $valuesToInertKeysQuantity - 1) {
                $this->statement .= "{$column})";
            } else {
                $this->statement .= "{$column}, ";
            }
            $index++;
        }
        $index = 0;
        $this->statement .= ' VALUES(';
        $valuesToInertQuantity = count($valuesToInert);
        foreach ($valuesToInert as $column => $value) {
            array_push($this->params, $value);
            if ($index == $valuesToInertQuantity - 1) {
                $this->statement .= "?)";
            } else {
                $this->statement .= "?, ";
            }
            $index++;
        }
        return $this;
    }

    /**Form $columns like this
     * array(
     *  'column0',
     *  'column1',
     *  .
     *  .
     *  'columnN'
     * )
     * @param array $columns
     * @param string $from
     * @return Database $this
     */
    public function Select($from, $columns = null) {
        $this->statement .= " SELECT ";
        if ($columns == null) {
            $this->statement .= '* ';
        } else {
            $index = 0;
            $columnsQuantity = count($columns);
            foreach ($columns as $column) {
                if ($index == $columnsQuantity - 1) {
                    $this->statement .= " {$column}";
                } else {
                    $this->statement .= " {$column},";
                }
                $index++;
            }
        }
        $this->from = $from;
        $this->statement .= ' FROM ' . $from;
        return $this;
    }

    /**
     * @param string $tableName
     * @param string $columnName
     * @param string|null $relation
     * @return Database $this
     */
    public function Join($tableName, $columnName, $relation = 'LEFT') {
        $this->statement .= " {$relation}" . " JOIN ({$tableName}) ON({$this->from}.{$columnName}={$tableName}.{$columnName})";
        return $this;
    }

    /**
     * @param string $columnName
     * @param string $direction
     * @return Database $this
     */
    public function OrderBy($columnName, $direction='ASC') {
        $this->statement .= " ORDER BY {$columnName} {$direction}";
        return $this;
    }

    /**
     * @param int $from
     * @param int $limit
     * @return Database $this
     */
    public function Limit($from, $limit) {
        $this->statement .= " LIMIT {$from},{$limit}";
        return $this;
    }

    /**
     * @param string $column
     * @return Database $this
     */
    public function OnDuplicateKeyUpdate($column) {
        $this->statement .= " ON DUPLICATE KEY UPDATE {$column}=VALUES({$column})";
        return $this;
    }

    public function GetQuery() {
        $array = str_split($this->statement);
        $index = 0;
        foreach ($array as $key => $char) {
            if ($char == '?') {
                $array[$key] = $this->params[$index];
                $index++;
            }
        }
        return (implode('', $array));
    }
    public function ExecuteScalar(){
        $prepared = $this->pdo->prepare($this->statement);
        $prepared->execute($this->params);
        $this->statement = null;
        $this->params = array();
        $this->from = null;
        return $prepared->fetch(PDO::FETCH_NUM)[0];
    }
    public function FetchAll() {
        $prepared = $this->pdo->prepare($this->statement);
        $prepared->execute($this->params);
        $this->statement = null;
        $this->params = array();
        $this->from = null;
        return $prepared->fetchAll();
    }

    public function FetchAssoc($rowNum=null) {
        $prepared = $this->pdo->prepare($this->statement);
        $prepared->execute($this->params);
        $this->statement = null;
        $this->params = array();
        $this->from = null;
        return $prepared->fetchAll()[($rowNum===null?0:$rowNum)];
    }

    public function ExecuteQuery() {
        $prepared = $this->pdo->prepare($this->statement);
        try {
            $prepared->execute($this->params);
            $affectedRows = $prepared->rowCount();
            self::LogToFile('Statement: ' . self::GetQuery() . ' Executed successfully ' . $affectedRows . ' row(s) affected');
            $this->statement = null;
            $this->params = array();
            $this->from = null;
            return $affectedRows;
        } catch (PDOException $exp) {
            self::LogToFile('Statement: ' . self::GetQuery() . ' Executed with error', $exp);
            $this->statement = null;
            $this->params = array();
            $this->from = null;
            return 0;
        }
    }

    /**
     * @param string $logText
     * @param Exception|null $exp
     */
    private function LogToFile($logText, Exception $exp = null) {
        $log = '[' . date("Y/m/d H:i:s") . '] ';
        if ($exp != null) {
            $log .= " Err code: " . $exp->getCode() . " Message: " . $exp->getMessage();
        }
        $log .= $logText . PHP_EOL;
        if (!file_exists(self::logDir)) {
            mkdir(self::logDir);
        }
        file_put_contents(self::logDir . self::logFile, $log, FILE_APPEND);
    }
}