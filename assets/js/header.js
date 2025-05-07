function toggleMenu() {
    const menuList = document.getElementById("menuList");
    if (menuList) {
        menuList.classList.toggle("active");
    } else {
        console.error("Error: #menuList not found in HTML.");
    }
}
window.onscroll = function() {
    document.querySelector('.navbar').classList.toggle('scrolled', window.scrollY > 50);
};