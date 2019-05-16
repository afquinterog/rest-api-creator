<?php
$app = [];

App::bind('config', require 'config.php' );
App::bind('resources', require 'resources.php' );


App::bind('database', new QueryBuilder(
  Connection::make(App::get('config')['database']),
  App::get('resources'),
  Request::putParameters()
  ) 
);