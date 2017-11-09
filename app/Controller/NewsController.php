<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * News Controller
 *
 * @property News $News
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class NewsController extends AppController
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

    public $uses = [
        'News',
        'NewsComment',
        'Pocale',
        'HinNews',
        'ThaNews',
        'Abuse'
    ];

    /*
     *
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('time_elapsed_string', 'otherlang', 'abusenews','getAjaxTemplate');
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
        $this->News->recursive = 0;

        $this->paginate = [
            'contain' => false,
            'limit' => LIMIT,
            'conditions' => $conditions,
            'order' => $order
        ];
        $this->set('news', $this->paginate('News'));
        $status = [
            'Inactive',
            'Active',
            'Blocked'
        ];
        $sports = $this->Sport->find('list');
        $this->set(compact('status', 'sports'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'List News');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'News.top_news DESC');
    }

    public function _getSearchConditions()
    {
        $input = $_GET;
        $model = 'News';

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
                'News' => $input
            ];
        }
        if (AuthComponent::user('role_id') == 2)
        {
            $conditions[$model . '.' . 'foreign_key'] = $this->Session->read('Auth.Sports.SportInfo.Sport.id');
        }

        // pr($conditions); die;
        return $conditions;
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
        $this->set('title_for_layout', 'View News');
        $id = base64_decode($id);
        if (! $this->News->exists($id))
        {
            throw new NotFoundException(__('Invalid news'));
        }
        $options = [
            'conditions' => [
                'News.' . $this->News->primaryKey => $id
            ]
        ];
        $this->set('news', $this->News->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', 'Add News');
        $this->loadModel('NewsTemplate');
        if ($this->request->is('post'))
        {

            unset($this->request->data['News']['language']);
            // $this->request->data['HinNews']['news_id'] = $this->request->data['News']['id'];
            // $this->request->data['ThaNews']['news_id'] = $this->request->data['News']['id'];
            Sanitize::clean($this->request->data);
            $this->request->data['News']['user_id'] = AuthComponent::user('id');
            if (($this->data['News']['file_id']['name']) || ($this->data['News']['second_file_id']['name']))
            {
               
                $this->data['News']['file_id']['name'];
               $tmpName = $this->data['News']['file_id']['tmp_name'];

              
               $imgType = $this->checkMimeTypeApp($tmpName);
               
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }
                $exten = explode('.', $this->data['News']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                   {
                    $imageSize = getimagesize($this->data['News']['file_id']['tmp_name']);
                   
                    if ($imageSize[0] <= 347 && $imageSize[1] <= 477)
                    {
                        $this->Flash->error(__('Please upload image greater than 348 (w) X 478 (h) dimension.'));
                        return $this->redirect([
                            'controller' => 'news',
                            'action' => 'add'
                        ]);
                    }
                    $filename = time() . '.' . $exten[1];
                   
                    $file1 = $this->data['News']['file_id'];
                    $destination = 'img/NewsImages/large/';
                    $destination2 = 'img/NewsImages/thumbnail/';
                   

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '480', 'jpg', '348', '478');
                   
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '180', 'jpg', '180', '180');
                    $files_data = $this->data['News']['file_id'];

                 
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/NewsImages/', $filename);
                    if(!empty($this->data['News']['second_file_id']['name'])){
                    $this->data['News']['second_file_id']['name'];
                    $tmpNames = $this->data['News']['second_file_id']['tmp_name'];
                    $imgTypes = $this->checkMimeTypeApp($tmpNames);
                    if ($imgTypes==0) 
                    {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                    }
                    $extens = explode('.', $this->data['News']['second_file_id']['name']);
                    if ($extens[1] == 'GIF' || $extens[1] == 'gif' || $extens[1] == 'jpg' || $extens[1] == 'jpeg' || $extens[1] == 'PNG' || $extens[1] == 'png' || $extens[1] == 'JPG' || $extens[1] == 'JPEG')
                    {
                     $imageSizes = getimagesize($this->data['News']['second_file_id']['tmp_name']);
                     if($imageSizes[0] <= 347 && $imageSizes[1] <= 477)
                     {
                        $this->Flash->error(__('Please upload second image greater than 348 (w) X 478 (h) dimension.'));
                        return $this->redirect([
                            'controller' => 'news',
                            'action' => 'add'
                        ]);
                     }
                     $filenames = time()+2 . '.' . $extens[1];
                     $files1 = $this->data['News']['second_file_id'];
                     $destinations = 'img/NewsImages/large/';
                     $destinations2 = 'img/NewsImages/thumbnail/';
                     $this->Resizer->upload($files1, $destinations, $filenames);
                     $this->Resizer->image($files1, 'resize', '480', 'jpg', '348', '478');
                    $fileNames = $this->Resizer->upload($files1, $destinations2, $filenames);

                    $this->Resizer->image($files1, 'resize', '180', 'jpg', '180', '180');

                    $files_datas = $this->data['News']['second_file_id'];

                    $upload_infos = $this->File->upload($files_datas, WWW_ROOT . 'img/NewsImages/', $filenames);

                    }
                    else
                    {
                    $this->Flash->error(__('Please select a valid second image format. gif, jpg, png, jpeg are allowed only'));
                    }
                    }
                    if (($upload_info['uploaded'] == 1)||($upload_infos['uploaded'] == 1))
                    {
                        $this->News->create();
                        $this->request->data['News']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if(!empty($upload_infos)){
                         $this->request->data['News']['second_file_id'] = $upload_infos['db_info']['Upload']['id'];
                          }
                        
                        if ($this->News->saveAll($this->request->data))
                        {
                            $this->Flash->success(__('The news has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The news could not be saved. Please, try again.'));
                    }
                    else
                    {
                        $this->Flash->error(__('Unable to upload Image and save record. Please, try again.'));
                    }
                }
                else
                {
                    $this->Flash->error(__('Please select a valid image format. gif, jpg, png, jpeg are allowed only'));
                }
            }
            else
            {
                Sanitize::clean($this->request->data);
                $this->News->create();
                // pr($this->request->data);die;
                if ($this->News->saveAll($this->request->data))
                {
                    $this->Flash->success(__('The news has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The news could not be saved. Please, try again.'));
            }
        }
        $available_lang = $this->Pocale->find('list', [
            'fields' => [
                'code',
                'name'
            ],
            'conditions' => [
                'Pocale.code !=' => 'eng'
            ]
        ]);
        $newstemplate = $this->NewsTemplate->find('list', [
            'fields' => [
                'NewsTemplate.title',
                
            ],
            'conditions' => [
                'NewsTemplate.status' => '1'
            ]
        ]);

        $sports = $this->Sport->find('list');
        $this->set(compact('sports', 'available_lang','newstemplate'));
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
      $this->set('title_for_layout', 'Update News');
        $this->loadModel('NewsTemplate');
        $id = base64_decode($id);
        // $this->News->bindModel(array('belongsTo'=>array("HinNews")));
        if (! $this->News->exists($id))
        {
            throw new NotFoundException(__('Invalid news'));
        }

       
       if ($this->request->is([
            'post',
            'put'
        ]))
        {
            unset($this->request->data['News']['language']);

            $this->request->data['HinNews']['news_id'] = $this->request->data['News']['id'];
            $this->request->data['ThaNews']['news_id'] = $this->request->data['News']['id'];
            Sanitize::clean($this->request->data);
            // strip_tags($this->request->data);
            // prx($this->request->data);
             if($this->data['News']['second_file_id']['name']){
                    $this->data['News']['second_file_id']['name'];
                    $tmpNames = $this->data['News']['second_file_id']['tmp_name'];
                    $imgTypes = $this->checkMimeTypeApp($tmpNames);
                    if ($imgTypes==0) 
                    {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                    }
                    $extens = explode('.', $this->data['News']['second_file_id']['name']);
                    if ($extens[1] == 'GIF' || $extens[1] == 'gif' || $extens[1] == 'jpg' || $extens[1] == 'jpeg' || $extens[1] == 'PNG' || $extens[1] == 'png' || $extens[1] == 'JPG' || $extens[1] == 'JPEG')
                    {
                     $imageSizes = getimagesize($this->data['News']['second_file_id']['tmp_name']);
                     if($imageSizes[0] <= 347 && $imageSizes[1] <= 477)
                     {
                        $this->Flash->error(__('Please upload second image greater than 348 (w) X 478 (h) dimension.'));
                             return $this->redirect([
                            'controller' => 'news',
                            'action' => 'edit',
                            base64_encode($id)
                    ]);
                     }
                     $filenames = time()+2 . '.' . $extens[1];
                     $files1 = $this->data['News']['second_file_id'];
                     $destinations = 'img/NewsImages/large/';
                     $destinations2 = 'img/NewsImages/thumbnail/';
                     $this->Resizer->upload($files1, $destinations, $filenames);
                     $this->Resizer->image($files1, 'resize', '480', 'jpg', '348', '478');
                    $fileNames = $this->Resizer->upload($files1, $destinations2, $filenames);

                    $this->Resizer->image($files1, 'resize', '180', 'jpg', '180', '180');

                    $files_datas = $this->data['News']['second_file_id'];

                    $upload_infos = $this->File->upload($files_datas, WWW_ROOT . 'img/NewsImages/', $filenames);
                         if ($upload_infos['uploaded'] == 1)
                        {
                            $this->News->create();
                            $this->request->data['News']['second_file_id'] = $upload_infos['db_info']['Upload']['id'];
                        }
                        else
                        {
                         $this->Flash->error(__('Unable to upload Image and save record. Please, try again.'));
                        }
                    }
                    else
                    {
                    $this->Flash->error(__('Please select a valid second image format. gif, jpg, png, jpeg are allowed only'));
                    }
                    }
                    else
                    {
                         unset($this->request->data['News']['second_file_id']);
                    }

                    if ($this->data['News']['file_id']['name'])
                    {
                        $tmpName = $this->data['News']['file_id']['tmp_name'];
                        $imgType = $this->checkMimeTypeApp($tmpName);
                        if ($imgType == 0)
                        {
                            $this->Flash->error(__('Invalid Image.'));
                            $this->redirect($this->referer());
                        }
                        $imageSize = getimagesize($this->data['News']['file_id']['tmp_name']);
                        if ($imageSize[0] <= 347 && $imageSize[1] <= 477)
                        {
                            $this->Flash->error(__('Please upload image greater than 348 (w) X 478 (h) dimension.'));
                            return $this->redirect([
                                'controller' => 'news',
                                'action' => 'edit',
                                base64_encode($id)
                            ]);
                        }
                        $exten = explode('.', $this->data['News']['file_id']['name']);
                        if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                        {
                            $filename = time() . '.' . $exten[1];
                            $file1 = $this->data['News']['file_id'];
                            $destination = 'img/NewsImages/large/';
                            $destination2 = 'img/NewsImages/thumbnail/';

                            $this->Resizer->upload($file1, $destination, $filename);
                            $this->Resizer->image($file1, 'resize', '480', 'jpg', '348', '478');

                            $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                            $this->Resizer->image($file1, 'resize', '180', 'jpg', '180', '180');

                            $files_data = $this->data['News']['file_id'];
                            $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/NewsImages/', $filename);

                            if ($upload_info['uploaded'] == 1)
                            {
                                $this->News->create();
                                $this->request->data['News']['file_id'] = $upload_info['db_info']['Upload']['id'];
                                if ($this->News->saveAll($this->request->data))
                                {
                                    // $newsId = $this->request->data['News']['id'];
                                    // unset($this->request->data['News']);
                                    // echo $newsId;
                                   //  pr($this->request->data);die;

                                    $this->Flash->success(__('The news has been saved.'));
                                    return $this->redirect([
                                        'action' => 'index'
                                    ]);
                                }
                                $this->Flash->error(__('The news could not be saved. Please, try again.'));
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
                Sanitize::clean($this->request->data);
                unset($this->request->data['News']['file_id']);
                unset($this->request->data['News']['second_file_id']);
                if ($this->News->saveAll($this->request->data))
                {
                    // $newsId = $this->request->data['News']['id'];
                    // unset($this->request->data['News']);
                    // echo $newsId;
                    // pr($this->request->data);die;
                    $this->Flash->success(__('The news has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The news could not be saved. Please, try again.'));
            }
        }
        else
        {
            $options = [
                'conditions' => [
                    'News.' . $this->News->primaryKey => $id
                ]
            ];
            $this->request->data = $this->News->find('first', $options);
            // prx($this->request->data);
        }

        $files = $this->News->File->find('list');
        $sports = $this->Sport->find('list');
        $available_lang = $this->Pocale->find('list', [
            'fields' => [
                'code',
                'name'
            ],
            'conditions' => [
                'Pocale.code !=' => 'eng'
            ]
        ]);
        $newstemplate = $this->NewsTemplate->find('list', [
            'fields' => [
                'NewsTemplate.title',
                
            ],
            'conditions' => [
                'NewsTemplate.status' => '1'
            ]
        ]);
       // pr($files);exit;
        $this->set(compact('sports', 'files', 'available_lang','newstemplate'));
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
        $this->set('title_for_layout', 'Delete News');
        $this->News->id = base64_decode($id);
        if (! $this->News->exists())
        {
            throw new NotFoundException(__('Invalid news'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->News->delete())
        {
            $this->Flash->success(__('The news has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The news could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * admin_changeToTopNews method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_changeToTopNews()
    {
        $this->autoRender = false;
        $this->News->id = base64_decode($this->request->data['id']);
        if (! $this->News->exists())
        {
            throw new NotFoundException(__('Invalid news'));
        }

        $topNewsCount = $this->News->find('count', [
            'conditions' => [
                'News.top_news' => 1,
                'AND' => [
                    'News.foreign_key' => $this->request->data['sportId']
                ]
            ]
        ]);
        if ($topNewsCount == 2 && $this->request->data['value'] == 1)
        {
            echo $topNewsCount;
        }
        else
        {
            if ($this->News->saveField('top_news', $this->request->data['value']))
            {
                echo 'saved';
            }
            else
            {
                echo 'error';
            }
        }
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function sports_index()
    {
        $this->set('title_for_layout', 'List News');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'News.top_news DESC');
    }

    /**
     * sports_add method
     *
     * @return void
     */
    public function sports_add()
    {
        $this->set('title_for_layout', 'Add News');
        if ($this->request->is('post'))
        {
            $this->request->data['News']['user_id'] = AuthComponent::user('id');
            $this->request->data['News']['publish'] = 0;
            if ($this->data['News']['file_id']['name'])
            {
                $tmpName = $this->data['News']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }
                $exten = explode('.', $this->data['News']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $imageSize = getimagesize($this->data['News']['file_id']['tmp_name']);
                    if ($imageSize[0] <= 347 && $imageSize[1] <= 477)
                    {
                        $this->Flash->error(__('Please upload image greater than 348 (w) X 478 (h) dimension.'));
                        return $this->redirect([
                            'controller' => 'news',
                            'action' => 'add',
                            'sports' => true
                        ]);
                    }
                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['News']['file_id'];
                    $destination = 'img/NewsImages/large/';
                    $destination2 = 'img/NewsImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '480', 'jpg', '348', '478');

                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '180', 'jpg', '180', '180');

                    $files_data = $this->data['News']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/NewsImages/', $filename);
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->News->create();
                        $this->request->data['News']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        $this->request->data['News']['foreign_key'] = $this->Session->read('Auth.Sports.SportInfo.Sport.id');
                        if ($this->News->save($this->request->data))
                        {
                            $this->Flash->success(__('The news has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The news could not be saved. Please, try again.'));
                    }
                    else
                    {
                        $this->Flash->error(__('Unable to upload Image and save record. Please, try again.'));
                    }
                }
                else
                {
                    $this->Flash->error(__('Please select a valid image format. gif, jpg, png, jpeg are allowed only'));
                }
            }
            else
            {
                $this->News->create();
                if ($this->News->save($this->request->data))
                {
                    $this->Flash->success(__('The news has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The news could not be saved. Please, try again.'));
            }
        }
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
        $this->set('title_for_layout', 'View News');
        $id = base64_decode($id);
        if (! $this->News->exists($id))
        {
            throw new NotFoundException(__('Invalid news'));
        }
        $options = [
            'conditions' => [
                'News.' . $this->News->primaryKey => $id
            ]
        ];
        $this->set('news', $this->News->find('first', $options));
    }

    /**
     * sports_edit method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_edit($id = null)
    {
        $this->set('title_for_layout', 'Update News');
        $id = base64_decode($id);
        if (! $this->News->exists($id))
        {
            throw new NotFoundException(__('Invalid news'));
        }

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->data['News']['file_id']['name'])
            {

                $imageSize = getimagesize($this->data['News']['file_id']['tmp_name']);
                if ($imageSize[0] <= 347 && $imageSize[1] <= 477)
                {
                    $this->Flash->error(__('Please upload image greater than 348 (w) X 478 (h) dimension.'));
                    return $this->redirect([
                        'controller' => 'news',
                        'action' => 'edit',
                        base64_encode($id)
                    ]);
                }
                $exten = explode('.', $this->data['News']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {
                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['News']['file_id'];
                    $destination = 'img/NewsImages/large/';
                    $destination2 = 'img/NewsImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '480', 'jpg', '348', '478');
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '180', 'jpg', '180', '180');

                    $files_data = $this->data['News']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/NewsImages/');
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->News->create();
                        $this->request->data['News']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->News->save($this->request->data))
                        {
                            $this->Flash->success(__('The news has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The news could not be saved. Please, try again.'));
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
                unset($this->request->data['News']['file_id']);
                if ($this->News->save($this->request->data))
                {
                    $this->Flash->success(__('The news has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The news could not be saved. Please, try again.'));
            }
        }
        else
        {
            $options = [
                'conditions' => [
                    'News.' . $this->News->primaryKey => $id
                ]
            ];
            $this->request->data = $this->News->find('first', $options);
        }

        $files = $this->News->File->find('list');
        $this->set(compact('files'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function editor_index()
    {
        $this->set('title_for_layout', 'List News');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'News.top_news DESC');
    }

    /**
     * admin_changeToAddedBy method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_changeToAddedBy()
    {
        $this->autoRender = false;
        $this->News->id = base64_decode($this->request->data['id']);
        if (! $this->News->exists())
        {
            throw new NotFoundException(__('Invalid news'));
        }
        if ($this->request->data['value'] == '0')
        {
            $returnMessage = 'publish';
        }
        else
        {
            $returnMessage = 'unpublish';
        }

        if ($this->News->saveField('publish', $this->request->data['value']))
        {
            echo $returnMessage;
        }
        else
        {
            echo 'error';
        }
    }

    /**
     * *******************************News Comment start****************************
     */
    /**
     * addComment method
     *
     * @return void
     */
    public function addComment()
    {
        $this->autoRender = false;
        if ($this->request->is('post'))
        {

            $this->request->data['NewsComment']['user_id'] = AuthComponent::user('id');
            $this->request->data['NewsComment']['news_id'] = base64_decode($this->request->data['NewsComment']['news_id']);
            // $this->request->data['NewsComment']['content'] = Sanitize::escape($this->request->data['NewsComment']['content']) ;
            $this->request->data['NewsComment']['content'] = Sanitize::clean($this->request->data['NewsComment']['content']);
            // pr($this->request->data);die;
            $this->NewsComment->create();
            if ($this->NewsComment->save($this->request->data))
            {
                $this->Flash->success(__('Comment has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('Comment could not be saved. Please, try again.'));
        }
        // pr($sports);
    }

    /**
     * *******************************News Comment end****************************
     * @param mixed $ptime
     */
    /*
     * ************************************************************************************
     * @Function Name : showing time in messages
     * @Params :
     * @Description : ajax function
     * @Author : SmartData
     * ******************************************************************************************
     */
    public function time_elapsed_string($ptime)
    {
        $etime = time() - $ptime;

        if ($etime < 1)
        {
            return '0 seconds';
        }

        $a = [
            365 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];
        $a_plural = [
            'year' => 'years',
            'month' => 'months',
            'day' => 'days',
            'hour' => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        ];

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }
    }

    public function otherlang()
    {
        $this->layout = false;
        // $this->autoRender = false;
        // pr($this->request->data);
        $this->set('news_id', $this->request->data['news_id']);
        $avl_lang_array = [];
        if (! empty($this->request->data['other_lang']))
        {
            foreach ($this->request->data['other_lang'] as $key => $value)
            {
                if (! empty($value))
                {
                    $available_lang = $this->Pocale->find('first', [
                        'conditions' => [
                            'Pocale.code' => $value
                        ],
                        'fields' => [
                            'id',
                            'code',
                            'name'
                        ]
                    ]);
                    $avl_lang_array[] = $available_lang;
                }
            }
        }
        // pr($avl_lang_array);die;
        $this->set('other_lang', $avl_lang_array);
        // die;
    }

    public function abusenews($newsId = null)
    {
        $this->autoRender = false;
        $this->layout = false;
        // $news_id = $this->request->data['news_id'];
        $news_id = base64_decode($newsId);
        $data = $this->Abuse->find('first', [
            'conditions' => [
                'Abuse.news_id' => $news_id
            ]
        ]);
        $count = 0;
        $abuse_id = '';
        if (! empty($data))
        {
            $count = $data['Abuse']['count'];
            $abuse_id = $data['Abuse']['id'];
        }
        $count = $count + 1;
        $this->request->data['Abuse']['news_id'] = $news_id;
        $this->request->data['Abuse']['count'] = $count;
        $this->request->data['Abuse']['id'] = $abuse_id;

        if ($this->Abuse->save($this->request->data))
        {
            $this->Flash->success(__('Your request has been submitted, Team will look into it.'));
            $this->redirect($this->referer());
        }
        else
        {
            $this->Flash->error(__('Something went wrong, Please try again'));
            $this->redirect($this->referer());
        }
    }
      public function admin_writerlist()
    { 
        $this->set('title_for_layout', 'List Writer');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
       $this->paginate =  array('fields' => array('News.user_id','News.description','News.status','Users.name','Users.id','count(*) AS Nums'),
            'joins' => array(
                array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'left',
                        'conditions' => array('News.user_id=Users.id')
                    ),
               
                ),
             'conditions'=>array('News.is_deleted=0','News.status=1','User.is_deleted'=>0,'User.status'=>1),
             'group'=>'News.user_id', 
             'limit' => 10,
        );
        $new = $this->News->find('all', [
            'fields' => [
                 'User.id',
                 'User.name',
                'User.email',
            ],
            'conditions' =>['User.is_deleted'=>0,'User.status'=>1],
            'order' =>['User.id']

        ]);

    $writerdata = $this->Paginator->paginate('News',$conditions);
     $this->set(compact('writerdata'));
     $this->set(compact('new'));
       
         
    }
      public function admin_newsDetails($id = null)
    { 
        $this->set('title_for_layout', 'View News');
         $id = base64_decode($id);
         if (! $this->User->exists($id))
        {
            throw new NotFoundException(__('Invalid news'));
        }
         $userdata = $this->User->find('all', [
            'fields' => [
               
                'User.name',
                'User.email',
                

            ],
            'conditions' =>['User.id'=>$id,'User.is_deleted'=>0,'User.status'=>1]
        ]);
         $newsdata = $this->News->find('all', [
            'fields' => [
               
                'News.description','News.external_url','News.id'                      
            ],
            'conditions' =>['News.user_id'=>$id,'News.is_deleted'=>0,'News.status'=>1]
        ]);
         
        $this->set(compact('userdata'));
      
         $this->set(compact('newsdata'));

       
    }
         public function getAjaxTemplate($newstemplateid = null)
    { 
        $this->layout = false;
        $this->autoRender = false;
        $newstemplateid = base64_decode($newstemplateid);
        $options = $this->News->NewsTemplate->find('first', [
            'conditions' => [
                'NewsTemplate.id' => $newstemplateid,
               
                
            ]
           
        ]);
         echo $options['NewsTemplate']['description'];die;
    }
   


}