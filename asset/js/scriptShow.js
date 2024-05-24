document.getElementById('show_login').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('.card_container').classList.add('show-login');
    document.querySelector('.card_container').classList.remove('show-register');
});

document.getElementById('show_register').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('.card_container').classList.add('show-register');
    document.querySelector('.card_container').classList.remove('show-login');
});