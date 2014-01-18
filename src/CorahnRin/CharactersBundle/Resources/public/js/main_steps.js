(function($){

    /**
     * Fonction permettant d'utiliser des div pour changer la valeur d'un input
     */
    $('.gen-div-choice').click(function(){
        var node = document.getElementsByClassName('gen-div-choice'), count = node.length;
        if (this.classList.contains('selected')) {
            return false;
        }
        for (var i = 0; i < count; i++) {
            node[i].classList.remove('selected');
        }
        this.classList.add('selected');
        if (this.getAttribute('data-target-node')) {
            node = document.querySelector(this.getAttribute('data-target-node'));
        } else {
            node = document.getElementById('gen-div-choice');
        }
        node.value = this.getAttribute('data-div-choice-value');
    });

    /**
     * Fonction permettant d'activer les boutons et un input associé
     */
    $('[data-toggle="btn-gen-choice"]').bind('mousedown', function(){var e=this;setTimeout(function(){
        var node, count,i=0,prev = e.previousElementSibling;
        node = document.querySelectorAll('[data-toggle="btn-gen-choice"].active');
        count = node.length;
        for (i=0;i<count;i++){
            node[i].classList.remove('active');
            if (node[i].previousElementSibling.classList.contains('btn')) {
                node[i].previousElementSibling.classList.remove('active');
            }
        }
        e.classList.add('active');
        if (prev.classList.contains('btn')) {
            prev.classList.add('active');
        }
        document.getElementById(e.getAttribute('data-target-node')).value = e.getAttribute('data-input-value');
    },1);});

    $('[data-toggle="btn-dist-click"]').bind('mouseup', function(){
        $(document.getElementById(this.getAttribute('data-target-node'))).mousedown();
    });
})(jQuery);