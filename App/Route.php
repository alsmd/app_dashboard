<?php 

    namespace App;

    use MF\init\Bootstrap;

    class Route extends Bootstrap{
        
        protected function initRoutes(){

            $route['home'] = [
                "route" => "/",
                "controller" => "indexController",
                "action" => "index"
            ];

            parent::setRoutes($route);
        }
        
        
    }

?>