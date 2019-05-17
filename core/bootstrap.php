<?php

use App\Core\App;
use App\Core\Database\QueryBuilder;
use App\Core\Database\Connection;
use App\Core\Request;

App::bind('config', require 'config.php' );
App::bind('resources', require 'resources.php' );


App::bind('database', new QueryBuilder(
  Connection::make(App::get('config')['database']),
  App::get('resources'),
  Request::putParameters()
  ) 
);