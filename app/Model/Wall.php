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
class Wall extends AppModel
{
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

    // The Associations below have been created with all possible keys, those that are not needed can be removed
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
        'UserTeam' => [
            'className' => 'UserTeam',
            'foreignKey' => 'team_id',
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
                'Sport' => [
            'className' => 'Sport',
            'foreignKey' => 'sport_id',
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
        'WallContent' => [
            'className' => 'WallContent',
            'foreignKey' => 'wall_id',
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