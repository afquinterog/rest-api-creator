<?php
$app = [];
$app['config'] = require 'config.php';
$app['resources'] = require 'resources.php';


$app['database'] = new QueryBuilder(
  Connection::make($app['config']['database']),
  $app['resources'],
  Request::putParameters()
);