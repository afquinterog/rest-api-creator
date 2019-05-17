<?php
// $resource = Request::getResourceName();
// $isNestedResource = Request::isNestedResource();

// if($isNestedResource){
//   $parent = Request::getParent();
//   $parentId = Request::getParentId();
//   $resource = App::get("database")->saveResourceChild($resource, $parent, $parentId);
// }else{
//   $resource = App::get("database")->saveResource($resource);  
// }

// if($resource){
//   echo  json_encode($resource);
// }
// else{
//   http_response_code(404);
// }