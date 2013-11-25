(function($){

    /**
     * Fonction permettant d'utiliser des div pour changer la valeur d'un input
     */
    $('.gen-div-choice').click(function(){
        var node;
        if (this.classList.contains('selected')) {
            return false;
        }
        $('.gen-div-choice').removeClass('selected');
        this.classList.add('selected');
        if (this.getAttribute('data-target-node')) {
            node = document.querySelector(this.getAttribute('data-target-node'));
        } else {
            node = document.getElementById('gen-div-choice');
        }
        node.value = this.getAttribute('data-div-choice-value');
    });
})(jQuery);