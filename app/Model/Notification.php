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
class Notification extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'status';

    /**
     * Validation rules
     *
     * @var array
     */
/*	public $validate = array(
        'position' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'image' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'title' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
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

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'by',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
                'To' => [
            'className' => 'User',
            'foreignKey' => 'to',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
                'WallContent' => [
            'className' => 'WallContent',
            'foreignKey' => 'content_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]

    ];
}
