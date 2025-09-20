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