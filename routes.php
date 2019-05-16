<?php
$router->addGetRoute('', 'controllers/index.php');

$router->addResource('contacts');

$router->addResource('emails');

$router->addResource('phones');

//Add resources here for new tables on the system