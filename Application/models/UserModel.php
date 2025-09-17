<?php
    namespace User\MyFinance\models;
    use User\MyFinance\core\Database;
    use User\MyFinance\core\Response;
    use User\MyFinance\models\BaseModel;
    // use PDO;
    use PDOException;

    //O UserModel irá receber e preparas os dados do usuario para envia-los ao BaseModel
    //Por mais que eu tenha validações via frontend com JS,o js pode ser facilmente desabitado por isso aqui no backend será feito uma camada extra de proteção
    
    class UserModel extends BaseModel{
        
        protected $pdo;
        protected $tableName = 'usuarios';
       
        
        public function __construct(Response $response){
            parent::__construct($response);
            $this->pdo = Database::getInstance()->getConnection();
        }

        //DUVIDA MINHA - VALIDAÇÕES SEPARADAS EM FUNÇoes?
        //Este método principal receberia todos os dados do formulário e faria as verificações.
        public function createData(){
        // Pega os dados diretamente do formulário
        $data = $_POST;

        // 1. Chama o método de validação para verificar os dados
        $errors = $this->validateData($data);

        // Se o array de erros estiver vazio, significa que os dados são válidos
        if (empty($errors)) {
            // 2. Criptografa a senha antes de salvar no banco
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            
            // 3. Chama o método 'create' do BaseModel para salvar os dados
            // Lembre-se, o BaseModel já faz toda a lógica de segurança e inserção
            $this->create($data);

            // Retorna um array de sucesso
            return ['success' => true];
        }

        // Se houver erros, retorna o array de erros
        return ['errors' => $errors];
        }
    
        //Valida os dados de email e senha,em caso de erro registra-os.
        public function validateData($data){
            $errors = [];
            //EMAIL:
            //Verifica se a variavel existe e se é vazia.
            if(!isset($data['email']) || empty($data['email'])){
                $errors['email'] = "O campo email é obrigatório!";
            }
            //Verifica se o email é unico
            if(!$this->isEmailUnique($data['email'])){
                $errors['email'] = "Este e-mail já está cadastrado.";
            }

            //SENHA:
            if(!isset($data['password']) || empty($data['password'])){
                $errors['password'] = "O campo senha é obrigatório!";
            }
            if(!$this->isPasswordStrong($data['password'])){
                $errors['password'] = "A senha deve conter no mínimo 8 caracteres, uma letra maiúscula, uma minúscula, um número e um caractere especial.";
            }
            if($data['password'] !== $data['confirm_password']){
                $errors['password'] = "As senhas não coincidem";
            }
            return $errors;
        }

        //Verifica se já existe um Usuario com email,para evitar mais de um usuario com mesmo email
        public function isEmailUnique($email){
            try{
                $query = ("SELECT COUNT(*) FROM {$this->tableName} WHERE email = :email");
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(":email",$email);
                $stmt->execute();
                if($stmt->fetchColumn() > 0){
                //Já existe um user com o email
                return false;
                }
                return true;
            }catch (PDOException $e) {
                error_log('Erro ao salvar usuário: ' . $e->getMessage());
                return false;
            }
        }

        public function isPasswordStrong($password){
            $minCaracteres =  8;

            //Valida minimo de caracteres
            if(strlen($password) < $minCaracteres){
                return false;
            }
            //Senha com pelo menos um numero
            if (!preg_match('/[0-9]/', $password)) {
                return false;
            }
            //Senha com letra maiuscula
            if(!preg_match('/[A-Z]/',$password)){
                return false;
            }
            //Senha com caracter especial
            if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\'":\\|,.<>\/?]/', $password)) {
                return false;
            }   
            //Senha com letra minuscula
            if(!preg_match('/[a-z]/',$password)){
                return false;
            }      
            return true;     
        }

        //Um método que faria a limpeza dos dados (ex: remover espaços em branco, formatar o celula
        public function prepareData($data){

            foreach($data as $key => $value){
                $data[$key] = trim($value);
            }
            if(isset($data['phone_number'])){

            $data['phone_number'] = preg_replace('/\D/', '', $data['phone_number']);
            }
            return $data;   
        }
    }
?>