<?php
    namespace User\MyFinance\controllers;
//O UserController é a ponte que conecta a requisição do usuario com o userModel, lidando com a resposta
require_once '../models/userModel';
require_once  __DIR__.'/loginController';
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
            header("location: /sucesso");
            exit;
        }else{
            // Se houver erros, você pode renderizar a página de cadastro novamente e passar os erros para a view
            echo '<pre>';
            print_r($result['errors']);
            echo '</pre>';
        }


    }
    public function showRegisterForm($errors = [], $formData = []) {
        // Renderiza a view 'cadastro' e passa os erros e os dados do formulário para ela
        
        return $this->renderView('cadastro', ['errors' => $errors, 'formData' => $formData]);
    } 

    






}