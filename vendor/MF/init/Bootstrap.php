<?php 

    namespace MF\init;

    abstract class Bootstrap{
        private $routes;

        abstract protected function initRoutes();

        public function __construct(){
            $this->initRoutes();
            $this->run($this->getUrl());
        }

        function getRoutes(){
            return $this->routes;
        }
        function setRoutes($routes){
            $this->routes = $routes;
        }


        protected function run($url){
            foreach($this->routes as $route){
                if($url == $route['route']){
                    $class = "App\\Controllers\\". ucfirst($route['controller']);
                    $controller = new $class;
                    $action = $route['action'];
                    $controller->$action();
                }
            }
        }




        protected function getUrl(){
            return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
        }
    }

?>