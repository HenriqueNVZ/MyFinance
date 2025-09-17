<?php
    namespace User\MyFinance\controllers;
    use User\MyFinance\models\BaseModel;
    use User\MyFinance\models\UserModel;
    use User\MyFinance\core\Response;

    class LoginController extends Controller{

        protected $UserModel;

        public function __construct(){
            $response = new Response();
            $this->UserModel = new UserModel($response);

            
        }

        //Valida os dados de login
        public function login(){
            //Array que contem dados enviados ao tentar efetuar o Login
            $loginData = [
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['senha'] ?? '',
            ];

            //Armazena um array com os dados do usuario e false se não existir;
            $user = $this->userModel->findUserByEmail($loginData['email']);

            //Verifica se existe um usuario com o email digitado e se a senha digitada corresponde com a senha do banco de dados
            if($user && password_verify($loginData['password'], $user['senha_hash'])){
                //Inicia uma sessão de login
                session_start();
                //Cria um espaço de armazeanmento de dados na superglobal,neste caso armazena o id do usuario logado;
                $_SESSION['user'] = $user['id'];
                //Direciona o usuario para o pagina de dashboard;
                header("Location: /dashboard");
                exit;
            }else{
                $errors = ['email' => "Email ou senha incorretos!"];
                return $this->showLoginForm($errors);
            }
        }

        public function showLoginForm($errors = [], $formData = []){
            //Renderiza a view Login passando para renderView um array com os erros
            $this->renderView('login',[
                    'errors' => $errors, 
                    'formData' => $formData
            ]);
        }

        
    }
?>