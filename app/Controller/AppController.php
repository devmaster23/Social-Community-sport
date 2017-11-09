<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * @link http://cakephp.org CakePHP(tm) Project
 *
 * @package app.Controller
 *
 * @since CakePHP(tm) v 0.2.9
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package app.Controller
 *
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $components = [
        'Paginator',
        'Flash',
        'Session',
        'Cookie',
        'Email',
        'Auth'
    ];

    public $forceSessionKey = false;

    public function beforeRender()
    {
        // $this->_setErrorLayout();
    }

    public function beforeFilter()
    {
        if ($this->Session->check('Config.language'))
        {
            Configure::write('Config.language', $this->Session->read('Config.language'));
        }

        if ($this->params['controller'] == 'Sports' && $this->params['action'] == 'sport')
        {
            // $sess = array_values($this->Session->read("Auth"));
            // $sesskey = array("6"=>"Auth.Blogger", "7"=>"Auth.Editor");
            // $this->forceSessionKey = $sesskey[$sess[0]['role_id']];

            $this->loadModel('League');
            $this->League->unbindModel([
                'belongsTo' => [
                    'Tournament',
                    'User'
                ]
            ]);
            $this->League->unbindModel([
                'hasMany' => [
                    'Forum',
                    'Game',
                    'Team',
                    'Wall'
                ]
            ]);
            $sportLeagues = $this->League->find('all', [
                'conditions' => [
                    'League.sport_id' => $this->request->params['pass'][0],
                    'League.status' => 1,
                    'League.is_deleted' => 0,
                    'League.end_date >=' => date('Y-m-d h:i:s')
                ],
                'fields' => [
                    'League.name',
                    'Sport.name',
                    'Sport.id'
                ],
                'order' => 'League.order_number ASC',
                'limit' => LIMIT
            ]);
            $totalSportLeague = $this->League->find('count', [
                'conditions' => [
                    'League.sport_id' => $this->request->params['pass'][0],
                    'League.status' => 1,
                    'League.is_deleted' => 0,
                    'League.end_date >=' => date('Y-m-d h:i:s')
                ]
            ]);

            $this->set(compact('sportLeagues', 'totalSportLeague'));
        }
        
        if ($this->params['controller'] == 'Sports' && $this->params['action'] == 'news')
        {
            $newsId = base64_decode($this->request->params['pass'][0]);
            $this->loadModel('News');
            $sportId = $this->News->find('first', [
                'conditions' => [
                    'News.id' => $newsId
                ],
                'fields' => [
                    'News.foreign_key'
                ]
            ]);

            $this->loadModel('League');
            $this->League->unbindModel([
                'belongsTo' => [
                    'Tournament',
                    'User'
                ]
            ]);
            $this->League->unbindModel([
                'hasMany' => [
                    'Forum',
                    'Game',
                    'Team',
                    'Wall'
                ]
            ]);
            $sportLeagues = $this->League->find('all', [
                'conditions' => [
                    'League.sport_id' => $sportId['News']['foreign_key'],
                    'League.status' => 1,
                    'League.is_deleted' => 0,
                    'League.end_date >=' => date('Y-m-d h:i:s')
                ],
                'fields' => [
                    'League.name',
                    'Sport.name',
                    'Sport.id'
                ],
                'order' => 'League.order_number ASC',
                'limit' => LIMIT
            ]);
            $totalSportLeague = $this->League->find('count', [
                'conditions' => [
                    'League.sport_id' => $sportId['News']['foreign_key'],
                    'League.status' => 1,
                    'League.is_deleted' => 0,
                    'League.end_date >=' => date('Y-m-d h:i:s')
                ]
            ]);

            $this->set(compact('sportLeagues', 'totalSportLeague'));
        }

        $this->Auth->userModel = 'User';
        $this->setAuthSessionKeysAndRedirects();
        // $this->_accessControl();
        $this->_accessControlUser();
        // $this->_accessStepControlUser();
        $this->setLayouts();

        $client_id = GOOGLE_CLIENT_ID;
        $redirectUrl = GOOGLE_REDIRECT_URL;
        $scope = 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email';
        $authUrl = 'https://accounts.google.com/o/oauth2/auth?client_id=' . urlencode($client_id) . '&response_type=code&scope=' . urlencode($scope) . '&redirect_uri=' . urlencode($redirectUrl) . '&access_type=offline&approval_prompt=auto';
        // $this->loadModel('Locale');
        $this->loadModel('Sport');
        // $LanguageArray = $this->Locale->find('list');
        $LanguageArray = [
            '1' => 'English',
            '2' => 'Hindi'
        ];

        $SportArray = $this->Sport->find('list');
        $this->set(compact('client_id', 'redirectUrl', 'scope', 'authUrl', 'LanguageArray', 'SportArray'));

        $this->getFooterSport();
        $this->loadModel('Location');

        $this->loadModel('GiftCategory');
        $gift_cat = $this->GiftCategory->find('list');
        $location = $this->Location->find('list');
        $this->set(compact('gift_cat', 'location'));
    }

    public function setAuthSessionKeysAndRedirects()
    {
        $this->loadModel('User');

        $this->Auth->loginRedirect = [
            'controller' => 'pages',
            'action' => 'display'
        ];
        $this->Auth->logoutRedirect = [
            'controller' => 'users',
            'action' => 'login'
        ];
        $this->Auth->loginAction = [
            'controller' => 'users',
            'action' => 'login'
        ];
        if (isset($this->params['prefix']))
        {
            if ($this->params['prefix'] == 'blogger')
            {
                AuthComponent::$sessionKey = 'Auth.Blogger';
                $this->Auth->authenticate = [
                    'Form' => [
                        'fields' => [
                            'username' => 'email'
                        ],
                        'scope' => [
                            'User.role_id' => 6,
                            'User.status' => 1,
                            'User.is_deleted' => 0
                        ]
                    ]
                ];
                $this->Auth->loginRedirect = [
                    'controller' => 'dashboard',
                    'action' => 'blogger_index',
                    'blogger' => true
                ];
                return true;
            }
            if ($this->params['prefix'] == 'editor')
            {
                AuthComponent::$sessionKey = 'Auth.Editor';
                $this->Auth->authenticate = [
                    'Form' => [
                        'fields' => [
                            'username' => 'email'
                        ],
                        'scope' => [
                            'User.role_id' => 7,
                            'User.status' => 1,
                            'User.is_deleted' => 0
                        ]
                    ]
                ];
                $this->Auth->loginRedirect = [
                    'controller' => 'dashboard',
                    'action' => 'editor_index',
                    'editor' => true
                ];
                return true;
            }
            if ($this->params['prefix'] == 'admin')
            {
                AuthComponent::$sessionKey = 'Auth.Admin';
                $this->Auth->authenticate = [
                    'Form' => [
                        'fields' => [
                            'username' => 'email'
                        ],
                        'scope' => [
                            'User.role_id' => 1,
                            'User.status' => 1,
                            'User.is_deleted' => 0
                        ]
                    ]
                ];
                $this->Auth->loginRedirect = [
                    'controller' => 'dashboard',
                    'action' => 'admin_index',
                    'admin' => true
                ];
            }
            else
                if ($this->params['prefix'] == 'sports')
                {
                    AuthComponent::$sessionKey = 'Auth.Sports';
                    $this->Auth->authenticate = [
                        'Form' => [
                            'fields' => [
                                'username' => 'email'
                            ],
                            'scope' => [
                                'User.role_id' => 2,
                                'User.status' => 1,
                                'User.is_deleted' => 0
                            ]
                        ]
                    ];
                    $this->Auth->loginRedirect = [
                        'controller' => 'dashboard',
                        'action' => 'sports_index',
                        'sports' => true
                    ];
                }
                else
                    if ($this->params['prefix'] == 'league')
                    {
                        AuthComponent::$sessionKey = 'Auth.League';
                        $this->Auth->authenticate = [
                            'Form' => [
                                'fields' => [
                                    'username' => 'email'
                                ],
                                'scope' => [
                                    'User.role_id' => 3,
                                    'User.status' => 1,
                                    'User.is_deleted' => 0
                                ]
                            ]
                        ];
                        $this->Auth->loginRedirect = [
                            'controller' => 'dashboard',
                            'action' => 'league_index',
                            'league' => true
                        ];
                    }
                    else
                        if ($this->params['prefix'] == 'team')
                        {
                            AuthComponent::$sessionKey = 'Auth.Team';
                            $this->Auth->authenticate = [
                                'Form' => [
                                    'fields' => [
                                        'username' => 'email'
                                    ],
                                    'scope' => [
                                        'User.role_id' => 4,
                                        'User.status' => 1,
                                        'User.is_deleted' => 0
                                    ]
                                ]
                            ];
                            $this->Auth->loginRedirect = [
                                'controller' => 'dashboard',
                                'action' => 'team_index',
                                'team' => true
                            ];
                        }
            $this->Auth->logoutRedirect = [
                'controller' => 'admins',
                'action' => 'login',
                $this->params['prefix'] => true
            ];
            $this->Auth->loginAction = [
                'controller' => 'admins',
                'action' => 'login',
                $this->params['prefix'] => true
            ];
        }
        else
        {
            if ($this->Session->check('auth_error'))
            {
                $this->set('auth_error', $this->Session->read('auth_error'));
                $this->Session->delete('auth_error');
            }
            if ($this->Session->check('reg'))
            {
                $this->set('reg_errors', $this->Session->read('reg'));
                $this->User->validationErrors = $this->Session->read('reg.validation_errors');
                $this->Session->delete('reg');
            }
            // if($this->forceSessionKey){
            // AuthComponent::$sessionKey = $this->forceSessionKey;
            // }else{
            AuthComponent::$sessionKey = 'Auth.User';
            // }
            $this->Auth->authenticate = [
                'Form' => [
                    'fields' => [
                        'username' => 'email'
                    ],
                    'scope' => [
                        'User.role_id' => 5,
                        'User.status' => 1,
                        'User.is_deleted' => 0
                    ]
                ]
            ];
        }
    }

    public function setLayouts()
    {
        $prefix = $this->params['prefix'];

        $role_layout = [];
        $role_layout['admin'] = 'backend';
        $role_layout['sports'] = 'backend';
        $role_layout['league'] = 'backend';
        $role_layout['team'] = 'backend';
        $role_layout['blogger'] = 'blog';
        $role_layout['editor'] = 'editor';
        $role_layout[1] = 'backend';
        $role_layout[2] = 'backend';
        $role_layout[3] = 'backend';
        $role_layout[4] = 'backend';
        $role_layout[5] = 'default';
        $role_layout[6] = 'blog';
        $role_layout[7] = 'editor';

        $elementFolder = [];
        $elementFolder[1] = 'admin';
        $elementFolder[2] = 'sports';
        $elementFolder[3] = 'league';
        $elementFolder[4] = 'team';
        $elementFolder[5] = 'fan';
        $elementFolder[6] = 'blogger';
        $elementFolder[7] = 'editor';

        $role_layout_keys = array_keys($role_layout);
        if ($this->Auth->loggedIn())
        {
            $role = $this->Auth->user('role_id');
            if (in_array($role, $role_layout_keys))
            {
                $this->layout = $role_layout[$role];
            }
            $this->set('elementFolder', $elementFolder[$role]);
        }
        else
        {
            if (in_array($prefix, $role_layout_keys))
            {
                $this->layout = $role_layout[$prefix];
            }
            $this->set('elementFolder', '');
        }
    }

    // Role based Permissions
    public function _accessControl()
    {
        $user = AuthComponent::user();
        $controller = $this->params['controller'];
        $action = $this->params['action'];
        $this->loadModel('Section');
        $options['conditions'] = [
            'SectionList.controller' => $controller,
            'SectionList.action' => $action,
            'Section.role_id' => $user['role_id']
        ];
        $control = $this->Section->find('first', $options);
        // pr($control);
        if (! empty($control))
        {
            $control['SectionList']['name'] = ucwords(str_replace($this->params['Prefix'] . '_', ' ', $control['SectionList']['name']));
            echo 'You are not authorised to access ' . $control['SectionList']['name'];
            exit();
        }
    }

    // User based Permissions
    public function _accessControlUser()
    {
        $user = AuthComponent::user();
        $user_id = AuthComponent::user('id');
        $role_id = AuthComponent::user('role_id');

        $controller = $this->params['controller'];
        $action = $this->params['action'];
        $this->loadModel('UserSection');
        $options['conditions'] = [
            'SectionList.controller' => $controller,
            'SectionList.action' => $action,
            'UserSection.user_id' => $user_id
        ];
        $control = $this->UserSection->find('first', $options);

        if (! empty($control))
        {
            $control['SectionList']['name'] = ucwords(str_replace($this->params['Prefix'] . '_', ' ', $control['SectionList']['name']));
            echo 'You are not authorised to access ' . $control['SectionList']['name'];
            exit();
        }
        // checks for logged in user access page front end
        /*
         * if((isset($_SESSION['Auth']['Blogger']) || $role_id == 5))
         * {
         * if(($controller == 'pages' && $action == 'home') || ($controller == 'users' && ($action == 'login' || $action == 'blogger_login' || $action == 'signup')) ){
         * if(isset($_SESSION['Auth']['Blogger']))
         * $this->redirect(array('controller' => 'dashboard', 'action' => 'index','blogger'=>true));
         * else
         * $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
         * }
         * }
         */
    }

    // public function _accessStepControlUser(){
    // $this->loadModel('User');
    // $this->User->unbindModel(array('belongsTo' => array('Role')));
    // $this->User->unbindModel(array('hasMany' => array('League','PollResponse','WallContent','Team','Sport')));
    //
    // $viewControl = $this->User->find('first',array('conditions'=>array('User.id'=>AuthComponent::user("id")),'fields'=>array('User.steps','User.role_id')));
    //
    // if(!empty($viewControl)){
    // $roleId = $viewControl['User']['role_id'];
    // if(($roleId == 5 OR $roleId == 6) AND $viewControl['User']['steps'] == 1)
    // {
    //
    // //calling auth logout method
    // $controller = $this->params['controller']; $action = $this->params['action'];
    // if($controller == 'users' && ($action == 'logout' || $action == 'blogger_logout')){
    // $this->Session->delete("Auth");
    // $this->Session->destroy();
    // $return = $this->Auth->logout();
    // return $this->redirect("/");
    // }
    // if(($controller != 'userTeams' || $action != 'add') && $roleId == 5)
    // {
    // $this->Flash->success('Please complete registration.');
    // $this->redirect(array('controller' => 'userTeams', 'action' => 'add'));
    // } else if(($controller != 'userTeams' || $action != 'blogger_add') && $roleId == 6 ) {
    //
    // $this->Flash->success('Please complete registration.');
    // $this->redirect(array('controller' => 'userTeams', 'action' => 'add','blogger'=>true));
    // } else if($controller == 'userTeams' && ($action == 'add' || $action == 'blogger_add')) {
    // // do nothing
    // }
    //
    // }
    //
    //
    // }
    // }
    public function _setErrorLayout()
    {
        if ($this->name == 'CakeError')
        {
            $this->layout = '404';
        }
    }

    public function checkRoleStepSocial($data, $sbtn, $socialVal)
    {
        // pr($data);
        // echo $sbtn.','.$socialVal;die;
        if ($data)
        {

            if ($data['User']['role_id'] == 7)
            {
                $data['Editor'] = $data['User'];
                $this->Auth->Session->write('Auth', $data);

                // if($data['Editor']['steps']==1){

                $this->request->data['User']['id'] = $data['User']['id'];
                $this->request->data['User']['status'] = 1;
                if ($sbtn == 'f')
                {
                    $this->request->data['User']['facebookId'] = $socialVal;
                }
                if ($sbtn == 't')
                {
                    $this->request->data['User']['twitterID'] = $socialVal;
                }
                if ($sbtn == 'g')
                {
                    $this->request->data['User']['google_id'] = $socialVal;
                }

                $this->User->save($this->request->data);
                unset($data['User']);
                $this->Flash->success(__('Welcome,' . $this->Auth->Session->read('Auth.Editor.name')));
                $this->redirect([
                    'controller' => 'editors',
                    'action' => 'index',
                    'editor' => true
                ]);
                // }
                // else{
                // $this->Flash->success(__('Welcome, '.$this->Auth->Session->read('Auth.Editor.name')));
                // $this->redirect(array('controller'=>'Dashboard','action' => 'index','editor'=>true));
                // }
            }

            else
                if ($data['User']['role_id'] == 6)
                {
                    $data['Blogger'] = $data['User'];
                    $this->Auth->Session->write('Auth', $data);

                    if ($data['Blogger']['steps'] == 1)
                    {

                        $this->request->data['User']['id'] = $data['User']['id'];
                        $this->request->data['User']['status'] = 1;
                        if ($sbtn == 'f')
                        {
                            $this->request->data['User']['facebookId'] = $socialVal;
                        }
                        if ($sbtn == 't')
                        {
                            $this->request->data['User']['twitterID'] = $socialVal;
                        }
                        if ($sbtn == 'g')
                        {
                            $this->request->data['User']['google_id'] = $socialVal;
                        }

                        $this->User->save($this->request->data);
                        unset($data['User']);
                        $this->Flash->success(__('Welcome,' . $this->Auth->Session->read('Auth.Blogger.name') . ' Please complete your profile.'));
                        $this->redirect([
                            'controller' => 'userTeams',
                            'action' => 'add',
                            'blogger' => true
                        ]);
                    }
                    else
                    {
                        $this->Flash->success(__('Welcome, ' . $this->Auth->Session->read('Auth.Blogger.name')));
                        $this->redirect([
                            'controller' => 'Dashboard',
                            'action' => 'index',
                            'blogger' => true
                        ]);
                    }
                }

                else
                    if ($data['User']['role_id'] == 5)
                    {
                        $this->Auth->Session->write('Auth', $data);
                        $this->Session->write('Auth', $data);

                        if ($data['User']['steps'] == 1)
                        {
                            $this->request->data['User']['id'] = $data['User']['id'];
                            $this->request->data['User']['status'] = 1;

                            if ($sbtn == 'f')
                            {
                                $this->request->data['User']['facebookId'] = $socialVal;
                            }
                            if ($sbtn == 't')
                            {
                                $this->request->data['User']['twitterID'] = $socialVal;
                            }
                            if ($sbtn == 'g')
                            {
                                $this->request->data['User']['google_id'] = $socialVal;
                            }

                            $this->User->save($this->request->data);
                            $this->Flash->success(__('Welcome,' . AuthComponent::User('name') . ' Please complete your profile.'));
                            $this->redirect([
                                'controller' => 'userTeams',
                                'action' => 'add'
                            ]);
                        }
                        else
                        {
                            $this->Flash->success(__('Welcome, ' . AuthComponent::User('name')));
                            $this->redirect([
                                'controller' => 'Dashboard',
                                'action' => 'index'
                            ]);
                        }
                    }
        }
    }

    public function getFooterSport()
    {
        $this->loadModel('Sport');
        $footerSports = $this->Sport->find('all', [
            'fields' => [
                'Sport.id',
                'Sport.name'
            ]
        ]);
        $this->set(compact('footerSports'));
    }

    /*
     * function checkMimeType check mime type of image upload
     * Created By: Shambhu
     * Date: 18-05-2016
     * Company: SmartData
     */
    public function checkMimeTypeApp($tmpName = null)
    {
        $this->autoRender = false;
        // $tmpName = $_FILES['file_id']['tmp_name'];
        $imageTypes = [
            'image/gif',
            'image/jpeg',
            'image/png'
        ]; // List of accepted file extensions.
                                                                // get file mime type
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($fileInfo, $tmpName);
        finfo_close($fileInfo);
        if (in_array($fileType, $imageTypes))
        {
            return 1;
        }
        return 0;
    }
}
