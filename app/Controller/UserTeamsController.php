<?php
App::uses('AppController', 'Controller');

/**
 * UserTeams Controller
 *
 * @property UserTeam $UserTeam
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class UserTeamsController extends AppController
{
    public $View;

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

    public $helpers = [
        'Wall',
        'Sport'
    ];

    /**
     * _index method
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('getTournamentsAjax', 'getLeaguesAjax', 'getTeamsAjax');
        $this->View = new View($this, FALSE);
    }

    /**
     * _index method
     *
     * @param mixed $conditions
     * @param mixed $order
     *
     * @return void
     */
    public function _index($conditions, $order)
    {
        // $conditions = array('UserTeam.user_id'=>10);
        // pr(AuthComponent::user('Role.id'));
        $this->UserTeam->recursive = 0;
        $this->paginate = [
            'contain' => FALSE,
            'limit' => '25',
            'conditions' => $conditions,
            'order' => $order
        ];
        $this->set('userTeams', $this->paginate('UserTeam'));
        $users = $this->UserTeam->User->find('list', [
            'conditions' => [
                'User.role_id' => 5
            ]
        ]);

        $tournaments = $this->UserTeam->Tournament->find('list');
        $sports = $this->UserTeam->Sport->find('list', [
            'order' => [
                'Sport.name'
            ]
        ]);
        $leagues = $this->UserTeam->League->find('list');
        $teams = $this->UserTeam->Team->find('list');
        $status = [
            'Inactive',
            'Active',
            'Archived'
        ];
        $this->set(compact('users', 'tournaments', 'sports', 'leagues', 'teams', 'status'));
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
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'List Team');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->_index($conditions, 'UserTeam.created DESC');
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
    public function admin_view($id = NULL)
    {
        $this->set('title_for_layout', 'View Team');

        if (! $this->UserTeam->exists($id))
        {
            throw new NotFoundException(__('Invalid team'));
        }

        $options = [
            'conditions' => [
                'UserTeam.' . $this->UserTeam->primaryKey => $id
            ]
        ];
        $this->set('userTeam', $this->UserTeam->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', 'Add Team');

        if ($this->request->is('post'))
        {
            $alreadyAssigned = FALSE;
            $alreadyAssigned = $this->UserTeam->find('first', [
                'conditions' => [
                    'UserTeam.user_id' => $this->data['UserTeam']['user_id'],
                    'UserTeam.league_id' => $this->data['UserTeam']['league_id']
                ]
            ]);

            if ($alreadyAssigned)
            {
                $this->Flash->error(__('The user cannot be assigned in the same league again.'));
                return $this->redirect($this->here);
            }

            $this->UserTeam->create();
            if ($this->UserTeam->save($this->request->data))
            {
                $this->Flash->success(__('The user team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }

            $this->Flash->error(__('The user team could not be saved. Please, try again.'));
        }

        $users = $this->UserTeam->User->find('list', [
            'conditions' => [
                'User.role_id' => 5
            ]
        ]);
        $tournaments = [];
        $sports = $this->UserTeam->Sport->find('list', [
            'order' => [
                'Sport.name'
            ]
        ]);
        $leagues = [];
        $teams = [];
        $this->set(compact('users', 'tournaments', 'sports', 'leagues', 'teams'));
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
    public function admin_edit($id = NULL)
    {
        $this->set('title_for_layout', 'Update Team');

        if (! $this->UserTeam->exists($id))
        {
            throw new NotFoundException(__('Invalid user team'));
        }

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->UserTeam->save($this->request->data))
            {
                $this->Flash->success(__('The user team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }

            $this->Flash->error(__('The user team could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'UserTeam.' . $this->UserTeam->primaryKey => $id
                ]
            ];
            $this->request->data = $this->UserTeam->find('first', $options);
        }

        $users = $this->UserTeam->User->find('list');
        $tournaments = $this->UserTeam->Tournament->find('list');
        $sports = $this->UserTeam->Sport->find('list', [
            'order' => [
                'Sport.name'
            ]
        ]);
        $leagues = $this->UserTeam->League->find('list');
        $teams = $this->UserTeam->Team->find('list');
        $this->set(compact('users', 'tournaments', 'sports', 'leagues', 'teams'));
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
    public function admin_delete($id = NULL)
    {
        $this->set('title_for_layout', 'Delete Team');
        $this->UserTeam->id = $id;

        if (! $this->UserTeam->exists())
        {
            throw new NotFoundException(__('Invalid user team'));
        }

        $this->request->allowMethod('post', 'delete');

        if ($this->UserTeam->delete())
        {
            // $this->Flash->success(__('The user team has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The user team could not be deleted. Please, try again.'));
        }

        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * add method
     * user registratoin step 2
     *
     * @return void1
     */
    public function add()
    {
        $this->set('title_for_layout', __('Registration Step 2'));

        if ($this->request->is('post'))
        {
            $user_id = AuthComponent::user('id');
            $getdate = new DateTime('15 days ago');
            $dateBefore = $getdate->format('Y-m-d h:i:s');

            /*
             * count team status not= 0
             * and leavedate and request date not leass then 15 day without admin approval
             */
            $countJoinTeams = $this->UserTeam->find('count', [
                'conditions' => [
                    'UserTeam.status !=' => [
                        0,
                        3
                    ],
                    'UserTeam.user_id' => AuthComponent::user('id'),
                    'OR' => [
                        'UserTeam.leave_date' => '0000-00-00 00:00:00',
                        'UserTeam.leave_date >=' => $dateBefore
                    ],
                    'AND' => [
                        'OR' => [
                            'UserTeam.request_date' => NULL,
                            'UserTeam.leave_date >=' => $dateBefore
                        ]
                    ]
                ]
            ]);

            if ($countJoinTeams >= 3)
            {
                $this->Flash->error(__('The user can join 3 active teams at a time.'));
                return $this->redirect($this->here);
            }

            $returnStatus = FALSE;
            // checks before insert
            $returnStatus = $this->_getLeagueTeamExist($user_id, $this->data['UserTeam']['league_id']);
            if ($returnStatus)
            {
                $this->Flash->error(__('The user cannot be assigned in the same league again.'));
                return $this->redirect($this->here);
            }

            // update the step fileds
            $this->User->id = $user_id;
            $this->User->saveField('steps', 2);

            $this->UserTeam->create();
            if ($this->UserTeam->save($this->request->data))
            {

                return $this->redirect([
                    'controller' => 'dashboard',
                    'action' => 'index'
                ]);
            }

            $this->Flash->error(__('The user team could not be saved. Please, try again.'));
        }
        $users = AuthComponent::user('id');
        $sports = $this->UserTeam->Sport->find('list', [
            'order' => [
                'Sport.name'
            ]
        ]);
        $newdbtArray = [];
        if (! empty($sports))
        {
            foreach ($sports as $key => $value)
            {
                $newdbtArray[$key] = __dbt($value);
            }
        }
        $sports = $newdbtArray;
        $this->set(compact('users', 'sports'));
    }

    /**
     * blogger_add method
     * user registratoin step 2
     *
     * @return void
     */
    public function blogger_add()
    {
        $this->set('title_for_layout', __('Assign VideoUploader Team'));
        if ($this->request->is('post'))
        {

            $user_id = AuthComponent::user('id');

            $returnStatus = FALSE;
            // checks before insert
            $returnStatus = $this->_getLeagueTeamExist($user_id, $this->data['UserTeam']['league_id']);
            if ($returnStatus)
            {
                $this->Flash->error(__('The user cannot be assigned in the same league again.'));
                return $this->redirect($this->here);
            }

            // update the step fileds
            $this->User->id = $user_id;
            $this->User->saveField('steps', 2);
            $this->UserTeam->create();
            if ($this->UserTeam->save($this->request->data))
            {
                $currentKey = AuthComponent::$sessionKey;
                $this->Auth->Session->write($currentKey . '.sportSession.league_id', $this->request->data['UserTeam']['league_id']);
                $this->Auth->Session->write($currentKey . '.sportSession.tournament_id', $this->request->data['UserTeam']['tournament_id']);
                $this->Auth->Session->write($currentKey . '.sportSession.team_id', $this->request->data['UserTeam']['team_id']);
                $this->Auth->Session->write($currentKey . '.sportSession.sport_id', $this->request->data['UserTeam']['sport_id']);
                // $this->Flash->success(__('The user team has been saved.'));
                return $this->redirect([
                    'controller' => 'Dashboard',
                    'action' => 'index',
                    'blogger' => TRUE
                ]);
            }

            $this->Flash->error(__('The user team could not be saved. Please, try again.'));
        }

        $users = AuthComponent::user('id');

        $this->UserTeam->Tournament->find('all');
        $sports = $this->UserTeam->Sport->find('list', [
            'order' => [
                'Sport.name'
            ]
        ]);
        $newdbtArray = [];
        if (! empty($sports))
        {
            foreach ($sports as $key => $value)
            {
                $newdbtArray[$key] = __dbt($value);
            }
        }
        $sports = $newdbtArray;
        $this->UserTeam->League->find('list');
        $this->UserTeam->Team->find('list');
        $this->set(compact('users', 'tournaments', 'sports', 'leagues', 'teams'));
    }

    /**
     * blogger_index method
     *
     * @return void
     */
    public function blogger_index()
    {
        $this->set('title_for_layout', __('List Blogger'));
        $conditions = [];
        $conditions = 'UserTeam.user_id = 10';
        $conditions = $this->_getSearchConditions();
        $this->_index($conditions, 'UserTeam.created DESC');
    }

    /**
     * blogger_edit method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function blogger_edit($id = NULL)
    {
        $this->set('title_for_layout', __('Update Blogger Team'));
        $id = base64_decode($id);
        if (! $this->UserTeam->exists($id))
        {
            throw new NotFoundException(__('Invalid user team'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->UserTeam->save($this->request->data))
            {
                $this->Flash->success(__('The user team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The user team could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'UserTeam.' . $this->UserTeam->primaryKey => $id
                ]
            ];
            $this->request->data = $this->UserTeam->find('first', $options);
        }
        $users = $this->UserTeam->User->find('list');
        $tournaments = $this->UserTeam->Tournament->find('list');
        $sports = $this->UserTeam->Sport->find('list', [
            'order' => [
                'Sport.name'
            ]
        ]);
        $leagues = $this->UserTeam->League->find('list');
        $teams = $this->UserTeam->Team->find('list');
        $this->set(compact('users', 'tournaments', 'sports', 'leagues', 'teams'));
    }

    /**
     * blogger_view method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function blogger_view($id = NULL)
    {
        $this->set('title_for_layout', __('View Blogger Team'));
        $id = base64_decode($id);
        if (! $this->UserTeam->exists($id))
        {
            throw new NotFoundException(__('Invalid user team'));
        }
        $options = [
            'conditions' => [
                'UserTeam.' . $this->UserTeam->primaryKey => $id
            ]
        ];
        $this->set('userTeam', $this->UserTeam->find('first', $options));
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('title_for_layout', __('My Teams'));
        $this->_checkSportSession();
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->_index($conditions, 'UserTeam.created DESC');
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
    public function edit($id = NULL)
    {
        $this->set('title_for_layout', __('Update Team'));
        $id = base64_decode($id);
        if (! $this->UserTeam->exists($id))
        {
            throw new NotFoundException(__('Invalid user team'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->UserTeam->save($this->request->data))
            {
                $this->Flash->success(__('The user team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The user team could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'UserTeam.' . $this->UserTeam->primaryKey => $id
                ]
            ];
            $this->request->data = $this->UserTeam->find('first', $options);
        }
        $users = $this->UserTeam->User->find('list');
        $tournaments = $this->UserTeam->Tournament->find('list');
        $sports = $this->UserTeam->Sport->find('list', [
            'order' => [
                'Sport.name'
            ]
        ]);
        $leagues = $this->UserTeam->League->find('list');
        $teams = $this->UserTeam->Team->find('list');
        $this->set(compact('users', 'tournaments', 'sports', 'leagues', 'teams'));
    }

    /**
     * view method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function view($id = NULL)
    {
        $this->_checkSportSession();
        $this->set('title_for_layout', __('Team Member Details'));
        $id = base64_decode($id);
        $this->loadModel('UserPermission');
        if (! $this->UserTeam->exists($id))
        {
            throw new NotFoundException(__('Invalid user team'));
        }

        $options = [
            'conditions' => [
                'UserTeam.' . $this->UserTeam->primaryKey => $id
            ]
        ];
        $fields = [
            'User.id',
            'User.name',
            'User.email',
            'User.title',
            'User.created',
            'Sport.id',
            'Sport.name',
            'Tournament.name',
            'League.name'
        ];
        $record = $this->UserTeam->find('first', $options);
        $dataCount = $this->UserPermission->find('count', [
            'conditions' => [
                'UserPermission.who_id' => AuthComponent::User('id'),
                'UserPermission.whom_id' => $record['UserTeam']['user_id']
            ]
        ]);
        if ($dataCount == 0)
        {
            $this->request->data['UserPermission']['who_id'] = AuthComponent::User('id');
            $this->request->data['UserPermission']['whom_id'] = $record['UserTeam']['user_id'];
            $this->request->data['UserPermission']['tag_post'] = 0;
            $this->request->data['UserPermission']['comment_post'] = 0;
            $this->request->data['UserPermission']['see_post'] = 0;
            $this->UserPermission->save($this->request->data);
        }
        $data = $this->UserPermission->find('first', [
            'conditions' => [
                'UserPermission.who_id' => AuthComponent::User('id'),
                'UserPermission.whom_id' => $record['UserTeam']['user_id']
            ],
            'fields' => [
                'UserPermission.see_post',
                'UserPermission.comment_post',
                'UserPermission.tag_post'
            ]
        ]);
        $this->set('userTeam', $record);
        $this->set('data', $data);
    }

    /**
     * _getLeagueTeamExist method
     *
     * @param mixed $user_id
     * @param mixed $league_id
     *
     * @return void
     */
    public function _getLeagueTeamExist($user_id, $league_id)
    {
        $teamExistStatus = $this->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.user_id' => $user_id,
                'UserTeam.league_id' => $league_id
            ]
        ]);
        if (! empty($teamExistStatus))
        {
            return 'teamAlredyJoin';
        }
    }

    /**
     * delete method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function leave($id = NULL)
    {
        $this->set('title_for_layout', __('Leave Team'));
        $this->UserTeam->id = base64_decode($id);

        if (! $this->UserTeam->exists())
        {
            throw new NotFoundException(__('Invalid user team'));
        }

        // update the step fileds
        $status = $this->UserTeam->saveField('status', 3);
        $this->UserTeam->saveField('leave_date', date('Y-m-d h:i:s'));

        if (! empty($status))
        {
            $currentKey = AuthComponent::$sessionKey;
            $this->Session->delete($currentKey . '.sportSession');
            $this->Flash->success(__('You have successfully left the team.'));
        }
        else
        {
            $this->Flash->error(__('Internal error occurs. Please, try again.'));
        }
        return $this->redirect([
            'controller' => 'dashboard',
            'action' => 'index'
        ]);
    }

    /**
     * delete method
     *
     * @param string     $id
     * @param null|mixed $days
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function rejoin($id = NULL, $days = NULL)
    {
        $this->set('title_for_layout', __('Rejoin Team'));
        $this->UserTeam->id = base64_decode($id);
        if (! $this->UserTeam->exists())
        {
            throw new NotFoundException(__('Invalid user team'));
        }

        $leave_date = $this->UserTeam->field('leave_date');
        $leave_date = new DateTime($leave_date);
        $current_date = new DateTime(date('Y-m-d h:i:s'));
        $difference = $leave_date->diff($current_date);

        // rejoin after 2 days day
        if ($difference->days > minDays)
        {
            $status = $this->UserTeam->saveField('status', 2);
            $this->UserTeam->saveField('request_date', date('Y-m-d h:i:s'));

            $this->Flash->success(__('Your request has been submitted for approval, It will take minimum 3 days.'));
            return $this->redirect([
                'action' => 'index'
            ]);
        }
        elseif ($difference->days <= minDays)
        {
            $this->request->data['UserTeam']['leave_date'] = '0000-00-00 00:00:00';
            $this->request->data['UserTeam']['rejoin_date'] = '0000-00-00 00:00:00';
            $this->request->data['UserTeam']['status'] = 1;
            $this->UserTeam->save($this->request->data);
            $this->Flash->success(__('Your have rejoined team successfully.'));
        }
        return $this->redirect([
            'controller' => 'dashboard',
            'action' => 'index'
        ]);
    }

    /**
     * _getSearchConditions method
     *
     * @return void
     */
    public function _getSearchConditions()
    {
        $input = $_GET;
        $model = 'UserTeam';

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
                'UserTeam' => $input
            ];
        }

        if (AuthComponent::user('Role.id') != 1)
        {
            $conditions = [
                $model . '.user_id' => AuthComponent::user('id'),
                $model . '.league_id' => $this->Auth->Session->read('Auth.User.sportSession.league_id'),
                $model . '.team_id' => $this->Auth->Session->read('Auth.User.sportSession.team_id')
            ];
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
    public function getTournamentsAjax($id = NULL)
    {
        $this->layout = FALSE;
        $this->autoRender = FALSE;
        $id = base64_decode($id);

        $options = $this->UserTeam->Tournament->find('list', [
            'conditions' => [
                'Tournament.sport_id' => $id,
                'Tournament.status' => 1,
                'Tournament.is_deleted' => 0
            ]
        ]);
        echo $this->View->Form->input('UserTeam.tournament_id', [
            'class' => 'form-control',
            'label' => FALSE,
            'empty' => __('Please Select Tournament'),
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
    public function getLeaguesAjax($id = NULL)
    {
        $this->layout = FALSE;
        $this->autoRender = FALSE;
        $id = base64_decode($id);
        $options = $this->UserTeam->League->find('list', [
            'conditions' => [
                'League.tournament_id' => $id,
                'League.end_date >=' => date('Y-m-d h:i:s'),
                'League.is_deleted' => 0
            ],
            'order' => 'League.name',
            'League.status' => 1
        ]);
        echo $this->View->Form->input('UserTeam.league_id', [
            'class' => 'form-control',
            'label' => FALSE,
            'empty' => __('Please Select League'),
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
    public function getTeamsAjax($id = NULL)
    {
        $this->layout = FALSE;
        $this->autoRender = FALSE;
        $id = base64_decode($id);
        $options = $this->UserTeam->Team->find('list', [
            'conditions' => [
                'Team.league_id' => $id,
                'Team.status' => 1,
                'Team.is_deleted' => 0
            ]
        ]);
        if (empty($options))
        {
            echo $this->View->Form->input('UserTeam.team_id', [
                'class' => 'form-control',
                'label' => FALSE,
                'empty' => __('Please Select Team')
            ]);
        }
        else
        {
            echo $this->View->Form->input('UserTeam.team_id', [
                'class' => 'form-control',
                'label' => FALSE,
                'empty' => __('Please Select Team'),
                'options' => $options
            ]);
        }
    }

    /**
     * teamMembers method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function teamMembers($id = NULL)
    {
        $this->_checkSportSession();
        $this->set('title_for_layout', __('My Team Members'));
        $id = base64_decode($id);
        $this->loadModel('Team');
        if (! $this->Team->exists($id))
        {
            throw new NotFoundException(__('Invalid user team'));
        }

        $userTeams = $this->UserTeam->find('all', [
            'conditions' => [
                'UserTeam.team_id' => $id,
                'UserTeam.status' => 1,
                'UserTeam.user_id !=' => AuthComponent::User('id')
            ]
        ]);
        $this->set(compact('userTeams'));
    }

    /**
     * blogger_teamMembers method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function blogger_teamMembers($id = NULL)
    {
        $this->set('title_for_layout', __('My Team Members'));
        $this->loadModel('Team');
        $id = base64_decode($id);
        if (! $this->Team->exists($id))
        {
            throw new NotFoundException(__('Invalid user team'));
        }
        $userTeams = $this->UserTeam->find('all', [
            'conditions' => [
                'UserTeam.team_id' => $id,
                'UserTeam.status' => 1
            ]
        ]);
        $this->set(compact('userTeams'));
    }

    /**
     * admin_rejoinTeamRequest method
     *
     * @show record that send request at max 15 before
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_rejoinTeamRequest()
    {
        $this->set('title_for_layout', 'Rejoin Team Request');
        $this->loadModel('UserTeam');
        $getdate = new DateTime('15 days ago');
        $dateBefore = $getdate->format('Y-m-d h:i:s');
        $fields = [];
        $userTeams = $this->UserTeam->find('all', [
            'conditions' => [
                'UserTeam.status' => 2,
                'UserTeam.request_date > ' => $dateBefore
            ],
            'fields' => $fields
        ]);
        $this->set(compact('userTeams'));
    }

    /**
     * admin_approve method
     *
     * @show record that send request at max 15 before
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_approveRejoinRequest($id = NULL)
    {
        $id = base64_decode($id);
        $this->_approveRequest($id);
    }

    /**
     * admin_rejoinTeamRequest method
     *
     * @show record that send request at max 15 before
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function team_rejoinTeamRequest()
    {
        // echo '<pre>'; print_r(AuthComponent::user()); echo '</pre>';
        $this->set('title_for_layout', 'Rejoin Team Request');
        $this->loadModel('UserTeam');
        $teamId = AuthComponent::user('SportInfo.Team.id');
        $getdate = new DateTime('15 days ago');
        $dateBefore = $getdate->format('Y-m-d h:i:s');
        $userTeams = $this->UserTeam->find('all', [
            'conditions' => [
                'UserTeam.status' => 0,
                'UserTeam.team_id' => $teamId,
                'UserTeam.rejoin_date > ' => $dateBefore
            ]
        ]);
        $this->set(compact('userTeams'));
    }

    /**
     * team_approveRejoinRequest method
     *
     * @param string $id
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function team_approveRejoinRequest($id = NULL)
    {
        $id = base64_decode($id);
        $this->_approveRequest($id);
    }

    /**
     * _approveRequest method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function _approveRequest($id = NULL)
    {
        if (! $this->UserTeam->exists($id))
        {
            throw new NotFoundException(__('Invalid user team'));
        }
        $this->UserTeam->id = $id;
        $this->UserTeam->saveField('request_date', NULL);
        $this->UserTeam->saveField('leave_date', '0000-00-00 00:00:00');
        $status = $this->UserTeam->saveField('status', 1);
        if (! empty($status))
        {
            $this->Flash->success(__('Team status has been changed successfully.'));
        }
        else
        {
            $this->Flash->error(__('The user team status could not be changed. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'rejoinTeamRequest'
        ]);
    }

    /**
     * updatePermissionStatus method
     *
     * @param string     $id
     * @param null|mixed $fieldName
     * @param null|mixed $userId
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function updatePermissionStatus($fieldName = NULL, $userId = NULL)
    {
        $this->loadModel('UserPermission');
        $first = $this->UserPermission->find('first', [
            'conditions' => [
                'UserPermission.who_id' => AuthComponent::User('id'),
                'UserPermission.whom_id' => $userId
            ]
        ]);
        $this->request->data['UserPermission']['id'] = $first['UserPermission']['id'];
        if ($first['UserPermission'][$fieldName] == 1)
        {

            $this->request->data['UserPermission'][$fieldName] = 0;
            $this->request->data['UserPermission']['who_id'] = AuthComponent::User('id');
            $this->request->data['UserPermission']['whom_id'] = $userId;
            $this->UserPermission->save($this->request->data);
        }
        else
        {

            $this->request->data['UserPermission'][$fieldName] = 1;
            $this->request->data['UserPermission']['who_id'] = AuthComponent::User('id');
            $this->request->data['UserPermission']['whom_id'] = $userId;
            $this->UserPermission->save($this->request->data);
        }

        die();
    }

    /**
     * *************************************Editor Section Starts Here*****************************************
     */
    /**
     * editor_add method
     * user registratoin step 2
     *
     * @return void
     */
    public function editor_add()
    {
        $this->set('title_for_layout', 'Assign Editor Team');
        $user_id = AuthComponent::user('id');
        $role_id = AuthComponent::user('role_id');
        return $this->redirect([
            'controller' => 'Dashboard',
            'action' => 'myProfile',
            'editor' => TRUE
        ]);
        if ($this->request->is('post'))
        {

            $user_id = AuthComponent::user('id');
            return $this->redirect([
                'controller' => 'Dashboard',
                'action' => 'myProfile',
                'editor' => TRUE
            ]);
        }
    }

    /**
     * blogger_index method
     *
     * @return void
     */
    public function editor_index()
    {
        $this->set('title_for_layout', 'List Editor');
        $conditions = [];
        $conditions = 'UserTeam.user_id = 10';
        $conditions = $this->_getSearchConditions();

        $this->_index($conditions, 'UserTeam.created DESC');
    }

    /**
     * blogger_edit method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_edit($id = NULL)
    {
        $this->set('title_for_layout', 'Update Editor Team');
        $id = base64_decode($id);
        if (! $this->UserTeam->exists($id))
        {
            throw new NotFoundException(__('Invalid user team'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->UserTeam->save($this->request->data))
            {
                $this->Flash->success(__('The user team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The user team could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'UserTeam.' . $this->UserTeam->primaryKey => $id
                ]
            ];
            $this->request->data = $this->UserTeam->find('first', $options);
        }
        $users = $this->UserTeam->User->find('list');
        $tournaments = $this->UserTeam->Tournament->find('list');
        $sports = $this->UserTeam->Sport->find('list', [
            'order' => [
                'Sport.name'
            ]
        ]);
        $leagues = $this->UserTeam->League->find('list');
        $teams = $this->UserTeam->Team->find('list');
        $this->set(compact('users', 'tournaments', 'sports', 'leagues', 'teams'));
    }

    /**
     * blogger_view method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_view($id = NULL)
    {
        $this->set('title_for_layout', 'View Editor Team');
        $id = base64_decode($id);
        if (! $this->UserTeam->exists($id))
        {
            throw new NotFoundException(__('Invalid user team'));
        }
        $options = [
            'conditions' => [
                'UserTeam.' . $this->UserTeam->primaryKey => $id
            ]
        ];
        $this->set('userTeam', $this->UserTeam->find('first', $options));
    }

/**
 * *************************************Editor Section Ends Here*****************************************
 */
}