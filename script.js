// script.js  

const loginBtn = document.getElementById('login-btn');  
const signupBtn = document.getElementById('signup-btn');  
const loginBox = document.getElementById('login-box');  
const signupBox = document.getElementById('signup-box');  
const switchToSignup = document.getElementById('switch-to-signup');  
const switchToLogin = document.getElementById('switch-to-login');  

loginBtn.addEventListener('click', () => {  
    loginBox.style.display = 'block';  
    signupBox.style.display = 'none';  
});  

signupBtn.addEventListener('click', () => {  
    signupBox.style.display = 'block';  
    loginBox.style.display = 'none';  
});  

switchToSignup.addEventListener('click', (e) => {  
    e.preventDefault();  
    signupBox.style.display = 'block';  
    loginBox.style.display = 'none';  
});  

switchToLogin.addEventListener('click', (e) => {  
    e.preventDefault();  
    loginBox.style.display = 'block';  
    signupBox.style.display = 'none';  
});