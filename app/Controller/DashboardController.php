<?php
App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property AuthComponent $Auth
 * @property SessionComponent $Session
 */
class DashboardController extends AppController
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
        'File',
        'Resizer'
    ];

    public $helpers = [
        'Sport',
        'Common'
    ];

    /**
     * Uses
     *
     * @var array
     */
    public $uses = [
        'User'
    ];

    /**
     * beforeFilter method
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('profile', 'blogger_profile');
    }

    /**
     * admin_myProfile method
     *
     * @param null|mixed $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_myProfile($id = null)
    {
        $this->set('title_for_layout', 'My Profile');
        $id = AuthComponent::user('id');
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $return = $this->edit($id);
            if ($return['success'])
            {
                $this->redirect($return['redirect']);
            }
        }
        else
        {
            $options = [
                'conditions' => [
                    'User.' . $this->User->primaryKey => $id
                ]
            ];
            $this->request->data = $this->User->find('first', $options);
        }
        $roleId = $this->Auth->user('role_id') + 1;
        $roles = $this->User->Role->find('list', [
            'conditions' => [
                'Role.id between ? and ?' => [
                    $roleId,
                    5
                ]
            ]
        ]);
        $locales = $this->User->Locale->find('list');
        $this->set(compact('roles', 'locales'));
    }

    /**
     * admin_myProfile method
     *
     * @param null|mixed $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function league_myProfile($id = null)
    {
        $this->set('title_for_layout', 'My Profile');
        $id = AuthComponent::user('id');
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $return = $this->edit($id);
            if ($return['success'])
            {
                $this->redirect($return['redirect']);
            }
        }
        else
        {
            $options = [
                'conditions' => [
                    'User.' . $this->User->primaryKey => $id
                ]
            ];
            $this->request->data = $this->User->find('first', $options);
        }
        $roleId = $this->Auth->user('role_id') + 1;
        $roles = $this->User->Role->find('list', [
            'conditions' => [
                'Role.id between ? and ?' => [
                    $roleId,
                    5
                ]
            ]
        ]);
        $locales = $this->User->Locale->find('list');
        $this->set(compact('roles', 'locales'));
    }

    /**
     * sports_myProfile method
     *
     * @param null|mixed $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_myProfile($id = null)
    {
        $this->set('title_for_layout', __('My Profile'));
        $id = AuthComponent::user('id');
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $return = $this->edit($id);
            if ($return['success'])
            {
                $this->redirect($return['redirect']);
            }
        }
        else
        {
            $options = [
                'conditions' => [
                    'User.' . $this->User->primaryKey => $id
                ]
            ];
            $this->request->data = $this->User->find('first', $options);
        }
        $roleId = $this->Auth->user('role_id') + 1;
        $roles = $this->User->Role->find('list', [
            'conditions' => [
                'Role.id between ? and ?' => [
                    $roleId,
                    5
                ]
            ]
        ]);
        $locales = $this->User->Locale->find('list');
        // $files = $this->User->File->find('list');
        $this->set(compact('roles', 'locales'));
    }

    /**
     * team_myProfile method
     *
     * @param null|mixed $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function team_myProfile($id = null)
    {
        $this->set('title_for_layout', 'My Profile');
        $id = AuthComponent::user('id');
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $return = $this->edit($id);
            if ($return['success'])
            {
                $this->redirect($return['redirect']);
            }
        }
        else
        {
            $options = [
                'conditions' => [
                    'User.' . $this->User->primaryKey => $id
                ]
            ];
            $this->request->data = $this->User->find('first', $options);
        }
        $roleId = $this->Auth->user('role_id') + 1;
        $roles = $this->User->Role->find('list', [
            'conditions' => [
                'Role.id between ? and ?' => [
                    $roleId,
                    5
                ]
            ]
        ]);
        $locales = $this->User->Locale->find('list');
        // $files = $this->User->File->find('list');
        $this->set(compact('roles', 'locales'));
    }

    /**
     * myProfile method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function myProfile()
    {
        $currentKey = AuthComponent::$sessionKey;

        $this->set('title_for_layout', __('My Profile'));
        if ($this->request->is([
            'post',
            'put'
        ]))
        {

            $id = $this->request->data['User']['id'];
            if (! $this->User->exists($id))
            {
                $this->Flash->error(__('Invalid user.'));
                return [
                    'success' => 0,
                    'redirect' => false
                ];
            }
            if (isset($this->data['User']['file_id']['name']))
            {
                $tmpName = $this->data['User']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }
                $exten = explode('.', $this->data['User']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['User']['file_id'];
                    $destination = 'img/ProfileImages/large/';
                    $destination2 = 'img/ProfileImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '180', 'jpg', '180', '180');
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '50', 'jpg', '40', '50');

                    $files_data = $this->data['User']['file_id'];
                    if (empty($this->request->data['User']['update_file_id']))
                    {
                        unset($this->request->data['User']['update_file_id']);
                    }
                    else
                    {
                        $pushValue = [
                            'file_id' => $this->data['User']['update_file_id']
                        ];
                        $files_data = array_merge($files_data, $pushValue);
                    }

                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/ProfileImages/', $fileName);
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->request->data['User']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->User->save($this->request->data))
                        {

                            $this->Auth->Session->write($currentKey . '.File.new_name', $fileName);
                            $this->Auth->Session->write($currentKey . '.File.path', '/img/ProfileImages/' . $fileName);
                            $this->Session->write('Auth.File.new_name', $fileName);
                            $this->Session->write('Auth.File.path', '/img/ProfileImages/' . $fileName);
                            $this->Flash->success(__('Profile has been updated successfully.'));
                            return $this->redirect([
                                'action' => 'myProfile'
                            ]);
                        }
                        $this->Flash->error(__('Profile could not be saved. Please, try again.'));
                    }
                    else
                    {
                        $this->Flash->error(__('Unable to upload Image and save record. Please, try again.'));
                    }
                }
                else
                {
                    $this->request->data = $users = $this->User->find('first', [
                        'conditions' => [
                            'User.' . $this->User->primaryKey => AuthComponent::User('id')
                        ]
                    ]);
                    $this->Flash->error(__('Please select a valid image format.'));
                }
            }
            else
            {
                unset($this->request->data['User']['file_id']);
                if ($this->User->save($this->request->data))
                {
                    $this->Auth->Session->write($currentKey . '.name', $this->data['User']['name']);
                   //echo  $this->Auth->Session->write($currentKey . '.email', $this->data['User']['email']);exit;
                    $this->Flash->success(__('Profile has been updated successfully.'));
                }
                else
                {
                    $this->Flash->error(__('Profile can not be saved! Please try again.'));
                }
                return $this->redirect([
                    'action' => 'myProfile'
                ]);
            }
        }
        else
        {
            $this->request->data = $users = $this->User->find('first', [
                'conditions' => [
                    'User.' . $this->User->primaryKey => AuthComponent::User('id')
                ]
            ]);
        }
       //  pr($this->request->data);exit;
        $this->set(compact('users'));
    }

    /**
     * blogger_myProfile method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function blogger_myProfile()
    {
        $this->set('title_for_layout', __('My Profile'));
        if ($this->request->is([
            'post',
            'put'
        ]))
        {

            $currentKey = AuthComponent::$sessionKey;
            $id = $this->request->data['User']['id'];
            if (! $this->User->exists($id))
            {
                $this->Flash->error(__('Invalid user.'));
                return [
                    'success' => 0,
                    'redirect' => false
                ];
            }
            if (isset($this->data['User']['file_id']['name']))
            {
                $tmpName = $this->data['User']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }
                $exten = explode('.', $this->data['User']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['User']['file_id'];
                    $destination = 'img/ProfileImages/large/';
                    $destination2 = 'img/ProfileImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '180', 'jpg', '180', '180');
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '50', 'jpg', '40', '50');

                    $files_data = $this->data['User']['file_id'];
                    if (empty($this->request->data['User']['update_file_id']))
                    {
                        unset($this->request->data['User']['update_file_id']);
                    }
                    else
                    {
                        $pushValue = [
                            'file_id' => $this->data['User']['update_file_id']
                        ];
                        $files_data = array_merge($files_data, $pushValue);
                    }

                    $files_data = $this->data['User']['file_id'];

                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/ProfileImages/', $fileName);
                    if ($upload_info['uploaded'] == 1)
                    {

                        // $this->User->create();
                        $this->request->data['User']['file_id'] = $upload_info['db_info']['Upload']['id'];

                        if ($this->User->save($this->request->data))
                        {
                            $this->Auth->Session->write($currentKey . '.File.new_name', $fileName);
                            $this->Auth->Session->write($currentKey . '.File.path', '/img/ProfileImages/' . $fileName);
                            $this->Session->write('Auth.File.new_name', $fileName);
                            $this->Session->write('Auth.File.path', '/img/ProfileImages/' . $fileName);
                            $this->Flash->success(__('Profile saved successfully.'));
                            return $this->redirect([
                                'action' => 'myProfile',
                                'blogger' => true
                            ]);
                        }
                        $this->Flash->error(__('Profile could not be saved. Please, try again.'));
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
                unset($this->request->data['User']['file_id']);
                if ($this->User->save($this->request->data))
                {
                    $this->Auth->Session->write($currentKey . '.name', $this->data['User']['name']);
                    $this->Flash->success(__('Profile has been updated successfully.'));
                }
                else
                {
                    $this->Flash->error(__('Profile can not be saved!, Please try again.'));
                }
                return $this->redirect([
                    'action' => 'myProfile',
                    'blogger' => true
                ]);
            }
        }
        else
        {
            $this->request->data = $users = $this->User->find('first', [
                'conditions' => [
                    'User.' . $this->User->primaryKey => AuthComponent::User('id')
                ]
            ]);
        }
        $this->set(compact('users'));
    }

    /**
     * edit method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function edit($id = null)
    {
        $this->set('title_for_layout', __('Update Profile'));
        if (! $this->User->exists($id))
        {
            $this->Flash->error(__('Invalid user.'));
            return [
                'success' => 0,
                'redirect' => false
            ];
        }

        if ($this->request->data['User']['file_id']['name'])
        {
            $tmpName = $this->data['User']['file_id']['tmp_name'];
            $imgType = $this->checkMimeTypeApp($tmpName);
            if ($imgType == 0)
            {
                $this->Flash->error(__('Invalid Image.'));
                $this->redirect($this->referer());
            }
            $this->request->data['User1'] = $this->request->data['User'];
            $exten = explode('.', $this->data['User']['file_id']['name']);
            if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
            {

                $filename = time() . '.' . $exten[1];
                $file1 = $this->data['User']['file_id'];
                $destination = 'img/ProfileImages/large/';
                $destination2 = 'img/ProfileImages/thumbnail/';

                $this->Resizer->upload($file1, $destination, $filename);
                $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                $this->Resizer->image($file1, 'resize', '50', 'jpg', '40', '50');

                $files_data = $this->data['User']['file_id'];
                $pushValue = [
                    'file_id' => $this->data['User']['update_file_id']
                ];
                $files_data = array_merge($files_data, $pushValue);
                $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/ProfileImages/', $fileName);

                if ($upload_info['uploaded'] == 1)
                {
                    $ex1 = explode('/', $upload_info['db_info']['Upload']['path']);

                    $this->request->data['User']['file_id'] = $upload_info['db_info']['Upload']['id'];
                    if ($this->User->save($this->request->data))
                    {
                        $currentKey = AuthComponent::$sessionKey;
                        $this->Auth->Session->write($currentKey . '.File.new_name', $fileName);
                        $this->Auth->Session->write($currentKey . '.File.path', '/img/ProfileImages/' . $fileName);
                        $this->Flash->success(__('Profile has been updated successfully.'));
                        return [
                            'success' => 1,
                            'redirect' => [
                                'action' => 'myProfile'
                            ]
                        ];
                    }
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));
                    return [
                        'success' => 0,
                        'redirect' => false
                    ];
                }

                $this->Flash->error(__('Unable to upload Image and save record. Please, try again.'));
            }
            else
            {
                $this->Flash->error(__('Please select a valid image format.'));
            }
        }
        else
        {
            unset($this->request->data['User']['file_id']);
            if ($this->User->save($this->request->data))
            {
                $this->Flash->success(__('Profile has been updated successfully.'));
                return [
                    'success' => 1,
                    'redirect' => [
                        'action' => 'myProfile'
                    ]
                ];
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
            return [
                'success' => 0,
                'redirect' => false
            ];
        }
    }

    /**
     * admin_index method
     * 
     * The panel for the main dashboard in admin
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_index()
    {
         $this->loadModel('News');
        $total_users = $this->User->find('count');
        
        $this->set('total_users', $total_users);

        $total_news = $this->News->find('count');
        $this->set('total_news', $total_news);
    }

    /**
     * sports_index method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_index()
    {
    }

    /**
     * league_index method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function league_index()
    {
    }

    /**
     * team_index method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function team_index()
    {
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
        $this->set('title_for_layout', __('Dashboard'));
        $this->loadModel('WallContent');
        $this->loadModel('Team');
        $this->loadModel('UserTeam');
        $this->WallContent->unbindModel([
            'hasMany' => [
                'WallComment'
            ]
        ]);
        $userTeamCount = $this->UserTeam->find('count', [
            'conditions' => [
                'UserTeam.user_id' => AuthComponent::User('id')
            ]
        ]);
        if ($userTeamCount == 0)
        {
            return $this->redirect([
                'controller' => 'userTeams',
                'action' => 'add'
            ]);
        }
        $Userteam = $this->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.user_id' => AuthComponent::User('id')
            ],
            'fields' => [
                'UserTeam.tournament_id',
                'UserTeam.sport_id',
                'UserTeam.league_id',
                'UserTeam.team_id'
            ]
        ]);
        $currentKey = AuthComponent::$sessionKey;
        $sportsession = $this->Auth->Session->read($currentKey . '.sportSession');
        if (! empty($Userteam) && empty($sportsession))
        {

            $this->Auth->Session->write($currentKey . '.sportSession.league_id', $Userteam['UserTeam']['league_id']);
            $this->Auth->Session->write($currentKey . '.sportSession.tournament_id', $Userteam['UserTeam']['tournament_id']);
            $this->Auth->Session->write($currentKey . '.sportSession.team_id', $Userteam['UserTeam']['team_id']);
            $this->Auth->Session->write($currentKey . '.sportSession.sport_id', $Userteam['UserTeam']['sport_id']);
        }
        $videos = $this->WallContent->find('all', [
            'conditions' => [
                'WallContent.user_id' => AuthComponent::User('id')
            ],
            'fields' => [
                'WallContent.title',
                'WallContent.name',
                'WallContent.status_name',
                'WallContent.id'
            ]
        ]);

        $this->set(compact('videos'));
    }

    /**
     * blogger_view method
     *
     * @param null|mixed $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function blogger_view($id = null)
    {
        $this->set('title_for_layout', __('Dashboard'));
        $this->loadModel('WallContent');
        $id = base64_decode($id);
        if (! $this->WallContent->exists($id))
        {
            $this->Flash->error(__('Invalid video.'));
            return [
                'success' => 0,
                'redirect' => false
            ];
        }

        $videos = $this->WallContent->find('first', [
            'conditions' => [
                'WallContent.id' => $id
            ]
        ]);
        $this->set(compact('videos'));
    }

    /**
     * blogger_edit method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function blogger_edit($id = null)
    {
        $this->set('title_for_layout', __('Edit YouTube Video'));
        $this->loadModel('WallContent');
        $this->loadModel('Team');
        $id = base64_decode($id);

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            // pr($has_match); die;
            $youtubeLink = $this->request->data['WallContent']['name'];
            $rx = '~
                            ^(?:https?://)?              # Optional protocol
                             (?:www\.)?                  # Optional subdomain
                             (?:youtube\.com|youtu\.be)  # Mandatory domain name
                             /watch\?v=([^&]+)           # URI with video id as capture group 1
                             ~x';

            $has_match = preg_match($rx, $youtubeLink);

            if (! $has_match)
            {
                $this->Flash->error(__('The youtube link is not valid. Please, try again.'));
                return $this->redirect([
                    'controller' => 'dashboard',
                    'action' => 'index',
                    'blogger' => true
                ]);
            }
            if ($this->WallContent->save($this->request->data))
            {
                $this->Flash->success(__('The video has been saved.'));
                return $this->redirect([
                    'controller' => 'dashboard',
                    'action' => 'index',
                    'blogger' => true
                ]);
            }
            $this->Flash->error(__('The video could not be saved. Please, try again.'));
        }
        else
        {
            $this->request->data = $this->WallContent->find('first', [
                'conditions' => [
                    'WallContent.id' => $id
                ]
            ]);
        }

        $teams = $this->Team->find('list');
        $this->set(compact('teams', 'WallContent'));
    }

    /**
     * blogger_delete method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function blogger_delete($id = null)
    {
        $this->loadModel('WallContent');
        $id = base64_decode($id);
        if (! $this->WallContent->exists($id))
        {
            $this->Flash->error(__('Invalid video id.'));
            return $this->redirect([
                'controller' => 'dashboard',
                'action' => 'index'
            ]);
        }

        if ($this->WallContent->delete($id))
        {
            $this->Flash->success(__('The video has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The video could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'controller' => 'dashboard',
            'action' => 'index'
        ]);
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
        $this->set('title_for_layout', __('My Dashboard'));
        $this->loadModel('UserTeam');
        $this->loadModel('News');
        $getdate = new DateTime('15 days ago');
        $dateBefore = $getdate->format('Y-m-d h:i:s');
        $fields = [
            'UserTeam.*',
            'User.id',
            'User.locale_id',
            'Tournament.id',
            'Tournament.name',
            'Sport.id',
            'Sport.name',
            'Sport.tile_image',
            'Sport.banner_image',
            'League.id',
            'League.name',
            'Team.id',
            'Team.name'
        ];
        $userTeams = $this->UserTeam->find('all', [
            'conditions' => [
                'UserTeam.status !=' => 0,
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
            ],
            'fields' => $fields
        ]);

        $this->News->unbindModel([
            'belongsTo' => [
                'Sport'
            ]
        ]);
        $newsTrends = $this->News->find('all', [
            'order' => 'News.most_read DESC',
            'limit' => 10,
            'fields' => [
                'File.new_name',
                'News.name',
                'News.id',
                'News.description'
            ]
        ]);
        $this->set(compact('userTeams', 'newsTrends'));
        // delete sport Session
        $currentKey = AuthComponent::$sessionKey;
        if ($this->Auth->Session->read($currentKey . '.sportSession'))
        {
            $this->Session->delete($currentKey . '.sportSession');
        }
    }

    /**
     * admin_changePassword
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_changePassword()
    {
        $this->set('title_for_layout', __('Change Password'));
        if ($this->request->is('post'))
        {
            $return = $this->changePassword($this->request->data('User'), AuthComponent::user('id'));
        }
    }

    /**
     * league_changePassword
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function league_changePassword()
    {
        if ($this->request->is('post'))
        {
            $return = $this->changePassword($this->request->data('User'), AuthComponent::user('id'));
        }
    }

    /**
     * sports_changePassword
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_changePassword()
    {
        if ($this->request->is('post'))
        {
            $return = $this->changePassword($this->request->data('User'), AuthComponent::user('id'));
        }
    }

    /**
     * team_changePassword
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function team_changePassword()
    {
        if ($this->request->is('post'))
        {

            $return = $this->changePassword($this->request->data('User'), AuthComponent::user('id'));
        }
    }

    /**
     * editor_changePassword
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_changePassword()
    {
        $this->layout = false;
        $this->autoRender = false;
        $return = $this->changePassword($this->request->data('User'), AuthComponent::user('id'));
    }

    /**
     * blogger_changePassword
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function blogger_changePassword()
    {
        $return = $this->changePassword($this->request->data('User'), AuthComponent::user('id'));
    }

    /**
     * changeFanPassword
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function changeFanPassword()
    {
        $return = $this->changePassword($this->request->data('User'), AuthComponent::user('id'));

        if ($this->request->is('post', 'get'))
        {
        }
    }

    /**
     * changePassword
     *
     * @param null|mixed $data
     * @param null|mixed $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function changePassword($data = null, $id = null)
    {
        $this->set('title_for_layout', 'Change Password');
        $this->autoRender = false;

        $orignanalPwd = $this->User->find('first', [
            'conditions' => [
                'User.id' => $id
            ],
            'fields' => [
                'password',
                'google_id',
                'facebookId',
                'twitterID'
            ]
        ]);
        if (empty($orignanalPwd['User']['password']) && (! empty($orignanalPwd['User']['google_id']) || ! empty($orignanalPwd['User']['facebookId']) || ! empty($orignanalPwd['User']['twitterID'])))
        {
            if (($this->request->data['User']['new_password'] == $this->request->data['User']['re_enter_password']))
            {
                $this->User->id = $id;
                $this->User->saveField('password', $this->request->data['User']['new_password']);
                $this->Flash->success(__('Password has been changed successfully.'));
                return $this->redirect([
                    'controller' => 'dashboard',
                    'action' => 'index'
                ]);
            }

            $this->Flash->error(__('New password and Confirm password does\'t match.Please, try again.'));
            return $this->redirect([
                'controller' => 'dashboard',
                'action' => 'myProfile'
            ]);
        }
        if ($data['current_password'] != '' && $data['new_password'] != '' && $data['re_enter_password'] != '')
        {
            $enteredPassword = AuthComponent::password($this->data['User']['current_password']);
            if ($orignanalPwd['User']['password'] != $enteredPassword)
            {
                $this->Flash->error(__('The password you entered is incorrect, please retype your current password'));
                return $this->redirect([
                    'controller' => 'dashboard',
                    'action' => 'myProfile'
                ]);
            }
            if (($orignanalPwd['User']['password'] == $enteredPassword) && ($this->request->data['User']['new_password'] == $this->request->data['User']['re_enter_password']))
            {
                $this->User->id = $id;
                $this->User->saveField('password', $this->request->data['User']['new_password']);
                $this->Flash->success(__('Password has been changed successfully.'));
                return $this->redirect([
                    'controller' => 'dashboard',
                    'action' => 'index'
                ]);
            }

            $this->Flash->error(__('The password cannot be changed. Please, try again.'));
            return $this->redirect([
                'controller' => 'dashboard',
                'action' => 'myProfile'
            ]);
        }
        $this->Flash->error(__('Please fill all the fields.'));
        return $this->redirect([
            'controller' => 'dashboard',
            'action' => 'myProfile'
        ]);
    }

    /**
     * startTeamSession method
     *
     * @create specific sport session
     *
     * @param null|mixed $teamId
     * @param null|mixed $tournamentId
     * @param null|mixed $leagueId
     * @param null|mixed $sport_id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function startTeamSession($teamId = null, $tournamentId = null, $leagueId = null, $sport_id = null)
    {
        $this->autoRender = false;
        if ($this->request->is('post'))
        {

            $this->loadModel('Team');

            $teamId = base64_decode($teamId);
            $tournamentId = base64_decode($tournamentId);
            $leagueId = base64_decode($leagueId);
            $sport_id = base64_decode($sport_id);
            $this->Team->unbindModel([
                'hasMany' => [
                    'Wall',
                    'Forum'
                ]
            ]);
            $teamName = $this->Team->find('first', [
                'conditions' => [
                    'Team.id' => $teamId
                ],
                'fields' => 'Team.name'
            ]);

            $SportSession = [
                'teamName' => $teamName['Team']['name'],
                'team_id' => $teamId,
                'tournament_id' => $tournamentId,
                'league_id' => $leagueId,
                'sport_id' => $sport_id
            ];

            $currentKey = AuthComponent::$sessionKey;
            $this->Auth->Session->write($currentKey . '.sportSession', $SportSession);
            $this->CheckSportSessionValues();
        }
    }

    /**
     * CheckSportSession method
     *
     * @create for checking user sport session and send to relative module
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function CheckSportSessionValues()
    {
        $this->autoRender = false;
        // find session key of user
        $currentUserKey = AuthComponent::$sessionKey;

        // condition on basis of sessionKey

        if ($currentUserKey == 'Auth.User')
        {

           $leagueId = $this->Auth->Session->read('Auth.User.sportSession.league_id');
           $sportId = $this->Auth->Session->read('Auth.User.sportSession.sport_id');
           $teamId = $this->Auth->Session->read('Auth.User.sportSession.team_id');
           $tournamentId = $this->Auth->Session->read('Auth.User.sportSession.tournament_id');
           $play_status_active= $this->change_play_status_1();
            //pr($play_status_active);exit;
            $play_status_inactive= $this->change_play_status_0();

            $wallResponce = $this->CheckWall();
            $chatRoomResponce = $this->CheckChatroom();

            if ($wallResponce && $chatRoomResponce)
            {
                // nothing happans
            }
            else
            {
                $this->Flash->error(__('Unable to crete wall or chatroom. Please, try again.'));
            }
            return $this->redirect([
                'controller' => 'walls',
                'action' => 'index'
            ]);

            // }
        }
        else
            if ($currentUserKey == 'Auth.Blogger')
            {
            }
    }

    /**
     * CheckWall method
     *
     * @create for checking wall if not exist create new and redirect user to wall
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function CheckWall()
    {
        $this->autoRender = false;
        $this->loadModel('Wall');
        $wallId = $this->Wall->find('first', [
            'conditions' => [
                'Wall.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Wall.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'Wall.locale_id' => AuthComponent::User('locale_id'),
                'Wall.league_id' => AuthComponent::User('sportSession.league_id'),
                'Wall.team_id' => AuthComponent::User('sportSession.team_id'),
                'Wall.status' => 1,
                'Wall.is_deleted' => 0
            ],
            'fields' => [
                'Wall.id'
            ]
        ]);
        $currentKey = AuthComponent::$sessionKey;
        if (! empty($wallId['Wall']['id']))
        {
            $this->Auth->Session->write($currentKey . '.sportSession.wall_id', $wallId['Wall']['id']);
            return true;
            // return $this->redirect(array('controller' => 'walls', 'action' => 'index'));
        }
        $this->request->data['Wall']['league_id'] = AuthComponent::User('sportSession.league_id');
        $this->request->data['Wall']['tournament_id'] = AuthComponent::User('sportSession.tournament_id');
        $this->request->data['Wall']['team_id'] = AuthComponent::User('sportSession.team_id');
        $this->request->data['Wall']['sport_id'] = AuthComponent::User('sportSession.sport_id');
        $this->request->data['Wall']['locale_id'] = AuthComponent::User('locale_id');
        $this->request->data['Wall']['name'] = 'Wall';
        if ($this->Wall->save($this->request->data))
        {
            $this->Auth->Session->write($currentKey . '.sportSession.wall_id', $this->Wall->getLastInsertID());
            // return $this->redirect(array('controller' => 'walls', 'action' => 'index'));
            return true;
        }
        $this->Flash->error(__('Not able to save record. Please, try again.'));
        return false;
        // return $this->redirect(array('controller' => 'walls', 'action' => 'index'));
    }

    /**
     * CheckChatroom method
     *
     * @create for checking wall if not exist create new and redirect user to wall
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function CheckChatroom()
    {
        $this->autoRender = false;
        $this->loadModel('Chatroom');
        $this->loadModel('Game');
        $getdate = new DateTime();
        $todayDate = $getdate->format('Y-m-d h:i:s');
        $teamID = AuthComponent::User('sportSession.team_id');
        $currentKey = AuthComponent::$sessionKey;
        /*
         * if game is active then open chat room of two teams
         * else open single team chat room
         */
        $this->Game->unbindModel([
            'hasMany' => [
                'Team'
            ]
        ]);
        $this->Game->unbindModel([
            'belongsTo' => [
                'Sport',
                'League',
                'Tournament',
                'First_team',
                'Second_team'
            ]
        ]);

        $gameStatus = $this->Game->find('first', [
            'conditions' => [
                'Game.play_status' => 1,
                'AND' => [
                    'OR' => [
                        'Game.first_team' => $teamID,
                        'Game.second_team' => $teamID
                    ]
                ]
            ]
        ]);

        if (! empty($gameStatus))
        {
            /* create chat room for multi team users */
            $allowedTeams = $gameStatus['Game']['first_team'] . ',' . $gameStatus['Game']['second_team'];
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
            if (! empty($room))
            {

                $this->Auth->Session->write($currentKey . '.sportSession.chatroom_id', $room['Chatroom']['id']);
            }
            else
            {

                $this->request->data['Chatroom']['league_id'] = AuthComponent::User('sportSession.league_id');
                $this->request->data['Chatroom']['tournament_id'] = AuthComponent::User('sportSession.tournament_id');
                $this->request->data['Chatroom']['team_id'] = AuthComponent::User('sportSession.team_id');
                $this->request->data['Chatroom']['sport_id'] = AuthComponent::User('sportSession.sport_id');
                $this->request->data['Chatroom']['locale_id'] = AuthComponent::User('locale_id');
                $this->request->data['Chatroom']['allowed_teams'] = $allowedTeams;
                $this->request->data['Chatroom']['name'] = 'chatRoom';
                if ($this->Chatroom->save($this->request->data))
                {
                    $this->Auth->Session->write($currentKey . '.sportSession.chatroom_id', $this->Chatroom->getLastInsertID());
                    return true;
                }
                $this->Flash->error(__('Not able to save record. Please, try again.'));
                return false;
            }
            return true;
        } /* create chat room for same team users */

        $room = $this->Chatroom->find('first', [
            'conditions' => [
                'Chatroom.tournament_id' => AuthComponent::User('sportSession.tournament_id'),
                'Chatroom.sport_id' => AuthComponent::User('sportSession.sport_id'),
                'Chatroom.locale_id' => AuthComponent::User('locale_id'),
                'Chatroom.league_id' => AuthComponent::User('sportSession.league_id'),
                'Chatroom.allowed_teams' => AuthComponent::User('sportSession.team_id'),
                'Chatroom.status' => 1
            ],
            'fields' => [
                'Chatroom.id'
            ]
        ]);

        if (! empty($room['Chatroom']['id']))
        {
            $this->Auth->Session->write($currentKey . '.sportSession.chatroom_id', $room['Chatroom']['id']);
            return true;
        }
        $this->request->data['Chatroom']['league_id'] = AuthComponent::User('sportSession.league_id');
        $this->request->data['Chatroom']['tournament_id'] = AuthComponent::User('sportSession.tournament_id');
        $this->request->data['Chatroom']['team_id'] = AuthComponent::User('sportSession.team_id');
        $this->request->data['Chatroom']['sport_id'] = AuthComponent::User('sportSession.sport_id');
        $this->request->data['Chatroom']['locale_id'] = AuthComponent::User('locale_id');
        $this->request->data['Chatroom']['allowed_teams'] = AuthComponent::User('sportSession.team_id');
        $this->request->data['Chatroom']['name'] = 'chatRoom';
        if ($this->Chatroom->save($this->request->data))
        {
            $this->Auth->Session->write($currentKey . '.sportSession.chatroom_id', $this->Chatroom->getLastInsertID());
            return true;
            // return $this->redirect(array('controller' => 'walls', 'action' => 'index'));
        }
        $this->Flash->error(__('Not able to save record. Please, try again.'));
        return false;
        // return $this->redirect(array('controller' => 'walls', 'action' => 'index'));
    }

    public function change_play_status_1()
    {
        $this->loadModel('Game');
        $this->autoRender = false;
         $today= date('Y-m-d');
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
         if(!empty($gameDetails)){
        $date = new DateTime($gameDetails['Game']['start_time']);
        $date->sub(new DateInterval('PT1H'));
        $gamestarttime=$date->format('Y-m-d H:i:s') . "\n";
        $gameStatus = $this->Game->find('all', [
            'conditions' => [
                'Game.play_status' => 0,
                'Game.tournament_id' => $tournamentId,
                'Game.league_id ' =>$leagueId,
                'Game.sport_id' => $sportId,
                //'date(Game.start_time)' =>$today,
                //'Game.start_time <=' => $predictiondate,
                'OR' => array(
                'Game.first_team' => $teamId,
                'Game.second_team' => $teamId
                ),
        array(
        '(Game.start_time) BETWEEN ? AND ?' => array($gamestarttime, $gameDetails['Game']['end_time']), 
    )
            ],
            'fields' => [
                'Game.id',
                'Game.start_time'
            ]
        ]);

        //pr($gameStatus);exit;
        foreach ($gameStatus as $gameStatus)
        {

            //if ($predictiondate >= date('Y-m-d h:i', strtotime($gameStatus['Game']['start_time'])))
            //{
                $this->request->data['Game']['play_status'] = 1;
                $this->request->data['Game']['id'] = $gameStatus['Game']['id'];
                $this->Game->save($this->request->data);
                echo '1';
            //}
        }
    }
    }
     public function change_play_status_0()
    {
        $this->loadModel('Game');
        $this->autoRender = false;

        $enddate = date('Y-m-d H:i:s');
        $leagueId = $this->Auth->Session->read('Auth.User.sportSession.league_id');
        $sportId = $this->Auth->Session->read('Auth.User.sportSession.sport_id');
        $teamId = $this->Auth->Session->read('Auth.User.sportSession.team_id');
       $tournamentId = $this->Auth->Session->read('Auth.User.sportSession.tournament_id');
        $this->Game->UnbindModel([
            'hasMany' => [
                'Team'
            ]
        ], false);

        $gameStatus = $this->Game->find('all', [
            'conditions' => [
                 'Game.play_status' => 1,
                'Game.tournament_id' => $tournamentId,
                'Game.league_id ' =>$leagueId,
                'Game.sport_id' => $sportId,
                'Game.end_time <=' => $enddate,
                'OR' => array(
                'Game.first_team' => $teamId,
                'Game.second_team' => $teamId)
            ],
            'fields' => [
                'Game.id',
                'Game.end_time'
            ]
        ]);

        foreach ($gameStatus as $gameStatus)
        {

           // if (date('Y-m-d h:i') >=date('Y-m-d h:i', strtotime($gameStatus['Game']['end_time'])))
           // {
                $this->request->data['Game']['play_status'] = 0;
                $this->request->data['Game']['id'] = $gameStatus['Game']['id'];
                $this->Game->save($this->request->data);
                echo '0';
           // }
        }
    }

    /**
     * **************************************Editor Section Starts here*********************************************
     */

    /**
     * blogger_index method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_index()
    {
        $this->loadModel('WallContent');
        $this->loadModel('Team');
        $this->loadModel('UserTeam');
        $this->WallContent->unbindModel([
            'hasMany' => [
                'WallComment'
            ]
        ]);
        $userTeamCount = $this->UserTeam->find('count', [
            'conditions' => [
                'UserTeam.user_id' => AuthComponent::User('id')
            ]
        ]);
        if ($userTeamCount == 0)
        {
            return $this->redirect([
                'controller' => 'userTeams',
                'action' => 'add'
            ]);
        }
        $Userteam = $this->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.user_id' => AuthComponent::User('id')
            ],
            'fields' => [
                'UserTeam.tournament_id',
                'UserTeam.sport_id',
                'UserTeam.league_id',
                'UserTeam.team_id'
            ]
        ]);
        $currentKey = AuthComponent::$sessionKey;
        $sportsession = $this->Auth->Session->read($currentKey . '.sportSession');
        if (! empty($Userteam) && empty($sportsession))
        {

            $this->Auth->Session->write($currentKey . '.sportSession.league_id', $Userteam['UserTeam']['league_id']);
            $this->Auth->Session->write($currentKey . '.sportSession.tournament_id', $Userteam['UserTeam']['tournament_id']);
            $this->Auth->Session->write($currentKey . '.sportSession.team_id', $Userteam['UserTeam']['team_id']);
            $this->Auth->Session->write($currentKey . '.sportSession.sport_id', $Userteam['UserTeam']['sport_id']);
        }
        $videos = $this->WallContent->find('all', [
            'conditions' => [
                'WallContent.user_id' => AuthComponent::User('id')
            ],
            'fields' => [
                'WallContent.title',
                'WallContent.name',
                'WallContent.status_name',
                'WallContent.id'
            ]
        ]);

        $this->set(compact('videos'));
    }

    /**
     * blogger_view method
     *
     * @param null|mixed $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_view($id = null)
    {
        $this->loadModel('WallContent');
        $id = base64_decode($id);
        if (! $this->WallContent->exists($id))
        {
            $this->Flash->error(__('Invalid video.'));
            return [
                'success' => 0,
                'redirect' => false
            ];
        }

        $videos = $this->WallContent->find('first', [
            'conditions' => [
                'WallContent.id' => $id
            ]
        ]);
        $this->set(compact('videos'));
    }

    /**
     * blogger_edit method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function editor_edit($id = null)
    {
        $this->loadModel('WallContent');
        $this->loadModel('Team');
        $id = base64_decode($id);

        if ($this->request->is([
            'post',
            'put'
        ]))
        {

            $youtubeLink = $this->request->data['WallContent']['name'];
            $rx = '~
                            ^(?:https?://)?              # Optional protocol
                             (?:www\.)?                  # Optional subdomain
                             (?:youtube\.com|youtu\.be)  # Mandatory domain name
                             /watch\?v=([^&]+)           # URI with video id as capture group 1
                             ~x';

            $has_match = preg_match($rx, $youtubeLink);

            if (! $has_match)
            {
                $this->Flash->error(__('The youtube link is not valid. Please, try again.'));
                return $this->redirect([
                    'controller' => 'dashboard',
                    'action' => 'index',
                    'editor' => true
                ]);
            }
            if ($this->WallContent->save($this->request->data))
            {
                $this->Flash->success(__('The video has been saved.'));
                return $this->redirect([
                    'controller' => 'dashboard',
                    'action' => 'index',
                    'editor' => true
                ]);
            }
            $this->Flash->error(__('The video could not be saved. Please, try again.'));
        }
        else
        {
            $this->request->data = $this->WallContent->find('first', [
                'conditions' => [
                    'WallContent.id' => $id
                ]
            ]);
        }

        $teams = $this->Team->find('list');
        $this->set(compact('teams', 'WallContent'));
    }

    /**
     * blogger_delete method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_delete($id = null)
    {
        $this->loadModel('WallContent');
        $id = base64_decode($id);
        if (! $this->WallContent->exists($id))
        {
            $this->Flash->error(__('Invalid video Id.'));
            return $this->redirect([
                'controller' => 'dashboard',
                'action' => 'index'
            ]);
        }

        if ($this->WallContent->delete($id))
        {
            $this->Flash->success(__('The video has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The video could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'controller' => 'dashboard',
            'action' => 'index'
        ]);
    }

    /**
     * editor_myProfile method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_myProfile()
    {
        $this->set('title_for_layout', __('My Profile'));
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $currentKey = AuthComponent::$sessionKey;
            $id = $this->request->data['User']['id'];
            if (! $this->User->exists($id))
            {
                $this->Flash->error(__('Invalid user.'));
                return [
                    'success' => 0,
                    'redirect' => false
                ];
            }
            if (isset($this->data['User']['file_id']['name']))
            {
                $tmpName = $this->data['User']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }
                $exten = explode('.', $this->data['User']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {
                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['User']['file_id'];
                    $destination = 'img/ProfileImages/large/';
                    $destination2 = 'img/ProfileImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '180', 'jpg', '180', '180');
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '50', 'jpg', '40', '50');

                    $files_data = $this->data['User']['file_id'];
                    if (empty($this->request->data['User']['update_file_id']))
                    {
                        unset($this->request->data['User']['update_file_id']);
                    }
                    else
                    {
                        $pushValue = [
                            'file_id' => $this->data['User']['update_file_id']
                        ];
                        $files_data = array_merge($files_data, $pushValue);
                    }

                    $files_data = $this->data['User']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/ProfileImages/', $fileName);
                    if ($upload_info['uploaded'] == 1)
                    {

                        $this->request->data['User']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->User->save($this->request->data))
                        {
                            $this->Auth->Session->write($currentKey . '.File.new_name', $fileName);
                            $this->Auth->Session->write($currentKey . '.File.path', '/img/ProfileImages/' . $fileName);
                            $this->Session->write('Auth.File.new_name', $fileName);
                            $this->Session->write('Auth.File.path', '/img/ProfileImages/' . $fileName);
                            $this->Flash->success(__('Profile saved successfully.'));
                            return $this->redirect([
                                'action' => 'myProfile',
                                'editor' => true
                            ]);
                        }
                        $this->Flash->error(__('Profile could not be saved. Please, try again.'));
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
                unset($this->request->data['User']['file_id']);
                if ($this->User->save($this->request->data))
                {
                    $this->Auth->Session->write($currentKey . '.name', $this->data['User']['name']);
                    $this->Flash->success(__('Profile has been updated successfully.'));
                }
                else
                {
                    $this->Flash->error(__('Profile can not be saved! Please try again.'));
                }
                return $this->redirect([
                    'action' => 'myProfile',
                    'editor' => true
                ]);
            }
        }
        else
        {
            $this->request->data = $users = $this->User->find('first', [
                'conditions' => [
                    'User.' . $this->User->primaryKey => AuthComponent::User('id')
                ]
            ]);
        }
        $this->set(compact('users'));
    }

/**
 * **************************************Editor Section Ends Here***********************************************
 */
}