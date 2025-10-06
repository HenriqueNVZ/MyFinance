<?php
    namespace User\MyFinance\controllers;

    use User\MyFinance\models\UserModel;
    use User\MyFinance\controllers\Controller;
    use User\MyFinance\core\Response;

//O UserController é a ponte que conecta a requisição do usuario com o userModel, lidando com a resposta
;
class UserController extends Controller{

    protected $userModel;
    
    
    public function __construct() {
        $response = new Response(); 
        $this->userModel = new UserModel($response);
    }

    public function registerUser(){
        $formData = $_POST;
        
        //CreateData vai retornar a chave sucess ou errors
        $result = $this->userModel->createData($formData);
            
        //Se não houver a chave errors significa que não possue erros
        if(empty($result['errors'])){
            header("location:/login");
            exit;
        }else{
            return $this->showRegisterForm($result['errors'], $formData);
        }


    }
    public function showRegisterForm($errors = [], $formData = []) {
        // Renderiza a view 'register' e passa os erros e os dados do formulário para ela
        
        return $this->renderView('/register', ['errors' => $errors, 'formData' => $formData]);
    } 

    public function deleteUser(){
            $userId = $_SESSION['user_id'] ?? null;
            var_dump($userId);
            if($userId <= 0){
                //Não há um usuario logado
                header("Location: /login");
                exit;
            }
            $deleteAction = $this->userModel->deleteUserData($userId);
            if($deleteAction){
                session_destroy();
                header("Location: /register");
                exit;
            }else{
                header("Location: /dashboard");
                exit;
            }
        }
        //Buscar dados de usuario e retornar um json 
        public function getProfileDataJson() {
            
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $userId = $_SESSION['user_id'] ?? null;
            
            if (!$userId) {
                //chamar o response 401
                exit;
            }
            
            $userData = $this->userModel->findById((int) $userId);

            //Define o cabeçalho para o navegador saber que é JSON
            header('Content-Type: application/json');
            
            //Imprime o JSON e encerra a execução
            echo json_encode($userData);
            exit;
        }

        // controller que trata /updateUserData
        public function updateProfile()
{
    // Inicia sessão se ainda não estiver ativa
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = $_SESSION['user_id'] ?? null;

    // Se não houver usuário logado, redireciona para login
    if (!$userId) {
        header('Location: /login');
        exit;
    }

    // Pega os dados enviados pelo formulário
    $NewUserData = $_POST;

    // Atualiza o perfil
    $result = $this->userModel->updateProfileData($NewUserData, $userId);

    // Redireciona conforme resultado
    if (!empty($result['errors'])) {
        // Se houver algum erro, volta para o dashboard com parâmetro de erro
        if (!empty($result['errors'])) {
            echo '<pre>';
            var_dump($result['errors']);
            echo '</pre>';
            exit;
        }
        header('Location: /dashboard?update=error');
        exit;
    }

    // Se deu certo, redireciona normalmente
    header('Location: /dashboard?update=success');
    exit;
}



    






}