<?php
$resource = Request::getResourceName();
$id = Request::getResourceId() ?? 0;
$resource = App::get("database")->deleteResource($resource, $id);  

if($resource){
  http_response_code(200);
}
else{
  http_response_code(404);
}
