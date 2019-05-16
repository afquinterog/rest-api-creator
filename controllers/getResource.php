<?php
$resource = Request::getResourceName();
$id = Request::getResourceId() ?? 0;
$isNestedResource = Request::isNestedResource();

if( $isNestedResource){
  $parent = Request::getParent();
  $parentId = Request::getParentId();
  
  if($id > 0){
    $resources =  App::get("database")->getResourceById($resource, $id);
  }
  else{
    $resources =  App::get("database")->getResourceChildData($resource, $parent, $parentId );
  }

}else{
  if($id > 0){
    $resources =  App::get("database")->getResourceById($resource, $id);
  }
  else{
    $resources =  App::get("database")->getResourceData($resource );
  }
}

if($resources){
  echo json_encode($resources);
}
else{
  echo "No data available";
}