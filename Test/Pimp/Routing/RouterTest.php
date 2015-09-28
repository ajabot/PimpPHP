<?php

namespace Test\Pimp\Routing;

class RouterTest extends \PHPUnit_Framework_TestCase
{
  public function testGetMatchingRoute()
  {
      $router = new \Pimp\Routing\Router();

      $router->map('/address/:id', 'Project\Controller\Address:getAction', 'GET');
      $router->map('/address', 'Project\Controller\Address:postAction', 'POST');

      $route = $router->getMatchingRoute('/address/1', 'GET');
      $this->assertInstanceOf('Pimp\Routing\Route', $route);

      $route = $router->getMatchingRoute('/address', 'POST');
      $this->assertInstanceOf('Pimp\Routing\Route', $route);
  }

  /**
   * @expectedException \Exception
   */
  public function testGetMatchingRouteNotFound()
  {
      $router = new \Pimp\Routing\Router();

      $router->map('/address/:id', 'Project\Controller\Address:getAction', 'GET');
      $route = $router->getMatchingRoute('/address', 'GET');
  }

  /**
   * @expectedException \Exception
   */
  public function testGetMatchingRouteWrongMethod()
  {
      $router = new \Pimp\Routing\Router();

      $router->map('/address/:id', 'Project\Controller\Address:getAction', 'GET');
      $route = $router->getMatchingRoute('/address/1', 'POST');
  }

  public function testGetRouteParams()
  {
      $router = new \Pimp\Routing\Router();

      $route = new \Pimp\Routing\Route('/address/:id', 'Project\Controller\Address:getAction', 'GET');
      $params = $router->getRouteParams($route, '/address/1');
      $this->assertSame(array('1'), $params);

      $route = new \Pimp\Routing\Route('/post/:id/comment', 'Project\Controller\Address:getAction', 'GET');
      $params = $router->getRouteParams($route, '/post/1/comment');
      $this->assertSame(array('1'), $params);

      $route = new \Pimp\Routing\Route('/post/:post/comment/:comment', 'Project\Controller\Address:getAction', 'GET');
      $params = $router->getRouteParams($route, '/post/3/comment/50');
      $this->assertSame(array('3', '50'), $params);
  }

  /**
   * @expectedException \Exception
   */
  public function testGetRouteParamsFails()
  {
      $router = new \Pimp\Routing\Router();

      $route = new \Pimp\Routing\Route('/address/:id', 'Project\Controller\Address:getAction', 'GET');
      $params = $router->getRouteParams($route, '/address/foo/1/');
  }
}
