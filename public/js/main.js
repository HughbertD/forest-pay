$(function () {

    /**
     * Sends an AJAX request, from the modal, handles reloading new data and mapping errors
     *
     * @param data - data to be sent in POST request
     * @param formUrl - URL to send the data to
     * @param reloadContainer - container to be reloaded on success
     * @param reloadUrl - url to load that container with
     * @param $modal - modal instance to be closed on success
     * @param $form - form within the modal to apply styles, warnings and validation on
     */
    var sendModalBasedAjaxRequest = function (data, formUrl, reloadContainer, reloadUrl, $modal, $form, successText) {
        $.ajax(formUrl, {
            method: 'POST',
            data: data,
            beforeSend: function () {
                // Clear the form of feedback
                $form.find('div.form-control-feedback').remove();
                $form.find('div.has-danger').removeClass('has-danger');
                $modal.find('div.modal-footer').hide();
            },
            success: function () {
                $modal.find('.modal-body').html('<div class="card-block"><h6 class="card-subtitle mb-2 text-muted">Thank you</h6><p class="card-text">' + successText + '</p></div>');
                setTimeout(function () {
                    // Reload content into the parent container
                    if (reloadContainer == 'document') {
                        window.location.href = reloadUrl;
                        return;
                    }
                    $(reloadContainer).load(reloadUrl, function () {
                        $modal.modal('hide');
                    });
                }, 2000);
            },
            error: function (response) {
                $modal.find('div.modal-footer').show();
                // Add validation issues into the form
                $.each(response.responseJSON, function (i, errors) {
                    var $formElementContainer = $form.find('div[data-error="'+i+'"]');
                    $formElementContainer.addClass('has-danger');
                    $formElementContainer.append("<div class='form-control-feedback'>" + errors.join(', ') + "</div>");
                });
            }
        });
    }

    /**
     *
     * @param $form
     * @param $modal
     */
    var userSearch = function ($form, $modal) {
        var formUrl = $form.attr('action');
        var data = $form.serializeArray();
        var username = data[0]['value'];
        $.ajax(formUrl + '/' + username, {
            method: 'GET',
            data: $form.serialize(),
            beforeSend: function () {
                $form.find('div.form-control-feedback').remove();
                $form.find('div.has-danger').removeClass('has-danger');
            },
            success: function () {
                $modal.find('.modal-header > .modal-title').html($form.data('modal-title'));
                $modal.find('.modal-body').load($form.data('modal-body') + '/' +username, function () {
                    $modal.modal('show');
                    var $form = $modal.find('form');
                    var url = $form.attr('action');
                    var $submit = $modal.find('[data-modal-button]');
                    $submit.on('click', function (e) {
                        e.preventDefault();
                        sendModalBasedAjaxRequest($form.serialize(), url, 'document', '/me', $modal, $form, 'Your payment is being processed');
                    });
                });
            },
            error: function () {
                // cannot find user
                var $formElementContainer = $form.find('div[data-error="username"]');
                $formElementContainer.addClass('has-danger');
                $formElementContainer.append("<div class='form-control-feedback'>We couldn't find a with that email address</div>");
            }
        });
    };

    var $modal = $('#modal');
    $modal.on('show.bs.modal', function (e) {
        $modal.find('div.modal-footer').show();
    });
    // Load a dynamic modal based on link attributes
    $('body').on('click', '[data-modal]', function (e) {
        e.preventDefault();
        var $submit = $modal.find('[data-modal-button]');
        $modal.on('hide.bs.modal', function (e) {
            $submit.off('click');
        });
        $modal.modal('show');

        var reloadContainer = $(this).data('modal-get-container');
        var reloadUrl = $(this).data('modal-get');
        var title = $(this).data('modal-title');

        var successText = "We're redirecting you now";
        if ($(this).data('modal-success-text')) {
            successText = $(this).data('modal-success-text');
        }

        $modal.find('.modal-header > .modal-title').html(title);
        $modal.find('.modal-body').load($(this).attr('href'), function () {
            var $form = $modal.find('form');
            var url = $form.attr('action');

            $submit.on('click', function (e) {
                e.preventDefault();
                sendModalBasedAjaxRequest($form.serialize(), url, reloadContainer, reloadUrl, $modal, $form, successText);
            });
        });
    });

    var $userSearchForm = $('form#userSearch');
    $userSearchForm.on('submit', function (e) {
        e.preventDefault();
        userSearch($userSearchForm, $modal);
    });
});