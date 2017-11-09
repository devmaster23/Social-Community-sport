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
class AdminsController extends AppController
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
     * Helpers
     *
     * @var array
     */
    public $helpers = [
        'Notification'
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
        $this->Auth->allow('login', 'logout', 'forgot_password');
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
        $this->set('title_for_layout', 'FansWage: Login');
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
                $this->Flash->success("Welcome $name_of_user!");
                return [
                    'login' => 1,
                    'redirect' => $this->Auth->loginRedirect
                ];
            }

            $this->Flash->error('Invalid username or password.');
            return [
                'login' => 0,
                'redirect' => $this->Auth->logoutRedirect
            ];
        }
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
    {
        $sessionKeys = [
            'Admin' => AuthComponent::password('Admin'),
            'Sports' => AuthComponent::password('Sports'),
            'League' => AuthComponent::password('League'),
            'Team' => AuthComponent::password('Team')
        ];
        $destroy = array_search($sessionKey, $sessionKeys);
        if ($destroy === FALSE)
        {
            $this->Flash->error('Unauthenticated Request');
            $this->redirect('/');
        }
        $prefix = strtolower($destroy);

        $this->Session->delete('Auth.' . $destroy);
        return $this->redirect([
            'controller' => 'admins',
            'action' => 'login',
            $prefix => true
        ]);
    }

    /**
     * sports_login method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_login()
    {
        if (! empty($this->request->data))
        {
            $return = $this->_login();
            if ($return['login'])
            {
                $sport = $this->User->Sport->find('first', [
                    'recursive' => - 1,
                    'conditions' => [
                        'Sport.user_id' => AuthComponent::user('id')
                    ]
                ]);
                $this->Session->write('Auth.Sports.SportInfo', $sport);
                $this->redirect($return['redirect']);
            }
        }
        $this->layout = 'b_login';
        $this->render('login');
    }

    /**
     * league_login method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function league_login()
    {
        if (! empty($this->request->data))
        {
            $return = $this->_login();
            if ($return['login'])
            {
                $league = $this->User->League->find('first', [
                    'recursive' => - 1,
                    'conditions' => [
                        'League.status' => 1,
                        'League.user_id' => AuthComponent::user('id')
                    ]
                ]);

                $this->Session->write('Auth.League.SportInfo', $league);

                $this->redirect($return['redirect']);
            }
        }
        $this->layout = 'b_login';
        $this->render('login');
    }

    /**
     * team_login method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function team_login()
    {
        if (! empty($this->request->data))
        {
            $return = $this->_login();
            if ($return['login'])
            {

                $team = $this->User->Team->find('first', [
                    'recursive' => - 1,
                    'conditions' => [
                        'Team.status' => 1,
                        'Team.user_id' => AuthComponent::user('id')
                    ]
                ]);
                $this->Session->write('Auth.Team.SportInfo', $team);
                $this->redirect($return['redirect']);
            }
        }
        $this->layout = 'b_login';
        $this->render('login');
    }

    /**
     * admin_login method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_login()
    {
        $this->set('title_for_layout', 'Sports : Login');
        if (! empty($this->request->data))
        {
            $return = $this->_login();
            if ($return['login'])
            {
                $this->redirect($return['redirect']);
            }
        }
        $this->layout = 'b_login';
        $this->render('login');
    }

    /**
     * forgot_password method
     *
     * @return void
     */
    public function forgot_password()
    {
        $this->layout = 'b_login';
        $this->loadModel('EmailTemplate');

        if (! empty($this->request->data))
        {

            $updatePassword = $this->__generateRandomPassword(8);
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
                // pr($emailTemplate); die;
                $Email = new CakeEmail();
                $Email->from([
                    FROM_EMAIL => 'Fanswage Support'
                ])
                    ->to($userEmail)
                    ->subject($subject)
                    ->send($emailTemplate);

                $this->Flash->success(__('Your password has been changed. Please check your email'));

                return $this->redirect(BASE_URL . strtolower($this->request->data('User.prefix')));
            }
            $this->Flash->error(__('Your email does not exist. Please, try again.'));
        }

        $this->set('prefix', $this->request->pass[0]);
    }
}