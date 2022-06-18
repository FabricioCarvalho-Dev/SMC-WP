jQuery(function($) {
    let $tools = $('.bookly-js-tools'),
        $toolsResponseModal = $('#bookly-tool-response-dialog'),
        toolClass
    ;

    $tools.on('click', '[data-action]', function (e) {
        e.preventDefault();
        let $btn = $(this),
            ladda = Ladda.create($('a', $btn.closest('.dropdown'))[0]),
            data = $btn.data();
        ladda.start();
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'bookly_run_tool',
                tool: data,
                csrf_token: BooklyL10nGlobal.csrf_token
            },
            dataType: 'json',
            error: function () {
                booklyAlert({error: [data.tool + ' error: in query execution.']});
            }
        }).then(function (response) {
            booklyAlert(response.data.alerts);
            ladda.stop();
            $(document.body).trigger('bookly.tools.completed', [response.data, data.tool]);
        });
    });

    $('#bookly-all-test').on('click', function () {
        let ladda = Ladda.create(this),
            count = BooklyL10n.tests.length,
            error_count = 0,
            errors = []
        ladda.start();
        ladda.setProgress(0.03);

        BooklyL10n.tests.forEach(function(test) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'bookly_run_test',
                    test_name: test
                },
                dataType: 'json',
                error: function () {
                    booklyAlert({error: [test + ' error: in query execution.']});
                }
            }).then(function(response) {
                if (!response.success) {
                    error_count += 1;
                    booklyAlert({error: ['Test: ' + response.data.test_name + '<p><pre>' + response.data.error + '</pre></p>']});
                }

                count -= 1;
                ladda.setProgress(1 - count / BooklyL10n.tests.length);
                if (count <= 0) {
                    ladda.stop();
                    booklyAlert({success: [(BooklyL10n.tests.length - error_count) + '/' + BooklyL10n.tests.length + ' tests complete successfully']});
                }
            });
        })
    }).trigger('click');

    $(document.body).on('bookly.tools.completed', {},
        function (event, data, tool) {
            toolClass = tool;
            if (data.hasOwnProperty('result') && data.result && data.result.length > 0) {
                $toolsResponseModal.booklyModal('show');
                $('.modal-dialog', $toolsResponseModal).addClass('modal-xl');
                $('.modal-title', $toolsResponseModal).html(data.name);
                $('.modal-body', $toolsResponseModal).html(data.result);
                if (tool == 'Phpinfo') {
                    $('.modal-dialog', $toolsResponseModal).addClass('modal-xl');
                } else {
                    $('.modal-dialog', $toolsResponseModal).removeClass('modal-xl');
                }
            }
        }
    );

    $toolsResponseModal
        .on('hidden.bs.modal', function(){
            $('.modal-body', $toolsResponseModal).html('');
        })

        // Actions for tool ShortCodes
        .on('click', '#bookly-js-find-shortcode-and-open', function () {
            let ladda = Ladda.create(this);
            ladda.start();

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'bookly_run_tool',
                    tool: {
                        action: 'find_shortcode',
                        tool: toolClass,
                        shortcode: $('#bookly_shortcode', $toolsResponseModal).val(),
                    },
                    csrf_token: BooklyL10nGlobal.csrf_token
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.data.result;
                    }
                    booklyAlert(response.data.alerts);
                    ladda.stop();
                }
            });
        })

        // Actions for tool FormsData
        .on('click', '#bookly-js-booking-forms button[data-action=copy]', function (e) {
            let $button = $(this),
                form_id = $button.closest('.list-group-item-action').data('form_id');
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'bookly_run_tool',
                    tool: {
                        action: 'get_data',
                        tool: toolClass,
                        form_id: form_id,
                    },
                    csrf_token: BooklyL10nGlobal.csrf_token
                },
                dataType: 'json',
                success: function (response) {
                    let $copied = $('<small>', {
                        class :'ml-2',
                        text: 'copied'
                    });
                    $button.before($copied);
                    $button.hide();
                    const $temp = $('<input/>');
                    $toolsResponseModal.append($temp);
                    $temp.val(response.data.result).select();
                    document.execCommand('copy');
                    $temp.remove();
                    console.group(form_id);
                    console.dir(JSON.parse(response.data.result));
                    console.groupEnd();
                    setTimeout(function () {
                        $copied.remove();
                        $button.show();
                    }, 1000);
                }
            });
        })
        .on('click', '#bookly-js-booking-forms button[data-action=destroy]', function (e) {
            let $li = $(this).closest('.list-group-item-action');
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'bookly_run_tool',
                    tool: {
                        action: 'destroy',
                        tool: toolClass,
                        form_id: $li.data('form_id'),
                    },
                    csrf_token: BooklyL10nGlobal.csrf_token
                },
                dataType: 'json',
                success: function (response) {
                    $li.remove();
                }
            });
        });
})