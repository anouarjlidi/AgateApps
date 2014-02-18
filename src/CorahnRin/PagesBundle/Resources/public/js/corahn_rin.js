(function($){
    var a;

    $('[data-toggle="tooltip"]').tooltip('destroy').tooltip({
        "placement" : function(event,element){
            return element.getAttribute('data-placement') ? element.getAttribute('data-placement') : 'auto bottom';
        },
        "container": "body"
    });

    a = document.querySelectorAll('a.btn-danger[href*=delete]');
    for (var i = 0, l = a.length ; i < l ; i++) {
        a[i].onclick = function(){
            return confirm(confirm_delete);
        };
    }

    a = document.querySelectorAll('[data-onchangesubmit]');
    for (var i = 0, l = a.length ; i < l ; i++) {
        a[i].onchange = function(){
            var a = this.getAttribute('data-onchangesubmit');
            if (a !== 'false' && a !== '0') {
                if ($(this).parents('form')) {
                    $(this).parents('form').submit();
                }
            }
            return false;
        };
    }

    String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g, '');};


    if (document.querySelectorAll('[data-prototype]').length) {

        var handler = document.getElementById('corahnrin_pagesbundle_menus_params'),
            elements = document.querySelectorAll('[data-collection-children]'),
            onclick = function(){
                $(this).parents('.input-group').remove();
            },
            prototype,
            inputContainer,
            spanNode,
            addElementNode,
            deleteElementNode;

        prototype = $(handler.getAttribute('data-prototype').trim()).find('input')[0];
        spanNode = document.createElement('span');
        spanNode.appendChild(prototype);
        prototype = spanNode.innerHTML;

        deleteElementNode = document.createElement('button');
        deleteElementNode.className = 'btn btn-delete';
        deleteElementNode.type = 'button';
        deleteElementNode.innerHTML = '<span class="glyphicon icon-bin text-red"></span>';

        spanNode = document.createElement('span');
        spanNode.className = 'input-group-btn span-delete-node';
        spanNode.appendChild(deleteElementNode);

        inputContainer = document.createElement('div');
        inputContainer.className = 'input-group';

        addElementNode = document.createElement('button');
        addElementNode.className = 'btn btn-inverse btn-xs btn-block';
        addElementNode.type = 'button';
        addElementNode.innerHTML = '<span class="glyphicon icon-plus text-green"></span>';
        addElementNode.onclick = function(){
            var iterator = !isNaN(document.iteratorValue) ? document.iteratorValue : 0,
                node = document.createElement('div'),
                handler = document.getElementById('corahnrin_pagesbundle_menus_params'),
                container = inputContainer.cloneNode(),
                spanNodeToAdd = spanNode.cloneNode();
            spanNodeToAdd.onclick = onclick;
            container.innerHTML += prototype;
            node.appendChild(container);
            node.innerHTML = node.innerHTML.replace(/__name__/gi, iterator);
            $(node).find('input').after(spanNodeToAdd);
            handler.appendChild(node);
            document.iteratorValue = iterator + 1;
        };
        handler.innerHTML = '';
        handler.appendChild(addElementNode);


        for (var i = 0, l = elements.length ; i < l ; i++) {
            elements[i];
        }

    }// end form prototypes

})(jQuery);