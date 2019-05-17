<?php
$router->addGetRoute('', 'ResourcesController@index');

$router->addResource('contacts');
$router->addResource('emails');
$router->addResource('phones');

//Add resources here for new tables on the system