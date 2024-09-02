window.addEventListener("scroll", () => {
    let upperNav = document.querySelector(".upper_navCont");
    upperNav.classList.toggle("hidden", window.scrollY > 50);
    let bottomNav = document.querySelector(".bottom_nav");
    bottomNav.classList.toggle("sticky", window.scrollY > 50);
});
