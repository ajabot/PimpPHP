Pimp PHP
==============

I had to "pimp up" the following script, by removing all mistakes and bad practices and create a structure of folder.
As extra, I could add full CRUD feature to it.
The company judged on structure, hierarchy of objects and overall design.

```php
<?php

$path = $_SERVER['PATH_INFO'];

if ($path = '/address')
{
  $controller = new \Controller();
  $return = $controller->ex();
  echo $return;
}

class Controller
{
  var $addresses = [];

  function ex()
  {
    $this->rcd();
    $id = $_GET['id'];
    $address = $this->addresses[$id];
    return json_encode($address);
  }

  function rcd()
  {
    $file = fopen('example.csv', 'r');
    while (($line = fgetcsv($file)) !== FALSE) {
        $this->addresses[] = [
            "name" => $line[0],
            "phone" => $line[1],
            "street" => $line[2]
        ];
    }

    fclose($file);
  }
}
?>
```

Pimp Application
----------------

To Instanciate application:

require_once('autoload.php');
$app = new Pimp\Pimp();

add custom service:

$template = new Smarty(); //beware of the interfaces
require_once('autoload.php');
$app = new Pimp\Pimp(
    array(
        'template' => $template
    )
);

Define a GET route:
$app->get('/pattern', 'ControllerClassName:MethodName');
Define a POST route:
$app->post('/pattern', 'ControllerClassName:MethodName');
Define a PUT route:
$app->put('/pattern', 'ControllerClassName:MethodName');
Define a DELETE route:
$app->delete('/pattern', 'ControllerClassName:MethodName');

You can use variables in the route (but not conditions):
$app->get('/post/:idpost/comment/:idcomment', 'ControllerClassName:MethodName');

Run the application:
$app->run();


Unit test
---------

Please make sure that PHPUnit is installed

to run the (incomplete) tests:

phpunit Test/ (all tests)
phpunit Test/Controller (Controller tests)
phpunit Test/Pimp (Pimp tests)
