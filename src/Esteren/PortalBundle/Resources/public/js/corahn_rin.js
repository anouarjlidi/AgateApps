(function($, d, w){

    // Placement dynamique d'une tooltip
    if (d.querySelector('[data-toggle="tooltip"]')) {
        $('[data-toggle="tooltip"]').tooltip({
            "placement" : function(event,element){
                return element.getAttribute('data-placement') ? element.getAttribute('data-placement') : 'auto bottom';
            },
            "container": "body"
        }).on('show.bs.tooltip', function(){
            var btn = this;
            $('[data-toggle="tooltip"]').filter(
                function(i,element){
                    return element != btn;
                }
            ).tooltip('hide');
        });
    }

})(jQuery, document, window);
