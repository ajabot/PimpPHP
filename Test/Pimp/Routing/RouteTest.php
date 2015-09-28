<?php

namespace Test\Pimp\Routing;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethod()
    {
        $route = new \Pimp\Routing\Route('/address/:id', 'Project\Controller\Address:getAction', 'GET');
        $this->assertEquals('GET', $route->getMethod());
    }

    public function testGetPattern()
    {
        $route = new \Pimp\Routing\Route('/address/:id', 'Project\Controller\Address:getAction', 'GET');
        $this->assertEquals('/address/:id', $route->getPattern());
    }

    public function testGetController()
    {
        $route = new \Pimp\Routing\Route('/address/:id', 'Project\Controller\Address:getAction', 'GET');
        $this->assertEquals('Project\Controller\Address:getAction', $route->getController());
    }

    public function testMatches()
    {
        $route = new \Pimp\Routing\Route('/address/:id', 'Project\Controller\Address:getAction', 'GET');
        $this->AssertTrue($route->matches('/address/1'));
        $this->AssertTrue($route->matches('/address/foo'));
        $this->AssertTrue($route->matches('/address/b613'));
        $this->AssertTrue($route->matches('/address/1_to_many'));

        $this->AssertFalse($route->matches('/address'));
        $this->AssertFalse($route->matches('/address/1/foo'));
        $this->AssertFalse($route->matches('/post/1'));

        $route = new \Pimp\Routing\Route('/post/:id/comments', 'Project\Controller\Address:getAction', 'GET');
        $this->AssertTrue($route->matches('/post/1/comments'));
        $this->AssertTrue($route->matches('/post/foo/comments'));

        $this->AssertFalse($route->matches('/post/1/comments/300'));
        $this->AssertFalse($route->matches('/post/'));
        $this->AssertFalse($route->matches('/address'));
        $this->AssertFalse($route->matches('/address/1/comments'));

        $route = new \Pimp\Routing\Route('/post/:idpost/comments/:idcomment', 'Project\Controller\Address:getAction', 'GET');
        $this->AssertTrue($route->matches('/post/1/comments/200'));
        $this->AssertTrue($route->matches('/post/foo/comments/bar'));

        $this->AssertFalse($route->matches('/post/1/comments'));
        $this->AssertFalse($route->matches('/post/foo/comments'));
        $this->AssertFalse($route->matches('/address/1/comments/2'));
        $this->AssertFalse($route->matches('/foo/1/bar/2'));
        $this->AssertFalse($route->matches('/post/'));

    }
}
