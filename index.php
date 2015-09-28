<?php
require_once('autoload.php');

use Pimp\Pimp;

$app = new Pimp();

//Setting up routes
$app->get('/address/:id', 'Project\Controller\Address:getAction');
$app->post('/address', 'Project\Controller\Address:postAction');
$app->put('/address/:id', 'Project\Controller\Address:putAction');
$app->delete('/address/:id', 'Project\Controller\Address:deleteAction');

$app->run();
?>
