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
