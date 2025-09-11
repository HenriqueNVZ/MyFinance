<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/styles/dashboard.css">
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
                <li><a href="#" class="btn-add-gasto">Adicionar gasto <i class="fa-solid fa-plus"></i></a></li>
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
                        <th class="th-actions">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>vazio</td>
                        <td>vazio</td>
                        <td>vazio</td>
                        <td class="td-actions">
                            <div class="btn-actions">
                            <button class="btn-action btn-edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn-action btn-delete">
                                <i class="fa-solid fa-trash-can"></i>                            
                            </button>
                            </div>
                        </td>                    
                    </tr>
                </tbody>
            </table>
        </div>   

    </main>
</body>
</html>