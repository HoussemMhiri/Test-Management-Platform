$(document).ready(function(){
    var swiper = new Swiper('.testimonial-wrapper .swiper-container', {
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
});
