document.querySelector('.login-form-container').addEventListener('submit',function(){
    const btn = document.querySelector('button[type="submit"]');
    if(btn){
        btn.innerHTML = 'Connexion...';
        btn.setAttribute('disabled','disabled');
        btn.classList.add('submitting-btn');
    }
});
