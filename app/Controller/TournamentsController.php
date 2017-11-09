<?php
App::uses('AppController', 'Controller');

/**
 * Tournaments Controller
 *
 * @property Tournament $Tournament
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class TournamentsController extends AppController
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
        'File'
    ];

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
        $this->Tournament->recursive = 0;
        $this->paginate = [
            'contain' => false,
            'limit' => LIMIT,
            'conditions' => $conditions,
            'order' => $order
        ];
        $this->set('tournaments', $this->paginate('Tournament'));

        $tournamentConditions = false;

        $sports = $this->Tournament->Sport->find('list');
        /*
         * if(AuthComponent::user("role_id") == 2){
         * $tournamentConditions = array("Sport.id"=>AuthComponent::user("SportInfo.Sport.id"));
         * $sports = $this->Tournament->Sport->find('list', array("conditions"=>$tournamentConditions));
         * }
         * if(AuthComponent::user("role_id") == 4){
         * $tournamentConditions = array("Sport.id"=>AuthComponent::user("SportInfo.League.sport_id"));
         * $sports = $this->Tournament->Sport->find('list', array("conditions"=>$tournamentConditions));
         * }
         */
        $this->set(compact('tournaments', 'sports'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'List Tournament');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, [
            'FIELD(Tournament.created,Tournament.status) DESC'
        ]);
    }

    public function _getSearchConditions()
    {
        $input = $_GET;
        $model = 'Tournament';

        $items = [];
        $conditions = [
            'Tournament.is_deleted' => 0,
            'Tournament.status' => [
                0,
                1
            ]
        ];

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
                'League' => $input
            ];
        }

        if (AuthComponent::user('role_id') == 2)
        {
            $conditions[$model . '.' . 'sport_id'] = AuthComponent::user('SportInfo.Sport.id');
        }
        if (AuthComponent::user('role_id') == 3)
        {
            $conditions[$model . '.' . 'sport_id'] = AuthComponent::user('SportInfo.League.sport_id');
        }
        // $conditions[$model.'.'.'status'] = 1;
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
        $this->set('title_for_layout', 'View Tournament');
        $id = base64_decode($id);
        if (! $this->Tournament->exists($id))
        {
            throw new NotFoundException(__('Invalid tournament'));
        }
        $options = [
            'conditions' => [
                'Tournament.' . $this->Tournament->primaryKey => $id
            ]
        ];
        $this->set('tournament', $this->Tournament->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', 'Add Tournament');
        if ($this->request->is('post'))
        {
            if ($this->data['Tournament']['file_id']['name'])
            {
                $tmpName = $this->data['Tournament']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }
                $exten = explode('.', $this->data['Tournament']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $files_data = $this->data['Tournament']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/TournamentImages/');
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->Tournament->create();
                        $this->request->data['Tournament']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Tournament->save($this->request->data))
                        {
                            $this->Flash->success(__('The tournament has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The tournament could not be saved. Please, try again.'));
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
                $this->Tournament->create();
                if ($this->Tournament->save($this->request->data))
                {
                    $this->Flash->success(__('The tournament has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The tournament could not be saved. Please, try again.'));
            }
        }
        $sports = $this->Tournament->Sport->find('list', [
            'order' => 'Sport.name'
        ]);
        $this->set(compact('sports'));
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
        $this->set('title_for_layout', 'Update Tournament');
        $id = base64_decode($id);
        if (! $this->Tournament->exists($id))
        {
            throw new NotFoundException(__('Invalid tournament'));
        }

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->data['Tournament']['file_id']['name'])
            {
                $tmpName = $this->data['Tournament']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }
                $exten = explode('.', $this->data['Tournament']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $files_data = $this->data['Tournament']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/TournamentImages/');
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->Tournament->create();
                        $this->request->data['Tournament']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Tournament->save($this->request->data))
                        {
                            $this->Flash->success(__('The tournament has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The tournament could not be saved. Please, try again.'));
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
                unset($this->request->data['Tournament']['file_id']);

                if ($this->Tournament->save($this->request->data))
                {
                    $this->Flash->success(__('The tournament has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The tournament could not be saved. Please, try again.'));
            }
        }
        else
        {
            $options = [
                'conditions' => [
                    'Tournament.' . $this->Tournament->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Tournament->find('first', $options);
        }

        /* start */
        $sportId = $this->Tournament->find('first', [
            'conditions' => [
                'Tournament.id' => $id
            ],
            'fields' => [
                'Tournament.sport_id'
            ]
        ]);
        $sports = $this->Sport->find('list', [
            'conditions' => [
                'Sport.id' => $sportId['Tournament']['sport_id']
            ]
        ]);
        // $sports = $this->Tournament->Sport->find('list');
        /* end */

        $this->set(compact('sports'));
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
        $this->set('title_for_layout', 'Delete Tournament');
        $this->Tournament->id = base64_decode($id);
        if (! $this->Tournament->exists())
        {
            throw new NotFoundException(__('Invalid tournament'));
        }
        $this->_deleteTournament($this->Tournament->id);
    }

    /**
     * _deleteTournament method
     *
     * @param string     $id
     * @param null|mixed $ournamentId
     *
     * @return void
     */
    public function _deleteTournament($ournamentId = null)
    {
        $this->loadModel('Game');
        $status = $this->Game->find('count', [
            'conditions' => [
                'Game.tournament_id' => $this->Tournament->id,
                'OR' => [
                    'Game.status' => 1,
                    'Game.end_time >' => date('Y-m-d h:i:s')
                ]
            ]
        ]);
        if ($status)
        {
            $this->Flash->error(__('You can not delete active tournament. Some game still has to play.'));
        }
        else
        {
            $this->Tournament->saveField('is_deleted', 1);
            $this->Tournament->saveField('deleted_by', AuthComponent::User('id'));
            $name = $this->Tournament->find('first', [
                'conditions' => [
                    'Tournament.id' => $this->Tournament->id
                ],
                'fields' => [
                    'Tournament.name'
                ]
            ]);
            $this->request->data['Tournament']['name'] = $name['Tournament']['name'] . '-is-deleted';
            if ($this->Tournament->saveField('name', $this->request->data['Tournament']['name']) && $this->Tournament->saveField('status', 0))
                $this->Flash->success(__('The Tournament has been deleted.'));
            else
                $this->Flash->error(__('The Tournament could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * sports_index method
     *
     * @return void
     */
    public function sports_index()
    {
        $this->set('title_for_layout', 'List Tournaments');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'Tournament.created DESC');
    }

    /**
     * sports_add method
     *
     * @return void
     */
    public function sports_add()
    {
        $this->set('title_for_layout', 'Add Tournament');
        if ($this->request->is('post'))
        {

            /*
             * if($this->data["Tournament"]["file_id"]["name"]){
             *
             * $exten = explode('.',$this->data["Tournament"]["file_id"]["name"]);
             * if($exten[1]=="GIF" || $exten[1]=="gif" || $exten[1]=="jpg" || $exten[1]=="jpeg" || $exten[1]=="PNG"|| $exten[1]=="png" || $exten[1]=="JPG" || $exten[1]=="JPEG"){
             *
             * $files_data = $this->data["Tournament"]["file_id"];
             * $upload_info = $this->File->upload($files_data, WWW_ROOT."img/TournamentImages/");
             * if($upload_info['uploaded']==1){
             * $this->Tournament->create();
             * $this->request->data['Tournament']['sport_id'] = AuthComponent::user("SportInfo.Sport.id");
             * $this->request->data['Tournament']['file_id'] = $upload_info['db_info']['Upload']['id'];
             * if ($this->Tournament->save($this->request->data)) {
             * $this->Flash->success(__('The tournament has been saved.'));
             * return $this->redirect(array('action' => 'index'));
             * } else {
             * $this->Flash->error(__('The tournament could not be saved. Please, try again.'));
             * }
             * }
             * else{
             * $this->Flash->error(__('Unable to upload Image and save record. Please, try again.'));
             * }
             * }
             * else{
             * $this->Flash->error(__('Please select a valid image format.'));
             * }
             * }
             * else{
             */

            $this->Tournament->create();
            $this->request->data['Tournament']['sport_id'] = AuthComponent::user('SportInfo.Sport.id');
            if ($this->Tournament->save($this->request->data))
            {
                $this->Flash->success(__('The tournament has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The tournament could not be saved. Please, try again.'));

            // }
        }
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
        $this->set('title_for_layout', 'Update Tournament');
        $id = base64_decode($id);
        if (! $this->Tournament->exists($id))
        {
            throw new NotFoundException(__('Invalid tournament'));
        }

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->data['Tournament']['file_id']['name'])
            {

                $exten = explode('.', $this->data['Tournament']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $files_data = $this->data['Tournament']['file_id'];
                    $pushValue = [
                        'file_id' => $this->data['Tournament']['update_file_id']
                    ];
                    $files_data = array_merge($files_data, $pushValue);
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/TournamentImages/');
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->Tournament->create();
                        $this->request->data['Tournament']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Tournament->save($this->request->data))
                        {
                            $this->Flash->success(__('The tournament has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The tournament could not be saved. Please, try again.'));
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
                unset($this->request->data['Tournament']['file_id']);

                if ($this->Tournament->save($this->request->data))
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
                    'Tournament.' . $this->Tournament->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Tournament->find('first', $options);
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
        $this->set('title_for_layout', 'View Tournament');
        $id = base64_decode($id);
        if (! $this->Tournament->exists($id))
        {
            throw new NotFoundException(__('Invalid tournament'));
        }
        $options = [
            'conditions' => [
                'Tournament.' . $this->Tournament->primaryKey => $id
            ]
        ];
        $this->set('tournament', $this->Tournament->find('first', $options));
    }

    /**
     * sports_delete method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function sports_delete($id = null)
    {
        $this->set('title_for_layout', 'Delete Tournament');
        $this->Tournament->id = base64_decode($id);
        if (! $this->Tournament->exists())
        {
            throw new NotFoundException(__('Invalid tournament'));
        }
        $this->_deleteTournament($this->Tournament->id);
    }

    /**
     * league method
     *
     * @return void
     */
    public function league_add()
    {
        $this->set('title_for_layout', 'Add Tournament');
        if ($this->request->is('post'))
        {

            if ($this->data['Tournament']['file_id']['name'])
            {

                $exten = explode('.', $this->data['Tournament']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $files_data = $this->data['Tournament']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/TournamentImages/');
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->Tournament->create();
                        $this->request->data['Tournament']['sport_id'] = AuthComponent::user('SportInfo.League.id');
                        $this->request->data['Tournament']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Tournament->save($this->request->data))
                        {
                            $this->Flash->success(__('The tournament has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The tournament could not be saved. Please, try again.'));
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
                $this->Tournament->create();
                $this->request->data['Tournament']['sport_id'] = AuthComponent::user('SportInfo.League.id');
                if ($this->Tournament->save($this->request->data))
                {
                    $this->Flash->success(__('The tournament has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The tournament could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * league_edit method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function league_edit($id = null)
    {
        $this->set('title_for_layout', 'Update Tournament');
        $id = base64_decode($id);
        if (! $this->Tournament->exists($id))
        {
            throw new NotFoundException(__('Invalid tournament'));
        }

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->data['Tournament']['file_id']['name'])
            {

                $exten = explode('.', $this->data['Tournament']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $files_data = $this->data['Tournament']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/TournamentImages/');
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->Tournament->create();
                        $this->request->data['Tournament']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Tournament->save($this->request->data))
                        {
                            $this->Flash->success(__('The tournament has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The tournament could not be saved. Please, try again.'));
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
                unset($this->request->data['Tournament']['file_id']);

                if ($this->Tournament->save($this->request->data))
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
                    'Tournament.' . $this->Tournament->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Tournament->find('first', $options);
        }
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
        $this->set('title_for_layout', 'View Tournament');
        $id = base64_decode($id);
        if (! $this->Tournament->exists($id))
        {
            throw new NotFoundException(__('Invalid tournament'));
        }
        $options = [
            'conditions' => [
                'Tournament.' . $this->Tournament->primaryKey => $id
            ]
        ];
        $this->set('tournament', $this->Tournament->find('first', $options));
    }

    /**
     * league_index method
     *
     * @return void
     */
    public function league_index()
    {
        $this->set('title_for_layout', 'List Tournaments');
        // $this->Tournament->recursive = 0;
        // $this->set('tournaments', $this->Paginator->paginate());
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'Tournament.created DESC');
    }
}
