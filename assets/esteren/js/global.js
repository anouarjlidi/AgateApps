window._enableJsComponents = null;

(function($, d){
    "use strict";

    function enableJsComponents(context) {
        // Automatically activate button collapse "side" navigation
        if (context.querySelector('.button-collapse')) {
            $('.button-collapse').sideNav();
        }

        // Automatically add parallax when available
        if (context.querySelector('.parallax')) {
            $('.parallax').parallax();
        }

        // Automatically activate tooltips
        if (context.querySelector('.tooltipped')) {
            $('.tooltipped').tooltip();
        }

        // Automatically activate modals
        if (context.querySelector('.modal')) {
            $('.modal').modal();
        }

        // Automatically activate materialize select tags
        if (context.querySelector('select')) {
            $('select').material_select();
        }

        if (context.querySelector('.chips')) {
            $('.chips').material_chip();
        }

        // Automatically activate dropdowns if there are some
        if (context.querySelector('.dropdown-button')) {
            $('.dropdown-button').dropdown();
        }
    }

    // Manage the "disable tags" cookie CNIL requirement
    var button = d.querySelector('button.disable_tags');
    if (button) {
        button.addEventListener('click', function(e){
            if (e.target.tagName.toLowerCase() === 'button' && e.target.className.match('disable_tags')) {
                d.cookie = "disable_tags=1";
                e.target.innerHTML = 'OK';
            }
        });
    }

    enableJsComponents(d);

    window._enableJsComponents = enableJsComponents;
})(jQuery, document);
