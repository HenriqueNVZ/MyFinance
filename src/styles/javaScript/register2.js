function isEmpty(value){
    return value.trim() === ''
}

function showError(inputElement,message){
    const errorElement = inputElement.nextElementSibling; //</p>
    
    errorElement.textContent = message;
    errorElement.classList.add('visivel');
    inputElement.classList.add('erro'); //input
    inputElement.classList.remove('valido');
}

function cleanError(inputElement){
    const errorElement = inputElement.nextElementSibling;
    errorElement.textContent = '';
    errorElement.classList.remove('visivel');
    inputElement.classList.remove('erro');
}

const form = document.querySelector('.formulario-cadastro');
const firstNameInput = document.getElementById("first_name");
    //Selecionar os outros inputs depois


function validateFirstName(){
    const firstNameValue = document.getElementById("first_name").value;
    const minCaracteres = 3;

    //é vazio?
    if(isEmpty(value)){
        showError(firstNameInput,'O campo é obrigatório!');
        return false;
    }
    //é muito curto?
    if(firstNameValue.lenght < minCaracteres){
        showError(firstNameInput,`O campo deve contar no minimo ${minCaracteres} caracteres`)
    }
    //Válido!
    cleanError(firstNameInput);
    firstNameInput.classList.add('valid')
    return true;
}


form.addEventListener('subtmit',(event) => {
    event.preventDefault();
    const isFirstNameValid = validateFirstName();
    //chamar outras validações dos outros camposs


    if(isFirstNameValid){ //&& ... ){
        form.submit();
    }else{
        console.log('formulario contem erros')
    }
    
})

