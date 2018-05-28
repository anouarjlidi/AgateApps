/**
 * This method is 99% copy/paste of the original method.
 * The change is simple: the "shown" event is fired
 * if the sidebar is already visible.
 */
L.Control.Sidebar.prototype.show = function () {
    if (!this.isVisible()) {
        L.DomUtil.addClass(this._container, 'visible');
        if (this.options.autoPan) {
            this._map.panBy([-this.getOffset() / 2, 0], {
                duration: 0.5
            });
        }
        this.fire('show');
    } else {
        this.fire('shown');
    }
};
