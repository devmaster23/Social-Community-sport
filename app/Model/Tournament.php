<?php
App::uses('AppModel', 'Model');
/**
 * Tournament Model
 *
 * @property Sport $Sport
 * @property League $League
 */
class Tournament extends AppModel
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
                'status_name' => 'CASE WHEN Tournament.status = "0" THEN "Inactive" WHEN Tournament.status = "1" THEN "Active" WHEN Tournament.status = "2" THEN "Archived" END',
                'delete_status' => 'CASE WHEN Tournament.is_deleted = "0" THEN "Exists" ELSE "Deleted" END'
        ];

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'name' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                'message' => 'Please enter tournament name',
            ],
                        'uniquename'=>[
                                'rule' => 'isUnique',
                                'message' => 'Tournament name already exists.'
                         ]
        ],
        'sport_id' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'file_id' => [
            'notBlank' => [
                'rule' => ['notBlank'],

            ],
        ],
        'status' => [
            'numeric' => [
                'rule' => ['numeric'],
                //'message' => 'Your custom message here',
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
        'Sport' => [
            'className' => 'Sport',
            'foreignKey' => 'sport_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
                'File' => [
            'className' => 'File',
            'foreignKey' => 'file_id',
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
        'League' => [
            'className' => 'League',
            'foreignKey' => 'tournament_id',
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
