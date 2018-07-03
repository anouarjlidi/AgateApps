<?php

return [

    '01_people' => [
        'next_step' => '02_job',
        'form_values' => [
            'gen-div-choice' => 1,
        ],
        'session_value' => 1,
    ],

    '02_job' => [
        'next_step' => '03_birthplace',
        'form_values' => [
            'job_value' => 1,
        ],
        'session_value' => 1,
    ],

    '03_birthplace' => [
        'next_step' => '04_geo',
        'form_values' => [
            'region_value' => 1,
        ],
        'session_value' => 1,
    ],

    '04_geo' => [
        'next_step' => '05_social_class',
        'form_values' => [
            'gen-div-choice' => 1,
        ],
        'session_value' => 1,
    ],

    '05_social_class' => [
        'next_step' => '06_age',
        'form_values' => [
            'gen-div-choice' => 1,
            'domains' => [
                0 => 5,
                1 => 8,
            ],
        ],
        'session_value' => [
            'id' => 1,
            'domains' => [
                5 => 5,
                8 => 8,
            ],
        ],
    ],

    '06_age' => [
        'next_step' => '07_setbacks',
        'form_values' => [
            'age' => 31,
        ],
        'session_value' => 31,
    ],

    '07_setbacks' => [
        'route_uri' => '07_setbacks?manual',
        'next_step' => '08_ways',
        'form_values' => [
            'setbacks_value' => [
                0 => 2,
                1 => 3,
            ],
        ],
        'session_value' => [
            2 => [
                'id' => 2,
                'avoided' => false,
            ],
            3 => [
                'id' => 3,
                'avoided' => false,
            ],
        ],
    ],

    '08_ways' => [
        'next_step' => '09_traits',
        'form_values' => [
            'ways' => [
                'ways.combativeness' => 5,
                'ways.creativity' => 4,
                'ways.empathy' => 3,
                'ways.reason' => 2,
                'ways.conviction' => 1,
            ],
        ],
        'session_value' => [
            'ways.combativeness' => 5,
            'ways.creativity' => 4,
            'ways.empathy' => 3,
            'ways.reason' => 2,
            'ways.conviction' => 1,
        ],
    ],

    '09_traits' => [
        'next_step' => '10_orientation',
        'form_values' => [
            'quality' => 1,
            'flaw' => 10,
        ],
        'session_value' => [
            'quality' => 1,
            'flaw' => 10,
        ],
    ],

    '10_orientation' => [
        'next_step' => '11_advantages',
        'form_values' => [
        ],
        'session_value' => 'character.orientation.instinctive',
    ],

    '11_advantages' => [
        'next_step' => '12_mental_disorder',
        'form_values' => [
            'advantages' => [
                3 => 1,
                8 => 1,
            ],
            'disadvantages' => [
                31 => 1,
                47 => 1,
                48 => 1,
            ],
        ],
        'session_value' => [
            'advantages' => [
                3 => 1,
                8 => 1,
            ],
            'disadvantages' => [
                31 => 1,
                47 => 1,
                48 => 1,
            ],
            'remainingExp' => 80,
        ],
    ],

    '12_mental_disorder' => [
        'next_step' => '13_primary_domains',
        'form_values' => [
            'gen-div-choice' => 1,
        ],
        'session_value' => 1,
    ],

    '13_primary_domains' => [
        'next_step' => '14_use_domain_bonuses',
        'form_values' => [
            'ost' => 2,
            'domains' => [
                2 => 2,
                5 => 1,
                13 => 3,
                15 => 2,
                16 => 1,
            ],
        ],
        'session_value' => [
            'domains' => [
                1 => 5,
                2 => 2,
                3 => 0,
                4 => 0,
                5 => 1,
                6 => 0,
                7 => 0,
                8 => 0,
                9 => 0,
                10 => 0,
                11 => 0,
                12 => 0,
                13 => 3,
                14 => 0,
                15 => 2,
                16 => 1,
            ],
            'ost' => 2,
            'scholar' => null,
        ],
    ],

    '14_use_domain_bonuses' => [
        'next_step' => '15_domains_spend_exp',
        'form_values' => [
            'domains_bonuses' => [
                1 => 0,
                2 => 1,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
                7 => 0,
                8 => 0,
                9 => 0,
                10 => 0,
                11 => 0,
                12 => 0,
                13 => 0,
                14 => 0,
                15 => 0,
                16 => 1,
            ],
        ],
        'session_value' => [
            'domains' => [
                1 => 0,
                2 => 1,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
                7 => 0,
                8 => 0,
                9 => 0,
                10 => 0,
                11 => 0,
                12 => 0,
                13 => 0,
                14 => 0,
                15 => 0,
                16 => 1,
            ],
            'remaining' => 2,
        ],
    ],

    '15_domains_spend_exp' => [
        'next_step' => '16_disciplines',
        'form_values' => [
            'domains_spend_exp' => [
                1 => 0,
                2 => 1,
                3 => 0,
                4 => 0,
                5 => 2,
                6 => 0,
                7 => 0,
                8 => 0,
                9 => 0,
                10 => 0,
                11 => 0,
                12 => 0,
                13 => 0,
                14 => 0,
                15 => 0,
                16 => 0,
            ],
        ],
        'session_value' => [
            'domains' => [
                1 => null,
                2 => 1,
                3 => null,
                4 => null,
                5 => 2,
                6 => null,
                7 => null,
                8 => null,
                9 => null,
                10 => null,
                11 => null,
                12 => null,
                13 => null,
                14 => null,
                15 => null,
                16 => null,
            ],
            'remainingExp' => 50,
        ],
    ],

    '16_disciplines' => [
        'next_step' => '17_combat_arts',
        'form_values' => [
            'disciplines_spend_exp' => [
                1 => [
                    12 => 'on',
                    45 => 'on',
                    92 => 'on',
                ],
            ],
        ],
        'session_value' => [
            'disciplines' => [
                1 => [
                    12 => true,
                    45 => true,
                    92 => true,
                ],
            ],
            'remainingExp' => 25,
            'remainingBonusPoints' => 0,
        ],
    ],

    '17_combat_arts' => [
        'next_step' => '18_equipment',
        'form_values' => [
            'combat_arts_spend_exp' => [
                1 => 'on',
            ],
        ],
        'session_value' => [
            'combatArts' => [
                1 => true,
            ],
            'remainingExp' => 5,
        ],
    ],

    '18_equipment' => [
        'next_step' => '19_description',
        'form_values' => [
            'armors' => [
                9 => '9',
            ],
            'weapons' => [
                5 => '5',
            ],
            'equipment' => [
                'Livre<a></a>

de  règles
',
            ],
        ],
        'session_value' => [
            'armors' => [
                9 => true,
            ],
            'weapons' => [
                5 => true,
            ],
            'equipment' => [
                'Livre de règles',
            ],
        ],
    ],

    '19_description' => [
        'next_step' => '20_finish',
        'form_values' => [
            'details' => [
                'name' => 'A',
                'player_name' => 'B',
                'sex' => 'character.sex.female',
                'description' => '',
                'story' => '',
                'facts' => '',
            ],
        ],
        'session_value' => [
            'name' => 'A',
            'player_name' => 'B',
            'sex' => 'character.sex.female',
            'description' => '',
            'story' => '',
            'facts' => '',
        ],
    ],
];
