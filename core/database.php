<?php

class Database {
    // A propriedade $instance vai armazenar a única instância da classe.
    private static $instance = null;
    
    // A propriedade $pdo vai armazenar o objeto de conexão.
    private $pdo;

    // O construtor é privado, impedindo a criação de novas instâncias com 'new'.força o uso do método getConnection
    private function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        
        try {
            // A conexão é criada aqui e armazenada em $this->pdo.
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS);
            
            // Configura os atributos para lançar exceções em caso de erros.
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $erro) {
            // Em um ambiente de produção, registre o erro, não o exiba.
            throw new Exception('Erro na conexão: ' . $erro->getMessage());
        }
    }

    // Este é o método que você vai chamar para obter a única instância da classe.
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Este método retorna o objeto de conexão.
    public function getConnection() {
        return $this->pdo;
    }
}
?>