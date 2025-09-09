<?php 
    //Ponte entre .ENV e a aplicação

// '/../' sobe um nível, para a raiz do seu projeto
$env_file = __DIR__ . '/../.env';

// Verifica se o arquivo .env existe.
if (file_exists($env_file)) {
    // A função parse_ini_file() lê o arquivo .env e o transforma em um array associativo.
    // Exemplo: 'DB_HOST=localhost' se torna ['DB_HOST' => 'localhost']
    $env = parse_ini_file($env_file);

    // Usa a função define() para criar constantes globais.
    // Agora, DB_HOST, DB_USER, etc., podem ser usados em qualquer lugar do seu código.
    define('DB_HOST', $env['DB_HOST']);
    define('DB_USER', $env['DB_USER']);
    define('DB_PASS', $env['DB_PASS']);
    define('DB_NAME', $env['DB_NAME']);

} else {
    // Se o arquivo não existir, exibe uma mensagem de erro fatal.
    die("Erro: Arquivo .env de configuração não encontrado.");
}
?>