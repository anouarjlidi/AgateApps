(function($){
    if (document.getElementById('generator_naissance')) {
        document.getElementsByClassName('step_module')[0].className = 'step_module';
        document.getElementsByClassName('step_menu')[0].className = 'step_menu';
        document.getElementsByClassName('step_list')[0].classList.add('list-inline');

        var l = document.getElementsByTagName('polygon'),
        c = l.length,
        i = 0;

        for (i = 0; i < c; i++) {
            $(l[i]).bind('click', function(){
                var l = document.querySelectorAll('polygon.checked'),
                    c = l.length,
                    i = 0;;
                for (var i = 0; i < c; i++) {
                    l[i].classList.remove('checked');
                }
                this.classList.add('checked');
                document.getElementById('region_value').value = this.getAttribute('data-region-id');
            });
        }
    }
})(jQuery);