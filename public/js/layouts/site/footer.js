let scrollTop = document.querySelector(".btn_scroll");

window.addEventListener("scroll", () => {
    if (window.scrollY > 200) {
        scrollTop.classList.add("active");
    } else {
        scrollTop.classList.remove("active");
    }
});
