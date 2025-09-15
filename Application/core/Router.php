<?php
    namespace User\MyFinance\core;
    use User\MyFinance\controllers\Controller;

    class Router{
        protected array $routes = [];
        public Request $request;
        public Response $response;
        public Controller $controller;

        
        public function __construct(Request $request, Response $response,Controller $controller)
        {
            $this->request = $request;
            $this->response = $response;
            $this->controller = $controller;
        }


        //Registra requisições get no array
        public function registerGet($path,$callback){
            //O valor para get => 'path' = $callback
            $this->routes['get'][$path] = $callback;
        }

        //Registra requisições post no array
        public function registerPost($path,$callback){
            //O valor para post => 'path' = $callback
            $this->routes['post'][$path] = $callback;
        }

        //Está função deve saber qual rota acessar e executar a callback correta
        public function resolve(){
            $path = $this->request->getPath();
            $method =$this->request->getMethod();
            $callback = $this->routes[$method][$path] ?? false;

            if($callback === false){
                //Se a callback retornar false significa que não existe está rota
                $this->response->error(404);
                return;
            }
            if (is_callable($callback)) {
                //Se a callback for uma função ela será executada imediatamente
                call_user_func($callback);
                return; 
            }
            if(is_string($callback)){
                //Se a callback for uma string significa que uma view deve ser renderizada
                //Guardamos a view como string
                echo $this->controller->renderView($callback);
                return;
            }
            // Caso o tipo de callback não seja suportado
            $this->response->error(500);
        }
    }
?>
