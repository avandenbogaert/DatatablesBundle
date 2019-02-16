(function ($) {
    $(function () {
        $('table.datatable').each(function () {
            let $element = $(this);

            let defaultOptions = {
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": $(this).data('uri'),
                    "data": function (data) {
                        data['params'] = $element.data('request-params');
                    }
                }
            };

            let $options = $.extend({}, defaultOptions, $(this).data('options'));
            let $table = $(this).DataTable($options);

            $.DatatablesManager.register($(this).data('alias'), $table);
        });
    });
})(jQuery);