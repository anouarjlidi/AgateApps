(function($, w){
    var d = w.document,
        equipmentPanel = d.getElementById('equipment_panel')
    ;

    equipmentPanel.addEventListener('click', function(event){
        var action, target, button, input, container, newElement, index, label, newButton, icon;

        target = event.target;

        if (target.classList.contains('equipment_remove') || target.parentElement.classList.contains('equipment_remove')) {
            action = 'remove';
            button = target.classList.contains('equipment_remove') ? target : target.parentElement;
        } else if (target.classList.contains('equipment_add') || target.parentElement.classList.contains('equipment_add')) {
            action = 'add';
            button = target.classList.contains('equipment_add') ? target : target.parentElement;
        }

        if (action !== 'add' && action !== 'remove') {
            return;
        }

        container = button.parentElement;

        if (!container.classList.contains('equipment')) {
            throw 'Invalid container for button';
        }

        if ('remove' === action) {
            if (equipmentPanel.querySelectorAll('div.equipment').length > 1) {
                container.parentElement.removeChild(container);
            }
            return;
        }

        newElement = container.cloneNode(true);

        // This will fix issues with materialize animations
        newButton = newElement.querySelector('.equipment_add');
        icon = newButton.querySelector('i.fa');
        newButton.innerHTML = '';
        newButton.appendChild(icon);

        console.info(newElement.innerHTML);
        input = newElement.querySelector('input[name="equipment[]"]');
        try {
            index = 1 + parseInt(input.id.replace(/\D+/gi, ''));
        } catch (e) {
            throw 'Invalid input inside container';
        }

        input.id = 'equipment_'+index;
        input.value = '';
        label = newElement.querySelector('label[for="equipment_'+(index-1)+'"]');
        if (!label) {
            throw 'Input label is invalid';
        }
        label.htmlFor = 'equipment_'+index;

        equipmentPanel.appendChild(newElement);

        input.focus();
        input.blur();
    });
})(jQuery, window);
