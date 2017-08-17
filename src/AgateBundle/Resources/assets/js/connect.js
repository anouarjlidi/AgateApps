(function(w, $){

    window._connect = function(){
    var paths = w._CP;

    if (paths && paths.constructor === Array && paths.length) {
        for (var i = 0, l = paths.length; i < l; i++) {
            console.info('Connecting via '+paths[i]);
            $.ajax({
                type: 'post',
                url: paths[i],
                xhrFields: {
                    withCredentials: true
                },
                success: function(response, message) {
                    if ('success' !== message) {
                        console.error('An error occured when connecting...');
                    }
                },
                error: function() {
                    console.error('An error occured when connecting...');
                }
            });
        }
    }
    };
    window._connect();
})(window, jQuery);
