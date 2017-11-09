<?php
App::uses('AppController', 'Controller');

/**
 * Leagues Controller
 *
 * @property League $League
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class EditorsController extends AppController
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
        'News'
    ];

    /**
     * _before filter method
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->View = new View($this, false);
        $this->Auth->allow('checkMimeType');
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
        array_push($conditions, [
            'News.user_id' => AuthComponent::user('id')
        ]);
        $this->paginate = [
            'contain' => false,
            'limit' => LIMIT,
            'conditions' => $conditions,
            'order' => $order
        ];
        $this->set('news', $this->paginate('News'));
        $status = [
            'Active',
            'Inactive'
        ];
        $sports = $this->Sport->find('list');
        $this->set(compact('status', 'sports'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function editor_index()
    {
        $this->set('title_for_layout', __('List News'));
        $conditions = [];
        $conditions = $this->_getSearchConditions();

        $this->index($conditions, 'News.top_news DESC');
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function sports_add()
    {
        if ($this->request->is('post'))
        {
            $alreadyAssigned = false;
            $alreadyAssigned = $this->UserTeam->find('first', [
                'conditions' => [
                    'UserTeam.user_id' => $this->data['UserTeam']['user_id'],
                    'UserTeam.league_id' => $this->data['UserTeam']['league_id']
                ]
            ]);
            if ($alreadyAssigned)
            {
                $this->Flash->error(__('The user cannot be assigned in the same league again.'));
                return $this->redirect($this->here);
            }

            $this->UserTeam->create();
            if ($this->UserTeam->save($this->request->data))
            {
                $this->Flash->success(__('The user team has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }

            $this->Flash->error(__('The user team could not be saved. Please, try again.'));
        }
        $userSportId = AuthComponent::user('SportInfo.Sport.id');
        $users = $this->User->find('list', [
            'conditions' => [
                'User.role_id' => 6
            ]
        ]);
        $sports = $userSportId;
        /*
         * $tournaments = array(); //$this->UserTeam->Tournament->find('list');
         * $sports = $this->UserTeam->Sport->find('list');
         * $leagues = array(); //$this->UserTeam->League->find('list');
         * $teams = array(); //$this->UserTeam->Team->find('list');
         */
        $this->set(compact('users', 'tournaments', 'sports', 'leagues', 'teams'));
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
        $this->loadModel('UserTeam');
        $this->UserTeam->unbindModel([
            'belongsTo' => [
                'Tournament',
                'Sport',
                'League',
                'Team'
            ]
        ]);
        $teamDetail = $this->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.user_id' => AuthComponent::User('id'),
                'UserTeam.status' => 1
            ]
        ]);
        $wallId = $this->Wall->find('first', [
            'conditions' => [
                'Wall.tournament_id' => $teamDetail['UserTeam']['tournament_id'],
                'Wall.sport_id' => $teamDetail['UserTeam']['sport_id'],
                'Wall.locale_id' => $teamDetail['User']['locale_id'],
                'Wall.league_id' => $teamDetail['UserTeam']['league_id'],
                'Wall.team_id' => $teamDetail['UserTeam']['team_id'],
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
            return $wallId['Wall']['id'];
        }
        $this->request->data['Wall']['league_id'] = $teamDetail['UserTeam']['league_id'];
        $this->request->data['Wall']['tournament_id'] = $teamDetail['UserTeam']['tournament_id'];
        $this->request->data['Wall']['team_id'] = $teamDetail['UserTeam']['team_id'];
        $this->request->data['Wall']['sport_id'] = $teamDetail['UserTeam']['sport_id'];
        $this->request->data['Wall']['locale_id'] = $teamDetail['User']['locale_id'];
        $this->request->data['Wall']['name'] = 'Wall';
        if ($this->Wall->save($this->request->data))
        {
            return $this->Wall->getLastInsertID();
        }
        $this->Flash->error(__('Not able to save record. Please, try again.'));
        return $this->redirect([
            'controller' => 'bloggers',
            'action' => 'share_video',
            'blogger' => true
        ]);
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
     * editor_view method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_view($id = null)
    {
        $this->set('title_for_layout', __('View News'));
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
     * editor_add method
     *
     * @return void
     */
    public function editor_add()
    {
        $this->set('title_for_layout', __('Add News'));
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
                            'controller' => 'editors',
                            'action' => 'add',
                            'editor' => true
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

        $sports = $this->Sport->find('list');
        $this->set(compact('sports'));
    }

    /**
     * editor_edit method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_edit($id = null)
    {
        $this->set('title_for_layout', __('Update News'));
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
                        'controller' => 'editors',
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
                        if ($this->News->save($this->request->data))
                        {
                            $this->Flash->success(__('News has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('News could not be saved. Please, try again.'));
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
                $this->Flash->error(__('News could not be saved. Please, try again.'));
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
        $sports = $this->Sport->find('list');
        $this->set(compact('sports', 'files'));
    }

    /**
     * editor_delete method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_delete($id = null)
    {
        $this->set('title_for_layout', __('Delete News'));
        $this->News->id = base64_decode($id);
        if (! $this->News->exists())
        {
            throw new NotFoundException(__('Invalid news'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->News->delete())
        {
            $this->Flash->success(__('News has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('News could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * editor_changeToTopNews method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function editor_changeToTopNews()
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
                echo __('saved');
            }
            else
            {
                echo __('error');
            }
        }
    }

    /*
     * function checkMimeType check mime type of image upload
     * Created By: Shambhu
     * Date: 18-05-2016
     * Company: SmartData
     */
    public function checkMimeType($tmpName = null)
    {
        $this->autoRender = false;
        $tmpName = $_FILES['file_id']['tmp_name'];
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