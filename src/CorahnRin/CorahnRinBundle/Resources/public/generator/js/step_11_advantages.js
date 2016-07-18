(function ($, d) {

    // Depends on the "Advantage" class.
    // Depends on all functions for this specific step.

    if (d.getElementById('generator_11_advantages')) {

        /**-----------------------------------------------------------------------
         -------------------------------------------------------------------------
         ---------------------------------- VARS ---------------------------------
         -------------------------------------------------------------------------
         -----------------------------------------------------------------------*/

        var $labelsCollection = $('.change_avdesv');
        var $advantagesElements = $labelsCollection.filter('.change_avtg');
        var $disadvantagesElements = $labelsCollection.filter('.change_desv');

        var advantagesList = {};
        var disadvantagesList = {};
        var numberOfAdvantages = 0;
        var numberOfDisadvantages = 0;

        // Initialize the two arrays.
        // Allows us to only work with memory and not always with loops through DOM...
        for (var i = 0, l = $labelsCollection.length; i < l; i++) {
            var input = $labelsCollection[i].querySelector('input');
            var element = getAdvantageFromInput(input, $labelsCollection[i]);
            // Push these changes into memory array.
            if (element.isAdvantage) {
                advantagesList[element.id] = element;
                ++numberOfAdvantages;
            } else {
                disadvantagesList[element.id] = element;
                ++numberOfDisadvantages;
            }
        }
        // End initialize

        /**-----------------------------------------------------------------------
         -------------------------------------------------------------------------
         --------------------------------- EVENTS --------------------------------
         -------------------------------------------------------------------------
         -----------------------------------------------------------------------*/

        // Process event listeners.
        // If we're here, input DOM attributes are already validated, so no more checks.
        $labelsCollection.on('click', function(){
            var currentInput = this.querySelector('input');
            var currentId = parseInt(currentInput.getAttribute('data-element-id'));
            var experience = 100;

            console.info('clicked on a label', this);

            /**-----------------------------------------------------------------------
             ---------------------- CALCULATE FROM DISADVANTAGES ---------------------
             -----------------------------------------------------------------------*/
            // TODO Calculate exp based on disadvantages.
            // TODO Remove when exp gained > 80 and/or more than 4 disadvantages.
            for (var elementId in disadvantagesList) {
                // skip loop if the property is from prototype
                if (!disadvantagesList.hasOwnProperty(elementId)) { continue; }

                var disadvantage = disadvantagesList[elementId];

                var xpLost = calculateXpFromAdvantage(disadvantage);

                if (0 === xpLost) {
                    continue;
                }

                console.info('xp lost', xpLost);
            }

            /**-----------------------------------------------------------------------
             ------------------------ CALCULATE FROM ADVANTAGES ----------------------
             -----------------------------------------------------------------------*/
            // TODO Then calculate based on advantages.
            // TODO Remove when total exp < 0 and/or more than 4 advantages.

            /**-----------------------------------------------------------------------
             --------------------------- PROCESS DOM BUTTONS -------------------------
             -----------------------------------------------------------------------*/
            // TODO Reset classes & input values everywhere
            // TODO Set proper values depending on what's in memory
        });

        /*
        $collection.on('mouseup', function (e) {
            var tclass, i, exp,
                desvexp = 0,
                values = [],
                actavtg = [],
                actdesv = [],
                real_values = {},
                alreadyActive,
                label = this,
                classList = this.classList,
                input = $(this).find('input').first()[0] || console.error('Input not found.'),
                cost = parseInt(input.getAttribute('data-element-cost')),
                actualValue = parseInt(input.value),
                augmentation = parseInt(input.getAttribute('data-augmentation')),
                id = parseInt(input.getAttribute('data-element-id'));
            console.clear();
            // Le label doit avoir un élément "input" en tant que premier enfant.
            if (!input) {
                return false;
            }
            // Si les éléments suivants ne sont pas des nombres,
            //  c'est que quelqu'un a tenté d'override les attributs html dans le DOM
            if (isNaN(cost) || isNaN(actualValue) || isNaN(augmentation) || isNaN(id)) {
                console.error('Wrong values.');
                return false;
            }
            // Ceci permet de palier aux erreurs de clic delegate lorsqu'on modifie les listeners du DOM
            if (label.tagName.toLowerCase() !== 'label') {
                console.error('Event listener not fired properly on the label.');
                return false;
            }

            alreadyActive = $(this).is('.btn-inverse,.btn-info,.btn-primary');

            exp = 100;

            if (classList.contains('change_desv')) {
                tclass = 'desv';
            } else {
                tclass = 'avtg';
            }

            // Génération de la classe relative à l'état de l'avantage
            // L'état dépend uniquement de l'avantage, il faut donc être très vigilant
            // btn-inverse : 1
            // btn-info : 2
            // btn-primary : 3 (uniquement pour le désavantage "Traumatisme"
            if (classList.contains('btn-inverse')) {
                // btn-inverse" : valeur 1
                classList.remove('btn-inverse');
                if (augmentation == '1') {
                    if (tclass === 'avtg' && id !== 50) {
                        $('.change_avtg').removeClass('btn-info btn-primary');
                    } else if (tclass === 'desv' && id != '50') {
                        // Tout désavantage sauf "Traumatisme"
                        $('.change_desv[data-element-id!="50"]').removeClass('btn-info btn-primary');
                    }
                    classList.add('btn-info');
                }
            } else if (classList.contains('btn-primary')) {
                // btn-primary : valeur 3
                classList.remove('btn-primary');
            } else if (classList.contains('btn-info')) {
                // btn-info : valeur 2
                classList.remove('btn-info');
                if (id === 50) {
                    // Si c'est le désavantage "Traumatisme", alors on ajoute la classe "primary"
                    // cela lui donne une valeur de 3
                    classList.add('btn-primary');
                }
            } else {
                // Si l'élément ne contient aucune des classes "btn-info","btn-primary" ou "btn-inverse"
                // On ajoute la classe "btn-inverse" valeur 1
                classList.add('btn-inverse');
            }

            // Cas "Allié ..."
            if ([1,2,3].indexOf(id) >= 0) {
                for (i = 1; i <= 3; i++) {
                    if (id !== i) {
                        $('#label-avdesv-'+i).removeClass('btn-inverse')
                            .find('input').val(0);
                    }
                }
            }

            // Cas "Aisance financière ..."
            if ([4,5,6,7,8].indexOf(id) >= 0) {
                for (i = 4; i <= 8; i++) {
                    if (id !== i) {
                        $('#label-avdesv-'+i).removeClass('btn-inverse')
                            .find('input').val(0);
                    }
                }
            }

            if (alreadyActive && actualValue == 1 && augmentation == 1) {
                classList.remove('btn-inverse');
            }

            // Désactive tous les inputs d'index supérieur à 3
            //  ce qui limite le nombre d'avantages et désavantages à 4
            $('.change_avtg')
                .filter(function (i,e) {
                    return e.classList.contains('inverse')
                        || e.classList.contains('info')
                        || e.classList.contains('primary');
                })
                .not(this)
                .filter(':gt(3)')
                .removeClass('btn-info btn-inverse btn-primary')
                .find('input').val(0);
            $('.change_desv')
                .filter(function (i,e) {
                    return e.classList.contains('inverse')
                        || e.classList.contains('info')
                        || e.classList.contains('primary');
                })
                .not(this)
                .filter(':gt(3)')
                .removeClass('btn-info btn-inverse btn-primary')
                .find('input').val(0);

            // Désactive tous les inputs améliorés d'index supérieur à 1
            //  ce qui limite le nombre d'avantages et désavantages améliorés à 1
            $('.change_avtg')
                .filter(function (i,e) {
                    return e.classList.contains('info')
                        || e.classList.contains('primary');
                })
                .not(this)
                .filter(':gt(1)')
                .removeClass('btn-info btn-inverse btn-primary')
                .find('input').val(0);
            $('.change_desv')
                .filter(function (i,e) {
                    return e.classList.contains('info')
                        || e.classList.contains('primary');
                })
                .not(this)
                .filter(':gt(3)')
                .removeClass('btn-info btn-inverse btn-primary')
                .find('input').val(0);

            if (
                (classList.contains('btn-info') || classList.contains('btn-info'))
                && id !== 50
            ) {
                // Cas du désavantage "Traumatisme"
                $('.change_avdesv')
                    .filter(function () {
                        return classList.contains('inverse')
                            || classList.contains('info')
                            || classList.contains('primary');
                    })
                    .not(this)
                    .not('[data-element-id="50"]')
                    .removeClass('btn-info btn-primary');
            }
            desvexp = 0;

            /**---------------------------------------------------------------------
             --------------------- Début de la boucle de calcul --------------------
             -- Calcule le montant total d'expérience selon les avantages trouvés --
             ----------- Rétablit également la valeur finale des inputs ------------
             ---------------------------------------------------------------------/
            $('.change_avdesv').sort(function (a, b) {
                // Tri du tableau pour que les désavantages soient en premier
                return a.classList.contains('change_desv') ? -1 : 1;
            }).each(function(i,_this) {
                var thisdesvexp = 0,
                    input = $(_this).find('input').first()[0] || console.error('Input not found.'),
                    id = parseInt(input.getAttribute('data-element-id')),
                    xp_cost = parseInt(input.getAttribute('data-element-cost')),
                    actualValue = 0,
                    augmentation = parseInt(input.getAttribute('data-augmentation')),
                    classList = _this.classList
                ;
                // On effectue la même vérification qu'à la base du clic, au cas où
                if (isNaN(xp_cost) || isNaN(augmentation) || isNaN(id)) {
                    console.error('Wrong values for element : ', _this);
                    return false;
                }
                if (_this.tagName.toLowerCase() !== 'label') {
                    console.error('Event listener not fired properly on the label.');
                    return false;
                }

                if (_this.className.match(/inverse|info|primary/gi)) {

                    if (classList.contains('btn-info') && augmentation < 1) {
                        classList.remove('btn-info');
                        console.error('Wrong upgrade value for id "'+id+'"');
                    }
                    if (classList.contains('btn-primary') && augmentation < 2) {
                        classList.remove('btn-primary');
                        console.error('Wrong upgrade value for id "'+id+'"');
                    }

                    if (classList.contains('change_avtg')) {
                        // AVANTAGES
                        actualValue = 0;
                        if (classList.contains('btn-info') && augmentation >= 1) {
                            exp -= Math.floor(xp_cost * 1.5);
                            actualValue = 2;
                        } else if (classList.contains('btn-inverse')) {
                            exp -= xp_cost;
                            actualValue = 1;
                        }
                        if (exp < 0) {
                            if (classList.contains('btn-info') && augmentation >= 1) {
                                classList.remove('btn-info');
                                exp += Math.floor(xp_cost * 1.5);
                                actualValue--;
                            } else if (classList.contains('btn-inverse')) {
                                classList.remove('btn-inverse');
                                exp += xp_cost;
                                actualValue--;
                            }
                        }
                    } else if (classList.contains('change_desv')) {
                        // DÉSAVANTAGES
                        actualValue = 0;
                        if (classList.contains('btn-info') && augmentation >= 1) {
                            if (id == 50) {
                                thisdesvexp += (xp_cost * 2);
                            } else {
                                thisdesvexp += Math.floor(xp_cost * 1.5);
                            }
                        } else if (classList.contains('btn-inverse')) {
                            thisdesvexp += xp_cost;
                        } else if (classList.contains('btn-primary') && augmentation >= 2) {
                            thisdesvexp += (xp_cost * 3);
                        }
                        desvexp = desvexp + thisdesvexp;
                        if (desvexp > 80) {
                            if (classList.contains('btn-info') && augmentation >= 1) {
                                classList.remove('btn-info');
                                if (id == 20) {
                                    thisdesvexp -= (xp_cost * 2);
                                } else {
                                    thisdesvexp -= Math.floor(xp_cost * 1.5);
                                }
                            } else if (classList.contains('btn-inverse')) {
                                classList.remove('btn-inverse');
                                thisdesvexp -= xp_cost;
                            } else if (classList.contains('btn-primary') && augmentation >= 2) {
                                classList.remove('btn-primary');
                                thisdesvexp -= (xp_cost * 3);
                            }
                        } else {
                            actualValue = 1;
                            if (classList.contains('btn-info') && augmentation >= 1) {
                                actualValue = 2;
                            } else if (classList.contains('btn-primary') && augmentation >= 2) {
                                actualValue = 3;
                            }
                        }
                        exp = exp + thisdesvexp;
                    } else {
                        console.error('')
                    }
                }// Fin du if "classList.match btn-inverse|primary|info"
                input.value = actualValue;
                real_values[id] = actualValue;
            });// Fin de la boucle de calcul
            $('#submit_btn').data('r'+'e'+'al_'+'values', real_values);

            d.getElementById('xp').innerHTML = ''+exp;

            return false;
        });
        */
    }
})(jQuery, document);
