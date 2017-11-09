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
class WallContent extends AppModel
{
    /**
     * Display field
     *
     * @var string
     */     //public $actsAs = array('Containable');
    public $displayField = 'name';

        public $virtualFields = ['status_name' => 'CASE WHEN WallContent.status = "0" THEN "Inactive" WHEN WallContent.status = "1" THEN "Active" WHEN WallContent.status = "2" THEN "Archived" END',
                'delete_status' => 'CASE WHEN WallContent.is_deleted = "0" THEN "Exists" ELSE "Deleted" END',
        ];

    /**
     * Validation rules
     *
     * @var array
     */
    /*public $validate = array(
        'name' => array(
            'content' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter youtube link',
            )
        ),
        'title' => array(
            'content' => array(
                'rule' => array('content'),

            ),
        ),
        'wall_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'user_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'status' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )

    );
*/
    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
        'Wall' => [
            'className' => 'Wall',
            'foreignKey' => 'wall_id',
        ],
                'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
        ],

    ];

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = [
        'WallComment' => [
            'className' => 'WallComment',
            'foreignKey' => 'content_id',
            'dependent' => false,
        ]

    ];
}