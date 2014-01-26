(function($){
    $('[data-toggle="tooltip"]').tooltip('destroy').tooltip({
        "placement" : function(event,element){
            return element.getAttribute('data-placement') ? element.getAttribute('data-placement') : 'auto bottom';
        },
        "container": "body"
    });
})(jQuery);

function reloadCss(){$('link').map(function(i,e){r=e.href;e.href='';e.href=r;});}