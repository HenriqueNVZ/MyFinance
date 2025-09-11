<?php

    class Controller{

        public function renderView($view){
            //Guarda a string da view em um buffer
            ob_start();
            require_once __DIR__ . "/../views/$view.php";
            return ob_get_clean();
        }
    }