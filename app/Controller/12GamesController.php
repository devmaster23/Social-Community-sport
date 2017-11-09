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
    public $components = ['Paginator', 'Flash', 'Session'];
    public $helpers    = ['Common', 'Chat', 'Text', 'Html'];
    public $uses       = ['GiftCategory', 'Location', 'Game'];

    /**
     * _before filter method
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();

        $this->Auth->allow('getTournamentsAjax', 'getLeaguesAjax', 'getTeamsAjax', 'getTeamsFilterAjax', 'checkleaguedate', 'checkdate');
        $this->View = new View($this, FALSE);
        $gift_cat = $this->GiftCategory->find('list');
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
            'contain' => FALSE,
            'limit' => LIMIT,
            'conditions' => $conditions,
            'order' => $order
        ];
        $this->set('games', $this->paginate('Game'));

        $tournamentConditions = FALSE;
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
                    {
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

        $this->index($conditions, [
            'FIELD(Game.created,Game.status) DESC'
        ]);
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
    public function admin_edit($id = null) {
                $this->set('title_for_layout', 'Update Game');
        $id = base64_decode($id);
        if (!$this->Game->exists($id)) {
            throw new NotFoundException(__('Invalid league'));
        }
        if ($this->request->is(['post', 'put'])) {
                    unset($this->request->data['stdate']);
                    unset($this->request->data['enddate']);

            if ($this->Game->save($this->request->data)) {
                $this->Flash->success(__('The league has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
                $this->Flash->error(__('The league could not be saved. Please, try again.'));

        } else {
            $options = ['conditions' => ['Game.' . $this->Game->primaryKey => $id]];
            $this->request->data = $this->Game->find('first', $options);

        }

        $leagues = $this->Game->League->find('list',['conditions'=>['League.tournament_id'=>$this->request->data['League']['tournament_id'], 'League.is_deleted'=>0], 'order'=>'League.name']);
                $sports = $this->Game->Sport->find('list',['order'=>'Sport.name']);
        $tournaments = $this->Game->Tournament->find('list',['conditions'=>['Tournament.status'=>1, 'Tournament.is_deleted'=>0, 'Tournament.sport_id'=>$this->request->data['Sport']['id']], 'order'=>'Tournament.name']);
        $teams = $this->Game->Team->find('list',['conditions'=>['Team.status'=>1, 'Team.is_deleted'=>0, 'Team.sport_id'=>$this->request->data['Sport']['id'], 'Team.tournament_id'=>$this->request->data['Tournament']['id'], 'Team.league_id'=>$this->request->data['League']['id']], 'order'=>'Team.name']);
        $this->set(compact('tournaments', 'sports','teams','leagues'));
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
        $this->layout = FALSE;
        $this->autoRender = FALSE;
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
            'label' => FALSE,
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
        $this->layout = FALSE;
        $this->autoRender = FALSE;
        $id = base64_decode($id);
        $options = $this->Game->League->find('list', [
            'conditions' => [
                'League.tournament_id' => $id,
                'League.end_date >=' => date('Y-m-d h:i:s'),
                'League.is_deleted' => 0
            ],
            'order' => 'League.name'
        ]);
        echo $this->View->Form->input('Game.league_id', [
            'class' => 'form-control',
            'label' => FALSE,
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
        $this->layout = FALSE;
        $this->autoRender = FALSE;
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
            'label' => FALSE,
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
        $this->layout = FALSE;
        $this->autoRender = FALSE;
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
            'label' => FALSE,
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
            $maxDays = date('Y-m-d', strtotime('+10 dayas'));
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
                'Game.league_id' => AuthComponent::User('sportSession.league_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status' => 1,
                'Game.end_time >' => date('Y-m-d h:i:s'),
                'OR' => [
                    'Game.first_team' => AuthComponent::User('sportSession.team_id'),
                    'Game.second_team' => AuthComponent::User('sportSession.team_id')
                ]
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
     * scheduleDownload method
     *
     * @return void
     */
    public function scheduleDownload()
    {
        $this->autoRender = FALSE;
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
                'bold' => TRUE
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
                'bold' => TRUE
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
            $maxDays = date('Y-m-d', strtotime('+10 dayas'));
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
                'Game.league_id' => AuthComponent::User('sportSession.league_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status' => 1,
                'Game.end_time >' => date('Y-m-d h:i:s'),
                'OR' => [
                    'Game.first_team' => AuthComponent::User('sportSession.team_id'),
                    'Game.second_team' => AuthComponent::User('sportSession.team_id')
                ]
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
            $maxDays = date('Y-m-d', strtotime('+10 dayas'));
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
                'Game.league_id' => AuthComponent::User('sportSession.league_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status' => 1,
                'Game.end_time >' => date('Y-m-d h:i:s'),
                'OR' => [
                    'Game.first_team' => AuthComponent::User('sportSession.team_id'),
                    'Game.second_team' => AuthComponent::User('sportSession.team_id')
                ]
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
    public function footballPrediction($gameId = null, $leagueId = null, $tournamentId = null, $sportId = null)
    {
        $this->layout = '';
        $this->loadModel('FootballPrediction');
        $this->set(compact('sportId', 'leagueId', 'tournamentId', 'gameId'));
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['FootballPrediction']['type']);
            unset($this->request->data['FootballPrediction']['location_id']);
            unset($this->request->data['FootballPrediction']['gift_category_id']);
            $this->request->data['FootballPrediction']['user_id'] = AuthComponent::User('id');

            if ($this->FootballPrediction->save($this->request->data))
            {
                $this->Flash->success(__('Prediction has been saved.'));
                return $this->redirect([
                    'controller' => 'games',
                    'action' => 'footballScheduling'
                ]);
            }
            $this->Flash->error(__('Prediction could not be saved. Please, try again.'));
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
    public function findSoccerPrediction($gameId = null, $firstTeam = null, $secondTeam = null)
    {
        $this->layout = '';
        $userId = $this->Session->read('Auth.User.id');
        $this->loadModel('SoccerPrediction');
        $gameId = base64_decode($gameId);
        $firstTeam = base64_decode($firstTeam);
        $secondTeam = base64_decode($secondTeam);
        $dataExist = $this->SoccerPrediction->find('first', [
            'conditions' => [
                'SoccerPrediction.game_id' => $gameId,
                'SoccerPrediction.user_id' => $userId
            ]
        ]);
        $this->set(compact('dataExist', 'firstTeam', 'secondTeam'));
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
        $this->_checkSportSession();
        $this->Game->unbindModel([
            'hasMany' => [
                'Team'
            ]
        ]);
        $this->loadModel('SoccerPrediction');
        $this->set('title_for_layout', __('Soccer Scheduling'));
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
            $today = date('Y-m-d');
            $maxDays = date('Y-m-d', strtotime('+10 dayas'));
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
                'Game.league_id' => AuthComponent::User('sportSession.league_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status' => 1,
                'Game.end_time >' => date('Y-m-d h:i:s'),
                'OR' => [
                    'Game.first_team' => AuthComponent::User('sportSession.team_id'),
                    'Game.second_team' => AuthComponent::User('sportSession.team_id')
                ]
            ];
            $this->paginate = [
                'limit' => 25,
                'conditions' => $conditions,
                'fields' => $fields
            ];
            $gameDatas = $this->Paginator->paginate('Game');
            // $gameDatas = $this->Game->find('all', array('conditions' => $conditions, 'fields' => $fields));
        }
        else
        {
            $gameDatas = '';
        }
        $this->set(compact('gameDatas'));
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
    public function soccerPrediction($gameId = null, $leagueId = null, $tournamentId = null, $sportId = null)
    {
        $this->layout = '';
        $this->loadModel('SoccerPrediction');
        $this->set(compact('sportId', 'leagueId', 'tournamentId', 'gameId'));
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['SoccerPrediction']['type']);
            unset($this->request->data['SoccerPrediction']['location_id']);
            unset($this->request->data['SoccerPrediction']['gift_category_id']);
            // pr($this->request->data); die;
            $this->request->data['SoccerPrediction']['user_id'] = AuthComponent::User('id');

            if ($this->SoccerPrediction->save($this->request->data))
            {
                $this->Flash->success(__('Prediction has been saved.'));
                return $this->redirect([
                    'controller' => 'games',
                    'action' => 'soccerScheduling'
                ]);
            }
            $this->Flash->error(__('Prediction could not be saved. Please, try again.'));
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
    public function findFootballPrediction($gameId = null, $firstTeam = null, $secondTeam = null)
    {
        $this->layout = '';
        $userId = $this->Session->read('Auth.User.id');
        $this->loadModel('FootballPrediction');
        $gameId = base64_decode($gameId);
        $firstTeam = base64_decode($firstTeam);
        $secondTeam = base64_decode($secondTeam);
        $dataExist = $this->FootballPrediction->find('first', [
            'conditions' => [
                'FootballPrediction.game_id' => $gameId,
                'FootballPrediction.user_id' => $userId
            ]
        ]);
        $this->set(compact('dataExist', 'firstTeam', 'secondTeam'));
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
            $maxDays = date('Y-m-d', strtotime('+10 dayas'));
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
                'Game.league_id' => AuthComponent::User('sportSession.league_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status' => 1,
                'Game.end_time >' => date('Y-m-d h:i:s'),
                'OR' => [
                    'Game.first_team' => AuthComponent::User('sportSession.team_id'),
                    'Game.second_team' => AuthComponent::User('sportSession.team_id')
                ]
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
    public function hockeyPrediction($gameId = null, $leagueId = null, $tournamentId = null, $sportId = null)
    {
        $this->layout = '';
        $this->loadModel('HockeyPrediction');
        $this->set(compact('sportId', 'leagueId', 'tournamentId', 'gameId'));
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['HockeyPrediction']['type']);
            unset($this->request->data['HockeyPrediction']['location_id']);
            unset($this->request->data['HockeyPrediction']['gift_category_id']);
            // pr($this->request->data); die;
            $this->request->data['HockeyPrediction']['user_id'] = AuthComponent::User('id');

            if ($this->HockeyPrediction->save($this->request->data))
            {
                $this->Flash->success(__('Prediction has been saved.'));
                return $this->redirect([
                    'controller' => 'games',
                    'action' => 'hockeyScheduling'
                ]);
            }
            $this->Flash->error(__('Prediction could not be saved. Please, try again.'));
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
    public function findHockeyPrediction($gameId = null, $firstTeam = null, $secondTeam = null)
    {
        $this->layout = '';
        $userId = $this->Session->read('Auth.User.id');
        $this->loadModel('HockeyPrediction');
        $gameId = base64_decode($gameId);
        $firstTeam = base64_decode($firstTeam);
        $secondTeam = base64_decode($secondTeam);

        $dataExist = $this->HockeyPrediction->find('first', [
            'conditions' => [
                'HockeyPrediction.game_id' => $gameId,
                'HockeyPrediction.user_id' => $userId
            ]
        ]);
        $this->set(compact('dataExist', 'firstTeam', 'secondTeam'));
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
        $this->set('title_for_layout', __('Basketball Scheduling'));
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
            $maxDays = date('Y-m-d', strtotime('+10 dayas'));
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
                'Game.league_id' => AuthComponent::User('sportSession.league_id'),
                'Game.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Game.status' => 1,
                'Game.end_time >' => date('Y-m-d h:i:s'),
                'OR' => [
                    'Game.first_team' => AuthComponent::User('sportSession.team_id'),
                    'Game.second_team' => AuthComponent::User('sportSession.team_id')
                ]
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
    public function basketballPrediction($gameId = null, $leagueId = null, $tournamentId = null, $sportId = null)
    {
        $this->layout = '';
        $this->loadModel('BasketballPrediction');
        $this->set(compact('sportId', 'leagueId', 'tournamentId', 'gameId'));
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['BasketballPrediction']['type']);
            unset($this->request->data['BasketballPrediction']['location_id']);
            unset($this->request->data['BasketballPrediction']['gift_category_id']);
            $this->request->data['BasketballPrediction']['user_id'] = AuthComponent::User('id');

            if ($this->BasketballPrediction->save($this->request->data))
            {
                $this->Flash->success(__('Prediction has been saved.'));
                return $this->redirect([
                    'controller' => 'games',
                    'action' => 'basketballScheduling'
                ]);
            }
            $this->Flash->error(__('Prediction could not be saved. Please, try again.'));
        }
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
    public function findBasketballPrediction($gameId = null, $firstTeam = null, $secondTeam = null)
    {
        $this->layout = '';
        $userId = $this->Session->read('Auth.User.id');
        $this->loadModel('BasketballPrediction');
        $gameId = base64_decode($gameId);
        $firstTeam = base64_decode($firstTeam);
        $secondTeam = base64_decode($secondTeam);
        $dataExist = $this->BasketballPrediction->find('first', [
            'conditions' => [
                'BasketballPrediction.game_id' => $gameId,
                'BasketballPrediction.user_id' => $userId
            ]
        ]);
        $this->set(compact('dataExist', 'firstTeam', 'secondTeam'));
    }

    /**
     * admin_cricketPrediction method
     * list predictions
     *
     * @return void
     */
    public function admin_cricketPrediction()
    {
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
        // pr($cricket);
        $this->set(compact('cricket'));
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
            'conditions',
            [
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
     * @return void
     */
    public function admin_soccerPrediction()
    {
        $this->loadModel('SoccerPrediction');
        $soccer = $this->SoccerPrediction->find('all', [
            'conditions',
            [
                'SoccerPrediction.id' => $this->SoccerPrediction->id
            ],
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
        $this->set(compact('soccer'));
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
            'conditions',
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
        $this->autoRender = FALSE;
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
                'admin' => TRUE
            ]);
        }
    }

    /**
     * admin_footballPrediction method
     * list predictions
     *
     * @return void
     */
    public function admin_footballPrediction()
    {
        $this->loadModel('FootballPrediction');
        $football = $this->FootballPrediction->find('all', [
            'conditions',
            [
                'FootballPrediction.id' => $this->FootballPrediction->id
            ],
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
        $this->set(compact('football'));
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
        $this->autoRender = FALSE;
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
                'admin' => TRUE
            ]);
        }
    }

    /**
     * admin_footballPrediction method
     * list predictions
     *
     * @return void
     */
    public function admin_hockeyPrediction()
    {
        $this->loadModel('HockeyPrediction');
        $hockey = $this->HockeyPrediction->find('all', [
            'conditions',
            [
                'HockeyPrediction.id' => $this->HockeyPrediction->id
            ],
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
        $this->set(compact('hockey'));
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
            'conditions',
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
        $this->autoRender = FALSE;
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
                'admin' => TRUE
            ]);
        }
    }

    /**
     * admin_baseballPrediction method
     * list predictions
     *
     * @return void
     */
    public function admin_baseballPrediction()
    {
        $this->loadModel('BaseballPrediction');
        $baseball = $this->BaseballPrediction->find('all', [
            'conditions',
            [
                'BaseballPrediction.id' => $this->BaseballPrediction->id
            ],
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
        // pr($baseball);
        $this->set(compact('baseball'));
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
        $this->autoRender = FALSE;
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
                'admin' => TRUE
            ]);
        }
    }

    /**
     * admin_basketballPrediction method
     * list predictions
     *
     * @return void
     */
    public function admin_basketballPrediction()
    {
        $this->loadModel('BasketballPrediction');
        $basketball = $this->BasketballPrediction->find('all', [
            'conditions',
            [
                'BasketballPrediction.id' => $this->BasketballPrediction->id
            ],
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
        $this->set(compact('basketball'));
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
            'conditions',
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
        $this->autoRender = FALSE;
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
                'admin' => TRUE
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
        $this->autoRender = FALSE;
        $this->loadModel($modelName);
        $this->$modelName->id = base64_decode($id);
        $this->$modelName->unbindModel([
            'belongsTo' => [
                'Sport',
                'League',
                'Tournament',
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
                'admin' => TRUE
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
        $this->autoRender = FALSE;
        $this->loadModel('Chatroom');
        $this->loadModel('Locale');
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
        $languages = $this->Locale->find('list');
        foreach ($languages as $language):
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
        endforeach;
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
        $this->autoRender = FALSE;
        $this->loadModel('Chatroom');
        $this->loadModel('Locale');
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

    /**
     * **************************** Currency Converter start ***********************
     */

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

    /**
     * **************************** Currency Converter end ***********************
     */
    public function admin_checkleaguedate()
    {
        $this->layout = FALSE;
        $this->autoRender = FALSE;
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

    public function admin_checkdate()
    {
        $this->layout = FALSE;
        $this->autoRender = FALSE;
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
        $this->layout = FALSE;
        $this->autoRender = FALSE;
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
        $this->layout = FALSE;
        $this->autoRender = FALSE;
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
        }
    }
}

