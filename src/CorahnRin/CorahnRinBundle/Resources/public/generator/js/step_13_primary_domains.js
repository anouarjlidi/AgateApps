(function ($, d) {
    var buttons = d.querySelectorAll('.domain button.domain-change');

    function updateDomainValue(button, value) {
        button._data.input.value = value;

        for (var i = 0, list = button._data.btnsList, l = list.length; i < l; i++) {
            if (!list[i]._data) {
                // This may be an input without data, in this case it can be input with 5.
                continue;
            }
            if (list[i]._data.changeValue === value) {
                list[i].classList.add('active');
            } else {
                list[i].classList.remove('active');
            }
        }
    }

    /**
     * @param {string}  cssClass
     * @returns Element
     */
    Element.prototype.findParentByClass = function (cssClass) {
        var element = this;
        while ((element = element.parentElement) && !element.classList.contains(cssClass)) {
            // Do nothing, element var will change automatically. That's the trick.
        }
        return element;
    };

    // At first, we cache DOM elements in the buttons themselves.
    // It avoids looking into the DOM on each click.
    for (var i = 0, l = buttons.length; i < l; i++) {
        var btn = buttons[i];

        // Initialize the property we'll use for "cache".
        var data = {};

        data.changeValue = parseInt(btn.getAttribute('data-change'), 10);
        data.btnGroup = btn.findParentByClass('btn-group');

        if (!data.btnGroup) {
            throw 'Button group is inaccessible.';
        }

        if (isNaN(data.changeValue)) {
            throw 'Invalid "change" value. Tried to change it?';
        }

        // Initialize data that depend on other data.
        data.btnsOfSameType = d.querySelectorAll('button[data-change="' + data.changeValue + '"]');
        data.btnsList = data.btnGroup.querySelectorAll('button[data-change]');
        data.domainElement = data.btnGroup.findParentByClass('domain');
        if (!data.domainElement) {
            throw 'Domain element is inaccessible.';
        }

        data.domainId = parseInt(data.domainElement.getAttribute('data-domain-id'), 10);
        if (isNaN(data.changeValue)) {
            throw 'Invalid domain id.';
        }

        data.input = data.domainElement.querySelector('input[type="hidden"][name^="domain"]');
        if (!data.input) {
            throw 'Data input is inaccessible.';
        }

        btn._data = Object.freeze(data);

        //-----------------------------------------------------------------------------

        // Add the listener to each button.
        btn.addEventListener('click', function () {
            var data = this._data;
            var value = parseInt(data.input.value, 10);
            var activeBtns;
            var btnsToDisable;

            // Do nothing if input is the same or if value equals 5.
            // Because 5 cannot be changed, so it's useless to execute more useless JS.
            if (data.changeValue === value || data.changeValue === 5) {
                return false;
            }

            if (isNaN(value)) {
                throw 'Incorrect input value. Must be an integer.';
            }

            activeBtns = $(data.btnsOfSameType).filter('.active');
            if (data.changeValue === 3 && activeBtns.length > 0) {
                btnsToDisable = activeBtns;
            } else if (
                   data.changeValue === 2 && activeBtns.length > 1
                || data.changeValue === 1 && activeBtns.length > 1
            ) {
                btnsToDisable = activeBtns.filter(':gt(0)')
            }

            // Disable when "too much" buttons.
            if (btnsToDisable && btnsToDisable.length > 0) {
                btnsToDisable.each(function(){
                    updateDomainValue(this, 0);
                });
            }

            updateDomainValue(this, data.changeValue);
        });
    }
})(jQuery, document);
