<?php

class ChatsController extends AppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = [
        'Paginator',
        'Flash',
        'Session'
    ];

    public $name = 'Chats';

    public $smiley = [
        'kiss' => ':-*',
        'heart' => '<3',
        'angel' => 'O:-)',
        'cry' => ';-(',
        'sad' => ':-(',
        'smile' => ':-)',
        'goggles' => 'B-)',
        'laugh' => ':-D',
        'tease' => ':-P'
    ];

    public function add()
    {
        $this->layout = false;
        $user = AuthComponent::user();
        $this->loadModel('Game');
        $this->loadModel('Chatroom');
        if (! empty($_POST))
        {
            $tmp['Chat']['chatroom_id'] = base64_decode($_POST['id']);
            $tmp['Chat']['name'] = $_POST['msg'];
            $tmp['Chat']['user_id'] = $user['id'];
            if (empty($user['File']['path']))
            {
                $user['File']['path'] = '/img/default_profile.png';
            }

            if (! empty($_POST['gameIds']))
            {
                $gameID = trim($_POST['gameIds']);
                $gameID = explode(',', $gameID);
                $gameID = array_unique($gameID);
                $gameID = array_filter($gameID);
                foreach ($gameID as $intGameId)
                {

                    $teamID = $this->Game->find('first', [
                        'conditions' => [
                            'Game.id' => $intGameId
                        ],
                        'fields' => [
                            'Game.first_team',
                            'Game.second_team'
                        ]
                    ]);
                    $allowedTeams = $teamID['Game']['first_team'] . ',' . $teamID['Game']['second_team'];
                    $room = $this->Chatroom->find('first', [
                        'conditions' => [
                            'Chatroom.locale_id' => AuthComponent::User('locale_id'),
                            'Chatroom.league_id' => AuthComponent::User('sportSession.league_id'),
                            'Chatroom.allowed_teams' => $allowedTeams,
                            'Chatroom.status' => 1
                        ],
                        'fields' => [
                            'Chatroom.id'
                        ]
                    ]);

                    if ($room)
                    {
                        $tmp2['Chat']['chatroom_id'] = $room['Chatroom']['id'];
                        $tmp2['Chat']['name'] = $_POST['msg'];
                        $tmp2['Chat']['user_id'] = $user['id'];
                        $this->Chat->create();
                        $this->Chat->save($tmp2);
                    }
                }
            }

            $this->Chat->create();
            if ($saved = $this->Chat->save($tmp))
            {
                $timeElapsed = humanTiming(strtotime($saved['Chat']['created']));
                $message = <<<EOD
<div class="chat-rpt">
            <div class="chat-usr-dtl pull-right">
                <div class="chat-avtar">
                    <img src="{$user['File']['path']}" alt="chat user" title="chat user" />
                </div>
                <div class="chat-user">
                    <h4>{$user['name']} </h4>
                    <p>{$timeElapsed} ago </p>
                </div>
            </div>
            <div class="chat-desc my-txt">
                {$saved['Chat']['name']}
            </div>
</div>
EOD;
                $return = [
                    'status' => 1,
                    'html' => $message,
                    'lm' => $saved['Chat']['created']
                ];
                echo json_encode($return);
                die();
            }
            $return = [
                'status' => 0,
                'html' => ''
            ];
            echo json_encode($return);
            die();
        }
    }

    public function getMatchList()
    {
        $leagueId = $this->Auth->Session->read('Auth.User.sportSession.league_id');
        $sportId = $this->Auth->Session->read('Auth.User.sportSession.sport_id');
        $teamId = $this->Auth->Session->read('Auth.User.sportSession.team_id');

        $this->loadModel('Game');
        $this->Game->UnbindModel([
            'hasMany' => [
                'Team'
            ]
        ], false);
        $gamesLists = $this->Game->find('all', [
            'conditions' => [
                'Game.sport_id' => $sportId,
                'Game.league_id' => $leagueId,
                'Game.play_status' => 1,
                'Game.first_team != ' => $teamId,
                'Game.second_team != ' => $teamId
            ],
            'fields' => [
                'Game.id',
                'Game.start_time',
                'Game.end_time',
                'First_team.name',
                'Second_team.name'
            ]
        ]);

        $arr = [];
        foreach ($gamesLists as $game)
        {
            $arr[$game['Game']['id']]['GameName'] = $game['First_team']['name'] . ' VS ' . $game['Second_team']['name'];
            $arr[$game['Game']['id']]['start_time'] = $game['Game']['start_time'];
            $arr[$game['Game']['id']]['end_time'] = $game['Game']['end_time'];
            $arr[$game['Game']['id']]['GameID'] = $game['Game']['id'];
        }
        $gamesList = json_encode($arr);

        return $gamesList;
    }
     public function getMatchUpdateList($teamId=null)
    {
        $user = AuthComponent::user();
        $this->layout = false;
        $this->loadModel('Game');
        $this->Game->UnbindModel([
            'hasMany' => [
                'Team'
            ]
        ], false);
           $today= date('Y-m-d');
          $enddate = date('Y-m-d H:i:s');
          $secondenddate=date('Y-m-d H:i:s',strtotime( '+20 second' ));
          $predictiondate = date('Y-m-d H:i:s',strtotime('1 hour'));
          $predictionenddate = date('Y-m-d H:i:s',strtotime('62 minutes'));
          $leagueId = $this->Auth->Session->read('Auth.User.sportSession.league_id');
          $sportId = $this->Auth->Session->read('Auth.User.sportSession.sport_id');
          $teamId = $this->Auth->Session->read('Auth.User.sportSession.team_id');
        $tournamentId = $this->Auth->Session->read('Auth.User.sportSession.tournament_id');
        $this->Game->UnbindModel([
            'hasMany' => [
                'Team'
            ]
        ], false);
        $gameDetails = $this->Game->find('first', [
            'conditions' => [
                'Game.play_status' => 0,
                'Game.tournament_id' => $tournamentId,
                'Game.league_id ' =>$leagueId,
                'Game.sport_id' => $sportId,
                'date(Game.start_time)' =>$today,
                'OR' => array(
                'Game.first_team' => $teamId,
                'Game.second_team' => $teamId
                ),
            //    array(
       // '(Game.start_time) BETWEEN ? AND ?' => array($predictiondate, $predictionenddate), 
   // )
            ],
            'fields' => [
                'Game.id',
                'Game.start_time',
                'Game.end_time'
            ]
        ]);
       // pr($gameDetails);exit;
if(!empty($gameDetails)){
        $gameStatus = $this->Game->find('first', [
            'conditions' => [
                'Game.play_status' => 0,
                'Game.tournament_id' => $tournamentId,
                'Game.league_id ' =>$leagueId,
                'Game.sport_id' => $sportId,
                //'Game.start_time <=' => $predictiondate,
                'OR' => array(
                'Game.first_team' => $teamId,
                'Game.second_team' => $teamId
                ),
                array(
        '(Game.start_time) BETWEEN ? AND ?' => array($predictiondate, $gameDetails['Game']['end_time']), 
    )
            ],
            'fields' => [
                'Game.id',
                'Game.start_time'
            ]
        ]);
    }
 /*    $date = new DateTime($gameDetails['Game']['start_time']);
        $date->sub(new DateInterval('PT1H'));
        $gamestarttime=$date->format('Y-m-d H:i:s') . "\n";
        //echo $d;exit;
        $gameStatus = $this->Game->find('first', [
            'conditions' => [
                'Game.play_status' => 0,
                'Game.tournament_id' => $tournamentId,
                'Game.league_id ' =>$leagueId,
                'Game.sport_id' => $sportId,
                //'Game.start_time <=' => $predictiondate,
                'OR' => array(
                'Game.first_team' => $teamId,
                'Game.second_team' => $teamId
                ),
 array(
        '(Game.start_time) BETWEEN ? AND ?' => array($gamestarttime, $gameDetails['Game']['end_time']), 
        //'Game.start_time <=' => $predictiondate,
        //'Game.start_time >=' => $gameDetails['Game']['end_time'],

    )
            ],
            'fields' => [
                'Game.id',
                'Game.start_time'
            ]
        ]);
       // pr($gameDetails);
         //pr($gameStatus);
    }*/
        //pr($gameStatus);exit;
        $gameEndStatus = $this->Game->find('first', [
            'conditions' => [
                'Game.play_status' => 1,
                'Game.tournament_id' => $tournamentId,
                'Game.league_id ' =>$leagueId,
                'Game.sport_id' => $sportId,
                'Game.end_time <=' => $enddate,
                'OR' => array(
                'Game.first_team' => $teamId,
                'Game.second_team' => $teamId
                ),
                 // array(
        //'(Game.end_time) BETWEEN ? AND ?' => array( $enddate, $secondenddate), 
   // )
            ],
            'fields' => [
                'Game.id',
                'Game.end_time'
            ]
        ]);
     //pr($gameEndStatus);
      if(!empty($gameStatus) || (!empty($gameEndStatus)))
      {
        $return= 1;
      }else
      {
        $return= 0;
      }
      echo ($return);
        die();

    }

    public function getChatUpdate()
    {
        $user = AuthComponent::user();
        $this->layout = false;

        $this->Chat->bindModel([
            'belongsTo' => [
                'User'
            ]
        ], false);
        $options['conditions'] = [
            'Chat.chatroom_id' => base64_decode($_POST['id']),
            'Chat.created >' => $_POST['lastMessageTime']
        ];
        $options['order'] = 'Chat.created ASC';
        $options['fields'] = [
            'Chat.*',
            'User.id',
            'User.name',
            'User.file_id'
        ];
        $chats = $this->Chat->find('all', $options);
        $this->loadModel('File');

        $script = '';
        foreach ($chats as $chat)
        {
            $file = $this->File->findById($chat['User']['file_id']);
            $timeElapsed = humanTiming(strtotime($chat['Chat']['created']));
            $pull_right = ($chat['User']['id'] == AuthComponent::user('id')) ? 'pull-right' : '';
            $my_txt = ($chat['User']['id'] == AuthComponent::user('id')) ? 'my-txt' : '';

            if (empty($file))
            {
                $file['File']['path'] = '/img/default_profile.png';
            }

            $script .= <<<EOD
<div class="chat-rpt">
            <div class="chat-usr-dtl {$pull_right}">
                <div class="chat-avtar">
                    <img src="{$file['File']['path']}" alt="chat user" title="chat user" />
                </div>
                <div class="chat-user">
                    <h4>{$chat['User']['name']} </h4>
                    <p>{$timeElapsed} ago </p>
                </div>
            </div>
            <div class="chat-desc {$my_txt}">
                {$chat['Chat']['name']}
            </div>
</div>
EOD;
            $lastMessage = $chat['Chat']['created'];
        }

        if (empty($script))
        {
            $return = [
                'status' => 0,
                'html' => ''
            ];
        }
        else
        {
            $return = [
                'status' => 1,
                'html' => $script,
                'lm' => $lastMessage
            ];
        }

        echo json_encode($return);
        die();
    }

    /**
     * viewChatHistory method
     *
     * @param null|mixed $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function viewChatHistory($id = null)
    {
        $chatId = base64_decode($id);
        $this->loadModel('Chatroom');
        if ($this->request->is('get'))
        {
            if (! $this->Chatroom->exists($chatId))
            {
                $this->Flash->error(__('Invalid Chatroom'));
            }
        }

        $options = [];
        $getdate = new DateTime('30 days ago');
        $chatAfterDate = $getdate->format('Y-m-d h:i:s');
        $this->Chat->bindModel([
            'belongsTo' => [
                'User'
            ]
        ], false);
        // $options = array("Chat.chatroom_id" => $chatId,"Chat.user_id" => AuthComponent::user('id'), "Chat.created >" => $chatAfterDate);
        $options = [
            'Chat.chatroom_id' => $chatId,
            'Chat.created >' => $chatAfterDate
        ];
        $order = 'Chat.created DESC';
        $this->paginate = [
            'contain' => false,
            'conditions' => $options,
            'order' => $order,
            'limit' => LIMIT,
            'fields' => [
                'Chat.*',
                'User.name',
                'User.file_id'
            ]
        ];
        $this->set('chats', $this->Paginator->paginate('Chat'));
    }

    public function maximize_chat($id = null)
    {
        $gameList = $this->getMatchList();
        $this->set(compact('gameList'));
    }
}
