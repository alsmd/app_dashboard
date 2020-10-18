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
            $route['suporte'] = [
                "route" => "/suporte",
                "controller" => "indexController",
                "action" => "suporte"
            ];
            $route['documentacao'] = [
                "route" => "/documentacao",
                "controller" => "indexController",
                "action" => "documentacao"
            ];
            parent::setRoutes($route);
        }
        
        
    }

?>