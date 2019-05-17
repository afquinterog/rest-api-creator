<?php

namespace App\Core\Database;

use App\Core\App;
use App\Core\Request;
/**
 * Abstract sql queries from the application
 */
class QueryBuilder
{
  protected $pdo;

  protected $resources;

  protected $put;

  public function __construct($pdo, $resources, $put)
  {
    $this->pdo = $pdo;

    $this->resources = $resources;

    $this->put = $put;
  }

  public function getResourceData($table)
  {
    $filtered = [];
    $params = Request::queryString();

    $filter = $params['filter'] ?? "";

    $relations = App::get('resources')[$table]['hasMany'];
    
    $statement = $this->pdo->prepare("select * from {$table}");

    $statement->execute();

    $data = $statement->fetchAll(\PDO::FETCH_CLASS);

    foreach($data as $item){
      foreach( $relations as $relation){
        $childs = $this->getResourceChildData($relation, $table, $item->id);
        $item->$relation = $childs;
      }
    }

    if($filter){
      foreach($data as $item){
        $encoded = json_encode($item);
        if(strpos($encoded, $filter)){
          $filtered[] = $item;
        }
      }
    }else{
      $filtered = $data;
    } 
  
    return $filtered;
  }

  public function getResourceChildData($table, $parent, $parentId)
  {
    $parent = Inflect::singularize($parent);

    $statement = $this->pdo->prepare("select * from {$table} where {$parent}_id={$parentId}");

    $statement->execute();

    return $statement->fetchAll(\PDO::FETCH_CLASS);
  }

  public function getResourceById($table, $id)
  {
    $statement = $this->pdo->prepare("select * from {$table} where id={$id}");

    $statement->execute();

    $mainData = $statement->fetchAll(\PDO::FETCH_CLASS);

    return $mainData;
  }

  public function saveResource($table)
  {
    $attributes = $this->resources[$table]['attributes'];

    $attributesInsert = implode(",", $attributes);

    $attributesBind = ':' . implode(", :", $attributes);

    $statement = $this->pdo->prepare("INSERT INTO {$table} ({$attributesInsert})
      VALUES ({$attributesBind})");

    foreach ($attributes as $attribute) {
      $statement->bindParam(":{$attribute}", $_POST[$attribute]);
    }

    $statement->execute();

    return $this->getResourceById($table, $this->pdo->lastInsertId());

  }

  public function saveResourceChild($table, $parent, $parentId)
  {
    $parent = Inflect::singularize($parent) . "_id";

    $attributes = $this->resources[$table]['attributes'];

    $attributesInsert = implode(",", $attributes) . ",{$parent}";

    $attributesBind = ':' . implode(", :", $attributes) . ",:{$parent}";

    $statement = $this->pdo->prepare("INSERT INTO {$table} ({$attributesInsert})
      VALUES ({$attributesBind})");

    foreach ($attributes as $attribute) {
      $statement->bindParam(":{$attribute}", $_POST[$attribute]);
    }

    $statement->bindParam(":{$parent}", $parentId);

    $statement->execute();

    return $this->getResourceById($table, $this->pdo->lastInsertId());

  }

  public function updateResource($table, $id)
  {

    $attributes = $this->resources[$table]['attributes'];

    foreach ($attributes as $attribute) {
      if ($this->put[$attribute]) {
        $setAttributes .= "{$attribute}=:{$attribute},";
      }
    }

    $setAttributes = rtrim($setAttributes, ',');

    $statement = $this->pdo->prepare("UPDATE {$table} SET {$setAttributes} WHERE id=:id");

    foreach ($attributes as $attribute) {
      if ($this->put[$attribute]) {
        $statement->bindParam(":{$attribute}", $this->put[$attribute]);
      }
    }
    $statement->bindParam(":id", $id);

    $statement->execute();

    return $this->getResourceById($table, $id);
  }

  public function deleteResource($table, $id)
  {
    try {
      $statement = $this->pdo->prepare("DELETE FROM {$table} WHERE id=:id");

      $statement->bindParam(":id", $id);

      $statement->execute();

      return $statement->rowCount() > 0;

    } catch (Exception $exception) {

      return false;

    }

  }

}