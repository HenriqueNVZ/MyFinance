//SELETORES
const modal = document.querySelector(".modal");
const btnAddExpense = document.querySelector(".btn-add-gasto");
const btnCloseModal = document.querySelector(".close");

//Abre o modal
btnAddExpense.addEventListener("click",(event) => {
    event.preventDefault();
    modal.classList.add("active");
})

//Fecha o modal
btnCloseModal.addEventListener("click",(event) =>{
    modal.classList.remove("active");
})


///CÓDIGO PARA O UPDATE DOS GASTOS
//Seletores
const ModalForm = document.querySelector('.modal-form');
const inputValue = document.querySelector("#valor");
const categoria = document.querySelector("#categoria");
const descricao = document.querySelector("#description");
const inputDate = document.querySelector("#date");
const idHidden = document.getElementById('expense-id-hidden');
const title = document.querySelector('.title');
const modalButton = document.querySelector('.btn-add');
    if(window.expenseToEdit){
        //Altera a action do form do modal para evitar criar um novo gasto ao invés de editar
        ModalForm.action = '/updateExpense'
        //Abre o modal
        modal.classList.add("active");
        //preenche o modal com os dados atuais,pegando do JSON enviado pelo script
        inputValue.value = expenseToEdit.valor;
        categoria.value = expenseToEdit.categoria;
        descricao.value = expenseToEdit.descricao;
        inputDate.value = expenseToEdit.data_gasto;
        //preenche o id oculto
        idHidden.value = expenseToEdit.id;
        //altera o botão de enviar e o titulo
        modalButton.innerHTML = "Atualizar";
        title.innerHTML = "Atualizar Gasto";
    }else{
        ModalForm.action = '/addExpense';
        modalButton.innerHTML = "Adicionar";
        title.innerHTML = "Adicionar Novo Gasto";
    }

///CODIGO PARA DELETE DE GASTOS

//Seletores das actions
const deleteButtons = document.querySelectorAll('.btn-delete');//Todos os botões de lixeiras
const HiddenInputId = document.getElementById("delete-gasto-id");
const confirmDeleteForm = document.querySelector('#confirm-delete-form');

//Seletores do modal
const deleteModal = document.querySelector('.delete-modal'); //O modal
const cancelButton = document.querySelector('.btn-cancel');
let gastoId = null;

//Abre o modal de exlusão 
deleteButtons.forEach(button => {
  button.addEventListener("click", (event) => {
        textAreaDelete.innerHTML = 'Deseja realmente excluir este gasto?'
        modalDeleteForm.action = '/deleteExpense';
        // 1. Encontra o form pai do botão que foi clicado
        const formTrigger = event.currentTarget.closest('.form-delete-gasto');
        
        // 2. Encontra o INPUT HIDDEN dentro desse form
        const hiddenInput = formTrigger.querySelector('.expense-id-input');
        
        // 3. Pega o ID
        const gastoId = hiddenInput.value;
        
        // 4. INJETA o ID no campo oculto do FORMULÁRIO DENTRO DO MODAL
        HiddenInputId.value = gastoId;
        console.log("ID capturado ao clicar na lixeira:", gastoId);

        // 5. Abre o modal de confirmação
        deleteModal.classList.add('active');
  });
});

//Fecha o modal de exlusão
cancelButton.addEventListener("click", (event) => {
    const HiddenInputId = document.getElementById('delete-gasto-id');
    HiddenInputId.value = ''; 
    deleteModal.classList.remove("active");
});

document.getElementById('confirm-delete-form').addEventListener('submit', function (e) {
    const id = document.getElementById('delete-gasto-id').value;
    console.log("Formulário enviado com ID:", id);
});


///MODAL DO PERFIL
//SELETORES 
const perfilIcon = document.querySelector("#user_icon");
const ModalPerfil = document.querySelector(".perfil-modal");
const CloseModal = document.querySelector('.icon-close')
const deleteCount = document.querySelector('.delete-account');
const textAreaDelete = document.querySelector('.delete-modal .text');
const modalDeleteForm = document.querySelector('#confirm-delete-form');

const inputName = document.querySelector("#nome");
const inputEmail = document.querySelector('#email')
const inputCelular = document.querySelector('#celular')

//Abre o modal

//Fecha o modal
CloseModal.addEventListener("click",(event) =>{
    event.preventDefault(); 
    ModalPerfil.classList.remove('active');
})

deleteCount.addEventListener("click",(event) =>{
    event.preventDefault();
    //Prepara o modal: altera o padrão html que seria para excluir um gasto para excluir um usuario
    textAreaDelete.innerHTML = 'Deseja realmente excluir este usuario?'
    //Altera a action do form original do modal delete
    modalDeleteForm.action = '/deleteUser';
    //Abre o modal de confirmação
    deleteModal.classList.add('active');
    
})


const userData = window.userData;
perfilIcon.addEventListener("click", (event) => {
    event.preventDefault();

    fetch('/api/profile-data') // <--- Requisição HTTP (GET) para o servidor
        .then(response => {
            // ... lógica para checar o status e converter para JSON ...
            return response.json();
        })
        .then(userData => {
            // ... lógica para preencher os inputs do modal com userData.nome, etc. ...
            inputName.value = userData['first_name'];
            inputEmail.value = userData['email'];
            inputCelular.value = userData['celular'];   
            ModalPerfil.classList.add('active'); 
        })
        .catch(error => {
            console.error('Erro:', error);
        });
});

