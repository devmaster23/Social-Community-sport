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
class LeaguesController extends AppController
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
     * _index method
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('getTournamentsAjax');
        $this->View = new View($this, false);
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
        $this->League->recursive = 0;
        $this->paginate = [
            'contain' => false,
            'limit' => LIMIT,
            'conditions' => $conditions,
            'order' => $order
        ];
        $this->set('leagues', $this->paginate('League'));

        $tournamentConditions = false;
        $tournaments = $this->League->Tournament->find('list', [
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
            $tournaments = $this->League->Tournament->find('list', [
                'conditions' => $tournamentConditions
            ]);
        }
        $sports = $this->League->Sport->find('list', [
            'conditions' => [
                'Sport.status' => 1
            ]
        ]);
        $this->set(compact('tournaments', 'sports'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'List Leagues');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, [
            'FIELD(League.created,League.status) DESC'
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
        $this->set('title_for_layout', 'View League');
        $id = base64_decode($id);
        if (! $this->League->exists($id))
        {
            throw new NotFoundException(__('Invalid league'));
        }
        $options = [
            'conditions' => [
                'League.' . $this->League->primaryKey => $id
            ]
        ];
        $this->set('league', $this->League->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', 'Add League');
        if ($this->request->is('post'))
        {
            $this->League->create();
            if ($this->League->save($this->request->data))
            {
                $this->Flash->success(__('The league has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The league could not be saved. Please, try again.'));
        }
        $assignedUsers = $this->League->find('list', [
            'conditions' => [
                'League.status' => 1
            ],
            'fields' => [
                'League.user_id',
                'League.user_id'
            ]
        ]);

        $sports = $this->League->Sport->find('list', [
            'order' => 'Sport.name'
        ]);
        $users = $this->League->User->find('list', [
            'conditions' => [
                'NOT' => [
                    'User.id' => $assignedUsers
                ],
                'User.role_id' => 3
            ]
        ]);

        $this->set(compact('tournaments', 'sports', 'users'));
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
        $this->set('title_for_layout', 'Update League');
        $id = base64_decode($id);
        if (! $this->League->exists($id))
        {
            throw new NotFoundException(__('Invalid league'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->League->save($this->request->data))
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
                    'League.' . $this->League->primaryKey => $id
                ]
            ];
            $this->request->data = $this->League->find('first', $options);
        }
        $tournaments = $this->League->Tournament->find('list', [
            'conditions' => [
                'status' => 1,
                'is_deleted' => 0
            ]
        ]);
        /* start */
        $sportId = $this->League->find('first', [
            'conditions' => [
                'League.id' => $id
            ],
            'fields' => [
                'League.sport_id'
            ]
        ]);
        $sports = $this->Sport->find('list', [
            'conditions' => [
                'Sport.id' => $sportId['League']['sport_id']
            ]
        ]);

        /* end */

        $assignedUsers = $this->League->find('list', [
            'conditions' => [
                'League.status' => 1,
                'League.user_id !=' => $this->request->data['League']['user_id']
            ],
            'fields' => [
                'League.user_id',
                'League.user_id'
            ]
        ]);

        $users = $this->League->User->find('list', [
            'conditions' => [
                'NOT' => [
                    'User.id' => $assignedUsers
                ],
                'User.role_id' => 3
            ]
        ]);
        $orderArray = $this->League->find('list', [
            'conditions' => [
                'League.is_deleted' => 0,
                'League.order_number !=' => NULL,
                'League.sport_id' => $sportId['League']['sport_id']
            ],
            'fields' => [
                'League.order_number',
                'League.order_number'
            ]
        ]);
        $this->set(compact('tournaments', 'sports', 'users', 'sportId', 'orderArray'));
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
        $this->set('title_for_layout', 'Delete League');
        $this->League->id = base64_decode($id);
        if (! $this->League->exists())
        {
            throw new NotFoundException(__('Invalid league'));
        }
        $this->loadModel('Game');
        $status = $this->Game->find('count', [
            'conditions' => [
                'Game.league_id' => $this->League->id,
                'OR' => [
                    'Game.status' => 1,
                    'Game.end_time >' => date('Y-m-d h:i:s')
                ]
            ]
        ]);
        if ($status)
        {
            $this->Flash->error(__('You can not delete active league. Some game still has to play.'));
        }
        else
        {
            $this->League->saveField('is_deleted', 1);
            $this->League->saveField('deleted_by', AuthComponent::User('id'));
            $name = $this->League->find('first', [
                'conditions' => [
                    'League.id' => $this->League->id
                ],
                'fields' => [
                    'League.name'
                ]
            ]);
            $this->request->data['League']['name'] = $name['League']['name'] . '-is-deleted';
            if ($this->League->saveField('name', $this->request->data['League']['name']) && $this->League->saveField('status', 0))
                $this->Flash->success(__('The league has been deleted.'));
            else
                $this->Flash->error(__('The league could not be deleted. Please, try again.'));
        }

        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * _create_league method
     *
     * @return void
     */
    public function _create_league()
    {
        if ($this->request->is('post'))
        {
            $this->League->create();
            $this->request->data['League']['sport_id'] = AuthComponent::user('SportInfo.Sport.id');
            if ($this->League->save($this->request->data))
            {
                $this->Flash->success(__('The League has been saved.'));
                return [
                    'success' => 1,
                    'redirect' => [
                        'action' => 'index'
                    ]
                ];
            }
            $this->Flash->error(__('The League could not be saved. Please, try again.'));
            return [
                'success' => 0,
                'redirect' => false
            ];
        }

        $tournaments = $this->League->Tournament->find('list', [
            'conditions' => [
                'Tournament.sport_id' => AuthComponent::user('SportInfo.Sport.id'),
                'status' => 1,
                'is_deleted' => 0
            ],
            'order' => 'Tournament.name'
        ]);
        $assignedUsers = $this->League->find('list', [
            'conditions' => [
                'League.status' => 1
            ],
            'fields' => [
                'League.user_id',
                'League.user_id'
            ]
        ]);

        $users = $this->League->User->find('list', [
            'conditions' => [
                'NOT' => [
                    'User.id' => $assignedUsers
                ],
                'User.role_id' => 3
            ]
        ]);
        $this->set(compact('tournaments', 'sports', 'users'));
    }

    /**
     * sports_add method
     *
     * @return void
     */
    public function sports_add()
    {
        $this->set('title_for_layout', 'Add League');
        $return = $this->_create_league();
        if (isset($return['success']))
        {
            if ($return['success'])
            {
                $this->redirect($return['redirect']);
            }
        }
    }

    /**
     * sports_index method
     *
     * @return void
     */
    public function sports_index()
    {
        $this->set('title_for_layout', 'List Leagues');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'League.created DESC');
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
        $this->set('title_for_layout', 'Update League');
        $id = base64_decode($id);
        if (! $this->League->exists($id))
        {
            throw new NotFoundException(__('Invalid league'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->League->save($this->request->data))
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
                    'League.' . $this->League->primaryKey => $id
                ]
            ];
            $this->request->data = $this->League->find('first', $options);
        }
        $tournaments = $this->League->Tournament->find('list', [
            'conditions' => [
                'Tournament.sport_id' => AuthComponent::user('SportInfo.Sport.id'),
                'status' => 1,
                'is_deleted' => 0
            ],
            'order' => 'Tournament.name'
        ]);
        $assignedUsers = $this->League->find('list', [
            'conditions' => [
                'League.status' => 1,
                'League.user_id !=' => $this->request->data['League']['user_id']
            ],
            'fields' => [
                'League.user_id',
                'League.user_id'
            ]
        ]);

        $users = $this->League->User->find('list', [
            'conditions' => [
                'NOT' => [
                    'User.id' => $assignedUsers
                ],
                'User.role_id' => 3
            ]
        ]);
        $this->set(compact('tournaments', 'sports', 'users'));
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
        $this->set('title_for_layout', 'View League');
        $id = base64_decode($id);
        if (! $this->League->exists($id))
        {
            throw new NotFoundException(__('Invalid league'));
        }
        $options = [
            'conditions' => [
                'League.' . $this->League->primaryKey => $id
            ]
        ];
        $this->set('league', $this->League->find('first', $options));
    }

    /**
     * sports_delete method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_delete($id = null)
    {
        $this->set('title_for_layout', 'Delete League');
        $this->League->id = base64_decode($id);
        if (! $this->League->exists())
        {
            throw new NotFoundException(__('Invalid league'));
        }

        $this->loadModel('Game');
        $status = $this->Game->find('count', [
            'conditions' => [
                'Game.league_id' => $this->League->id,
                'OR' => [
                    'Game.status' => 1,
                    'Game.end_time >' => date('Y-m-d h:i:s')
                ]
            ]
        ]);
        if (! $status)
        {
            $this->Flash->error(__('You can not delete active league. Some game still has to play.'));
        }
        else
        {
            $this->League->saveField('is_deleted', 1);
            $this->League->saveField('deleted_by', AuthComponent::User('id'));
            $name = $this->League->find('first', [
                'conditions' => [
                    'League.id' => $this->League->id
                ],
                'fields' => [
                    'League.name'
                ]
            ]);
            $this->request->data['League']['name'] = $name['League']['name'] . '-is-deleted';
            if ($this->League->saveField('name', $this->request->data['League']['name']) && $this->League->saveField('status', 0))
                $this->Flash->success(__('The league has been deleted.'));
            else
                $this->Flash->error(__('The league could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    public function _getSearchConditions()
    {
        $input = $_GET;
        $model = 'League';

        $items = [];
        $conditions = [
            'League.is_deleted' => 0,
            'League.status' => [
                0,
                1
            ],
            'League.end_date >=' => date('Y-m-d h:i:s')
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
                'League' => $input
            ];
        }

        if (AuthComponent::user('role_id') == 2)
        {
            $conditions[$model . '.' . 'sport_id'] = AuthComponent::user('SportInfo.Sport.id');
        }

        return $conditions;
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
        $options = $this->League->Tournament->find('list', [
            'conditions' => [
                'Tournament.sport_id' => $id,
                'status' => 1,
                'is_deleted' => 0
            ],
            'order' => 'Tournament.name'
        ]);

        echo $this->View->Form->input('League.tournament_id', [
            'class' => 'form-control',
            'label' => false,
            'empty' => 'Please Select Tournament',
            'options' => $options,
            'required' => false
        ]);
    }
}
