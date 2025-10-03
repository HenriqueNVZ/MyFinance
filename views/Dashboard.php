<?php
//Além da verificação no método index, há a verificação na view -garantindo a segurança do dashboard em duas camadas


// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Verifica se a variável de dados do formulário existe para definir o modo
$isEditing = isset($formData['id']);

$formAction = $isEditing ? "/update-expense" : "/add-expense";


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Caminho css pensando em public como raiz do projeto -->
    <link rel="stylesheet" href="/styles/dashboard.css">
    <link rel="stylesheet" href="/styles/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>MyFinance</title>
</head>
<body>
    <header>
        <div class="logo">
            MyFinance
        </div>
        <nav class="nav-bar">
            <ul class="itens">
                <li><a href="#">Receitas</a></li>
                <li><a href="#">Relatórios</a></li>
                <li><a href="#">Resumo</a></li>
                <li><a href="" class="btn-add-gasto">Adicionar gasto <i class="fa-solid fa-plus"></i></a></li>
            </ul>
        </nav>
        <div class="user">
            <i class="fa-solid fa-user" id="user_icon"></i>
        </div>
    </header>
    <main>
        <div class="tabela">
            <table>
                <thead>
                    <tr>
                        <th class="categoria">Categoria</th>
                        <th class="valor-gasto">Valor</th>
                        <th>Descrição</th>
                        <th>Data</th>
                        <th class="th-actions">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (isset($expenses) && is_array($expenses)): ?>
                        <?php foreach($expenses as $expense):?>
                            <tr>
                                <!-- HTMLSPECIALCHARS previne ataques de injeção de código XSS -->
                                <td> <?= htmlspecialchars($expense['categoria'])?> </td>
                                <td> <?= htmlspecialchars($expense['valor'])?> </td>
                                <td> <?= htmlspecialchars($expense['descricao'])?> </td>
                                <td> <?= htmlspecialchars($expense['data_gasto']) ?></td>
                                

                                <td class="td-actions">
                                    <div class="btn-actions">
                                        <form action="/editExpense" method="GET"> 
                                            <input 
                                            type="hidden" 
                                            name="id" 
                                            value="<?= htmlspecialchars($expense['id']) ?>"
                                            >
                                            <button class="btn-action btn-edit" type="submit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </form>
                                        <form action="#" method="POST" class="form-delete-gasto">
                                            <input 
                                            type="hidden" 
                                            name="id"
                                            class="expense-id-input" 
                                            value="<?= htmlspecialchars($expense['id']) ?>"
                                            >
                                            <button class="btn-action btn-delete" type="button" title="Excluir Gasto">
                                                <i class="fa-solid fa-trash-can" ></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>                    
                            </tr>
                        <?php endforeach; ?> 
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">Nenhum gasto encontrado.</td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>   
    </main>

    <div class="modal">
        <div class="modal-content">
            <div class="close">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="title">
                Adicionar Novo Gasto
            </div>

            <form action="\addExpense" method="POST" class="modal-form">
                <input type="hidden" name="id" value="" id="expense-id-hidden">
                <div class="form-group">
                    <label for="Valor">Valor</label>
                    <!-- Type text mas no js valido para apenas aceitar numeros - mais bonito -->
                    <input 
                    type="text"
                    name="valor"
                    placeholder="R$ 0,00"
                    id="valor"
                    class="input_data" 

                    >
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select name="categoria" id="categoria">
                        <option value="Alimentação">Alimentação</option>
                        <option value="Moradia">Moradia</option>
                        <option value="Transporte">Transporte</option>
                        <option value="Saúde">Saúde</option>
                        <option value="Educação">Educação</option>
                        <option value="Lazer">Lazer</option>
                        <option value="Serviços">Serviços</option>
                        <option value="Compras">Compras</option>
                        <option value="Outros   ">Outros</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Descrição</label>
                    
                    <input 
                    type="text"
                    name="description"
                    placeholder="Descrição da compra"
                    id="description"
                    class="input_data" 
                    >
                </div>
                <div class="form-group">
                    <label for="date">Data</label>

                    <input 
                    type="date"
                    name="date"
                    placeholder="DD/MM/AAAA"
                    id="date"
                    class="input_data" 
                   
                    >
                </div>

                <button type="submit" class="btn-add">
                    Adicionar 
                </button>
            </form>
        </div>
    </div>

    <div class="delete-modal">
        <div class="content">
            <div class="title">
                <h4>Confirmar exclusão</h4>
            </div>

            <div class="text">
                <h5>Deseja realmente excluir este gasto?</h5>
            </div>

            <div class="buttons">
                <button type="button" class="btn-cancel">Cancelar</button>

                <form action="/deleteExpense" method="POST" id="confirm-delete-form">
                    <input type="hidden" name="id" id="delete-gasto-id" value=""> 
                    <button type="submit" class="btn-confirm">Confirmar</button>
                </form> 
            </div>
        </div>
    </div>

   <div class="perfil-modal"> 
        <div class="perfil-content">
            <div class="close">
                <i class="fa-solid fa-xmark icon-close"></i>
            </div>
            <div class="form-header">
                <form action="/logout" method="POST" id="logout-form">
                <button type="submit" class="logout-button">
                    <i class="fa-solid fa-right-from-bracket"></i> 
                    Logout
                </button>
                </form>
            </div>

            <form class="perfil-form" action="/updateUserData" method="POST">
                <div class="form-group">
                    <h2>Conta</h2>
                    <label for="nome">Nome</label>
                        <div class="input-wrapper">
                            <input 
                            type="text" 
                            id="nome" 
                            name="nome" 
                            placeholder="">
                            <i class="fa-solid fa-pen-to-square edit-icon"></i>
                        </div>
                </div>

                <h2>Segurança da Conta</h2>

                <div class="form-group">
                    <label for="email">Email</label>
                        <div class="input-wrapper">
                            <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            placeholder="">
                            <i class="fa-solid fa-pen-to-square edit-icon"></i>

                        </div>
                </div>

                <div class="form-group">
                    <label for="celular">Telefone</label>
                        <div class="input-wrapper">
                            <input
                             type="tel" 
                             id="celular" 
                             name="celular" 
                             placeholder="">
                            <i class="fa-solid fa-pen-to-square edit-icon"></i>

                        </div>
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                        <div class="input-wrapper">
                            <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="">
                            <i class="fa-solid fa-pen-to-square edit-icon"></i>

                        </div>
                </div>

                <div class="suporte-area">
                    <h2>Suporte</h2>
                    <a href="" class="delete-account"><i class="fa-regular fa-trash-can" style="color:#dc2626;"></i> Excluir minha conta </a>
                    <p>Exclua permanentemente a conta e remova o acesso de todos os espaços de trabalho.</p>
                </div>

                <div class="form-footer">
                    <button type="submit" class="submit-button">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>



    
    <script src="/styles/javaScript/modal.js">
        window.expenseToEdit = <?php echo json_encode($expense_to_edit ?? null); ?>;
        //Cria a váriavel global para os dados do usuario
        window.userData = <?php echo json_encode($userData ?? null); ?>;
    </script>

</body>
</html>