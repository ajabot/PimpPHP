<?php

namespace Pimp;

use Pimp\HTTP\Request;
use Pimp\HTTP\Response;
use Pimp\Routing\Router;
use Pimp\Routing\Route;
use Pimp\View\Template;
use Pimp\View\TemplateInterface;
use Pimp\Model\ModelManager;
use Pimp\Model\DataGateway;
use Pimp\Model\DataGatewayInterface;
use Pimp\DependencyInjection\Container;
use Pimp\Dispatch\Dispatcher;
use Pimp\Helper\CSVHandler;
use Pimp\Helper\FileHandlerInterface;
use Pimp\Helper\ResponseFormatter;

/**
 * This class orchestrate the application
 */
class Pimp {
    /**
     * @var Container $container the container object used to manage services
     */
    protected $container;

    /**
     * Set up settings and services
     *
     * @param array $settings array of custom settings and services (see README)
     *
     * @return void
     */
    public function __construct(array $settings = array())
    {
        $this->container = new Container();

        $settings = array_merge(static::getDefaultConfig(), $settings);
        $this->container->setSettings($settings);


        $this->_addFileHandlerService();
        $this->_addModelManagerService();
        $this->_addTemplateService();
        $this->container->addService('router', new Router());
        $this->container->addService('request', new Request());
        $this->container->addService('responseFormatter', new ResponseFormatter());
    }

    /**
     * Set up the file handler service
     *
     * @return void
     */
    private function _addFileHandlerService()
    {
        if ($this->container->getSetting('fileHandler') instanceof FileHandlerInterface) {
            $fileHandler = $this->container->getSetting('fileHandler');
        } else {
            $fileHandler = new CSVHandler();
        }

        $this->container->addService('fileHandler', $fileHandler);
    }

    /**
     * Set up the modelManager service
     *
     * @return void
     */
    private function _addModelManagerService()
    {
        if ($this->container->getSetting('dataGateway') instanceof DataGatewayInterface) {
            $dataGateway = $this->container->getSetting('dataGateway');
        } else {
            $dataGateway = new DataGateway($this->container->get('fileHandler'));
        }

        $this->container->addService('modelManager', new ModelManager($dataGateway));
    }

    /**
     * Set up the template engine
     *
     * @return void
     */
    private function _addTemplateService()
    {
        if ($this->container->getSetting('template') instanceof TemplateInterface) {
            $template = $this->container->getSetting('template');
        } else {
            $template = new Template();
        }

        $template->setViewDirectory($this->container->getSetting('view_directory'));
        $template->setCompileDirectory($this->container->getSetting('compile_directory'));
        $template->setCacheDirectory($this->container->getSetting('cache_directory'));

        $this->container->addService('template', $template);
    }

    /**
     * Return an array containing the default settings of our application
     *
     * @return array the settings
     */
    public static function getDefaultConfig()
    {
        return array(
            'view_directory' => dirname(__FILE__) . DIRECTORY_SEPARATOR . "View",
            'compile_directory' => dirname(__FILE__) . DIRECTORY_SEPARATOR . "View/Compile",
            'cache_directory' => dirname(__FILE__) . DIRECTORY_SEPARATOR . "View/Cache",
        );
    }

    /**
     * add a new to the application with the GET method
     *
     * @param string $pattern    the pattern of the route
     * @param string $controller the controller and method that will manage a request coming through this route (ex: Project\Controller\Address:getAction)
     *
     * @return void
     */
    public function get($pattern, $controller)
    {
        $this->container->get('router')->map($pattern, $controller, Route::GET_METHOD);
    }

    /**
     * add a new to the application with the POST method
     *
     * @param string $pattern    the pattern of the route
     * @param string $controller the controller and method that will manage a request coming through this route (ex: Project\Controller\Address:getAction)
     *
     * @return void
     */
    public function post($pattern, $controller)
    {
        $this->container->get('router')->map($pattern, $controller, Route::POST_METHOD);
    }

    /**
     * add a new to the application with the PUT method
     *
     * @param string $pattern    the pattern of the route
     * @param string $controller the controller and method that will manage a request coming through this route (ex: Project\Controller\Address:getAction)
     *
     * @return void
     */
    public function put($pattern, $controller)
    {
        $this->container->get('router')->map($pattern, $controller, Route::PUT_METHOD);
    }

    /**
     * add a new to the application with the DELETE method
     *
     * @param string $pattern    the pattern of the route
     * @param string $controller the controller and method that will manage a request coming through this route (ex: Project\Controller\Address:getAction)
     *
     * @return void
     */
    public function delete($pattern, $controller)
    {
        $this->container->get('router')->map($pattern, $controller, Route::DELETE_METHOD);
    }

    /**
     * This is where our application gets a request and converts it into a response
     * that is returned to the user
     *
     * @return void
     */
    public function run()
    {
        $uri = $this->container->get('request')->getUri();
        $method = $this->container->get('request')->getMethod();

        try {
            //First we're trying to get a route matching the requested URI
            $matchingRoute = $this->container->get('router')->getMatchingRoute($uri, $method);
            //If we've got one we get the parameters from the URI
            $params = $this->container->get('router')->getRouteParams($matchingRoute, $uri);
            //And we call the controller linked to the route
            $response = $this->dispatch($matchingRoute, $params);
        }  catch(\Exception $e) {
            //very basic Exception management
            //custom Exceptions would be better
            $content = array('message' => $e->getMessage());
            $headers = $this->container->get('request')->getHeaders();
            $response = $this->container->get('responseFormatter')->format($content, $headers['Accept']);
            $response->setStatus(Response::INTERNAL_ERROR_CODE);
        }

        //Now that we have a response from the controller or the Exception Handler
        //building the HTTP response
        http_response_code($response->getStatus());
        $headers = $response->getHeaders();
        //adding headers
        if ($headers && is_array($headers)) {
            foreach($headers as $header) {
                header($header);
            }
        }

        //And finally we return our response
        echo $response->getContent();
    }

    /**
     * Calls the controller linked to the route with the right params
     *
     * @param Route $route  The route that matched the requested URI
     * @param array $params an array containing the parameters sent by the user through the URI
     *
     * @return void
     */
    public function dispatch(Route $route, array $params)
    {
        list($className, $method) = explode(':', $route->getController());

        $className .= 'Controller';
        $controller = new $className($this->container);

        return call_user_func_array(array($controller, $method), $params);
    }
}
