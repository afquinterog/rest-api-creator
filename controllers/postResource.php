<?php
$resource = Request::getResourceName();
$isNestedResource = Request::isNestedResource();

if($isNestedResource){
  $parent = Request::getParent();
  $parentId = Request::getParentId();
  $resource = $app['database']->saveResourceChild($resource, $parent, $parentId);
}else{
  $resource = $app['database']->saveResource($resource);  
}

if($resource){
  echo  json_encode($resource);
}
else{
  http_response_code(404);
}