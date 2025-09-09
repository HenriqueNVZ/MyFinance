<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de login</title>
    <link rel="stylesheet" href="src/styles/style.css">
</head>
<body style="background-color: #E6F4EA ;">
    <div class="container">
        <div class="login-area">
            <div class="text">
                <h2 class="titulo-login">Faça o seu login</h2>
            </div>
            
            <form action="login.php" method="POST" class="formulario-login">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text"  name="email" class="input_data" placeholder="Digite seu email">
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="text"  name="senha" class="input_data" placeholder="Digite sua senha">
                </div>

                <div class="btn-entrar">
                       <button type="submit">Entrar</button>
                </div>
             
            </form>

            <div class="createAccount">
                <p>Primeira vez aqui ? <a href="register.php"><span>Crie sua conta</span></a></p>
            </div>
        </div>
    </div>
</body>
</html>