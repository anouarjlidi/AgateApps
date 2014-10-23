
(function($, d, w){

    $(d).ready(function(){
        // Activation des colorpickers
        if (d.querySelectorAll('.colorpicker')) {
            $('.colorpicker').colorpicker({
                regional: typeof CURRENT_LOCALE !== 'undefined' ? CURRENT_LOCALE : 'fr',
                showNoneButton: true,
                alpha: true,
                colorFormat: 'RGBA',
                draggable: true
            });
        }
    });

})(jQuery, document, window);
