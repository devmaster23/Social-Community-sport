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
class GamesGiftPrediction extends AppModel
{
    /**
     * Display field
     *
     * @var string
     */
    public $useTable = 'gamesgiftprediction';
        public $displayField = 'name';

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
        ]
      /*  'Gift' => [
            'className' => 'Gift',
            'foreignKey' => 'gift_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]*/
         /*'GameDay' => [
            'className' => 'GameDay',
            'foreignKey' => 'teams_gameday',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]*/
    ];

    /*public $hasMany = [
        'soccer_prediction' => [
            'className' => 'soccer_prediction',
            'foreignKey' => 'gift_id',
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
    ];*/
}