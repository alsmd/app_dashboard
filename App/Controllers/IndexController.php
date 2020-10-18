<?php 

    namespace App\Controllers;

     class IndexController{
        private $dados;

        public function __construct(){
            $this->dados = new \stdClass();
        }

        public function index(){
            $this->render('index');
        }

        public function render($view){
            $nome = get_class();
            $nome = str_replace("App\\Controllers\\","",$nome);
            $nome = lcfirst(str_replace("Controller","",$nome));


            require_once "../App/Views/$nome/$view.phtml";

        }
    }

?>

