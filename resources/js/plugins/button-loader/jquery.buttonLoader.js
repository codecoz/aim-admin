/*A jQuery plugin which add loading indicators into buttons
* By Minoli Perera
* MIT Licensed.
*/
(function ($) {
    $.fn.buttonLoader = function (action) {
        const selfBtn = $(this);

        if (!selfBtn.hasClass('has-spinner')) {
            selfBtn.addClass('has-spinner');
        }
        if (action == 'start') {
            if (selfBtn.attr("disabled") == "disabled") {
                console.log("Button already disabled");
                return false;
            }
            selfBtn.attr('disabled', true);
            selfBtn.attr('data-btn-text', selfBtn.text());
            let btnText = 'Loading...';
            if (selfBtn.attr('data-load-text') != undefined && selfBtn.attr('data-load-text') != "") {
                btnText = selfBtn.attr('data-load-text');
            }
            selfBtn.html('<span><i class="fa fa-spinner fa-spin" title="button-loader"></i></span> ' + btnText);
            selfBtn.addClass('active');
        }
        if (action == 'stop') {
            selfBtn.html(selfBtn.attr('data-btn-text'));
            selfBtn.removeClass('active');
            selfBtn.attr('disabled', false);
        }
    }
})(jQuery);

