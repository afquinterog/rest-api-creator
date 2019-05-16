<?php
/**
 * Handles http request information
 */
class Request
{
  public static function uri()
  {
    $uri = $_SERVER['REQUEST_URI'];

    if (strpos($uri, '?')) {
      $uri = explode("?", $uri);
      return trim($uri[0], '/');
    }

    return trim($_SERVER['REQUEST_URI'], '/');
  }

  public function queryString(){
    $uri = $_SERVER['REQUEST_URI'];
    $queryFilters = [];

    if (strpos($uri, '?')) {
      $uri = explode("?", $uri);
      if (strpos($uri[1], '&')) {
        $params  = explode("&", $uri[1]);
        foreach($params as $param){
          $param = explode("=", $param);
          $queryFilters[$param[0]] = $param[1];
        }
      }
      else{
        $param = explode("=", $uri[1]);
        $queryFilters[$param[0]] = $param[1];
        $params  = $uri[1];
      }
      return $queryFilters;
    }
    return "";
  }

  public static function method()
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  public static function getResourceName()
  {
    $tokens = explode("/", Request::uri());

    return $tokens[2] ?? $tokens[0];
  }

  public static function getResourceId()
  {
    $tokens = explode("/", Request::uri());

    if (Request::isNestedResource()) {

      return $tokens[3];

    } else {

      return $tokens[1];

    }
  }

  public static function getParent()
  {
    $tokens = explode("/", Request::uri());

    return $tokens[0];
  }

  public static function getParentId()
  {
    $tokens = explode("/", Request::uri());

    return $tokens[1];
  }

  public static function isNestedResource()
  {
    $tokens = explode("/", Request::uri());

    return count($tokens) >= 3;
  }

  public static function putParameters()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

      parse_str(file_get_contents("php://input"), $_PUT);

      foreach ($_PUT as $key => $value) {
        unset($_PUT[$key]);
        $_PUT[str_replace('amp;', '', $key)] = $value;
      }

      $_REQUEST = array_merge($_REQUEST, $_PUT);
    }

    return $_PUT;
  }




}