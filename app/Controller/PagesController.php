<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 *
 * @package       app.Controller
 *
 * @since         CakePHP(tm) v 0.2.9
 *
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package app.Controller
 *
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = [];

    public $components = [
        'Paginator',
        'Flash',
        'Session',
        'Email'
    ];

    /**
     * beforeFilter method
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    /**
     * home method
     *
     * @return void
     */
    public function home()
    {
        $this->layout = 'default';
        $this->loadModel('News');
        $this->loadModel('Slider');
        $this->set('title_for_layout', __('Home'));
        $search = 0;
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $news = [];
            // display search news.
            $news = $this->News->find('all', [
                'conditions' => [
                    'OR' => [
                        'News.name LIKE' => '%' . $this->request->data['News']['search'] . '%',
                        'News.description LIKE' => '%' . $this->request->data['News']['search'] . '%'
                    ]
                ]
            ]);

            $search = 1;
        }
        else
        {
            $news = [];
            for ($i = 1; $i <= 6; ++ $i)
            {
                $count = $this->News->find('count', [
                    'conditions' => [
                        'News.top_news ' => 1,
                        'AND' => [
                            'News.foreign_key ' => $i
                        ]
                    ]
                ]);
                // if only 1 top news.

                if ($count == 1)
                {
                    $news[$i][0] = $this->News->find('first', [
                        'conditions' => [
                            'News.top_news ' => 1,
                            'AND' => [
                                'News.foreign_key ' => $i
                            ]
                        ]
                    ]);
                    $news[$i][1] = $this->News->find('first', [
                        'conditions' => [
                            'News.top_news ' => 1,
                            'AND' => [
                                'News.foreign_key ' => $i
                            ]
                        ]
                    ]);
                }
                else
                    if ($count >= 2)
                    {
                        // if top news more then or equal to 2.
                        $news[] = $this->News->find('all', [
                            'conditions' => [
                                'News.top_news ' => 1,
                                'AND' => [
                                    'News.foreign_key ' => $i
                                ]
                            ],
                            'limit' => 2
                        ]);
                    }
                    else
                    {

                        // display most visited news.
                        $news[] = $this->News->find('all', [
                            'conditions' => [
                                'News.foreign_key' => $i
                            ],
                            'order' => [
                                'News.most_read' => 'DESC'
                            ],
                            'limit' => 2
                        ]);
                    }
            }
        }
        $this->Slider->bindModel([
            'belongsTo' => [
                'File'
            ]
        ]);
        $slider = $this->Slider->find('all', [
            'conditions' => [
                'Slider.foreign_key' => 0,
                'Slider.status' => 1
            ]
        ]);
        $this->set(compact('news', 'slider', 'search'));
    }

    /**
     * view method
     *
     * @param string     $id
     * @param null|mixed $string
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function view($string = null)
    {
        if ($string == 'about_us')
        {
            $string1 = 'About Us';
        }
        elseif ($string == 'contact_us')
        {
            $string1 = 'Contact Us';
        }
        elseif ($string == 'help')
        {
            $string1 = 'Help';
        }
        elseif ($string == 'privacy_policy')
        {
            $string1 = 'Privacy Policy';
        }
        elseif ($string == 'terms_conditions')
        {
            $string1 = 'Terms and Conditions';
        }
        $this->set('title_for_layout', __($string1));
        $this->loadModel('StaticPage');
        $conditions = [
            'StaticPage.slug' => $string,
            'StaticPage.status' => 1
        ];
        if (! $this->StaticPage->hasAny($conditions))
        {
            throw new NotFoundException(__('Invalid page'));
        }

        $pages = $this->StaticPage->find('all', [
            'conditions' => [
                'StaticPage.slug' => $string
            ]
        ]);
        $this->set(compact('pages'));
    }

    /**
     * contactUs method
     *
     * @return void
     */
    public function contactUs()
    {
        $to = $this->request->data['ContactUs']['email'];
        $this->layout = false;
        $this->autoRender = false;
        if ($this->request->is('post'))
        {
            $this->loadModel('ContactUs');
            $this->loadModel('EmailTemplate');
            $emailTemplate = $this->EmailTemplate->find('first', [
                'conditions' => [
                    'EmailTemplate.id' => 4
                ]
            ]);
            $subject = $emailTemplate['EmailTemplate']['subject'];
            $emailTemplate = str_replace([
                '{EMAIL}',
                '{MESSAGE}'
            ], [
                $this->request->data['ContactUs']['email'],
                $this->request->data['ContactUs']['message']
            ], $emailTemplate['EmailTemplate']['description']);
            $status = $this->_sendSmtpMail($subject, $emailTemplate, $to);

            if ($status)
            {
                $this->ContactUs->create();
                if ($this->ContactUs->save($this->request->data))
                {
                    $this->Flash->success(__('Your message has been sent successfully.'));
                }
                else
                {
                    $this->Flash->error(__('The message can not be sent. Please, try again.'));
                }
            }
            else
            {
                $this->Flash->error(__('The message can not be sent. Please, try again.'));
            }
            return $this->redirect([
                'controller' => 'pages',
                'action' => 'view',
                'contact_us'
            ]);
        }
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
        $this->loadModel('ContactUs');
        $this->ContactUs->recursive = 0;
        $this->paginate = [
            'contain' => false,
            'limit' => 25,
            'conditions' => $conditions,
            'order' => $order
        ];
        $this->set('messages', $this->paginate('ContactUs'));
        $status = [
            'Inactive',
            'Active',
            'Blocked'
        ];
        $this->set(compact('status'));
    }

    /**
     * admin_contact method
     *
     * @return string
     */
    public function admin_contact()
    {
        $this->set('title_for_layout', 'View Messages');
        $this->layout = 'backend';
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'ContactUs.created DESC');
    }

    public function _getSearchConditions()
    {
        $input = $_GET;
        $model = 'ContactUs';

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
                'ContactUs' => $input
            ];
        }

        return $conditions;
    }

    /**
     * replyMessage method
     *
     * @param string     $id
     * @param null|mixed $messageId
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_replyMessage($messageId = null)
    {
        $this->set('title_for_layout', 'Message Reply');
        $this->loadModel('ContactUs');
        $this->loadModel('EmailTemplate');
        $this->layout = 'backend';
        $id = base64_decode($messageId);
        if (! $this->ContactUs->exists($id))
        {
            throw new NotFoundException(__('Invalid message'));
        }
        $message = $this->ContactUs->find('first', [
            'conditions' => [
                'ContactUs.id' => $id
            ]
        ]);
        // change status read
        $this->ContactUs->id = $id;
        $this->ContactUs->saveField('status', 1);
        if ($this->request->is('post'))
        {
            if (! empty($this->request->data['ContactUs']['reply']))
            {
                $emailTemplate = $this->EmailTemplate->find('first', [
                    'conditions' => [
                        'EmailTemplate.id' => 5
                    ]
                ]);
                $subject = $emailTemplate['EmailTemplate']['subject'];
                $emailTemplate = str_replace([
                    '{MESSAGE}'
                ], [
                    $this->request->data['ContactUs']['reply']
                ], $emailTemplate['EmailTemplate']['description']);

                $status = $this->_sendSmtpMail($subject, $emailTemplate, $message['ContactUs']['email']);
                if ($status)
                {
                    // change status replied
                    $this->ContactUs->id = $id;
                    $this->ContactUs->saveField('status', 2);
                    $this->Flash->success(__('Your have send reply message successfully.'));
                }
                else
                {
                    $this->Flash->error(__('The message can not be sent. Please, try again.'));
                }
                return $this->redirect([
                    'controller' => 'pages',
                    'action' => 'contact',
                    'admin' => true
                ]);
            }
            $this->Flash->error(__('The message can not be sent. Message is empty. Please, try again.'));
            return $this->redirect([
                'controller' => 'pages',
                'action' => 'contact',
                'admin' => true
            ]);
        }
        $this->set(compact('message'));
    }

    // smtp mail reply to sender
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
     * $this->Email->from = 'sdd.sdei1@gmail.com';
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
}
