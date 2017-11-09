<?php
App::uses('AppController', 'Controller');

class TestsController extends AppController
{
    // public $name = 'Users';
    public $uses = [
        'User'
    ];

    public $components = [
        'Session',
        'Paginator'
    ];

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('google_callback', 'loginbyfacebook', 'facebook_connect', 'currencyConverter', 'getCurrencyRate', 'contentToLocale');
    }

    public function google_callback()
    {
        $this->loadModel('User');
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

                    $this->Auth->login($checkUseremail['User']);

                    if ($checkUseremail['User']['steps'] == 1)
                    {
                        $this->Flash->success('Welcome ' . $this->Auth->user('name') . '! Please complete you profile.');
                        return $this->redirect([
                            'controller' => 'userTeams',
                            'action' => 'add'
                        ]);
                    }
                    $this->Flash->success('Welcome ' . $this->Auth->user('name') . '.');
                    return $this->redirect([
                        'controller' => 'Users',
                        'action' => 'index'
                    ]);
                }
                $data['User']['email'] = $new_array['email'];
                $data['User']['name'] = $new_array['given_name'];
                $data['User']['role_id'] = $_COOKIE['myid'];
                $data['User']['locale_id'] = 1;
                $data['User']['gender'] = 0;
                if ($new_array['gender'] == 'female')
                {
                    $data['User']['gender'] = 1;
                }

                $data['User']['google_id'] = $google_id; // Google ID
                $data['User']['steps'] = 1; // Google ID
                if ($this->User->save($data['User']))
                {
                    unset($_COOKIE['myid']);
                    $lastUserId = $this->User->getLastInsertId();
                    $user = $this->User->findById($lastUserId);
                    $this->Auth->Session->write('Auth', $user);

                    $this->Flash->success('Welcome ' . $this->Auth->user('name') . '! Please complete you profile.');
                    return $this->redirect([
                        'controller' => 'userTeams',
                        'action' => 'add'
                    ]);
                }
            }
            else
            {

                if ($this->Auth->login($google_user['User']))
                {

                    if ($google_user['User']['steps'] == 1)
                    {
                        $this->Flash->success('Welcome ' . $this->Auth->user('name') . '! Please complete you profile.');
                        return $this->redirect([
                            'controller' => 'userTeams',
                            'action' => 'add'
                        ]);
                    }
                    $this->Flash->success('Welcome ' . $this->Auth->user('name') . '.');
                    return $this->redirect([
                        'controller' => 'Users',
                        'action' => 'index'
                    ]);
                }
            }
        }
    }

    public function facebook_connect()
    {
        $this->loadModel('User');
        $this->layout = '';
        $this->autoRender = false;
        if ($this->request->is('post'))
        {
            $user_profile = $this->request->data;
            // pr($user_profile);die;
            $checkUserfbid = $this->User->find('first', [
                'conditions' => [
                    'User.facebookId' => $user_profile['User']['id']/* ,'User.email'=>$user_profile['User']['email'] */]
            ]);
            if (empty($checkUserfbid))
            {
                // $tmp['User']['email'] = $user_profile['User']['email'];
                $tmp['User']['name'] = $user_profile['User']['name'];
                $tmp['User']['facebookId'] = $user_profile['User']['id'];
                $tmp['User']['role_id'] = $_COOKIE['fbid'];
                $tmp['User']['steps'] = 1;

                $this->User->create();
                $this->loadModel('User');

                if ($this->User->save($tmp, false))
                {

                    // $this->loadModel('EmailTemplate');
                    // $message = $this->EmailTemplate->findById('21');
                    // $template = str_replace(array('{NAME}'), array($tmp['User']['fname']),$message['EmailTemplate']['description']);
                    // $this->Email->to = $tmp['User']['email'];
                    // $this->Email->subject = $message['EmailTemplate']['subject'];
                    // $this->Email->from = FROM_EMAIL;
                    // $this->Email->sendAs = 'both';
                    // $this->Email->send($template);
                    unset($_COOKIE['fbid']);
                    $lastUserId = $this->User->getLastInsertId();
                    $user = $this->User->findById($lastUserId);
                    $this->Auth->Session->write('Auth', $user);
                    echo '1';
                }
                else
                {
                    $this->Session->setFlash('Unable to save user !!');
                }
            }
            else
            {
                $this->Auth->Session->write('Auth', $checkUserfbid);

                if ($checkUserfbid['User']['steps'] == 1)
                {
                    echo '1';
                }
                else
                    echo '2';
            }
        }
    }

    public function loginbyfacebook()
    {
        $this->AutoRender = false;
        $user = $this->FacebookConnect->call_fb();
        $userInfo = $this->User->find('first', [
            'conditions' => [
                'User.facebookId' => $user['id']
            ]
        ]);

        if (! empty($userInfo))
        {
            $this->Auth->login($userInfo['User']);
            $this->Session->setFlash(__('Welcome, ' . $this->Auth->user('username')));

            $this->redirect([
                'controller' => 'ExercisePlans',
                'action' => 'index'
            ]);
        }
        else
        {
            if (isset($user['email']) && ! empty($user['email']))
            {
                $fbemailExist = $this->User->find('first', [
                    'conditions' => [
                        'User.email' => $user['email']
                    ]
                ]);
                if (isset($fbemailExist) && ! empty($fbemailExist))
                {
                    $this->User->updateAll([
                        'User.facebookId' => "'" . $user['id'] . "'"
                    ], [
                        'User.id' => $fbemailExist['User']['id']
                    ]);

                    if ($this->Auth->user())
                    {
                        $this->Auth->logout();
                    }
                    $this->Auth->login($fbemailExist['User']);
                    return $this->redirect([
                        'controller' => 'ExercisePlans',
                        'action' => 'myprofile'
                    ]);
                }
            }
            else
            {
                $data['User']['facebookId'] = $user['id'];
                $data['User']['username'] = $user['first_name'] . $user['last_name'];
                // $data['User']['role'] = 'customer';
                $this->User->create();
                $this->User->save($data);
            }
            return $this->redirect([
                'controller' => 'tests',
                'action' => 'login'
            ]);
        }
    }

    /* * **************************** Currency Converter start *********************** */
    public function currencyConverter()
    {
        $this->layout = false;
    }

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

    /**
     * **********************************Content from table to locale table starts********
     * @param mixed      $fields
     * @param null|mixed $localeTable
     * @param null|mixed $tableName
     */
    // public function contentToLocale($fields = array(),$localeTable = null,$tableName = null,$conditions = array()) {
    // Configure::write("debug",2);
    // $this->layout = false;
    // $this->autoRender = false;
    // $localeTable='HiTranslation';
    // $tableName = 'Slider';
    // $fields = array('title','content','description');
    // $this->loadModel($localeTable);
    // $this->loadModel($tableName);
    // $conditions = array(
    // //"Slider.file_id"=>1,
    // "Slider.title Like"=>"%slider%"
    // );
    // $data = $this->$tableName->find('all',array('fields'=>$fields,'conditions'=>$conditions));
    // if(!empty($data)){
    // foreach ($data as $key => $value) {
    // if(!empty($value)){
    // foreach ($value as $columnName => $columnvalue) {
    // if(!empty($columnvalue)){
    // foreach ($columnvalue as $textkey => $textvalue) {
    // $this->$localeTable->create();
    // $dataSaveArray[$textkey][$localeTable]['text'] = $textvalue;
    // $this->$localeTable->save($dataSaveArray[$textkey]);
    // }
    // }
    // }
    // }
    // }
    // }
    // }
    public function contentToLocale($fields = [], $localeTable = null, $tableName = null)
    {
        Configure::write('debug', 2);
        $this->layout = false;
        $this->autoRender = false;
        $localeTable = 'HiTranslation';
        // $tableName = 'Slider';
        // $fields = array('title','content','description');
        $this->loadModel($localeTable);

        $dbTableArray = [
            '0' => [
                'Slider' => [
                    'title',
                    'content',
                    'description'
                ]
            ],
            '1' => [
                'Chatroom' => [
                    'name'
                ]
            ],
            '2' => [
                'Chats' => [
                    'name'
                ]
            ],
            '3' => [
                'ContactUs' => [
                    'message'
                ]
            ],
            '4' => [
                'EmailTemplate' => [
                    'title',
                    'subject'
                ]
            ],
            '5' => [
                'Forum' => [
                    'name'
                ]
            ],
            '6' => [
                'ForumComment' => [
                    'name'
                ]
            ],
            '7' => [
                'Game' => [
                    'name'
                ]
            ],
            '8' => [
                'Gift' => [
                    'name'
                ]
            ],
            '9' => [
                'GiftCategory' => [
                    'name'
                ]
            ],
            '10' => [
                'Leagues' => [
                    'name'
                ]
            ],
            '11' => [
                'Location' => [
                    'name'
                ]
            ],
            // "12"=>array(
            // "News"=>array('name','description')
            // ),
            '13' => [
                'NewsComment' => [
                    'content'
                ]
            ],
            '14' => [
                'Poll' => [
                    'name',
                    'options',
                    'answer',
                    'trend'
                ]
            ],
            '15' => [
                'PollCategory' => [
                    'name'
                ]
            ],
            '16' => [
                'PollResponse' => [
                    'name'
                ]
            ],
            '17' => [
                'Role' => [
                    'name'
                ]
            ],
            // "18"=>array(
            // "Sport"=>array('name')
            // ),
            '19' => [
                'StaticPage' => [
                    'name'
                ]
            ]
        ]
        // "20"=>array(
        // "Team"=>array('name')
        // ),
        // "21"=>array(
        // "Tournament"=>array('name','description')
        // ),
        // "22"=>array(
        // "Wall"=>array('name')
        // ),
        // "23"=>array(
        // "WallComment"=>array('comment')
        // ),
        // "24"=>array(
        // "WallContent"=>array('name','content_type')
        // )
        ;

        foreach ($dbTableArray as $dbkey => $dbTable)
        {
            foreach ($dbTable as $key => $value)
            {
                $tableName = $key;
                $fields = $value;
                $this->loadModel($tableName);
                // $tableName = classRegistry::init($tableName);
                /**
                 * ****************Inner Common Loop*****************
                 */
                $data = $this->$tableName->find('all', [
                    'fields' => $fields
                ]);
                if (! empty($data))
                {
                    foreach ($data as $key => $value)
                    {
                        if (! empty($value))
                        {
                            foreach ($value as $columnName => $columnvalue)
                            {
                                if (! empty($columnvalue))
                                {
                                    foreach ($columnvalue as $textkey => $textvalue)
                                    {
                                        $textvalue = (string) $textvalue;
                                        // pr($textvalue);
                                        if ($textvalue != '')
                                        {
                                            $alreadyExist = $this->$localeTable->find('first', [
                                                'conditions' => [
                                                    "$localeTable.text" => strip_tags($textvalue)
                                                ]
                                            ]);
                                            if (empty($alreadyExist))
                                            {
                                                $this->$localeTable->create();
                                                $dataSaveArray[$textkey][$localeTable]['text'] = strip_tags($textvalue);
                                                $this->$localeTable->save($dataSaveArray[$textkey]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            /**
             * ****************Inner Common Loop*****************
             */
            }
        }
    }
/**
 * **********************************Content from table to locale table end********
 */
}