<?php
App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property FlashComponenut $Flash
 * @property SessionComponent $Session
 * @property AuthComponent $Auth
 * @property SessionComponent $Session
 */
class WallsController extends AppController
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
        'Email',
        'File',
        'Resizer'
    ];

    public $helpers = [
        'Wall'
    ];

    /**
     * beforeFilter method
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('editComment', 'deleteComment', 'deletePost');
    }

    /**
     * blogger_add method
     *
     * @todo method will change the way data fetched. It will changed AuthComponent::User('id') to league_id.
     *       Data will fetched using league id.
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function blogger_add()
    {
        $this->set('title_for_layout', __('Add Walls'));
        $id = AuthComponent::User('id');
        $resultArr = $this->Wall->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.user_id' => $id
            ]
        ]);
        $team_id = $resultArr['UserTeam']['team_id'];
        $league_id = $resultArr['League']['id'];
        $teamExist = $this->Wall->find('first', [
            'conditions' => [
                'Wall.team_id' => $team_id,
                'Wall.league_id' => $league_id
            ]
        ]);

        if (empty($teamExist))
        {
            $this->request->data['Wall']['name'] = 'Wall';
            $this->request->data['Wall']['locale_id'] = AuthComponent::User('locale_id');
            $this->request->data['Wall']['tournament_id'] = $resultArr['Tournament']['id'];
            $this->request->data['Wall']['sport_id'] = $resultArr['Sport']['id'];
            $this->request->data['Wall']['league_id'] = $resultArr['League']['id'];
            $this->request->data['Wall']['team_id'] = $resultArr['Team']['id'];
            $this->Wall->create();
            if ($this->Wall->save($this->request->data))
            {
                $this->Flash->success(__('The wall has been created.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The wall could not generate. Please, try again.'));
        }
        else
        {
            return $this->redirect([
                'action' => 'index'
            ]);
        }
        $this->autoRender = false;
    }

    /**
     * blogger_index method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function blogger_index()
    {
        $this->loadModel('WallContent');
        $this->set('title_for_layout', __('Add Walls'));
        $wallContent = $this->WallContent->find('all');
        $this->set(compact('wallContent'));
    }

    /**
     * index method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function index()
    {
        $this->set('title_for_layout', __('My Wall'));
        $limit = 10;
        $tagUsers = '';
        $recordBeforeDate = '';
        $this->loadModel('UserTeam');
        $this->loadModel('UserPermission');
        $this->loadModel('Team');
        $userId = AuthComponent::User('id');
        $notSeePostByUsers = [];
        $notCommentOnPostUser = [];
        $notTagUsers = [];
        $leagueId = $this->Auth->Session->read('Auth.User.sportSession.league_id');
        $teamId = $this->Auth->Session->read('Auth.User.sportSession.team_id');
        $wallId = $this->Auth->Session->read('Auth.User.sportSession.wall_id');
        $this->_checkSportSession();

        // seprate permission(user) array for each type of permission.
        $permisons = $this->UserPermission->find('all', [
            'conditions' => [
                'UserPermission.whom_id' => $userId
            ]
        ]);

        foreach ($permisons as $permission)
        {
            if ($permission['UserPermission']['see_post'] == 1)
            {
                $notSeePostByUsers[] = $permission['UserPermission']['who_id'];
            }
            if ($permission['UserPermission']['comment_post'] == 1)
            {
                $notCommentOnPostUser[] = $permission['UserPermission']['who_id'];
            }
            if ($permission['UserPermission']['tag_post'] == 1)
            {
                $notTagUsers[] = $permission['UserPermission']['who_id'];
            }
        }

        $teamStatus = $this->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.status' => 1,
                'UserTeam.team_id' => $teamId,
                'UserTeam.user_id' => $userId
            ],
            'fields' => [
                'UserTeam.rejoin_date',
                'UserTeam.created',
                'UserTeam.status'
            ]
        ]);
        if (strtotime($teamStatus['UserTeam']['rejoin_date']) > strtotime($teamStatus['UserTeam']['created']))
        {
            $recordBeforeDate = $teamStatus['UserTeam']['rejoin_date'];
        }
        else
        {
            $recordBeforeDate = $teamStatus['UserTeam']['created'];
        }
        if ($teamStatus['UserTeam']['status'] == 1)
        {
            if (! empty($notSeePostByUsers))
            {
                $wallContents = $this->Wall->WallContent->find('all', [
                    'conditions' => [
                        'WallContent.user_id NOT' => $notSeePostByUsers,
                        'WallContent.created >' => $recordBeforeDate,
                        'WallContent.status' => 1,
                        'OR' => [
                            'WallContent.troll_id' => $wallId,
                            'WallContent.wall_id' => $wallId
                        ]
                    ],
                    'order' => [
                        'WallContent.created' => 'desc'
                    ],
                    'limit' => $limit
                ]);
            }
            else
            {
                $wallContents = $this->Wall->WallContent->find('all', [
                    'conditions' => [
                        'WallContent.created >' => $recordBeforeDate,
                        'WallContent.status' => 1,
                        'OR' => [
                            'WallContent.troll_id' => $wallId,
                            'WallContent.wall_id' => $wallId
                        ]
                    ],
                    'order' => [
                        'WallContent.created' => 'desc'
                    ],
                    'limit' => $limit
                ]);
            }
        }
        else
        {
            $wallContents = '';
        }

        $teams = $this->Team->find('list', [
            'conditions' => [
                'Team.league_id' => $leagueId,
                'Team.id !=' => $teamId
            ]
        ]);

        array_push($notTagUsers, $userId);
        $teamUsers = $this->Wall->UserTeam->find('all', [
            'conditions' => [
                'User.locale_id' => AuthComponent::User('locale_id'),
                'UserTeam.team_id' => $teamId,
                'UserTeam.league_id' => $leagueId,
                'UserTeam.user_id NOT' => $notTagUsers
            ],
            'fields' => [
                'User.email'
            ]
        ]);
        foreach ($teamUsers as $user)
        {
            $tagUsers .= "'" . $user['User']['email'] . "',";
        }
        $gameList = $this->getMatchList();
        $this->set(compact([
            'gameList',
            'wallContents',
            'tagUsers',
            'notCommentOnPostUser',
            'teams'
        ]));
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
     * blogger_index method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function comment()
    {
        $this->autoRender = false;
        $this->loadModel('WallComment');
        $this->loadModel('User');
        $this->loadModel('Notification');
        $this->set('title_for_layout', __('Add comments'));

        $userId = AuthComponent::User('id');
        $wallId = $this->request->data[1]['value'];
        $contentId = $this->request->data[2]['value'];
        if (trim($this->request->data[3]['value']) == '')
        {
            echo 'error';
            return '';
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $this->request->data['WallComment']['wall_id'] = $wallId;
            $this->request->data['WallComment']['content_id'] = $contentId;
            $this->request->data['WallComment']['comment'] = $this->request->data[3]['value'];
            $this->request->data['WallComment']['user_id'] = $userId;
            if ($this->WallComment->save($this->request->data))
            {
                // insert tag details for tag user
                if (! empty($this->request->data[4]['value']))
                {

                    $emailsArr = explode(',', $this->request->data[4]['value']);
                    foreach ($emailsArr as $emails)
                    {
                        $toUserId = $this->User->find('first', [
                            'conditions' => [
                                'User.email' => $emails
                            ],
                            'fields' => [
                                'User.id'
                            ]
                        ]);
                        $this->Notification->create();
                        $this->request->data['Notification']['to'] = $toUserId['User']['id'];
                        $this->request->data['Notification']['by'] = $userId;
                        $this->request->data['Notification']['content_id'] = $contentId;
                        $this->request->data['Notification']['comment_id'] = $this->WallComment->id;
                        $this->Notification->save($this->request->data);
                    }
                }
                echo $this->WallComment->id;
            }
            else
            {
                echo 'error';
            }
        }
    }

    /**
     * editComment ajax method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editComment()
    {
        // pr($this->request->data); die;
        $this->autoRender = false;
        $this->loadModel('WallComment');
        if ($this->request->is('post'))
        {
            $this->request->data['WallComment']['id'] = $this->request->data[1]['value'];
            $this->request->data['WallComment']['comment'] = $this->request->data[2]['value'];
            $id = $this->request->data[1]['value'];
            if (! $this->WallComment->exists($id))
            {
                throw new NotFoundException(__('Invalid user'));
            }
            if ($this->WallComment->save($this->request->data))
            {
                echo $this->request->data[2]['value'];
            }
            else
            {
                echo 'error';
            }
        }
    }

    /**
     * deleteComment ajax method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function deleteComment()
    {
        $this->autoRender = false;
        $id = $this->request->data;
        $this->loadModel('WallComment');
        if ($this->request->is('post'))
        {
            if (! $this->WallComment->exists($id))
            {
                throw new NotFoundException(__('Invalid comment'));
            }

            if ($this->WallComment->delete($id))
            {
                echo 'success';
            }
            else
            {
                echo 'error';
            }
        }
    }

    /**
     * deletePost ajax method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function deletePost()
    {
        $this->autoRender = false;
        $id = $this->request->data;
        $this->loadModel('WallContent');
        if ($this->request->is('post'))
        {
            if (! $this->WallContent->exists($id))
            {
                throw new NotFoundException(__('Invalid post'));
            }

            if ($this->WallContent->delete($id))
            {
                echo 'success';
            }
            else
            {
                echo 'error';
            }
        }
    }

    /**
     * loadComments ajax method
     *
     * @throws NotFoundException
     *
     * @todo add query for rejoin date condition.
     *
     * @return void
     */
    public function loadComments()
    {
        $this->layout = false;
        $this->loadModel('UserTeam');
        $limit = 5;
        $tagUsers = '';
        $recordBeforeDate = '';
        $this->loadModel('UserTeam');
        $this->loadModel('UserPermission');
        $userId = AuthComponent::User('id');
        $notSeePostByUsers = [];
        $notCommentOnPostUser = [];
        $notTagUsers = [];

        if ($this->request->is('post'))
        {
            $loadeIdFrom = $this->request->data['loadfrom'];
            $this->User->unbindModel([
                'belongsTo' => [
                    'Tournament,Sport'
                ]
            ]);

            $leagueId = $this->Auth->Session->read('Auth.User.sportSession.league_id');
            $teamId = $this->Auth->Session->read('Auth.User.sportSession.team_id');
            $wallId = $this->Wall->find('first', [
                'conditions' => [
                    'Wall.league_id' => $leagueId,
                    'AND' => [
                        'Wall.team_id' => $teamId
                    ],
                    'AND' => [
                        'Wall.locale_id' => AuthComponent::User('locale_id')
                    ]
                ],
                'fields' => [
                    'Wall.id'
                ]
            ]);
            $wallId = $wallId['Wall']['id'];

            $permisons = $this->UserPermission->find('all', [
                'conditions' => [
                    'UserPermission.whom_id' => $userId
                ]
            ]);
            foreach ($permisons as $permission)
            {
                if ($permission['UserPermission']['see_post'] == 1)
                {
                    $notSeePostByUsers[] = $permission['UserPermission']['who_id'];
                }
                if ($permission['UserPermission']['comment_post'] == 1)
                {
                    $notCommentOnPostUser[] = $permission['UserPermission']['who_id'];
                }
                if ($permission['UserPermission']['tag_post'] == 1)
                {
                    $notTagUsers[] = $permission['UserPermission']['who_id'];
                }
            }
            // pr($notSeePostByUsers); die;
            $teamStatus = $this->UserTeam->find('first', [
                'conditions' => [
                    'UserTeam.status' => 1,
                    'UserTeam.team_id' => $teamId,
                    'UserTeam.user_id' => AuthComponent::User('id')
                ]
            ]);
            if (strtotime($teamStatus['UserTeam']['rejoin_date']) > strtotime($teamStatus['UserTeam']['created']))
            {
                $recordBeforeDate = $teamStatus['UserTeam']['rejoin_date'];
            }
            else
            {
                $recordBeforeDate = $teamStatus['UserTeam']['created'];
            }
            $wallContents = $this->Wall->WallContent->find('all', [
                'conditions' => [
                    'WallContent.user_id NOT' => $notSeePostByUsers,
                    'WallContent.status' => 1,
                    'WallContent.wall_id' => $wallId,
                    'WallContent.id <' => $loadeIdFrom,
                    'WallContent.created >' => $recordBeforeDate
                ],
                'order' => [
                    'WallContent.created' => 'desc'
                ],
                'limit' => $limit
            ]);
            if (empty($wallContents))
            {
                $wallContents = '';
            }
            array_push($notTagUsers, $userId);
            $teamUsers = $this->UserTeam->find('all', [
                'conditions' => [
                    'UserTeam.team_id' => $teamId,
                    'UserTeam.league_id' => $leagueId,
                    'UserTeam.user_id NOT' => $notTagUsers
                ],
                'fields' => [
                    'User.email'
                ]
            ]);
            foreach ($teamUsers as $user)
            {
                $tagUsers .= "'" . $user['User']['email'] . "',";
            }
            $this->set(compact('wallContents', 'tagUsers', 'notCommentOnPostUser'));
        }
    }

    /**
     * notificaton method
     *
     * @param null|mixed $postId
     * @param null|mixed $notificationId
     *
     * @throws NotFoundException
     *
     * @return void display detail post
     */
    public function notificaton($postId = null, $notificationId = null)
    {
        Configure::write('debug', 2);
        $this->autoRender = false;
        $this->set('title_for_layout', __('Wall Notification'));
        $this->loadModel('Notification');
        $id = base64_decode($notificationId);
        if (! $this->Notification->exists($id))
        {
            throw new NotFoundException(__('Invalid team'));
        }
        $this->Notification->id = $id;
        if ($this->Notification->saveField('status', 1))
        {
            return $this->redirect([
                'action' => 'post',
                $postId
            ]);
        }
    }

    /**
     * post method
     *
     * @param null|mixed $id
     *
     * @throws NotFoundException
     *
     * @return void display detail post
     */
    public function post($id = null)
    {
        $this->_checkSportSession();
        $this->set('title_for_layout', __('My Wall'));
        $this->loadModel('UserTeam');
        $id = base64_decode($id);
        $tagUsers = '';
        $this->loadModel('UserPermission');
        $userId = AuthComponent::User('id');
        $notCommentOnPostUser = [];
        $notTagUsers = [];

        if ($this->request->is('get'))
        {
            if (! $this->Wall->WallContent->exists($id))
            {
                $this->Flash->error(__('The post has been deleted by user.'));
            }

            $permisons = $this->UserPermission->find('all', [
                'conditions' => [
                    'UserPermission.whom_id' => $userId
                ]
            ]);
            foreach ($permisons as $permission)
            {
                if ($permission['UserPermission']['comment_post'] == 1)
                {
                    $notCommentOnPostUser[] = $permission['UserPermission']['who_id'];
                }
                if ($permission['UserPermission']['tag_post'] == 1)
                {
                    $notTagUsers[] = $permission['UserPermission']['who_id'];
                }
            }

            $leagueId = $this->Auth->Session->read('Auth.User.sportSession.league_id');
            $teamId = $this->Auth->Session->read('Auth.User.sportSession.team_id');
            $wallContents = $this->Wall->WallContent->find('all', [
                'conditions' => [
                    'WallContent.id' => $id
                ]
            ]);

            array_push($notTagUsers, $userId);
            $teamUsers = $this->UserTeam->find('all', [
                'conditions' => [
                    'UserTeam.team_id' => $teamId,
                    'UserTeam.league_id' => $leagueId,
                    'UserTeam.user_id NOT' => $notTagUsers
                ],
                'fields' => [
                    'User.email'
                ]
            ]);
            foreach ($teamUsers as $user)
            {
                $tagUsers .= "'" . $user['User']['email'] . "',";
            }

            $this->set(compact('wallContents', 'tagUsers', 'notCommentOnPostUser'));
        }
    }

    /**
     * addPost method
     *
     * @param null|mixed $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function addPost($id = null)
    {
        $this->autoRender = false;
        if ($this->request->is('post'))
        {
            // pr($this->request->data);die;
            if ((trim($this->request->data['WallContent']['name']) == '') and ($this->request->data['WallContent']['file_id']['name'] == ''))
            {
                $this->Flash->error(__('Post value could not be empty. Please enter some text or upload image'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $currentKey = AuthComponent::$sessionKey;
            $leagueId = $this->Auth->Session->read($currentKey . '.sportSession.league_id');
            $teamId = $this->Auth->Session->read($currentKey . '.sportSession.team_id');
            $wallId = $this->Auth->Session->read($currentKey . '.sportSession.wall_id');

            $contentType = 'text'; // default text
            $userId = AuthComponent::User('id');

            // save wll id in troll_id field in database
            if ($this->request->data['WallContent']['troll_id'])
            {
                $this->Wall->unbindModel([
                    'hasMany' => [
                        'WallContent'
                    ]
                ]);
                $trollId = $this->Wall->find('first', [
                    'conditions' => [
                        'Wall.team_id' => $this->request->data['WallContent']['troll_id'],
                        'Wall.locale_id' => AuthComponent::User('locale_id')
                    ],
                    'fields' => [
                        'Wall.id'
                    ]
                ]);
                $this->request->data['WallContent']['troll_id'] = isset($trollId['Wall']['id']) ? $trollId['Wall']['id'] : 0;
            }
            else
            {
                $this->request->data['WallContent']['troll_id'] = 0;
            }

            if ($this->request->data['WallContent']['file_id']['name'])
            {

                $this->request->data['WallContent']['wall_id'] = $wallId;
                $this->request->data['WallContent']['post_type'] = 1; // 1 for wall post, 0 for blog post
                $this->request->data['WallContent']['content_type'] = $contentType; // image,video,document,audio
                $this->request->data['WallContent']['user_id'] = $userId;

                $exten = explode('.', $this->data['WallContent']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {
                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['WallContent']['file_id'];
                    $destination = 'img/WallPosts/large/';
                    $destination2 = 'img/WallPosts/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '50', 'jpg', '40', '50');

                    $files_data = $this->data['WallContent']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/WallPosts/', $fileName);
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->request->data['WallContent']['content'] = $exten[1];
                        $this->request->data['WallContent']['content_type'] = 'image';
                        $this->request->data['WallContent']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Wall->WallContent->save($this->request->data))
                        {
                            $this->notificationEmail($this->request->data['WallContent']['tagUsersEmail'], $userId, $this->Wall->WallContent->id);

                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The user could not be saved. Please, try again.'));
                    }
                    else
                    {
                        $this->Flash->error(__('Unable to upload Image and save record. Please, try again.'));
                    }
                }
                else
                {
                    $this->Flash->error(__('Please select a valid image format.'));
                }
            }
            else
            {

                unset($this->request->data['WallContent']['file_id']);
                $this->request->data['WallContent']['wall_id'] = $wallId;
                $this->request->data['WallContent']['post_type'] = 1; // 1 for wall post, 0 for blog post
                $this->request->data['WallContent']['content_type'] = $contentType; // image,video,document,audio
                $this->request->data['WallContent']['user_id'] = $userId;
                if ($this->Wall->WallContent->save($this->request->data))
                {
                    $this->notificationEmail($this->request->data['WallContent']['tagUsersEmail'], $userId, $this->Wall->WallContent->id);
                }
                else
                {
                    $this->Flash->error(__('The post could not be saved. Please, try again.'));
                }
            }

            return $this->redirect([
                'action' => 'index'
            ]);
        }
    }

    /**
     * notificationEmail method
     *
     * @param null|mixed $data
     * @param null|mixed $userId
     * @param null|mixed $contentId
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function notificationEmail($data = null, $userId = null, $contentId = null)
    {
        if (! empty($data))
        {
            $this->loadModel('Notification');
            $emailsArr = explode(',', $data);

            foreach ($emailsArr as $emails)
            {
                $toUserId = $this->User->find('first', [
                    'conditions' => [
                        'User.email' => $emails
                    ],
                    'fields' => [
                        'User.id'
                    ]
                ]);
                if (! empty($toUserId))
                {
                    $this->Notification->create();
                    $this->request->data['Notification']['to'] = $toUserId['User']['id'];
                    $this->request->data['Notification']['by'] = $userId;
                    $this->request->data['Notification']['content_id'] = $contentId;
                    $this->Notification->save($this->request->data);
                }
            }
        }
    }

    /**
     * team_index method
     *
     * @return void
     */
    public function team_index()
    {
        $this->loadModel('WallContent');
        $this->set('title_for_layout', 'Video Listing');
        $this->loadModel('Wall');
        $this->loadModel('UserTeam');
        $teamId = AuthComponent::User('SportInfo.Team.id');
        $leagueId = AuthComponent::User('SportInfo.Team.league_id');

        $this->WallContent->unbindModel([
            'hasMany' => [
                'WallComment'
            ]
        ]);
        $this->WallContent->unbindModel([
            'belongsTo' => [
                'User'
            ]
        ]);
        $videoDetail = $this->WallContent->find('all', [
            'conditions' => [
                'Wall.team_id' => $teamId,
                'Wall.league_id' => $leagueId,
                'Wall.status' => 1,
                'WallContent.content_type' => 'embed'
            ]
        ]);
        // pr($videoDetail);
        $this->set(compact('videoDetail'));
    }

    /**
     * team_view method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function team_view($id = null)
    {
        $this->loadModel('WallContent');
        $videoDetail = $this->WallContent->find('first', [
            'conditions' => [
                'Wall.id' => base64_decode($id)
            ]
        ]);
        $this->set(compact('videoDetail'));
    }

    /**
     * team_delete method
     *
     * @param null|mixed $id
     * @param null|mixed $status
     *
     * @return void
     */
    public function team_delete($id = null, $status = null)
    {
        $this->loadModel('WallContent');
        $this->WallContent->id = base64_decode($id);
        if ($this->WallContent->saveField('status', base64_decode($status)))
        {
            $this->Flash->success(__('Video status has been changed successfully.'));
        }
        else
        {
            $this->Flash->error(__('The video status could not be changed. Please, try again.'));
        }
        return $this->redirect([
            'controller' => 'walls',
            'action' => 'index'
        ]);
    }

    /**
     * team_wall method
     *
     * @return void
     */
    public function team_post()
    {
        $this->loadModel('WallContent');
        $userId = AuthComponent::User('id');
        $this->Wall->unbindModel([
            'belongsTo' => [
                'WallComment',
                'User',
                'Wall'
            ]
        ]);
        $this->paginate = [
            'limit' => 10,
            'conditions' => [
                'WallContent.user_id' => $userId
            ],
            'order' => 'WallContent.id DESC'
        ];
        $wallPost = $this->Paginator->paginate('WallContent');
        $this->set(compact('wallPost'));
    }

    /**
     * team_add method
     *
     * @return void
     */
    public function team_add()
    {
        if ($this->request->is('post'))
        {
            if ((trim($this->request->data['WallContent']['name']) == '') and ($this->request->data['WallContent']['file_id']['name'] == ''))
            {
                $this->Flash->error(__('Post value could not be empty. Please enter some text or upload image'));
                return $this->redirect([
                    'controller' => 'walls',
                    'action' => 'add'
                ]);
            }

            $contentType = 'text'; // default text
            $this->Wall->unbindModel([
                'belongsTo' => [
                    'WallContent',
                    'UserTeam',
                    'Tournament',
                    'Sport'
                ]
            ]);
            $currentKey = AuthComponent::$sessionKey;
            $userId = AuthComponent::User('id');
            $leagueId = $this->Auth->Session->read($currentKey . '.SportInfo.Team.league_id');
            $teamId = $this->Auth->Session->read($currentKey . '.SportInfo.Team.id');
            $sportId = $this->Auth->Session->read($currentKey . '.SportInfo.Team.sport_id');
            $tournamentId = $this->Auth->Session->read($currentKey . '.SportInfo.Team.tournament_id');
            $localeId = $this->Auth->Session->read($currentKey . '.locale_id');

            $wallInfo = $this->Wall->find('first', [
                'conditions' => [
                    'Wall.league_id' => $leagueId,
                    'Wall.team_id' => $teamId,
                    'Wall.locale_id' => $localeId,
                    'Wall.status' => 1
                ],
                'fields' => [
                    'Wall.id'
                ]
            ]);

            if (! empty($wallInfo))
            {
                $wallId = $wallInfo['Wall']['id'];
            }
            else
            {
                $this->Flash->error(__('You have not assigned any wall. Please, try again.'));
                return $this->redirect([
                    'controller' => 'walls',
                    'action' => 'add'
                ]);
            }

            if ($this->request->data['WallContent']['file_id']['name'])
            {

                $this->request->data['WallContent']['wall_id'] = $wallId;
                $this->request->data['WallContent']['post_type'] = 1; // 1 for wall post, 0 for blog post
                $this->request->data['WallContent']['content_type'] = $contentType; // image,video,document,audio
                $this->request->data['WallContent']['user_id'] = $userId;

                $exten = explode('.', $this->data['WallContent']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {
                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['WallContent']['file_id'];
                    $destination = 'img/WallPosts/large/';
                    $destination2 = 'img/WallPosts/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '50', 'jpg', '40', '50');

                    $files_data = $this->data['WallContent']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/WallPosts/', $fileName);
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->request->data['WallContent']['content'] = $exten[1];
                        $this->request->data['WallContent']['content_type'] = 'image';
                        $this->request->data['WallContent']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Wall->WallContent->save($this->request->data))
                        {
                            $this->Flash->success(__('The post has been saved successfully.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The post could not be saved. Please, try again.'));
                    }
                    else
                    {
                        $this->Flash->error(__('Unable to upload Image and save record. Please, try again.'));
                    }
                }
                else
                {
                    $this->Flash->error(__('Please select a valid image format.'));
                }
            }
            else
            {

                unset($this->request->data['WallContent']['file_id']);
                $this->request->data['WallContent']['wall_id'] = $wallId;
                $this->request->data['WallContent']['post_type'] = 1; // 1 for wall post, 0 for blog post
                $this->request->data['WallContent']['content_type'] = $contentType; // image,video,document,audio
                $this->request->data['WallContent']['user_id'] = $userId;
                if ($this->Wall->WallContent->save($this->request->data))
                {
                    $this->Flash->success(__('The post has been saved successfully.'));
                }
                else
                {
                    $this->Flash->error(__('The post could not be saved. Please, try again.'));
                }
            }
        }
    }

    /**
     * team_postStatus method
     *
     * @param null|mixed $id
     * @param null|mixed $status
     *
     * @return void
     */
    public function team_postStatus($id = null, $status = null)
    {
        $this->loadModel('WallContent');
        $this->WallContent->id = base64_decode($id);
        if ($this->WallContent->saveField('status', base64_decode($status)))
        {
            $this->Flash->success(__('Post status has been changed successfully.'));
        }
        else
        {
            $this->Flash->error(__('The post status could not be changed. Please, try again.'));
        }
        return $this->redirect([
            'controller' => 'walls',
            'action' => 'post'
        ]);
    }

    /**
     * team_add method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function team_editPost($id = null)
    {
        $id = base64_decode($id);
        if ($this->request->is('post'))
        {
            // pr($this->request->data); die;
            if ((trim($this->request->data['WallContent']['name']) == '') and ($this->request->data['WallContent']['file_id']['name'] == ''))
            {
                $this->Flash->error(__('Post value could not be empty. Please enter some text or upload image'));
                return $this->redirect([
                    'controller' => 'walls',
                    'action' => 'add'
                ]);
            }

            $contentType = 'text'; // default text
            $this->Wall->unbindModel([
                'belongsTo' => [
                    'WallContent',
                    'UserTeam',
                    'Tournament',
                    'Sport'
                ]
            ]);
            $currentKey = AuthComponent::$sessionKey;
            $userId = AuthComponent::User('id');
            $leagueId = $this->Auth->Session->read($currentKey . '.SportInfo.Team.league_id');
            $teamId = $this->Auth->Session->read($currentKey . '.SportInfo.Team.id');
            $sportId = $this->Auth->Session->read($currentKey . '.SportInfo.Team.sport_id');
            $tournamentId = $this->Auth->Session->read($currentKey . '.SportInfo.Team.tournament_id');
            $localeId = $this->Auth->Session->read($currentKey . '.locale_id');

            $wallInfo = $this->Wall->find('first', [
                'conditions' => [
                    'Wall.league_id' => $leagueId,
                    'Wall.team_id' => $teamId,
                    'Wall.locale_id' => $localeId,
                    'Wall.status' => 1
                ],
                'fields' => [
                    'Wall.id'
                ]
            ]);
            if ($wallInfo !== '')
            {
                $wallId = $wallInfo['Wall']['id'];
            }
            else
            {
                $this->Flash->error(__('The post could not be saved. Please, try again.'));
            }
            if ($this->request->data['WallContent']['file_id']['name'])
            {

                $this->request->data['WallContent']['wall_id'] = $wallId;
                $this->request->data['WallContent']['post_type'] = 1; // 1 for wall post, 0 for blog post
                $this->request->data['WallContent']['content_type'] = $contentType; // image,video,document,audio
                $this->request->data['WallContent']['user_id'] = $userId;

                $exten = explode('.', $this->data['WallContent']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {
                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['WallContent']['file_id'];
                    $destination = 'img/WallPosts/large/';
                    $destination2 = 'img/WallPosts/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '50', 'jpg', '40', '50');

                    $files_data = $this->data['WallContent']['file_id'];
                    $pushValue = [
                        'file_id' => $this->data['WallContent']['update_file_id']
                    ];
                    $files_data = array_merge($files_data, $pushValue);

                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/WallPosts/', $fileName);
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->request->data['WallContent']['content'] = $exten[1];
                        $this->request->data['WallContent']['content_type'] = 'image';
                        $this->request->data['WallContent']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Wall->WallContent->save($this->request->data))
                        {
                            $this->Flash->success(__('The post has been saved successfully.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The post could not be saved. Please, try again.'));
                    }
                    else
                    {
                        $this->Flash->error(__('Unable to upload Image and save record. Please, try again.'));
                    }
                }
                else
                {
                    $this->Flash->error(__('Please select a valid image format.'));
                }
            }
            else
            {

                unset($this->request->data['WallContent']['file_id']);
                unset($this->request->data['WallContent']['update_file_id']);
                $this->request->data['WallContent']['wall_id'] = $wallId;
                $this->request->data['WallContent']['post_type'] = 1; // 1 for wall post, 0 for blog post
                $this->request->data['WallContent']['content_type'] = 'image'; // image,video,document,audio
                $this->request->data['WallContent']['user_id'] = $userId;
                if ($this->Wall->WallContent->save($this->request->data))
                {
                    $this->Flash->success(__('The post has been saved successfully.'));
                }
                else
                {
                    $this->Flash->error(__('The post could not be saved. Please, try again.'));
                }
            }
        }
        $this->request->data = $this->Wall->WallContent->find('first', [
            'conditions' => [
                'WallContent.id' => $id
            ]
        ]);
        // pr($this->request->data);
    }

    /**
     * team_viewPost method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function team_viewPost($id = null)
    {
        $id = base64_decode($id);
        $this->loadModel('WallContent');
        $wallPost = $this->Wall->WallContent->find('first', [
            'conditions' => [
                'WallContent.id' => $id
            ]
        ]);
        $this->set(compact('wallPost'));
    }

    /*
     * function to get list of today's match
     * Created By: Smartdata
     * Date: 02-06-2016
     * Company: SmartData
     */
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
}