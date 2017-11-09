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
class BasketballPrediction extends AppModel
{
    /**
     * Display field
     *
     * @var string
     */
    public $useTable = 'basketball_predictions';
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
        ],
        'Game' => [
            'className' => 'Game',
            'foreignKey' => 'game_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];
}