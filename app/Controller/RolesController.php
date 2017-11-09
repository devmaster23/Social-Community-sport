<?php
App::uses('AppController', 'Controller');

/**
 * Roles Controller
 *
 * @property Role $Role
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class RolesController extends AppController
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
        $this->set('title_for_layout', 'List Roles');
        $this->Role->recursive = 0;
        $this->set('roles', $this->Paginator->paginate());
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
        $this->set('title_for_layout', 'View Role');
        if (! $this->Role->exists($id))
        {
            throw new NotFoundException(__('Invalid role'));
        }
        $options = [
            'conditions' => [
                'Role.' . $this->Role->primaryKey => $id
            ]
        ];
        $this->set('role', $this->Role->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', 'Add Role');
        if ($this->request->is('post'))
        {
            $this->Role->create();
            if ($this->Role->save($this->request->data))
            {
                $this->Flash->success(__('The role has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
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
        $this->set('title_for_layout', 'Edit Role');
        if (! $this->Role->exists($id))
        {
            throw new NotFoundException(__('Invalid role'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->Role->save($this->request->data))
            {
                $this->Flash->success(__('The role has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'Role.' . $this->Role->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Role->find('first', $options);
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
        $this->set('title_for_layout', 'Delete Role');
        $this->Role->id = $id;
        if (! $this->Role->exists())
        {
            throw new NotFoundException(__('Invalid role'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Role->delete())
        {
            $this->Flash->success(__('The role has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The role could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }
}
