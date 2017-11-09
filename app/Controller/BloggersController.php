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
class BloggersController extends AppController
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
     * _before filter method
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->View = new View($this, false);
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
        $this->set(compact('users', 'tournaments', 'sports', 'leagues', 'teams'));
    }

    /**
     * blogger_youtube method
     *
     * @return void
     */
    public function blogger_share_video()
    {
        $this->set('title_for_layout', __('YouTube Video Share'));
        $this->loadModel('Team');
        $this->loadModel('Wall');
        $this->loadModel('WallContent');
        $id = AuthComponent::User('id');
        $resultArr = $this->Wall->UserTeam->find('first', [
            'conditions' => [
                'UserTeam.user_id' => $id
            ]
        ]);
        $team_id = isset($resultArr['UserTeam']['team_id']) ? $resultArr['UserTeam']['team_id'] : '';
        $league_id = isset($resultArr['League']['id']) ? $resultArr['League']['id'] : '';
        $this->request->data['WallContent']['post_type'] = 0; // 1 for wall post, 0 for blog post
        $this->request->data['WallContent']['content_type'] = 'embed'; // image,video,document,audio

        if ($this->request->is('post'))
        {
            $wallId = $this->CheckWall();

            $youtubeLink = $this->request->data['WallContent']['name'];
            $rx = '~
                        ^(?:https?://)?              # Optional protocol
                         (?:www\.)?                  # Optional subdomain
                         (?:youtube\.com|youtu\.be)  # Mandatory domain name
                         /watch\?v=([^&]+)           # URI with video id as capture group 1
                         ~x';

            $has_match = preg_match($rx, $youtubeLink);
            if (! $has_match)
            {
                $this->Flash->error(__('The youtube link is not valid. Please, try again.'));
                return $this->redirect([
                    'controller' => 'bloggers',
                    'action' => 'share_video'
                ]);
            }
            $this->request->data['WallContent']['wall_id'] = $wallId;
            $this->request->data['WallContent']['user_id'] = AuthComponent::User('id');

            $this->WallContent->create();
            if ($this->WallContent->save($this->request->data))
            {
                $this->Flash->success(__('The video has been saved.'));
            }
            else
            {

                $this->Flash->error(__('The video could not be saved. Please, try again.'));
            }
            return $this->redirect([
                'controller' => 'dashboard',
                'action' => 'index'
            ]);
        }
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
}