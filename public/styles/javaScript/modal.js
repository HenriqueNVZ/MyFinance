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
console.log(window.expenseToEdit);

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