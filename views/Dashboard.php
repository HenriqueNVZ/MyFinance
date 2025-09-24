<?php
//Além da verificação no método index, há a verificação na view -garantindo a segurança do dashboard em duas camadas


// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}
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
                                        <form action="/editExpense" method="POST"> 
                                            <button class="btn-action btn-edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </form>

                                        <form action="/deleteExpense" method="POST"> 
                                            <button class="btn-action btn-edit">
                                                <i class="fa-solid fa-trash-can"></i>
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

<!-- Adicionar o css e javascript para mostrar e tirar o modal -->
    <div class="modal">
        <div class="modal-content">
            <div class="close">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="title">
                Adicionar Novo Gasto
            </div>

            <form action="\addExpense" method="POST">

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
    <script src="/styles/javaScript/modal.js"></script>
</body>
</html>