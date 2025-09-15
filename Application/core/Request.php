<?php
    namespace User\MyFinance\core;

    //O Request vai pegar o Caminho e o método das requisições

    class Request{

        //Deve retornar o caminho da requisição,Caso haja query string devemos retirar ao enviar path
        public function getPath(){
            $basePath = '/MyFinance';



            $path = $_SERVER['REQUEST_URI'] ?? '/';
            $position = strpos($path,'?');
            if($position !== false){
                // extrai de path da posição 0 ao inicio da query string
                $path = substr($path,0,$position);
            }
            if(strpos($path,$basePath) === 0){
                $path = substr($path,strlen($basePath));
            }
            //Se path ficar vazio após remover a /,ele a recoloca para ficar na raiz do projeto
            $path = rtrim($path, '/');
            if ($path === '') $path = '/';
            return $path;
        }

        public function getMethod(){
            $method = strtolower($_SERVER['REQUEST_METHOD']) ?? 'get';
            return $method;
        }
    }
?>