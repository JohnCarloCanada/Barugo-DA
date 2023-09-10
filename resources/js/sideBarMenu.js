let menu = document.querySelector("[data-menu]");
let sidebar = document.querySelector("[data-sidebar]");

menu.addEventListener("click", () => {
    sidebar.classList.toggle("isHidden");
});
