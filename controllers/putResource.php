<?php
$resource = Request::getResourceName();
$isNestedResource = Request::isNestedResource();
$id = Request::getResourceId() ?? 0;
$resource = $app['database']->updateResource($resource, $id);  

if($resource){
  echo json_encode($resource);
}
else{
  http_response_code(404);
}
