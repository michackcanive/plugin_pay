document.addEventListener('DOMContentLoaded', function (e) {
    const showAuthBtn = document.getElementById('ajec-show-auth-form'),
        authContainer = document.getElementById('ajec-auth-container'),
        close = document.getElementById('ajec-auth-close');
    
    showAuthBtn.addEventListener('click', () => {
        authContainer.classList.add('show');        
        showAuthBtn.parentElement.classList.add('hide');
    });

    close.addEventListener('click', () => {
        authContainer.classList.remove('show');
        showAuthBtn.parentElement.classList.remove('hide');
    });
});