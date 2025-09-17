<?php
    namespace User\MyFinance\controllers;


    class Controller{

        public function renderView($view,$data =[]){
            //Transforma as chaves do array data em variaveis (o array vem de showLoginForm()) 
            extract($data);
            //Guarda a string da view em um buffer
            ob_start();
            require_once __DIR__ . "/../../views/$view.php";
            return ob_get_clean();
        }
    }