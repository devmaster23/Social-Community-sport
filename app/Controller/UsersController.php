<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
// session_start();
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
class UsersController extends AppController
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

    /**
     * __generateRandomPassword method
     *
     * @param null|mixed $length
     *
     * @return void
     */
    private function __generateRandomPassword($length = null)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; ++ $i)
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * beforeFilter method
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('google_callback', 'login', 'blogger_login', 'blogger_logout', 'forgot_password', 'signup', 'verify_email', 'loginbyfacebook', 'afterFbLogin', 'twitterSetup', 'twitterLogin', 'checkEmailExist', 'locale', 'editor_login', 'mailsc');
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
        $this->User->recursive = 0;
        $this->User->bindModel([
            'belongsTo' => [
                'Role' => [
                    'classname' => 'Role',
                    'foreign_key' => 'role_id'
                ]
            ]
        ]);
        $fields = [
            'User.id',
            'User.name',
            'User.email',
            'User.locale_id',
            'User.role_id',
            'User.title',
            'User.sex',
            'User.status_name',
            'Role.name',
            'Locale.name'
        ];

        $this->paginate = [
            'contain' => false,
            'limit' => LIMIT,
            'conditions' => $conditions,
            'fields' => $fields,
            'order' => $order
        ];

        $this->set('users', $this->paginate('User'));

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
        $gender = [
            'Male',
            'Female'
        ];
        $status = [
            'Inactive',
            'Active',
            'Blocked'
        ];
        $this->set(compact('roles', 'locales', 'gender', 'status'));
    }

    /**
     * delete_listing method
     *
     * @param string     $id
     * @param mixed      $conditions1
     * @param null|mixed $order
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function user_deleted($conditions1 = [], $order = null)
    {
        if (empty($conditions1))
        {
            $conditions = [
                'User.status' => '0',
                'User.is_deleted' => '0'
            ];
        }
        else
        {
            $conditions = [
                'User.status' => '0',
                'User.is_deleted' => '0'
            ];
            $conditions = array_merge($conditions1, $conditions);
        }

        $this->User->recursive = 0;
        $this->User->bindModel([
            'belongsTo' => [
                'Role' => [
                    'classname' => 'Role',
                    'foreign_key' => 'role_id'
                ]
            ]
        ]);
        $fields = [
            'User.id',
            'User.name',
            'User.email',
            'User.locale_id',
            'User.role_id',
            'User.title',
            'User.sex',
            'User.status_name',
            'Role.name',
            'Locale.name'
        ];

        $this->paginate = [
            'contain' => false,
            'limit' => LIMIT,
            'conditions' => $conditions,
            'fields' => $fields,
            'order' => $order
        ];

        $this->set('users', $this->paginate('User'));

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
        $gender = [
            'Male',
            'Female'
        ];
        $status = [
            'Inactive',
            'Active',
            'Blocked'
        ];
        $this->set(compact('roles', 'locales', 'gender', 'status'));
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
    public function view($id = null)
    {
        $this->set('title_for_layout', __('View User'));

        if (! $this->User->exists($id))
        {
            throw new NotFoundException(__('Invalid user'));
        }

        $options = [
            'conditions' => [
                'User.' . $this->User->primaryKey => $id
            ]
        ];
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $this->set('title_for_layout', __('Add Users'));

        if ($this->request->is('post'))
        {
            $this->User->create();
            if ($this->User->save($this->request->data))
            {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }

            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->User->Role->find('list');
        $locales = $this->User->Locale->find('list');
        $files = $this->User->File->find('list');
        $this->set(compact('roles', 'locales', 'files'));
    }

    /**
     * _create_user method
     *
     * @return void
     */
    public function _create_user()
    {
        if ($this->request->is('post'))
        {
            if ($this->data['User']['file_id']['name'])
            {
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
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/ProfileImages/', $filename);
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->User->create();
                        $this->request->data['User']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->User->save($this->request->data))
                        {
                            $this->Flash->success(__('The user has been saved.'));
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
                unset($this->request->data['User']['file_id']);
                $this->User->create();

                if ($this->User->save($this->request->data))
                {
                    $this->Flash->success(__('The user has been saved.'));
                    return [
                        'success' => 1,
                        'redirect' => [
                            'action' => 'index'
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
        $this->set('title_for_layout', __('Update User'));

        if (! $this->User->exists($id))
        {
            $this->Flash->error(__('Invalid user.'));
            return [
                'success' => 0,
                'redirect' => false
            ];
        }

        // pr($this->request->data);die;
        if ($this->request->data['User']['file_id']['name'])
        {
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
                $pushValue = [
                    'file_id' => $this->data['User']['update_file_id']
                ];
                $files_data = array_merge($files_data, $pushValue);
                $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/ProfileImages/', $filename);
                if ($upload_info['uploaded'] == 1)
                {
                    $this->User->create();
                    $this->request->data['User']['file_id'] = $upload_info['db_info']['Upload']['id'];
                    if ($this->User->save($this->request->data))
                    {
                        $this->Flash->success(__('The user has been saved.'));
                        return [
                            'success' => 1,
                            'redirect' => [
                                'action' => 'index'
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
                $this->Flash->success(__('The user has been saved.'));
                return [
                    'success' => 1,
                    'redirect' => [
                        'action' => 'index'
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
     * delete method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function delete($id = null)
    {
        $this->set('title_for_layout', __('Delete User'));
        $this->User->id = $id;

        if (! $this->User->exists())
        {
            $this->Flash->error(__('Invalid user.'));
            return $this->redirect([
                'action' => 'index'
            ]);
        }

        $this->request->allowMethod('post', 'delete');

        if ($this->User->delete())
        {
            $this->Flash->success(__('The user has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'List User');
        $conditions = [];
        $conditions = $this->_getSearchConditions();

        $this->index($conditions, 'User.created DESC');

        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
    }

    public function admin_deleted()
    {
        $this->set('title_for_layout', 'List User');
        $conditions = [];
        $conditions = $this->_getSearchConditions();

        $this->user_deleted($conditions, 'User.created DESC');

        $roles = $this->User->Role->find('list');
        // pr($roles);die;
        $this->set(compact('roles'));
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
        $this->set('title_for_layout', 'View User');
        $id = base64_decode($id);
        if (! $this->User->exists($id))
        {
            $this->Flash->error(__('Invalid user.'));
            return $this->redirect([
                'action' => 'index'
            ]);
        }
        $options = [
            'conditions' => [
                'User.' . $this->User->primaryKey => $id
            ]
        ];
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', 'Add User');
        if ($this->request->is('post'))
        {
            if ($this->data['User']['file_id']['name'])
            {

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
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/ProfileImages/', $fileName);
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->User->create();
                        $this->request->data['User']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->User->save($this->request->data))
                        {
                            $this->Flash->success(__('The user has been saved.'));
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
                unset($this->request->data['User']['file_id']);
                $this->User->create();
                if ($this->User->save($this->request->data))
                {
                    $this->Flash->success(__('The user has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }

        $roles = $this->User->Role->find('list');
        $locales = $this->User->Locale->find('list');
        $files = $this->User->File->find('list');
        $this->set(compact('roles', 'locales', 'files'));
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
        $this->set('title_for_layout', 'Update User');
        $id = base64_decode($id);

        if (! $this->User->exists($id))
        {
            $this->Flash->error(__('Invalid user.'));
            return $this->redirect([
                'action' => 'index'
            ]);
        }

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->data['User']['file_id']['name'])
            {
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
                    $pushValue = [
                        'file_id' => $this->data['User']['update_file_id']
                    ];
                    $files_data = array_merge($files_data, $pushValue);
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/ProfileImages/', $filename);
                    if ($upload_info['uploaded'] == 1)
                    {

                        $this->request->data['User']['file_id'] = $upload_info['db_info']['Upload']['id'];

                        if ($this->User->save($this->request->data))
                        {
                            $this->Flash->success(__('The user has been saved.'));
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
                unset($this->request->data['User']['file_id']);

                if ($this->User->save($this->request->data))
                {
                    $this->Flash->success(__('The user has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
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
        $roles = $this->User->Role->find('list');
        $locales = $this->User->Locale->find('list');
        $files = $this->User->File->find('list');
        $this->set(compact('roles', 'locales', 'files'));
    }

    /**
     * admin_delete method
     *
     * @param string     $id
     * @param null|mixed $id_passed
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_delete($id_passed = null)
    {
        $this->set('title_for_layout', 'Delete User');
        $id = base64_decode($id_passed);
        $this->User->id = $id;
        if (! $this->User->exists())
        {
            $this->Flash->error(__('Invalid user.'));
            return $this->redirect([
                'action' => 'index'
            ]);
        }
        $user_array = [
            'User' => [
                'id' => $id,
                'is_deleted' => 1
            ]
        ];
        $this->User->validate = false;
        if ($this->User->save($user_array))
        {
            $this->Flash->success(__('The user has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * login method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function _login()
    {
        if (! empty($this->request->data))
        {
            if ($this->Auth->login())
            {
                // Remember me code using cookies
                if (isset($this->request->data['User']['remember_me']) && ! empty($this->request->data['User']['remember_me']))
                {
                    // if user check the remember me checkbox
                    $twoDays = 60 * 60 * 24 * 2 + time();
                    setcookie('email', $this->request->data['User']['email'], $twoDays);
                    setcookie('password', $this->request->data['User']['password'], $twoDays);
                }
                else
                {
                    // if user not check the remember me checkbox
                    $twoDaysBack = time() - 60 * 60 * 24 * 2;
                    setcookie('email', '', $twoDaysBack);
                    setcookie('password', '', $twoDaysBack);
                }

                $name_of_user = $this->Auth->user('name');
                $this->Flash->success(__('Welcome') . ' ' . $name_of_user);

                return [
                    'login' => 1,
                    'redirect' => $this->Auth->loginRedirect
                ];
            }

            $this->Flash->error(__('Invalid Email or Password.'));
            return [
                'login' => 0,
                'redirect' => $this->Auth->logoutRedirect
            ];
        }
    }

    public function login()
    {
        $this->set('title_for_layout', __('User Login'));
        $this->set('socialRoleSet', 5);
        $this->loadModel('UserLoging');
        if (! empty($this->request->data))
        {
            if ($this->Auth->login())
            {
                // echo AuthComponent::user('Locale.code');
                $this->Session->write('Config.language', AuthComponent::user('Locale.code'));
                Configure::write('Config.language', $this->Session->read('Config.language'));
                // pr($_SESSION);die;
                $user_id = AuthComponent::user('id');
                // Remember me code using cookies
                if (isset($this->request->data['User']['remember_me']) && ! empty($this->request->data['User']['remember_me']))
                {
                    // if user check the remember me checkbox
                    $twoDays = 60 * 60 * 24 * 2 + time();
                    setcookie('email', $this->request->data['User']['email'], $twoDays, '/');
                    setcookie('password', $this->request->data['User']['password'], $twoDays, '/');
                }
                else
                {
                    // if user not check the remember me checkbox
                    $twoDaysBack = time() - 60 * 60 * 24 * 2;
                    setcookie('email', '', $twoDaysBack, '/');
                    setcookie('password', '', $twoDaysBack, '/');
                }

                $name_of_user = $this->Auth->user('name');
                // AuthComponent::user('role_id');
                if (AuthComponent::user('role_id') == 7)
                {
                    $this->Flash->success(__('Welcome') . ' ' . $name_of_user);
                    $this->redirect([
                        'controller' => 'editors',
                        'action' => 'index',
                        'editor' => true
                    ]);
                }
                else
                {
                    if (AuthComponent::user('steps') == 1)
                    {
                        $this->Flash->success(__('Welcome') . ' ' . $name_of_user . ', ' . __('Select your team.'));
                        return $this->redirect([
                            'controller' => 'userTeams',
                            'action' => 'add'
                        ]);
                    }
                    $enddate = date('Y-m-d H:i:s');
                    $this->User->id = $user_id;
                    $this->UserLoging->saveField('user_id', $user_id);
                    $this->UserLoging->saveField('loging_time', $enddate);
                    // pr($sata);exit;
                    $this->Flash->success(__('Welcome') . ' ' . $name_of_user);
                    $this->redirect('/dashboard');
                }
            }
            else
            {
                $this->Flash->error(__('Invalid Email or Password.'), [
                    'key' => 'loginError'
                ]);
                return $this->redirect(Router::url($this->referer(), true));
            }
        }
    }

    public function admin_loginasuser($userId = null)
    {
        // $userId = base64_decode($userId);
        if (empty($userId))
        {
            $this->Flash->success(__('Invalid User'));
            $this->redirect($this->referer());
        }
        $admin_info = $this->User->find('first', [
            'conditions' => [
                'User.id' => $userId
            ]
        ]);
        // $admin_info['User']['fromadmin'] = 1;
        if (! empty($admin_info))
        {
            $userData = $this->Auth->login($admin_info['User']);
            echo '<pre>';
            print_r($userData);
            die();
            $this->redirect([
                'controller' => 'admins',
                'action' => 'dashboard',
                'admin' => true
            ]);
        }
        die();
    }

    /**
     * logout method
     *
     * @param null|mixed $sessionKey
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function logout($sessionKey = NULL)
    { $this->loadModel('UserLoging');
        if ($sessionKey === FALSE)
        {
            $this->Flash->error('Unauthenticated Request');
            $this->redirect('/');
        }
            $user_id = AuthComponent::user('id');
            $enddate = date('Y-m-d H:i:s');
            //$this->UserLoging->user_id = $user_id; 
           // $this->UserLoging->saveField('logout_time', $enddate);
            $this->UserLoging->updateAll(
            array('UserLoging.logout_time' => "'".$enddate."'"), 
            array(
                'UserLoging.user_id' => $user_id,
                'UserLoging.logout_time' => "0000-00-00 00:00:00"
            )
            );
          //  $this->Event->id = $id;
        // $this->Event->saveField('is_featured', true);
        if (empty($sessionKey))
        {
            $this->Session->delete('Auth');
        }
        $this->Session->delete('Auth.' . $sessionKey);
        return $this->redirect([
            'controller' => 'users',
            'action' => 'login'
        ]);
    }

    /**
     * blogger_logout method
     *
     * @param null|mixed $sessionKey
     *
     * @throws NotFoundException
     *
     * @return void
     */
    // public function blogger_logout() {
    // $this->Session->delete("Auth");
    // $this->Session->destroy();
    // $return = $this->Auth->logout();
    // return $this->redirect("/");
    // }
    public function blogger_logout($sessionKey = NULL)
    {
        if ($sessionKey === FALSE)
        {
            $this->Flash->error('Unauthenticated Request');
            $this->redirect('/');
        }
        $this->Session->delete('Auth.' . $sessionKey);
        return $this->redirect([
            'controller' => 'users',
            'action' => 'login'
        ]);
    }

    /**
     * blogger_login method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function blogger_login()
    {
        $this->set('title_for_layout', __('Video Uploader Login'));
        $this->set('socialRoleSet', 6);
        if (! empty($this->request->data))
        {
            if ($this->User->validates())
            {

                if ($this->Auth->login())
                {
                    $this->Session->write('Config.language', AuthComponent::user('Locale.code'));
                    Configure::write('Config.language', $this->Session->read('Config.language'));

                    // Remember me code using cookies
                    if (isset($this->request->data['User']['remember_me']) && ! empty($this->request->data['User']['remember_me']))
                    {
                        // if user check the remember me checkbox
                        $twoDays = 60 * 60 * 24 * 2 + time();
                        setcookie('email', $this->request->data['User']['email'], $twoDays, '/');
                        setcookie('password', $this->request->data['User']['password'], $twoDays, '/');
                    }
                    else
                    {
                        // if user not check the remember me checkbox
                        $twoDaysBack = time() - 60 * 60 * 24 * 2;
                        setcookie('email', '', $twoDaysBack, '/');
                        setcookie('password', '', $twoDaysBack, '/');
                    }
                    $name_of_user = $this->Auth->user('name');
                    $this->Flash->success(__('Welcome') . ' ' . $name_of_user . '!');
                    if (AuthComponent::user('role_id') == 6)
                    {
                        if (AuthComponent::user('steps') == 1)
                        {
                            $this->Flash->success(__('Welcome') . ' ' . $name_of_user . ', ' . __('Select your team.'));
                            return $this->redirect([
                                'controller' => 'userTeams',
                                'action' => 'add',
                                'blogger' => true
                            ]);
                        }
                        $this->Flash->success(__('Welcome') . ' ' . $name_of_user . '!');
                        $this->redirect([
                            'controller' => 'dashboard',
                            'action' => 'index',
                            'blogger' => true
                        ]);
                    }
                    else
                        if (AuthComponent::user('role_id') == 7)
                        { // die('here');
                            $this->Flash->success(__('Welcome') . ' ' . $name_of_user . '!');
                            $this->redirect([
                                'controller' => 'dashboard',
                                'action' => 'index',
                                'editor' => true
                            ]);
                        }
                }
                else
                {
                    $this->Flash->error(__('Invalid Email or Password.'), [
                        'key' => 'videoBloginError'
                    ]);
                    return $this->redirect(Router::url($this->referer(), true));
                }
            }
            else
            {
                $error = $this->User->validationErrors;
                $this->Session->setFlash(__('Some errors occurred ! Please try again'));
                $this->Session->write('reg.validation_errors', $error);
                $this->Session->write('reg.status', 1);
                $this->redirect('/');
            }
        }
        $this->render('login');
    }

    /**
     * blogger_logout method
     *
     * @param null|mixed $sessionKey
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_logout($sessionKey = NULL)
    {
        if ($sessionKey === FALSE)
        {
            $this->Flash->error('Unauthenticated Request');
            $this->redirect('/');
        }

        $this->Session->delete('Auth.' . $sessionKey);

        return $this->redirect([
            'controller' => 'users',
            'action' => 'login'
        ]);
    }

    /**
     * blogger_login method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_login()
    {
        $this->set('title_for_layout', __('Editor Login'));
        $this->set('socialRoleSet', 7);

        if (! empty($this->request->data))
        {
            if ($this->User->validates())
            {

                if ($this->Auth->login())
                {
                    $this->Session->write('Config.language', AuthComponent::user('Locale.code'));
                    Configure::write('Config.language', $this->Session->read('Config.language'));
                    $user_id = AuthComponent::user('id');

                    // Remember me code using cookies
                    if (isset($this->request->data['User']['remember_me']) && ! empty($this->request->data['User']['remember_me']))
                    {
                        // if user check the remember me checkbox
                        $twoDays = 60 * 60 * 24 * 2 + time();
                        setcookie('email', $this->request->data['User']['email'], $twoDays, '/');
                        setcookie('password', $this->request->data['User']['password'], $twoDays, '/');
                    }
                    else
                    {
                        // if user not check the remember me checkbox
                        $twoDaysBack = time() - 60 * 60 * 24 * 2;
                        setcookie('email', '', $twoDaysBack, '/');
                        setcookie('password', '', $twoDaysBack, '/');
                    }
                    $name_of_user = $this->Auth->user('name');
                    AuthComponent::user('role_id');
                    $this->Flash->success(__('Welcome') . ' ' . $name_of_user . '!');

                    return $this->redirect([
                        'controller' => 'editors',
                        'action' => 'index',
                        'editor' => true
                    ]);
                }
                $this->Flash->error(__('Invalid Email or Password.'), [
                    'key' => 'editorError'
                ]);
                return $this->redirect(Router::url($this->referer(), true));
            }
            $error = $this->User->validationErrors;
            $this->Session->setFlash(__('Some errors occurred ! Please try again'));
            $this->Session->write('reg.validation_errors', $error);
            $this->Session->write('reg.status', 1);
            $this->redirect('/');
        }
        $this->render('login');
    }

    /**
     * sports_index method
     *
     * @return void
     */
    public function sports_index()
    {
        $this->set('title_for_layout', 'List Sports');
        $conditions = [];
        $conditions = $this->_getSearchConditions();

        $this->index($conditions, 'User.created DESC');
    }

    /**
     * sports_edit method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function sports_edit($id = null)
    {
        $this->set('title_for_layout', 'Edit Sport');
        $id = base64_decode($id);
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
        $files = $this->User->File->find('list');
        $this->set(compact('roles', 'locales', 'files'));
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
        $this->set('title_for_layout', 'View Sport');
        $id = base64_decode($id);
        if (! $this->User->exists($id))
        {
            $this->Flash->error(__('Invalid user.'));
            return $this->redirect([
                'action' => 'index'
            ]);
        }
        $options = [
            'conditions' => [
                'User.' . $this->User->primaryKey => $id
            ]
        ];
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * sports_delete method
     *
     * @param string     $id
     * @param null|mixed $id_passed
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_delete($id_passed = null)
    {
        $this->set('title_for_layout', 'Delete User');
        $id = base64_decode($id_passed);
        $this->User->id = $id;
        if (! $this->User->exists())
        {
            $this->Flash->error(__('Invalid user.'));
            return $this->redirect([
                'action' => 'index'
            ]);
        }
        $user_array = [
            'User' => [
                'id' => $id,
                'is_deleted' => 1
            ]
        ];
        $this->User->validate = false;
        if ($this->User->save($user_array))
        {
            $this->Flash->success(__('The user has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
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
        $this->set('title_for_layout', 'List Leagues');
        $conditions = [];
        $conditions = $this->_getSearchConditions();

        $this->index($conditions, 'User.created DESC');
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
        $this->set('title_for_layout', 'View League');
        $id = base64_decode($id);
        if (! $this->User->exists($id))
        {
            $this->Flash->error(__('Invalid user.'));
            return $this->redirect([
                'action' => 'index'
            ]);
        }
        $options = [
            'conditions' => [
                'User.' . $this->User->primaryKey => $id
            ]
        ];
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * league_add method
     *
     * @return void
     */
    public function league_add()
    {
        $this->set('title_for_layout', 'Add League');
        $return = $this->_create_user();
        if (isset($return['success']))
        {
            if ($return['success'])
            {
                $this->redirect($return['redirect']);
            }
        }
    }

    /**
     * league_edit method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function league_edit($id = null)
    {
        $this->set('title_for_layout', 'Update League');
        $id = base64_decode($id);
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
        $files = $this->User->File->find('list');
        $this->set(compact('roles', 'locales', 'files'));
    }

    /**
     * team_index method
     *
     * @return void
     */
    public function team_index()
    {
        $this->set('title_for_layout', 'List Team');
        $conditions = [];
        // $conditions['LEFT JOIN UserTeam'];

        $conditions = $this->_getSearchConditions();
        // pr($conditions);
        $this->index($conditions, 'User.created DESC');
    }

    /**
     * team_view method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function team_view($id = null)
    {
        $this->set('title_for_layout', 'View Team');
        $id = base64_decode($id);
        if (! $this->User->exists($id))
        {
            $this->Flash->error(__('Invalid user.'));
            return $this->redirect([
                'action' => 'index'
            ]);
        }
        $options = [
            'conditions' => [
                'User.' . $this->User->primaryKey => $id
            ]
        ];
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * team_edit method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function team_edit($id = null)
    {
        $this->set('title_for_layout', 'Update Team');
        $id = base64_decode($id);
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
        $files = $this->User->File->find('list');
        $this->set(compact('roles', 'locales', 'files'));
    }

    /**
     * sports_add method
     *
     * @return void
     */
    public function sports_add()
    {
        $this->set('title_for_layout', 'Add Sport');
        $return = $this->_create_user();

        if (isset($return['success']))
        {
            if ($return['success'])
            {
                $this->redirect($return['redirect']);
            }
        }
    }

    /**
     * team_add method
     *
     * @return void
     */
    public function team_add()
    {
        $this->set('title_for_layout', 'Add Team');
        $return = $this->_create_user();

        if (isset($return['success']))
        {
            if ($return['success'])
            {
                $this->redirect($return['redirect']);
            }
        }
    }

    /**
     * forgot_password method
     *
     * @return void
     */
    public function forgot_password()
    {
        $this->set('title_for_layout', __('Forgot Password'));
        $this->loadModel('EmailTemplate');

        if (! empty($this->request->data))
        {
            $updatePassword = $this->__generateRandomPassword(6);
            $userEmail = $this->request->data('User.email');

            $resultStatus = $this->User->find('first', [
                'conditions' => [
                    'User.email' => $userEmail
                ]
            ]);

            if (! empty($resultStatus) && $resultStatus['User']['email'] == $userEmail)
            {
                $this->User->id = $resultStatus['User']['id'];
                $this->User->saveField('password', $updatePassword);
                $emailTemplate = $this->EmailTemplate->find('first', [
                    'conditions' => [
                        'EmailTemplate.id' => 1
                    ]
                ]);
                $subject = $emailTemplate['EmailTemplate']['subject'];
                $emailTemplate = str_replace([
                    '{NAME}',
                    '{NewPassword}'
                ], [
                    $resultStatus['User']['name'],
                    $updatePassword
                ], $emailTemplate['EmailTemplate']['description']);
                $this->_sendSmtpMail($subject, $emailTemplate, $userEmail);

                $this->Flash->success(__('Your password has been sent to your email. Please check your email'));

                if ($resultStatus['User']['role_id'] == 6)
                {
                    return $this->redirect([
                        'controller' => 'users',
                        'action' => 'login',
                        'blogger' => true
                    ]);
                }

                return $this->redirect([
                    'action' => 'login'
                ]);
            }

            $this->Flash->error(__('Your email does not exist. Please, try again.'));
        }
    }

    /**
     * changePassword method
     *
     * @param null|mixed $data
     *
     * @throws NotFoundException When the view file could not be found
     *                           or MissingViewException in debug mode.
     *
     * @return void
     */
    public function changePassword($data = null)
    {
        $this->set('title_for_layout', __('Change Password'));
        $this->layout = 'login';

        if (! empty($this->request->data))
        {
            $currentPassword = $this->request->data('User.current_password');
            $newPassword = $this->request->data('User.new_password');
            $confirmPassword = $this->request->data('User.re_enter_password');
            $id = AuthComponent::User('id');

            if ($currentPassword != '' && $newPassword != '' && $confirmPassword != '')
            {
                $savedPwd = $this->User->find('first', [
                    'conditions' => [
                        'User.id' => $id
                    ],
                    'fields' => [
                        'password'
                    ]
                ]);
                $enteredPassword = AuthComponent::password($this->data['User']['current_password']);
                if ($savedPwd['User']['password'] != $enteredPassword)
                {
                    $this->Flash->error(__('You have entered wrong password. Please, try again.'));
                    return $this->redirect([
                        'controller' => 'users',
                        'action' => 'changePassword'
                    ]);
                }
                else
                    if ($newPassword != $confirmPassword)
                    {
                        $this->Flash->error(__('New password does not match the Re-enter password. Please, try again.'));
                        return $this->redirect([
                            'controller' => 'users',
                            'action' => 'changePassword'
                        ]);
                    }
                $this->User->id = $id;
                $this->User->saveField('password', $newPassword);
                $this->Flash->success(__('Password has been changed successfully.'));
                return $this->redirect([
                    'controller' => 'userTeams',
                    'actisaon' => 'add'
                ]);
            }
            $this->Flash->error(__('Please fill all the fields.'));
            return $this->redirect([
                'controller' => 'users',
                'action' => 'changePassword'
            ]);
        }
    }

    /**
     * signup method
     * signup step1
     *
     * @return void
     */
    public function signup()
    {
        $this->set('title_for_layout', __('SignUp'));
        $this->loadModel('EmailTemplate');
        $this->autoRender = false;
        if ($this->request->is('post'))
        {
            $userEmail = $this->request->data('User.email');
            $name_of_user = $this->request->data['User']['name'];
            $this->User->validate = $this->User->validate;
            $this->User->set($this->request->data);
            if ($this->User->validates())
            {

                if ($this->data['User']['file_id']['name'])
                {
                    $tmpname = $this->data['User']['file_id']['tmp_name'];
                    $mimetype = $this->checkMimeTypeApp($tmpname);
                    if ($mimetype == 0)
                    {
                        $this->Flash->error(__('Please select a valid image format.'));
                        $this->redirect('/');
                    }

                    $exten = explode('.', $this->data['User']['file_id']['name']);
                    if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                    {

                        $filename = time() . '.' . $exten[1];
                        $file1 = $this->request->data['User']['file_id'];
                        $destination = 'img/ProfileImages/large/';
                        $destination2 = 'img/ProfileImages/thumbnail/';
                        $this->Resizer->upload($file1, $destination, $filename);
                        $this->Resizer->image($file1, 'resize', '180', 'jpg', '180', '180');
                        $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                        $this->Resizer->image($file1, 'resize', '50', 'jpg', '40', '50');

                        $files_data = $this->data['User']['file_id'];
                        $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/ProfileImages/', $filename);

                        if ($upload_info['uploaded'] == 1)
                        {
                            $this->User->create();
                            $this->request->data['User']['file_id'] = $upload_info['db_info']['Upload']['id'];
                            if ($this->User->save($this->request->data))
                            {
                                $lastInsertedId = $this->User->getLastInsertID();
                                // mail function
                                $this->signUpMail($lastInsertedId, $userEmail, $name_of_user);
                                $this->Flash->success(__('The user has been saved.'));
                                return $this->redirect([
                                    'action' => 'index'
                                ]);
                            }
                            $this->Flash->error(__('The user could not be saved. Please, try again.'));
                            $this->redirect('/');
                        }
                        else
                        {
                            $this->Flash->error(__('Unable to upload Image and save record. Please, try again.'));
                            $this->redirect('/');
                        }
                    }
                    else
                    {
                        $this->Flash->error(__('Please select a valid image format.'));
                        $this->redirect('/');
                    }
                }

                else
                {
                    unset($this->request->data['User']['file_id']);
                    $this->User->create();
                    $this->User->save($this->request->data, [
                        'validate' => false
                    ]);
                    $lastInsertedId = $this->User->getLastInsertID();
                    // mail function
                    $this->signUpMail($lastInsertedId, $userEmail, $name_of_user);
                }
            }
            else
            {

                $error = $this->User->validationErrors;
                $this->Session->setFlash(__('Some errors occurred ! Please try again'));
                $this->Session->write('reg.validation_errors', $error);
                $this->Session->write('reg.status', 1);
                $this->redirect('/');
            }
        }
    }

    /**
     * 
     * @param unknown $lastInsertedId
     * @param unknown $userEmail
     * @param unknown $name_of_user
     */
    public function signUpMail($lastInsertedId = null, $userEmail = null, $name_of_user = null)
    {
        $newUser = $this->User->find('first', [
            'conditions' => [
                'User.id' => $lastInsertedId
            ]
        ]);

        // email template
        $emailTemp = $this->EmailTemplate->find('first', [
            'conditions' => [
                'EmailTemplate.title' => 'New Registration'
            ]
        ]);
        // if($newUser['User']['role_id'] == 6){
        // $link = BASE_URL . 'users/verify_email/' . base64_encode($userEmail) . '/' . base64_encode($lastInsertedId);
        // } else {
        // $link = BASE_URL . 'users/verify_email/' . base64_encode($userEmail) . '/' . base64_encode($lastInsertedId);
        // }

        $link = BASE_URL . 'users/verify_email/' . base64_encode($userEmail) . '/' . base64_encode($lastInsertedId);
        $link = '<a href="' . $link . '" target="_blank" >"' . $link . '"</a>';
        $emailTemplate = str_replace([
            '{NAME}',
            '{verifylink}'
        ], [
            $name_of_user,
            $link
        ], $emailTemp['EmailTemplate']['description']);
        $subject = $emailTemp['EmailTemplate']['subject'];
        /*
         * $Email = new CakeEmail();
         * $Email->from(array(FROM_EMAIL => 'FansWage'))
         * ->to($userEmail)
         * ->subject($emailTemp['EmailTemplate']['subject'])
         * ->send($emailTemplate);
         */
        // echo $subject,$emailTemplate, $userEmail; die;
        $this->_sendSmtpMail($subject, $emailTemplate, $userEmail);

        $this->Flash->success(__('Hello') . ' ' . $name_of_user . ', ' . __('Please activate your account using the verification link sent to your email address.'));
        if ($newUser['User']['role_id'] == 6)
        {
            $this->redirect([
                'controller' => 'users',
                'action' => 'login',
                'blogger' => true
            ]);
        }
        else
            if ($newUser['User']['role_id'] == 7)
            {
                $this->redirect([
                    'controller' => 'users',
                    'action' => 'login',
                    'editor' => true
                ]);
            }
            else
            {
                $this->redirect([
                    'controller' => 'users',
                    'action' => 'login'
                ]);
            }
    }

    /**
     * verify_email method
     * signup step1
     *
     * @param null|mixed $email
     * @param null|mixed $id
     *
     * @return void
     */
    public function verify_email($email = null, $id = null)
    {
        $email = base64_decode($email);
        $id = base64_decode($id);

        $this->autoRender = false;
        $userExist = $this->User->find('first', [
            'conditions' => [
                'User.email' => $email,
                'User.id' => $id
            ]
        ]);

        if ($userExist['User']['status'] == 0)
        {
            $name_of_user = $userExist['User']['name'];
            $this->User->id = $id;
            $this->User->saveField('status', 1);
            $this->Flash->success(__('Welcome') . $name_of_user . '! ' . __('Your email has been verified. Please login.'));
            if ($userExist['User']['role_id'] == 6)
            {
                $this->redirect([
                    'controller' => 'users',
                    'action' => 'login',
                    'blogger' => true
                ]);
            }
            else
                if ($userExist['User']['role_id'] == 7)
                {
                    $this->redirect([
                        'controller' => 'users',
                        'action' => 'login',
                        'editor' => true
                    ]);
                }
                else
                {
                    $this->redirect([
                        'controller' => 'users',
                        'action' => 'login'
                    ]);
                }
        }
        else
            if ($userExist['User']['status'] == 1)
            {
                $this->Flash->success(__('You are already registerd with our website.Please use your credentials to login.'));
                if ($userExist['User']['role_id'] == 6)
                {
                    $this->redirect([
                        'controller' => 'users',
                        'action' => 'login',
                        'blogger' => true
                    ]);
                }
                else
                    if ($userExist['User']['role_id'] == 7)
                    {
                        $this->redirect([
                            'controller' => 'users',
                            'action' => 'login',
                            'editor' => true
                        ]);
                    }
                    else
                    {
                        $this->redirect([
                            'controller' => 'users',
                            'action' => 'login'
                        ]);
                    }
            }
            else
            {
                $this->Flash->success(__('Fanswage Welcomes you. Your email not verified. Please, try again.'));
                $this->redirect([
                    'controller' => 'users',
                    'action' => 'login'
                ]);
            }
    }

    /**
     * google_callback method
     * signup step1 or login if already exists
     *
     * @return void
     */
      public function google_callback()
    {
        // configur::write("debug",2);
        $this->loadModel('User');
        $this->loadModel('UserLoging');
        $this->autoRender = false;
        $this->User->recursive = 0;

        if (isset($_GET['code']))
        {
            $client_id = GOOGLE_CLIENT_ID;
            $client_secret = GOOGLE_SECRET_KEY;
            $redirect = GOOGLE_REDIRECT_URL;
            $fields = [
                'code' => urlencode($_GET['code']),
                'client_id' => urlencode($client_id),
                'client_secret' => urlencode($client_secret),
                'redirect_uri' => urlencode($redirect),
                'grant_type' => urlencode('authorization_code')
            ];
            $fields_string = '';
            foreach ($fields as $key => $value)
            {
                $fields_string .= $key . '=' . $value . '&';
            }
            $fields_string = rtrim($fields_string, '&');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
            curl_setopt($ch, CURLOPT_POST, 5);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($result);
            $accesstoken = $response->access_token;
            $token_url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $accesstoken;
            $responseUserInfo = file_get_contents($token_url);
            $new_array = json_decode($responseUserInfo, true);

            $google_id = $new_array['id'];
            $google_user = $this->User->find('first', [
                'conditions' => [
                    'User.google_id' => $google_id
                ]
            ]);

            if (empty($google_user))
            {
                $checkUseremail = $this->User->find('first', [
                    'conditions' => [
                        'User.email' => $new_array['email']
                    ]
                ]);
                if (isset($checkUseremail) && ! empty($checkUseremail))
                {
                    $this->User->updateAll([
                        'User.google_id' => "'" . $google_id . "'"
                    ], [
                        'User.id' => $checkUseremail['User']['id']
                    ]);

                    $this->checkRoleStepSocial($google_user, '', '');
                }
                $data['User']['email'] = $new_array['email'];
                $data['User']['name'] = $new_array['given_name'];
                $data['User']['role_id'] = $_COOKIE['myid'];
                $data['User']['locale_id'] = 1;
                $data['User']['gender'] = 0;
                if (array_key_exists('gender', $new_array))
                {
                    if ($new_array['gender'] == 'female')
                    {
                        $data['User']['gender'] = 1;
                    }
                }

                $data['User']['google_id'] = $google_id; // Google ID
                $data['User']['steps'] = 1; // Google ID
                if ($_COOKIE['myid'] == 7)
                {
                    $data['User']['steps'] = 2;
                }
                if ($this->User->save($data['User']))
                {
                    unset($_COOKIE['myid']);
                    $lastUserId = $this->User->getLastInsertId();
                    $user = $this->User->findById($lastUserId);
                    $enddate = date('Y-m-d H:i:s');
                    $user_id = $user['User']['id'];
                    $this->UserLoging->saveField('user_id', $user_id);
                    $this->UserLoging->saveField('loging_time', $enddate);
                    $this->checkRoleStepSocial($user, '', '');
                }
            }
            else
            {
                    $enddate = date('Y-m-d H:i:s');
                    //pr($google_user);exit;
                    $user_id = $google_user['User']['id'];
                    //$this->User->id = $user_id;
                    $this->UserLoging->saveField('user_id', $user_id);
                    $this->UserLoging->saveField('loging_time', $enddate);
                $this->checkRoleStepSocial($google_user, 'g', $google_id);
            }
        }
    }


    /**
     * facebook_connect method
     * signup step1 or login if email already exists
     *
     * @return void
     */
    public function loginbyfacebook()
    {
        $this->AutoRender = false;
        // session_start();
        App::import('vendor', 'FbConnect');
        $objConnect = new FbConnect();

        $strUrl = $objConnect->beforeLogin();
        $this->redirect($strUrl);
    }

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
     * $this->Email->from = 'sdd.sdei@gmail.com';
     * $this->Email->to = $to;
     *
     * //
     * $this->Email->subject = $subject;
     * $this->set('smtp_errors', $this->Email->smtpError);
     * $this->set('data', 'sending');
     * $this->Email->sendAs= 'both';
     *
     * if($this->Email->send($emailTemplate)){
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

    /**
     * afterFbLogin method
     * signup step1 or login if email already exists
     *
     * @return void
     */
    public function afterFbLogin()
    {
        $this->autoRender = false;
        $this->layout = false;
        App::import('vendor', 'FbConnect');
        $objConnect = new FbConnect();

        $arrData = $objConnect->afterLogin();

        if ($arrData)
        {
            $user_profile = $arrData;
            // $this->User->recursive = -1;
            $this->User->unbindModel([
                'hasMany' => [
                    'League',
                    'PollResponse',
                    'Sport',
                    'Team',
                    'WallContent',
                    'UserTeam'
                ]
            ]);
            $checkUserfbid = $this->User->find('first', [
                'conditions' => [
                    'User.email' => $user_profile['email']
                ],
                'fields' => [
                    'User.*',
                    'Locale.*',
                    'File.*'
                ]
            ]);

            if (empty($checkUserfbid))
            {
                //die('aaya');
                $tmp['User']['email'] = $user_profile['email'];
                $tmp['User']['name'] = $user_profile['name'];
                $tmp['User']['facebookId'] = $user_profile['id'];
                $tmp['User']['role_id'] = $_COOKIE['fbid'];
                $tmp['User']['steps'] = 1;
                if ($user_profile['locale'] == 'en_US')
                {
                    $tmp['User']['locale_id'] = 1;
                }
                else
                {
                    $tmp['User']['locale_id'] = 2;
                }

                $tmp['User']['gender'] = $user_profile['gender'];

                $this->User->create();
                $this->loadModel('User');

                if ($this->User->save($tmp, false))
                {
                    unset($_COOKIE['fbid']);
                    $lastUserId = $this->User->getLastInsertId();
                    $user = $this->User->findById($lastUserId);
                    $this->checkRoleStepSocial($user, '', '');
                }
                else
                {
                    $this->Session->setFlash(__('Unable to save user !!'));
                }
            }
            else
            {
                $this->checkRoleStepSocial($checkUserfbid, 'f', $user_profile['id']);
            }
        }
        else
        {
            $this->Flash->error(__('Invalid credentials, Please try again'));
            $this->redirect([
                'controller' => 'Users',
                'action' => 'login'
            ]);
        }
    }

    /**
     * afterFbLogin method
     * signup step1 or login if email already exists
     *
     * @param null|mixed $socialMediaUrl
     *
     * @return void
     */
    public function twitterLogin($socialMediaUrl = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $response = [];

        $appKey = TWAPPKEY;
        $secretKey = TWSECRETKETKEY;
        $callbackUrl = TWREREDIRECTURL;

        App::import('Vendor', 'twitteroauth');

        $connection = new TwitterOAuth($appKey, $secretKey);

        $arrRequestToken = $connection->getRequestToken($callbackUrl);

        switch ($connection->http_code)
        {
            case 200:
                $this->Session->write('TWIITER_OAUTH_TOKEN', $arrRequestToken['oauth_token']);
                $this->Session->write('TWIITER_OAUTH_TOKEN_SECRET', $arrRequestToken['oauth_token_secret']);
                $url = $connection->getAuthorizeURL($arrRequestToken['oauth_token']);

                $this->redirect($url);
            break;
            default:
                echo __('Could not connect to Twitter.');
        }
    }

    public function twitterSetup()
    {
        $this->layout = false;
        $this->autoRender = false;
        $strEnableNetwork = '';
        $prefix = false;

        App::import('vendor', 'twitteroauth');
        if (! empty($this->params->query['oauth_token']) && ! empty($this->params->query['oauth_verifier']) && $this->Session->check('TWIITER_OAUTH_TOKEN') && $this->Session->read('TWIITER_OAUTH_TOKEN') == $this->params->query['oauth_token'] && $this->Session->check('TWIITER_OAUTH_TOKEN_SECRET'))
        {

            $strOauthToken = $this->params->query['oauth_token'];
            $strOauthVerifier = $this->params->query['oauth_verifier'];
            $this->Session->write('oauth_verifier', $strOauthVerifier);

            $appKey = TWAPPKEY;
            $secretKey = TWSECRETKETKEY;

            App::import('Vendor', 'twitteroauth');
            $tweet = new TwitterOAuth($appKey, $secretKey, $this->Session->read('TWIITER_OAUTH_TOKEN'), $this->Session->read('TWIITER_OAUTH_TOKEN_SECRET'));
            //print_r($tweet);exit;
            $arrAccessToken = $tweet->getAccessToken($strOauthVerifier);
           
            $strNewOauthToken = $arrAccessToken['oauth_token'];
            $strNewOauthTokenSec = $arrAccessToken['oauth_token_secret'];
            $this->Session->write('arrRequestToken', $arrAccessToken);

            $checkUsertwid = $this->User->find('first', [
                'conditions' => [
                    'User.twitterID' => $arrAccessToken['user_id']
                ]
            ]);

            if (empty($checkUsertwid))
            {
                $tmp['User']['name'] = $arrAccessToken['screen_name'];
                $tmp['User']['twitterID'] = $arrAccessToken['user_id'];
                $tmp['User']['role_id'] = $_COOKIE['twid'];
                $tmp['User']['steps'] = 1;
                $tmp['User']['locale_id'] = 1;
                $tmp['User']['gender'] = 0;

                $this->User->create();
                $this->loadModel('User');
                $this->loadModel('UserLoging');

                if ($this->User->save($tmp, false))
                {
                    unset($_COOKIE['twid']);
                    $lastUserId = $this->User->getLastInsertId();
                    $user = $this->User->findById($lastUserId);
                    $enddate = date('Y-m-d H:i:s');
                    $user_id = $user['User']['id'];
                    $this->UserLoging->saveField('user_id', $user_id);
                    $this->UserLoging->saveField('loging_time', $enddate);
                    $this->checkRoleStepSocial($user, '', '');
                }
                else
                {
                    $this->Session->setFlash(__('Unable to save user !!'));
                }
            }
            else
            {      $this->loadModel('UserLoging');
                    //pr($checkUsertwid );exit;
                    $enddate = date('Y-m-d H:i:s');
                    $user_id = $checkUsertwid['User']['id'];
                    $this->UserLoging->saveField('user_id', $user_id);
                    $this->UserLoging->saveField('loging_time', $enddate);
                $this->checkRoleStepSocial($checkUsertwid, 't', $arrAccessToken['user_id']);
            }
        }
        else
            if (! empty($this->params->query['denied']))
            {
                $this->Session->setFlash(__('You have denied to setup your twitter account.', 'error'));
                $this->redirect('/');
            }
            else
            {
                $this->Session->setFlash(__('Please try again after some time.', 'error'));
                $this->redirect('/');
            }
    }

    /**
     * checkEmailExist method
     * client side remote checking for eamil
     *
     * @return void
     */
    public function checkEmailExist()
    {
        $this->layout = false;
        $this->autoRender = false;

        if ($this->request->is('post'))
        {
            $countResult = $this->User->find('count', [
                'conditions' => [
                    'User.email' => $this->request->data['User']['email']
                ]
            ]);

            if ($countResult != 0)
            {
                echo 'false';
            }
            else
            {
                echo 'true';
            }
        }
    }

    /**
     * admin_delete method
     *
     * @param string     $id
     * @param null|mixed $status
     *
     * @return void
     */
    public function admin_status($id = null, $status = null)
    {
        $this->_changeStatus($id, $status);
    }

    /**
     * _changeStatus method
     * commen to all type of user
     *
     * @param string     $id
     * @param null|mixed $status
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function _changeStatus($id = null, $status = null)
    {
        $this->set('title_for_layout', __('change status'));
        $id = base64_decode($id);
        $status = base64_decode($status);
        $this->User->id = $id;
        if (! $this->User->exists($id))
        {
            $this->Flash->error(__('Invalid user.'));
            return $this->redirect([
                'action' => 'index'
            ]);
        }
        $this->User->id = $id;

        if ($this->User->saveField('status', $status))
        {
            if ($status)
                $this->Flash->success(__('The user has been activated successfully.'));
            else
                $this->Flash->success(__('The user has been deactivated successfully.'));
        }
        else
        {
            $this->Flash->error(__('The user status could not be changed. Please, try again.'));
        }

        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * admin_delete method
     *
     * @param string     $id
     * @param null|mixed $status
     *
     * @return void
     */
    public function admin_delstatus($id = null, $status = null)
    {
        $this->_delchangeStatus($id, $status);
    }

    /**
     * _changeStatus method
     * commen to all type of user
     *
     * @param string     $id
     * @param null|mixed $status
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function _delchangeStatus($id = null, $status = null)
    {
        $this->set('title_for_layout', __('change status'));
        $id = base64_decode($id);
        $status = base64_decode($status);
        $this->User->id = $id;

        if (! $this->User->exists($id))
        {
            $this->Flash->error(__('Invalid user.'));
            return $this->redirect([
                'action' => 'index'
            ]);
        }

        $this->User->id = $id;

        if ($this->User->saveField('status', $status))
        {
            if ($status)
                $this->Flash->success(__('The user has been activated successfully.'));
            else
                $this->Flash->success(__('The user has been deactivated successfully.'));
        }
        else
        {
            $this->Flash->error(__('The user status could not be changed. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'deleted'
        ]);
    }

    public function locale($locale = 'eng')
    {
        $this->Session->write('Config.language', $locale);
        $this->redirect($this->referer());
    }

    public function change_play_status_1()
    {
        $this->loadModel('Game');
        $this->autoRender = false;
        echo date('Y-m-d h:i:s');
        $this->Game->UnbindModel([
            'hasMany' => [
                'Team'
            ]
        ], false);
        $gameStatus = $this->Game->find('all', [
            'conditions' => [
                'Game.play_status' => 0,
                'Game.start_time >=' => date('Y-m-d h:i:s')
            ],
            'fields' => [
                'Game.id',
                'Game.start_time'
            ]
        ]);
        foreach ($gameStatus as $gameStatus)
        {

            if (date('Y-m-d h:i') == date('Y-m-d h:i', strtotime($gameStatus['Game']['start_time'])))
            {
                $this->request->data['Game']['play_status'] = 1;
                $this->request->data['Game']['id'] = $gameStatus['Game']['id'];
                $this->Game->save($this->request->data);
                echo '1';
            }
        }
    }

    public function change_play_status_0()
    {
        $this->loadModel('Game');
        $this->autoRender = false;
        $this->Game->UnbindModel([
            'hasMany' => [
                'Team'
            ]
        ], false);

        $gameStatus = $this->Game->find('all', [
            'conditions' => [
                'Game.play_status' => 1
            ],
            'fields' => [
                'Game.id',
                'Game.end_time'
            ]
        ]);

        foreach ($gameStatus as $gameStatus)
        {

            if (date('Y-m-d h:i') == date('Y-m-d h:i', strtotime($gameStatus['Game']['end_time'])))
            {
                $this->request->data['Game']['play_status'] = 0;
                $this->request->data['Game']['id'] = $gameStatus['Game']['id'];
                $this->Game->save($this->request->data);
                echo '0';
            }
        }
    }

    /**
     *
     * @return array.
     */
    private function _getSearchConditions()
    {
        $input = $_GET;
        $model = 'User';

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
                'User' => $input
            ];
        }

        if ($this->Auth->user('role_id') != 1)
        {
            $roleId = $this->Auth->user('role_id') + 1;
            $conditions['User.role_id between ? and ?'] = [
                $roleId,
                6
            ];
        }

        return $conditions;
    }
  public function admin_graph()
    {
        $this->loadModel('UserLoging');
        $loging = $this->UserLoging->query("select count(user_id) from user_logings LEFT JOIN users ON user_logings.user_id = users.id where users.status=1 and users.is_deleted=0 and users.role_id NOT IN (1) AND  loging_time BETWEEN '".date('Y-m-d H:i:s', strtotime('today - 30 days'))."' AND '".date('Y-m-d 23:59:59', strtotime('today'))."'");


           $data  = $this->User->query("SELECT `users`.`name` as name , max(`user_logings`.`loging_time`) as L_time, COUNT(`user_logings`.`user_id`) as login_count ,(SELECT count(`team_id`) FROM `user_teams` WHERE `users`.id = `user_teams`.`user_id`) as team FROM `users` LEFT JOIN `user_logings` ON `users`.id = `user_logings`.`user_id` where `users`.`status`=1 and `users`.`is_deleted`=0 AND `role_id` NOT IN (1) AND  `user_logings`.`loging_time` BETWEEN '".date('Y-m-d H:i:s', strtotime('today - 30 days'))."' AND '".date('Y-m-d 23:59:59', strtotime('today'))."' GROUP BY (`user_logings`.`user_id`)");

        $sevendaydate=date('Y-m-d H:i:s', strtotime('today -7 days'));
       // $totle = $this->UserLoging->query('select count(user_id) from user_logings LEFT JOIN users ON user_logings.user_id = users.id where users.status=1 and users.is_deleted=0 and users.role_id NOT IN (1)' );
        $totle = $this->User->query('select count(id) from users where users.status=1 and users.is_deleted=0 and users.role_id NOT IN (1)' );


        $seventhday = $this->UserLoging->query("select count(user_id),DATE_FORMAT('".$sevendaydate."','%a') as day from user_logings LEFT JOIN users ON user_logings.user_id = users.id where users.status=1 and users.is_deleted=0 and users.role_id NOT IN (1) and date(loging_time) = '".date('Y-m-d H:i:s', strtotime('today -7 days'))."'");
        $sixthday = $this->UserLoging->query("select count(user_id),DATE_FORMAT('".date('Y-m-d H:i:s', strtotime('today -6 days'))."','%a') as day from user_logings LEFT JOIN users ON user_logings.user_id = users.id where users.status=1 and users.is_deleted=0 and users.role_id NOT IN (1) and date(loging_time) = '".date('Y-m-d H:i:s', strtotime('today -6 days'))."'");
        $fifthday = $this->UserLoging->query("select count(user_id),DATE_FORMAT('".date('Y-m-d H:i:s', strtotime('today -5 days'))."','%a') as day from user_logings LEFT JOIN users ON user_logings.user_id = users.id where users.status=1 and users.is_deleted=0 and users.role_id NOT IN (1) and  date(loging_time) =  '".date('Y-m-d H:i:s', strtotime('today -5 days'))."'");
        $forthday = $this->UserLoging->query("select count(user_id),DATE_FORMAT('".date('Y-m-d H:i:s', strtotime('today -4 days'))."','%a') as day from user_logings LEFT JOIN users ON user_logings.user_id = users.id where users.status=1 and users.is_deleted=0 and users.role_id NOT IN (1) and date(loging_time) = '".date('Y-m-d H:i:s', strtotime('today -4 days'))."'");
        $thirdday = $this->UserLoging->query("select count(user_id),DATE_FORMAT('".date('Y-m-d H:i:s', strtotime('today -3 days'))."','%a') as day from user_logings LEFT JOIN users ON user_logings.user_id = users.id where users.status=1 and users.is_deleted=0 and users.role_id NOT IN (1) and date(loging_time) = '".date('Y-m-d H:i:s', strtotime('today -3 days'))."'");
        $secondday = $this->UserLoging->query("select count(user_id),DATE_FORMAT('".date('Y-m-d H:i:s', strtotime('today -2 days'))."','%a') as day from user_logings LEFT JOIN users ON user_logings.user_id = users.id where users.status=1 and users.is_deleted=0 and users.role_id NOT IN (1) and date(loging_time) = '".date('Y-m-d H:i:s', strtotime('today -2 days'))."'");
        $firstday = $this->UserLoging->query("select count(user_id),DATE_FORMAT('".date('Y-m-d H:i:s', strtotime('today -1 days'))."','%a') as day from user_logings LEFT JOIN users ON user_logings.user_id = users.id where users.status=1 and users.is_deleted=0 and users.role_id NOT IN (1) and date(loging_time) =  '".date('Y-m-d H:i:s', strtotime('today -1 days'))."'");
        $today = $this->UserLoging->query("select count(user_id),DATE_FORMAT('".date('Y-m-d')."','%a') as day from user_logings LEFT JOIN users ON user_logings.user_id = users.id where users.status=1 and users.is_deleted=0 and users.role_id NOT IN (1)  AND date(loging_time) = '".date('Y-m-d')."'");
       // pr($firstday  );exit;
         $to = date('Y-m-d', strtotime('today - 30 days'));
         $sevenday = date('Y-m-d', strtotime('today - 7 days'));
         $from = date('Y-m-d', strtotime('today'));
          $this->set('title_for_layout', __('Graph'));
          $this->set(compact('to','from','totle','loging','sixthday','fifthday','forthday','thirdday','secondday','firstday','today','data','sevenday' ));

    //pr($data);exit;
     
    }
}


