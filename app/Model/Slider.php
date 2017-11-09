<?php
App::uses('AppModel', 'Model');
/**
 * Team Model
 *
 * @property Sport $Sport
 * @property League $League
 * @property User $User
 * @property Forum $Forum
 * @property Wall $Wall
 */
class Slider extends AppModel
{
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';

        /**
         * Virtual field
         *
         * @var string
         */
        public $virtualFields = [
                'status_name' => 'CASE WHEN Slider.status = "0" THEN "Inactive" WHEN Slider.status = "1" THEN "Active" END',
        ];
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'position' => [
            'numeric' => [
                'rule' => ['numeric'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'image' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'title' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
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
        ]

    ];

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
                'Sport' => [
                            'className' => 'Sport',
                            'foreignKey' => 'foreign_key',
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
    //public $hasMany = array(
    //	'File' => array(
    //		'className' => 'File',
    //		'foreignKey' => 'image',
    //		'dependent' => false,
    //		'conditions' => '',
    //		'fields' => '',
    //		'order' => '',
    //		'limit' => '',
    //		'offset' => '',
    //		'exclusive' => '',
    //		'finderQuery' => '',
    //		'counterQuery' => ''
    //	)
    //);
}