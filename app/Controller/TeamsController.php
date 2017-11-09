<?php
App::uses('AppController', 'Controller');

/**
 * Teams Controller
 *
 * @property Team $Team
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class TeamsController extends AppController
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

    /**
     * beforeFilter method
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        // $this->Auth->allow("getTournamentsAjax","getLeaguesAjax","getTeamAdminAjax");
        $this->Auth->allow('getTournamentsAjax', 'getLeaguesAjax', 'getTeamAdminAjax', 'getExistingTeamAjax', 'getModerator', 'getModeratorAjax');
        $this->View = new View($this, false);
    }

    /**
     * _getSearchConditions method
     *
     * @return searched results
     */
    public function _getSearchConditions()
    {
        $input = $_GET;
        $model = 'Team';

        $items = [];
        $conditions = [
            'Team.is_deleted' => 0,
            'Team.status' => [
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
                'Team' => $input
            ];
        }

        if (AuthComponent::user('role_id') == 2)
        {
            $conditions[$model . '.' . 'sport_id'] = AuthComponent::user('SportInfo.Sport.id');
        }
        else
            if (AuthComponent::user('role_id') == 3)
            {
                $conditions[$model . '.' . 'sport_id'] = AuthComponent::user('SportInfo.League.sport_id');
                $conditions[$model . '.' . 'league_id'] = AuthComponent::user('SportInfo.League.id');
            }

        // $conditions[$model.'.'.'status'] = 1;
        return $conditions;
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
        $this->Team->recursive = 0;
        $this->paginate = [
            'contain' => false,
            'limit' => LIMIT,
            'conditions' => $conditions,
            'order' => $order
        ];

        $this->set('teams', $this->paginate('Team'));

        $tournamentConditions = false;
        $tournaments = $this->Team->Tournament->find('list', [
            'conditions' => [
                'Tournament.is_deleted' => 0,
                'Tournament.status' => 1
            ]
        ]);
        if (AuthComponent::user('role_id') == 2)
        {
            $tournamentConditions = [
                'Tournament.sport_id' => AuthComponent::user('SportInfo.Sport.id'),
                'Tournament.is_deleted' => 0,
                'Tournament.status' => 1
            ];
            $tournaments = $this->Team->Tournament->find('list', [
                'conditions' => $tournamentConditions
            ]);
        }

        if (AuthComponent::user('role_id') == 3)
        {
            $tournamentConditions = [
                'Tournament.sport_id' => AuthComponent::user('SportInfo.League.sport_id'),
                'Tournament.is_deleted' => 0,
                'Tournament.status' => 1
            ];
            $tournaments = $this->Team->Tournament->find('list', [
                'conditions' => $tournamentConditions
            ]);
        }
        $this->set(compact('tournaments'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'List Teams');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, [
            'FIELD(Team.created,Team.status) DESC'
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
        $this->set('title_for_layout', 'View Team');
        $id = base64_decode($id);
        if (! $this->Team->exists($id))
        {
            throw new NotFoundException(__('Invalid team'));
        }
        $options = [
            'conditions' => [
                'Team.' . $this->Team->primaryKey => $id
            ]
        ];
        $this->set('team', $this->Team->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    // public function admin_add() {
    // $this->set('title_for_layout', 'Add Team');
    // $this->loadModel('League');
    // $this->loadModel('UserTeam');
    // if ($this->request->is('post')) {
    //
    // $limitCheck = $this->_getTeamInLeagueLimit($this->request->data['Team']['league_id']);
    // if(!empty($limitCheck)) {
    // $this->Flash->success(__($limitCheck));
    // return $this->redirect(array('action' => 'add'));
    // }
    //
    // $this->Team->create();
    // if ($this->Team->save($this->request->data)) {
    // $this->Flash->success(__('The team has been saved.'));
    // return $this->redirect(array('action' => 'index'));
    // } else {
    // $this->Flash->error(__('The team could not be saved. Please, try again.'));
    // }
    // }
    // $sports = $this->Team->Sport->find('list',array('order'=>'Sport.name'));
    // $existingTeamAdmin = $this->UserTeam->find('list');
    // $this->set(compact('sports', 'leagues'));
    // }
    public function admin_add()
    {
        $this->set('title_for_layout', 'Add Team');
        $this->loadModel('League');
        $this->loadModel('UserTeam');
        if ($this->request->is('post'))
        {
            if ($this->request->data['Team']['optionid'] == 2)
            {
                $this->request->data['Team']['name'] = $this->request->data['Team']['name1'];
                $this->request->data['Team']['status'] = $this->request->data['Team']['status1'];
                $this->request->data['Team']['user_id'] = $this->request->data['Team']['user_id1'];
                unset($this->Team->validate['name']);
            }

            $limitCheck = $this->_getTeamInLeagueLimit($this->request->data['Team']['league_id']);
            if (! empty($limitCheck))
            {
                $this->Flash->success(__($limitCheck));
                return $this->redirect([
                    'action' => 'add'
                ]);
            }

            $this->Team->create();
            if ($this->Team->save($this->request->data))
            {
                $this->Flash->success(__('The team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The team could not be saved. Please, try again.'));
        }
        $sports = $this->Team->Sport->find('list', [
            'order' => 'Sport.name'
        ]);
        $existingTeamAdmin = $this->UserTeam->find('list');
        $this->set(compact('sports', 'leagues'));
    }

    /**
     * _getTeamInLeagueLimit method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return int
     */
    public function _getTeamInLeagueLimit($id = null)
    {
        $this->League->id = $id;
        $maxNoOfTeamInLeague = $this->League->field('no_of_teams');
        $teamInLeagueCount = $this->Team->find('count', [
            'conditions' => [
                'Team.is_deleted' => 0,
                'Team.league_id' => $id
            ]
        ]);
        if ($teamInLeagueCount >= $maxNoOfTeamInLeague)
        {
            return 'You can not add teams more then ' . $maxNoOfTeamInLeague . ' in this league';
        }
        return '';
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
        $this->set('title_for_layout', 'Update Team');
        $id = base64_decode($id);
        if (! $this->Team->exists($id))
        {
            throw new NotFoundException(__('Invalid team'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->Team->save($this->request->data))
            {
                $this->Flash->success(__('The team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The team could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'Team.' . $this->Team->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Team->find('first', $options);
        }

        $existingTeamAdmin = $this->Team->find('list', [
            'conditions' => [
                'Team.user_id NOT' => [
                    $this->data['Team']['user_id']
                ]
            ],
            'fields' => [
                'Team.user_id'
            ]
        ]);
        if (! empty($existingTeamAdmin))
        {
            $users = $this->User->find('list', [
                'conditions' => [
                    'User.role_id' => 4,
                    'User.id NOT' => $existingTeamAdmin
                ]
            ]);
        }
        else
        {
            $users = $this->User->find('list', [
                'conditions' => [
                    'User.role_id' => 4
                ]
            ]);
        }

        /* start */
        $sportId = $this->Team->find('first', [
            'conditions' => [
                'Team.id' => $id
            ],
            'fields' => [
                'Team.sport_id'
            ]
        ]);
        $sports = $this->Team->Sport->find('list', [
            'conditions' => [
                'Sport.id' => $sportId['Team']['sport_id']
            ]
        ]);
        $tournaments = $this->Team->Tournament->find('list', [
            'conditions' => [
                'Tournament.sport_id' => $sportId['Team']['sport_id'],
                'Tournament.is_deleted' => 0,
                'Tournament.status' => 1
            ]
        ]);

        $leagues = $this->Team->League->find('list', [
            'conditions' => [
                'League.sport_id' => $sportId['Team']['sport_id'],
                'League.is_deleted' => 0,
                'League.status' => 1,
                'League.end_date >=' => date('Y-m-d h:i:s'),
                'League.tournament_id' => $this->request->data['Team']['tournament_id']
            ]
        ]);

        $this->set(compact('sports', 'leagues', 'users', 'tournaments'));
    }

    /**
     * admin_delete method
     *
     * @param string     $id
     * @param null|mixed $tournamentId
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_delete($id = null, $tournamentId = null)
    {
        $this->set('title_for_layout', 'Delete Team');
        $this->Team->id = base64_decode($id);
        $tournamentId = base64_decode($tournamentId);
        if (! $this->Team->exists())
        {
            throw new NotFoundException(__('Invalid team'));
        }
        $this->_deleteTeam($this->Team->id, $tournamentId);
    }

    /**
     * sports_index method
     *
     * @return void
     */
    public function sports_index()
    {
        $this->set('title_for_layout', 'List Teams');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'Team.created DESC');
    }

    /**
     * sports_add method
     *
     * @return void
     */
    public function sports_add()
    {
        $this->set('title_for_layout', 'Add Team');
        $this->loadModel('League');
        if ($this->request->is('post'))
        {

            if ($this->request->data['Team']['optionid'] == 2)
            {
                $this->request->data['Team']['name'] = $this->request->data['Team']['name1'];
                $this->request->data['Team']['status'] = $this->request->data['Team']['status1'];
                $this->request->data['Team']['user_id'] = $this->request->data['Team']['user_id1'];
                unset($this->Team->validate['name']);
            }

            $limitCheck = $this->_getTeamInLeagueLimit($this->request->data['Team']['league_id']);
            if (! empty($limitCheck))
            {
                $this->Flash->success(__($limitCheck));
                return $this->redirect([
                    'action' => 'add'
                ]);
            }

            $this->Team->create();
            $this->request->data['Team']['sport_id'] = AuthComponent::user('SportInfo.Sport.id');
            if ($this->Team->save($this->request->data))
            {
                $this->Flash->success(__('The team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The team could not be saved. Please, try again.'));
        }

        $tournaments = $this->Team->Tournament->find('list', [
            'conditions' => [
                'Tournament.sport_id' => AuthComponent::user('SportInfo.Sport.id'),
                'Tournament.status' => 1,
                'Tournament.is_deleted' => 0
            ],
            'order' => 'Tournament.name'
        ]);
        $assignedUsers = $this->Team->find('list', [
            'conditions' => [
                'Team.status' => 1
            ],
            'fields' => [
                'Team.user_id',
                'Team.user_id'
            ]
        ]);

        $users = $this->Team->User->find('list', [
            'conditions' => [
                'NOT' => [
                    'User.id' => $assignedUsers
                ],
                'User.role_id' => 4
            ]
        ]);
        $this->set(compact('tournaments', 'users'));
    }

    /**
     * sports_edit method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_edit($id = null)
    {
        $this->set('title_for_layout', 'Update Team');
        $id = base64_decode($id);
        if (! $this->Team->exists($id))
        {
            throw new NotFoundException(__('Invalid team'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->Team->save($this->request->data))
            {
                $this->Flash->success(__('The team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The team could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'Team.' . $this->Team->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Team->find('first', $options);
        }

        // $tournaments = $this->Team->Tournament->find('list');
        $existingTeamAdmin = $this->Team->find('list', [
            'conditions' => [
                'Team.user_id NOT' => [
                    $this->data['Team']['user_id']
                ]
            ],
            'fields' => [
                'Team.user_id'
            ]
        ]);
        if (! empty($existingTeamAdmin))
        {
            $users = $this->User->find('list', [
                'conditions' => [
                    'User.role_id' => 4,
                    'User.id NOT' => $existingTeamAdmin
                ]
            ]);
        }
        else
        {
            $users = $this->User->find('list', [
                'conditions' => [
                    'User.role_id' => 4
                ]
            ]);
        }

        /* start */
        $sportId = $this->Team->find('first', [
            'conditions' => [
                'Team.id' => $id
            ],
            'fields' => [
                'Team.sport_id'
            ]
        ]);
        $tournaments = $this->Team->Tournament->find('list', [
            'conditions' => [
                'Tournament.sport_id' => $sportId['Team']['sport_id'],
                'Tournament.is_deleted' => 0,
                'Tournament.status' => 1
            ],
            'order' => 'Tournament.name'
        ]);

        $leagues = $this->Team->League->find('list', [
            'conditions' => [
                'League.sport_id' => $sportId['Team']['sport_id'],
                'League.is_deleted' => 0,
                'League.status' => 1,
                'League.end_date >=' => date('Y-m-d h:i:s'),
                'League.tournament_id' => $this->request->data['Team']['tournament_id']
            ]
        ]);
        // $leagues = $this->Team->League->find('list');
        // $sports = $this->Team->Sport->find('list');
        // $tournaments = $this->Team->Tournament->find('list');
        /* end */

        $this->set(compact('leagues', 'users', 'tournaments'));
    }

    /**
     * sports_delete method
     *
     * @param string     $id
     * @param null|mixed $tournamentId
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_delete($id = null, $tournamentId = null)
    {
        $this->set('title_for_layout', 'Delete Team');
        $this->Team->id = base64_decode($id);
        $tournamentId = base64_decode($tournamentId);
        if (! $this->Team->exists())
        {
            throw new NotFoundException(__('Invalid league'));
        }
        $this->_deleteTeam($this->Team->id, $tournamentId);
    }

    /**
     * sports_view method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_view($id = null)
    {
        $this->set('title_for_layout', 'View Team');
        $id = base64_decode($id);
        if (! $this->Team->exists($id))
        {
            throw new NotFoundException(__('Invalid team'));
        }
        $options = [
            'conditions' => [
                'Team.' . $this->Team->primaryKey => $id
            ]
        ];
        $this->set('team', $this->Team->find('first', $options));
    }

    /**
     * league_index method
     *
     * @return void
     */
    public function league_index()
    {
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'Team.created DESC');
    }

    /**
     * league_add method
     *
     * @return void
     */
    public function league_add()
    {
        $this->set('title_for_layout', 'Add Team');
        $this->loadModel('League');
        if ($this->request->is('post'))
        {
            $this->request->data['Team']['league_id'] = AuthComponent::user('SportInfo.League.id');
            $this->request->data['Team']['sport_id'] = AuthComponent::user('SportInfo.League.sport_id');
            $limitCheck = $this->_getTeamInLeagueLimit($this->request->data['Team']['league_id']);
            if (! empty($limitCheck))
            {
                $this->Flash->success(__($limitCheck));
                return $this->redirect([
                    'action' => 'add'
                ]);
            }
            $this->Team->create();
            if ($this->Team->save($this->request->data))
            {
                $this->Flash->success(__('The team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The team could not be saved. Please, try again.'));
        }

        $tournaments = $this->Team->Tournament->find('list', [
            'conditions' => [
                'Tournament.sport_id' => AuthComponent::user('SportInfo.League.sport_id'),
                'Tournament.status' => 1,
                'Tournament.is_deleted' => 0
            ]
        ]);
        $assignedUsers = $this->Team->find('list', [
            'conditions' => [
                'Team.status' => 1
            ],
            'fields' => [
                'Team.user_id',
                'Team.user_id'
            ]
        ]);

        $users = $this->Team->User->find('list', [
            'conditions' => [
                'NOT' => [
                    'User.id' => $assignedUsers
                ],
                'User.role_id' => 4
            ]
        ]);

        $this->set(compact('tournaments', 'users'));
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
        $this->set('title_for_layout', 'Edit Team');
        $id = base64_decode($id);
        if (! $this->Team->exists($id))
        {
            throw new NotFoundException(__('Invalid team'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->Team->save($this->request->data))
            {
                $this->Flash->success(__('The team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The team could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'Team.' . $this->Team->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Team->find('first', $options);
        }

        // $tournaments = $this->Team->Tournament->find('list');
        $existingTeamAdmin = $this->Team->find('list', [
            'conditions' => [
                'Team.user_id NOT' => [
                    $this->data['Team']['user_id']
                ]
            ],
            'fields' => [
                'Team.user_id'
            ]
        ]);
        if (! empty($existingTeamAdmin))
        {
            $users = $this->User->find('list', [
                'conditions' => [
                    'User.role_id' => 4,
                    'User.id NOT' => $existingTeamAdmin
                ]
            ]);
        }
        else
        {
            $users = $this->User->find('list', [
                'conditions' => [
                    'User.role_id' => 4
                ]
            ]);
        }

        /* start */
        $sportId = $this->Team->find('first', [
            'conditions' => [
                'Team.id' => $id
            ],
            'fields' => [
                'Team.sport_id'
            ]
        ]);
        $tournaments = $this->Team->Tournament->find('list', [
            'conditions' => [
                'Tournament.sport_id' => $sportId['Team']['sport_id']
            ]
        ]);

        $leagues = $this->Team->League->find('list', [
            'conditions' => [
                'League.sport_id' => $sportId['Team']['sport_id'],
                'League.is_deleted' => 0,
                'League.status' => 1,
                'League.end_date >=' => date('Y-m-d h:i:s'),
                'League.tournament_id' => $this->request->data['Team']['tournament_id']
            ]
        ]);
        // $leagues = $this->Team->League->find('list');
        // $sports = $this->Team->Sport->find('list');
        // $tournaments = $this->Team->Tournament->find('list');
        /* end */

        $this->set(compact('leagues', 'users', 'tournaments'));
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
        $this->set('title_for_layout', 'View Team');
        $id = base64_decode($id);
        if (! $this->Team->exists($id))
        {
            throw new NotFoundException(__('Invalid team'));
        }
        $options = [
            'conditions' => [
                'Team.' . $this->Team->primaryKey => $id
            ]
        ];
        $this->set('team', $this->Team->find('first', $options));
    }

    /**
     * league_delete method
     *
     * @param string     $id
     * @param null|mixed $tournamentId
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function league_delete($id = null, $tournamentId = null)
    {
        $this->set('title_for_layout', 'Delete Team');
        $this->Team->id = base64_decode($id);
        $tournamentId = base64_decode($tournamentId);
        if (! $this->Team->exists())
        {
            throw new NotFoundException(__('Invalid league'));
        }
        $this->_deleteTeam($this->Team->id, $tournamentId);
    }

    /**
     * _deleteTeam method
     *
     * @param string     $id
     * @param null|mixed $teamId
     * @param null|mixed $tournamentId
     *
     * @return void
     */
    public function _deleteTeam($teamId = null, $tournamentId = null)
    {
        $this->loadModel('Game');
        $this->Team->id = $teamId;
        $tournamentGameStatus = $this->Game->find('count', [
            'conditions' => [
                'Game.tournament_id' => $tournamentId,
                'OR' => [
                    'Game.status' => 1,
                    'Game.end_time >' => date('Y-m-d h:i:s')
                ]
            ]
        ]);
        if (! $tournamentGameStatus)
        {
            $this->Flash->error(__('You can not delete active tournament team. Some game still has to play.'));
        }
        else
        {
            $this->Team->saveField('is_deleted', 1);
            $this->Team->saveField('deleted_by', AuthComponent::User('id'));
            $name = $this->Team->find('first', [
                'conditions' => [
                    'Team.id' => $teamId
                ],
                'fields' => [
                    'Team.name'
                ]
            ]);
            $this->request->data['Team']['name'] = $name['Team']['name'] . '-is-deleted';
            if ($this->Team->saveField('name', $this->request->data['Team']['name']) && $this->Team->saveField('status', 0))
            {
                $this->Flash->success(__('The team has been deleted.'));
            }
            else
                $this->Flash->error(__('The team could not be deleted. Please, try again.'));
        }

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
        $options = $this->Team->Tournament->find('list', [
            'conditions' => [
                'Tournament.sport_id' => $id,
                'Tournament.status' => 1,
                'Tournament.is_deleted' => 0
            ],
            'order' => 'Tournament.name'
        ]);
        echo $this->View->Form->input('Team.tournament_id', [
            'class' => 'form-control',
            'label' => false,
            'empty' => 'Please Select Tournament',
            'options' => $options,
            'onchange' => 'getLeagues(this);'
        ]);
    }

    /**
     * getTeamsAjax method
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
        $options = $this->Team->League->find('list', [
            'conditions' => [
                'League.tournament_id' => $id,
                'League.end_date >=' => date('Y-m-d h:i:s'),
                'League.is_deleted' => 0,
                'League.status' => 1
            ],
            'order' => 'League.name'
        ]);
        echo $this->View->Form->input('Team.league_id', [
            'class' => 'form-control',
            'label' => false,
            'empty' => '--Select League --',
            'options' => $options,
            'onchange' => 'getTeamAdmin(this);'
        ]);
    }

    /**
     * getTeamAdminAjax method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function getTeamAdminAjax($id = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('UserTeam');
        $this->loadModel('User');
        $id = base64_decode($id);

        $assignedUsers = $this->Team->find('list', [
            'conditions' => [
                'Team.status' => 1
            ],
            'fields' => [
                'Team.user_id',
                'Team.user_id'
            ]
        ]);

        $users = $this->Team->User->find('list', [
            'conditions' => [
                'NOT' => [
                    'User.id' => $assignedUsers
                ],
                'User.role_id' => 4
            ]
        ]);
        echo $this->View->Form->input('Team.user_id', [
            'class' => 'form-control',
            'label' => false,
            'empty' => '--Select Team Admin --',
            'options' => $users
        ]);
    }

    /**
     * getExistingTeamAjax method
     *
     * @param null|mixed $sportId
     * @param null|mixed $leagueId
     *
     * @return void
     */
    public function getExistingTeamAjax($sportId = null, $leagueId = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('Sport');
        $this->loadModel('Teams');

        $existingTeam = $this->Team->find('list', [
            'conditions' => [
                'Team.league_id' => $leagueId,
                'Team.status' => 1
            ],
            'fields' => [
                'Team.id',
                'Team.name'
            ]
        ]);
        if (! empty($existingTeam))
        {
            $conditions = [
                'Team.sport_id' => $sportId,
                'Team.league_id !=' => $leagueId,
                'Team.status' => 1,
                'NOT' => [
                    'Team.name' => $existingTeam
                ]
            ];
        }
        else
        {
            $conditions = [
                'Team.sport_id' => $sportId,
                'Team.league_id !=' => $leagueId,
                'Team.status' => 1
            ];
        }

        $existingTeam1 = $this->Team->find('list', [
            'conditions' => $conditions,
            'fields' => [
                'Team.name',
                'Team.name'
            ]
        ]);
        echo $this->View->Form->input('Team.name1', [
            'class' => 'form-control',
            'label' => false,
            'empty' => '--Select Team --',
            'options' => $existingTeam1,
            'onchange' => 'getModerator(this);'
        ]);
    }

    /**
     * getModeratorAjax method
     *
     * @param null|mixed $teamName
     *
     * @return void
     */
    public function getModeratorAjax($teamName = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('User');

        $userId = $this->Team->find('first', [
            'conditions' => [
                'Team.name' => $teamName
            ]
        ]);

        $UserName = $this->User->find('list', [
            'conditions' => [
                'User.id' => $userId['Team']['user_id']
            ],
            'fields' => [
                'User.id',
                'User.name'
            ]
        ]);

        echo $this->View->Form->input('Team.user_id1', [
            'class' => 'form-control',
            'label' => false,
            'empty' => '--Select Moderator --',
            'options' => $UserName
        ]);
    }
}
