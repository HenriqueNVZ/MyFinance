<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de login</title>
    <link rel="stylesheet" href ="/styles/style.css">
</head>
<body style="background-color: #E6F4EA ;">
    <div class="container">
        <div class="login-area">
            <div class="text">
                <h2 class="titulo-login">Faça o seu login</h2>
            </div>
            <!-- action do form aponta para a rota que lida com a autenticação   -->
            <form action="/login" method="POST" class="formulario-login">
                
                <?php if(isset($errors['login_error'])): ?>
                    <div class="alert-error">
                        <?php echo htmlspecialchars($errors['login_error']); ?>
                    </div>
                <?php endif;?>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="text"  
                        name="email" 
                        class="input_data" 
                        placeholder="Digite seu email"
                    >
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input 
                        type="text"  
                        name="senha" 
                        class="input_data" 
                        placeholder="Digite sua senha"
                    >
                </div>

                <div class="btn-entrar">
                       <button type="submit">Entrar</button>
                </div>
             
            </form>

            <div class="createAccount">
                <p>Primeira vez aqui ? <a href="/register"><span>Crie sua conta</span></a></p>
            </div>
        </div>
    </div>
</body>
</html>