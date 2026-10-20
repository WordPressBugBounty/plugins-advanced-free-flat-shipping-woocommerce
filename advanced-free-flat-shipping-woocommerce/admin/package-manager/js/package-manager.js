(function ($) {
    'use strict';

    jQuery(function ($) {

        function enableDisable() {
            jQuery(document).on('change', '.pi-affsw-package-manager-status-change', function (e) {
                var id = jQuery(this).data('id');
                var status = jQuery(this).is(":checked") ? 1 : 0;
                var nonce = jQuery(this).data('nonce');
                jQuery("#pisol-efrs-shipping-method-list-view").addClass('blocktable');
                jQuery.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    data: {
                        id: id,
                        status: status,
                        nonce:nonce,
                        action: 'pisol_affsw_package_manager_change_status'
                    }
                }).always(function (d) {
                    jQuery("#pisol-efrs-shipping-method-list-view").removeClass('blocktable');
                })
            });
        }
        enableDisable();
    });


})(jQuery);