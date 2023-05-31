const burger = document.querySelector(".burger");
const navMenu = document.querySelector(".nav-menu");
const navLink = document.querySelector(".nav-link");


burger.onclick = function () {
    burger.classList.toggle("active");
}


burger.addEventListener("click", () => {

    navMenu.classList.toggle("active");
    navLink.classList.toggle("mobile-menu");
});
