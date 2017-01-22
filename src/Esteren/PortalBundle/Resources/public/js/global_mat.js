(function($, d){$(function(){

    // Automatically activate button collapse "side" navigation
    if (d.querySelector('.button-collapse')) {
        $('.button-collapse').sideNav();
    }

    // Automatically add parallax when available
    if (d.querySelector('.parallax')) {
        $('.parallax').parallax();
    }

    // Automatically activate tooltips
    if (d.querySelector('.tooltipped')) {
        $('.tooltipped').tooltip();
    }

    // Automatically activate modals
    if (d.querySelector('.modal')) {
        $('.modal').modal();
    }

    // Automatically activate materialize select tags
    if (d.querySelector('select')) {
        $('select').material_select();
    }

    // Manage the "disable tags" cookie CNIL requirement
    if (d.querySelector('button.disable_tags')) {
        d.addEventListener('click', function(e){
            if (e.target.tagName.toLowerCase() === 'button' && e.target.className.match('disable_tags')) {
                d.cookie = "disable_tags=1";
                e.target.innerHTML = 'OK';
            }
        });
    }

})})(jQuery, document);
