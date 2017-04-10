$(function () {
    // Load a dynamic modal based on link attributes
    $('[data-modal]').on('click', function (e) {
        e.preventDefault();
        var $modal = $('#modal');
        $modal.modal('show');

        var reloadContainer = $(this).data('modal-get-container');
        var reloadUrl = $(this).data('modal-get');
        var title = $(this).data('modal-title');

        $modal.find('.modal-header > .modal-title').html(title);
        $modal.find('.modal-body').load($(this).attr('href'), function () {
            var $form = $modal.find('form');
            var url = $form.attr('action');

            $modal.find('[data-modal-button]').on('click', function (e) {
                e.preventDefault();
                sendModalBasedAjaxRequest($form.serialize(), url, reloadContainer, reloadUrl, $modal, $form);
            });
        });

    });

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
    var sendModalBasedAjaxRequest = function sendAjaxRequest(data, formUrl, reloadContainer, reloadUrl, $modal, $form) {
        $.ajax(formUrl, {
            method: 'POST',
            data: data,
            beforeSend: function () {
                // Clear the form of feedback
                $form.find('div.form-control-feedback').remove();
                $form.find('div.has-danger').removeClass('has-danger');
            },
            success: function () {
                // Reload content into the parent container
                $(reloadContainer).load(reloadUrl, function () {
                    $modal.modal('hide');
                });
            },
            error: function (response) {
                // Add validation issues into the form
                $.each(response.responseJSON, function (i, errors) {
                    var $formElementContainer = $form.find('div[data-error="'+i+'"]');
                    $formElementContainer.addClass('has-danger');
                    $formElementContainer.append("<div class='form-control-feedback'>" + errors.join(', ') + "</div>");
                });
            }
        });
    }

});