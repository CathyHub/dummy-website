var app = {};


$(function() {

    app.navigation().init();
    $('#contact-form').validate();
    $('input, textarea').placeholder();


    app.ajaxFormSubmit({
        form: $('#contact-form'),
        successText: $('#form-text'),
        formWrapper: $('.contact-form')
    }).init();

    $('.project-cms-buttons > span').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
});

app.navigation = function() {
    var mobToggle = $('#mob-menu-toggle'),
        mobMenu = $('#mob-menu');

    function init() {
        bindEvents();
    }

    function bindEvents() {
        mobToggle.on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            mobMenu.toggleClass('active');
            $(this).toggleClass('active');
            $('body').toggleClass('scroll-lock');
        });

        mobMenu.on('click', function(e) {
            e.stopPropagation();
        });

        $(window).on('click', function() {
            mobMenu.removeClass('active');
            mobToggle.removeClass('active replace');

            if ($('body').hasClass('scroll-lock')) {
                $('body').removeClass('scroll-lock');
            }
        });
    }

    return {
        init: init
    };
};


app.ajaxFormSubmit = function(options) {
    var form = options.form,
        submit = form.find('.submit'),
        sendUrl = form.attr('action'),
        successText = options.successText;

    function init() {
        bindEvents();
    }

    function bindEvents() {
        submit.click(function(e) {
            e.preventDefault();
            form.submit();
        });

        form.submit(function(e) {
            e.preventDefault();
            var data = form.serialize();

            if (form.valid()) {
                submitForm(data);
            }
        });
    }

    function clearForm() {
        form.find('input[type="text"], textarea').val('');
    }

    function submitForm(data) {

        submit.val('').addClass('ajax-loading');

        setTimeout(function() {
            $.ajax({
                type: 'POST',
                url: sendUrl,
                data: data,
                success: function() {
                    // options.formWrapper.css('height', options.formWrapper.outerHeight() + 10);
                    form.fadeOut(250, function() {
                        successText.html('Thanks for that, we\'ll be in touch shortly.<br><a href="#" class="new-enquiry button">Show Form</a>').fadeIn(150);

                        $('.new-enquiry').on('click', function(e) {
                            e.preventDefault();
                            submit.val('SUBMIT').removeClass('ajax-loading');
                            successText.hide();
                            form.slideDown(150);
                            clearForm();
                        });
                    });
                },
                error: function() {
                    alert('There was an error submitting the form, please try again');
                    submit.val('SUBMIT').removeClass('ajax-loading');
                }
            });
        }, 300);
    }

    return {
        init: init
    };
};