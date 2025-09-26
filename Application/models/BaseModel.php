<?php
    namespace User\MyFinance\models;
    use User\MyFinance\core\Database;
    use User\MyFinance\core\Response;
    use PDO;
    use PDOException;
    
        class BaseModel{

        protected $pdo;
        private $tableName;

        public function __construct(Response $response) {
            $this->pdo = Database::getInstance()->getConnection();
         
        }
        
        //Esta função acessa todos os dados de uma tablea
        public function findAll(){
            $query = ("SELECT * FROM {$this->tableName}");
            try{
                //Preparando a query SQL - protege contra injeções SQL
                $stmt = $this->pdo->prepare($query);
                $stmt->execute();
                //retorna o array dos dados
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }catch(PDOException $e){
                echo "Erro na consulta: " . $e->getMessage();
                return false;
            }
        }
          
        //Esta função busca um dado por id
        public function findById($id){
                $query = ("SELECT * FROM {$this->tableName} WHERE id = :id");
            try{
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(":id",$id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
                
            }catch(PDOException $e){
                echo "Erro na consulta: " . $e->getMessage();
                return false;
            }
        }

        //CRUD(exeto read)

        //Esta função cria um novo usuario
        public function create(array $data){
            //Pego o array dos dados extraio apenas as chaves
            $columnField = implode(",",array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            $query = ("INSERT INTO {$this->tableName}($columnField) VALUES ($placeholders) ");
            
            try{
                $stmt = $this->pdo->prepare($query);
                // foreach($data as $key => &$value){
                //     $stmt->bindParam(":$key", $value); 
                // }                
                return $stmt->execute($data);
                
            }catch(PDOException $e){
                echo "Erro na consulta: " . $e->getMessage();
                return false;
            }
        }

        //Esta função atualiza os dados de um usuario
        public function update(int $id,array $data){
            $setClause = '';
            foreach($data as $key => &$value){
                $setClause .= " {$key} = :{$key},";
            }
            //remove a ultima virgula;
            $setClause = rtrim($setClause, ', ');
            $query = ("UPDATE {$this->tableName} SET {$setClause} WHERE id = :id");

            try{
                $stmt = $this->pdo->prepare($query);
                $data['id'] = $id;
                $stmt->execute($data);
                return true;
            }catch(PDOException $e){
                echo "Erro na atualização de dados: " . $e->getMessage();
                return false;
            }
        }
        //Esta função apaga os dados de um usuario
        public function delete($id){
            $query = ("DELETE FROM {$this->tableName} WHERE id = :id");
            
            try{
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':id' => $id]);

            }catch(PDOException $e){
                echo "Erro ao Excluir dados: " . $e->getMessage();
                return false;
            }
        }
        
    }
?>