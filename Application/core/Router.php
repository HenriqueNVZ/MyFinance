<?php
/**
 * A classe Router gerencia o roteamento de URLs.
 * Ela armazena as rotas para a aplicação e as executa com base na requisição do usuário.
 */

    namespace User\MyFinance\core;
    use User\MyFinance\controllers\Controller;

    class Router{
        //Array associativo com chave GET e POST para armazenar rotas e callbacks
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


        //Armazena requisições GET no Array $routes;
        public function registerGet($path,$callback){
            //A path é a URL e a callback é função a ser executada essa URL é acessada
            $this->routes['get'][$path] = $callback;
        }

        //Armazena requisições POST no Array $routes;
        public function registerPost($path,$callback){
            $this->routes['post'][$path] = $callback;
        }

        //Executa a Callback
        public function resolve(){
            //Recebe a URL 
            $path = $this->request->getPath();
            //Recebe o metodo(GET ou POST)
            $method =$this->request->getMethod();
            //Recebe a callback
            $callback = $this->routes[$method][$path] ?? false;

            if($callback === false){
                //Callback retornando false significa que a rota é inexistente
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
