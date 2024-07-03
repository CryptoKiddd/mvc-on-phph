<?php

require_once __DIR__.'/vendor/autoload.php';
use app\core\Application;

$app = new Application();

$app->router->get('/', function(){
  echo 'index page';
});
$app->router->get('/users', function(){
  echo 'users page';
});

$app->run();