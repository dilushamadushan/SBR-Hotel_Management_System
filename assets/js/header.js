window.onscroll = function () {
    const navbar = document.querySelector('.navbar');
    const menuIcon = document.querySelector('.menuIcon');
    const mobileMenu = document.querySelector('.mobile-menu');

    const scrolled = window.scrollY > 50;

    navbar.classList.toggle('scrolled', scrolled);
    menuIcon.classList.toggle('mItem', scrolled);
    mobileMenu.classList.toggle('mobileMenu',scrolled);
};


function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    if (menu.style.display === 'block') {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'block';
    }
}
