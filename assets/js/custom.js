$('input[type="file"]').change(function(e){
    var fileName = e.target.files[0].name;
    $('.custom-file-label').html(fileName);
});

document.addEventListener('scroll', function(e) {
    if (window.scrollY > 35) {
        document.querySelector('.navbar').classList.add('js-navbar-not-transparent');
        document.querySelector('.navbar-brand').classList.add('js-change-navbar-color');
        document.querySelectorAll('.nav-link').forEach(element => {
            element.classList.add('js-change-navbar-color')
        });
    } else {
        document.querySelector('.navbar').classList.remove('js-navbar-not-transparent');
        document.querySelector('.navbar-brand').classList.remove('js-change-navbar-logo-color');
        document.querySelectorAll('.nav-link').forEach(element => {
            element.classList.remove('js-change-navbar-color')
        });
    }
});