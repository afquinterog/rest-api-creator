<?php

/**
 * Basic http router implementation
 */
class Router
{
  protected $getRoutes = [];
  protected $postRoutes = [];
  protected $putRoutes = [];
  protected $deleteRoutes = [];

  protected $routesLink = [
    'GET' => 'getRoutes', 'POST' => 'postRoutes',
    'PUT' => 'putRoutes', 'DELETE' => 'deleteRoutes'
  ];


  public static function load($file)
  {
    $router = new static;

    require $file;
    
    return $router;
  }

  public function addResource($name)
  {
    $this->addGetRoute($name, 'controllers/getResource.php');
    $this->addPostRoute($name, 'controllers/postResource.php');
    $this->addPutRoute($name, 'controllers/putResource.php');
    $this->addDeleteRoute($name, 'controllers/deleteResource.php');
  }

  public function addGetRoute($route, $controller)
  {
    $this->getRoutes[$route] = $controller;
  }

  public function addPostRoute($route, $controller)
  {
    $this->postRoutes[$route] = $controller;
  }

  public function addPutRoute($route, $controller)
  {
    $this->putRoutes[$route] = $controller;
  }

  public function addDeleteRoute($route, $controller)
  {
    $this->deleteRoutes[$route] = $controller;
  }


  public function direct($uri)
  {
    $actualRoutes = $this->routesLink[Request::method()];

    if (array_key_exists($uri, $this->$actualRoutes)) {
      return $this->$actualRoutes[$uri];
    }

    throw new Exception('No route defined for this URI.');
  }


}