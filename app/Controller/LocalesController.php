<?php
App::uses('AppController', 'Controller');

/**
 * Locales Controller
 *
 * @property Locale $Locale
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class LocalesController extends AppController
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
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->Locale->recursive = 0;
        $this->set('locales', $this->Paginator->paginate());
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
        if (! $this->Locale->exists($id))
        {
            throw new NotFoundException(__('Invalid locale'));
        }
        $options = [
            'conditions' => [
                'Locale.' . $this->Locale->primaryKey => $id
            ]
        ];
        $this->set('locale', $this->Locale->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        if ($this->request->is('post'))
        {
            $this->Locale->create();
            if ($this->Locale->save($this->request->data))
            {
                $this->Flash->success(__('The locale has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The locale could not be saved. Please, try again.'));
        }
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
        if (! $this->Locale->exists($id))
        {
            throw new NotFoundException(__('Invalid locale'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->Locale->save($this->request->data))
            {
                $this->Flash->success(__('The locale has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The locale could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'Locale.' . $this->Locale->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Locale->find('first', $options);
        }
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
        $this->Locale->id = $id;
        if (! $this->Locale->exists())
        {
            throw new NotFoundException(__('Invalid locale'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Locale->delete())
        {
            $this->Flash->success(__('The locale has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The locale could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }
}
