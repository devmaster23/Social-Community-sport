<?php
App::uses('AppController', 'Controller');

/**
 * Leagues Controller
 *
 * @property League $League
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class GamesController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = [
        'Paginator',
        'Flash',
        'Session',
        'Email'
    ];

    public $helpers = [
        'Common',
        'Chat',
        'Text',
        'Html'
    ];

    public $uses = [
        'GiftCategory',
        'Location',
        'Game'
    ];

    /**
     * _before filter method
     *
     * @return void
     */
     public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('getTournamentsAjax', 'getLeaguesAjax', 'getTeamsAjax', 'getTeamsFilterAjax', 'checkleaguedate', 'checkdate', 'getpreviousdays', 'getnextdays' );
        $this->View = new View($this, false);
        $gift_cat = $this->GiftCategory->find('list');
       // $gift_name = $this->GiftName->find('list');
        $location = $this->Location->find('list');
        $this->set(compact('gift_cat', 'location'));
    }

    /**
     * _checkSportSession method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function _checkSportSession()
    {
        if (! $this->Auth->Session->read('Auth.User.sportSession.league_id') && ! $this->Auth->Session->read('Auth.User.sportSession.team_id'))
        {

            return $this->redirect([
                'controller' => 'dashboard',
                'action' => 'index'
            ]);
        }
    }

    /**
     * index method
     *
     * @param mixed      $conditions
     * @param null|mixed $order
     *
     * @return void
     */
    public function index($conditions = [], $order = null)
    {
        $this->Game->recursive = 0;
        $this->paginate = [
            'contain' => false,
            'limit' => LIMIT,
            'conditions' => $conditions,
            'order' => $order
        ];
        $this->set('games', $this->paginate('Game'));

        $tournamentConditions = false;
        $tournaments = $this->Game->Tournament->find('list', [
            'conditions' => [
                'Tournament.status' => 1,
                'Tournament.is_deleted' => 0
            ]
        ]);
        if (AuthComponent::user('id') != 1)
        {
            $tournamentConditions = [
                'Tournament.sport_id' => AuthComponent::user('SportInfo.Sport.id'),
                'Tournament.status' => 1,
                'Tournament.is_deleted' => 0
            ];
            $tournaments = $this->Game->Tournament->find('list', [
                'conditions' => $tournamentConditions
            ]);
        }

        $this->set(compact('tournaments'));
        $sports = $this->Game->Sport->find('list', [
            'conditions' => [
                'Sport.status' => 1
            ]
        ]);
        $teams = $this->Game->Team->find('list', [
            'conditions' => [
                'Team.status' => 1,
                'Team.is_deleted' => 0
            ]
        ]);
        $this->set(compact('tournaments', 'sports', 'teams'));
    }

    public function _getSearchConditions()
    {
        $input = $_GET;
        $model = 'Game';

        $items = [];
        $conditions = [
            'Game.is_deleted' => 0,
            'Game.status' => [
                0,
                1
            ]
        ];
        if (! empty($input))
        {
            foreach ($input as $k => $v)
            {
                $setKey = 1;
                if (empty($v))
                {
                    if ($v !== '0')
                    {
                        unset($input[$k]);
                        $setKey = 0;
                    }
                }
                if ($setKey)
                {
                    if ($k == 'name')
                    {
                        $v = '%' . trim($v) . '%';
                        $conditions['OR'][$model . '.' . $k . ' LIKE'] = $v;
                    }
                    else
                        if ($k == 'email')
                        {
                            $v = trim($v) . '%';
                            $conditions['OR'][$model . '.' . $k . ' LIKE'] = $v;
                        }
                        else
                        {
                            $conditions[$model . '.' . $k] = $v;
                        }
                }
            }

            $this->data = [
                'Game' => $input
            ];
        }

        if (AuthComponent::user('role_id') == 3)
        {

            $conditions[$model . '.' . 'league_id'] = $this->Session->read('Auth.League.SportInfo')['League']['id'];
        }

        if (AuthComponent::user('role_id') == 2)
        {
            $conditions[$model . '.' . 'sport_id'] = AuthComponent::user('SportInfo.Sport.id');
        }

        $conditions[$model . '.' . 'status'] = 1;

        return $conditions;
    }
    public function _getSearchConditionspredictionresult()
    {
        $input = $_GET;
        $model = 'Game';

        $items = [];
        $conditions = [];
        if (! empty($input))
        {
            foreach ($input as $k => $v)
            {
                $setKey = 1;
                if (empty($v))
                {
                    if ($v !== '0')
                    {
                        unset($input[$k]);
                        $setKey = 0;
                    }
                }
                if ($setKey)
                {
                    if ($k == 'name')
                    {
                        $v = '%' . trim($v) . '%';
                        $conditions['OR'][$model . '.' . $k . ' LIKE'] = $v;
                    }
                    else
                        if ($k == 'email')
                        {
                            $v = trim($v) . '%';
                            $conditions['OR'][$model . '.' . $k . ' LIKE'] = $v;
                        }
                        else
                        {
                            $conditions[$model . '.' . $k] = $v;
                        }
                }
            }

            $this->data = [
                'Game' => $input
            ];
        }

        if (AuthComponent::user('role_id') == 3)
        {

            $conditions[$model . '.' . 'league_id'] = $this->Session->read('Auth.League.SportInfo')['League']['id'];
        }

        if (AuthComponent::user('role_id') == 2)
        {
            $conditions[$model . '.' . 'sport_id'] = AuthComponent::user('SportInfo.Sport.id');
        }

        

        return $conditions;
    }

    public function _getGamesSearchConditions($model)
    {
        $input = $_GET;
        $items = [];
        $conditions = [
            '' . $model . '.is_deleted' => 0,
            '' . $model . '.status' => [
                0,
                1
            ]
        ];
        if (! empty($input))
        {
            foreach ($input as $k => $v)
            {
                $setKey = 1;
                if (empty($v))
                {
                    if ($v !== '0')
                    {
                        unset($input[$k]);
                        $setKey = 0;
                    }
                }
                if ($setKey)
                {
                    if ($k == 'name')
                    {
                        $v = '%' . trim($v) . '%';
                        $conditions['OR'][$model . '.' . $k . ' LIKE'] = $v;
                    }
                    else
                        if ($k == 'email')
                        {
                            $v = trim($v) . '%';
                            $conditions['OR'][$model . '.' . $k . ' LIKE'] = $v;
                        }
                        else
                        {
                            $conditions[$model . '.' . $k] = $v;
                        }
                }
            }

            $this->data = [
                'CricketPrediction' => $input
            ];
        }

        if (AuthComponent::user('role_id') == 3)
        {

            $conditions[$model . '.' . 'league_id'] = $this->Session->read('Auth.League.SportInfo')['League']['id'];
        }

        if (AuthComponent::user('role_id') == 2)
        {
            $conditions[$model . '.' . 'sport_id'] = AuthComponent::user('SportInfo.Sport.id');
        }

        $conditions[$model . '.' . 'status'] = 1;

        return $conditions;
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'List Games');
        // $this->Game->recursive = 0;
        // $this->set('games', $this->Paginator->paginate());
        $this->Game->unbindModel([
            'belongsTo' => [
                'League'
            ]
        ]);
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        // pr($conditions); die;
        $this->index($conditions, [
            'FIELD(Game.created,Game.status) DESC'
        ]);
    }

    public function admin_search_data()
    {
        $this->autoRender = false;
        $this->set('title_for_layout', 'List Games');
        // $this->Game->recursive = 0;
        // $this->set('games', $this->Paginator->paginate());
        $this->Game->unbindModel([
            'belongsTo' => [
                'League'
            ]
        ]);
        $conditions = [];
        $conditions = $this->_getSearchConditions();

        $this->loadModel('CricketPrediction');

        $cricket = $this->CricketPrediction->find('all', [
            'fields' => [
                'CricketPrediction.id',
                'CricketPrediction.winner',
                'CricketPrediction.first_team_score',
                'CricketPrediction.second_team_score',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);
        // pr($cricket);die;
        $this->set(compact('cricket'));
        // die();
    }
     public function admin_listPredictions()
    {  $this->set('title_for_layout', 'Games Result List');
        error_reporting(0);
        $this->loadModel('GamesResult');
        $this->loadModel('Game');

         $conditions=[];
         $conditions = $this->_getSearchConditionspredictionresult();
       if(!empty($conditions)){
       $condition = array('GamesResult.is_deleted' => 0, 'file.first_team' =>$conditions['Game.first_team'],'file.second_team' =>$conditions['Game.second_team'],'GamesResult.status' =>1,'GamesResult.Sport_id' =>$conditions['Game.sport_id'],'GamesResult.game_day' =>$conditions['Game.game_day']);

              foreach($condition as $key=>$value)
                {
                    if(is_null($value) || $value == ''){
                        unset($condition[$key]);
                }
            }
           }

            else
            {
                $condition = array('GamesResult.is_deleted' => 0,'GamesResult.status' => 1);
            }
       $this->paginate =  array(
            'fields' => array('GamesResult.id','GamesResult.game_id','GamesResult.first_team_goals','GamesResult.second_team_goals','GamesResult.game_day','file.first_team','file.second_team','team.name','secondteam.name','Tournament.name','Tournament.id','Sport.name','Sport.id'),
            'joins' => array(
                array(
                        'table' => 'games',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('GamesResult.game_id = file.id')
                    ),
               
                array(
                        'table' => 'teams',
                        'alias' => 'team',
                        'type' => 'right',
                        'conditions' => array('file.first_team =team.id')
                    ),
                array(
                        'table' => 'teams',
                        'alias' => 'secondteam',
                        'type' => 'right',
                        'conditions' => array('file.second_team =secondteam.id')
                    ),
                ),
             //'conditions'=>array('GamesResult.is_deleted' => 0),
             'limit' => 10,
               
            
        );
            $games = $this->Paginator->paginate('GamesResult',$condition);
        
       

        $this->set(compact('tournaments'));
        $sports = $this->Game->Sport->find('list', [
            'conditions' => [
                'Sport.status' => 1
            ]
        ]);

        $teams = $this->Game->Team->find('list', [
            'conditions' => [
                'Team.status' => 1,
                'Team.is_deleted' => 0
            ]
        ]);

         //echo '<pre>'; print_r($games);exit;
        $this->set(compact('games','teams','sports'));
    }
      public function admin_gamesResult()
    { 
       $this->set('title_for_layout', 'Add Games Result');
        $this->loadModel('GamesResult');
          $today = date('Y-m-d h:i:s');
        if ($this->request->is('post'))
        {
            //print_r($this->request->data);exit;
            $gamedayExist = $this->GamesResult->find('first', [
            'fields' =>['GamesResult.game_day'],
            'conditions' => [
            'GamesResult.sport_id' => $this->request->data['Game']['sport_id'],
            'GamesResult.tournament_id' => $this->request->data['Game']['tournament_id'],
            'GamesResult.league_id' => $this->request->data['Game']['league_id'],
            'GamesResult.game_day' => $this->request->data['Game']['teams_gameday'],
            'GamesResult.is_deleted' => 0,

           
            ]
            ]);
            $gamedataready = $this->Game->find('all', [
            'fields' =>['Game.end_time'],
            'conditions' => [
            'Game.sport_id' => $this->request->data['Game']['sport_id'],
            'Game.tournament_id' => $this->request->data['Game']['tournament_id'],
            'Game.league_id' => $this->request->data['Game']['league_id'],
            'Game.teams_gameday' => $this->request->data['Game']['teams_gameday'],
            'Game.is_deleted' => 0,
            ],
           'order' => ['Game.end_time' => 'DESC'],
            ]);
           // print_r($gamedataready);exit;

             $gamecheck = $this->Game->find('first', [
            'fields' => ['Game.id'],
            //MAX(teams_gameday) as maxday
            'conditions' => [
            'Game.sport_id' => $this->request->data['Game']['sport_id'],
            'Game.tournament_id' => $this->request->data['Game']['tournament_id'],
            'Game.league_id' => $this->request->data['Game']['league_id'],
            'Game.teams_gameday' => $this->request->data['Game']['teams_gameday'],
            'Game.is_deleted' => 0,
            ],
           'order' => ['Game.end_time' => 'DESC'],
            ]);
          
            
            if(empty($gamecheck))
            {
             $this->Flash->success(__('This Game is not exist.'));
                return $this->redirect([
                    'action' => 'gamesResult'
                ]);
            }

            if(!empty($gamedayExist))
            {
                 $this->Flash->success(__('You have already Added Scores for this game day.'));
                return $this->redirect([
                    'action' => 'gamesResult'
                ]);
            }
            elseif($gamedataready[0]['Game']['end_time'] >=$today)
            {
                $this->Flash->success(__('You cannot add scores because this game is not completed yet.'));
                return $this->redirect([
                    'action' => 'gamesResult'
                ]);
            }
            else{
            $conditions =[
                'Game.sport_id' => $this->request->data['Game']['sport_id'],
                'Game.tournament_id' => $this->request->data['Game']['tournament_id'],
                'Game.league_id' => $this->request->data['Game']['league_id'],
                'Game.teams_gameday' => $this->request->data['Game']['teams_gameday'],
                'Game.is_deleted' => 0,
              //  'Game.start_time >=' => $today,
            ];
              $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'Sport.name',
                'League.id',
                'League.name',
                'Tournament.id',
                'Tournament.name',
                'Game.teams_gameday',
    // ...
            ];
            
        
               $this->paginate = [
                'limit' => 10,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            
        $gamedata = $this->Paginator->paginate('Game');
            $this->set(compact('gamedata'));
         // echo '<pre>'; print_r($gamedata);exit;
            
        }
    }

        $sports = $this->Game->Sport->find('list', [
            'order' => 'Sport.name'
        ]);

        $this->set(compact('sports'));
        
        
      
     }
      public function admin_gamesResultAdd()
    {
       
     
       
        $this->loadModel('GamesResult');
       

       if ($this->request->is('post'))
        {
            
            $datas=$this->request->data['GamesResult'];
          //print_r($datas);exit;
            if ($this->GamesResult->saveMany($datas))
            {  

                $this->Flash->success(__('Prediction has been saved.'));
                return $this->redirect([
                    'controller' => 'games',
                    'action' => 'gamesResult'
                ]);
               
            }
            else
            {
        //}
            $this->Flash->error(__('Prediction could not be saved. Please, try again.','error'));

        }
        }
    }
    public function admin_gameResultEdit($first_team  = null,$second_team = null,$game_Id = null,$id=null)
    {
       //$id = $this->request->params['pass'][0];
        $game_Id = base64_decode($game_Id );
       
        $firstTeam = base64_decode($first_team );
        $secondTeam = base64_decode($second_team );
         $id = base64_decode($id);
          $this->layout = '';
          $this->loadModel('GamesResult');
        $this->GamesResult->id = $id;
        if (! $this->GamesResult->exists($id))
        {
             $this->Flash->error(__('The score could not be saved. Please, try again.'));
            $this->redirect(array('action' => 'listPredictions'));
        }

            $this->request->data = $this->GamesResult->read(null, $id );
           $dataExist = $this->GamesResult->find('first', [
            'conditions' => [
                'GamesResult.id' => $id,
                
            ]
        ]);
        // print_r($dataExist);exit;
        $this->set(compact('dataExist', 'firstTeam', 'secondTeam'));
    }
     public function admin_resultEdit()
    {
          $this->layout = '';
          $this->loadModel('GamesResult');
         $id = $this->request->params['pass'][0];
         $this->GamesResult->id = $id;
     
        if( $this->GamesResult->exists() ){
        
            if( $this->request->is( 'post' ) || $this->request->is( 'put' ) ){
                //save user
                if( $this->GamesResult->save( $this->request->data ) ){
                
                    $this->Flash->success(__('The Score has been saved.'));
                    $this->redirect(array('action' => 'listPredictions'));
                    
                }else{
                    $this->Flash->error(__('The score could not be saved. Please, try again.'));
                }
                
            }else{
        
                $this->request->data = $this->GamesResult->read();
            }
            
        }else{
           
            $this->Flash->error(__('The score could not be saved. Please, try again.'));
            $this->redirect(array('action' => 'listPredictions'));
                
          
        }
        
    }
    public function admin_soccerPredictionResult($user_Id=null,$game_day=null)
    {
       $this->layout = '';    
        $this->loadModel('SoccerPrediction');
        $this->loadModel('UserTeam');
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        $this->loadModel('Game');
        $gameDay = base64_decode($game_day);
        $userId = base64_decode($user_Id);
          $dataExists= $this->SoccerPrediction->find('all',  array('fields' => array('User.name','League.name','Tournament.name','SoccerPrediction.id','SoccerPrediction.game_id','SoccerPrediction.sport_id','SoccerPrediction.user_id','SoccerPrediction.tournament_id', 'SoccerPrediction.league_id', 'SoccerPrediction.game_id', 'SoccerPrediction.game_day','gameresult.first_team_goals', 'gameresult.second_team_goals', 'SoccerPrediction.first_team_goals', 'SoccerPrediction.second_team_goals','file.first_team','file.second_team','team.name','secondteam.name'),

                'joins' => array( 
                    array('table' => 'games_results',
                                  'alias' => 'gameresult',
                                   'type' => 'INNER',
                                   'conditions' => array( 'SoccerPrediction.game_day=gameresult.game_day','SoccerPrediction.game_id=gameresult.game_id')
                                   ),
                     array(
                        'table' => 'games',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('SoccerPrediction.game_id = file.id')
                    ),
                    array(
                        'table' => 'teams',
                        'alias' => 'team',
                        'type' => 'right',
                        'conditions' => array('file.first_team =team.id')
                    ),
                    array(
                        'table' => 'teams',
                        'alias' => 'secondteam',
                        'type' => 'right',
                        'conditions' => array('file.second_team =secondteam.id')
                    ),
                    ),
                  'conditions'=>array('SoccerPrediction.game_day' => $gameDay,'SoccerPrediction.user_id' => $userId,'SoccerPrediction.is_deleted' => 0)
                )
          );
          $giftdata= $this->GamesGiftPrediction->find('all',  array('fields' => array('gift.winning_no_game','gift.name', 'gift.type','gift.amount','GamesGiftPrediction.cashamount'),

                'joins' => array( 
                    array('table' => 'gifts',
                                   'alias' => 'gift',
                                   'type' => 'left',
                                   'conditions' => array( 'GamesGiftPrediction. gift_id = gift.id')
                                   ),
                     
                    ),
                  'conditions'=>array('GamesGiftPrediction.teams_gameday' => $gameDay,
                  'GamesGiftPrediction.is_deleted' => 0,'GamesGiftPrediction.user_id' => $userId)
                )
          );
 $this->set(compact('giftdata'));

 $this->set(compact('dataExists'));
    }


 public function admin_soccerWinner()
    {
        
        $this->set('title_for_layout', 'Soccer Prediction');
        $this->loadModel('Gift');
         $this->loadModel('GamesGiftPrediction');
          $this->loadModel('GamesResult');
          $this->loadModel('SoccerPrediction');
         $conditions = [];
         //$conditions = $this->_getGamesSearchConditions('GamesGiftPrediction');
        // $conditions = $this->_getGamesSearchConditions('SoccerPrediction');
        $condition = $this->_getGamesSearchConditions('Game');

         /*$this->paginate =  array('fields' => array('lGamesGiftPrediction.user_id','GamesGiftPrediction.teams_gameday','Gifts.winning_no_game'),
            'joins' => array(
                array(
                        'table' => 'gifts',
                        'alias' => 'Gifts',
                        'type' => 'inner',
                        'conditions' => array('GamesGiftPrediction.gift_id = Gifts.id',' GamesGiftPrediction.sport_id = Gifts.sport_id ',' GamesGiftPrediction.tournament_id = Gifts.tournament_id',' GamesGiftPrediction.league_id =Gifts.league_id')
                    ),
               
                ),
             'conditions'=>array('GamesGiftPrediction.is_deleted=0','GamesGiftPrediction.status=1'),
             'order'=>'GamesGiftPrediction.teams_gameday', 
             'limit' => 10,

               
            
        );
            $soccerwinner = $this->Paginator->paginate('GamesGiftPrediction',$conditions);*/
      
       /*$soccerwinner=$this->GamesGiftPrediction->query("select GamesGiftPrediction.user_id,GamesGiftPrediction.teams_gameday,Gifts.winning_no_game from gamesgiftprediction GamesGiftPrediction  inner join gifts Gifts ON GamesGiftPrediction.gift_id = Gifts.id and GamesGiftPrediction.sport_id = Gifts.sport_id and GamesGiftPrediction.tournament_id = Gifts.tournament_id and GamesGiftPrediction.league_id =Gifts.league_id where GamesGiftPrediction.is_deleted=0 and GamesGiftPrediction.status=1 ORDER BY GamesGiftPrediction.teams_gameday " );  */
     // echo '<pre>'; print_r($soccerwinner);
 $soccerwinner=$this->GamesGiftPrediction->query("SELECT `GamesGiftPrediction`.`user_id`, `GamesGiftPrediction`.`teams_gameday`,`GamesGiftPrediction`.`sport_id`,`GamesGiftPrediction`.`tournament_id`,`GamesGiftPrediction`.`league_id`, `Gifts`.`winning_no_game`,`Gifts`.`id` FROM .`gamesgiftprediction` AS `GamesGiftPrediction` LEFT JOIN .`users` AS `User` ON (`GamesGiftPrediction`.`user_id` = `User`.`id`) LEFT JOIN .`tournaments` AS `Tournament` ON (`GamesGiftPrediction`.`tournament_id` = `Tournament`.`id`) LEFT JOIN .`sports` AS `Sport` ON (`GamesGiftPrediction`.`sport_id` = `Sport`.`id`) LEFT JOIN .`leagues` AS `League` ON (`GamesGiftPrediction`.`league_id` = `League`.`id`) inner JOIN .`gifts` AS `Gifts` ON (`GamesGiftPrediction`.`gift_id` = `Gifts`.`id` AND ((`GamesGiftPrediction`.`sport_id` = `Gifts`.`sport_id`) OR (`Gifts`.`sport_id`=0)) AND ((`GamesGiftPrediction`.`tournament_id` = `Gifts`.`tournament_id`) OR (`Gifts`.`tournament_id`=0)) AND ((`GamesGiftPrediction`.`league_id` =`Gifts`.`league_id`) OR (`Gifts`.`league_id`=0))) WHERE `GamesGiftPrediction`.`is_deleted`=0 AND `GamesGiftPrediction`.`status`=1   " );  

// echo '<pre>'; print_r($soccerwinner);exit;
       $soccerwinnerlist_array=array();   
        $soccerwinnerdata_array=array();        
        $i=0;
        if(!empty($soccerwinner)){
           
       while($i<count($soccerwinner))
       {  
            $userid= $soccerwinner[$i]['GamesGiftPrediction']['user_id'];
            $gameday= $soccerwinner[$i]['GamesGiftPrediction']['teams_gameday'];
            $sport_id=$soccerwinner[$i]['GamesGiftPrediction']['sport_id'];
            $tornament_id=$soccerwinner[$i]['GamesGiftPrediction']['tournament_id'];
            $league_id=$soccerwinner[$i]['GamesGiftPrediction']['league_id'];
               $fields = [
                
                'SoccerPrediction.game_day',
                'User.id',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name', 
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id',
                'Game.teams_gameday'
            ];
            $group =['User.name'];
            $order =['User.name'=> 'ASC'];
            $conditions = [
                'User.id' => $userid,
                'SoccerPrediction.game_day' => $gameday,
                'SoccerPrediction.sport_id' => $sport_id,
                   'SoccerPrediction.league_id' => $league_id,
                   'SoccerPrediction.tournament_id' => $tornament_id
            ];
            $this->paginate = [
                'limit' => 50,
                'conditions' => $conditions,
                'fields' => $fields,
               'group' =>$group,
                'order' =>$order
            ];
             
     
             $soccerwinnerdata_array[] = $this->Paginator->paginate('SoccerPrediction',$condition);
            // pr($soccerwinnerdata_array);exit;
            // $soccerwinnerdata_array[]=$soccerwinnerdata;
            //  $this->set(compact('soccerwinnerdata_array',$soccerwinnerdata));

              //
            /* $soccerwinnerdata_array[] = $this->SoccerPrediction->find('all', [
            'fields' => [
                'SoccerPrediction.game_day',
                'User.id',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name', 
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ],
             'group' =>['User.name'],
            'order' =>['User.name'=> 'ASC'],
            'conditions' => [
                'User.id' => $userid,
                'SoccerPrediction.game_day' => $gameday
            ]

        ]);*/
        
            
         $i++;
       }
   }
     // echo '<pre>';print_r( $soccerwinnerdata_array );exit;
         $new = $this->SoccerPrediction->find('all', [
            'fields' => [
                'SoccerPrediction.id',
                'SoccerPrediction.winner',
                'SoccerPrediction.is_deleted',
                'SoccerPrediction.status',
                'SoccerPrediction.created',
                'SoccerPrediction.modified',
                'SoccerPrediction.first_team_goals',
                'SoccerPrediction.second_team_goals',
                'SoccerPrediction.game_day',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ],
              'conditions' =>['SoccerPrediction.is_deleted'=>0,'SoccerPrediction.status'=>1,
            'User.is_deleted'=>0,'User.status'=>1,
            'Tournament.is_deleted'=>0,'Tournament.status'=>1,
          'Sport.status'=>1,'League.is_deleted'=>0,'League.status'=>1,'Game.is_deleted'=>0,'Game.status'=>1,]
        ]);

      //array_push($mains_array,$userid);
      //echo '<pre>';print_r($soccerwinnerdata_array);
       //exit;

     //echo sizeof($soccerwinnerdata_array);exit;
       

         $this->set(compact('soccerwinnerdata_array'));
      
         $this->set(compact('new'));
    }


     public function gift_name()
    {
        $this->autoRender = false;
       
        $this->Game->unbindModel([
            'belongsTo' => [
                'League'
            ]
        ]);
        $conditions = [];
        $conditions = $this->_getSearchConditions();

        $this->loadModel('CricketPrediction');
       // $gift_cat = $this->GiftCategory->find('list');
        $cricket = $this->CricketPrediction->find('all', [
            'fields' => [
                'CricketPrediction.id',
                'CricketPrediction.winner',
                'CricketPrediction.first_team_score',
                'CricketPrediction.second_team_score',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);
        // print_r(expression)($cricket);die;
        $this->set(compact('giftname'));
        // die();
    }
    public function admin_soccerResults()
    { $this->set('title_for_layout', 'Soccer winners');
        $this->loadModel('Gift');
         $this->loadModel('GamesGiftPrediction');
          $this->loadModel('GamesResult');
          $this->loadModel('SoccerPrediction');
         $conditions = [];
       $conditions = $this->_getGamesSearchConditions('GamesResult');

        $soccerwinner=$this->GamesGiftPrediction->query("SELECT `GamesGiftPrediction`.`user_id`, `GamesGiftPrediction`.`teams_gameday`,`GamesGiftPrediction`.`sport_id`,`GamesGiftPrediction`.`tournament_id`,`GamesGiftPrediction`.`league_id`, `Gifts`.`winning_no_game`,`Gifts`.`id` FROM .`gamesgiftprediction` AS `GamesGiftPrediction` LEFT JOIN .`users` AS `User` ON (`GamesGiftPrediction`.`user_id` = `User`.`id`) LEFT JOIN .`tournaments` AS `Tournament` ON (`GamesGiftPrediction`.`tournament_id` = `Tournament`.`id`) LEFT JOIN .`sports` AS `Sport` ON (`GamesGiftPrediction`.`sport_id` = `Sport`.`id`) LEFT JOIN .`leagues` AS `League` ON (`GamesGiftPrediction`.`league_id` = `League`.`id`) inner JOIN .`gifts` AS `Gifts` ON (`GamesGiftPrediction`.`gift_id` = `Gifts`.`id` AND ((`GamesGiftPrediction`.`sport_id` = `Gifts`.`sport_id`) OR (`Gifts`.`sport_id`=0)) AND ((`GamesGiftPrediction`.`tournament_id` = `Gifts`.`tournament_id`) OR (`Gifts`.`tournament_id`=0)) AND ((`GamesGiftPrediction`.`league_id` =`Gifts`.`league_id`) OR (`Gifts`.`league_id`=0))) WHERE `GamesGiftPrediction`.`is_deleted`=0 AND `GamesGiftPrediction`.`status`=1");  
      //echo '<pre>'; print_r($soccerwinner);
       $soccerwinnerlist_array=array();   
        $soccerwinnerdata_array=array();        
        $i=0;
        if(!empty($soccerwinner)){
           
       while($i<count($soccerwinner))
       {  
            $userid= $soccerwinner[$i]['GamesGiftPrediction']['user_id'];
            $gameday= $soccerwinner[$i]['GamesGiftPrediction']['teams_gameday'];
            $giftcount=$soccerwinner[$i]['Gifts']['winning_no_game'];
            $sport_id=$soccerwinner[$i]['GamesGiftPrediction']['sport_id'];
             $tornament_id=$soccerwinner[$i]['GamesGiftPrediction']['tournament_id'];
             $league_id=$soccerwinner[$i]['GamesGiftPrediction']['league_id'];
             $soccerwinnerlist=$this->SoccerPrediction->query("select soccerprediction.user_id,soccerprediction.first_team_goals,soccerprediction.second_team_goals,soccerprediction.game_day from soccer_predictions as soccerprediction inner join games_results as GamesResult ON soccerprediction.first_team_goals=GamesResult.first_team_goals and soccerprediction.second_team_goals=GamesResult.second_team_goals and soccerprediction.game_id=GamesResult.game_id and GamesResult.game_day=soccerprediction.game_day where soccerprediction.user_id =$userid and soccerprediction.game_day =$gameday and soccerprediction.is_deleted=0 and soccerprediction.status=1 and soccerprediction.sport_id =$sport_id and soccerprediction.league_id  = $league_id and 
                   soccerprediction.tournament_id = $tornament_id");

          //echo'<pre>';  print_r($soccerwinnerlist);
            if(!empty($soccerwinnerlist)){
                  
                // echo'<pre>';  print_r($soccerwinnerlist);
             $soccerwinnerlist_array[$i]['count']=count($soccerwinnerlist);
              //echo $j=count($soccerwinnerlist);
                 $soccerwinnerlist_array[$i]['userid']=$soccerwinnerlist[0]['soccerprediction']['user_id'];
                $soccerwinnerlist_array[$i]['gameday']=$soccerwinnerlist[0]['soccerprediction']['game_day'];
          
            if($soccerwinnerlist_array[$i]['count']>=$giftcount)
            { 
            
              $winneruser_id= $soccerwinnerlist_array[$i]['userid']; 
              $winnergame_day= $soccerwinnerlist_array[$i]['gameday']; 
           
             $this->paginate =  array('fields' => array('user.name','League.name','Tournament.name','GamesResult.id','GamesResult.sport_id','soccerprediction.user_id','GamesResult.tournament_id', 'GamesResult.league_id', 'GamesResult.game_id', 'GamesResult.game_day', 'GamesResult.first_team_goals', 'GamesResult.second_team_goals'),

                'joins' => array( 
                    array('table' => 'soccer_predictions',
                                  'alias' => 'soccerprediction',
                                   'type' => 'INNER',
                                   'conditions' => array('GamesResult.first_team_goals = soccerprediction.first_team_goals ','GamesResult.second_team_goals=soccerprediction.second_team_goals', 'GamesResult.game_day=soccerprediction.game_day','soccerprediction.game_id=GamesResult.game_id')
                            
                                   ),
                       array(
                        'table' => 'users',
                        'alias' => 'user',
                        'type' => 'left',
                        'conditions' => array('soccerprediction. user_id = user.id')
                    ),

                     
                    ),
                'conditions'=>array('soccerprediction.user_id' => $winneruser_id,'soccerprediction.game_day' => $winnergame_day,'soccerprediction.is_deleted' => 0),
                'limit' => 10,
                'group' => 'soccerprediction.user_id'
                );
              
             $soccerwinnerdata = $this->Paginator->paginate('GamesResult',$conditions);
             $soccerwinnerdata_array[]=$soccerwinnerdata;
            }
        }
            
         $i++;
       }
   }
      
         $new = $this->SoccerPrediction->find('all', [
               'fields' => [
                'SoccerPrediction.id',
                'SoccerPrediction.winner',
                'SoccerPrediction.is_deleted',
                'SoccerPrediction.status',
                'SoccerPrediction.created',
                'SoccerPrediction.modified',
                'SoccerPrediction.first_team_goals',
                'SoccerPrediction.second_team_goals',
                'SoccerPrediction.game_day',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ],
             'conditions' =>['SoccerPrediction.is_deleted'=>0,'SoccerPrediction.status'=>1,
            'User.is_deleted'=>0,'User.status'=>1,
            'Tournament.is_deleted'=>0,'Tournament.status'=>1,
          'Sport.status'=>1,'League.is_deleted'=>0,'League.status'=>1,'Game.is_deleted'=>0,'Game.status'=>1,]
        ]);
     
        $this->set(compact('soccerwinnerdata_array'));
         $this->set(compact('new'));
    }
    public function admin_soccerWinnerProfile($user_Id=null)
    {
        $this->layout = '';    
        $this->loadModel('User');
        $userId = base64_decode($user_Id);
        $fields=[
        'User.name','User.email'
        ];
         $condition=[
        'User.id ' =>$userId
        ];
        $dataExists= $this->User->find('first',  array('conditions' =>$condition,'fields' =>$fields));
     //$gameDatas = $this->Game->find('all', array('conditions' => $conditions, 'fields' => $fields));
           // pr($dataExists);exit;
        $this->set(compact('dataExists'));
    }

public function admin_soccerWinnerResult($user_Id=null,
$game_day=null)
    {
        $this->layout = '';    
        $this->loadModel('SoccerPrediction');
        $this->loadModel('UserTeam');
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        $this->loadModel('Game');
        $gameDay = base64_decode($game_day);
        $userId = base64_decode($user_Id);
          $dataExists= $this->SoccerPrediction->find('all',  array('fields' => array('User.name','League.name','Tournament.name','SoccerPrediction.id','SoccerPrediction.game_id','SoccerPrediction.sport_id','SoccerPrediction.user_id','SoccerPrediction.tournament_id', 'SoccerPrediction.league_id', 'SoccerPrediction.game_id', 'SoccerPrediction.game_day','gameresult.first_team_goals', 'gameresult.second_team_goals', 'SoccerPrediction.first_team_goals', 'SoccerPrediction.second_team_goals','file.first_team','file.second_team','team.name','secondteam.name'),

                'joins' => array( 
                    array('table' => 'games_results',
                                  'alias' => 'gameresult',
                                   'type' => 'INNER',
                                   'conditions' => array( 'SoccerPrediction.game_day=gameresult.game_day','SoccerPrediction.game_id=gameresult.game_id')
                                   ),
                     array(
                        'table' => 'games',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('SoccerPrediction.game_id = file.id')
                    ),
                    array(
                        'table' => 'teams',
                        'alias' => 'team',
                        'type' => 'right',
                        'conditions' => array('file.first_team =team.id')
                    ),
                    array(
                        'table' => 'teams',
                        'alias' => 'secondteam',
                        'type' => 'right',
                        'conditions' => array('file.second_team =secondteam.id')
                    ),
                    ),
                  'conditions'=>array('SoccerPrediction.game_day' => $gameDay,'SoccerPrediction.user_id' => $userId,'SoccerPrediction.is_deleted' => 0)
                )
          );

$giftdata= $this->GamesGiftPrediction->find('all',  array('fields' => array('gift.winning_no_game','gift.name', 'gift.type','gift.amount','GamesGiftPrediction.cashamount'),

                'joins' => array( 
                    array('table' => 'gifts',
                                   'alias' => 'gift',
                                   'type' => 'left',
                                   'conditions' => array( 'GamesGiftPrediction. gift_id = gift.id')
                                   ),
                     
                    ),
                  'conditions'=>array('GamesGiftPrediction.teams_gameday' => $gameDay,
                  'GamesGiftPrediction.is_deleted' => 0,'GamesGiftPrediction.user_id' => $userId)
                )
          );
 $this->set(compact('giftdata'));
 $this->set(compact('dataExists'));
    }

    /**
     * admin_edit method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_edit($id = null)
    {
       $this->set('title_for_layout', 'Update Game');
        $id = base64_decode($id);
        if (! $this->Game->exists($id))
        {
            throw new NotFoundException(__('Invalid league'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['stdate']);
            unset($this->request->data['enddate']);

            if ($this->Game->save($this->request->data))
            {
                $this->Flash->success(__('The league has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The league could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'Game.' . $this->Game->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Game->find('first', $options);
        }

        $leagues = $this->Game->League->find('list', [
            'conditions' => [
                'League.tournament_id' => $this->request->data['League']['tournament_id'],
                'League.is_deleted' => 0
            ],
            'order' => 'League.name'
        ]);
        $sports = $this->Game->Sport->find('list', [
            'order' => 'Sport.name'
        ]);
        $tournaments = $this->Game->Tournament->find('list', [
            'conditions' => [
                'Tournament.status' => 1,
                'Tournament.is_deleted' => 0,
                'Tournament.sport_id' => $this->request->data['Sport']['id']
            ],
            'order' => 'Tournament.name'
        ]);
        $teams = $this->Game->Team->find('list', [
            'conditions' => [
                'Team.status' => 1,
                'Team.is_deleted' => 0,
                'Team.sport_id' => $this->request->data['Sport']['id'],
                'Team.tournament_id' => $this->request->data['Tournament']['id'],
                'Team.league_id' => $this->request->data['League']['id']
            ],
            'order' => 'Team.name'
        ]);
        $this->set(compact('tournaments', 'sports', 'teams', 'leagues'));
    }

    /**
     * admin_delete method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_delete($id = null)
    {
        $this->set('title_for_layout', 'delete Game');
        $this->Game->id = base64_decode($id);
        if (! $this->Game->exists())
        {
            throw new NotFoundException(__('Invalid league'));
        }
        $status = $this->Game->find('first', [
            'conditions' => [
                'Game.id' => $this->Game->id,
                'Game.end_time >' => date('Y-m-d h:i:s')
            ],
            'fields' => [
                'Game.status'
            ]
        ]);
        if (! empty($status) && $status['Game']['status'] == 1)
        {
            $this->Flash->error(__('The game could not be deleted. Please, try again.'));
            $this->Flash->error(__('You can not delete active league game. Some game still has to play.'));
        }
        else
        {
            $this->Game->saveField('is_deleted', 1);
            $this->Game->saveField('deleted_by', AuthComponent::User('id'));
            $name = $this->Game->find('first', [
                'conditions' => [
                    'Game.id' => $this->Game->id
                ],
                'fields' => [
                    'Game.name'
                ]
            ]);
            // $this->request->data['Game']['name'] = $name['Game']['name'].'-is-deleted';
            /* if ($this->Game->saveField('name',$this->request->data['Game']['name']) && $this->Game->saveField('status',0)) */
            if ($this->Game->saveField('status', 0))
            {
                $this->Flash->success(__('Game has been deleted sucessfully.'));
            }
            else
                $this->Flash->error(__('The game could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
       /* $this->set('title_for_layout', 'Add Game');

        $this->loadModel('Gameday');
        if ($this->request->is('post'))
        {
            $this->Game->validate = $this->Game->validate;
            $this->Game->set($this->request->data);
            if ($this->Game->validates())
            {
                $dataAuto = $this->request->data;
                unset($dataAuto['stdate']);
                unset($dataAuto['enddate']
                    );
                
                // $this->loadModel('League');
                // $leagueStartEnd = $this->League->find('first',array('conditions'=>array('League.id'=>$this->request->data['Game']['league_id'])));
                // if(!empty($leagueStartEnd)){
                //
                // if(strtotime($this->request->data['Game']['start_time']) < $leagueStartEnd['League']['start_date'] || strtotime($this->request->data['Game']['end_time']) > $leagueStartEnd['League']['end_date']){
                // $this->Flash->error(__('Duration not match according to league.'));
                // return $this->redirect($this->referer());
                // }
                // }
                if ($this->request->data['Game']['end_time'] <= $this->request->data['Game']['start_time'])
                {

                    $this->Flash->success(__('End date can not be smaller then start date.'));
                    return $this->redirect([
                        'action' => 'add'
                    ]);
                }
                  $tid= $this->data['Game']['tournament_id'];
                   $lid=$this->data['Game']['league_id'];
                   $sid=$this->data['Game']['sport_id'];
                   $first_team=$this->data['Game']['first_team'];
                   $second_team=$this->data['Game']['second_team'];

                    if($sid!==1){
                     $gameday = $this->Game->find('first', [
                        'conditions' => [
                            'Game.tournament_id' => $tid,
                            'Game.league_id' => $lid,
                            'Game.sport_id' => $sid,
                                'or' => array(
                              'Game.first_team' =>$first_team,
                            'Game.second_team' =>$first_team
                            )  
                        ],
                        'fields' => [
                            'firstteam_gameday','secondteam_gameday','teams_gameday'
                        ],
                         'order' => ['id' => 'DESC']
                    ]);

                   $game_day = $this->Game->find('first', [
                        'conditions' => [
                            'Game.tournament_id' => $tid,
                            'Game.league_id' => $lid,
                            'Game.sport_id' => $sid,
                            
                                'or' => array(
                            'Game.first_team' =>$second_team,
                            'Game.second_team' =>$second_team
                            )
                        
                           
                        ],
                        'fields' => [
                            'firstteam_gameday','secondteam_gameday','teams_gameday'
                        ],
                         'order' => ['id' => 'DESC']
                    ]);
                   }

                if ($this->Game->save($this->request->data))
                {

                  if(isset($gameday) && !empty($gameday) && isset($game_day) && !empty($game_day)){
               
                   $first_teamgameday=$gameday['Game']['firstteam_gameday']+1;
                   $second_teamgameday=$game_day['Game']['secondteam_gameday']+1;
                 
                    $firstgameday=$this->Game->savefield('firstteam_gameday',$first_teamgameday);
                    $secondgameday=$this->Game->savefield('secondteam_gameday',$second_teamgameday); 
                    $gameday=$this->Game->savefield('teams_gameday',$first_teamgameday);
        
                   
                }
                else
                {
                     $this->Game->savefield('firstteam_gameday',1);
                    $this->Game->savefield('secondteam_gameday',1);
                     $this->Game->savefield('teams_gameday',1);
                }
                 if($sid==1){
                     $this->Game->savefield('firstteam_gameday',0);
                    $this->Game->savefield('secondteam_gameday',0);
                    $this->Game->savefield('teams_gameday',0);
                }
                   
                    $this->Flash->success(__('The game has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The game could not be saved. Please, try again.'));
            }
            else
            {
                $error = $this->Game->validationErrors;
            }
        }

        $sports = $this->Game->Sport->find('list', [
            'order' => 'Sport.name'
        ]);

        $this->set(compact('sports'));*/
        $this->set('title_for_layout', 'Add Game');
        if ($this->request->is('post'))
        {
            $this->Game->validate = $this->Game->validate;
            $this->Game->set($this->request->data);
            if ($this->Game->validates())
            {
                $dataAuto = $this->request->data;
                unset($dataAuto['stdate']);
                unset($dataAuto['enddate']);
                // $this->loadModel('League');
                // $leagueStartEnd = $this->League->find('first',array('conditions'=>array('League.id'=>$this->request->data['Game']['league_id'])));
                // if(!empty($leagueStartEnd)){
                //
                // if(strtotime($this->request->data['Game']['start_time']) < $leagueStartEnd['League']['start_date'] || strtotime($this->request->data['Game']['end_time']) > $leagueStartEnd['League']['end_date']){
                // $this->Flash->error(__('Duration not match according to league.'));
                // return $this->redirect($this->referer());
                // }
                // }
                if ($this->request->data['Game']['end_time'] <= $this->request->data['Game']['start_time'])
                {
                    $this->Flash->success(__('End date can not be smaller then start date.'));
                    return $this->redirect([
                        'action' => 'add'
                    ]);
                }
                if ($this->Game->save($this->request->data))
                {
                    $this->Flash->success(__('The game has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The game could not be saved. Please, try again.'));
            }
            else
            {
                $error = $this->Game->validationErrors;
            }
        }

        $sports = $this->Game->Sport->find('list', [
            'order' => 'Sport.name'
        ]);

        $this->set(compact('sports'));
    }

    /**
     * admin_importData method
     *
     * @return void
     */
    private function covertArray($arr){
        $result = array();
        foreach($arr as $key => $value)
        {
            $key1 = trim(strtolower($value));
            {
                $result[$key1] = $key;
            }
        }
        return $result;
    }
    public function admin_importData(){
        $result = 'success';
        Configure::write('debug', 0);
        App::import('Vendor', 'PHPExcel');
        $objPHPExcel = new PHPExcel();

        $gameObjects = array();
        $sports = $this->Game->Sport->find('list', [
            'order' => 'Sport.name'
        ]);

        $sport_keys = self::covertArray($sports);

        $tournaments = $this->Game->Tournament->find('list', [
            'conditions' => [
                // 'Tournament.sport_id' => $id,
                'Tournament.status' => 1,
                'Tournament.is_deleted' => 0
            ],
            'order' => 'Tournament.name',
            'fields' => [
                'Tournament.id',
                'Tournament.name',
                'Tournament.sport_id'
            ]
        ]);

        $leagues = $this->Game->League->find('list', [
            'conditions' => [
                // 'League.tournament_id' => $id,
                'League.end_date >=' => date('Y-m-d h:i:s'),
                'League.is_deleted' => 0
            ],
            'order' => 'League.name',
            'fields' => [
                'League.id',
                'League.name',
                'League.tournament_id'
            ]
        ]);
        $teams = $this->Game->Team->find('list', [
            'conditions' => [
                // 'Team.league_id' => $id,
                'Team.status' => 1,
                'Team.is_deleted' => 0
            ],
            'order' => 'Team.name',
            'fields' => [
                'Team.id',
                'Team.name',
                'Team.league_id'
            ]
        ]);


        $colIndexArr = array(
            'B' => 'sport_id',
            'C' => 'tournament_id',
            'D' => 'league_id',
            'E' => 'start_time',
            'F' => 'end_time',
            'G' => 'first_team',
            'H' => 'second_team',
            'I' => 'teams_gameday',
            'J' => 'status'
        );

        $status_arr = array(
            'inactive' => 0,
            'active' => 1,
            );
        if ($this->request->is('post') && isset($_FILES['csv_filename']))
        {
            $file_addr = $_FILES['csv_filename']['tmp_name'];
            $excelReader = PHPExcel_IOFactory::createReaderForFile($file_addr);
            $excelObj = $excelReader->load($file_addr);
            $worksheet = $excelObj->getSheet(0);
            $lastRow = $worksheet->getHighestRow();
            $lastCol = $worksheet->getHighestDataColumn();

            for ($row = 2; $row <= $lastRow; $row++) {
                $game_item = array();
                $is_rowValid = true;
                $sport_id = $tournament_id = $league_id = $first_team_id = $second_team_id = null;
                for ($col = 'B'; $col <= 'J'; $col++) {
                    $value = trim(strtolower($worksheet->getCell($col.$row)->getFormattedValue()));
                    if($col == 'B')
                    {
                        if(isset($sport_keys[$value]))
                        {
                            $sport_id = $sport_keys[$value];
                            $value = $sport_id;
                        }else{
                            $is_rowValid = false;
                        }
                    }
                    if($col == 'C')
                    {
                        if(!is_null($sport_id))
                        {
                            $tournament_keys = self::covertArray($tournaments[$sport_id]);
                            if(isset($tournament_keys[$value]))
                            {

                                $tournament_id = $tournament_keys[$value];
                                $value = $tournament_id;
                                $is_rowValid = true;    
                            }else{
                                $is_rowValid = false;
                            }
                        }
                    }
                    if($col == 'D')
                    {
                        if(!is_null($tournament_id))
                        {
                            $league_keys = self::covertArray($leagues[$tournament_id]);
                            if(isset($league_keys[$value]))
                            {
                                $league_id = $league_keys[$value];
                                $value = $league_id;
                                $is_rowValid = true;
                            }else{
                                $is_rowValid = false;
                            }
                        }
                    }
                    if($col == 'E')
                    {
                        try{
                           if (new DateTime($value)){
                                $start_time = new DateTime($value);
                                $value = date_format($start_time, 'Y-m-d H:i:s');
                            }else{
                                $is_rowValid = false;
                            }
                        }
                        catch(Exception $e){
                            $is_rowValid = false;
                            break;
                        }
                    }
                    if($col == 'F')
                    {
                        try{
                           if (new DateTime($value)){
                                $end_time = new DateTime($value);
                                $value = date_format($end_time, 'Y-m-d H:i:s');
                            }else{
                                $is_rowValid = false;
                            }
                        }
                        catch(Exception $e){
                            break;
                        }
                    }
                    if($col == 'G')
                    {
                        if(!is_null($league_id))
                        {
                            $team_keys = self::covertArray($teams[$league_id]);
                            if(isset($team_keys[$value]))
                            {
                                $first_team_id = $team_keys[$value];
                                $value = $first_team_id;
                                $is_rowValid = true;
                            }else{
                                $is_rowValid = false;
                            }
                        }
                    }
                    if($col == 'H')
                    {
                        if(!is_null($league_id))
                        {
                            $team_keys = self::covertArray($teams[$league_id]);
                            if(isset($team_keys[$value]) && $team_keys[$value] != $first_team_id)
                            {
                                $second_team_id = $team_keys[$value];
                                $value = $second_team_id;
                                $is_rowValid = true;
                            }else{
                                $is_rowValid = false;
                            }
                        }
                    }
                    if($col == 'I')
                    {
                        $value = intval($value);
                    }
                    if($col == 'J')
                    {
                        $value = isset($status_arr[$value])? $status_arr[$value] : 1;
                    }
                    if(!$is_rowValid)
                        break;
                    $game_item[$colIndexArr[$col]] = $value;
                }
                if($is_rowValid)
                    $gameObjects[] = $game_item;            
            }
        }
        if(count($gameObjects))
        {
            $this->Game->saveAll($gameObjects);
        }
        if (count($gameObjects))
        {
            $this->Flash->success(__(count($gameObjects).' row(s) are imported successfully.'));
        }
        else
            $this->Flash->error(__('Error occured. Please, try again.'));

        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * admin_view method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_view($id = null)
    {
        $this->set('title_for_layout', 'View Game');
        $id = base64_decode($id);
        if (! $this->Game->exists($id))
        {
            throw new NotFoundException(__('Invalid game'));
        }
        $options = [
            'conditions' => [
                'Game.' . $this->Game->primaryKey => $id
            ]
        ];
        $this->set('game', $this->Game->find('first', $options));
    }

    /**
     * sports_index method
     *
     * @return void
     */
    public function sports_index()
    {
        $this->set('title_for_layout', 'List Games');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'League.created DESC');
    }

    /**
     * sports_add method
     *
     * @return void
     */
    public function sports_add()
    {
        $this->set('title_for_layout', 'Add Game');
        if ($this->request->is('post'))
        {
            $this->request->data['Game']['sport_id'] = $this->Session->read('Auth.Sports.SportInfo')['Sport']['id'];
            if ($this->Game->save($this->request->data))
            {
                $this->Flash->success(__('The team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The team could not be saved. Please, try again.'));
        }

        $tournaments = $this->Game->Tournament->find('list', [
            'conditions' => [
                'status' => 1,
                'is_deleted' => 0,
                'sport_id' => $this->Session->read('Auth.Sports.SportInfo')['Sport']['id']
            ],
            'order' => 'Tournament.name'
        ]);
        $this->set(compact('tournaments'));
    }

    /**
     * sport_edit method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_edit($id = null)
    {
        $this->set('title_for_layout', 'Update Game');
        $id = base64_decode($id);
        if (! $this->Game->exists($id))
        {
            throw new NotFoundException(__('Invalid Game'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {

            $this->request->data['Game']['sport_id'] = $this->Session->read('Auth.Sports.SportInfo')['Sport']['id'];
            if ($this->Game->save($this->request->data))
            {
                $this->Flash->success(__('The Game has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The Game could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'Game.' . $this->Game->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Game->find('first', $options);
        }

        $sportId = $this->Session->read('Auth.Sports.SportInfo')['Sport']['id'];

        $tournaments = $this->Game->Tournament->find('list', [
            'conditions' => [
                'Tournament.status' => 1,
                'Tournament.is_deleted' => 0,
                'Tournament.sport_id' => $sportId
            ],
            'order' => 'Tournament.name'
        ]);

        $leagues = $this->Game->League->find('list', [
            'conditions' => [
                'League.sport_id' => $sportId,
                'League.is_deleted' => 0,
                'League.status' => 1,
                'League.end_date >=' => date('Y-m-d h:i:s'),
                'League.tournament_id' => $this->request->data['League']['tournament_id'],
                'League.is_deleted' => 0
            ],
            'order' => 'League.name'
        ]);

        $teams = $this->Game->Team->find('list', [
            'conditions' => [
                'Team.status' => 1,
                'Team.is_deleted' => 0,
                'Team.sport_id' => $sportId,
                'Team.tournament_id' => $this->request->data['Tournament']['id'],
                'Team.league_id' => $this->request->data['League']['id']
            ],
            'order' => 'Team.name'
        ]);
        $this->set(compact('tournaments', 'teams', 'leagues'));
    }

    /**
     * sport_view method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_view($id = null)
    {
        $this->set('title_for_layout', 'View Game');
        $id = base64_decode($id);
        if (! $this->Game->exists($id))
        {
            throw new NotFoundException(__('Invalid game'));
        }
        $options = [
            'conditions' => [
                'Game.' . $this->Game->primaryKey => $id
            ]
        ];
        $this->set('game', $this->Game->find('first', $options));
    }

    /**
     * sport_delete method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_delete($id = null)
    {
        $this->set('title_for_layout', 'Delete Game');
        $this->Game->id = base64_decode($id);
        if (! $this->Game->exists())
        {
            throw new NotFoundException(__('Invalid game'));
        }
        $status = $this->Game->find('first', [
            'conditions' => [
                'Game.id' => $this->Game->id,
                'Game.end_time >' => date('Y-m-d h:i:s')
            ],
            'fields' => [
                'Game.status'
            ]
        ]);
        if (! empty($status) && $status['Game']['status'] == 1)
        {
            $this->Flash->error(__('You can not delete active league game. Some game still has to play.'));
        }
        else
        {
            $this->Game->saveField('is_deleted', 1);
            $this->Game->saveField('deleted_by', AuthComponent::User('id'));
            $name = $this->Game->find('first', [
                'conditions' => [
                    'Game.id' => $this->Game->id
                ],
                'fields' => [
                    'Game.name'
                ]
            ]);
            $this->request->data['Game']['name'] = $name['Game']['name'] . '-is-deleted';
            if ($this->Game->saveField('name', $this->request->data['Game']['name']) && $this->Game->saveField('status', 0))
            {
                $this->Flash->success(__('The game has been deleted.'));
            }
            else
                $this->Flash->error(__('The game could not be deleted. Please, try again.'));
        }

        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * league_index method
     *
     * @return void
     */
    public function league_index()
    {
        $this->set('title_for_layout', 'List Games');
        // $this->Game->recursive = 0;
        // $this->set('games', $this->Paginator->paginate());
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'League.created DESC');
    }

    /**
     * league_add method
     *
     * @return void
     */
    public function league_add()
    {
        $this->set('title_for_layout', 'Add Game');
        if ($this->request->is('post'))
        {
            unset($this->request->data['stdate']);
            unset($this->request->data['enddate']);
            unset($this->request->data['leagu']);
            $this->request->data['Game']['tournament_id'] = $this->Session->read('Auth.League.SportInfo')['League']['tournament_id'];
            $this->request->data['Game']['sport_id'] = $this->Session->read('Auth.League.SportInfo')['League']['sport_id'];
            if ($this->Game->save($this->request->data))
            {
                $this->Flash->success(__('The team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The team could not be saved. Please, try again.'));
        }
        $leagues = $this->Game->League->find('list', [
            'conditions' => [
                'status' => 1,
                'end_date >=' => date('Y-m-d'),
                'sport_id' => $this->Session->read('Auth.League.SportInfo')['League']['sport_id'],
                'user_id' => AuthComponent::User('id'),
                'League.is_deleted' => 0
            ],
            'order' => 'League.name'
        ]);
        $this->set(compact('leagues'));
    }

    /**
     * league_edit method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function league_edit($id = null)
    {
        $this->set('title_for_layout', 'Update Game');
        $id = base64_decode($id);
        if (! $this->Game->exists($id))
        {
            throw new NotFoundException(__('Invalid league'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['stdate']);
            unset($this->request->data['enddate']);
            unset($this->request->data['leagu']);
            $this->request->data['Game']['tournament_id'] = $this->Session->read('Auth.League.SportInfo')['League']['tournament_id'];
            $this->request->data['Game']['sport_id'] = $this->Session->read('Auth.League.SportInfo')['League']['sport_id'];
            if ($this->Game->save($this->request->data))
            {
                $this->Flash->success(__('The league has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The league could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'Game.' . $this->Game->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Game->find('first', $options);
        }

        $sportId = $this->Session->read('Auth.League.SportInfo')['League']['sport_id'];

        $leagues = $this->Game->League->find('list', [
            'conditions' => [
                'League.is_deleted' => 0
            ],
            'order' => 'League.name'
        ]);

        $tournaments = $this->Game->Tournament->find('list', [
            'conditions' => [
                'Tournament.is_deleted' => 0
            ],
            'order' => 'Tournament.name'
        ]);
        $teams = $this->Game->Team->find('list', [
            'conditions' => [
                'Team.league_id' => $this->Session->read('Auth.League.SportInfo')['League']['id'],
                'status' => 1,
                'is_deleted' => 0
            ],
            'order' => 'Team.name'
        ]);
        $this->set(compact('tournaments', 'sports', 'teams', 'leagues'));
    }

    /**
     * league_view method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function league_view($id = null)
    {
        $this->set('title_for_layout', 'View Game');
        $id = base64_decode($id);
        if (! $this->Game->exists($id))
        {
            throw new NotFoundException(__('Invalid game'));
        }
        $options = [
            'conditions' => [
                'Game.' . $this->Game->primaryKey => $id
            ]
        ];
        $this->set('game', $this->Game->find('first', $options));
    }

    /**
     * league_delete method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function league_delete($id = null)
    {
        $this->set('title_for_layout', 'Delete Game');
        $this->Game->id = base64_decode($id);
        if (! $this->Game->exists())
        {
            throw new NotFoundException(__('Invalid league'));
        }
        $status = $this->Game->find('first', [
            'conditions' => [
                'Game.id' => $this->Game->id,
                'Game.end_time >' => date('Y-m-d h:i:s')
            ],
            'fields' => [
                'Game.status'
            ]
        ]);
        if (! empty($status) && $status['Game']['status'] == 1)
        {
            $this->Flash->error(__('You can not delete active league game. Some game still has to play.'));
        }
        else
        {
            $this->Game->saveField('is_deleted', 1);
            $this->Game->saveField('deleted_by', AuthComponent::User('id'));
            $name = $this->Game->find('first', [
                'conditions' => [
                    'Game.id' => $this->Game->id
                ],
                'fields' => [
                    'Game.name'
                ]
            ]);
            $this->request->data['Game']['name'] = $name['Game']['name'] . '-is-deleted';
            if ($this->Game->saveField('name', $this->request->data['Game']['name']) && $this->Game->saveField('status', 0))
            {
                $this->Flash->success(__('The game has been deleted.'));
            }
            else
                $this->Flash->error(__('The game could not be deleted. Please, try again.'));
        }
        /*
         * $this->request->allowMethod('post', 'delete');
         * if ($this->Game->delete()) {
         * $this->Flash->success(__('The league has been deleted.'));
         * } else {
         * $this->Flash->error(__('The league could not be deleted. Please, try again.'));
         * }
         */
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * getTournamentsAjax method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function getTournamentsAjax($id = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $id = base64_decode($id);
        $options = $this->Game->Tournament->find('list', [
            'conditions' => [
                'Tournament.sport_id' => $id,
                'Tournament.status' => 1,
                'Tournament.is_deleted' => 0
            ],
            'order' => 'Tournament.name'
        ]);
        echo $this->View->Form->input('Game.tournament_id', [
            'class' => 'form-control',
            'label' => false,
            'empty' => '-- Select Tournament --',
            'options' => $options,
            'onchange' => 'getLeagues(this);'
        ]);
    }

 

    /**
     * getLeaguesAjax method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function getLeaguesAjax($id = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $id = base64_decode($id);
        $options = $this->Game->League->find('list', [
            'conditions' => [
                'League.tournament_id' => $id,
                'League.end_date >=' => date('Y-m-d h:i:s'),
                'League.is_deleted' => 0
            ],
            'order' => 'League.name',
            'League.status' => 1
        ]);
        echo $this->View->Form->input('Game.league_id', [
            'class' => 'form-control',
            'label' => false,
            'empty' => '-- Select League --',
            'options' => $options,
            'onchange' => 'getTeams(this);'
        ]);
    }

    /**
     * getTeamsAjax method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function getTeamsAjax($id = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $id = base64_decode($id);
        $options = $this->Game->Team->find('list', [
            'conditions' => [
                'Team.league_id' => $id,
                'Team.status' => 1,
                'Team.is_deleted' => 0
            ],
            'order' => 'Team.name'
        ]);
        echo $this->View->Form->input('Game.first_team', [
            'class' => 'form-control',
            'label' => false,
            'empty' => '-- Select Team --',
            'options' => $options,
            'onchange' => 'getTeamsFilter(this);'
        ]);
    }

    /**
     * getTeamsFilter method
     *
     * @param null|mixed $id
     * @param null|mixed $leagueId
     *
     * @return void
     */
    public function getTeamsFilterAjax($id = null, $leagueId = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $id = base64_decode($id);
        $leagueId = base64_decode($leagueId);
        // echo $id,$tid;
        $options = $this->Game->Team->find('list', [
            'conditions' => [
                'Team.league_id' => $leagueId,
                'Team.status' => 1,
                'Team.id !=' => $id,
                'Team.is_deleted' => 0
            ],
            'order' => 'Team.name'
        ]);
        echo $this->View->Form->input('Game.second_team', [
            'class' => 'form-control',
            'label' => false,
            'empty' => '-- Select Team --',
            'options' => $options
        ]);
    }

    /**
     * cricketScheduling method
     *
     * @return void
     */
    public function cricketScheduling()
    {
        $this->_checkSportSession();
        $this->Game->unbindModel([
            'hasMany' => [
                'Team'
            ]
        ]);

        $this->loadModel('CricketPrediction');
        $this->set('title_for_layout', __('Cricket Scheduling'));
        $this->loadModel('UserTeam');

        $teamId = $this->Auth->Session->read('Auth.User.sportSession.team_id');
        $teamStatus = $this->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.status' => 1,
                'UserTeam.team_id' => $teamId,
                'UserTeam.user_id' => AuthComponent::User('id')
            ],
            'fields' => [
                'UserTeam.status'
            ]
        ]);
        if ($teamStatus['UserTeam']['status'] == 1)
        {
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id'
            ];

            // $gameDatas = $this->Game->find('all', array('conditions' => array('Game.sport_id' => AuthComponent::User('sportSession.sport_id'), 'Game.league_id' => AuthComponent::User('sportSession.league_id'), 'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'), 'Game.status' => 1, 'Game.end_time >' => date('Y-m-d h:i:s'), 'OR' => array('Game.first_team' => AuthComponent::User('sportSession.team_id'), 'Game.second_team' => AuthComponent::User('sportSession.team_id'))), 'fields' => $fields));
            $today = date('Y-m-d');
            $maxDays = date('Y-m-d', strtotime('+11 days'));
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id'
            ];
            $conditions = [
                'Game.start_time >=' => $today,
                'Game.start_time <=' => $maxDays,
                'Game.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'Game.status' => 1,
                'Game.end_time >' => date('Y-m-d h:i:s')
            ];
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            $gameDatas = $this->Paginator->paginate('Game');
        }
        else
        {
            $gameDatas = '';
        }
      // echo'<pre>'; print_r($gameDatas);die;
        $this->set(compact('gameDatas'));
    }

 
    /**
     * scheduleDownload method
     *
     * @return void
     */
    public function scheduleDownload()
    {
        $this->autoRender = false;
        $this->_checkSportSession();
        $this->Game->unbindModel([
            'hasMany' => [
                'Team'
            ]
        ]);

        $teamId = $this->Auth->Session->read('Auth.User.sportSession.team_id');

        $fields = [
            'First_team.id',
            'First_team.name',
            'Second_team.id',
            'Second_team.name',
            'Game.start_time',
            'Game.end_time',
            'Game.id',
            'Sport.id',
            'League.id',
            'Tournament.id'
        ];
        $gameDatas = $this->Game->find('all', [
            'conditions' => [
                'Game.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'Game.league_id' => AuthComponent::User('sportSession.league_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status' => 1,
                'Game.end_time >' => date('Y-m-d h:i:s'),
                'OR' => [
                    'Game.first_team' => AuthComponent::User('sportSession.team_id'),
                    'Game.second_team' => AuthComponent::User('sportSession.team_id')
                ]
            ],
            'fields' => $fields
        ]);

        Configure::write('debug', 0);
        App::import('Vendor', 'PHPExcel');
        $objPHPExcel = new PHPExcel();

        $styleArray2 = [
            'font' => [
                'name' => 'Arial',
                'size' => '10',
                'color' => [
                    'rgb' => '444555'
                ],
                'bold' => true
            ],
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => [
                    'rgb' => 'D6D6D6'
                ]
            ]
        ];
        $styleArray = [
            'font' => [
                'name' => 'Arial',
                'size' => '10',
                'color' => [
                    'rgb' => 'ffffff'
                ],
                'bold' => true
            ],
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => [
                    'rgb' => '0295C9'
                ]
            ]
        ];
        // ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
        $filename = 'schedule ' . date('Y-m-d') . '.xls'; // create a file
        $objPHPExcel->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(10);
        $objPHPExcel->getDefaultStyle()
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getDefaultStyle()
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setTitle('Game Schedule');

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'First Team');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Second Team');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Start Time  ');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'End Time');
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1')
            ->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()
            ->getStyle('B1')
            ->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()
            ->getStyle('C1')
            ->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()
            ->getStyle('D1')
            ->applyFromArray($styleArray);
        $i = 2;
        foreach ($gameDatas as $key => $data)
        {
            $objPHPExcel->getActiveSheet()->setCellValue("A$i", $data['First_team']['name']);

            $objPHPExcel->getActiveSheet()->setCellValue("B$i", $data['Second_team']['name']);

            $objPHPExcel->getActiveSheet()->setCellValue("C$i", $data['Game']['start_time']);

            $objPHPExcel->getActiveSheet()->setCellValue("D$i", $data['Game']['end_time']);

            ++ $i;
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit();
    }

    /**
     * CricketPrediction method
     *
     * @param null|mixed $gameId
     * @param null|mixed $leagueId
     * @param null|mixed $tournamentId
     * @param null|mixed $sportId
     *
     * @return void
     */
    public function cricketPrediction($gameId = null, $leagueId = null, $tournamentId = null, $sportId = null)
    {
        $this->layout = '';
        $this->loadModel('CricketPrediction');
        // $gift_cat = $this->GiftCategory->find('list');
        // $location = $this->Location->find('list');

        $this->set(compact('sportId', 'leagueId', 'tournamentId', 'gameId'));
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['CricketPrediction']['type']);
            unset($this->request->data['CricketPrediction']['location_id']);
            unset($this->request->data['CricketPrediction']['gift_category_id']);
            // pr($this->request->data);die;
            $this->request->data['CricketPrediction']['user_id'] = AuthComponent::User('id');

            if ($this->CricketPrediction->save($this->request->data))
            {
                $this->Flash->success(__('Prediction has been saved.'));
                return $this->redirect([
                    'controller' => 'Games',
                    'action' => 'cricketScheduling'
                ]);
            }
            $this->Flash->error(__('Prediction could not be saved. Please, try again.'));
        }
    }

    /**
     * findPrediction method
     *
     * @param null|mixed $gameId
     * @param null|mixed $firstTeam
     * @param null|mixed $secondTeam
     *
     * @return void
     */
    public function findCricketPrediction($gameId = null, $firstTeam = null, $secondTeam = null)
    {
        $this->layout = '';
        $userId = $this->Session->read('Auth.User.id');
        $this->loadModel('CricketPrediction');
        $gameId = base64_decode($gameId);
        $firstTeam = base64_decode($firstTeam);
        $secondTeam = base64_decode($secondTeam);
        $dataExist = $this->CricketPrediction->find('first', [
            'conditions' => [
                'CricketPrediction.game_id' => $gameId,
                'CricketPrediction.user_id' => $userId
            ]
        ]);
        $this->set(compact('dataExist', 'firstTeam', 'secondTeam'));
    }

    /**
     * baseballScheduling method
     *
     * @return void
     */
    public function baseballScheduling()
    {
        $this->_checkSportSession();
        $this->Game->unbindModel([
            'hasMany' => [
                'Team'
            ]
        ]);
        $this->loadModel('BaseballPrediction');
        $this->set('title_for_layout', __('Baseball Scheduling'));
        $this->loadModel('UserTeam');
        $teamId = $this->Auth->Session->read('Auth.User.sportSession.team_id');
        $teamStatus = $this->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.status' => 1,
                'UserTeam.team_id' => $teamId,
                'UserTeam.user_id' => AuthComponent::User('id')
            ],
            'fields' => [
                'UserTeam.status'
            ]
        ]);
        if ($teamStatus['UserTeam']['status'] == 1)
        {
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id'
            ];

            // $gameDatas = $this->Game->find('all', array('conditions' => array('Game.sport_id' => AuthComponent::User('sportSession.sport_id'), 'Game.league_id' => AuthComponent::User('sportSession.league_id'), 'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'), 'Game.status' => 1, 'Game.end_time >' => date('Y-m-d h:i:s'), 'OR' => array('Game.first_team' => AuthComponent::User('sportSession.team_id'), 'Game.second_team' => AuthComponent::User('sportSession.team_id'))), 'fields' => $fields));
            $today = date('Y-m-d');
            $maxDays = date('Y-m-d', strtotime('+11 days'));
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id'
            ];
            $conditions = [
                'Game.start_time >=' => $today,
                'Game.start_time <=' => $maxDays,
                'Game.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'Game.status' => 1,
                'Game.end_time >' => date('Y-m-d h:i:s')
            ];
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            $gameDatas = $this->Paginator->paginate('Game');
        }
        else
        {
            $gameDatas = '';
        }
        $this->set(compact('gameDatas'));
    }

    /**
     * baseballPrediction method
     *
     * @param null|mixed $gameId
     * @param null|mixed $leagueId
     * @param null|mixed $tournamentId
     * @param null|mixed $sportId
     *
     * @return void
     */
    public function baseballPrediction($gameId = null, $leagueId = null, $tournamentId = null, $sportId = null)
    {
        $this->layout = '';
        $this->loadModel('BaseballPrediction');
        $this->set(compact('sportId', 'leagueId', 'tournamentId', 'gameId'));
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['BaseballPrediction']['type']);
            unset($this->request->data['BaseballPrediction']['location_id']);
            unset($this->request->data['BaseballPrediction']['gift_category_id']);
            $this->request->data['BaseballPrediction']['user_id'] = AuthComponent::User('id');

            if ($this->BaseballPrediction->save($this->request->data))
            {
                $this->Flash->success(__('Prediction has been saved.'));
                return $this->redirect([
                    'controller' => 'Games',
                    'action' => 'baseballScheduling'
                ]);
            }
            $this->Flash->error(__('Prediction could not be saved. Please, try again.'));
        }
    }

    /**
     * findBaseballPrediction method
     *
     * @param null|mixed $gameId
     * @param null|mixed $firstTeam
     * @param null|mixed $secondTeam
     *
     * @return void
     */
    public function findBaseballPrediction($gameId = null, $firstTeam = null, $secondTeam = null)
    {
        $this->layout = '';
        $userId = $this->Session->read('Auth.User.id');
        $this->loadModel('BaseballPrediction');
        $gameId = base64_decode($gameId);
        $firstTeam = base64_decode($firstTeam);
        $secondTeam = base64_decode($secondTeam);
        $dataExist = $this->BaseballPrediction->find('first', [
            'conditions' => [
                'BaseballPrediction.game_id' => $gameId,
                'BaseballPrediction.user_id' => $userId
            ]
        ]);
        $this->set(compact('dataExist', 'firstTeam', 'secondTeam'));
    }

    /**
     * footballScheduling method
     *
     * @todo dynamic scheduling using user details
     *
     * @return void
     */
    public function footballScheduling()
    {
       $this->_checkSportSession();
        $this->Game->unbindModel([
            'hasMany' => [
                'Team'
            ]
        ]);
        $this->loadModel('FootballPrediction');
        $this->set('title_for_layout', __('Football Scheduling'));
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        $this->loadModel('UserTeam');
       $team_id = $this->Auth->Session->read('Auth.User.sportSession.team_id');
         $user_id = AuthComponent::User('id');
        $current_tournament = $this->Tournament->find('first', [
            'conditions' => [
                'Tournament.id ' => AuthComponent::User('sportSession.tournament_id'),

            ],
            'fields' => [
                'Tournament.name'
            ],
        ]);
        
        $tournament_name = NULL;
     if(!empty($current_tournament))
        {
            $tournament_name = $current_tournament['Tournament']['name'];
        }
        $teamStatus = $this->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.status' => UserTeam::STATUS_ACTIVE,
                'UserTeam.team_id' => $team_id,
                'UserTeam.user_id' => $user_id,

            ],
            'fields' => [
                'UserTeam.status'
            ],
        ]);
        $giftsfootball_id = $this->GamesGiftPrediction->find('first', [
            'conditions' => [
                'GamesGiftPrediction.status' => 1,
                'GamesGiftPrediction.is_deleted' => 0,
                'GamesGiftPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'GamesGiftPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'GamesGiftPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
                'GamesGiftPrediction.user_id' => AuthComponent::User('id')
            ],
              'fields' => [
                'GamesGiftPrediction.gift_id','GamesGiftPrediction.teams_gameday'
            ],
              'order' => ['GamesGiftPrediction.id' => 'DESC'],
               'limit' => 1,
            
        ]);
       if(!empty( $giftsfootball_id)){
        $gamefootball_id = $this->FootballPrediction->find('list', [
        'conditions' => [
            'FootballPrediction.status' => 1,
            'FootballPrediction.game_day' => $giftsfootball_id['GamesGiftPrediction']['teams_gameday'] ,
            'FootballPrediction.is_deleted' => 0,
            'FootballPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
            'FootballPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
            'FootballPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
            'FootballPrediction.user_id' => AuthComponent::User('id')
        ],
          'fields' => [
            'FootballPrediction.game_id'
        ]
        
    ]);
    }
    if ($this->request->isPost()) {
               $maxnextdays= $this->request->data['postt'];
               $maxdays= $this->request->data['postid']; 
             if((isset($maxdays) && $maxdays=="0") || !empty($maxdays)){
            $maxgameddays=$maxdays-1;   
            }
            if((isset($maxnextdays) && $maxnextdays=="0") || !empty($maxnextdays)){
            $maxgameddays=$maxnextdays+1;
            }
        }
        elseif(!empty($giftsfootball_id) && empty($gamefootball_id))
         {
              $gift_id=$giftsfootball_id['GamesGiftPrediction']['gift_id'];
              $maxgameddays=$giftsfootball_id['GamesGiftPrediction']['teams_gameday'];
         }
        elseif($teamStatus['UserTeam']['status'] == UserTeam::STATUS_ACTIVE)
        {
            $today    = date('Y-m-d');
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id',
                'Tournament.name',
                'Game.teams_gameday' => 'MIN(teams_gameday) as maxday',
            ];
            
            $conditions = [
                'Game.start_time >=' => $today,
                'Game.sport_id'      => AuthComponent::User('sportSession.sport_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status'        => 1,
                'Game.end_time >'    => date('Y-m-d h:i:s')
            ];
            
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            
            $gameDays = $this->Paginator->paginate('Game');
            $max_game_days= $gameDays[0][0]['maxday']; 
            if(!empty($max_game_days)){
                $maxgameddays= $gameDays[0][0]['maxday']; 
            }
            else
            {
              $maxgameddays=1; 
            }
        }
        if ($teamStatus['UserTeam']['status'] == UserTeam::STATUS_ACTIVE)
        {
            $today    = date('Y-m-d');
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id',
                'Tournament.name',
                'Game.teams_gameday'
  
            ];
            
            $conditions = [
                'Game.start_time >=' => $today,
                'Game.sport_id'      => AuthComponent::User('sportSession.sport_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status'        => 1,
                'Game.teams_gameday' => $maxgameddays, 
                'Game.end_time >'    => date('Y-m-d h:i:s')
            ];
          $order = [
                'Game.start_time' => 'ASC', ];
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields,
                'order' =>$order
            ];
            $gameDatas = $this->Paginator->paginate('Game');
        }
        else
        {
            $gameDatas = '';
        }

         $gifts_id = $this->GamesGiftPrediction->find('first', [
            'conditions' => [
                'GamesGiftPrediction.status' => 1,
                'GamesGiftPrediction.teams_gameday' =>$maxgameddays,
                'GamesGiftPrediction.is_deleted' => 0,
                'GamesGiftPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'GamesGiftPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'GamesGiftPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
                'GamesGiftPrediction.user_id' => AuthComponent::User('id')
            ],
              'fields' => [
                'GamesGiftPrediction.gift_id','GamesGiftPrediction.teams_gameday'
            ]  
        ]);
        if(!empty($gifts_id))
         {
            $gift_id=$gifts_id['GamesGiftPrediction']['gift_id'];  
         }
         else
         {
            $gift_id='';
         }
            $game_id = $this->FootballPrediction->find('list', [
            'conditions' => [
                'FootballPrediction.status' => 1,
                'FootballPrediction.game_day' =>$maxgameddays,
                'FootballPrediction.is_deleted' => 0,
                'FootballPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'FootballPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'FootballPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
                'FootballPrediction.user_id' => AuthComponent::User('id')
            ],
              'fields' => [
                'FootballPrediction.game_id'
            ]
            
        ]);
          if(!empty($game_id))
         {
            $game_id=$game_id;
         }
         else
         {
          $game_id='';
         }
         
          $user_id =AuthComponent::User('id');
      // pr($gameDatas);exit;
        $this->set(compact('gameDatas', 'tournament_name','maxgameddays','gift_id','user_id','game_id'));
    }

    /**
     * footballPrediction method
     * save footaball prediction
     *
     * @param null|mixed $gameId
     * @param null|mixed $leagueId
     * @param null|mixed $tournamentId
     * @param null|mixed $sportId
     *
     * @return void
     */
     public function footballPrediction()
    {
        $this->layout = '';
        $this->loadModel('FootballPrediction');
        $this->loadModel('GamesGiftPrediction');
        $this->set(compact('sportId', 'leagueId', 'tournamentId', 'gameId'));

         $tournament_id = AuthComponent::User('sportSession.tournament_id');
         $sport_id=AuthComponent::User('sportSession.sport_id');
         $league_id =AuthComponent::User('sportSession.league_id');
         $user_id =AuthComponent::User('id');
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['FootballPrediction']['type']);
            unset($this->request->data['FootballPrediction']['location_id']);
            unset($this->request->data['FootballPrediction']['gift_category_id']);
       
            $datas=$this->request->data['FootballPrediction'];
         

            
            if ($this->FootballPrediction->saveMany($datas))
            { 

                $this->Flash->success(__('Prediction has been saved.'));
                return $this->redirect([
                    'controller' => 'games',
                    'action' => 'footballScheduling'
                ]);
               
            }
            else
            {
        //}
            $this->Flash->error(__('Prediction could not be saved. Please, try again.','error'));

        }
        }
    }

    /**
     * findSoccerPrediction method
     *
     * @param null|mixed $gameId
     * @param null|mixed $firstTeam
     * @param null|mixed $secondTeam
     *
     * @return void
     */
    public function findSoccerPrediction($gameDay = null)
    {
        $this->layout = '';
        $userId = $this->Session->read('Auth.User.id');
      /*  $this->Game->unbindModel([
            'hasMany' => [
                'Team'
            ]
        ]);*/
        
        $this->loadModel('SoccerPrediction');
        $this->loadModel('UserTeam');
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        $this->loadModel('Game');
        $gameDay = base64_decode($gameDay);
       

            $dataExists= $this->SoccerPrediction->find('all', array(
            'fields' => array('SoccerPrediction.game_id','SoccerPrediction.first_team_goals','SoccerPrediction.second_team_goals','file.first_team','file.second_team','team.name','secondteam.name'),
            'joins' => array(
                array(
                        'table' => 'games',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('SoccerPrediction.game_id = file.id')
                    ),
                array(
                        'table' => 'teams',
                        'alias' => 'team',
                        'type' => 'right',
                        'conditions' => array('file.first_team =team.id')
                    ),
                array(
                        'table' => 'teams',
                        'alias' => 'secondteam',
                        'type' => 'right',
                        'conditions' => array('file.second_team =secondteam.id')
                    ),
                ),
             'conditions'=>array('SoccerPrediction.game_day' => $gameDay,'SoccerPrediction.user_id' => $userId, 'SoccerPrediction.is_deleted' => 0)
               
            )
        );
         // echo '<pre>'; print_r($dataExists);exit;
        $this->set(compact('dataExists'));
    }

    /**
     * soccerScheduling method
     *
     * @todo dynamic scheduling using user details
     *
     * @return void
     */

  

    

      public function soccerScheduling()
    { 
        
        
      /*  $this->_checkSportSession();
        $this->Game->unbindModel([
            'hasMany' => [
                'Team'
            ]
        ]);
        
        $this->loadModel('SoccerPrediction');
        $this->loadModel('UserTeam');
        $this->loadModel('Tournament');
        
        $this->set('title_for_layout', __('Soccer Scheduling'));
        
        // The team selected by the user
        $team_id = $this->Auth->Session->read('Auth.User.sportSession.team_id');
        $user_id = AuthComponent::User('id');
        
        $current_tournament = $this->Tournament->find('first', [
            'conditions' => [
                'Tournament.id ' => AuthComponent::User('sportSession.tournament_id'),

            ],
            'fields' => [
                'Tournament.name'
            ],
        ]);
        
        $tournament_name = NULL;
        if(!empty($current_tournament))
        {
            $tournament_name = $current_tournament['Tournament']['name'];
        }
        
        // Select only the first team from the user which are active and with the team selected
        $teamStatus = $this->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.status' => UserTeam::STATUS_ACTIVE,
                'UserTeam.team_id' => $team_id,
                'UserTeam.user_id' => $user_id,

            ],
            'fields' => [
                'UserTeam.status'
            ],
        ]);
  
        // Double check of status active
        if ($this->request->isPost()) {
               $maxnextdays= $this->request->data['postt'];
               $maxdays= $this->request->data['postid']; 
             if((isset($maxdays) && $maxdays=="0") || !empty($maxdays)){
            $maxgameddays=$maxdays-1;   
            }
            if((isset($maxnextdays) && $maxnextdays=="0") || !empty($maxnextdays)){
            $maxgameddays=$maxnextdays+1;
            }
        }
        elseif ($teamStatus['UserTeam']['status'] == UserTeam::STATUS_ACTIVE)
        {
            $today    = date('Y-m-d');
           // $max_days = date('Y-m-d', strtotime('+11 days'));
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id',
                'Tournament.name',
                'Game.teams_gameday' => 'MIN(teams_gameday) as maxday',
    // ...
  
           // print_r($max_weekday);exit;

            ];
            
            $conditions = [
                'Game.start_time >=' => $today,
               // 'Game.start_time <=' => $max_days,
                'Game.sport_id'      => AuthComponent::User('sportSession.sport_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status'        => 1,

              //  'Game.teams_gameday' => 
               // 'Game.teams_gameday' => 2, 
                'Game.end_time >'    => date('Y-m-d h:i:s')
            ];
            
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            
            $gameDays = $this->Paginator->paginate('Game');
            $maxgameddays= $gameDays[0][0]['maxday']; //exit;

           // echo '<pre>';print_r($gameDays);exit;
           //exit;
        }

        // Double check of status active
        if ($teamStatus['UserTeam']['status'] == UserTeam::STATUS_ACTIVE)
        {
            $today    = date('Y-m-d');

          //  $max_days = date('Y-m-d', strtotime('+11 days'));
        
            
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id',
                'Tournament.name',
                //'Game.teams_gameday' => 'MAX(teams_gameday)',
    // ...
  
           // print_r($max_weekday);exit;

            ];
            
            $conditions = [
                'Game.start_time >=' => $today,
              //  'Game.start_time <=' => $max_days,
                'Game.sport_id'      => AuthComponent::User('sportSession.sport_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status'        => 1,

              //  'Game.teams_gameday' => 
                'Game.teams_gameday' => $maxgameddays, 
                'Game.end_time >'    => date('Y-m-d h:i:s')
            ];
            
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            
            $gameDatas = $this->Paginator->paginate('Game');
         
            //print_r($gameDatas);exit;
            // $gameDatas = $this->Game->find('all', array('conditions' => $conditions, 'fields' => $fields));
        }
        else
        {
            $gameDatas = '';
        }
        
        $this->set(compact('gameDatas', 'tournament_name','maxgameddays'));*/
      
        $this->_checkSportSession();
        $this->Game->unbindModel([
            'hasMany' => [
                'Team'
            ]
        ]);
        
        $this->loadModel('SoccerPrediction');
        $this->loadModel('UserTeam');
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        
        $this->set('title_for_layout', __('Soccer Scheduling'));
        
        // The team selected by the user
        $team_id = $this->Auth->Session->read('Auth.User.sportSession.team_id');
        $user_id = AuthComponent::User('id');
        
        $current_tournament = $this->Tournament->find('first', [
            'conditions' => [
                'Tournament.id ' => AuthComponent::User('sportSession.tournament_id'),

            ],
            'fields' => [
                'Tournament.name'
            ],
        ]);
        
        $tournament_name = NULL;
        if(!empty($current_tournament))
        {
            $tournament_name = $current_tournament['Tournament']['name'];
        }
        $teamStatus = $this->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.status' => UserTeam::STATUS_ACTIVE,
                'UserTeam.team_id' => $team_id,
                'UserTeam.user_id' => $user_id,

            ],
            'fields' => [
                'UserTeam.status'
            ],
        ]);

           $giftssoccer_id = $this->GamesGiftPrediction->find('first', [
            'conditions' => [
                'GamesGiftPrediction.status' => 1,
                'GamesGiftPrediction.is_deleted' => 0,
                'GamesGiftPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'GamesGiftPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'GamesGiftPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
                'GamesGiftPrediction.user_id' => AuthComponent::User('id')
            ],
              'fields' => [
                'GamesGiftPrediction.gift_id','GamesGiftPrediction.teams_gameday'
            ],
              'order' => ['GamesGiftPrediction.id' => 'DESC'],
               'limit' => 1,
            
        ]);
       if(!empty( $giftssoccer_id)){
        $gamesoccer_id = $this->SoccerPrediction->find('list', [
        'conditions' => [
            'SoccerPrediction.status' => 1,
            'SoccerPrediction.game_day' => $giftssoccer_id['GamesGiftPrediction']['teams_gameday'] ,
            'SoccerPrediction.is_deleted' => 0,
            'SoccerPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
            'SoccerPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
            'SoccerPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
            'SoccerPrediction.user_id' => AuthComponent::User('id')
        ],
          'fields' => [
            'SoccerPrediction.game_id'
        ]
        
    ]);
    } // Double check of status active
       if ($this->request->isPost()) {
               $maxnextdays= $this->request->data['postt'];
               $maxdays= $this->request->data['postid']; 
             if((isset($maxdays) && $maxdays=="0") || !empty($maxdays)){
            $maxgameddays=$maxdays-1;   
            }
            if((isset($maxnextdays) && $maxnextdays=="0") || !empty($maxnextdays)){
            $maxgameddays=$maxnextdays+1;
            }
        }
        elseif(!empty($giftssoccer_id) && empty($gamesoccer_id))
         {
              $gift_id=$giftssoccer_id['GamesGiftPrediction']['gift_id'];
              $maxgameddays=$giftssoccer_id['GamesGiftPrediction']['teams_gameday'];
         }
        elseif($teamStatus['UserTeam']['status'] == UserTeam::STATUS_ACTIVE)
        {
            $today    = date('Y-m-d');
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id',
                'Tournament.name',
                'Game.teams_gameday' => 'MIN(teams_gameday) as maxday',
            ];
            
            $conditions = [
                'Game.start_time >=' => $today,
                'Game.sport_id'      => AuthComponent::User('sportSession.sport_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status'        => 1,
                'Game.end_time >'    => date('Y-m-d h:i:s')
            ];
            
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            
            $gameDays = $this->Paginator->paginate('Game');
             $max_game_days= $gameDays[0][0]['maxday']; 
            if(!empty($max_game_days)){
                $maxgameddays= $gameDays[0][0]['maxday']; 
            }
            else
            {
              $maxgameddays=1; 
            }//exit;
        }
        // Double check of status active
        if ($teamStatus['UserTeam']['status'] == UserTeam::STATUS_ACTIVE)
        {
            $today    = date('Y-m-d');
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id',
                'Tournament.name',
                'Game.teams_gameday'
  
            ];
            
            $conditions = [
                'Game.start_time >=' => $today,
                'Game.sport_id'      => AuthComponent::User('sportSession.sport_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status'        => 1,
                'Game.teams_gameday' => $maxgameddays, 
                'Game.end_time >'    => date('Y-m-d h:i:s')
            ];
          $order = [
                'Game.start_time' => 'ASC', ];
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields,
                'order' =>$order
            ];
            $gameDatas = $this->Paginator->paginate('Game');
        }
        else
        {
            $gameDatas = '';
        }

         $gifts_id = $this->GamesGiftPrediction->find('first', [
            'conditions' => [
                'GamesGiftPrediction.status' => 1,
                'GamesGiftPrediction.teams_gameday' =>$maxgameddays,
                'GamesGiftPrediction.is_deleted' => 0,
                'GamesGiftPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'GamesGiftPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'GamesGiftPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
                'GamesGiftPrediction.user_id' => AuthComponent::User('id')
            ],
              'fields' => [
                'GamesGiftPrediction.gift_id','GamesGiftPrediction.teams_gameday'
            ]  
        ]);
        if(!empty($gifts_id))
         {
            $gift_id=$gifts_id['GamesGiftPrediction']['gift_id'];  
         }
         else
         {
            $gift_id='';
         }
            $game_id = $this->SoccerPrediction->find('list', [
            'conditions' => [
                'SoccerPrediction.status' => 1,
                'SoccerPrediction.game_day' =>$maxgameddays,
                'SoccerPrediction.is_deleted' => 0,
                'SoccerPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'SoccerPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'SoccerPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
                'SoccerPrediction.user_id' => AuthComponent::User('id')
            ],
              'fields' => [
                'SoccerPrediction.game_id'
            ]
            
        ]);
          if(!empty($game_id))
         {
            $game_id=$game_id;
         }
         else
         {
          $game_id='';
         }
         
          $user_id =AuthComponent::User('id');
        
        $this->set(compact('gameDatas', 'tournament_name','maxgameddays','gift_id','user_id','game_id'));
    }


    

   
    /**
     * soccerPrediction method
     * save footaball prediction
     *
     * @param null|mixed $gameId
     * @param null|mixed $leagueId
     * @param null|mixed $tournamentId
     * @param null|mixed $sportId
     *
     * @return void
     */
     public function GamesGiftsPrediction($leagueId = null, $tournamentId = null, $sportId = null, $gameDay =null,$controllerName =null)
    {
        $this->layout = '';
        $this->loadModel('GamesGiftPrediction');
        
        $this->set(compact('sportId', 'leagueId', 'tournamentId','gameDay','controllerName'));
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            //echo 'ok';
            unset($this->request->data['GamesGiftPrediction']['type']);
            unset($this->request->data['GamesGiftPrediction']['location_id']);
            unset($this->request->data['GamesGiftPrediction']['gift_category_id']);
             //pr($this->request->data); die;
            $this->request->data['GamesGiftPrediction']['user_id'] = AuthComponent::User('id');
           
             if ($this->GamesGiftPrediction->save($this->request->data))
            {
                $this->GamesGiftPrediction->saveField('is_deleted', 0);
                $this->GamesGiftPrediction->saveField('status', 1);

                // pr($this->request->data);exit;
                //$this->Flash->success(__('Prediction has been saved.'));
                return $this->redirect([
                    'controller' => 'games',
                    'action' => $this->request->data['GamesGiftPrediction']['controller']
                ]);
            }
            $this->Flash->error(__('Prediction could not be saved. Please, try again.'));
        }
    }
      public function soccerPrediction()
    {
        $this->layout = '';
        $this->loadModel('SoccerPrediction');
        $this->loadModel('GamesGiftPrediction');
        $this->set(compact('sportId', 'leagueId', 'tournamentId', 'gameId'));

         $tournament_id = AuthComponent::User('sportSession.tournament_id');
         $sport_id=AuthComponent::User('sportSession.sport_id');
         $league_id =AuthComponent::User('sportSession.league_id');
         $user_id =AuthComponent::User('id');
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['SoccerPrediction']['type']);
            unset($this->request->data['SoccerPrediction']['location_id']);
            unset($this->request->data['SoccerPrediction']['gift_category_id']);
       
            $datas=$this->request->data['SoccerPrediction'];
         

            
            if ($this->SoccerPrediction->saveMany($datas))
            { 

                $this->Flash->success(__('Prediction has been saved.'));
                return $this->redirect([
                    'controller' => 'games',
                    'action' => 'soccerScheduling'
                ]);
               
            }
            else
            {
        //}
            $this->Flash->error(__('Prediction could not be saved. Please, try again.','error'));

        }
        }
    }

    /**
     * findFootballPrediction method
     *
     * @param null|mixed $gameId
     * @param null|mixed $firstTeam
     * @param null|mixed $secondTeam
     *
     * @return void
     */
    public function findFootballPrediction($gameDay = null)
    {
        $this->layout = '';
        $userId = $this->Session->read('Auth.User.id');
        $this->loadModel('FootballPrediction');
        $this->loadModel('UserTeam');
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        $this->loadModel('Game');
        $gameDay = base64_decode($gameDay);
        $dataExists= $this->FootballPrediction->find('all', array(
            'fields' => array('FootballPrediction.game_id','FootballPrediction.first_team_goals','FootballPrediction.second_team_goals','file.first_team','file.second_team','team.name','secondteam.name'),
            'joins' => array(
                array(
                        'table' => 'games',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('FootballPrediction.game_id = file.id')
                    ),
                array(
                        'table' => 'teams',
                        'alias' => 'team',
                        'type' => 'right',
                        'conditions' => array('file.first_team =team.id')
                    ),
                array(
                        'table' => 'teams',
                        'alias' => 'secondteam',
                        'type' => 'right',
                        'conditions' => array('file.second_team =secondteam.id')
                    ),
                ),
             'conditions'=>array('FootballPrediction.game_day' => $gameDay,'FootballPrediction.user_id' => $userId, 'FootballPrediction.is_deleted' => 0)
               
            )
        );
       //  echo '<pre>'; print_r($dataExists);exit;
        $this->set(compact('dataExists'));
    }
    /**
     * hockeyScheduling method
     *
     * @todo dynamic scheduling using user details
     *
     * @return void
     */
     public function hockeyScheduling()
    {
        $this->_checkSportSession();
        $this->Game->unbindModel([
            'hasMany' => [
                'Team'
            ]
        ]);
        $this->loadModel('HockeyPrediction');
        $this->set('title_for_layout', __('Hockey Scheduling'));
           $this->loadModel('UserTeam');
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        
        $team_id = $this->Auth->Session->read('Auth.User.sportSession.team_id');
        $user_id = AuthComponent::User('id');
        
        $current_tournament = $this->Tournament->find('first', [
            'conditions' => [
                'Tournament.id ' => AuthComponent::User('sportSession.tournament_id'),

            ],
            'fields' => [
                'Tournament.name'
            ],
        ]);
        
        $tournament_name = NULL;
        if(!empty($current_tournament))
        {
            $tournament_name = $current_tournament['Tournament']['name'];
        }
        
        // Select only the first team from the user which are active and with the team selected
        $teamStatus = $this->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.status' => UserTeam::STATUS_ACTIVE,
                'UserTeam.team_id' => $team_id,
                'UserTeam.user_id' => $user_id,

            ],
            'fields' => [
                'UserTeam.status'
            ],
        ]);

           $giftshockey_id = $this->GamesGiftPrediction->find('first', [
            'conditions' => [
                'GamesGiftPrediction.status' => 1,
                'GamesGiftPrediction.is_deleted' => 0,
                'GamesGiftPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'GamesGiftPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'GamesGiftPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
                'GamesGiftPrediction.user_id' => AuthComponent::User('id')
            ],
              'fields' => [
                'GamesGiftPrediction.gift_id','GamesGiftPrediction.teams_gameday'
            ],
              'order' => ['GamesGiftPrediction.id' => 'DESC'],
               'limit' => 1,
            
        ]);
         //$gift_id=$gift_id['GamesGiftPrediction']['gift_id'];
       // print_r($gifts_id) ;exit;
       if(!empty( $giftshockey_id)){
        $gamehockey_id = $this->HockeyPrediction->find('list', [
        'conditions' => [
            'HockeyPrediction.status' => 1,
            'HockeyPrediction.game_day' => $giftshockey_id['GamesGiftPrediction']['teams_gameday'] ,
            'HockeyPrediction.is_deleted' => 0,
            'HockeyPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
            'HockeyPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
            'HockeyPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
            'HockeyPrediction.user_id' => AuthComponent::User('id')
        ],
          'fields' => [
            'HockeyPrediction.game_id'
        ]
        
    ]);
    }
       
        // Double check of status active
       if ($this->request->isPost()) {
               $maxnextdays= $this->request->data['postt'];
               $maxdays= $this->request->data['postid']; 
             if((isset($maxdays) && $maxdays=="0") || !empty($maxdays)){
            $maxgameddays=$maxdays-1;   
            }
            if((isset($maxnextdays) && $maxnextdays=="0") || !empty($maxnextdays)){
            $maxgameddays=$maxnextdays+1;
            }
        }
        elseif(!empty($giftshockey_id) && empty($gamehockey_id))
         {
              $gift_id=$giftshockey_id['GamesGiftPrediction']['gift_id'];
              $maxgameddays=$giftshockey_id['GamesGiftPrediction']['teams_gameday'];
         }
        elseif($teamStatus['UserTeam']['status'] == UserTeam::STATUS_ACTIVE)
        {
            $today    = date('Y-m-d');
           // $max_days = date('Y-m-d', strtotime('+11 days'));
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id',
                'Tournament.name',
                'Game.teams_gameday' => 'MIN(teams_gameday) as maxday',
    // ...
  
           // print_r($max_weekday);exit;

            ];
            
            $conditions = [
                'Game.start_time >=' => $today,
               // 'Game.start_time <=' => $max_days,
                'Game.sport_id'      => AuthComponent::User('sportSession.sport_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status'        => 1,

              //  'Game.teams_gameday' => 
               // 'Game.teams_gameday' => 2, 
                'Game.end_time >'    => date('Y-m-d h:i:s')
            ];
            
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            
            $gameDays = $this->Paginator->paginate('Game');
             $max_game_days= $gameDays[0][0]['maxday']; 
            if(!empty($max_game_days)){
                $maxgameddays= $gameDays[0][0]['maxday']; 
            }
            else
            {
              $maxgameddays=1; 
            }//exit;

           // echo '<pre>';print_r($gameDays);exit;
           //exit;
        }
        
      
       
        // Double check of status active
        if ($teamStatus['UserTeam']['status'] == UserTeam::STATUS_ACTIVE)
        {
            $today    = date('Y-m-d');

          //  $max_days = date('Y-m-d', strtotime('+11 days'));
        
            
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id',
                'Tournament.name',
                'Game.teams_gameday'
    // ...
  
           // print_r($max_weekday);exit;

            ];
            
            $conditions = [
                'Game.start_time >=' => $today,
              //  'Game.start_time <=' => $max_days,
                'Game.sport_id'      => AuthComponent::User('sportSession.sport_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status'        => 1,

              //  'Game.teams_gameday' => 
                'Game.teams_gameday' => $maxgameddays, 
                'Game.end_time >'    => date('Y-m-d h:i:s')
            ];
          $order = [
                'Game.start_time' => 'ASC',
              //  'Game.start_time <=' => $max_days,
              
            ];
          
            
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields,
                'order' =>$order
            ];
            
            $gameDatas = $this->Paginator->paginate('Game');
         
            //print_r($gameDatas);exit;
            // $gameDatas = $this->Game->find('all', array('conditions' => $conditions, 'fields' => $fields));
        }
        else
        {
            $gameDatas = '';
        }

         $gifts_id = $this->GamesGiftPrediction->find('first', [
            'conditions' => [
                'GamesGiftPrediction.status' => 1,
                'GamesGiftPrediction.teams_gameday' =>$maxgameddays,
                'GamesGiftPrediction.is_deleted' => 0,
                'GamesGiftPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'GamesGiftPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'GamesGiftPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
                'GamesGiftPrediction.user_id' => AuthComponent::User('id')
            ],
              'fields' => [
                'GamesGiftPrediction.gift_id','GamesGiftPrediction.teams_gameday'
            ]
            
        ]);
         //$gift_id=$gift_id['GamesGiftPrediction']['gift_id'];
            //print_r($gifts_id) ;exit;
        if(!empty($gifts_id))
         {
            $gift_id=$gifts_id['GamesGiftPrediction']['gift_id'];
           // $maxgameddays=$gifts_id['GamesGiftPrediction']['teams_gameday'];
             
         }
         else
         {
            $gift_id='';
         }

            $game_id = $this->HockeyPrediction->find('list', [
            'conditions' => [
                'HockeyPrediction.status' => 1,
                'HockeyPrediction.game_day' =>$maxgameddays,
                'HockeyPrediction.is_deleted' => 0,
                'HockeyPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'HockeyPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'HockeyPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
                'HockeyPrediction.user_id' => AuthComponent::User('id')
            ],
              'fields' => [
                'HockeyPrediction.game_id'
            ]
            
        ]);
         // print_r($game_id);
         if(!empty($game_id))
         {
            $game_id=$game_id;
         }
         else
         {
          $game_id='';
         }
         
          $user_id =AuthComponent::User('id');
       // pr($gameDatas);exit;
        $this->set(compact('gameDatas', 'tournament_name','maxgameddays','gift_id','user_id','game_id'));
    }

    /**
     * hockeyPrediction method
     * save footaball prediction
     *
     * @param null|mixed $gameId
     * @param null|mixed $leagueId
     * @param null|mixed $tournamentId
     * @param null|mixed $sportId
     *
     * @return void
     */
     public function hockeyPrediction()
    {
        
        $this->layout = '';
        $this->loadModel('HockeyPrediction');
        $this->loadModel('GamesGiftPrediction');
        $this->set(compact('sportId', 'leagueId', 'tournamentId', 'gameId'));

         $tournament_id = AuthComponent::User('sportSession.tournament_id');
         $sport_id=AuthComponent::User('sportSession.sport_id');
         $league_id =AuthComponent::User('sportSession.league_id');
         $user_id =AuthComponent::User('id');
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['HockeyPrediction']['type']);
            unset($this->request->data['HockeyPrediction']['location_id']);
            unset($this->request->data['HockeyPrediction']['gift_category_id']);
      
            $datas=$this->request->data['HockeyPrediction'];        
            if ($this->HockeyPrediction->saveMany($datas))
            { 
                $this->Flash->success(__('Prediction has been saved.'));
                return $this->redirect([
                    'controller' => 'games',
                    'action' => 'hockeyScheduling'
                ]);
               
            }
            else
            {
       
            $this->Flash->error(__('Prediction could not be saved. Please, try again.','error'));

        }
        }
    }

    /**
     * findHockeyPrediction method
     *
     * @param null|mixed $gameId
     * @param null|mixed $firstTeam
     * @param null|mixed $secondTeam
     *
     * @return void
     */
   public function findHockeyPrediction($gameDay = null)
    {
        $this->layout = '';
        $userId = $this->Session->read('Auth.User.id');
        $this->loadModel('HockeyPrediction');
        $userId = $this->Session->read('Auth.User.id');
        $this->loadModel('UserTeam');
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        $this->loadModel('Game');
        $gameDay = base64_decode($gameDay);
        $dataExists= $this->HockeyPrediction->find('all', array(
            'fields' => array('HockeyPrediction.game_id','HockeyPrediction.first_team_goals','HockeyPrediction.second_team_goals','file.first_team','file.second_team','team.name','secondteam.name'),
            'joins' => array(
                array(
                        'table' => 'games',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('HockeyPrediction.game_id = file.id')
                    ),
                array(
                        'table' => 'teams',
                        'alias' => 'team',
                        'type' => 'right',
                        'conditions' => array('file.first_team =team.id')
                    ),
                array(
                        'table' => 'teams',
                        'alias' => 'secondteam',
                        'type' => 'right',
                        'conditions' => array('file.second_team =secondteam.id')
                    ),
                ),
             'conditions'=>array('HockeyPrediction.game_day' => $gameDay,'HockeyPrediction.user_id' => $userId, 'HockeyPrediction.is_deleted' => 0)
               
            )
        );
        // echo '<pre>'; print_r($dataExists);exit;
        $this->set(compact('dataExists'));
    }

    /**
     * basketballScheduling method
     *
     * @todo dynamic scheduling using user details
     *
     * @return void
     */
    public function basketballScheduling()
    {
        $this->_checkSportSession();
        $this->Game->unbindModel([
            'hasMany' => [
                'Team'
            ]
        ]);
        $this->loadModel('BasketballPrediction');
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        $this->loadModel('UserTeam');
        $this->set('title_for_layout', __('Basketball Scheduling'));
        
       $team_id = $this->Auth->Session->read('Auth.User.sportSession.team_id');
         $user_id = AuthComponent::User('id');
        $current_tournament = $this->Tournament->find('first', [
            'conditions' => [
                'Tournament.id ' => AuthComponent::User('sportSession.tournament_id'),

            ],
            'fields' => [
                'Tournament.name'
            ],
        ]);
        
        $tournament_name = NULL;
     if(!empty($current_tournament))
        {
            $tournament_name = $current_tournament['Tournament']['name'];
        }
        $teamStatus = $this->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.status' => UserTeam::STATUS_ACTIVE,
                'UserTeam.team_id' => $team_id,
                'UserTeam.user_id' => $user_id,

            ],
            'fields' => [
                'UserTeam.status'
            ],
        ]);

           $giftsbasketball_id = $this->GamesGiftPrediction->find('first', [
            'conditions' => [
                'GamesGiftPrediction.status' => 1,
                'GamesGiftPrediction.is_deleted' => 0,
                'GamesGiftPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'GamesGiftPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'GamesGiftPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
                'GamesGiftPrediction.user_id' => AuthComponent::User('id')
            ],
              'fields' => [
                'GamesGiftPrediction.gift_id','GamesGiftPrediction.teams_gameday'
            ],
              'order' => ['GamesGiftPrediction.id' => 'DESC'],
               'limit' => 1,
            
        ]);
       if(!empty( $giftsbasketball_id)){
        $gamebasketball_id = $this->BasketballPrediction->find('list', [
        'conditions' => [
            'BasketballPrediction.status' => 1,
            'BasketballPrediction.game_day' => $giftsbasketball_id['GamesGiftPrediction']['teams_gameday'] ,
            'BasketballPrediction.is_deleted' => 0,
            'BasketballPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
            'BasketballPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
            'BasketballPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
            'BasketballPrediction.user_id' => AuthComponent::User('id')
        ],
          'fields' => [
            'BasketballPrediction.game_id'
        ]
        
    ]);
    } // Double check of status active
       if ($this->request->isPost()) {
               $maxnextdays= $this->request->data['postt'];
               $maxdays= $this->request->data['postid']; 
             if((isset($maxdays) && $maxdays=="0") || !empty($maxdays)){
            $maxgameddays=$maxdays-1;   
            }
            if((isset($maxnextdays) && $maxnextdays=="0") || !empty($maxnextdays)){
            $maxgameddays=$maxnextdays+1;
            }
        }
        elseif(!empty($giftsbasketball_id) && empty($gamebasketball_id))
         {
              $gift_id=$giftsbasketball_id['GamesGiftPrediction']['gift_id'];
              $maxgameddays=$giftsbasketball_id['GamesGiftPrediction']['teams_gameday'];
         }
        elseif($teamStatus['UserTeam']['status'] == UserTeam::STATUS_ACTIVE)
        {
            $today    = date('Y-m-d');
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id',
                'Tournament.name',
                'Game.teams_gameday' => 'MIN(teams_gameday) as maxday',
            ];
            
            $conditions = [
                'Game.start_time >=' => $today,
                'Game.sport_id'      => AuthComponent::User('sportSession.sport_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status'        => 1,
                'Game.end_time >'    => date('Y-m-d h:i:s')
            ];
            
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            
            $gameDays = $this->Paginator->paginate('Game');
            //$maxgameddays= $gameDays[0][0]['maxday']; 
             $max_game_days= $gameDays[0][0]['maxday']; 
            if(!empty($max_game_days)){
                $maxgameddays= $gameDays[0][0]['maxday']; 
            }
            else
            {
              $maxgameddays=1; 
            }//exit;
        }
        // Double check of status active
        if ($teamStatus['UserTeam']['status'] == UserTeam::STATUS_ACTIVE)
        {
            $today    = date('Y-m-d');
            $fields = [
                'First_team.id',
                'First_team.name',
                'Second_team.id',
                'Second_team.name',
                'Game.start_time',
                'Game.end_time',
                'Game.id',
                'Sport.id',
                'League.id',
                'Tournament.id',
                'Tournament.name',
                'Game.teams_gameday'
  
            ];
            
            $conditions = [
                'Game.start_time >=' => $today,
                'Game.sport_id'      => AuthComponent::User('sportSession.sport_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status'        => 1,
                'Game.teams_gameday' => $maxgameddays, 
                'Game.end_time >'    => date('Y-m-d h:i:s')
            ];
          $order = [
                'Game.start_time' => 'ASC', ];
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields,
                'order' =>$order
            ];
            $gameDatas = $this->Paginator->paginate('Game');
        }
        else
        {
            $gameDatas = '';
        }

         $gifts_id = $this->GamesGiftPrediction->find('first', [
            'conditions' => [
                'GamesGiftPrediction.status' => 1,
                'GamesGiftPrediction.teams_gameday' =>$maxgameddays,
                'GamesGiftPrediction.is_deleted' => 0,
                'GamesGiftPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'GamesGiftPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'GamesGiftPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
                'GamesGiftPrediction.user_id' => AuthComponent::User('id')
            ],
              'fields' => [
                'GamesGiftPrediction.gift_id','GamesGiftPrediction.teams_gameday'
            ]  
        ]);
        if(!empty($gifts_id))
         {
            $gift_id=$gifts_id['GamesGiftPrediction']['gift_id'];  
         }
         else
         {
            $gift_id='';
         }
            $game_id = $this->BasketballPrediction->find('list', [
            'conditions' => [
                'BasketballPrediction.status' => 1,
                'BasketballPrediction.game_day' =>$maxgameddays,
                'BasketballPrediction.is_deleted' => 0,
                'BasketballPrediction.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'BasketballPrediction.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'BasketballPrediction.league_id' => AuthComponent::User('sportSession.league_id'),
                'BasketballPrediction.user_id' => AuthComponent::User('id')
            ],
              'fields' => [
                'BasketballPrediction.game_id'
            ]
            
        ]);
          if(!empty($game_id))
         {
            $game_id=$game_id;
         }
         else
         {
          $game_id='';
         }
         
          $user_id =AuthComponent::User('id');
       
        $this->set(compact('gameDatas', 'tournament_name','maxgameddays','gift_id','user_id','game_id'));
    }






    /**
     * basketballPrediction method
     * save footaball prediction
     *
     * @param null|mixed $gameId
     * @param null|mixed $leagueId
     * @param null|mixed $tournamentId
     * @param null|mixed $sportId
     *
     * @return void
     */
    public function basketballPrediction()
    {
          $this->layout = '';
        $this->loadModel('BasketballPrediction');
        $this->loadModel('GamesGiftPrediction');
        $this->set(compact('sportId', 'leagueId', 'tournamentId', 'gameId'));

         $tournament_id = AuthComponent::User('sportSession.tournament_id');
         $sport_id=AuthComponent::User('sportSession.sport_id');
         $league_id =AuthComponent::User('sportSession.league_id');
         $user_id =AuthComponent::User('id');
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['BasketballPrediction']['type']);
            unset($this->request->data['BasketballPrediction']['location_id']);
            unset($this->request->data['BasketballPrediction']['gift_category_id']);
       
            $datas=$this->request->data['BasketballPrediction'];
         

            
            if ($this->BasketballPrediction->saveMany($datas))
            { 

                $this->Flash->success(__('Prediction has been saved.'));
                return $this->redirect([
                    'controller' => 'games',
                    'action' => 'basketballScheduling'
                ]);
               
            }
            else
            {
        //}
            $this->Flash->error(__('Prediction could not be saved. Please, try again.','error'));

        }
        }
    }
    public function admin_basketballPredictions()
    {


        $this->set('title_for_layout', 'Basketball Prediction');
        $this->loadModel('Gift');
         $this->loadModel('GamesGiftPrediction');
          $this->loadModel('GamesResult');
          $this->loadModel('BasketballPrediction');
         $conditions = [];
         //$conditions = $this->_getGamesSearchConditions('GamesGiftPrediction');
         $condition = $this->_getGamesSearchConditions('Game');
         //$conditions = $this->_getGamesSearchConditions('SoccerPrediction');
         /*$this->paginate =  array('fields' => array('GamesGiftPrediction.user_id','GamesGiftPrediction.teams_gameday','Gifts.winning_no_game'),
            'joins' => array(
                array(
                        'table' => 'gifts',
                        'alias' => 'Gifts',
                        'type' => 'inner',
                        'conditions' => array('GamesGiftPrediction.gift_id = Gifts.id',
                            'Gifts.sport_id' => array('GamesGiftPrediction.sport_id',0),
                           
                            ' Gifts.tournament_id' => array(
                                'GamesGiftPrediction.tournament_id',0),
                          
                         ' Gifts.league_id' => array('GamesGiftPrediction.league_id',0)
                         ),
                             
                    ),
               
                ),
             'conditions'=>array('GamesGiftPrediction.is_deleted=0','GamesGiftPrediction.status=1'),
             'order'=>'GamesGiftPrediction.teams_gameday', 
             'limit' => 10,

               
            
        );
            $basketballpredictionswinner = $this->Paginator->paginate('GamesGiftPrediction',$conditions);*/
            $basketballpredictionswinner=$this->GamesGiftPrediction->query("SELECT `GamesGiftPrediction`.`user_id`,`GamesGiftPrediction`.`sport_id`,`GamesGiftPrediction`.`tournament_id`,`GamesGiftPrediction`.`league_id`, `GamesGiftPrediction`.`teams_gameday`, `Gifts`.`winning_no_game`,`Gifts`.`id` FROM .`gamesgiftprediction` AS `GamesGiftPrediction` LEFT JOIN .`users` AS `User` ON (`GamesGiftPrediction`.`user_id` = `User`.`id`) LEFT JOIN .`tournaments` AS `Tournament` ON (`GamesGiftPrediction`.`tournament_id` = `Tournament`.`id`) LEFT JOIN .`sports` AS `Sport` ON (`GamesGiftPrediction`.`sport_id` = `Sport`.`id`) LEFT JOIN .`leagues` AS `League` ON (`GamesGiftPrediction`.`league_id` = `League`.`id`) inner JOIN .`gifts` AS `Gifts` ON (`GamesGiftPrediction`.`gift_id` = `Gifts`.`id` AND ((`GamesGiftPrediction`.`sport_id` = `Gifts`.`sport_id`) OR (`Gifts`.`sport_id`=0)) AND ((`GamesGiftPrediction`.`tournament_id` = `Gifts`.`tournament_id`) OR (`Gifts`.`tournament_id`=0)) AND ((`GamesGiftPrediction`.`league_id` =`Gifts`.`league_id`) OR (`Gifts`.`league_id`=0))) WHERE `GamesGiftPrediction`.`is_deleted`=0 AND `GamesGiftPrediction`.`status`=1   " );  
      
    //pr($basketballpredictionswinner);exit;
       $basketballpredictionswinnerlist_array=array();   
        $basketballpredictionswinnerdata_array=array();        
        $i=0;
        if(!empty($basketballpredictionswinner)){
           
       while($i<count($basketballpredictionswinner))
       {  
            $userid= $basketballpredictionswinner[$i]['GamesGiftPrediction']['user_id'];
            $gameday= $basketballpredictionswinner[$i]['GamesGiftPrediction']['teams_gameday'];
            $sport_id=$basketballpredictionswinner[$i]['GamesGiftPrediction']['sport_id'];
             $tornament_id=$basketballpredictionswinner[$i]['GamesGiftPrediction']['tournament_id'];
             $league_id=$basketballpredictionswinner[$i]['GamesGiftPrediction']['league_id'];
         
           
           /*  $basketballpredictionswinnerdata_array[] = $this->BasketballPrediction->find('all', [
            'fields' => [
                'BasketballPrediction.game_day',
                'User.id',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name', 
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ],
             'group' =>['User.name'],
            'order' =>['User.name'=> 'ASC'],
            'conditions' => [
                'User.id' => $userid,
                'BasketballPrediction.game_day' => $gameday,'BasketballPrediction.sport_id' => $sport_id,
                   'BasketballPrediction.league_id' => $league_id,
                   'BasketballPrediction.tournament_id' => $tornament_id
            ]

        ]);
        */
         $fields = [
                
                'BasketballPrediction.game_day',
                'User.id',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name', 
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ];
            $group =['User.name'];
            $order =['User.name'=> 'ASC'];
            $conditions = [
                'User.id' => $userid,
                'BasketballPrediction.game_day' => $gameday,'BasketballPrediction.sport_id' => $sport_id,
                   'BasketballPrediction.league_id' => $league_id,
                   'BasketballPrediction.tournament_id' => $tornament_id
            ];
            $this->paginate = [
                'limit' => 50,
                'conditions' => $conditions,
                'fields' => $fields,
               'group' =>$group,
                'order' =>$order
            ];
             
     
             $basketballpredictionswinnerdata_array[] = $this->Paginator->paginate('BasketballPrediction',$condition);
            
         $i++;
       }
   }
    
         $new = $this->BasketballPrediction->find('all', [
            'fields' => [
                'BasketballPrediction.id',
                'BasketballPrediction.winner',
                'BasketballPrediction.is_deleted',
                'BasketballPrediction.status',
                'BasketballPrediction.created',
                'BasketballPrediction.modified',
                'BasketballPrediction.first_team_goals',
                'BasketballPrediction.second_team_goals',
                'BasketballPrediction.game_day',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'

            ],
            'conditions' =>['BasketballPrediction.is_deleted'=>0,'BasketballPrediction.status'=>1,
            'User.is_deleted'=>0,'User.status'=>1,
            'Tournament.is_deleted'=>0,'Tournament.status'=>1,
          'Sport.status'=>1,'League.is_deleted'=>0,'League.status'=>1,'Game.is_deleted'=>0,'Game.status'=>1,]
        ]);
       // pr($basketballpredictionswinnerdata_array);exit;

         $this->set(compact('basketballpredictionswinnerdata_array'));
      
         $this->set(compact('new'));
    }
public function admin_basketballPredictionResult($user_Id=null,
$game_day=null)
    {
        $this->layout = '';    
        $this->loadModel('BasketballPrediction');
        $this->loadModel('UserTeam');
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        $this->loadModel('Game');
        $gameDay = base64_decode($game_day);
        $userId = base64_decode($user_Id);
          $dataExists= $this->BasketballPrediction->find('all',  array('fields' => array('User.name','League.name','Tournament.name','BasketballPrediction.id','BasketballPrediction.game_id','BasketballPrediction.sport_id','BasketballPrediction.user_id','BasketballPrediction.tournament_id', 'BasketballPrediction.league_id', 'BasketballPrediction.game_id', 'BasketballPrediction.game_day','gameresult.first_team_goals', 'gameresult.second_team_goals', 'BasketballPrediction.first_team_goals', 'BasketballPrediction.second_team_goals','file.first_team','file.second_team','team.name','secondteam.name'),

                'joins' => array( 
                    array('table' => 'games_results',
                                  'alias' => 'gameresult',
                                   'type' => 'INNER',
                                   'conditions' => array( 'BasketballPrediction.game_day=gameresult.game_day','BasketballPrediction.game_id=gameresult.game_id')
                                   ),
                     array(
                        'table' => 'games',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('BasketballPrediction.game_id = file.id')
                    ),
                    array(
                        'table' => 'teams',
                        'alias' => 'team',
                        'type' => 'right',
                        'conditions' => array('file.first_team =team.id')
                    ),
                    array(
                        'table' => 'teams',
                        'alias' => 'secondteam',
                        'type' => 'right',
                        'conditions' => array('file.second_team =secondteam.id')
                    ),
                    ),
                  'conditions'=>array('BasketballPrediction.game_day' => $gameDay,'BasketballPrediction.user_id' => $userId,'BasketballPrediction.is_deleted' => 0)
                )
          );

$giftdata= $this->GamesGiftPrediction->find('all',  array('fields' => array('gift.winning_no_game','gift.name', 'gift.type','gift.amount','GamesGiftPrediction.cashamount'),

                'joins' => array( 
                    array('table' => 'gifts',
                                   'alias' => 'gift',
                                   'type' => 'left',
                                   'conditions' => array( 'GamesGiftPrediction. gift_id = gift.id')
                                   ),
                     
                    ),
                  'conditions'=>array('GamesGiftPrediction.teams_gameday' => $gameDay,
                  'GamesGiftPrediction.is_deleted' => 0,'GamesGiftPrediction.user_id' => $userId)
                )
          );
 $this->set(compact('giftdata'));
 $this->set(compact('dataExists'));
    }
    public function admin_basketballResults()
    { $this->set('title_for_layout', 'Basketball winners');
        $this->loadModel('Gift');
         $this->loadModel('GamesGiftPrediction');
          $this->loadModel('GamesResult');
          $this->loadModel('BasketballPrediction');
         $conditions = [];
       $conditions = $this->_getGamesSearchConditions('GamesResult');

        $basketballwinner=$this->GamesGiftPrediction->query("SELECT `GamesGiftPrediction`.`user_id`, `GamesGiftPrediction`.`sport_id`,`GamesGiftPrediction`.`tournament_id`,`GamesGiftPrediction`.`league_id`,`GamesGiftPrediction`.`teams_gameday`, `Gifts`.`winning_no_game`,`Gifts`.`id` FROM .`gamesgiftprediction` AS `GamesGiftPrediction` LEFT JOIN .`users` AS `User` ON (`GamesGiftPrediction`.`user_id` = `User`.`id`) LEFT JOIN .`tournaments` AS `Tournament` ON (`GamesGiftPrediction`.`tournament_id` = `Tournament`.`id`) LEFT JOIN .`sports` AS `Sport` ON (`GamesGiftPrediction`.`sport_id` = `Sport`.`id`) LEFT JOIN .`leagues` AS `League` ON (`GamesGiftPrediction`.`league_id` = `League`.`id`) inner JOIN .`gifts` AS `Gifts` ON (`GamesGiftPrediction`.`gift_id` = `Gifts`.`id` AND ((`GamesGiftPrediction`.`sport_id` = `Gifts`.`sport_id`) OR (`Gifts`.`sport_id`=0)) AND ((`GamesGiftPrediction`.`tournament_id` = `Gifts`.`tournament_id`) OR (`Gifts`.`tournament_id`=0)) AND ((`GamesGiftPrediction`.`league_id` =`Gifts`.`league_id`) OR (`Gifts`.`league_id`=0))) WHERE `GamesGiftPrediction`.`is_deleted`=0 AND `GamesGiftPrediction`.`status`=1");  
      //echo '<pre>'; print_r($soccerwinner);
       $basketballwinnerlist_array=array();   
        $basketballwinnerdata_array=array();        
        $i=0;
        if(!empty($basketballwinner)){
           
       while($i<count($basketballwinner))
       {  
            $userid= $basketballwinner[$i]['GamesGiftPrediction']['user_id'];
            $gameday= $basketballwinner[$i]['GamesGiftPrediction']['teams_gameday'];
            $giftcount=$basketballwinner[$i]['Gifts']['winning_no_game'];
             $sport_id=$basketballwinner[$i]['GamesGiftPrediction']['sport_id'];
             $tornament_id=$basketballwinner[$i]['GamesGiftPrediction']['tournament_id'];
             $league_id=$basketballwinner[$i]['GamesGiftPrediction']['league_id'];
             $basketballwinnerlist=$this->BasketballPrediction->query("select BasketballPrediction.user_id,BasketballPrediction.first_team_goals,BasketballPrediction.second_team_goals,BasketballPrediction.game_day from basketball_predictions as BasketballPrediction inner join games_results as GamesResult ON BasketballPrediction.first_team_goals=GamesResult.first_team_goals and BasketballPrediction.second_team_goals=GamesResult.second_team_goals and BasketballPrediction.game_id=GamesResult.game_id and GamesResult.game_day=BasketballPrediction.game_day where BasketballPrediction.user_id =$userid and BasketballPrediction.game_day =$gameday and BasketballPrediction.is_deleted=0 and BasketballPrediction.status=1 and BasketballPrediction.sport_id =$sport_id and BasketballPrediction.league_id  = $league_id and 
                   BasketballPrediction.tournament_id = $tornament_id");

          //echo'<pre>';  print_r($soccerwinnerlist);
            if(!empty($basketballwinnerlist)){
                  
                // echo'<pre>';  print_r($soccerwinnerlist);
             $basketballwinnerlist_array[$i]['count']=count($basketballwinnerlist);
              //echo $j=count($soccerwinnerlist);
                 $basketballwinnerlist_array[$i]['userid']=$basketballwinnerlist[0]['BasketballPrediction']['user_id'];
                $basketballwinnerlist_array[$i]['gameday']=$basketballwinnerlist[0]['BasketballPrediction']['game_day'];
          
            if($basketballwinnerlist_array[$i]['count']>=$giftcount)
            { 
            
              $winneruser_id= $basketballwinnerlist_array[$i]['userid']; 
              $winnergame_day= $basketballwinnerlist_array[$i]['gameday']; 
           
             $this->paginate =  array('fields' => array('user.name','League.name','Tournament.name','GamesResult.id','GamesResult.sport_id','BasketballPrediction.user_id','GamesResult.tournament_id', 'GamesResult.league_id', 'GamesResult.game_id', 'GamesResult.game_day', 'GamesResult.first_team_goals', 'GamesResult.second_team_goals'),

                'joins' => array( 
                    array('table' => 'basketball_predictions',
                                  'alias' => 'BasketballPrediction',
                                   'type' => 'INNER',
                                   'conditions' => array('GamesResult.first_team_goals = BasketballPrediction.first_team_goals ','GamesResult.second_team_goals=BasketballPrediction.second_team_goals', 'GamesResult.game_day=BasketballPrediction.game_day','BasketballPrediction.game_id=GamesResult.game_id')
                            
                                   ),
                       array(
                        'table' => 'users',
                        'alias' => 'user',
                        'type' => 'left',
                        'conditions' => array('BasketballPrediction. user_id = user.id')
                    ),

                     
                    ),
                'conditions'=>array('BasketballPrediction.user_id' => $winneruser_id,'BasketballPrediction.game_day' => $winnergame_day,'BasketballPrediction.is_deleted' => 0),
                'limit' => 10,
                'group' => 'BasketballPrediction.user_id'
                );
              
             $basketballwinnerdata = $this->Paginator->paginate('GamesResult',$conditions);
             $basketballwinnerdata_array[]=$basketballwinnerdata;
            }
        }
            
         $i++;
       }
   }
      
         $new = $this->BasketballPrediction->find('all', [
               'fields' => [
                'BasketballPrediction.id',
                'BasketballPrediction.winner',
                'BasketballPrediction.is_deleted',
                'BasketballPrediction.status',
                'BasketballPrediction.created',
                'BasketballPrediction.modified',
                'BasketballPrediction.first_team_goals',
                'BasketballPrediction.second_team_goals',
                'BasketballPrediction.game_day',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ],
             'conditions' =>['BasketballPrediction.is_deleted'=>0,'BasketballPrediction.status'=>1,
            'User.is_deleted'=>0,'User.status'=>1,
            'Tournament.is_deleted'=>0,'Tournament.status'=>1,
          'Sport.status'=>1,'League.is_deleted'=>0,'League.status'=>1,'Game.is_deleted'=>0,'Game.status'=>1,]
        ]);
     
        $this->set(compact('basketballwinnerdata_array'));
         $this->set(compact('new'));
    }
    /**
     * findBasketballPrediction method
     *
     * @param null|mixed $gameId
     * @param null|mixed $firstTeam
     * @param null|mixed $secondTeam
     *
     * @return void
     */
     public function findBasketballPrediction($gameDay = null)
    {
        $this->layout = '';
        $userId = $this->Session->read('Auth.User.id');
        $this->loadModel('BasketballPrediction');
        $this->loadModel('UserTeam');
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        $this->loadModel('Game');
        $gameDay = base64_decode($gameDay);
       

            $dataExists= $this->BasketballPrediction->find('all', array(
            'fields' => array('BasketballPrediction.game_id','BasketballPrediction.first_team_goals','BasketballPrediction.second_team_goals','file.first_team','file.second_team','team.name','secondteam.name'),
            'joins' => array(
                array(
                        'table' => 'games',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('BasketballPrediction.game_id = file.id')
                    ),
                array(
                        'table' => 'teams',
                        'alias' => 'team',
                        'type' => 'right',
                        'conditions' => array('file.first_team =team.id')
                    ),
                array(
                        'table' => 'teams',
                        'alias' => 'secondteam',
                        'type' => 'right',
                        'conditions' => array('file.second_team =secondteam.id')
                    ),
                ),
             'conditions'=>array('BasketballPrediction.game_day' => $gameDay,'BasketballPrediction.user_id' => $userId, 'BasketballPrediction.is_deleted' => 0)
               
            )
        );
         // echo '<pre>'; print_r($dataExists);exit;
        $this->set(compact('dataExists'));
    }

    /**
     * admin_cricketPrediction method
     * list predictions
     *
     * @param mixed $conditions
     * @param mixed $order
     *
     * @return void
     */
    public function admin_cricketPrediction($conditions = '', $order = '')
    {
        $this->loadModel('CricketPrediction');

        $conditions = [];
        $conditions = $this->_getGamesSearchConditions('CricketPrediction');
        // pr($conditions);die;
        $cricket = $this->CricketPrediction->find('all', [
            'conditions' => $conditions,
            'fields' => [
                'CricketPrediction.id',
                'CricketPrediction.winner',
                'CricketPrediction.first_team_score',
                'CricketPrediction.second_team_score',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);

        $new = $this->CricketPrediction->find('all', [
            'fields' => [
                'CricketPrediction.id',
                'CricketPrediction.winner',
                'CricketPrediction.first_team_score',
                'CricketPrediction.second_team_score',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);

        // $cricket = $this->CricketPrediction->find('all', array('fields' => array('CricketPrediction.id', 'CricketPrediction.winner', 'CricketPrediction.first_team_score', 'CricketPrediction.second_team_score', 'User.name', 'Tournament.id', 'Tournament.name', 'Sport.name', 'Sport.id', 'League.name', 'League.id', 'Game.name', 'Game.id'),'conditions' => $conditions));

        $this->set(compact('cricket'));
        $this->set(compact('new'));
    }

    /**
     * admin_viewCricketPrediction method
     *
     * @param null|mixed $id
     *
     * @return notfound exception
     * @return void
     */
    public function admin_viewCricketPrediction($id = null)
    {
        $this->loadModel('CricketPrediction');
        $this->CricketPrediction->id = base64_decode($id);
        if (! $this->CricketPrediction->exists())
        {
            throw new NotFoundException(__('Invalid prediction'));
        }

        $cricket = $this->CricketPrediction->find('first', [
            'conditions' => [
                'CricketPrediction.id' => $this->CricketPrediction->id
            ],
            'fields' => [
                'CricketPrediction.id',
                'CricketPrediction.is_deleted',
                'CricketPrediction.status',
                'CricketPrediction.created',
                'CricketPrediction.modified',
                'CricketPrediction.first_team_score',
                'CricketPrediction.second_team_score',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);
        $this->set(compact('cricket'));
    }

    /**
     * admin_cricketPrediction method
     *
     * @param null|mixed $id
     *
     * @return notfound exception
     * @return void
     */
    public function admin_deletePrediction($id = null)
    {
        $this->loadModel('CricketPrediction');
        $this->CricketPrediction->id = base64_decode($id);
        if (! $this->CricketPrediction->exists())
        {
            throw new NotFoundException(__('Invalid prediction'));
        }
        if ($this->request->is('post'))
        {
            $this->CricketPrediction->id = base64_decode($id);
            if ($this->CricketPrediction->saveField('is_deleted', 1))
            {
                $this->Flash->success(__('The prediction has been deleted.'));
            }
            else
            {
                $this->Flash->error(__('The prediction could not be deleted. Please, try again.'));
            }
            return $this->redirect([
                'action' => 'cricketPrediction'
            ]);
        }
    }

    /**
     * admin_soccerPrediction method
     * list predictions
     *
     * @param mixed $conditions
     * @param mixed $order
     *
     * @return void
     */
    public function admin_soccerPrediction($conditions = '', $order = '')
    {
            
        $this->loadModel('SoccerPrediction');
        $conditions = [];
        $conditions = $this->_getGamesSearchConditions('SoccerPrediction');
            $fields = [
                'SoccerPrediction.id',
                'SoccerPrediction.winner',
                'SoccerPrediction.is_deleted',
                'SoccerPrediction.status',
                'SoccerPrediction.created',
                'SoccerPrediction.modified',
                'SoccerPrediction.first_team_goals',
                'SoccerPrediction.second_team_goals',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ];
        $new = $this->SoccerPrediction->find('all', [
            'fields' => [
                'SoccerPrediction.id',
                'SoccerPrediction.winner',
                'SoccerPrediction.is_deleted',
                'SoccerPrediction.status',
                'SoccerPrediction.created',
                'SoccerPrediction.modified',
                'SoccerPrediction.first_team_goals',
                'SoccerPrediction.second_team_goals',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);
         $this->paginate = [
                'limit' => 10,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            
        $soccer = $this->Paginator->paginate('SoccerPrediction');
        $this->set(compact('soccer'));
        $this->set(compact('new'));
    }

    /**
     * admin_viewCricketPrediction method
     *
     * @param null|mixed $id
     *
     * @return notfound exception
     * @return void
     */
    public function admin_viewSoccerPrediction($id = null)
    {
        $this->loadModel('SoccerPrediction');
        $this->SoccerPrediction->id = base64_decode($id);
        if (! $this->SoccerPrediction->exists())
        {
            throw new NotFoundException(__('Invalid prediction'));
        }

        $soccer = $this->SoccerPrediction->find('first', [
            'conditions' =>
            [
                'SoccerPrediction.id' => $this->SoccerPrediction->id
            ],
            'fields' => [
                'SoccerPrediction.id',
                'SoccerPrediction.is_deleted',
                'SoccerPrediction.status',
                'SoccerPrediction.created',
                'SoccerPrediction.modified',
                'SoccerPrediction.first_team_goals',
                'SoccerPrediction.second_team_goals',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);
        $this->set(compact('soccer'));
    }

    /**
     * admin_cricketPrediction method
     *
     * @param null|mixed $id
     *
     * @return notfound exception
     * @return void
     */
    public function admin_deleteSoccerPrediction($id = null)
    {
        $this->autoRender = false;
        $this->loadModel('SoccerPrediction');
        $this->SoccerPrediction->id = base64_decode($id);
        if (! $this->SoccerPrediction->exists())
        {
            throw new NotFoundException(__('Invalid prediction'));
        }
        if ($this->request->is('post'))
        {
            $this->SoccerPrediction->id = base64_decode($id);
            if ($this->SoccerPrediction->saveField('is_deleted', 1))
            {
                $this->Flash->success(__('The prediction has been deleted.'));
            }
            else
            {
                $this->Flash->error(__('The prediction could not be deleted. Please, try again.'));
            }
            return $this->redirect([
                'controller' => 'Games',
                'action' => 'soccerPrediction',
                'admin' => true
            ]);
        }
    }

    /**
     * admin_footballPrediction method
     * list predictions
     *
     * @param mixed $conditions
     * @param mixed $order
     *
     * @return void
     */
    public function admin_footballPrediction($conditions = '', $order = '')
    {
        $this->loadModel('FootballPrediction');
        $conditions = [];
        $conditions = $this->_getGamesSearchConditions('FootballPrediction');
        $football = $this->FootballPrediction->find('all', [
            'conditions' => $conditions,
            'fields' => [
                'FootballPrediction.id',
                'FootballPrediction.winner',
                'FootballPrediction.is_deleted',
                'FootballPrediction.status',
                'FootballPrediction.created',
                'FootballPrediction.modified',
                'FootballPrediction.first_team_goals',
                'FootballPrediction.second_team_goals',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);

        $new = $this->FootballPrediction->find('all', [
            'fields' => [
                'FootballPrediction.id',
                'FootballPrediction.winner',
                'FootballPrediction.is_deleted',
                'FootballPrediction.status',
                'FootballPrediction.created',
                'FootballPrediction.modified',
                'FootballPrediction.first_team_goals',
                'FootballPrediction.second_team_goals',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);

        // $cricket = $this->CricketPrediction->find('all', array('fields' => array('CricketPrediction.id', 'CricketPrediction.winner', 'CricketPrediction.first_team_score', 'CricketPrediction.second_team_score', 'User.name', 'Tournament.id', 'Tournament.name', 'Sport.name', 'Sport.id', 'League.name', 'League.id', 'Game.name', 'Game.id'),'conditions' => $conditions));

        $this->set(compact('football'));
        $this->set(compact('new'));
    }
      public function admin_footballPredictions()
    {


        $this->set('title_for_layout', 'Football Prediction');
        $this->loadModel('Gift');
         $this->loadModel('GamesGiftPrediction');
          $this->loadModel('GamesResult');
          $this->loadModel('FootballPrediction');
         $conditions = [];
         $conditions = $this->_getGamesSearchConditions('GamesGiftPrediction');
         //$conditions = $this->_getGamesSearchConditions('SoccerPrediction');
        /* $this->paginate =  array('fields' => array('GamesGiftPrediction.user_id','GamesGiftPrediction.teams_gameday','Gifts.winning_no_game'),
            'joins' => array(
                array(
                        'table' => 'gifts',
                        'alias' => 'Gifts',
                        'type' => 'inner',
                        'conditions' => array('GamesGiftPrediction.gift_id = Gifts.id',' GamesGiftPrediction.sport_id = Gifts.sport_id ',' GamesGiftPrediction.tournament_id = Gifts.tournament_id',' GamesGiftPrediction.league_id =Gifts.league_id')
                    ),
               
                ),
             'conditions'=>array('GamesGiftPrediction.is_deleted=0','GamesGiftPrediction.status=1'),
             'order'=>'GamesGiftPrediction.teams_gameday', 
             'limit' => 10,

               
            
        );*/
        $footballpredictionswinner=$this->GamesGiftPrediction->query("SELECT `GamesGiftPrediction`.`user_id`,`GamesGiftPrediction`.`sport_id`,`GamesGiftPrediction`.`tournament_id`,`GamesGiftPrediction`.`league_id`, `GamesGiftPrediction`.`teams_gameday`, `Gifts`.`winning_no_game`,`Gifts`.`id` FROM .`gamesgiftprediction` AS `GamesGiftPrediction` LEFT JOIN .`users` AS `User` ON (`GamesGiftPrediction`.`user_id` = `User`.`id`) LEFT JOIN .`tournaments` AS `Tournament` ON (`GamesGiftPrediction`.`tournament_id` = `Tournament`.`id`) LEFT JOIN .`sports` AS `Sport` ON (`GamesGiftPrediction`.`sport_id` = `Sport`.`id`) LEFT JOIN .`leagues` AS `League` ON (`GamesGiftPrediction`.`league_id` = `League`.`id`) inner JOIN .`gifts` AS `Gifts` ON (`GamesGiftPrediction`.`gift_id` = `Gifts`.`id` AND ((`GamesGiftPrediction`.`sport_id` = `Gifts`.`sport_id`) OR (`Gifts`.`sport_id`=0)) AND ((`GamesGiftPrediction`.`tournament_id` = `Gifts`.`tournament_id`) OR (`Gifts`.`tournament_id`=0)) AND ((`GamesGiftPrediction`.`league_id` =`Gifts`.`league_id`) OR (`Gifts`.`league_id`=0))) WHERE `GamesGiftPrediction`.`is_deleted`=0 AND `GamesGiftPrediction`.`status`=1 ");  
          //  $footballpredictionswinner = $this->Paginator->paginate('GamesGiftPrediction',$conditions);
      
    //pr($footballpredictionswinner);exit;
       $footballpredictionswinnerlist_array=array();   
        $footballpredictionswinnerdata_array=array();        
        $i=0;
        if(!empty($footballpredictionswinner)){
           
       while($i<count($footballpredictionswinner))
       {  
            $userid= $footballpredictionswinner[$i]['GamesGiftPrediction']['user_id'];
             $gameday= $footballpredictionswinner[$i]['GamesGiftPrediction']['teams_gameday'];
             $sport_id=$footballpredictionswinner[$i]['GamesGiftPrediction']['sport_id'];
             $tornament_id=$footballpredictionswinner[$i]['GamesGiftPrediction']['tournament_id'];
             $league_id=$footballpredictionswinner[$i]['GamesGiftPrediction']['league_id'];
         
         
             $fields = [
                
                'FootballPrediction.game_day',
                'User.id',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name', 
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ];
            $group =['User.name'];
            $order =['User.name'=> 'ASC'];
            $conditions = [
                'User.id' => $userid, 'FootballPrediction.game_day' => $gameday,'FootballPrediction.sport_id' => $sport_id,
                   'FootballPrediction.league_id' => $league_id,
                   'FootballPrediction.tournament_id' => $tornament_id
            ];
            $this->paginate = [
                'limit' => 50,
                'conditions' => $conditions,
                'fields' => $fields,
               'group' =>$group,
                'order' =>$order
            ];
             
     
             $footballpredictionswinnerdata_array[] = $this->Paginator->paginate('FootballPrediction',$conditions);
        
            //pr($footballpredictionswinnerdata_array);
         $i++;
       }
   }
    
         $new = $this->FootballPrediction->find('all', [
            'fields' => [
                'FootballPrediction.id',
                'FootballPrediction.winner',
                'FootballPrediction.is_deleted',
                'FootballPrediction.status',
                'FootballPrediction.created',
                'FootballPrediction.modified',
                'FootballPrediction.first_team_goals',
                'FootballPrediction.second_team_goals',
                'FootballPrediction.game_day',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'

            ],
            'conditions' =>['FootballPrediction.is_deleted'=>0,'FootballPrediction.status'=>1,
            'User.is_deleted'=>0,'User.status'=>1,
            'Tournament.is_deleted'=>0,'Tournament.status'=>1,
          'Sport.status'=>1,'League.is_deleted'=>0,'League.status'=>1,'Game.is_deleted'=>0,'Game.status'=>1,]
        ]);
//pr($footballpredictionswinnerdata_array);exit;
         $this->set(compact('footballpredictionswinnerdata_array'));
      
         $this->set(compact('new'));
    }
       public function admin_footballPredictionResult($user_Id=null,
       $game_day=null)
    {
        $this->layout = '';    
        $this->loadModel('FootballPrediction');
        $this->loadModel('UserTeam');
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        $this->loadModel('Game');
        $gameDay = base64_decode($game_day);
        $userId = base64_decode($user_Id);
          $dataExists= $this->FootballPrediction->find('all',  array('fields' => array('User.name','League.name','Tournament.name','FootballPrediction.id','FootballPrediction.game_id','FootballPrediction.sport_id','FootballPrediction.user_id','FootballPrediction.tournament_id', 'FootballPrediction.league_id', 'FootballPrediction.game_id', 'FootballPrediction.game_day','gameresult.first_team_goals', 'gameresult.second_team_goals', 'FootballPrediction.first_team_goals', 'FootballPrediction.second_team_goals','file.first_team','file.second_team','team.name','secondteam.name'),

                'joins' => array( 
                    array('table' => 'games_results',
                                  'alias' => 'gameresult',
                                   'type' => 'INNER',
                                   'conditions' => array( 'FootballPrediction.game_day=gameresult.game_day','FootballPrediction.game_id=gameresult.game_id')
                                   ),
                     array(
                        'table' => 'games',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('FootballPrediction.game_id = file.id')
                    ),
                    array(
                        'table' => 'teams',
                        'alias' => 'team',
                        'type' => 'right',
                        'conditions' => array('file.first_team =team.id')
                    ),
                    array(
                        'table' => 'teams',
                        'alias' => 'secondteam',
                        'type' => 'right',
                        'conditions' => array('file.second_team =secondteam.id')
                    ),
                    ),
                  'conditions'=>array('FootballPrediction.game_day' => $gameDay,'FootballPrediction.user_id' => $userId,'FootballPrediction.is_deleted' => 0)
                )
          );

$giftdata= $this->GamesGiftPrediction->find('all',  array('fields' => array('gift.winning_no_game','gift.name', 'gift.type','gift.amount','GamesGiftPrediction.cashamount'),

                'joins' => array( 
                    array('table' => 'gifts',
                                   'alias' => 'gift',
                                   'type' => 'left',
                                   'conditions' => array( 'GamesGiftPrediction. gift_id = gift.id')
                                   ),
                     
                    ),
                  'conditions'=>array('GamesGiftPrediction.teams_gameday' => $gameDay,
                  'GamesGiftPrediction.is_deleted' => 0,'GamesGiftPrediction.user_id' => $userId)
                )
          );
 $this->set(compact('giftdata'));
 $this->set(compact('dataExists'));
    }

 public function admin_footballResults()
    { $this->set('title_for_layout', 'Football winners');
        $this->loadModel('Gift');
         $this->loadModel('GamesGiftPrediction');
          $this->loadModel('GamesResult');
          $this->loadModel('FootballPrediction');
         $conditions = [];
       $conditions = $this->_getGamesSearchConditions('GamesResult');

        $footballwinner=$this->GamesGiftPrediction->query("SELECT `GamesGiftPrediction`.`user_id`,`GamesGiftPrediction`.`sport_id`,`GamesGiftPrediction`.`tournament_id`,`GamesGiftPrediction`.`league_id`, `GamesGiftPrediction`.`teams_gameday`, `Gifts`.`winning_no_game`,`Gifts`.`id` FROM .`gamesgiftprediction` AS `GamesGiftPrediction` LEFT JOIN .`users` AS `User` ON (`GamesGiftPrediction`.`user_id` = `User`.`id`) LEFT JOIN .`tournaments` AS `Tournament` ON (`GamesGiftPrediction`.`tournament_id` = `Tournament`.`id`) LEFT JOIN .`sports` AS `Sport` ON (`GamesGiftPrediction`.`sport_id` = `Sport`.`id`) LEFT JOIN .`leagues` AS `League` ON (`GamesGiftPrediction`.`league_id` = `League`.`id`) inner JOIN .`gifts` AS `Gifts` ON (`GamesGiftPrediction`.`gift_id` = `Gifts`.`id` AND ((`GamesGiftPrediction`.`sport_id` = `Gifts`.`sport_id`) OR (`Gifts`.`sport_id`=0)) AND ((`GamesGiftPrediction`.`tournament_id` = `Gifts`.`tournament_id`) OR (`Gifts`.`tournament_id`=0)) AND ((`GamesGiftPrediction`.`league_id` =`Gifts`.`league_id`) OR (`Gifts`.`league_id`=0))) WHERE `GamesGiftPrediction`.`is_deleted`=0 AND `GamesGiftPrediction`.`status`=1");  
      //echo '<pre>'; print_r($soccerwinner);
       $footballwinnerlist_array=array();   
        $footballwinnerdata_array=array();        
        $i=0;
        if(!empty($footballwinner)){
           
       while($i<count($footballwinner))
       {  
            $userid= $footballwinner[$i]['GamesGiftPrediction']['user_id'];
            $gameday= $footballwinner[$i]['GamesGiftPrediction']['teams_gameday'];
            $giftcount=$footballwinner[$i]['Gifts']['winning_no_game'];
            $sport_id=$footballwinner[$i]['GamesGiftPrediction']['sport_id'];
             $tornament_id=$footballwinner[$i]['GamesGiftPrediction']['tournament_id'];
             $league_id=$footballwinner[$i]['GamesGiftPrediction']['league_id'];
             $footballwinnerlist=$this->FootballPrediction->query("select FootballPrediction.user_id,FootballPrediction.first_team_goals,FootballPrediction.second_team_goals,FootballPrediction.game_day from football_predictions as FootballPrediction inner join games_results as GamesResult ON FootballPrediction.first_team_goals=GamesResult.first_team_goals and FootballPrediction.second_team_goals=GamesResult.second_team_goals and FootballPrediction.game_id=GamesResult.game_id and GamesResult.game_day=FootballPrediction.game_day where FootballPrediction.user_id =$userid and FootballPrediction.game_day =$gameday and FootballPrediction.is_deleted=0 and FootballPrediction.status=1 and FootballPrediction.sport_id =$sport_id and FootballPrediction.league_id  = $league_id and 
                   FootballPrediction.tournament_id = $tornament_id");

          //echo'<pre>';  print_r($soccerwinnerlist);
            if(!empty($footballwinnerlist)){
                  
                // echo'<pre>';  print_r($soccerwinnerlist);
             $footballwinnerlist_array[$i]['count']=count($footballwinnerlist);
              //echo $j=count($soccerwinnerlist);
                 $footballwinnerlist_array[$i]['userid']=$footballwinnerlist[0]['FootballPrediction']['user_id'];
                $footballwinnerlist_array[$i]['gameday']=$footballwinnerlist[0]['FootballPrediction']['game_day'];
          
            if($footballwinnerlist_array[$i]['count']>=$giftcount)
            { 
            
              $winneruser_id= $footballwinnerlist_array[$i]['userid']; 
              $winnergame_day= $footballwinnerlist_array[$i]['gameday']; 
           
             $this->paginate =  array('fields' => array('user.name','League.name','Tournament.name','GamesResult.id','GamesResult.sport_id','FootballPrediction.user_id','GamesResult.tournament_id', 'GamesResult.league_id', 'GamesResult.game_id', 'GamesResult.game_day', 'GamesResult.first_team_goals', 'GamesResult.second_team_goals'),

                'joins' => array( 
                    array('table' => 'football_predictions',
                                  'alias' => 'FootballPrediction',
                                   'type' => 'INNER',
                                   'conditions' => array('GamesResult.first_team_goals = FootballPrediction.first_team_goals ','GamesResult.second_team_goals=FootballPrediction.second_team_goals', 'GamesResult.game_day=FootballPrediction.game_day','FootballPrediction.game_id=GamesResult.game_id')
                            
                                   ),
                       array(
                        'table' => 'users',
                        'alias' => 'user',
                        'type' => 'left',
                        'conditions' => array('FootballPrediction. user_id = user.id')
                    ),

                     
                    ),
                'conditions'=>array('FootballPrediction.user_id' => $winneruser_id,'FootballPrediction.game_day' => $winnergame_day,'FootballPrediction.is_deleted' => 0),
                'limit' => 10,
                'group' => 'FootballPrediction.user_id'
                );
              
             $footballwinnerdata = $this->Paginator->paginate('GamesResult',$conditions);
             $footballwinnerdata_array[]=$footballwinnerdata;
            }
        }
            
         $i++;
       }
   }
      
         $new = $this->FootballPrediction->find('all', [
               'fields' => [
                'FootballPrediction.id',
                'FootballPrediction.winner',
                'FootballPrediction.is_deleted',
                'FootballPrediction.status',
                'FootballPrediction.created',
                'FootballPrediction.modified',
                'FootballPrediction.first_team_goals',
                'FootballPrediction.second_team_goals',
                'FootballPrediction.game_day',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ],
             'conditions' =>['FootballPrediction.is_deleted'=>0,'FootballPrediction.status'=>1,
            'User.is_deleted'=>0,'User.status'=>1,
            'Tournament.is_deleted'=>0,'Tournament.status'=>1,
          'Sport.status'=>1,'League.is_deleted'=>0,'League.status'=>1,'Game.is_deleted'=>0,'Game.status'=>1,]
        ]);
     //pr($footballwinnerdata_array);exit;
        $this->set(compact('footballwinnerdata_array'));
         $this->set(compact('new'));
    }

    /**
     * admin_viewCricketPrediction method
     *
     * @param null|mixed $id
     *
     * @return notfound exception
     * @return void
     */
    public function admin_viewFootballPrediction($id = null)
    {
        $this->loadModel('FootballPrediction');
        $this->FootballPrediction->id = base64_decode($id);
        if (! $this->FootballPrediction->exists())
        {
            throw new NotFoundException(__('Invalid prediction'));
        }

        $football = $this->FootballPrediction->find('first', [
            'conditions',
            [
                'FootballPrediction.id' => $this->FootballPrediction->id
            ],
            'fields' => [
                'FootballPrediction.id',
                'FootballPrediction.is_deleted',
                'FootballPrediction.status',
                'FootballPrediction.created',
                'FootballPrediction.modified',
                'FootballPrediction.first_team_goals',
                'FootballPrediction.second_team_goals',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);
        $this->set(compact('football'));
    }

    /**
     * admin_cricketPrediction method
     *
     * @param null|mixed $id
     *
     * @return notfound exception
     * @return void
     */
    public function admin_deleteFootballPrediction($id = null)
    {
        $this->autoRender = false;
        $this->loadModel('FootballPrediction');
        $this->FootballPrediction->id = base64_decode($id);
        if (! $this->FootballPrediction->exists())
        {
            throw new NotFoundException(__('Invalid prediction'));
        }
        if ($this->request->is('post'))
        {
            $this->FootballPrediction->id = base64_decode($id);
            if ($this->FootballPrediction->saveField('is_deleted', 1))
            {
                $this->Flash->success(__('The prediction has been deleted.'));
            }
            else
            {
                $this->Flash->error(__('The prediction could not be deleted. Please, try again.'));
            }
            return $this->redirect([
                'controller' => 'games',
                'action' => 'footballPrediction',
                'admin' => true
            ]);
        }
    }

    /**
     * admin_footballPrediction method
     * list predictions
     *
     * @param mixed $conditions
     * @param mixed $order
     *
     * @return void
     */
     public function admin_hockeyPrediction($conditions = '', $order = '')
    {

        $this->loadModel('HockeyPrediction');
        $conditions = [];
        $conditions = $this->_getGamesSearchConditions('HockeyPrediction');

       // $soccer = $this->SoccerPrediction->find('all', [
            //'conditions' => $conditions,
            $fields = [
                 'HockeyPrediction.id',
                'HockeyPrediction.winner',
                'HockeyPrediction.is_deleted',
                'HockeyPrediction.status',
                'HockeyPrediction.created',
                'HockeyPrediction.modified',
                'HockeyPrediction.first_team_goals',
                'HockeyPrediction.second_team_goals',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ];
      //  ]);

        $new = $this->HockeyPrediction->find('all', [
            'fields' => [
               'HockeyPrediction.id',
                'HockeyPrediction.winner',
                'HockeyPrediction.is_deleted',
                'HockeyPrediction.status',
                'HockeyPrediction.created',
                'HockeyPrediction.modified',
                'HockeyPrediction.first_team_goals',
                'HockeyPrediction.second_team_goals',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);
         $this->paginate = [
                'limit' => 10,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            
        $hockey = $this->Paginator->paginate('HockeyPrediction');
        $this->set(compact('hockey'));
        $this->set(compact('new'));
    }
    public function admin_hockeyPredictions()
    {
        $this->set('title_for_layout', 'Hockey Prediction');
        $this->loadModel('Gift');
         $this->loadModel('GamesGiftPrediction');
          $this->loadModel('GamesResult');
          $this->loadModel('HockeyPrediction');
         $conditions = [];
         $conditions = $this->_getGamesSearchConditions('GamesGiftPrediction');
        
        $hockeypredictionswinner=$this->GamesGiftPrediction->query("SELECT `GamesGiftPrediction`.`user_id`,`GamesGiftPrediction`.`sport_id`,`GamesGiftPrediction`.`tournament_id`,`GamesGiftPrediction`.`league_id`, `GamesGiftPrediction`.`teams_gameday`, `Gifts`.`winning_no_game`,`Gifts`.`id` FROM .`gamesgiftprediction` AS `GamesGiftPrediction` LEFT JOIN .`users` AS `User` ON (`GamesGiftPrediction`.`user_id` = `User`.`id`) LEFT JOIN .`tournaments` AS `Tournament` ON (`GamesGiftPrediction`.`tournament_id` = `Tournament`.`id`) LEFT JOIN .`sports` AS `Sport` ON (`GamesGiftPrediction`.`sport_id` = `Sport`.`id`) LEFT JOIN .`leagues` AS `League` ON (`GamesGiftPrediction`.`league_id` = `League`.`id`) inner JOIN .`gifts` AS `Gifts` ON (`GamesGiftPrediction`.`gift_id` = `Gifts`.`id` AND ((`GamesGiftPrediction`.`sport_id` = `Gifts`.`sport_id`) OR (`Gifts`.`sport_id`=0)) AND ((`GamesGiftPrediction`.`tournament_id` = `Gifts`.`tournament_id`) OR (`Gifts`.`tournament_id`=0)) AND ((`GamesGiftPrediction`.`league_id` =`Gifts`.`league_id`) OR (`Gifts`.`league_id`=0))) WHERE `GamesGiftPrediction`.`is_deleted`=0 AND `GamesGiftPrediction`.`status`=1 ");  
       //  pr($hockeypredictionswinner);exit;
       $hockeypredictionswinnerlist_array=array();   
        $hockeypredictionswinnerdata_array=array();        
        $i=0;
        if(!empty($hockeypredictionswinner)){
           
       while($i<count($hockeypredictionswinner))
       {  
           $userid= $hockeypredictionswinner[$i]['GamesGiftPrediction']['user_id'];
           $gameday= $hockeypredictionswinner[$i]['GamesGiftPrediction']['teams_gameday'];
           $sport_id=$hockeypredictionswinner[$i]['GamesGiftPrediction']['sport_id'];
           $tornament_id=$hockeypredictionswinner[$i]['GamesGiftPrediction']['tournament_id'];
           $league_id=$hockeypredictionswinner[$i]['GamesGiftPrediction']['league_id'];
         
          
             $fields = [
                
                'HockeyPrediction.game_day',
                'User.id',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name', 
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ];
            $group =['User.name'];
            $order =['User.name'=> 'ASC'];
            $conditions = [
                'User.id' => $userid, 'HockeyPrediction.game_day' => $gameday,'HockeyPrediction.sport_id' => $sport_id,
                   'HockeyPrediction.league_id' => $league_id,
                   'HockeyPrediction.tournament_id' => $tornament_id
            ];
            $this->paginate = [
                'limit' => 50,
                'conditions' => $conditions,
                'fields' => $fields,
               'group' =>$group,
                'order' =>$order
            ];
             
     
             $hockeypredictionswinnerdata_array[] = $this->Paginator->paginate('HockeyPrediction',$conditions);
        
            
         $i++;
       }
   }
    
         $new = $this->HockeyPrediction->find('all', [
            'fields' => [
                'HockeyPrediction.id',
                'HockeyPrediction.winner',
                'HockeyPrediction.is_deleted',
                'HockeyPrediction.status',
                'HockeyPrediction.created',
                'HockeyPrediction.modified',
                'HockeyPrediction.first_team_goals',
                'HockeyPrediction.second_team_goals',
                'HockeyPrediction.game_day',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'

            ],
            'conditions' =>['HockeyPrediction.is_deleted'=>0,'HockeyPrediction.status'=>1,
            'User.is_deleted'=>0,'User.status'=>1,
            'Tournament.is_deleted'=>0,'Tournament.status'=>1,
          'Sport.status'=>1,'League.is_deleted'=>0,'League.status'=>1,'Game.is_deleted'=>0,'Game.status'=>1,]
        ]);
         //pr($hockeypredictionswinnerdata_array);exit;
         $this->set(compact('hockeypredictionswinnerdata_array'));
      
         $this->set(compact('new'));
    }

     public function admin_hockeyResults()
    { $this->set('title_for_layout', 'Hockey winners');
        $this->loadModel('Gift');
         $this->loadModel('GamesGiftPrediction');
          $this->loadModel('GamesResult');
          $this->loadModel('HockeyPrediction');
         $conditions = [];
       $conditions = $this->_getGamesSearchConditions('GamesResult');

        $hockeywinner=$this->GamesGiftPrediction->query("SELECT `GamesGiftPrediction`.`user_id`, `GamesGiftPrediction`.`sport_id`,`GamesGiftPrediction`.`tournament_id`,`GamesGiftPrediction`.`league_id`,`GamesGiftPrediction`.`teams_gameday`, `Gifts`.`winning_no_game`,`Gifts`.`id` FROM .`gamesgiftprediction` AS `GamesGiftPrediction` LEFT JOIN .`users` AS `User` ON (`GamesGiftPrediction`.`user_id` = `User`.`id`) LEFT JOIN .`tournaments` AS `Tournament` ON (`GamesGiftPrediction`.`tournament_id` = `Tournament`.`id`) LEFT JOIN .`sports` AS `Sport` ON (`GamesGiftPrediction`.`sport_id` = `Sport`.`id`) LEFT JOIN .`leagues` AS `League` ON (`GamesGiftPrediction`.`league_id` = `League`.`id`) inner JOIN .`gifts` AS `Gifts` ON (`GamesGiftPrediction`.`gift_id` = `Gifts`.`id` AND ((`GamesGiftPrediction`.`sport_id` = `Gifts`.`sport_id`) OR (`Gifts`.`sport_id`=0)) AND ((`GamesGiftPrediction`.`tournament_id` = `Gifts`.`tournament_id`) OR (`Gifts`.`tournament_id`=0)) AND ((`GamesGiftPrediction`.`league_id` =`Gifts`.`league_id`) OR (`Gifts`.`league_id`=0))) WHERE `GamesGiftPrediction`.`is_deleted`=0 AND `GamesGiftPrediction`.`status`=1");  
      //echo '<pre>'; print_r($soccerwinner);
       $hockeywinnerlist_array=array();   
        $hockeywinnerdata_array=array();        
        $i=0;
        if(!empty($hockeywinner)){
           
       while($i<count($hockeywinner))
       {  
            $userid= $hockeywinner[$i]['GamesGiftPrediction']['user_id'];
            $gameday= $hockeywinner[$i]['GamesGiftPrediction']['teams_gameday'];
            $giftcount=$hockeywinner[$i]['Gifts']['winning_no_game'];
             $sport_id=$hockeywinner[$i]['GamesGiftPrediction']['sport_id'];
             $tornament_id=$hockeywinner[$i]['GamesGiftPrediction']['tournament_id'];
             $league_id=$hockeywinner[$i]['GamesGiftPrediction']['league_id'];
             $hockeywinnerlist=$this->HockeyPrediction->query("select HockeyPrediction.user_id,HockeyPrediction.first_team_goals,HockeyPrediction.second_team_goals,HockeyPrediction.game_day from hockey_predictions as HockeyPrediction inner join games_results as GamesResult ON HockeyPrediction.first_team_goals=GamesResult.first_team_goals and HockeyPrediction.second_team_goals=GamesResult.second_team_goals and HockeyPrediction.game_id=GamesResult.game_id and GamesResult.game_day=HockeyPrediction.game_day where HockeyPrediction.user_id =$userid and HockeyPrediction.game_day =$gameday and HockeyPrediction.is_deleted=0 and HockeyPrediction.status=1 and HockeyPrediction.sport_id =$sport_id and HockeyPrediction.league_id  = $league_id and 
                   HockeyPrediction.tournament_id = $tornament_id");

          //echo'<pre>';  print_r($soccerwinnerlist);
            if(!empty($hockeywinnerlist)){
                  
                // echo'<pre>';  print_r($soccerwinnerlist);
             $hockeywinnerlist_array[$i]['count']=count($hockeywinnerlist);
              //echo $j=count($soccerwinnerlist);
                 $hockeywinnerlist_array[$i]['userid']=$hockeywinnerlist[0]['HockeyPrediction']['user_id'];
                $hockeywinnerlist_array[$i]['gameday']=$hockeywinnerlist[0]['HockeyPrediction']['game_day'];
          
            if($hockeywinnerlist_array[$i]['count']>=$giftcount)
            { 
            
              $winneruser_id= $hockeywinnerlist_array[$i]['userid']; 
              $winnergame_day= $hockeywinnerlist_array[$i]['gameday']; 
           
             $this->paginate =  array('fields' => array('user.name','League.name','Tournament.name','GamesResult.id','GamesResult.sport_id','HockeyPrediction.user_id','GamesResult.tournament_id', 'GamesResult.league_id', 'GamesResult.game_id', 'GamesResult.game_day', 'GamesResult.first_team_goals', 'GamesResult.second_team_goals'),

                'joins' => array( 
                    array('table' => 'hockey_predictions',
                                  'alias' => 'HockeyPrediction',
                                   'type' => 'INNER',
                                   'conditions' => array('GamesResult.first_team_goals = HockeyPrediction.first_team_goals ','GamesResult.second_team_goals=HockeyPrediction.second_team_goals', 'GamesResult.game_day=HockeyPrediction.game_day','HockeyPrediction.game_id=GamesResult.game_id')
                            
                                   ),
                       array(
                        'table' => 'users',
                        'alias' => 'user',
                        'type' => 'left',
                        'conditions' => array('HockeyPrediction. user_id = user.id')
                    ),

                     
                    ),
                'conditions'=>array('HockeyPrediction.user_id' => $winneruser_id,'HockeyPrediction.game_day' => $winnergame_day,'HockeyPrediction.is_deleted' => 0),
                'limit' => 10,
                'group' => 'HockeyPrediction.user_id'
                );
              
             $hockeywinnerdata = $this->Paginator->paginate('GamesResult',$conditions);
             $hockeywinnerdata_array[]=$hockeywinnerdata;
            }
        }
            
         $i++;
       }
   }
      
         $new = $this->HockeyPrediction->find('all', [
               'fields' => [
                'HockeyPrediction.id',
                'HockeyPrediction.winner',
                'HockeyPrediction.is_deleted',
                'HockeyPrediction.status',
                'HockeyPrediction.created',
                'HockeyPrediction.modified',
                'HockeyPrediction.first_team_goals',
                'HockeyPrediction.second_team_goals',
                'HockeyPrediction.game_day',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ],
             'conditions' =>['HockeyPrediction.is_deleted'=>0,'HockeyPrediction.status'=>1,
            'User.is_deleted'=>0,'User.status'=>1,
            'Tournament.is_deleted'=>0,'Tournament.status'=>1,
          'Sport.status'=>1,'League.is_deleted'=>0,'League.status'=>1,'Game.is_deleted'=>0,'Game.status'=>1,]
        ]);
     
        $this->set(compact('hockeywinnerdata_array'));
         $this->set(compact('new'));
    }

    public function admin_hockeyPredictionResult($user_Id=null,
       $game_day=null)
    {
        $this->layout = '';    
        $this->loadModel('HockeyPrediction');
        $this->loadModel('UserTeam');
        $this->loadModel('Tournament');
        $this->loadModel('GamesGiftPrediction');
        $this->loadModel('Game');
        $gameDay = base64_decode($game_day);
        $userId = base64_decode($user_Id);
          $dataExists= $this->HockeyPrediction->find('all',  array('fields' => array('User.name','League.name','Tournament.name','HockeyPrediction.id','HockeyPrediction.game_id','HockeyPrediction.sport_id','HockeyPrediction.user_id','HockeyPrediction.tournament_id', 'HockeyPrediction.league_id', 'HockeyPrediction.game_id', 'HockeyPrediction.game_day','gameresult.first_team_goals', 'gameresult.second_team_goals', 'HockeyPrediction.first_team_goals', 'HockeyPrediction.second_team_goals','file.first_team','file.second_team','team.name','secondteam.name'),

                'joins' => array( 
                    array('table' => 'games_results',
                                  'alias' => 'gameresult',
                                   'type' => 'INNER',
                                   'conditions' => array( 'HockeyPrediction.game_day=gameresult.game_day','HockeyPrediction.game_id=gameresult.game_id')
                                   ),
                     array(
                        'table' => 'games',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('HockeyPrediction.game_id = file.id')
                    ),
                    array(
                        'table' => 'teams',
                        'alias' => 'team',
                        'type' => 'right',
                        'conditions' => array('file.first_team =team.id')
                    ),
                    array(
                        'table' => 'teams',
                        'alias' => 'secondteam',
                        'type' => 'right',
                        'conditions' => array('file.second_team =secondteam.id')
                    ),
                    ),
                  'conditions'=>array('HockeyPrediction.game_day' => $gameDay,'HockeyPrediction.user_id' => $userId,'HockeyPrediction.is_deleted' => 0)
                )
          );

$giftdata= $this->GamesGiftPrediction->find('all',  array('fields' => array('gift.winning_no_game','gift.name', 'gift.type','gift.amount','GamesGiftPrediction.cashamount'),

                'joins' => array( 
                    array('table' => 'gifts',
                                   'alias' => 'gift',
                                   'type' => 'left',
                                   'conditions' => array( 'GamesGiftPrediction. gift_id = gift.id')
                                   ),
                     
                    ),
                  'conditions'=>array('GamesGiftPrediction.teams_gameday' => $gameDay,
                  'GamesGiftPrediction.is_deleted' => 0,'GamesGiftPrediction.user_id' => $userId)
                )
          );
 $this->set(compact('giftdata'));
 $this->set(compact('dataExists'));
    }

    /**
     * admin_viewCricketPrediction method
     *
     * @param null|mixed $id
     *
     * @return notfound exception
     * @return void
     */
    public function admin_viewHockeyPrediction($id = null)
    {
        $this->loadModel('HockeyPrediction');
        $this->HockeyPrediction->id = base64_decode($id);
        if (! $this->HockeyPrediction->exists())
        {
            throw new NotFoundException(__('Invalid prediction'));
        }

        $hockey = $this->HockeyPrediction->find('first', [
            'conditions'=>
            [
                'HockeyPrediction.id' => $this->HockeyPrediction->id
            ],
            'fields' => [
                'HockeyPrediction.id',
                'HockeyPrediction.is_deleted',
                'HockeyPrediction.status',
                'HockeyPrediction.created',
                'HockeyPrediction.modified',
                'HockeyPrediction.first_team_goals',
                'HockeyPrediction.second_team_goals',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);
        $this->set(compact('hockey'));
    }


    /**
     * admin_cricketPrediction method
     *
     * @param null|mixed $id
     *
     * @return notfound exception
     * @return void
     */
    public function admin_deleteHockeyPrediction($id = null)
    {
        $this->autoRender = false;
        $this->loadModel('HockeyPrediction');
        $this->HockeyPrediction->id = base64_decode($id);
        if (! $this->HockeyPrediction->exists())
        {
            throw new NotFoundException(__('Invalid prediction'));
        }

        if ($this->request->is('post'))
        {
            if ($this->HockeyPrediction->saveField('is_deleted', 1))
            {
                $this->Flash->success(__('The prediction has been deleted.'));
            }
            else
            {
                $this->Flash->error(__('The prediction could not be deleted. Please, try again.'));
            }
            return $this->redirect([
                'controller' => 'games',
                'action' => 'hockeyPrediction',
                'admin' => true
            ]);
        }
    }

    /**
     * admin_baseballPrediction method
     * list predictions
     *
     * @param mixed $conditions
     * @param mixed $order
     *
     * @return void
     */
    public function admin_baseballPrediction($conditions = '', $order = '')
    {
        $this->loadModel('BaseballPrediction');

        $conditions = [];
        $conditions = $this->_getGamesSearchConditions('BaseballPrediction');

        $baseball = $this->BaseballPrediction->find('all', [
            'conditions' => $conditions,
            'fields' => [
                'BaseballPrediction.id',
                'BaseballPrediction.winner',
                'BaseballPrediction.is_deleted',
                'BaseballPrediction.status',
                'BaseballPrediction.created',
                'BaseballPrediction.modified',
                'BaseballPrediction.first_team_score',
                'BaseballPrediction.second_team_score',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);
        // pr($baseball);die;
        $new = $this->BaseballPrediction->find('all', [
            'fields' => [
                'BaseballPrediction.id',
                'BaseballPrediction.winner',
                'BaseballPrediction.is_deleted',
                'BaseballPrediction.status',
                'BaseballPrediction.created',
                'BaseballPrediction.modified',
                'BaseballPrediction.first_team_score',
                'BaseballPrediction.second_team_score',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);

        $this->set(compact('baseball'));
        $this->set(compact('new'));
    }

    /**
     * admin_viewCricketPrediction method
     *
     * @param null|mixed $id
     *
     * @return notfound exception
     * @return void
     */
    public function admin_viewBaseballPrediction($id = null)
    {
        $this->loadModel('BaseballPrediction');
        $this->BaseballPrediction->id = base64_decode($id);
        if (! $this->BaseballPrediction->exists())
        {
            throw new NotFoundException(__('Invalid prediction'));
        }

        $baseball = $this->BaseballPrediction->find('first', [
            'conditions',
            [
                'BaseballPrediction.id' => $this->BaseballPrediction->id
            ],
            'fields' => [
                'BaseballPrediction.id',
                'BaseballPrediction.is_deleted',
                'BaseballPrediction.status',
                'BaseballPrediction.created',
                'BaseballPrediction.modified',
                'BaseballPrediction.first_team_score',
                'BaseballPrediction.second_team_score',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);
        $this->set(compact('baseball'));
    }

    /**
     * admin_cricketPrediction method
     *
     * @param null|mixed $id
     *
     * @return notfound exception
     * @return void
     */
    public function admin_deleteBaseballPrediction($id = null)
    {
        $this->autoRender = false;
        $this->loadModel('BaseballPrediction');
        $this->BaseballPrediction->id = base64_decode($id);
        if (! $this->BaseballPrediction->exists())
        {
            throw new NotFoundException(__('Invalid prediction'));
        }

        if ($this->request->is('post'))
        {
            if ($this->BaseballPrediction->saveField('is_deleted', 1))
            {
                $this->Flash->success(__('The prediction has been deleted.'));
            }
            else
            {
                $this->Flash->error(__('The prediction could not be deleted. Please, try again.'));
            }
            return $this->redirect([
                'controller' => 'games',
                'action' => 'baseballPrediction',
                'admin' => true
            ]);
        }
    }

    /**
     * admin_basketballPrediction method
     * list predictions
     *
     * @param mixed $conditions
     * @param mixed $order
     *
     * @return void
     */
    public function admin_basketballPrediction($conditions = '', $order = '')
    {
        $this->loadModel('BasketballPrediction');
        $conditions = [];
        $conditions = $this->_getGamesSearchConditions('BasketballPrediction');
            $fields = [
               'BasketballPrediction.id',
                'BasketballPrediction.winner',
                'BasketballPrediction.is_deleted',
                'BasketballPrediction.status',
                'BasketballPrediction.created',
                'BasketballPrediction.modified',
                'BasketballPrediction.first_team_goals',
                'BasketballPrediction.second_team_goals',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ];
        $new = $this->BasketballPrediction->find('all', [
            'fields' => [
                'BasketballPrediction.id',
                'BasketballPrediction.winner',
                'BasketballPrediction.is_deleted',
                'BasketballPrediction.status',
                'BasketballPrediction.created',
                'BasketballPrediction.modified',
                'BasketballPrediction.first_team_goals',
                'BasketballPrediction.second_team_goals',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);
         $this->paginate = [
                'limit' => 10,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            
        $basketball = $this->Paginator->paginate('BasketballPrediction');
        $this->set(compact('basketball'));
        $this->set(compact('new'));
    }

    /**
     * admin_viewBasketballPrediction method
     *
     * @param null|mixed $id
     *
     * @return notfound exception
     * @return void
     */
    public function admin_viewBasketballPrediction($id = null)
    {
        $this->loadModel('BasketballPrediction');
         $this->BasketballPrediction->id = base64_decode($id);
        if (! $this->BasketballPrediction->exists())
        {
            throw new NotFoundException(__('Invalid prediction'));
        }

        $basketball = $this->BasketballPrediction->find('first', [
            'conditions'=>
            [
                'BasketballPrediction.id' => $this->BasketballPrediction->id
            ],
            'fields' => [
                'BasketballPrediction.id',
                'BasketballPrediction.is_deleted',
                'BasketballPrediction.status',
                'BasketballPrediction.created',
                'BasketballPrediction.modified',
                'BasketballPrediction.first_team_goals',
                'BasketballPrediction.second_team_goals',
                'User.name',
                'Tournament.id',
                'Tournament.name',
                'Sport.name',
                'Sport.id',
                'League.name',
                'League.id',
                'Game.name',
                'Game.id'
            ]
        ]);
        $this->set(compact('basketball'));
    }

    /**
     * admin_deleteBasketballPrediction method
     *
     * @param null|mixed $id
     *
     * @return notfound exception
     * @return void
     */
    public function admin_deleteBasketballPrediction($id = null)
    {
        $this->autoRender = false;
        $this->loadModel('BasketballPrediction');
        $this->BasketballPrediction->id = base64_decode($id);
        if (! $this->BasketballPrediction->exists())
        {
            throw new NotFoundException(__('Invalid prediction'));
        }

        if ($this->request->is('post'))
        {
            if ($this->BasketballPrediction->saveField('is_deleted', 1))
            {
                $this->Flash->success(__('The prediction has been deleted.'));
            }
            else
            {
                $this->Flash->error(__('The prediction could not be deleted. Please, try again.'));
            }
            return $this->redirect([
                'controller' => 'games',
                'action' => 'basketballPrediction',
                'admin' => true
            ]);
        }
    }

    /**
     * admin_viewBasketballPrediction method
     *
     * @param null|mixed $id
     * @param null|mixed $modelName
     *
     * @return notfound exception
     * @return void
     */
    public function admin_predictionWinner($id = null, $modelName = null)
    {
        $this->autoRender = false;
        $this->loadModel($modelName);
        $this->$modelName->id = base64_decode($id);
        $this->$modelName->unbindModel([
            'belongsTo' => [
                'User',
                'Game'
            ]
        ]);

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $getPredictionStatus = $this->$modelName->find('first', [
                'conditions' => [
                    $modelName . '.id' => $this->$modelName->id
                ],
                'fields' => [
                    'Tournament.name',
                    'CricketPrediction.tournament_id',
                    'Sport.name',
                    'CricketPrediction.sport_id',
                    'League.name',
                    'CricketPrediction.league_id',
                    'CricketPrediction.user_id',
                    'CricketPrediction.game_id'
                ]
            ]);

            $user_info = $this->User->find('first', [
                'conditions' => [
                    'User.id' => $getPredictionStatus[$modelName]['user_id']
                ]
            ]);

            $predictStatus = $this->$modelName->find('count', [
                'conditions' => [
                    $modelName . '.winner' => 1,
                    $modelName . '.game_id' => $getPredictionStatus[$modelName]['game_id'],
                    $modelName . '.league_id' => $getPredictionStatus[$modelName]['league_id']
                ]
            ]);
            if ($predictStatus == 0)
            {
                if ($this->$modelName->saveField('winner', 1))
                {

                    $message = 'Congratulations for winning the grand raffle prize!! <p>As per your prediction you have declared winner for sport <b> ' . $getPredictionStatus['Sport']['name'] . '</b> league <b> ' . $getPredictionStatus['League']['name'] . ' </b> and tournament <b>' . $getPredictionStatus['Tournament']['name'] . '</b>. </p>';
                    // SENT Email Code Started

                    $this->loadModel('EmailTemplate');
                    $emailTemplate = $this->EmailTemplate->find('first', [
                        'conditions' => [
                            'EmailTemplate.id' => 7
                        ]
                    ]);
                    $subject = $emailTemplate['EmailTemplate']['subject'];
                    // $emailTemplate = str_replace(array('{NAME}','{MESSAGE}'), $user_info['User']['name'], $emailTemplate['EmailTemplate']['description']);
                    $emailTemplate = str_replace([
                        '{NAME}',
                        '{MESSAGE}'
                    ], [
                        $user_info['User']['name'],
                        $message
                    ], $emailTemplate['EmailTemplate']['description']);

                    $to = $user_info['User']['email'];

                    //
                    // $Email = new CakeEmail();
                    //
                    // $this->Email->smtpOptions = array(
                    // 'port'=>'465',
                    // 'timeout'=>'30',
                    // 'host' => 'ssl://smtp.gmail.com',
                    // 'username'=>'sdd.sdei@gmail.com',
                    // 'password'=>'Sdei#6001',
                    // 'mailtype' => 'html',
                    // 'MIME-Version' => '1.0',
                    // 'Content-Type' => "text/html; charset=ISO-8859-1"
                    //
                    // );
                    // $this->Email->delivery = 'smtp';
                    //
                    //
                    // $this->Email->from = 'SportsAdmin<username@Domain.com>';
                    // $this->Email->to = 'rsona85@yahoo.com'; //$user_info['user']['id']; die;
                    //
                    // $this->Email->subject = $subject;
                    // $this->Email->sendAs="html";
                    //
                    // $this->set('smtp_errors', $this->Email->smtpError);
                    // $this->Email->send($emailTemplate);

                    $status = $this->_sendSmtpMail($subject, $emailTemplate, $to);

                    // END
                    $this->Flash->success(__('The winner for prediction has been saved.'));
                }
                else
                {
                    $this->Flash->error(__('The prediction winner could not be saved. Please, try again.'));
                }
            }
            else
            {
                $this->Flash->error(__('You have already declared winner for a game.'));
            }
            return $this->redirect([
                'controller' => 'games',
                'action' => lcfirst($modelName),
                'admin' => true
            ]);
        }
    }

    /**
     * admin_allowTeamChat method
     *
     * @param null|mixed $firstTeamId
     * @param null|mixed $secondTeamId
     * @param null|mixed $sportId
     * @param null|mixed $tournamentId
     * @param null|mixed $leagueId
     *
     * @return void
     */
    public function admin_allowTeamChat($firstTeamId = null, $secondTeamId = null, $sportId = null, $tournamentId = null, $leagueId = null)
    {
        $this->set('title_for_layout', 'Allow Team Chat');
        $this->autoRender = false;
        $this->loadModel('Chatroom');
        $this->loadModel('Pocale');
        $this->request->data['team_id'] = base64_decode($firstTeamId);
        $this->request->data['sport_id'] = base64_decode($sportId);
        $this->request->data['tournament_id'] = base64_decode($tournamentId);
        $this->request->data['league_id'] = base64_decode($leagueId);
        $this->request->data['allowed_teams'] = base64_decode($firstTeamId) . ',' . base64_decode($secondTeamId);

        $rooms = $this->Chatroom->find('all', [
            'conditions' => [
                'Chatroom.allowed_teams' => $this->request->data['allowed_teams']
            ],
            'fields' => [
                'Chatroom.id'
            ]
        ]);

        if ($rooms)
        {
            foreach ($rooms as $room)
            :
                $this->Chatroom->id = $room['Chatroom']['id'];
                if ($this->Chatroom->saveField('status', 1))
                {
                    $this->Flash->success(__('Chat room opend successfully.'));
                }
                else
                {
                    $this->Flash->error(__('Error in opening chat room. Please, try again.'));
                }
            endforeach
            ;
            return $this->redirect([
                'action' => 'index'
            ]);
        }
        $i = 0;
        $languages = $this->Pocale->find('list');
        foreach ($languages as $language)
        :
            $this->request->data['name'] = 'admin_allow_chat';
            $this->request->data['locale_id'] = $i ++;
            $this->request->data['room_type'] = 1;
            $this->request->data['status'] = 1;
            $this->Chatroom->create();
            if ($this->Chatroom->save($this->request->data))
            {
                $this->Flash->success(__('Chat room opend successfully.'));
            }
            else
            {
                $this->Flash->error(__('Error in opening chat room. Please, try again.'));
            }
        endforeach
        ;
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * admin_allowTeamChat method
     *
     * @param null|mixed $firstTeamId
     * @param null|mixed $secondTeamId
     * @param null|mixed $sportId
     * @param null|mixed $tournamentId
     * @param null|mixed $leagueId
     *
     * @return void
     */
    public function admin_closeTeamChat($firstTeamId = null, $secondTeamId = null, $sportId = null, $tournamentId = null, $leagueId = null)
    {
        $this->set('title_for_layout', __('Allow Team Chat'));
        $this->autoRender = false;
        $this->loadModel('Chatroom');
        $this->loadModel('Pocale');
        $this->request->data['team_id'] = base64_decode($firstTeamId);
        $this->request->data['sport_id'] = base64_decode($sportId);
        $this->request->data['tournament_id'] = base64_decode($tournamentId);
        $this->request->data['league_id'] = base64_decode($leagueId);
        $this->request->data['allowed_teams'] = base64_decode($firstTeamId) . ',' . base64_decode($secondTeamId);

        $rooms = $this->Chatroom->find('all', [
            'conditions' => [
                'Chatroom.allowed_teams' => $this->request->data['allowed_teams'],
                'Chatroom.status' => 1
            ],
            'fields' => [
                'Chatroom.id'
            ]
        ]);

        if ($rooms)
        {
            foreach ($rooms as $room)
            :
                $this->Chatroom->id = $room['Chatroom']['id'];
                if ($this->Chatroom->saveField('status', 0))
                {
                    $this->Flash->success(__('Chat room closed successfully.'));
                }
                else
                {
                    $this->Flash->error(__('Error in closing chat room. Please, try again.'));
                }
            endforeach
            ;
            return $this->redirect([
                'action' => 'index'
            ]);
        }
        $this->Flash->success(__('Chat room already closed.'));
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /* * **************************** Currency Converter start *********************** */

    /* function for get Currency Rate */
    public function getCurrencyRate()
    {
        if ((empty($_POST['access_Token'])) || $_POST['access_Token'] != 'OO0OO0OO0O0O0O0O0OO0O')
        {
            echo '<h1>Bad Request</h1>';
            die();
        }
        $from = $_POST['from'];
        $to = $_POST['to'];
        $yahoo_rates = file_get_contents('http://download.finance.yahoo.com/d/quotes.csv?s=' . $from . '' . $to . '=X&f=sl1d1t1ba&e=.csv');
        $yahoo_rates = explode(',', $yahoo_rates);
        echo $yahoo_rates[1];
        die();
        echo '<table>
                    <tr>
                        <th>Params</th>
                        <th>Value</th>
                    </tr>';
        $i = 0;
        $keyy = [
            'FROM-TO',
            'VALUE',
            'DATE',
            'TIME',
            'PARAM1',
            'PARAM2'
        ];
        foreach ($yahoo_rates as $yr)
        {
            echo "<tr><td>$keyy[$i]</td><td>" . $yr . '</td></tr>';
            ++ $i;
        }
        echo '</table>';
        die();
    }

    /* * **************************** Currency Converter end *********************** */
    public function admin_checkleaguedate()
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('League');

        // pr($this->request->data);die;
        $leagueStartEnd = $this->League->find('first', [
            'conditions' => [
                'League.id' => $this->request->data['league_id']
            ]
        ]);
        if (! empty($leagueStartEnd))
        {
            $dbStartDate = $leagueStartEnd['League']['start_date'];
            // echo '<br/>';
            $dbEndDate = $leagueStartEnd['League']['end_date'];
            echo $dbStartDate . '###' . $dbEndDate;
            die();
        }
    }

    // smtp mail reply to sender
    /*
     * function _sendSmtpMail($subject= null,$emailTemplate = null, $to= null){
     *
     * Configure::write('host', 'ssl://smtp.gmail.com');
     * Configure::write('username', SMTP_USER);
     * Configure::write('password', SMTP_PASSWORD);
     * Configure::write('port', '465');
     * Configure::write('timeout', 60);
     * $this->Email->smtpOptions = array(
     * 'port' => Configure::read('port'),
     * 'host' => Configure::read('host'),
     * 'username' => Configure::read('username'),
     * 'password' => Configure::read('password'),
     * 'timeout' => Configure::read('timeout')
     * );
     * $this->Email->delivery = 'smtp';
     * $this->Email->from = 'sdd.sdei1@gmail.com';
     * $this->Email->to = $to;
     *
     * //
     * $this->Email->subject = $subject;
     * $this->set('smtp_errors', $this->Email->smtpError);
     * $this->set('data', 'sending');
     * $this->Email->sendAs= 'both';
     *
     * if($this->Email->send($emailTemplate)){
     *
     * return true;
     * } else {
     * return false;
     * }
     * }
     */
    public function _sendSmtpMail($subject = null, $emailTemplate = null, $to = null)
    {
        $this->Email->from = FROM_EMAIL;
        $this->Email->to = $to;
        $this->Email->subject = $subject;
        $this->Email->sendAs = 'both';
        if ($this->Email->send($emailTemplate))
        {
            return true;
        }
        return false;
    }

    public function admin_checkdate()
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('League');

        // pr($this->request->data);die;
        $leagueStartEnd = $this->League->find('first', [
            'conditions' => [
                'League.id' => $this->request->data['league_id']
            ]
        ]);
        if (! empty($leagueStartEnd))
        {
            $formStartDate = base64_decode($this->request->data['startDate']);

            // echo '<br/>';
            $dbStartDate = $leagueStartEnd['League']['start_date'];
            // echo '<br/>';
            $dbEndDate = $leagueStartEnd['League']['end_date'];

            if ($this->request->data['check'] == 'start')
            {

                if (strtotime($formStartDate) > strtotime($dbStartDate) && strtotime($formStartDate) < strtotime($dbEndDate))
                {
                    echo 'success';
                    die();
                }
                echo 'fail';
                die();

                die();
            }
            // pr($this->request->data);die;
            $formStartDate = base64_decode($this->request->data['startDate']);
            $formEndDate = base64_decode($this->request->data['endDate']);
            $dbStartDate = $leagueStartEnd['League']['start_date'];
            $dbEndDate = $leagueStartEnd['League']['end_date'];

            // die;
            if (strtotime($formEndDate) < strtotime($dbStartDate) || strtotime($formEndDate) > strtotime($dbEndDate))
            {
                echo 'fail';
                die();
            }
            echo 'success';
            die();

            die();
            die();
        }
    }

    public function checkleaguedate()
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('League');

        // pr($this->request->data);die;
        $leagueStartEnd = $this->League->find('first', [
            'conditions' => [
                'League.id' => $this->request->data['league_id']
            ]
        ]);
        if (! empty($leagueStartEnd))
        {
            $dbStartDate = $leagueStartEnd['League']['start_date'];
            // echo '<br/>';
            $dbEndDate = $leagueStartEnd['League']['end_date'];
            echo $dbStartDate . '###' . $dbEndDate;
            die();
        }
    }

    public function checkdate()
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('League');

        // pr($this->request->data);die;
        $leagueStartEnd = $this->League->find('first', [
            'conditions' => [
                'League.id' => $this->request->data['league_id']
            ]
        ]);
        if (! empty($leagueStartEnd))
        {
            $formStartDate = base64_decode($this->request->data['startDate']);

            // echo '<br/>';
            $dbStartDate = $leagueStartEnd['League']['start_date'];
            // echo '<br/>';
            $dbEndDate = $leagueStartEnd['League']['end_date'];

            if ($this->request->data['check'] == 'start')
            {

                if (strtotime($formStartDate) > strtotime($dbStartDate) && strtotime($formStartDate) < strtotime($dbEndDate))
                {
                    echo 'success';
                    die();
                }
                echo 'fail';
                die();

                die();
            }
            // pr($this->request->data);die;
            $formStartDate = base64_decode($this->request->data['startDate']);
            $formEndDate = base64_decode($this->request->data['endDate']);
            $dbStartDate = $leagueStartEnd['League']['start_date'];
            $dbEndDate = $leagueStartEnd['League']['end_date'];

            // die;
            if (strtotime($formEndDate) < strtotime($dbStartDate) || strtotime($formEndDate) > strtotime($dbEndDate))
            {
                echo 'fail';
                die();
            }
            echo 'success';
            die();

            die();
            die();
        }
    }
}
