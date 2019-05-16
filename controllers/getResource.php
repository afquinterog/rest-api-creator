<?php
$resource = Request::getResourceName();
$id = Request::getResourceId() ?? 0;
$isNestedResource = Request::isNestedResource();
$database = App::get("database");

if( $isNestedResource){
  $parent = Request::getParent();
  $parentId = Request::getParentId();
  
  if($id > 0){
    $resources = $database->getResourceById($resource, $id);
  }
  else{
    $resources = $database->getResourceChildData($resource, $parent, $parentId );
  }

}else{
  if($id > 0){
    $resources = $database->getResourceById($resource, $id);
  }
  else{
    $resources = $database->getResourceData($resource );
  }
}

if($resources){
  echo json_encode($resources);
}
else{
  echo "No data available";
}