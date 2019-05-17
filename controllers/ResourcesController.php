<?php 

namespace App\Controllers;

use App\Core\Request;
use App\Core\App;

class ResourcesController
{

  public function index(){
    echo "Api ready";
  }

  public function getResource()
  {
    $resource = Request::getResourceName();
    $id = Request::getResourceId() ?? 0;
    $isNestedResource = Request::isNestedResource();

    if ($isNestedResource) {
      $parent = Request::getParent();
      $parentId = Request::getParentId();

      if ($id > 0) {
        $resources = App::get("database")->getResourceById($resource, $id);
      } else {
        $resources = App::get("database")->getResourceChildData($resource, $parent, $parentId);
      }

    } else {
      if ($id > 0) {
        $resources = App::get("database")->getResourceById($resource, $id);
      } else {
        $resources = App::get("database")->getResourceData($resource);
      }
    }

    if ($resources) {
      echo json_encode($resources);
    } else {
      echo "No data available";
    }
  }

  public function postResource()
  {
    $resource = Request::getResourceName();
    $isNestedResource = Request::isNestedResource();

    if ($isNestedResource) {
      $parent = Request::getParent();
      $parentId = Request::getParentId();
      $resource = App::get("database")->saveResourceChild($resource, $parent, $parentId);
    } else {
      $resource = App::get("database")->saveResource($resource);
    }

    if ($resource) {
      echo json_encode($resource);
    } else {
      http_response_code(404);
    }
  }

  public function putResource()
  {
    $resource = Request::getResourceName();
    $isNestedResource = Request::isNestedResource();
    $id = Request::getResourceId() ?? 0;
    $resource = App::get("database")->updateResource($resource, $id);

    if ($resource) {
      echo json_encode($resource);
    } else {
      http_response_code(404);
    }
  }

  public function deleteResource()
  {
    $resource = Request::getResourceName();
    $id = Request::getResourceId() ?? 0;
    $resource = App::get("database")->deleteResource($resource, $id);

    if ($resource) {
      http_response_code(200);
    } else {
      http_response_code(404);
    }
  }

}