<?php
App::uses('AppModel', 'Model');
/**
 * Sport Model
 *
 * @property User $User
 * @property League $League
 * @property Team $Team
 * @property Tournament $Tournament
 */
class SoccerPrediction extends AppModel
{
    /**
     * Display field
     *
     * @var string
     */
    public $useTable = 'soccer_predictions';
        //public $displayField = 'name';

    /**
     * belongsTo associations
     *
     * @var array
     */
        public $validate = [
        'first_team_goals' => ['numeric' => [ 'rule' => [ 'numeric' ],'message' => 'This field is required.']
        ],
        'second_team_goals' => ['numeric' => [ 'rule' => [ 'numeric' ], 'message' => 'This field is required.'
            ]
        ],
       
    ];

    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
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
        ],
        'League' => [
            'className' => 'League',
            'foreignKey' => 'league_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
        'Game' => [
            'className' => 'Game',
            'foreignKey' => 'game_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]/*,
         'First_team' => [
            'className' => 'Team',
            'foreignKey' => 'first_team',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ],
          'Second_team' => [
            'className' => 'Team',
            'foreignKey' => 'second_team',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]*/
    ];
     
}