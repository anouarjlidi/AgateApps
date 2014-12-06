var e = document.querySelectorAll('button.btn[id^="map_hide_"]');
for(var i=0,l=e.length; i<l ; i++) {
    e[i].onclick = function(){
        var id = this.id.replace('map_hide_',''),
            styleNode = document.getElementById('map_add_style'),
            selector;
        if (id === 'zones') {
            selector = 'polygon,.map-icon-target[data-target-element^="map_add_zone"]';
        } else if (id === 'routes') {
            selector = 'polyline,.map-icon-target[data-target-element^="map_add_route"]';
        } else if (id === 'markers') {
            selector = 'div#map_markers .map-marker';
        }
        selector += '{display:none;}';
        styleNode.innerHTML = styleNode.innerHTML.replace(selector,'');
        this.classList.remove('text-green');
        this.classList.remove('text-darkred');
        if (this.classList.contains('active')) {
            this.classList.remove('active');
            this.classList.add('text-green');
        } else {
            styleNode.innerHTML += selector;
            this.classList.add('active');
            this.classList.add('text-darkred');
        }
    };
}