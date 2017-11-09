<?php
ob_start();

class SectionListsController extends AppController
{
    public $name = 'SectionLists';

    public $components = [
        'Session'
    ];

    /* function to list sections */
    public function admin_index()
    {
        $this->set('title_for_layout', 'List sections');
        $this->SectionList->recursive = 0;
        $this->paginate = [
            'contain' => false,
            'order' => 'SectionList.id DESC',
            'limit' => LIMIT
        ];
        $this->set('SectionList', $this->Paginate('SectionList'));
    }

    /* function to view sections */
    public function admin_view($id = null)
    {
        $this->set('title_for_layout', 'View section');
        $id = base64_decode($id);
        if (! $this->SectionList->exists($id))
        {
            throw new NotFoundException(__('Invalid Section List'));
        }
        $options = [
            'conditions' => [
                'SectionList.' . $this->SectionList->primaryKey => $id
            ]
        ];
        $this->set('SectionList', $this->SectionList->find('first', $options));
    }

    /* function to add sections */
    public function admin_add()
    {
        $this->set('title_for_layout', 'Add section');
        $acos = $this->listControllers();
        $flag = 0;
        $this->SectionList->query('Truncate `section_lists`;');
        foreach ($acos as $aco)
        {
            $this->SectionList->create();
            if ($this->SectionList->save($aco))
            {
                ++ $flag;
            }
        }
        $this->Session->setFlash($flag . " ACO's out of " . count($acos) . ' SAVED SUCCESSFULLY');
        $this->redirect('/admin/sectionLists/');
    }

    /* function to edit SectionList */
    public function admin_edit($id = null)
    {
        $this->set('title_for_layout', 'Update section');
        $id = base64_decode($id);
        if (! $this->SectionList->exists($id))
        {
            throw new NotFoundException(__('Invalid SectionList'));
        }
        if ($this->request->is('post') || $this->request->is('put'))
        {
            if ($this->SectionList->save($this->request->data))
            {
                $this->Session->setFlash(__('The SectionList has been saved'));
                $this->redirect([
                    'action' => 'admin_index'
                ]);
            }
            else
            {
                $this->Session->setFlash(__('The SectionList could not be saved. Please, try again.'));
            }
        }
        else
        {
            $options = [
                'conditions' => [
                    'SectionList.id' => $id
                ]
            ];
            $this->set('data', $this->SectionList->find('first', $options));
        }
    }

    /* function to delete SectionList */
    public function admin_remove($id = null)
    {
        $this->set('title_for_layout', 'Remove section');
        $id = base64_decode($id);
        $this->SectionList->id = $id;

        if (! $this->SectionList->exists())
        {
            throw new NotFoundException(__('Invalid SectionList'));
        }
        $this->request->onlyAllow('get', 'delete');
        if ($this->SectionList->delete())
        {
            $this->Session->setFlash(__('SectionList deleted'));
            $this->redirect([
                'action' => 'index'
            ]);
        }
        $this->Session->setFlash(__('SectionList was not deleted'));
        $this->redirect([
            'action' => 'index'
        ]);
    }

    public function listControllers()
    {
        $this->set('title_for_layout', 'Control Listing');
        ini_set('allow_url_fopen', 1);
        $accesslists = [];
        $path = App::path('Controller');
        $notWanted = [
            'AppController.php',
            'SectionListsController.php',
            'RolesController.php',
            'PagesController.php',
            'AdminsController.php'
        ];
        if ($handle = opendir($path[0]))
        {
            while (false !== ($entry = readdir($handle)))
            {
                if ($entry != '.' && $entry != '..' && (! in_array($entry, $notWanted)))
                {
                    if (! is_dir($path[0] . $entry))
                    {
                        require_once $path[0] . $entry;
                        $entry2 = explode('.php', $entry);
                        $entry2 = $entry2[0];
                        $entry3 = explode('Controller.php', $entry);
                        $entry3 = $entry3[0];
                        $result = array_diff(get_class_methods($entry2), get_class_methods(get_parent_class($entry2)));
                        // $accesslists[]['SectionList']=array('filename' => $entry,'classname'=>$entry2, 'controller'=>lcfirst($entry3), 'methods'=>$result);
                        /* --------- */
                        foreach ($result as $r)
                        {
                            $accesslists[]['SectionList'] = [
                                'name' => $r . ' for ' . $entry3,
                                'controller' => lcfirst($entry3),
                                'action' => $r
                            ];
                        }
                        /* --------- */
                    }
                }
            }
            closedir($handle);
        }
        return $accesslists;
        $this->autoRender = false;
    }
}