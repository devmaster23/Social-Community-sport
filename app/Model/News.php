<?php
App::uses('AppModel', 'Model');
/**
 * News Model
 *
 */
class News extends AppModel {
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
                'status_name' => 'CASE WHEN News.status = "0" THEN "Inactive" WHEN News.status = "1" THEN "Active" END',
        ];

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [

        'description' => [
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

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Sport' => [
            'className' => 'Sport',
            'foreignKey' => 'foreign_key',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'NewsTemplate' => [
            'className' => 'NewsTemplate',
            'foreignKey' => 'template_id',
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
                       'SecondFile' => [
                            'className' => 'File',
                            'foreignKey' => 'second_file_id',
                             //'foreignKey' => '1second_file_id',
                            'conditions' => '',
                            'fields' => '',
                            'order' => ''
                    ]
    
    ];

        public $hasMany = [
        'NewsComment' => [
            'className' => 'NewsComment',
            'foreignKey' => 'news_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
            ];

        public $hasOne = [
        'Abuse' => [
            'className' => 'Abuse',
            'foreignKey' => 'news_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
                'HinNews' => [
            'className' => 'HinNews',
            'foreignKey' => 'news_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
//            ,
//                'ThaNews' => array(
//			'className' => 'ThaNews',
//			'foreignKey' => 'news_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
            ];

    public function beforeSave($options = [])
    {
        if(!parent::beforeSave($options))
        {
            return false;
        }

        if(!empty($this->data[$this->alias]['description']))
        {
            $this->data[$this->alias]['description'] = strip_tags($this->data[$this->alias]['description']);
        }

        return true;
    }

}
