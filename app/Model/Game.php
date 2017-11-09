<?php
App::uses('AppModel', 'Model');

/**
 * Sport Model
 *
 * @property Game $Game
 * @property League $League
 * @property Game $Game
 * @property Tournament $Tournament
 */
class Game extends AppModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    const STATUS_ARCHIVED = 2;
    
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

        /**
         * Virtual field
         *
         * @var string
         */
        public $virtualFields = [
                'status_name'   => 'CASE WHEN Game.status = "0" THEN "Inactive" WHEN Game.status = "1" THEN "Active" WHEN Game.status = "2" THEN "Archived" END',
                'delete_status' => 'CASE WHEN Game.is_deleted = "0" THEN "Exists" ELSE "Deleted" END'
        ];

    /**
     * Validation rules
     * 
     * @var array
     */
    public $validate = [
        'tournament_id' => [
            'numeric' => [
                'rule' => [
                    'numeric'
                ],
                'message' => 'Please select tournament'
            ]
        ],
        
        'sport_id' => [
            'numeric' => [
                'rule' => [
                    'numeric'
                ],
                'message' => 'Please select sport'
            ]
        ],
        'league_id' => [
            'numeric' => [
                'rule' => [
                    'numeric'
                ],
                'message' => 'Please select league'
            ]
        ],
        'first_team' => [
            'numeric' => [
                'rule' => [
                    'numeric'
                ],
                'message' => 'Please select first team'
            ]
        ],
        'second_team' => [
            'numeric' => [
                'rule' => [
                    'numeric'
                ],
                'message' => 'Please select second team'
            ]
        ],
        'start_time' => [
            'datetime' => [
                'rule' => [
                    'datetime'
                ],
                'message' => 'Please select start time'
            ]
        ],
        'end_time' => [
            'datetime' => [
                'rule' => [
                    'datetime'
                ],
                'message' => 'Please select end time'
            ]
        ],
        'teams_gameday' => [
            'numeric' => [
                'rule' => [
                    'numeric'
                ],
                'message' => 'Please select game day'
            ]
        ],

        'is_deleted' => [
            'numeric' => [
                'rule' => [
                    'numeric'
                ]
            ]
        ]
    ];

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
        'Sport' => [
            'className' => 'Sport',
            'foreignKey' => 'sport_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
                'League' => [
            'className' => 'League',
            'foreignKey' => 'league_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
                'Tournament' => [
            'className' => 'Tournament',
            'foreignKey' => 'tournament_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
                'First_team' => [
            'className' => 'Team',
            'foreignKey' => 'first_team',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
                'Second_team' => [
            'className' => 'Team',
            'foreignKey' => 'second_team',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = [
        'Team' => [
            'className' => 'Team',
            'foreignKey' => 'sport_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ]
    ];
 
}