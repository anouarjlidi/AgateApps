(function($, d){$(function(){

    // Activate button collapse "side" navigation
    if (d.querySelector('.button-collapse')) {
        $('.button-collapse').sideNav();
    }

    // Add parallax when available
    if (d.querySelector('.parallax')) {
        $('.parallax').parallax();
    }

    // Automatically activate modals
    if (d.querySelector('.modal')) {
        $('.modal').modal();
    }

})})(jQuery, document);
