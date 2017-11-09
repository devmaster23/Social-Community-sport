<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Translations Controller
 *
 * @property Translations $Translations
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class TranslationsController extends AppController
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

    public $helpers = [
        'Html',
        'Text'
    ];

    public $uses = null;

    /*
     *
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    /**
     * index method
     *
     * @param mixed      $model
     * @param mixed      $conditions
     * @param null|mixed $order
     * @param null|mixed $limit
     *
     * @return void
     */
    public function index($model, $conditions = [], $order = null, $limit = null)
    {
        $this->$model->recursive = 0;
        if ($limit == '')
        {
            $limit = LIMIT;
        }
        $this->paginate = [
            'contain' => false,
            'limit' => $limit,
            'conditions' => $conditions,
            'order' => $order
        ];
        // $this->paginate = array('contain' => false, 'limit' => LIMIT, 'conditions' => $conditions, 'order' => $order);
        $this->set('trans', $this->paginate($model));
    }

    /**
     * admin_index method
     *
     * @param null|mixed $model
     * @param null|mixed $id
     *
     * @return void
     */
    public function admin_index($model = null, $id = null)
    {
        // configure::write("debug",2);
        $this->set('title_for_layout', 'List Translations');
        // $model = "HiTranslation";
        $this->set('model', $model);
        $this->loadModel($model);

        $conditions = [];
        $conditions = $this->_getSearchConditions($model);
        $this->index($model, $conditions, $model . '.id DESC', 100);

        if (! empty($id))
        {
            if ($id == 'add')
            {
                if ($this->request->is([
                    'post',
                    'put'
                ]))
                {
                    // pr($this->request->data);die;
                    if ($this->$model->save($this->request->data))
                    {
                        $this->Flash->success(__('The translations has been saved.'));
                        return $this->redirect([
                            'action' => 'index',
                            $model
                        ]);
                    }
                    $this->Flash->error(__('The translations could not be saved. Please, try again.'));
                }
            }
            else
            {
                $id = base64_decode($id);
                if (! $this->$model->exists($id))
                {
                    throw new NotFoundException(__('Invalid translations'));
                }

                if ($this->request->is([
                    'post',
                    'put'
                ]))
                {
                    // pr($this->request->data);die;
                    if ($this->$model->save($this->request->data))
                    {
                        $this->Flash->success(__('The translations has been saved.'));
                        return $this->redirect([
                            'action' => 'index',
                            $model
                        ]);
                    }
                    $this->Flash->error(__('The translations could not be saved. Please, try again.'));
                }
                else
                {
                    $options = [
                        'conditions' => [
                            $model . '.' . $this->$model->primaryKey => $id
                        ]
                    ];
                    $this->request->data = $this->$model->find('first', $options);
                }
            }
        }
    }

    public function _getSearchConditions($model = null)
    {
        $input = $_GET;
        // $model = 'Translation';

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
                    if ($k == 'text' || $k == 'translation')
                    {
                        $v = '%' . trim($v) . '%';
                        $conditions['OR'][$model . '.' . $k . ' LIKE'] = $v;
                    }
                    else
                    {
                        $conditions[$model . '.' . $k] = $v;
                    }
                }
            }
            $this->data = [
                $model => $input
            ];
        }

        return $conditions;
    }

    /**
     * admin_view method
     *
     * @param string     $id
     * @param null|mixed $model
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_view($model = null, $id = null)
    {
        $this->set('title_for_layout', 'View Translations');
        $id = base64_decode($id);
        // $model = "HiTranslation";
        $this->set('model', $model);
        $this->loadModel($model);

        if (! $this->$model->exists($id))
        {
            throw new NotFoundException(__('Invalid translations'));
        }
        $options = [
            'conditions' => [
                $model . '.' . $this->$model->primaryKey => $id
            ]
        ];
        $this->set('trans', $this->$model->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @param null|mixed $model
     *
     * @return void
     */
    public function admin_add($model = null)
    {
        $this->set('title_for_layout', 'Add Translations');
        // $model = "HiTranslation";
        $this->set('model', $model);
        $this->loadModel($model);
        if ($this->request->is('post'))
        {
            // pr($this->request->data);die;
            if ($this->$model->save($this->request->data))
            {
                $this->Flash->success(__('The translations has been saved.'));
                return $this->redirect([
                    'action' => 'index',
                    $model
                ]);
            }
            $this->Flash->error(__('The translations could not be saved. Please, try again.'));
        }
    }

    /**
     * admin_edit method
     *
     * @param null|mixed $model
     * @param null|mixed $id
     *
     * @return void
     */
    public function admin_edit($model = null, $id = null)
    {
        $this->set('title_for_layout', 'Edit Translations');
        $id = base64_decode($id);
        // $model = "HiTranslation";
        $this->set('model', $model);
        $this->loadModel($model);

        if (! $this->$model->exists($id))
        {
            throw new NotFoundException(__('Invalid translations'));
        }

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            // pr($this->request->data);die;
            if ($this->$model->save($this->request->data))
            {
                $this->Flash->success(__('The translations has been saved.'));
                return $this->redirect([
                    'action' => 'index',
                    $model
                ]);
            }
            $this->Flash->error(__('The translations could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    $model . '.' . $this->$model->primaryKey => $id
                ]
            ];
            $this->request->data = $this->$model->find('first', $options);
        }
    }

    /**
     * admin_delete method
     *
     * @param string     $id
     * @param null|mixed $model
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_delete($model = null, $id = null)
    {
        $this->set('title_for_layout', 'Delete Translations');
        $this->loadModel($model);
        $this->$model->id = base64_decode($id);
        if (! $this->$model->exists())
        {
            throw new NotFoundException(__('Invalid translations'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->$model->delete())
        {
            $this->Flash->success(__('The translations has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The translations could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index',
            $model
        ]);
    }
}