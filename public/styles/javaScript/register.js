// =============================================
// FUNÇÕES AUXILIARES 
// =============================================
function isEmpty(value) {
    return value.trim() === '';
}

function showError(inputElement, message) {
    const errorElement = inputElement.nextElementSibling;//p 
    
    errorElement.textContent = message;
    errorElement.className = 'mensagem-erro visivel invalid'; 
    
    inputElement.classList.add('invalid');
    inputElement.classList.remove('valid');
}

function setSuccess(inputElement) {
    const errorElement = inputElement.nextElementSibling;
    errorElement.textContent = ''; 
    inputElement.classList.add('valid');
    inputElement.classList.remove('invalid');
    errorElement.classList.remove('visivel');
}

function isEmailForm(email){
    const emailRegex = new RegExp(
        /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
    )
     // O método .test() da RegEx retorna true se o email corresponder ao padrão, e false caso contrário
    return emailRegex.test(email);
}

// =============================================
// SELETORES GLOBAIS
// =============================================
const form = document.querySelector('.formulario-cadastro');
const firstNameInput = document.getElementById("first_name");
const lastNameInput = document.getElementById('last_name');
const emailInput = document.getElementById('email');
const phoneNumberInput = document.getElementById('number_phone');
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('confirm_password');

// =============================================
// FUNÇÕES DE VALIDAÇÃO
// =============================================

function validateFirstName() {
    const firstNameValue = firstNameInput.value;
    const minCaracteres = 3;

    if (isEmpty(firstNameValue)) {
        showError(firstNameInput, 'O campo é obrigatório!');
        return false;
    }

    if (firstNameValue.length < minCaracteres) {
        showError(firstNameInput, `O nome deve ter no mínimo ${minCaracteres} caracteres.`);
        return false;
    }

    setSuccess(firstNameInput);
    return true;
}

function validateLastName() {
    const lastNameValue = lastNameInput.value;
    const minCaracteres = 2;

    if (isEmpty(lastNameValue)) {
        showError(lastNameInput, 'O campo é obrigatório.');
        return false; 
    }

    if (lastNameValue.length < minCaracteres) {
        showError(lastNameInput, `O sobrenome deve ter no mínimo ${minCaracteres} caracteres.`);
        return false;
    }

    setSuccess(lastNameInput);
    return true;
}

function validateEmail(){
    const emailInputValue = emailInput.value;

    if(isEmpty(emailInputValue)){
        showError(emailInput,'O campo é obrigatório');
        return false;
    }

    if(!isEmailForm(emailInputValue)){
        showError(emailInput,'Formato de email inválido. Exemplo: contato@meusite.com.')
        return false;
    }

    setSuccess(emailInput);
    return true;
}

function validatePhoneNumber(){
    const phoneNumberValue = phoneNumberInput.value;
    const invalidCharsRegex = /[^0-9()\-\s]/; 
    const onlyNumbers = phoneNumberValue.replace(/\D/g, '');


    if(isEmpty(phoneNumberValue)){
        showError(phoneNumberInput,'O campo é obrigatório');
        return false;
    }
    //REGRA 2: Checa se existem caracteres INVÁLIDOS
    if (invalidCharsRegex.test(phoneNumberValue)) {
        showError(phoneNumberInput, 'O celular contém caracteres inválidos. Use apenas números.');
        return false; 
    }
    // Deve ter 10 (telefone fixo) ou 11 (celular) dígitos.
    if (onlyNumbers.length < 10 || onlyNumbers.length > 11) {
        showError(phoneNumberInput, 'O número de celular é inválido. Inclua o DDD.');
        return false;
    }
    setSuccess(phoneNumberInput);
    return true;
}

function validatePassword(){
    const passwordValue = passwordInput.value;
    const minCaracteres = 8;

    if(isEmpty(passwordValue)){
        showError(passwordInput,'O campo é obrigatorio');
        return false;
    }

    if(passwordValue.length < minCaracteres ){
        showError(passwordInput, `A senha deve ter no mínimo ${minCaracteres} caracteres.`);
        return false;
    }

    //Garante a segurança do usuario
    if(!/\d/.test(passwordValue)){
        showError(passwordInput, 'A senha deve conter pelo menos um número.');
        return false;
    }
    if(!/[A-Z]/.test(passwordValue)){
        showError(passwordInput, 'A senha deve conter pelo menos uma letra maiuscula');
        return false;
    }

    if(!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(passwordValue)){
        showError(passwordInput, 'A senha deve conter pelo menos um caracter especial.');
        return false;
    }

    setSuccess(passwordInput);
    return true
}


function validatePasswordComfirm(){
    const confirmPasswordValue = confirmPasswordInput.value;
    const passwordValue = passwordInput.value;

    if(isEmpty(confirmPasswordValue)){
        showError(confirmPasswordInput,'O campo é obrigatorio');
        return false;
    }
    if(confirmPasswordValue != passwordValue){
        showError(confirmPasswordInput,"As senhas não coincidem.")
        return false
    }
    setSuccess(confirmPasswordInput);
    return true
}
// =============================================
// EVENT LISTENER PRINCIPAL
// =============================================

form.addEventListener('submit', (event) => {
    event.preventDefault();

    const isFirstNameValid = validateFirstName();
    const isLastNameValid = validateLastName();
    const isEmailValid = validateEmail();
    const isPhoneNumberValid = validatePhoneNumber();
    const isPasswordValid = validatePassword()
    const isComfirmPasswordValid = validatePasswordComfirm()

    const validator = [
        isFirstNameValid ,
        isLastNameValid ,
        isEmailValid ,
        isPhoneNumberValid ,
        isPasswordValid ,
        isComfirmPasswordValid,
    ]
    //Garante que o formulario só será enviado caso todasas verificações sejam true
    const isformValid = validator.every(result => result === true);
    
    if(isformValid){
        form.submit();
    }
});