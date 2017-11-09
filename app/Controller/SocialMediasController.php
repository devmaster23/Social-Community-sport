<?php
error_reporting(E_ALL);
class SocialMediasController extends AppController
{
    public $components = [
        'Cookie',
        'Session'
    ];

    public $uses = [
        'User'
    ];

    protected $objFacebook = null;
    // protected $objGoogleClient = null;
    // protected $objGoogleOauth = null;
    // protected $objLinkedin = null;
    public function beforeFilter()
    {
        $this->Auth->allow([
            'loginWithFacebook',
            'getUserDataFromFacebook',
            'logoutFacebook'
        ]);
        $this->Auth->allow([
            'addUser',
            'editSocialMediaId'
        ]);
    }

    /**
     * @function : loginWithFacebook
     * ription : to post on twitter
     *
     * @param
     *            s:
     *            @Created by : smartData Inc
     *            @Created Date :08 Sep 2015
     *            @Modified On :
     *            @Modified By :
     */
    public function loginWithFacebook()
    {
        $this->layout = false;
        $this->autoRender = false;
        error_reporting(E_ALL);
        // for FACEBOOK configuration
        // App::import('Vendor', 'Facebook/facebook');

        App::import('Vendor', 'facebook', [
            'file' => 'Facebook/facebook.php'
        ]);

        $facebook = new Facebook([
            'appId' => FBAPPKEY,
            'secret' => FBSECRETKETKEY
        ]);
        $this->objFacebook = $facebook;

        $this->redirect($this->objFacebook->getLoginUrl([
            'redirect_uri' => FBREDIRECTURL
        ]));

        // set to FACEBOOK LOGIN URL
        // $this->set('fb_login_url', $this->objFacebook->getLoginUrl(array('redirect_uri' => Router::url(array('controller' => 'SocialMedia', 'action' => 'loginWithFacebook'), true))));
    }

    /**
     * @function : getUserDataFromFacebook
     * ription : to setup twitter login
     *
     * @param
     *            s: N/A
     *            @Created by : smartData Inc.
     *            @Created Date : 09-09-2015
     *            @Modified On :
     *            @Modified By :
     *
     * @return :
     */
    public function getUserDataFromFacebook()
    {
        // configure::write("debug",2);
        $this->layout = false;
        $this->autoRender = false;
        $shareLink = $this->Session->read('SocialMediaUrl');
        error_reporting(E_ALL);
        App::import('Vendor', 'Facebook/facebook');
        $facebook = new Facebook([
            'appId' => FBAPPKEY,
            'secret' => FBSECRETKETKEY,
           // 'cookie' => true
           
        ]);
       

        $this->objFacebook = $facebook;

        // If it is a post request we can assume this is a local login request
        if ($this->request->isPost())
        {
            if ($this->Auth->login())
            {
                $this->redirect($shareLink);
            }
            else
            {
                $this->Flash->error(__('Invalid Username or password. Try again.'));
            }
        }
        else // When facebook login is used, facebook always returns $_GET['code'].
            if ($this->request->query('code'))
            {
                //pr($this->request->query('code'));exit;
                $fb_user = $this->objFacebook->getUser();

                 //pr($facebook->getUser());exit;
                if ($fb_user)
                {
                    // $fb_user = $this->objFacebook->api('/me'); # Returns user information
                  // die('aala');
                    $access_token = $this->objFacebook->getAccessToken();
                    $_SESSION['FacebookToken'] = $access_token;
                    $param_token = [
                        'access_token' => $access_token
                    ];

                    // $fields = 'email,id,name,hometown,about,bio,birthday,gender,education,relationship_status,first_name,last_name,locale,middle_name,political,work,website,religion,location,languages,age_range';
                    $fields = 'email,id,name,hometown,about,birthday,gender,education,relationship_status,first_name,last_name,locale,middle_name,political,work,website,religion,location,languages,age_range';

                    $fbUserData = $this->objFacebook->api('/me?fields=' . $fields, 'GET', $param_token);
                    // die($fbUserData);

                    if (! empty($fbUserData) && isset($fbUserData))
                    {
                        $this->Session->write('FacebookUser', 1);
                    }
                    else
                    {
                        $this->Flash->error(__('Please try again after some time.'));
                        //$this->redirect($shareLink);
                    }
                    // We will varify if a local user exists first
                    $this->loadModel('User');
                    $localUser = $this->User->find('first', [
                        'conditions' => [
                            'social_api_id' => $fbUserData['id']
                        ],
                        'fields' => [
                            'User.*',
                            'Locale.*',
                            'File.*'
                        ], // array('id', 'name', 'email', 'password'),
                        'resursive' => - 1
                    ]);
                    // pr($localUser);
                    // die;
                    // If exists, we will log them in
                    if (! empty($localUser) && isset($localUser))
                    {
                        $socialMedia = [
                            'columnName' => 'User.social_api_id',
                            'columnValue' => $fbUserData['id'],
                            'userId' => $localUser['User']['id']
                        ];
                        
                        $this->checkRoleStepSocial($localUser, 'f', $fbUserData['id']);
                        // $return = $this->editSocialMediaId($socialMedia, $localUser);
                        // $this->checkRoleStepSocial($user,'','');
                        // $this->redirect(array('controller' => 'users', 'action' => 'profile'));
                    }

                    // Otherwise we ll add a new user (Registration)
                    else
                    {
                        if ($fbUserData['locale'] == 'en_US')
                        {
                            $tmplocale = 1;
                        }
                        else
                        {
                            $tmplocale = 2;
                        }
                        $stps = 1;
                        if ($_COOKIE['fbid'] == 7)
                        {
                            $stps = 2;
                        }
                        $userData = [
                            'social_api_id' => $fbUserData['id'],
                            'facebookId' => $fbUserData['id'],
                            'name' => $fbUserData['first_name'] . ' ' . $fbUserData['last_name'],
                            'email' => (isset($fbUserData['email']) ? $fbUserData['email'] : $fbUserData['id'] . '@gmail.com'),
                            'role_id' => $_COOKIE['fbid'],
                            'steps' => $stps,
                            'locale_id' => $tmplocale,
                            'gender' => $fbUserData['gender']
                        ];
                           
                       //  pr($userData);die;
                        $this->addUser($userData);
                       
                        // $this->checkRoleStepSocial($localUser, 'f', $fbUserData['id']);
                        $this->redirect(array('controller' => 'users', 'action' => 'profile'));
                    }
                }
                else
                {
                    $this->Flash->error(__('Cannot found your facebook user id. Please try again after some time.'));
                    //echo 'error';
                    //$this->redirect($shareLink);
                }
            }
        
        $this->Session->setFlash('Please try again after some time.', 'error');
        
        //$this->redirect($shareLink);
    }

    /**
     * @function : logoutFacebook
     * ription : to post on twitter
     *
     * @param
     *            s:
     *            @Created by : smartData Inc
     *            @Created Date : 14-09-2015
     *            @Modified On :
     *            @Modified By :
     */
    public function logoutFacebook()
    {
        $this->layout = false;
        $this->autoRender = false;
        $shareLink = $this->Session->read('SocialMediaUrl');
        $facebookToken = $_SESSION['FacebookToken'];
        $logoutUrl = 'https://www.facebook.com/logout.php?next=http://' . $_SERVER['HTTP_HOST'] . '/SocialMedia/logoutFacebook&access_token=' . $facebookToken;
        echo $logoutUrl;
        exit();
        $this->redirect($logoutUrl);
        $this->redirect($shareLink);
    }

    /**
     * @function : editSocialMediaId
     * ription : edit to socail media id to exitsting user
     *
     * @param
     *            s:
     *            @Created by : smartData Inc
     *            @Created Date : 14-09-2015
     *            @Modified On :
     *            @Modified By :
     *
     * @param mixed $socialMedia
     * @param mixed $localUser
     */
    public function editSocialMediaId($socialMedia, $localUser)
    {
        $this->layout = false;
        $this->autoRender = false;

        $this->loadModel('User');
        // $this->User->bindModel(array('hasMany'=>array('Wishlist'),'hasOne'=>'Shipping'));
        // pr($socialMedia);
        // pr($localUser);die();
        if ($socialMedia['columnName'] == 'User.linkedin_id')
        {
            $this->User->updateAll([
                $socialMedia['columnName'] => "'" . $socialMedia['columnValue'] . "'"
            ], [
                'User.id' => $socialMedia['userId']
            ]);
        }
        else
        {
            $this->User->updateAll([
                $socialMedia['columnName'] => $socialMedia['columnValue']
            ], [
                'User.id' => $socialMedia['userId']
            ]);
            $this->checkRoleStepSocial($localUser, 'f', $socialMedia['id']);
            // if ($this->Auth->login($localUser['User'])) {
            // $this->Session->setFlash(__('You have successfully logged in.'), 'flash_success');
            // $this->redirect(array('controller' => 'Users', 'action' => 'profile'));
            // }
        }
        // return true;
    }

    /**
     * @function : addUser
     * ription : add new user into user table
     *
     * @param
     *            s:
     *            @Created by : smartData Inc
     *            @Created Date : 14-09-2015
     *            @Modified On :
     *            @Modified By :
     *
     * @param mixed $userData
     */
    public function addUser($userData)
    {
        $this->layout = false;
        $this->autoRender = false;
        $password = 12345678;
        $userData['password'] = $password;
        // $userData['activation_code']= md5(uniqid(rand(), true));
        // $userData['user_type']= 1;
        // $userData['subscription_type']= 2;
        // pr($userData);die();
        $this->loadModel('User');
        // $this->User->bindModel(array('hasMany'=>array('Wishlist'),'hasOne'=>'Shipping'));
        $this->User->validate = false;
        $this->User->create();
        $this->User->save($userData);

        $lastInsertedId = $this->User->getLastInsertID();

        $userData['id'] = $lastInsertedId;

        // if(!empty($userData['id'])) {
        unset($_COOKIE['fbid']);
        // $lastUserId = $this->User->getLastInsertId();
        $user = $this->User->findById($lastInsertedId);
        // pr($user);die;
        $this->checkRoleStepSocial($user, '', '');

        // $this->Auth->login($userData);
        // $this->Session->setFlash(__('You have successfully logged in.'), 'flash_success');
        // $this->redirect(array('controller' => 'Users', 'action' => 'profile'));

        // return true;
    }
}