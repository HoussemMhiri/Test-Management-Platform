/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./resources/js/auth/login.js ***!
  \************************************/
$(document).ready(function () {
  var container = $("#container");
  var registerBtn = $("#register-btn");
  var signInBtn = $("#sign-in-btn");
  $(registerBtn).on('click', function () {
    container.addClass("active");
  });
  $(signInBtn).on('click', function () {
    container.removeClass("active");
  });
});
/******/ })()
;