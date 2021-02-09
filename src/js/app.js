document.addEventListener("DOMContentLoaded", function() {

    eventListeners();

    darkMode();
})

function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)'); 
    // codigo que analiza la preferencia del sistema en cuanto al color ^

    // console.log(prefiereDarkMode.matches); // da true o false dependiendo el color del sistema (diurno/nocturno)

    if(prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');
    botonDarkMode.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners() {
    const mobileMenu = document.querySelector(".mobile-menu");

    mobileMenu.addEventListener("click", navegacionResponsive);   
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    navegacion.classList.toggle('mostrar') // manera de remplazar el if para quitar y poner una clase
}