// Désactivation du mouvement
document.getElementById('map_dont_move').onclick = function(){
    var active = this.getAttribute('data-active');
    if (active === 'true') {
        // Réactivation du mouvement de la map
        active = 'false';
        document.esterenmap.allowMove(true);
        this.classList.remove('active');
        this.parentNode.classList.remove('active');
        this.children[0].classList.remove('text-danger');
        this.children[0].classList.add('text-success');
    } else {
        // Désactivation du mouvement de la map
        active = 'true';
        document.esterenmap.allowMove(false);
        this.classList.add('active');
        this.parentNode.classList.add('active');
        this.children[0].classList.add('text-danger');
        this.children[0].classList.remove('text-success');
    }
    this.setAttribute('data-active', active);
    return false;
};
