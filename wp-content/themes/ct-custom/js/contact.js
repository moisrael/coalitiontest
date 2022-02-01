jQuery(document).ready(function($) {
    $(document).on('click', function(event) {
        if (event.target != $('.feedback-message')) {
            $('.feedback-message').addClass('inactive');
        }
    });
    
    /* contact form submission */
    $('footer #contact-form').on('submit', function(event) {

        event.preventDefault();

        const form = $(this),
                name = form.find('#name').val(),
                phone = form.find('#phone').val(),
                email = form.find('#email').val(),
                message = form.find('#message').val(),
                ajaxurl = form.data('url');

        if (name === '') {
            $('.contact-form .name-field-container .feedback-message.error').removeClass('inactive');
            return;
        }

        if (phone === '') {
            $('.contact-form .phone-field-container .feedback-message.error').removeClass('inactive');
            return;
        }

        if (email === '') {
            $('.contact-form .email-field-container .feedback-message.error').removeClass('inactive');
            return;
        }

        if (message === '') {
            $('.contact-form .message-field-container .feedback-message.error').removeClass('inactive');
            return;
        }

        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                name: name,
                phone: phone,
                email: email,
                message: message,
                action: 'ct_custom_save_user_contact_form'
            },
            error: function(response) {
                $('.contact-form .submit-button-container .feedback-message.failure').removeClass('inactive');
                setTimeout(function() {
                    $('.contact-form .submit-button-container .feedback-message.failure').addClass('inactive');
                }, 3000);
            },
            success: function(response) {
                $('.contact-form .feedback-message.error').addClass('inactive');
                form.find('input, button, textarea').val('');
                if (response == 0) {
                    $('.contact-form .submit-button-container .feedback-message.failure').removeClass('inactive');
                    setTimeout(function() {
                        $('.contact-form .submit-button-container .feedback-message.failure').addClass('inactive');
                    }, 3000);
                } else {
                    $('.contact-form .submit-button-container .feedback-message.success').removeClass('inactive');
                    setTimeout(function() {
                        $('.contact-form .submit-button-container .feedback-message.success').addClass('inactive');
                    }, 3000);
                }
            }
        });
    });
});