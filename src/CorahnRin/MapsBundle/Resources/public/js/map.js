
function Map(id, zoom) {
    this.id = id;
    this.zoom = {
        'actual': zoom,
        'max': 0
    };
    this.name = '';
    this.nameSlug = '';
    this.apiUrl = '../';
    this.init = function(id){
        
    }
}