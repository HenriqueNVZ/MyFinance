<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Cadastro</title>
    <link rel="stylesheet" href="../../styles/style.css">
</head>
<body>
    <div class="cadastro-container">
        <div class="cadastro-area">
            <div class="text-cadastro">
                <h2 class="titulo-cadastro">Cadastre-se</h2>
                
                <a href="/login" >Entrar</a>
            </div>
            
            <form action="/register" method="POST" class="formulario-cadastro">

                <div class="form-group">
                    <label for="first_name">Primeiro Nome</label>
                    <input 
                        type="text"
                        name="first_name" 
                        class="input_data" 
                        placeholder="Digite seu primeiro nome"
                        id="first_name"  
                    >
                    <p class="mensagem-erro"></p> 
                </div>

                <div class="form-group">
                    <label for="last_name">Sobrenome</label>
                    <input 
                        type="text" 
                        name="last_name" 
                        class="input_data" 
                        placeholder="Digite seu sobrenome"
                        id="last_name"
                    >

                    <p class="mensagem-erro"></p> 
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="text" 
                        name="email" 
                        class="input_data" 
                        placeholder="Digite seu email"
                        id="email"
                    >

                    <p class="mensagem-erro"></p> 
                </div>

                <div class="form-group">
                    <label for="number_phone">Celular</label>
                    <input 
                        type="text" 
                        name="number_phone" 
                        class="input_data" 
                        placeholder="(xx) xxxxx-xxxx"
                        id="number_phone"
                    >
                    
                    <p class="mensagem-erro"></p> 
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="input_data" 
                        placeholder="Digite sua senha"
                        id="password"
                    >
                    <p class="mensagem-erro"></p> 
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirme a senha</label>
                    <input 
                        type="password" 
                        name="confirm_password"
                        class="input_data" 
                        placeholder="Digite sua senha novamente"
                        id="confirm_password"
                    >
                    <p class="mensagem-erro"></p> 
                </div>
                
                <div class="btn-enviar-cadastro">
                       <button type="submit">Continuar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../../styles/javaScript/register.js"></script>
</body>
</html>