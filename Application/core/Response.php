<?php
    namespace User\MyFinance\core;

    class Response{

        public function error($code){
            http_response_code($code);
            if($code == 404){
                echo 'pagina não encontrada';
            }
            else if($code == 500){
                echo 'Erro interno do servidor';
            }
            elseif($code == 401){
                echo 'Usuário não autenticado.';
            }
        }
    }
?>