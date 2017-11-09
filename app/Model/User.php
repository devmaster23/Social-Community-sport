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
class User extends AppModel {
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
                'sex' => 'CASE WHEN User.gender = "0" THEN "Male" ELSE "Female" END',
                'status_name' => 'CASE WHEN User.status = "0" THEN "Inactive" WHEN User.status = "1" THEN "Active" WHEN User.status = "2" THEN "Blocked" END',
                'delete_status' => 'CASE WHEN User.is_deleted = "0" THEN "Exists" ELSE "Deleted" END',
                'title' => 'CASE WHEN User.gender = "0" THEN "Mr. " ELSE "Mrs. " END',
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
                'message' => 'Please enter name',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'email' => [
                    'required' => [
                        'rule' => ['notBlank'],
                        'message' => 'Please enter email address.',
                        'last' =>true
                    ],
                    'validemail'=>[
                                    'rule'=>'email',
                                    'message'=>'Please enter a valid email address.'
                    ],
                    'uniqueemail'=>[
                                    'rule' => 'isUnique',
                                    'message' => 'This email already exists in the database.'
                    ], 'customrule'=> [
                            'rule' => ['custom', '/^[a-z0-9-@_\.]+$/i'],
                            'message' => 'only a-z 0-9 @ . _ - are allowed.'
                    ]
                ],
        'role_id' => [
            'numeric' => [
                'rule' => ['numeric'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'locale_id' => [
            'numeric' => [
                'rule' => ['numeric'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'gender' => [
            'numeric' => [
                'rule' => ['numeric'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ],
        'password' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ],
        ]/*,
        'file_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            ),
        )*/,
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

public $validateChangePassword = [
    'current_password' => [
        'minLength' => [
                'rule' => ['minLength', 6],
        'required' => true,
                'message' => 'Please enter at least %d characters password.'
            ]
    ],
    'confirmpassword' => [
        'minLength' => [
                'rule' => ['minLength', 6],
        'required' => true,
                'message' => 'Please enter at least %d characters password.'
        ],
        'checknewconfirmpassword' => [
            'rule' => 'checknewconfirmpassword',
            'message' => "Password and confirm password doesn't match.",
            'last' => true
        ]
    ],
    're_enter_password' => [
        'minLength' => [
                'rule' => ['minLength', 6],
        'required' => true,
                'message' => 'Please enter at least %d characters password.'
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
        ], 'Role' => [
            'className' => 'Role',
            'foreignKey' => 'role_id',
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
        ],
                'UserTeam' => [
            'className' => 'UserTeam',
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
         'UserLoging' => [
            'className' => 'UserLoging',
            'foreignKey' => 'id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
//            'NewsComment' => array(
//			'className' => 'NewsComment',
//			'foreignKey' => 'user_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
    ];

        public function beforeSave($options = [])
        {
                if(isset($this->data['User']['password'])){
                        $this->data['User']['password'] = AuthComponent::password(
                                $this->data['User']['password']
                        );
                }
                return true;
        }

        public function beforeFind($queryData)
        {
                $defaultConditions = ['User.is_deleted' => 0];
                if(isset($queryData['conditions'])){
                    $queryData['conditions'] = array_merge($queryData['conditions'], $defaultConditions);
                }else{
                    $queryData['conditions'] = $defaultConditions;
                }
                return $queryData;
        }
}
