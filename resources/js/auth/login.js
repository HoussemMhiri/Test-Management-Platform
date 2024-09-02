$(document).ready(function () {
    const container = $("#container");
    const registerBtn = $("#register-btn");
    const signInBtn = $("#sign-in-btn");

    $(registerBtn).on('click', function () {
        container.addClass("active");
    });

    $(signInBtn).on('click', function () {
        container.removeClass("active");
    });
});
