<?php
App::uses('AppModel', 'Model');
/**
 * League Model
 *
 * @property Tournament $Tournament
 * @property Sport $Sport
 * @property User $User
 * @property Forum $Forum
 * @property Game $Game
 * @property Team $Team
 * @property Wall $Wall
 */
class League extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'name' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                'message' => 'Please enter league name',
            ],
                        'uniquename'=>[
                                'rule' => 'isUnique',
                                'message' => 'League name already exists.'
                         ]
        ],
        'tournament_id' => [
            'numeric' => [
                'rule' => ['numeric'],
                'message' => 'Please select tournament',
            ],
        ],
        'sport_id' => [
            'numeric' => [
                'rule' => ['numeric'],
                'message' => 'Please select sport',
            ],
        ],
        'no_of_teams' => [
            'numeric' => [
                'rule' => ['numeric'],
                'message' => 'Please enter number of teams',
            ],
        ],
        'start_date' => [
            'datetime' => [
                'rule' => ['datetime'],
                'message' => 'Please select start date',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'end_date' => [
            'datetime' => [
                'rule' => ['datetime'],
                'message' => 'Please select end date',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'host' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                                'message' => 'Please enter host',
            ],
        ],
        'user_id' => [
            'numeric' => [
                'rule' => ['numeric'],
                'message' => 'Please select league moderator',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'status' => [
            'numeric' => [
                'rule' => ['numeric'],
                'message' => 'Please select status',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'is_deleted' => [
            'numeric' => [
                'rule' => ['numeric'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
    ];

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
        'Tournament' => [
            'className' => 'Tournament',
            'foreignKey' => 'tournament_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Sport' => [
            'className' => 'Sport',
            'foreignKey' => 'sport_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
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
        'Forum' => [
            'className' => 'Forum',
            'foreignKey' => 'league_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ],
        'Game' => [
            'className' => 'Game',
            'foreignKey' => 'league_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ],
        'Team' => [
            'className' => 'Team',
            'foreignKey' => 'league_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ],
        'Wall' => [
            'className' => 'Wall',
            'foreignKey' => 'league_id',
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