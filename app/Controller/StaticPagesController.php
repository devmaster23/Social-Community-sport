<?php
App::uses('AppController', 'Controller');

/**
 * StaticPage Controller
 *
 * @property StaticPage $StaticPage
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class StaticPagesController extends AppController
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

    /**
     * beforeFilter method
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('view', 'viewLeague');
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'List Pages');
        $this->StaticPage->recursive = 0;
        $this->set('staticPages', $this->Paginator->paginate());
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
        $this->set('title_for_layout', 'View Page');
        $id = base64_decode($id);
        if (! $this->StaticPage->exists($id))
        {
            throw new NotFoundException(__('Invalid page'));
        }
        $datass = $this->StaticPage->find('first', [
            'conditions' => [
                'StaticPage.' . $this->StaticPage->primaryKey => $id
            ]
        ]);

        $options = [
            'conditions' => [
                'StaticPage.' . $this->StaticPage->primaryKey => $id
            ]
        ];
        $this->set('pages', $this->StaticPage->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', 'Add Page');
        if ($this->request->is('post'))
        {
            $this->StaticPage->create();
            if ($this->StaticPage->save($this->request->data))
            {
                $this->Flash->success(__('The page has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The page could not be saved. Please, try again.'));
        }
        $staticPages = $this->StaticPage->find('list');
        $this->set(compact('staticPages'));
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
        $this->set('title_for_layout', 'Update Page');
        $id = base64_decode($id);
        if (! $this->StaticPage->exists($id))
        {
            throw new NotFoundException(__('Invalid page'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->StaticPage->save($this->request->data))
            {
                $this->Flash->success(__('The page has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The page could not be saved. Please try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'StaticPage.' . $this->StaticPage->primaryKey => $id
                ]
            ];
            $this->request->data = $this->StaticPage->find('first', $options);
        }
        $staticPage = $this->StaticPage->find('list');
        $this->set(compact('staticPage'));
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
        $this->set('title_for_layout', 'Delete Page');
        $this->StaticPage->id = base64_decode($id);
        if (! $this->StaticPage->exists())
        {
            throw new NotFoundException(__('Invalid page'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->StaticPage->delete())
        {
            $this->Flash->success(__('The page has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The page could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * admin_slider method
     *
     * @return void
     */
    public function admin_slider()
    {
        $this->set('title_for_layout', 'List Slider');
        $this->loadModel('Slider');

        $this->paginate = [
            'contain' => false,
            'limit' => LIMIT,
            'fields' => [
                'Slider.*',
                'Sport.name'
            ]
        ];
        $this->set('sliders', $this->Paginator->paginate('Slider'));
    }

    /**
     * admin_addSlider method
     *
     * @return void
     */
    public function admin_addSlider()
    {
        $this->set('title_for_layout', 'Add Slider');
        $this->loadModel('Slider');
        if ($this->request->is('post'))
        {
            if ($this->data['Slider']['file_id']['name'])
            {
                $tmpName = $this->data['Slider']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }
                $exten = explode('.', $this->data['Slider']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $imageSize = getimagesize($this->data['Slider']['file_id']['tmp_name']);
                    if ($imageSize[0] <= 1359 || $imageSize[1] <= 679)
                    {
                        $this->Flash->error(__('Please upload image greater than 1360 (w) X 680 (h) dimension.'));
                        return $this->redirect([
                            'controller' => 'staticPages',
                            'action' => 'editslider',
                            base64_encode($id)
                        ]);
                    }

                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['Slider']['file_id'];
                    $destination = 'img/BannerImages/large/';
                    $destination2 = 'img/BannerImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '1600', 'jpg', '1600', '700');
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '400', 'jpg', '400', '180');

                    $files_data = $this->data['Slider']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/BannerImages/', $filename);
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->Slider->create();
                        $this->request->data['Slider']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Slider->save($this->request->data))
                        {
                            $this->Flash->success(__('The slide has been saved.'));
                            return $this->redirect([
                                'controller' => 'staticPages',
                                'action' => 'slider'
                            ]);
                        }
                        $this->Flash->error(__('The slider could not be saved. Please, try again.'));
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
        }

        $slider = $this->Slider->find('list');
        $this->set(compact('slider'));
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
    public function admin_editSlider($id = null)
    {
        $this->set('title_for_layout', 'Update Slider');
        $this->loadModel('Slider');
        $id = base64_decode($id);
        if (! $this->Slider->exists($id))
        {
            throw new NotFoundException(__('Invalid page'));
        }

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->data['Slider']['file_id']['name'])
            {
                $tmpName = $this->data['Slider']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }
                $exten = explode('.', $this->data['Slider']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $imageSize = getimagesize($this->data['Slider']['file_id']['tmp_name']);
                    if ($imageSize[0] <= 1359 || $imageSize[1] <= 679)
                    {
                        $this->Flash->error(__('Please upload image greater than 1360 (w) X 680 (h) dimension.'));
                        return $this->redirect([
                            'controller' => 'staticPages',
                            'action' => 'editslider',
                            base64_encode($id)
                        ]);
                    }

                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['Slider']['file_id'];
                    $destination = 'img/BannerImages/large/';
                    $destination2 = 'img/BannerImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '1600', 'jpg', '1600', '700');
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '400', 'jpg', '400', '180');

                    $files_data = $this->data['Slider']['file_id'];
                    $pushValue = [
                        'file_id' => $this->data['Slider']['update_file_id']
                    ];
                    $files_data = array_merge($files_data, $pushValue);
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/BannerImages/', $filename);
                    if ($upload_info['uploaded'] == 1)
                    {
                        // $this->Slider->create();
                        $this->request->data['Slider']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Slider->save($this->request->data))
                        {
                            $this->Flash->success(__('The slide has been saved.'));
                            return $this->redirect([
                                'controller' => 'staticPages',
                                'action' => 'slider'
                            ]);
                        }
                        $this->Flash->error(__('The slider could not be saved. Please, try again.'));
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
                unset($this->request->data['Slider']['file_id']);
                if ($this->Slider->save($this->request->data))
                {
                    $this->Flash->success(__('The slider has been saved.'));
                    return $this->redirect([
                        'controller' => 'staticPages',
                        'action' => 'slider'
                    ]);
                }
                $this->Flash->error(__('The page could not be saved. Please, try again.'));
            }
        }
        else
        {
            $options = [
                'conditions' => [
                    'Slider.' . $this->Slider->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Slider->find('first', $options);
        }

        $this->Slider->bindModel([
            'belongsTo' => [
                'File'
            ]
        ]);
        $slider = $this->Slider->find('first', [
            'conditions' => [
                'Slider.id' => $id
            ]
        ]);
        // pr($slider);
        $this->set(compact('slider'));
    }

    /**
     * admin_viewSlider method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_viewSlider($id = null)
    {
        $this->set('title_for_layout', 'View Slider');
        $this->loadModel('Slider');
        $id = base64_decode($id);
        if (! $this->Slider->exists($id))
        {
            throw new NotFoundException(__('Invalid slider'));
        }
        // $slider = $this->Slider->find('first',array('conditions'=>array('Slider.' . $this->Slider->primaryKey => $id)));
        // $this->set(compact('slider'));
        $this->Slider->bindModel([
            'belongsTo' => [
                'File'
            ]
        ]);
        $slider = $this->Slider->find('first', [
            'conditions' => [
                'Slider.id' => $id
            ]
        ]);
        // pr($slider);
        $this->set(compact('slider'));
    }

    /**
     * admin_sportSlider method
     *
     * @return void
     */
    public function admin_addSportSlider()
    {
        $this->set('title_for_layout', 'Add Slider');
        $this->loadModel('Slider');
        if ($this->request->is('post'))
        {
            if ($this->data['Slider']['file_id']['name'])
            {
                $tmpName = $this->data['Slider']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }
                $exten = explode('.', $this->data['Slider']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $imageSize = getimagesize($this->data['Slider']['file_id']['tmp_name']);
                    if ($imageSize[0] <= 1359 || $imageSize[1] <= 679)
                    {
                        $this->Flash->error(__('Please upload image greater than 1360 (w) X 680 (h) dimension.'));
                        return $this->redirect([
                            'controller' => 'staticPages',
                            'action' => 'editslider',
                            base64_encode($id)
                        ]);
                    }

                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['Slider']['file_id'];
                    $destination = 'img/BannerImages/large/';
                    $destination2 = 'img/BannerImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '1600', 'jpg', '1600', '700');
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '400', 'jpg', '400', '180');

                    $files_data = $this->data['Slider']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/BannerImages/', $filename);
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->Slider->create();
                        $this->request->data['Slider']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Slider->save($this->request->data))
                        {
                            $this->Flash->success(__('The slide has been saved.'));
                            return $this->redirect([
                                'controller' => 'staticPages',
                                'action' => 'slider'
                            ]);
                        }
                        $this->Flash->error(__('The slider could not be saved. Please, try again.'));
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
        }
        $this->loadModel('Sport');
        $sports = $this->Sport->find('list');
        $slider = $this->Slider->find('list');
        $this->set(compact('slider', 'sports'));
    }

    /**
     * admin_editSportSlider method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_editSportSlider($id = null)
    {
        $this->set('title_for_layout', 'Update Slider');
        $this->loadModel('Slider');
        $id = base64_decode($id);
        if (! $this->Slider->exists($id))
        {
            throw new NotFoundException(__('Invalid page'));
        }

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->data['Slider']['file_id']['name'])
            {
                $tmpName = $this->data['Slider']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }
                $exten = explode('.', $this->data['Slider']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $imageSize = getimagesize($this->data['Slider']['file_id']['tmp_name']);
                    if ($imageSize[0] <= 1359 || $imageSize[1] <= 679)
                    {
                        $this->Flash->error(__('Please upload image greater than 1360 (w) X 680 (h) dimension.'));
                        return $this->redirect([
                            'controller' => 'staticPages',
                            'action' => 'editslider',
                            base64_encode($id)
                        ]);
                    }
                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['Slider']['file_id'];
                    $destination = 'img/BannerImages/large/';
                    $destination2 = 'img/BannerImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '1600', 'jpg', '1600', '700');
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '400', 'jpg', '400', '180');

                    $files_data = $this->data['Slider']['file_id'];
                    $pushValue = [
                        'file_id' => $this->data['Slider']['update_file_id']
                    ];
                    $files_data = array_merge($files_data, $pushValue);
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/BannerImages/', $filename);
                    if ($upload_info['uploaded'] == 1)
                    {
                        // $this->Slider->create();
                        $this->request->data['Slider']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Slider->save($this->request->data))
                        {
                            $this->Flash->success(__('The slide has been saved.'));
                            return $this->redirect([
                                'controller' => 'staticPages',
                                'action' => 'slider'
                            ]);
                        }
                        $this->Flash->error(__('The slider could not be saved. Please, try again.'));
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
                unset($this->request->data['Slider']['file_id']);
                if ($this->Slider->save($this->request->data))
                {
                    $this->Flash->success(__('The slider has been saved.'));
                }
                else
                {
                    $this->Flash->error(__('The page could not be saved. Please, try again.'));
                }
                return $this->redirect([
                    'controller' => 'staticPages',
                    'action' => 'slider'
                ]);
            }
        }
        $options = [
            'conditions' => [
                'Slider.' . $this->Slider->primaryKey => $id
            ]
        ];
        $this->request->data = $this->Slider->find('first', $options);

        $this->Slider->bindModel([
            'belongsTo' => [
                'File'
            ]
        ]);
        $slider = $this->Slider->find('first', [
            'conditions' => [
                'Slider.id' => $id
            ]
        ]);
        $this->loadModel('Sport');
        $sports = $this->Sport->find('list');
        $this->set(compact('slider', 'sports'));
    }

    /**
     * View Banner Detail Page
     *
     * @param
     *            type id
     * @param null|mixed $id
     *
     * @throws NotFoundException
     */
    public function view($id = null)
    {
        $this->set('title_for_layout', __('View Details'));
        $this->loadModel('Slider');
        $id = base64_decode($id);
        if (! $this->Slider->exists($id))
        {
            throw new NotFoundException(__('Invalid banner'));
        }

        $bannerData = $this->Slider->find('first', [
            'conditions' => [
                'Slider.id' => $id
            ],
            'fields' => [
                'Slider.id',
                'Slider.file_id',
                'Slider.title',
                'Slider.content',
                'Slider.description'
            ]
        ]);

        $this->set(compact('bannerData'));
    }

    /**
     * View Leagues
     *
     * @param
     *            league id
     * @param null|mixed $id
     *
     * @throws NotFoundException
     */
    public function viewLeague($id = null)
    {
        $this->set('title_for_layout', __('View Leagues'));
        $this->loadModel('League');
        $this->loadModel('Sport');
        $id = base64_decode($id);
        if (! $this->Sport->exists($id))
        {
            throw new NotFoundException(__('Invalid Sport'));
        }
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

        $leagueData = $this->League->find('all', [
            'conditions' => [
                'League.sport_id' => $id,
                'League.status' => 1,
                'League.is_deleted' => 0,
                'League.end_date >=' => date('Y-m-d h:i:s')
            ],
            'fields' => [
                'League.name',
                'Sport.name'
            ],
            'order' => 'League.order_number ASC'
        ]);
        $this->set(compact('leagueData'));
    }
}
