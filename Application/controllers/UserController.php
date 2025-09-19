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

    






}