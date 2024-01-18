// login-modal
let signInNext = document.getElementById("sign-in-next");
function next(){
    let itemsToHide = document.getElementsByClassName("hide-sign-in-body");
    let hiddenForm = document.getElementById("hidden-form");
    // hide
    for(let i = 0; i < itemsToHide.length ; i++)
    {
        itemsToHide[i].classList.remove('d-block');
        itemsToHide[i].classList.add('d-none');
    }
    hiddenForm.classList.remove("d-none");
    hiddenForm.classList.add("d-block");
}
function back(){
    let itemsToHide = document.getElementsByClassName("hide-sign-in-body");
    let hiddenForm = document.getElementById("hidden-form");
    // hide
    for(let i = 0; i < itemsToHide.length ; i++)
    {
        itemsToHide[i].classList.remove('d-none');
        itemsToHide[i].classList.add('d-block');
    }
    hiddenForm.classList.remove("d-block");
    hiddenForm.classList.add("d-none");
}   
function validateEmail(email){
    var regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');
    return regex.test(email);
}  
function validatePassoword(password){
    return password.length>8;
}
signInNext?.addEventListener('click', (e) => {
    // validate first
    let signInEmailFirst = document.getElementById("sign-in-email-first");
    let email = document.getElementById("email");
    let error = document.getElementById('sign-in-email-first-error');
    email?.setAttribute("value", signInEmailFirst.value);
    if(validateEmail(signInEmailFirst.value)){
        if(signInEmailFirst.classList.contains("border-danger"))signInEmailFirst.classList.remove("border-danger");
        if(!error.classList.contains('invisible'))error.classList.add('invisible');
        next();
    }
    else{
        // ERROR
        signInEmailFirst.classList.add("border-danger");
        if(error.classList.contains('invisible'))error.classList.remove('invisible');
    }
});
let closeButtonModal = document.getElementById('modal-dismiss');
closeButtonModal?.addEventListener('click', (e) => {
    back();
});
// signup-modal
let signUpNext = document.getElementById('sign-up-next');
signUpNext?.addEventListener('click' , (e)=>{
    let email = document.getElementById('email-sign-up');
    let password = document.getElementById('password-sign-up');
    let emailError = document.getElementById('email-sign-up-error');
    let passwordError = document.getElementById('password-sign-up-error');
    if(validateEmail(email.value)){
        if(email.classList.contains('border-danger'))email.classList.remove('border-danger');
        if(!emailError.classList.contains('d-none'))emailError.classList.add('d-none');
    }
    else{
        email.classList.add('border-danger');
        if(emailError.classList.contains('d-none'))emailError.classList.remove('d-none');
    }
    if(validatePassoword(password.value)){
        if(password.classList.contains('border-danger'))password.classList.remove('border-danger');
        if(!passwordError.classList.contains('d-none'))passwordError.classList.add('d-none');
    }
    else{
        password.classList.add('border-danger');
        if(passwordError.classList.contains('d-none'))passwordError.classList.remove('d-none');
    }
    if(validateEmail(email.value) && validatePassoword(password.value))e.submit();
    e.preventDefault();
})