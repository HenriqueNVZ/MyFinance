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
            $user = $this->UserModel->findUserByEmail($loginData['email']);

            //Verifica se existe um usuario com o email digitado e se a senha digitada corresponde com a senha do banco de dados
            if($user && password_verify($loginData['password'], $user['password'])){
                //Inicia uma sessão de login
                session_start();
                //Cria um espaço de armazeanmento de dados na superglobal,neste caso armazena o id do usuario logado;
                $_SESSION['user_id'] = $user['id'];
                //Direciona o usuario para o pagina de dashboard;
                header("Location: /dashboard");
                exit;
            }else{
                $errors = ['login_error' => "Email ou senha incorretos!"];
                return $this->showLoginForm($errors = [],$formData = []);
            }
        }

        public function showLoginForm($errors = [], $formData = []){
            //Renderiza a view Login passando para renderView um array com os erros
            return $this->renderView('login',[
                    'errors' => $errors, 
                    'formData' => $formData
            ]);
        }

        public function logout(){
            if(session_status() === PHP_SESSION_NONE){
                //Inicia a sessão
                session_start();
            }
                //Limpa todas as variáveis da sessão
                session_unset();
                //Destroi a sessão
                session_destroy();
                header('Location: /login');
                exit;
        }

        
    }
?>