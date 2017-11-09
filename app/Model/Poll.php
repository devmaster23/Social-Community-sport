<?php
App::uses('AppModel', 'Model');
/**
 * PollCategory Model
 *
 * @property Poll $Poll
 */
class Poll extends AppModel {
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
         */ //$this->Store->virtualFields = array('product_count' => 'COUNT(Product.id)');
        public $virtualFields = [
                'status_name' => 'CASE WHEN Poll.status = "0" THEN "Inactive" WHEN Poll.status = "1" THEN "Active" END',
                'post_type' => 'CASE WHEN Poll.poll_category_id = "2" THEN "Poll" WHEN Poll.poll_category_id = "3" THEN "Forum" END',
                'delete_status' => 'CASE WHEN Poll.is_deleted = "0" THEN "Exists" ELSE "Deleted" END'

                ];

    /** Validation rules
     *
     * @var array
     */
    public $validate = [
        'name' => [
            'notBlank' => [
                'rule' => ['notBlank'],

            ],
        ],
        'status' => [
            'numeric' => [
                'rule' => ['numeric'],

            ],
        ],
        'options' => [
            'notBlank' => [
                'rule' => ['notBlank'],

            ],
        ],
                'poll_category_id' => [
            'notBlank' => [
                'rule' => ['notBlank'],

            ],
        ],
    ];

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $belongsTo = [
        'PollCategory' => [
            'className' => 'PollCategory',
            'foreignKey' => 'poll_category_id',
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
            'Pocale' => [
            'className' => 'Pocale',
            'foreignKey' => 'locale_id',
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

    ];
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = [
        'PollResponse' => [
            'className' => 'PollResponse',
            'foreignKey' => 'poll_id',
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
                'ForumComment' => [
            'className' => 'ForumComment',
            'foreignKey' => 'forum_id',
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
