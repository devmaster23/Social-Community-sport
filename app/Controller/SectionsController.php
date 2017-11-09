<?php

class SectionsController extends AppController
{
    public $name = 'Sections';

    /* function to manage permissions by admin */
    public function admin_managePermissions($rid = null)
    {
        $this->set('title_for_layout', 'Manage Permission');
        if (! empty($this->request->data))
        {
            $tmp = $this->request->data;
            foreach ($tmp['Section']['section_list_id'] as $sl)
            {
                $tmp2[] = [
                    'Section' => [
                        'role_id' => $tmp['Section']['role_id'],
                        'section_list_id' => $sl
                    ]
                ];
            }
            foreach ($tmp2 as $t)
            {
                $this->Section->create();
                $this->Section->save($t);
            }
            $this->Session->setFlash('Section Denied to users of selected Roles');
            $this->redirect('/admin/sections/allowAccess/' . $rid);
        }
        // ELSE
        $this->loadModel('Role');
        $roles = $this->Role->find('list', [
            'fields' => [
                'id',
                'name'
            ],
            'conditions' => [
                'AND' => [
                    'Role.id' => base64_decode($rid),
                    'NOT' => [
                        'Role.id' => 1
                    ]
                ]
            ]
        ]);
        if (empty($rid))
        {
            echo 'Bad Request.';
            die();
        }
        if (empty($roles))
        {
            echo 'Bad Request';
            die();
        }
        $data = $this->Section->find('all', [
            'fields' => [
                'section_list_id'
            ],
            'conditions' => [
                'Section.role_id' => base64_decode($rid)
            ]
        ]);
        if (! empty($data))
        {
            foreach ($data as $d)
            {
                if (empty($str))
                {
                    $str = $d['Section']['section_list_id'];
                }
                else
                {
                    $str .= ',' . $d['Section']['section_list_id'];
                }
            }
        }
        else
        {
            $str = 0;
        }
        $this->loadModel('SectionList');
        $this->SectionList->unbindModel([
            'hasMany' => [
                'Section'
            ]
        ]);
        $this->paginate = [
            'contain' => false,
            'order' => 'SectionList.id ASC',
            'limit' => LIMIT,
            'conditions' => [
                ' SectionList.id NOT IN (' . $str . ')'
            ]
        ];
        $Section = $this->Paginate('SectionList');
        // pr($Section);
        $this->set(compact('Section'));

        $this->set('roles', $roles);
    }

    /* function to allow permissions by admin */
    public function admin_allowAccess($rid = null)
    {
        $this->set('title_for_layout', 'Access Permission');
        if (! empty($this->request->data))
        {
            $tmp = $this->request->data;
            // pr($tmp);
            foreach ($tmp['Section']['section_list_id'] as $t)
            {

                $id = $t;
                $this->Section->id = $id;

                if (! $this->Section->exists())
                {
                    throw new NotFoundException(__('Invalid Access Token'));
                }
                $this->request->onlyAllow('post', 'delete');
                if ($this->Section->delete())
                {
                    $f = 1;
                }
            }
            if ($f == 1)
            {
                $this->Session->setFlash(__('Access Granted'));
                $this->redirect([
                    'action' => 'managePermissions/' . base64_encode($tmp['Section']['role_id'])
                ]);
            }
            else
            {
                $this->Session->setFlash(__('Access Denied'));
            }
        }
        // ELSE
        $this->loadModel('Role');
        $roles = $this->Role->find('list', [
            'fields' => [
                'id',
                'name'
            ],
            'conditions' => [
                'AND' => [
                    'Role.id' => base64_decode($rid),
                    'NOT' => [
                        'Role.id' => 1
                    ]
                ]
            ]
        ]);
        if (empty($rid))
        {
            echo 'Bad Request';
            die();
        }
        if (empty($roles))
        {
            echo 'Bad Request';
            die();
        }
        $this->paginate = [
            'contain' => false,
            'order' => 'Section.id ASC',
            'limit' => LIMIT,
            'conditions' => [
                ' Section.role_id' => base64_decode($rid)
            ]
        ];
        $Section = $this->Paginate('Section');
        // pr($Section);
        $this->set(compact('Section'));

        $this->set('roles', $roles);
    }

    /* function to manage roles & permissions by admin */
    public function admin_manageRolesAndPermissions()
    {
        $this->set('title_for_layout', 'Manage Role Permission');
        if (empty($this->request->data))
        {
            $this->loadModel('Role');
            $this->Role->unbindModel([
                'hasMany' => [
                    'Subrole'
                ]
            ]);
            $this->request->data = $this->Role->find('list', [
                'fields' => [
                    'id',
                    'name'
                ],
                'conditions' => [
                    'NOT' => [
                        'Role.id' => 1
                    ]
                ]
            ]);
            foreach ($this->request->data as $k => $v)
            {
                $arr[base64_encode($k)] = $v;
            }
            $this->request->data = $arr;
        }
        else
        {
            if (isset($this->request->data['allow']))
            {
                $url = Router::url([
                    'action' => 'admin_allowAccess/' . $this->request->data['Role']['id'],
                    'controller' => 'sections'
                ]);
            }
            else
            {
                $url = Router::url([
                    'action' => 'admin_managePermissions/' . $this->request->data['Role']['id'],
                    'controller' => 'sections'
                ]);
            }
            $this->redirect($url);
        }
    }
}