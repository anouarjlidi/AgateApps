(function($){
    $('[data-toggle="tooltip"]').tooltip({
        "placement" : "auto bottom",
        "container": "body"
    });
})(jQuery);

function reloadCss(){$('link').map(function(i,e){r=e.href;e.href='';e.href=r;});}