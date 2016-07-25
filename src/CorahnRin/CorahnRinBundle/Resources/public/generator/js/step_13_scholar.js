(function ($, d) {
    var buttons = d.querySelectorAll('.domain button[data-type="scholar"]');
    var scholarInput = d.getElementById('scholar');

    // At first, we cache DOM elements in the buttons themselves.
    // It avoids looking into the DOM on each click.
    for (var i = 0, l = buttons.length; i < l; i++) {
        var btn = buttons[i];

        // Add the listener to each button.
        btn.addEventListener('click', function () {

            // Disable all buttons
            for (var j = 0, l = buttons.length; j < l; j++) {
                buttons[j].classList.remove('active');
            }

            this.classList.add('active');
            scholarInput.value = this.getAttribute('data-domain-id');
        });
    }
})(jQuery, document);
