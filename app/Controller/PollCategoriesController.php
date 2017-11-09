<?php
App::uses('AppController', 'Controller');

/**
 * PollCategories Controller
 *
 * @property PollCategory $PollCategory
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class PollCategoriesController extends AppController
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

    public $helpers = [
        'Poll',
        'Wall'
    ];

    /**
     * _checkSportSession method
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function _checkSportSession()
    {
        if (! $this->Auth->Session->read('Auth.User.sportSession.league_id') && ! $this->Auth->Session->read('Auth.User.sportSession.team_id'))
        {
            return $this->redirect([
                'controller' => 'dashboard',
                'action' => 'index'
            ]);
        }
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'List Poll');
        $this->PollCategory->recursive = 0;
        $this->set('pollCategories', $this->Paginator->paginate());
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
        $this->set('title_for_layout', 'View Poll');
        if (! $this->PollCategory->exists($id))
        {
            throw new NotFoundException(__('Invalid poll category'));
        }
        $options = [
            'conditions' => [
                'PollCategory.' . $this->PollCategory->primaryKey => $id
            ]
        ];
        $this->set('pollCategory', $this->PollCategory->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', 'Add Poll');
        if ($this->request->is('post'))
        {
            $this->PollCategory->create();
            if ($this->PollCategory->save($this->request->data))
            {
                $this->Flash->success(__('The poll category has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The poll category could not be saved. Please, try again.'));
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
        $this->set('title_for_layout', 'Update Poll');
        if (! $this->PollCategory->exists($id))
        {
            throw new NotFoundException(__('Invalid poll category'));
        }
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->PollCategory->save($this->request->data))
            {
                $this->Flash->success(__('The poll category has been saved.'));
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('The poll category could not be saved. Please, try again.'));
        }
        else
        {
            $options = [
                'conditions' => [
                    'PollCategory.' . $this->PollCategory->primaryKey => $id
                ]
            ];
            $this->request->data = $this->PollCategory->find('first', $options);
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
        $this->set('title_for_layout', 'Delete Poll');
        $this->PollCategory->id = $id;
        if (! $this->PollCategory->exists())
        {
            throw new NotFoundException(__('Invalid poll category'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->PollCategory->delete())
        {
            $this->Flash->success(__('The poll category has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The poll category could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * polls method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function polls()
    {
        Configure::write('debug', 2);
        $this->_checkSportSession();
        $this->set('title_for_layout', __('View Polls'));
        $limit = 10;
        $this->loadModel('Poll');
        $this->loadModel('PollResponse');
        $options = [
            'Poll.status' => 1,
            'Poll.is_deleted' => 0,
            'Pocale.code' => $this->Session->read('Config.language')
        ];
        $polls = $this->Poll->find('all', [
            'conditions' => $options,
            'order' => [
                'Poll.id' => 'desc'
            ],
            'limit' => $limit
        ]);
        $gameList = $this->getMatchList();
        $this->set(compact('polls', 'gameList'));
    }

    /**
     * savePoll method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function savePoll()
    {
        $this->autoRender = false;
        $this->layout = false;
        $this->loadModel('Poll');
        $this->loadModel('PollResponse');
        if ($this->request->is([
            'post',
            'put'
        ]))
        {

            $pollId = $this->request->data['poll_id'];
            if (! $this->PollCategory->Poll->exists($pollId))
            {
                throw new NotFoundException(__('Invalid poll'));
            }
            $userId = AuthComponent::User('id');
            $checkIfPollExist = $this->PollResponse->find('count', [
                'conditions' => [
                    'PollResponse.user_id' => $userId,
                    'PollResponse.poll_id' => $pollId
                ]
            ]);
            if (! empty($checkIfPollExist))
            {
                echo 'exist';
                exit();
            }

            $this->request->data['user_id'] = $userId;
            if ($this->PollResponse->save($this->request->data))
            {
                echo $this->PollResponse->getLastInsertId();
            }
            else
            {
                echo 0;
            }
        }
    }

    /**
     * addComment method
     *
     * @param string $id
     *
     * @return void
     */
    public function addComment()
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->set('title_for_layout', __('View Poll'));
        $this->loadModel('ForumComment');
        $params = [];
        parse_str($this->request->data, $params);
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $params['data']['ForumComment']['user_id'] = AuthComponent::User('id');
            if ($this->ForumComment->save($params['data']))
            {
                echo $this->ForumComment->getLastInsertId();
            }
            else
            {
                echo 0;
            }
        }
    }

    /**
     * loadComments ajax method
     *
     * @throws NotFoundException
     *
     * @todo add query for rejoin date condition.
     *
     * @return void
     */
    public function loadComments()
    {
        $this->layout = false;
        $this->loadModel('Poll');
        if ($this->request->is('post'))
        {
            $limit = 10;
            $loadeIdFrom = $this->request->data['loadfrom'];
            $options = [
                'Poll.id <' => $loadeIdFrom,
                'Poll.status' => 1,
                'Poll.is_deleted' => 0
            ];
            $polls = $this->Poll->find('all', [
                'conditions' => $options,
                'order' => [
                    'Poll.id' => 'desc'
                ],
                'limit' => $limit
            ]);
            $this->set(compact('polls'));
        }
    }

    /**
     * viewDetail method
     *
     * @todo add query for rejoin date condition.
     *
     * @param null|mixed $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function viewDetail($id = null)
    {
        $this->_checkSportSession();
        $id = base64_decode($id);
        $this->loadModel('Poll');
        if (! $this->Poll->exists($id))
        {
            throw new NotFoundException(__('Invalid poll category'));
        }
        if ($this->request->is('get'))
        {
            $options = [
                'Poll.id' => $id,
                'Poll.status' => 1,
                'Poll.is_deleted' => 0
            ];
            $poll = $this->Poll->find('first', [
                'conditions' => $options
            ]);
            $this->set(compact('poll'));
        }
    }

    /**
     * saveEditComment method
     *
     * @param string $id
     *
     * @return void
     */
    public function saveEditComment()
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->set('title_for_layout', __('Save Forum'));
        $this->loadModel('ForumComment');
        $params = $this->request->data;
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $this->ForumComment->id = $this->request->data['id'];
            if ($this->ForumComment->saveField('name', $this->request->data['value']))
            {
                echo $this->request->data['id'];
            }
            else
            {
                echo 0;
            }
        }
    }

    /**
     * deleteComment method
     *
     * @param string $id
     *
     * @return void
     */
    public function deleteComment()
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->set('title_for_layout', __('Delete forum'));
        $this->loadModel('ForumComment');
        $params = $this->request->data;
        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            $this->request->data['id'];
            $this->ForumComment->id = $this->request->data['id'];
            if ($this->ForumComment->delete())
            {
                echo $this->request->data['id'];
            }
            else
            {
                echo 0;
            }
        }
    }

    /*
     * function to get list of today's match
     * Created By: Smartdata
     * Date: 02-06-2016
     * Company: SmartData
     */
    public function getMatchList()
    {
        $leagueId = $this->Auth->Session->read('Auth.User.sportSession.league_id');
        $sportId = $this->Auth->Session->read('Auth.User.sportSession.sport_id');
        $this->loadModel('Game');
        $this->Game->UnbindModel([
            'hasMany' => [
                'Team'
            ]
        ], false);
        $gamesLists = $this->Game->find('all', [
            'conditions' => [
                'Game.sport_id' => $sportId,
                'Game.league_id' => $leagueId,
                'Game.play_status' => 1
            ]/*,'fields'=>array('Game.id','Game.start_time','First_team.name','Second_team.name')*/]);
        // pr($gamesLists);die;
        $arr = [];
        foreach ($gamesLists as $game)
        {
            $arr[$game['Game']['id']]['GameName'] = $game['First_team']['name'] . ' VS ' . $game['Second_team']['name'];
            $arr[$game['Game']['id']]['start_time'] = $game['Game']['start_time'];
            $arr[$game['Game']['id']]['end_time'] = $game['Game']['end_time'];
            $arr[$game['Game']['id']]['GameID'] = $game['Game']['id'];
        }
        $gamesList = json_encode($arr);

        return $gamesList;
    }
}