<?php
App::uses('AppModel', 'Model');
/**
 * Sport Model
 *
 * @property Gift $Gift
 * @property League $League
 * @property Gift $Gift
 * @property Tournament $Tournament
 */
class Gift extends AppModel {
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
                'status_name' => 'CASE WHEN Gift.status = "0" THEN "Inactive" WHEN Gift.status = "1" THEN "Active" WHEN Gift.status = "2" THEN "Archived" END',
                'delete_status' => 'CASE WHEN Gift.is_deleted = "0" THEN "Exists" ELSE "Deleted" END',
                'type_status' => 'CASE WHEN Gift.type = "1" THEN "Gift" ELSE "Cash Order" END',
               // 'file.path' =>'CASE WHEN file.path = "Null" THEN "/img/GiftsImages/1487568245.png"  END'
               // 'path' => "ISNULL(file.path)",
               // 'customer' => "IF(Contact.company IS NULL OR Contact.company = '', CONCAT(Contact.first_name, ' ', Contact.last_name, ' ', Contact.company), Contact.company)"
                //'file.path' => "IF(file.path IS NULL, ('/img/GiftsImages/1487570931.png'),file.path)"
        ];

/**
 * Validation rules
 *
 *



 * @var array
 */
public $validate = [
        'name' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'location_id' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'type' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
         'winning_no_game' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                //'message' => 'Please enter number',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'game_day' => [
            'numeric' => [
                'rule' => [
                    'notBlank'
                ],
                //'message' => 'Please select game day'
            ]
        ],
//      'file_id' => array(
//          'notBlank' => array(
//              'rule' => array('notBlank'),
//              //'message' => 'Your custom message here',
//              //'allowEmpty' => false,
//              //'required' => false,
//              //'last' => false, // Stop validation after this rule
//              //'on' => 'create', // Limit validation to 'create' or 'update' operations
//          ),
//      ),
        'gift_category_id' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'amount' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
//      'product_link' => array(
//          'notBlank' => array(
//              'rule' => array('notBlank'),
//              //'message' => 'Your custom message here',
//              //'allowEmpty' => false,
//              //'required' => false,
//              //'last' => false, // Stop validation after this rule
//              //'on' => 'create', // Limit validation to 'create' or 'update' operations
//          ),
//      ),

//      'is_deleted' => array(
//          'numeric' => array(
//              'rule' => array('numeric'),
//              //'message' => 'Your custom message here',
//              //'allowEmpty' => false,
//              //'required' => false,
//              //'last' => false, // Stop validation after this rule
//              //'on' => 'create', // Limit validation to 'create' or 'update' operations
//          ),
//      ),
    ];

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
        'File' => [
                            'className' => 'File',
                            'foreignKey' => 'file_id',
                            'conditions' => '',
                            'fields' => '',
                            'order' => ''
                    ],
        'Location' => [
                            'className' => 'Location',
                            'foreignKey' => 'location_id',
                            'conditions' => '',
                            'fields' => '',
                            'order' => ''
                    ],
        'GiftCategory' => [
                            'className' => 'GiftCategory',
                            'foreignKey' => 'gift_category_id',
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
        'Tournament' => [
                            'className' => 'Tournament',
                            'foreignKey' => 'tournament_id',
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
                    ]
    ];
}
