const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link')
const registerLink = document.querySelector('.register-link');
const btnpopup = document.querySelector('.Btnlogin-popup');
const iconclose = document.querySelector('.icon-close')

registerLink.addEventListener('click', ()   =>{
    wrapper.classList.add('active');
})
loginLink.addEventListener('click', ()   =>{
    wrapper.classList.remove('active');
})
btnpopup.addEventListener('click', ()   =>{
    wrapper.classList.add('active-popup');
})
iconclose.addEventListener('click', ()   =>{
    wrapper.classList.remove('active-popup');
})
document.addEventListener('DOMContentLoaded', function() {
    var registerForm = document.querySelector('.register form');
    registerForm.addEventListener('submit', function(event) {
        var termsCheckbox = document.getElementById('terms-checkbox');
        if (!termsCheckbox.checked) {
            event.preventDefault();
            alert('Você precisa concordar com os termos e condições para se registrar.');
        }
    });
});
