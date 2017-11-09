<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 * @property Role $Role
 * @property Locale $Locale
 * @property File $File
 * @property League $League
 * @property PollResponse $PollResponse
 * @property Sport $Sport
 * @property Team $Team
 * @property WallContent $WallContent
 */
class Blogger extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

         public $virtualFields = [
                'status_name' => 'CASE WHEN WallContent.status = "0" THEN "Inactive" WHEN User.status = "1" THEN "Active" WHEN User.status = "2" THEN "Blocked" END',
                'delete_status' => 'CASE WHEN WallContent.is_deleted = "0" THEN "Exists" ELSE "Deleted" END',

        ];

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
        'Role' => [
            'className' => 'Role',
            'foreignKey' => 'role_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Locale' => [
            'className' => 'Pocale',
            'foreignKey' => 'locale_id',
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
        ],
                'User' => [
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
            'foreignKey' => 'user_id',
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
        'PollResponse' => [
            'className' => 'PollResponse',
            'foreignKey' => 'user_id',
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
        'Sport' => [
            'className' => 'Sport',
            'foreignKey' => 'user_id',
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
            'foreignKey' => 'user_id',
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
        'WallContent' => [
            'className' => 'WallContent',
            'foreignKey' => 'user_id',
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