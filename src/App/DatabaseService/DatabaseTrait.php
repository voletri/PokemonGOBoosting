<?php
namespace App\DatabaseService;

trait DatabaseTrait{
    /**
     * @param $tableName
     * @param $columnsToUpdate
     * @return Database
     */
    public function Update($tableName, $columnsToUpdate){
        return $this['database']->Update($tableName,$columnsToUpdate);
    }

    /**
     * @param $conditionColumns
     * @return Database
     */
    public function WhereEquals($conditionColumns){
        return $this['database']->WhereEquals($conditionColumns);
    }

    /**
     * @param $columns
     * @return Database
     */
    public function IsNull($columns){
        return $this['database']->IsNull($columns);
    }

    /**
     * @param $columns
     * @return Database
     */
    public function IsNotNull($columns){
        return $this['database']->IsNotNull($columns);
    }

    /**
     * @param bool $all
     * @return Database
     */
    public function Union($all=true){
        return $this['database']->Union($all);
    }

    /**
     * @param $tableName
     * @param $valuesToInert
     * @return Database
     */
    public function Insert($tableName, $valuesToInert){
        return $this['database']->Insert($tableName, $valuesToInert);
    }

    /**
     * @param $from
     * @param null $columns
     * @return Database
     */
    public function Select($from, $columns = null){
        return $this['database']->Select($from, $columns);
    }

    /**
     * @param $tableName
     * @param $columnName
     * @param null $relation
     * @return Database
     */
    public function Join($tableName, $columnName, $relation = null){
        return $this['database']->Join($tableName, $columnName, $relation);
    }

    /**
     * @param $columnName
     * @param $direction
     * @return Database
     */
    public function OrderBy($columnName, $direction){
        return $this['database']->OrderBy($columnName, $direction);
    }

    /**
     * @param $from
     * @param $limit
     * @return Database
     */
    public function Limit($from, $limit){
        return $this['database']->Limit($from, $limit);
    }

    /**
     * @param $column
     * @return Database
     */
    public function OnDuplicateKeyUpdate($column){
        return $this['database']->OnDuplicateKeyUpdate($column);
    }

    /**
     * @return string
     */
    public function GetQuery(){
        return $this['database']->GetQuery();
    }

    /**
     * @return mixed
     */
    public function ExecuteScalar(){
        return $this['database']->ExecuteScalar();
    }
    public function FetchAll(){
        return $this['database']->FetchAll();
    }
    public function FetchAssoc(){
        return $this['database']->FetchAssoc();
    }
    public function ExecuteQuery(){
        return $this['database']->ExecuteQuery();
    }
}