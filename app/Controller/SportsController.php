<?php
App::uses('AppController', 'Controller');

/**
 * Sports Controller
 *
 * @property Sport $Sport
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class SportsController extends AppController
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

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('sport', 'news');
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'List Sports');
        $this->Sport->recursive = 0;
        $this->set('sports', $this->Paginator->paginate());
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
        $this->set('title_for_layout', 'View Sport');
        if (! $this->Sport->exists(base64_decode($id)))
        {
            throw new NotFoundException(__('Invalid sport'));
        }
        $options = [
            'conditions' => [
                'Sport.' . $this->Sport->primaryKey => base64_decode($id)
            ]
        ];
        $this->set('sport', $this->Sport->find('first', $options));
    }

    /**
     * sport_view method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_view($id = null)
    {
        $this->set('title_for_layout', __('View Sport'));
        if (! $this->Sport->exists(base64_decode($id)))
        {
            throw new NotFoundException(__('Invalid sport'));
        }
        $options = [
            'conditions' => [
                'Sport.' . $this->Sport->primaryKey => base64_decode($id)
            ]
        ];
        $this->set('sport', $this->Sport->find('first', $options));
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
        $this->set('title_for_layout', 'View Sport');
        if (! $this->Sport->exists(base64_decode($id)))
        {
            throw new NotFoundException(__('Invalid sport'));
        }
        $options = [
            'conditions' => [
                'Sport.' . $this->Sport->primaryKey => base64_decode($id)
            ]
        ];
        $this->set('sport', $this->Sport->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', 'Add Sport');
        if ($this->request->is('post'))
        {
            if ($this->data['Sport']['banner_image']['name'])
            {
                // code for banner image
                $exten = explode('.', $this->data['Sport']['banner_image']['name']);
                $exten1 = explode('.', $this->data['Sport']['tile_image']['name']);
                if (($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG') and ($exten1[1] == 'GIF' || $exten1[1] == 'gif' || $exten1[1] == 'jpg' || $exten1[1] == 'jpeg' || $exten1[1] == 'PNG' || $exten1[1] == 'png' || $exten1[1] == 'JPG' || $exten1[1] == 'JPEG'))
                {

                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['Sport']['banner_image'];
                    $destination = 'img/BannerImages/large/';
                    $destination2 = 'img/BannerImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '915', 'jpg', '915', '300');
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '80', 'jpg', '80', '80');
                    $files_data = $this->data['Sport']['banner_image'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/BannerImages/', $filename);

                    // code for tile image upload
                    $filename1 = time() . '.' . $exten1[1];
                    $file2 = $this->data['Sport']['tile_image'];
                    $destination3 = 'img/BannerImages/large/';
                    $destination4 = 'img/BannerImages/thumbnail/';

                    $this->Resizer->upload($file2, $destination3, $filename1);
                    $this->Resizer->image($file2, 'resize', '480', 'jpg', '348', '478');
                    $fileName1 = $this->Resizer->upload($file2, $destination4, $filename1);
                    $this->Resizer->image($file2, 'resize', '80', 'jpg', '80', '80');
                    $files_data1 = $this->data['Sport']['tile_image'];
                    $upload_info1 = $this->File->upload($files_data1, WWW_ROOT . 'img/BannerImages/', $filename1);

                    if (($upload_info['uploaded'] == 1) and ($upload_info1['uploaded'] == 1))
                    {
                        $this->Sport->create();
                        $this->request->data['Sport']['banner_image'] = $upload_info['db_info']['Upload']['id'];
                        $this->request->data['Sport']['tile_image'] = $upload_info1['db_info']['Upload']['id'];

                        if ($this->Sport->save($this->request->data))
                        {
                            $this->Flash->success(__('The sport has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }

                        $this->Flash->error(__('The sport could not be saved. Please, try again.'));
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
            } /*
               * else { //pr($this->request->data);die;
               * $this->Sport->create();
               * if ($this->Sport->save($this->request->data)) {
               * $this->Flash->success(__('The sport has been saved.'));
               * return $this->redirect(array('action' => 'index'));
               * } else {
               * $this->Flash->error(__('The sport could not be saved. Please, try again.'));
               * }
               * }
               */
        }
        $this->Sport->unbindModel([
            'hasMany' => [
                'League',
                'Team',
                'Tournament'
            ]
        ]);
        $usersList = $this->Sport->find('list', [
            'fields' => [
                'Sport.user_id'
            ]
        ]);

        $usersList = $this->Sport->find('list', [
            'fields' => [
                'Sport.user_id'
            ]
        ]);
        if (! empty($usersList))
        {
            $users = $this->Sport->User->find('list', [
                'conditions' => [
                    'User.role_id' => 2,
                    'User.id NOT' => $usersList
                ]
            ]);
        }
        else
        {
            $users = $this->Sport->User->find('list', [
                'conditions' => [
                    'User.role_id' => 2
                ]
            ]);
        }

        $users = $this->Sport->User->find('list', [
            'conditions' => [
                'User.role_id' => 2,
                'User.id NOT' => $usersList
            ]
        ]);
        $this->set(compact('users'));
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
        $this->set('title_for_layout', 'Update Sport');
        $id = base64_decode($id);
        /*
         * if (!$this->Sport->exists(base64_decode($id))) {
         * throw new NotFoundException(__('Invalid sport'));
         * }
         */
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $upload_info = [];
            $upload_info1 = [];
            if ($this->data['Sport']['banner_image']['name'] || $this->data['Sport']['tile_image']['name'])
            {
                // code for banner image
                if ($this->data['Sport']['banner_image']['name'])
                {

                    $exten = explode('.', $this->data['Sport']['banner_image']['name']);
                    if (($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG'))
                    {
                        $filename = time() . '.' . $exten[1];
                        $file1 = $this->data['Sport']['banner_image'];
                        $destination = 'img/BannerImages/large/';
                        $destination2 = 'img/BannerImages/thumbnail/';

                        $this->Resizer->upload($file1, $destination, $filename);
                        $this->Resizer->image($file1, 'resize', '915', 'jpg', '915', '300');
                        $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                        $this->Resizer->image($file1, 'resize', '80', 'jpg', '80', '80');
                        $files_data = $this->data['Sport']['banner_image'];

                        $pushValue = [
                            'file_id' => $this->data['Sport']['update_banner_image_id']
                        ];
                        $files_data = array_merge($files_data, $pushValue);
                        $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/BannerImages/', $filename);
                    }
                    else
                    {
                        $this->Flash->error(__('Please select a valid image format.'));
                    }
                }
                if ($this->data['Sport']['tile_image']['name'])
                {
                    $exten1 = explode('.', $this->data['Sport']['tile_image']['name']);
                    if (($exten1[1] == 'GIF' || $exten1[1] == 'gif' || $exten1[1] == 'jpg' || $exten1[1] == 'jpeg' || $exten1[1] == 'PNG' || $exten1[1] == 'png' || $exten1[1] == 'JPG' || $exten1[1] == 'JPEG'))
                    {
                        // code for tile image upload
                        $filename1 = time() . '.' . $exten1[1];
                        $file2 = $this->data['Sport']['tile_image'];
                        $destination3 = 'img/BannerImages/large/';
                        $destination4 = 'img/BannerImages/thumbnail/';

                        $this->Resizer->upload($file2, $destination3, $filename1);
                        $this->Resizer->image($file2, 'resize', '480', 'jpg', '348', '478');
                        $fileName1 = $this->Resizer->upload($file2, $destination4, $filename1);
                        $this->Resizer->image($file2, 'resize', '80', 'jpg', '80', '80');
                        $files_data1 = $this->data['Sport']['tile_image'];

                        $pushValue = [
                            'file_id' => $this->data['Sport']['update_tile_image_id']
                        ];
                        $files_data1 = array_merge($files_data1, $pushValue);
                        $upload_info1 = $this->File->upload($files_data1, WWW_ROOT . 'img/BannerImages/', $filename1);
                    }
                    else
                    {
                        $this->Flash->error(__('Please select a valid image format.'));
                    }
                }

                if ((isset($upload_info['uploaded']) && ($upload_info['uploaded'] == 1)) || (isset($upload_info1['uploaded']) and ($upload_info1['uploaded'] == 1)))
                {
                    unset($this->request->data['Sport']['update_banner_image_id']);
                    unset($this->request->data['Sport']['update_tile_image_id']);
                    $this->Sport->create();
                    if ((isset($upload_info['uploaded']) && ($upload_info['uploaded'] == 1)) and (isset($upload_info1['uploaded']) and ($upload_info1['uploaded'] == 1)))
                    {
                        $this->request->data['Sport']['banner_image'] = $upload_info['db_info']['Upload']['id'];
                        $this->request->data['Sport']['tile_image'] = $upload_info1['db_info']['Upload']['id'];
                    }
                    else
                        if (isset($upload_info['uploaded']) and $upload_info['uploaded'] == 1)
                        {
                            unset($this->request->data['Sport']['tile_image']);
                            $this->request->data['Sport']['banner_image'] = $upload_info['db_info']['Upload']['id'];
                        }
                        else
                            if (isset($upload_info1['uploaded']) and $upload_info1['uploaded'] == 1)
                            {
                                unset($this->request->data['Sport']['banner_image']);
                                $this->request->data['Sport']['tile_image'] = $upload_info1['db_info']['Upload']['id'];
                            }
                    // pr($this->request->data); die;
                    if ($this->Sport->save($this->request->data))
                    {
                        $this->Flash->success(__('The sport has been updated.'));
                        return $this->redirect([
                            'action' => 'index'
                        ]);
                    }

                    $this->Flash->error(__('The sport could not be saved. Please, try again.'));
                }
                else
                {
                    $this->Flash->error(__('Unable to upload Image and save record. Please, try again.'));
                }
            }
            else
            { // if no image updated
                unset($this->request->data['Sport']['tile_image']);
                unset($this->request->data['Sport']['banner_image']);
                unset($this->request->data['Sport']['update_banner_image_id']);
                unset($this->request->data['Sport']['update_tile_image_id']);
                if ($this->Sport->save($this->request->data))
                {
                    $this->Flash->success(__('The sport has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The sport could not be saved. Please, try again.'));
            }
        }
        else
        {
            $options = [
                'conditions' => [
                    'Sport.' . $this->Sport->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Sport->find('first', $options);
        }

        $this->Sport->unbindModel([
            'hasMany' => [
                'League',
                'Team',
                'Tournament'
            ]
        ]);

        $usersList = $this->Sport->find('list', [
            'conditions' => [
                'Sport.user_id !=' => $this->data['User']['id']
            ],
            'fields' => [
                'Sport.user_id'
            ]
        ]);
        if (! empty($usersList))
        {
            $users = $this->Sport->User->find('list', [
                'conditions' => [
                    'User.role_id' => 2,
                    'User.id NOT' => $usersList
                ]
            ]);
        }
        else
        {
            $users = $this->Sport->User->find('list', [
                'conditions' => [
                    'User.role_id' => 2
                ]
            ]);
        }
        // pr($users);die;
        $this->set(compact('users'));
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
        $this->set('title_for_layout', 'Delet Sport');
        $this->Sport->id = $id;
        if (! $this->Sport->exists())
        {
            throw new NotFoundException(__('Invalid sport'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Sport->delete())
        {
            $this->Flash->success(__('The sport has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The sport could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * sport method
     *
     * @param null|mixed $sportId
     *
     * @return void
     */
    public function sport($sportId = null)
    {
        $this->set('title_for_layout', __('Home'));
        $this->layout = 'default';
        $this->loadModel('News');
        $this->loadModel('UserTeam');
        $this->loadModel('Slider');
        $search = 0;
        if ($this->request->data && ! empty($sportId))
        {

            $news = $this->News->find('all', [
                'conditions' => [
                    'News.foreign_key' => $sportId,
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
            if (! empty($sportId))
            {
                $news = $this->News->find('all', [
                    'conditions' => [
                        'News.foreign_key' => $sportId
                    ],
                    'order' => [
                        'News.created' => 'DESC'
                    ],
                    'limit' => LIMIT
                ]);
            }
        }
        $this->UserTeam->unbindModel([
            'belongsTo' => [
                'User',
                'Tournament',
                'Sport',
                'Team'
            ]
        ]);
        $topLeagues = $this->UserTeam->find('all', [
            'conditions' => [
                'UserTeam.sport_id' => $sportId
            ],
            'group' => [
                'UserTeam.league_id'
            ],
            'fields' => [
                'count("UserTeam.league_id") as userCount',
                'League.name'
            ]
        ]);

        $this->Slider->bindModel([
            'belongsTo' => [
                'File'
            ]
        ]);
        $slider = $this->Slider->find('all', [
            'conditions' => [
                'Slider.foreign_key' => $sportId
            ]
        ]);
        // if sport slider empty then add home slider as default slider
        if (empty($slider))
        {
            $this->Slider->bindModel([
                'belongsTo' => [
                    'File'
                ]
            ]);
            $slider = $this->Slider->find('all', [
                'conditions' => [
                    'Slider.foreign_key' => 0
                ]
            ]);
        }

        $this->set(compact('news', 'topLeagues', 'slider', 'search'));
    }

    /**
     * news method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function news($id = null)
    {
        $this->set('title_for_layout', __('View News'));
        $id = base64_decode($id);
        $this->loadModel('News');
        $this->loadModel('User');
        $this->loadModel('NewsComment');

        if (! $this->News->exists($id))
        {
            throw new NotFoundException(__('Invalid news'));
        }
        // $this->News->User->unbindModel(array('belongsTo'=>array('Locale','Role'),'hasMany'=>array('League','PollResponse','Sport','Team','WallContent','UserTeam')));
        $news = $this->News->find('first', [
            'conditions' => [
                'News.id' => $id
            ]
        ]);
        $newsConditions = [
            'NewsComment.news_id' => $id
        ];
        $userArray = $this->Auth->user();
        if (! empty($userArray))
        {
            $uId = $this->Auth->user('id');
            $this->set('uId', $uId);
            // $newsConditions = array_merge($newsConditions/*,array('NewsComment.user_id'=>$uId)*/);
        }
        $newsCom = $this->NewsComment->find('all', [
            'conditions' => $newsConditions,
            'recursive' => 2,
            'contain' => [
                'User',
                'User.File'
            ],
            'order' => 'NewsComment.id desc'
        ]);

        // check page refreshed or not
        $_SESSION['LastRequest'] = '';
        $RequestSignature = md5($_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'] . print_r($_POST, true));
        if ($_SESSION['LastRequest'] == $RequestSignature)
        {
            // This is a page refresh.;
        }
        else
        {
            $_SESSION['LastRequest'] = $RequestSignature;
            $addReadCount = $news['News']['most_read'] + 1;
            $this->News->id = $id;
            $this->News->saveField('most_read', $addReadCount);
        }
        $this->News->unbindModel([
            'belongsTo' => [
                'Sport'
            ]
        ]);
        $newsTrends = $this->News->find('all', [
            'conditions' => [
                'News.foreign_key' => $news['News']['foreign_key']
            ],
            'order' => 'News.most_read DESC',
            'limit' => LIMIT,
            'fields' => [
                'File.new_name',
                'News.name',
                'News.id',
                'News.description'
            ]
        ]);
        // pr($newsTrends);
        $this->set(compact('news', 'newsTrends', 'newsCom'));
    }

    /**
     * addPolls method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_addPolls()
    {
        $this->loadModel('Poll');
        $this->loadModel('Locale');
        $locale = $this->Locale->find('list', [
            'fields' => [
                'id',
                'code'
            ],
            'conditions' => [
                'Locale.code !=' => 'eng'
            ]
        ]);
        $this->set('locale', $locale);
        if ($this->request->is([
            'post',
            'put'
        ]))
        {

            $this->_savePoll($this->request->data, $postType = 'poll');
        }
    }

    /**
     * _savePoll method
     *
     * @param data       $data
     * @param null|mixed $type
     *
     * @return void
     */
    public function _savePoll($data = null, $type = null)
    {
        // check post type(forum or poll)
        if ($type == 'forum')
        {
            if (empty($data['Poll']['name']))
            {
                $this->Flash->error(__('Unable to save polls. Please, try again.'));
                return $this->redirect([
                    'controller' => 'sports',
                    'action' => 'addFourms'
                ]);
            }

            $data['Poll']['poll_category_id'] = ForumCategory;
            if ($this->Poll->save($data))
            {
                $this->Flash->success(__('Forum has been saved successfully.'));
                return $this->redirect([
                    'controller' => 'sports',
                    'action' => 'polls'
                ]);
            }
            $this->Flash->error(__('Unable to save forum. Please, try again.'));
            return $this->redirect([
                'controller' => 'sports',
                'action' => 'polls'
            ]);
        }
        if (empty($data['Poll']['options']) || empty($data['Poll']['answer']))
        {
            $this->Flash->error(__('Unable to save polls. Please, try again.'));
            return $this->redirect([
                'controller' => 'sports',
                'action' => 'polls'
            ]);
        }
        $data['Poll']['options'] = serialize($data['Poll']['options']);
        $data['Poll']['poll_category_id'] = PollsCategory;
        if (strpos($data['Poll']['options'], $data['Poll']['answer']) !== false)
        {
            if ($this->Poll->save($data))
            {
                $this->Flash->success(__('Poll has been saved successfully.'));
                return $this->redirect([
                    'controller' => 'sports',
                    'action' => 'polls'
                ]);
            }
            $this->Flash->error(__('Unable to save polls. Please, try again.'));
            return $this->redirect([
                'controller' => 'sports',
                'action' => 'polls'
            ]);
        }
        $this->Flash->error(__('The answer text does not match with options.'));
        return $this->redirect([
            'controller' => 'sports',
            'action' => 'addPolls'
        ]);
    }

    /**
     * admin_polls method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_polls()
    {
        $this->loadModel('Poll');
        $this->paginate = [
            'contain' => false,
            'limit' => LIMIT,
            'order' => 'Poll.created'
        ];
        $this->set('polls', $this->paginate('Poll'));
    }

    /**
     * admin_viewPoll method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_viewPoll($id = null)
    {
        $id = base64_decode($id);
        $this->loadModel('Poll');
        if (! $this->Poll->exists($id))
        {
            throw new NotFoundException(__('Invalid poll'));
        }
        $poll = $this->Poll->find('first', [
            'conditions' => [
                'Poll.id' => $id
            ]
        ]);
        $this->set(compact('poll'));
    }

    /**
     * addPolls method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_editPoll($id = null)
    {
        $this->loadModel('Poll');
        $id = base64_decode($id);
        $this->loadModel('Poll');
        $this->loadModel('Locale');
        $locale = $this->Locale->find('list', [
            'fields' => [
                'id',
                'code'
            ],
            'conditions' => [
                'Locale.code !=' => 'eng'
            ]
        ]);
        $this->set('locale', $locale);
        if (! $this->Poll->exists($id))
        {
            throw new NotFoundException(__('Invalid poll'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            // pr($this->request->data); die;
            $this->_editPoll($this->request->data, $postType = 'poll');
        }

        $this->data = $this->Poll->find('first', [
            'conditions' => [
                'Poll.id' => $id
            ]
        ]);
    }

    /**
     * _editPoll method
     *
     * @param data       $data
     * @param null|mixed $type
     *
     * @return void
     */
    public function _editPoll($data = null, $type = null)
    {
        if ($type == 'poll')
        {
            $data['Poll']['options'] = serialize($data['Poll']['options']);
            $data['Poll']['poll_category_id'] = PollsCategory;
            if (strpos($data['Poll']['options'], $data['Poll']['answer']) !== false)
            {
                if ($this->Poll->save($data))
                {
                    $this->Flash->success(__('Poll has been saved successfully.'));
                    return $this->redirect([
                        'controller' => 'sports',
                        'action' => 'polls'
                    ]);
                }
                $this->Flash->error(__('Unable to save poll. Please, try again.'));
                return $this->redirect([
                    'controller' => 'sports',
                    'action' => 'polls'
                ]);
            }
            $this->Flash->error(__('The answer text does not match with options.'));
            return $this->redirect([
                'controller' => 'sports',
                'action' => 'editPoll',
                base64_encode($data['Poll']['id'])
            ]);
        }
        if ($this->Poll->save($data))
        {
            $this->Flash->success(__('Forum has been saved successfully.'));
            return $this->redirect([
                'controller' => 'sports',
                'action' => 'polls'
            ]);
        }
        $this->Flash->error(__('Unable to save forum. Please, try again.'));
        return $this->redirect([
            'controller' => 'sports',
            'action' => 'polls'
        ]);
    }

    /**
     * admin_pollStatus method
     *
     * @param data       $data
     * @param null|mixed $id
     * @param null|mixed $status
     *
     * @return void
     */
    public function admin_pollStatus($id = null, $status = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('Poll');
        $id = base64_decode($id);

        if (! $this->Poll->exists($id))
        {
            throw new NotFoundException(__('Invalid poll'));
        }
        if (isset($id) && isset($status))
        {
            $this->Poll->id = $id;
            if ($this->Poll->saveField('status', base64_decode($status)))
            {
                $this->Flash->success(__('Poll status has been changed successfully.'));
                return $this->redirect([
                    'controller' => 'sports',
                    'action' => 'polls'
                ]);
            }
            $this->Flash->error(__('Unable to change poll status. Please, try again.'));
            return $this->redirect([
                'controller' => 'sports',
                'action' => 'polls'
            ]);
        }
        $this->Flash->error(__('Unable to change poll status. Please, try again.'));
        return $this->redirect([
            'controller' => 'sports',
            'action' => 'polls'
        ]);
    }

    /**
     * admin_addFourms method
     *
     * @param string $id
     *
     * @return void
     */
    public function admin_addFourms()
    {
        $this->loadModel('Poll');
        $this->loadModel('Locale');
        $locale = $this->Locale->find('list', [
            'fields' => [
                'id',
                'code'
            ],
            'conditions' => [
                'Locale.code !=' => 'eng'
            ]
        ]);
        $this->set('locale', $locale);
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $this->_savePoll($this->request->data, $postType = 'forum');
        }
    }

    /**
     * admin_fourms method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_fourms()
    {
        $this->loadModel('Poll');
        $this->paginate = [
            'contain' => false,
            'limit' => LIMIT,
            'order' => 'Poll.created'
        ];
        $this->set('polls', $this->paginate('Poll'));
    }

    /**
     * admin_viewForum method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_viewForum($id = null)
    {
        $id = base64_decode($id);
        $this->loadModel('Poll');
        if (! $this->Poll->exists($id))
        {
            throw new NotFoundException(__('Invalid poll'));
        }
        $poll = $this->Poll->find('first', [
            'conditions' => [
                'Poll.id' => $id
            ]
        ]);
        $this->set(compact('poll'));
    }

    /**
     * admin_forumStatus method
     *
     * @param data       $data
     * @param null|mixed $id
     * @param null|mixed $status
     *
     * @return void
     */
    public function admin_forumStatus($id = null, $status = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('Poll');
        $id = base64_decode($id);

        if (! $this->Poll->exists($id))
        {
            throw new NotFoundException(__('Invalid forum'));
        }
        if (isset($id) && isset($status))
        {
            $this->Poll->id = $id;
            if ($this->Poll->saveField('status', base64_decode($status)))
            {
                $this->Flash->success(__('Forum status has been changed successfully.'));
                return $this->redirect([
                    'controller' => 'sports',
                    'action' => 'polls'
                ]);
            }
            $this->Flash->error(__('Unable to change forum status. Please, try again.'));
            return $this->redirect([
                'controller' => 'sports',
                'action' => 'polls'
            ]);
        }
        $this->Flash->error(__('Unable to change poll status. Please, try again.'));
        return $this->redirect([
            'controller' => 'sports',
            'action' => 'polls'
        ]);
    }

    /**
     * admin_editForum method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_editForum($id = null)
    {
        $this->loadModel('Poll');
        $id = base64_decode($id);
        $this->loadModel('Locale');
        $locale = $this->Locale->find('list', [
            'fields' => [
                'id',
                'code'
            ],
            'conditions' => [
                'Locale.code !=' => 'eng'
            ]
        ]);
        $this->set('locale', $locale);
        $this->loadModel('Poll');
        if (! $this->Poll->exists($id))
        {
            throw new NotFoundException(__('Invalid forum'));
        }

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            // pr($this->request->data); die;
            $this->_editPoll($this->request->data, $postType = 'forum');
        }

        $this->data = $this->Poll->find('first', [
            'conditions' => [
                'Poll.id' => $id
            ]
        ]);
    }
}
