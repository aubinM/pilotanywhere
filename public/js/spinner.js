(function ($) {
    $.fn.buttonLoader = function (action) {
        var self = $(this);
        if (action == 'start') {
            if ($(self).attr("disabled") == "disabled") {
                e.preventDefault();
            }
            $('.has-spinner').attr("disabled", "disabled");
            $(self).attr('data-btn-text', $(self).text());
            $(self).html('<span class="spinner"><i class="fa fa-spinner fa-spin"></i></span>Chargement');
            $(self).addClass('active');
        }
        if (action == 'stop') {
            $(self).html($(self).attr('data-btn-text'));
            $(self).removeClass('active');
            $('.has-spinner').removeAttr("disabled");
        }
    }
})(jQuery);

$(document).ready(function () {

    $('.has-spinner').click(function () {
        var btn = $(this);
        $(btn).buttonLoader('start');
        setTimeout(function () {
            $(btn).buttonLoader('stop');
        }, 20000);
    });
    $("#precedent").click(function () {
        $("#container").replaceWith("");
        $("#preload").show();
    });
    $("#suivant").click(function () {
        $("#container").replaceWith("");
        $("#preload").show();
    });

    $(document.body).on("keydown", this,
            function (event) {
                if (event.keyCode == 116) {
                    $("#container").replaceWith("");
                    $("#preload").show();
                }
            });



    window.onbeforeunload = function () {
        $("#container").replaceWith("");
        $("#preload").show();
    }
});



