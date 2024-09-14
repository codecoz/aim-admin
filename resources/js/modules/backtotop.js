import './../../css/modules/backtotop.css'

$(document).scroll(function () {
    const scrollPosition = $(this).scrollTop();
    if (scrollPosition > 200) { // Adjust 200 to when you want the button to appear
        $('.back-to-top').addClass('show');
    } else {
        $('.back-to-top').removeClass('show');
    }
});

$('.back-to-top').click(function (e) {
    e.preventDefault();
    $('html, body').animate({scrollTop: 0}, 'smooth');
});
