const modal = document.querySelector(".modal");
const btnAddExpense = document.querySelector(".btn-add-gasto");
const btnCloseModal = document.querySelector(".close");

btnAddExpense.addEventListener("click",(event) => {
    
    event.preventDefault();
    modal.classList.add("active");
})

btnCloseModal.addEventListener("click",(event) =>{
    modal.classList.remove("active");
})