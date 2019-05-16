<?php
$app = [];
$app['config'] = require 'config.php';
$app['resources'] = require 'resources.php';
require 'core/Router.php';
require 'core/Request.php';
require 'core/database/Connection.php';
require 'core/database/QueryBuilder.php';

$app['database'] = new QueryBuilder(
  Connection::make($app['config']['database']),
  $app['resources'],
  Request::putParameters()
);