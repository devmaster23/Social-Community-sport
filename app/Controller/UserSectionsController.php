<?php

class UserSectionsController extends AppController
{
    public $name = 'UserSections';

    /* function to manage permissions by admin */
    public function admin_managePermissions($uid = null)
    {
        $this->set('title_for_layout', 'Manage Permission');

        if (! empty($this->request->data))
        {
            $tmp = $this->request->data;

            if ($tmp['Section']['section_list_id'])
            {
                foreach ($tmp['Section']['section_list_id'] as $sl)
                {
                    $tmp2[] = [
                        'UserSection' => [
                            'user_id' => $tmp['Section']['user_id'],
                            'section_list_id' => $sl
                        ]
                    ];
                }

                foreach ($tmp2 as $t)
                {
                    $this->UserSection->create();
                    $this->UserSection->save($t);
                }
                $this->Session->setFlash('Section Denied to users of selected Roles');
                $this->redirect('/admin/userSections/allowAccess/' . $uid);
            }
            else
            {
                $this->Session->setFlash('Please select function name first.');
                $this->redirect('/admin/userSections/managePermissions/' . $uid);
            }
        }
        // ELSE
        $this->loadModel('User');
        $roles = $this->User->find('list', [
            'fields' => [
                'id',
                'name'
            ],
            'conditions' => [
                'AND' => [
                    'User.id' => base64_decode($uid),
                    'NOT' => [
                        'User.role_id' => 1
                    ]
                ]
            ]
        ]);
        if (empty($uid))
        {
            echo 'Bad Request.';
            die();
        }
        if (empty($roles))
        {
            echo 'Bad Request';
            die();
        }
        $data = $this->UserSection->find('all', [
            'fields' => [
                'section_list_id'
            ],
            'conditions' => [
                'UserSection.user_id' => base64_decode($uid)
            ]
        ]);
        if (! empty($data))
        {
            foreach ($data as $d)
            {
                if (empty($str))
                {
                    $str = $d['UserSection']['section_list_id'];
                }
                else
                {
                    $str .= ',' . $d['UserSection']['section_list_id'];
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

        $this->set('users', $roles);
    }

    /* function to allow permissions by admin */
    public function admin_allowAccess($uid = null)
    {
        $this->set('title_for_layout', 'Access Permission');
        if (! empty($this->request->data))
        {
            $tmp = $this->request->data;
            if (@$tmp['Section']['section_list_id'])
            {
                foreach ($tmp['Section']['section_list_id'] as $t)
                {

                    $id = $t;
                    $this->UserSection->id = $id;

                    if (! $this->UserSection->exists())
                    {
                        throw new NotFoundException(__('Invalid Access Token'));
                    }
                    $this->request->onlyAllow('post', 'delete');
                    if ($this->UserSection->delete())
                    {
                        $f = 1;
                    }
                }
                if ($f == 1)
                {
                    $this->Session->setFlash(__('Access Granted'));
                    $this->redirect([
                        'action' => 'managePermissions/' . base64_encode($tmp['Section']['user_id'])
                    ]);
                }
                else
                {
                    $this->Session->setFlash(__('Access Denied'));
                }
            }
            else
            {
                $this->Session->setFlash('Please select function name first.');
                $this->redirect('/admin/userSections/allowAccess/' . $uid);
            }
        }
        // ELSE
        $this->loadModel('User');
        $roles = $this->User->find('list', [
            'fields' => [
                'id',
                'name'
            ],
            'conditions' => [
                'AND' => [
                    'User.id' => base64_decode($uid),
                    'NOT' => [
                        'User.id' => 1
                    ]
                ]
            ]
        ]);
        if (empty($uid))
        {
            echo 'Bad Request.';
            die();
        }
        if (empty($roles))
        {
            echo 'Bad Request';
            die();
        }
        $this->paginate = [
            'contain' => false,
            'order' => 'UserSection.id ASC',
            'limit' => LIMIT,
            'conditions' => [
                ' UserSection.user_id' => base64_decode($uid)
            ]
        ];
        $Section = $this->Paginate('UserSection');
        // pr($Section);
        $this->set(compact('Section'));

        $this->set('users', $roles);
    }
}