<?php
$resource = Request::getResourceName();
$id = Request::getResourceId() ?? 0;
$isNestedResource = Request::isNestedResource();

if( $isNestedResource){
  $parent = Request::getParent();
  $parentId = Request::getParentId();
  
  if($id > 0){
    $resources = $app['database']->getResourceById($resource, $id);
  }
  else{
    $resources = $app['database']->getResourceChildData($resource, $parent, $parentId );
  }

}else{
  if($id > 0){
    $resources = $app['database']->getResourceById($resource, $id);
  }
  else{
    $resources = $app['database']->getResourceData($resource );
  }
}

if($resources){
  echo json_encode($resources);
}
else{
  http_response_code(404);
}