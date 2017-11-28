<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Gifts Controller
 *
 * @property Gifts $Gifts
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 * @property SessionComponent $Session
 */
class GiftsController extends AppController
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
        'Resizer',

    ];

    public $helpers = [
        'Html',
        'Text'
    ];

    public $uses = [
        'Gift',
        'GiftCategory',
        'Location',
        'Game',
        'Tournament',
        'League'
    ];

    /*
     *
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->View = new View($this, false);
        $this->Auth->allow('getTournamentsAjax', 'getGiftListAjax','getLeaguesAjax', 'admin_searchGiftLocation', 'searchGiftLocation','getcashImagesAjax','getGamesDaysAjax');
    }

    /**
     * index method
     *
     * @param mixed      $conditions
     * @param null|mixed $order
     * @param null|mixed $limit
     *
     * @return void
     */
    public function index($conditions = [], $order = null, $limit = null)
    {
        $this->Gift->recursive = 0;
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
        $this->set('gifts', $this->paginate('Gift'));
        $status = [
            'Inactive',
            'Active'
        ];

        $this->set(compact('status'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        // configure::write("debug",2);
        $this->set('title_for_layout', 'List Gifts');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'Gift.id DESC');
    }

    public function _getSearchConditions()
    {
        $input = $_GET;
        $model = 'Gift';

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
                    {
                        $conditions[$model . '.' . $k] = $v;
                    }
                }
            }
            $this->data = [
                'Gift' => $input
            ];
        }

        return $conditions;
    }

    public function _getSearchConditions1()
    {
        $input = $_GET;
        $model = 'Gift';

        $items = [];
        $conditions = [
            'Gift.status' => 1,
            'Gift.location_id' => $_REQUEST['location_id'],
            'Gift.sport_id' => [
                0,
                AuthComponent::User('sportSession.sport_id')
            ],
            'Gift.tournament_id' => [
                0,
                AuthComponent::User('sportSession.tournament_id')
            ],
            'Gift.league_id' => [
                0,
                AuthComponent::User('sportSession.league_id')
            ],
            'Gift.end_date >=' => date('Y-m-d')
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
                    {
                        $conditions[$model . '.' . $k] = $v;
                    }
                }
            }
            $this->data = [
                'Gift' => $input
            ];
        }

        return $conditions;
    }
   public function getGiftListAjax($gifttype=null,$giftgameday=null,$gift_cat=null)
    {
        $this->loadModel('Countries');
        $this->layout = false;
        $this->autoRender = false;
          $gifttype = base64_decode($gifttype);
          $gift_cat = base64_decode($gift_cat);
          $gift_gameday = base64_decode($giftgameday);
        $tournament_id = AuthComponent::User('sportSession.tournament_id');
        $sport_id=AuthComponent::User('sportSession.sport_id');
        $league_id =AuthComponent::User('sportSession.league_id');
         if(($gifttype==1) || ($gifttype=='')){

            $options = $this->Gift->find('list', [
                        'conditions' => [
                            'type' => $gifttype,
                            'tournament_id' => array($tournament_id,0),
                            'league_id' => array($league_id,0),
                            'sport_id' => array($sport_id,0),
                            'gift_category_id'=>array($gift_cat,0),
                            'game_day' =>array($gift_gameday,0),
                            'status' =>1,
                            'is_deleted' =>0,

                        ],
                        'fields' => [
                             'name'
                        ],
                         'order' => ['id' => 'DESC'],

                    ]);



        echo $this->View->Form->input('GamesGiftPrediction.gift_id', [
            'class' => 'form-control',
            'label' => 'Gift Name',
            'empty' => '-- Select one --',
            'options' => $options,
            'onchange' => 'getGiftImages(this);'
        ]);
    }
   else
    {



        /*$this->Gift->query("Select id, 'abc' as dummy_col
    FROM `gifts` WHERE type=$id and tournament_id= $tournament_id and league_id=$league_id and sport_id=$sport_id and status=1 and is_deleted=0;");*/
      $country = $this->Countries->find('list', [

                        'fields' => [
                             'Countries.CurrencyCode','Countries.Country'
                        ],
                       'order' => ['Countries.Country' => 'ASC'],
                        // 'order' => 'Country'

                    ]);


//print_r($country);exit;
     echo '<div class ="input select" style="margin-bottom:5px;">'.$this->View->Form->input('', ['class' => 'form-control','id' => 'countryid','label' => 'Country', 'empty' => '-- Select one --', 'options' => $country,'onchange' => 'getRate();'
        ]).'</div>';
//  $gift_cat;
 //   echo $gift_cat;
      $options = $this->Gift->find('list', [
                        'conditions' => [
                            'type' => $gifttype,
                            //'gift_category_id' =>$gift_cat,
                            'game_day' =>array($gift_gameday,0),
                            'tournament_id' => array($tournament_id,0),
                            'league_id' => array($league_id,0),
                            'sport_id' => array($sport_id,0),
                            'status' =>1,
                            'is_deleted' =>0,

                        ],
               'fields' => array('amount'),
                         'order' => ['id' => 'DESC'],

                    ]);

    // print_r($options);exit;
      echo '<div class ="input select" style="margin-bottom:10px;">'.$this->View->Form->input('GamesGiftPrediction.gift_id', ['class' => 'form-control','label' => 'Cash Price','id' => 'cashpriceid', 'empty' => '-- Select one --', 'options' => $options ,'onchange' => 'getRate();'

        ]).'</div>';
      /* $cash_images = $this->Gift->find('all', array(
            'fields' => array('file.path','Gift.product_link','Gift.winning_no_game'),
            'joins' => array(
                array(
                        'table' => 'files',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('file.id =Gift.file_id')
                    ),
                ),
             'conditions'=>array('Gift.tournament_id' => $tournament_id,
                            'Gift.league_id' => $league_id,
                            'Gift.sport_id' => $sport_id,
                            'Gift.status' =>1,
                            'Gift.is_deleted' =>0),
            'order' => 'rand()',
            'limit' => 3,
            )
        );
       //echo'<pre>';print_r($cash_images);exit;

       foreach($cash_images as $cashimage)
       {
      echo '<div class="col-sm-4" id="realimage-box"><a class="thumbnail" href=http://'.$cashimage['Gift']['product_link'].'><img src='.$cashimage['file']['path'].' style="height:50px; width:100px;" alt="Sports"></a><div class="checkbox" style="position: absolute; left: 21px; top: -6px;"><label><input type="checkbox" value="" style="position:static !important;"></label></div></div>';
       }*/


    }
}

     public function getGiftImagesAjax($id = null)
    {

        $this->layout = false;
        $this->autoRender = false;
        $id = base64_decode($id);

        $tournament_id = AuthComponent::User('sportSession.tournament_id');
        $sport_id=AuthComponent::User('sportSession.sport_id');
        $league_id =AuthComponent::User('sportSession.league_id');
      /* $randomegiftimages=$this->set('random_posts', $this->Gift->find('first', array(
       'conditions' => array('tournament_id' => $tournament_id,
                            'league_id' => $league_id,
                            'sport_id' => $sport_id,
                            'status' =>1,
                            'is_deleted' =>0),
       'order' => 'rand()',
       'limit' => 2,
        )));*/
            //print_r($randomegiftimages);exit;
/*            $gift_images = $this->Gift->find('first', array(
            'fields' => array('file.path','Gift.product_link','Gift.winning_no_game'),
            'joins' => array(
                array(
                        'table' => 'files',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('file.id =Gift.file_id')
                    ),
                ),
            'order' => 'rand()',
            'limit' => 2,
            )
        );*/
         $giftrandomimage = $this->Gift->find('all', array(
            'fields' => array('file.path','Gift.product_link','Gift.winning_no_game'),
            'joins' => array(
                array(
                        'table' => 'files',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('file.id =Gift.file_id')
                    ),
                ),
             'conditions'=>array('Gift.tournament_id' => $tournament_id,
                            'Gift.league_id' => $league_id,
                            'Gift.sport_id' => $sport_id,
                            'Gift.type' =>1,
                            'Gift.status' =>1,
                            'Gift.is_deleted' =>0),
            'order' => 'rand()',
            'limit' => 2,
            )
        );

            $giftimages = $this->Gift->find('all', array(
            'fields' => array('file.path','Gift.product_link','Gift.winning_no_game'),
            'joins' => array(
                array(
                        'table' => 'files',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('file.id =Gift.file_id')
                    ),
                ),
             'conditions'=>array('Gift.id' => $id)
            )
        );
           // print_r($giftimages);exit;
         //echo json_encode($giftimages);exit;
         $allimages=array_merge($giftrandomimage,$giftimages);
        if(sizeof($allimages)==3)
        {

          echo json_encode(array_merge($giftrandomimage,$giftimages));die;
       }
       elseif(!empty($giftimages) && (sizeof($allimages)<3))
       {
        echo json_encode($giftimages);die;
       }
      else

      {
          $options = $this->Gift->find('first', array(
            'fields' => array('Gift.winning_no_game'),

             'conditions'=>array(
                            'Gift.id' => $id,


                        )
            )
        );

        echo json_encode($options);exit;
      }
    }

     public function getcashImagesAjax()
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('Gift');
       // $this->response->type('json');
        $cashamount = $_POST['cashamount'];

        //echo $cashamount = $_POST['cashamount'];
        $tournament_id = AuthComponent::User('sportSession.tournament_id');
        $sport_id=AuthComponent::User('sportSession.sport_id');
        $league_id =AuthComponent::User('sportSession.league_id');
        $cash_images = $this->Gift->find('all', array(
            'fields' => array('file.path','Gift.product_link','Gift.winning_no_game'),
            'joins' => array(
                array(
                        'table' => 'files',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('file.id =Gift.file_id')
                    ),
                ),
             'conditions'=>array('Gift.tournament_id' => $tournament_id,
                            'Gift.league_id' => $league_id,
                            'Gift.sport_id' => $sport_id,
                            'Gift.status' =>1,
                             'Gift.type' =>1,
                            'Gift.is_deleted' =>0),
            'order' => 'rand()',
            'limit' => 2,
            )
        );

     /*
         $options = $this->Gift->find('all', array(
           // 'fields' => array('("/img/GiftsImages/1487570931.png") as path','Gift.product_link','Gift.winning_no_game'),
           // 'fields' => array('IFNULL("/img/GiftsImages/1487570931.png","abc") as path','Gift.product_link','Gift.winning_no_game'),
            //'fields' => array('file.path','Gift.product_link','Gift.winning_no_game'),
             'fields' => array('filea.path','Gift.product_link','Gift.winning_no_game'),
            'joins' => array(
                array(
                        'table' => 'files',
                        'alias' => 'file',
                        'type' => 'left',
                        'conditions' => array('file.id =Gift.file_id')
                    ),
                ),
             'conditions'=>array('Gift.id' => $cashamount)
            )
        );*/
        $options =$this->Gift->query("SELECT IFNULL(`file`.`path`,'/img/GiftsImages/1487601352.png') AS `path`, `Gift`.`product_link`, `Gift`.`winning_no_game` FROM `gifts` AS `Gift` LEFT JOIN `files` AS `File` ON (`Gift`.`file_id` = `File`.`id`) LEFT JOIN `locations` AS `Location` ON (`Gift`.`location_id` = `Location`.`id`) LEFT JOIN `gift_categories` AS `GiftCategory` ON (`Gift`.`gift_category_id` = `GiftCategory`.`id`) LEFT JOIN `sports` AS `Sport` ON (`Gift`.`sport_id` = `Sport`.`id`) LEFT JOIN `tournaments` AS `Tournament` ON (`Gift`.`tournament_id` = `Tournament`.`id`) LEFT JOIN `leagues` AS `League` ON (`Gift`.`league_id` = `League`.`id`) left JOIN `files` AS `file` ON (`file`.`id` =`Gift`.`file_id`) WHERE `Gift`.`id` = '".$cashamount."'" );

        // print_r($options);exit;
           $allimages=array_merge($cash_images,$options);
            if(sizeof($allimages)==3)
            {

              echo json_encode(array_merge($cash_images,$options));die;
           }
           else
           {
            //echo json_encode($giftimages);die;
            echo json_encode($options);die;
           }
         /*$cashimage = $this->Gift->find('first', array(
            'fields' => array('file.path','Gift.product_link','Gift.winning_no_game'),
            'joins' => array(
                array(
                        'table' => 'files',
                        'alias' => 'file',
                        'type' => 'right',
                        'conditions' => array('file.id =Gift.file_id')
                    ),
                ),
             'conditions'=>array('Gift.id' => $id)
            )
        );*/

       //echo'<pre>';print_r($cash_images);exit;

     /*  foreach($cash_images as $cashimage)
       {
      echo '<div class="col-sm-4" id="realimage-box"><a class="thumbnail" href=http://'.$cashimage['Gift']['product_link'].'><img src='.$cashimage['file']['path'].' style="height:50px; width:100px;" alt="Sports"></a><div class="checkbox" style="position: absolute; left: 21px; top: -6px;"><label><input type="checkbox" value="" style="position:static !important;"></label></div></div>';
       }*/
    }
 public function getGamesDaysAjax($sport_id = null,$tournament_id=null,$league_id=null,$winning_game=null,$gameday=null)
    {
        $this->loadModel('Game');
        $this->layout = false;
        $this->autoRender = false;
         $sportid = base64_decode($sport_id);
         $tournamentid = base64_decode($tournament_id);
         $leagueid = base64_decode($league_id);
         $winninggame = base64_decode($winning_game);
         $game_day = base64_decode($gameday);
         $totalgameday = $this->Game->find('count', [
                         'conditions' => [
                            'Game.tournament_id' => $tournamentid,
                            'Game.league_id' => $leagueid,
                            'Game.sport_id' => $sportid,
                            'Game.teams_gameday' =>$game_day,
                            'Game.status' =>1,
                            'Game.is_deleted' =>0,

                        ],
                         'fields' => [
                             'teams_gameday'
                        ],

                    ]);
       /*  $totalgameday = $this->Game->find('list', [
                        'conditions' => [
                            'type' => $gifttype,
                            'tournament_id' => $tournamentid,
                            'league_id' => $leagueid,
                            'sport_id' => $sportid,
                            'teams_gameday' =>$game_day,
                            'status' =>1,
                            'is_deleted' =>0,

                        ],
                        ]);*/
         print_r($totalgameday);

    }

      public function randomgiftlist()
    {
        $tournament_id = AuthComponent::User('sportSession.tournament_id');
        $sport_id=AuthComponent::User('sportSession.sport_id');
        $league_id =AuthComponent::User('sportSession.league_id');
        $this->set('random_posts', $this->Gift->find('all', array(
       'conditions' => array('tournament_id' => $tournament_id,
                            'league_id' => $league_id,
                            'sport_id' => $sport_id,
                            'status' =>1,
                            'is_deleted' =>0),
       'order' => 'rand()',
       'limit' => 2,
    )));
        //print_r($random_images);exit;
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

    public function gift_prediction()
    {
       $this->loadModel('Game');
        $sports = $this->Game->Sport->find('list', [
            'order' => 'Sport.name'
        ]);
        $sports['0'] = 'All';
        $this->set(compact('sports'));
    }

    public function admin_view($id = null)
    {
        $this->set('title_for_layout', 'View Gifts');
        if (! $this->Gift->exists($id))
        {
            throw new NotFoundException(__('Invalid gifts'));
        }
        $options = [
            'conditions' => [
                'Gift.' . $this->Gift->primaryKey => $id
            ]
        ];
        $this->set('gifts', $this->Gift->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
   public function admin_add()
    {
        $this->set('title_for_layout', 'Add Gifts');
        if ($this->request->is('post'))
        {
            if ($this->request->data['Gift']['type'] == 2)
            {
                $this->request->data['Gift']['product_link'] = '';
                unset($this->request->data['Gift']['file_id']);
            }
            $this->request->data['Gift']['user_id'] = AuthComponent::user('id');

            if (@$this->data['Gift']['file_id']['name'] != '')
            {
                $tmpName = $this->data['Gift']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                    // return 'selectvalidimage';
                }

                $exten = explode('.', $this->data['Gift']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {
                    $imageSize = getimagesize($this->data['Gift']['file_id']['tmp_name']);
                    if ($imageSize[0] <= 347 && $imageSize[1] <= 477)
                    {
                        $this->Flash->error(__('Please upload image greater than 348 (w) X 478 (h) dimension.'));
                        // return 'uploadbigimage';
                        return $this->redirect($this->referer());

                    }
                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['Gift']['file_id'];
                    $destination = 'img/GiftsImages/large/';
                    $destination2 = 'img/GiftsImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '480', 'jpg', '348', '478');

                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '180', 'jpg', '180', '180');
                    $files_data = $this->data['Gift']['file_id'];

                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/GiftsImages/', $filename);
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->Gift->create();
                        $this->request->data['Gift']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Gift->save($this->request->data))
                        {
                            $this->Flash->success(__('The gifts has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                            // return 'save';

                        }
                        $this->Flash->error(__('The gifts could not be saved. Please, try again.'));
                        // return 'datanotsaved';
                    }
                    else
                    {
                       $this->Flash->error(__('Unable to upload Image and save record. Please, try again.'));
                        // return 'unabletouploadimage';
                    }
                }
                else
                {
                   $this->Flash->error(__('Please select a valid image format. gif, jpg, png, jpeg are allowed only'));
                    // return 'selectvalidimage';
                }
            }
            else
            {
                unset($this->request->data['Gift']['file_id']);
                $this->Gift->create();
                if ($this->Gift->save($this->request->data))
                {
                    $this->Flash->success(__('The gifts has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The gifts could not be saved. Please, try again.'));
            }
        }

        $gift_cat = $this->GiftCategory->find('list');
        $gift_cat['0'] = 'All';
        $location = $this->Location->find('list');
        $this->set(compact('gift_cat', 'location'));

        $this->loadModel('Game');
        $sports = $this->Game->Sport->find('list', [
            'order' => 'Sport.name'
        ]);
        $sports['0'] = 'All';
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
        $this->set('title_for_layout', 'Update Gifts');

        if (! $this->Gift->exists($id))
        {
            throw new NotFoundException(__('Invalid gifts'));
        }

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->request->data['Gift']['type'] == 2)
            {
                $this->request->data['Gift']['product_link'] = '';
                unset($this->request->data['Gift']['file_id']);
            }

            if ($this->data['Gift']['file_id']['name'])
            {
                $tmpName = $this->data['Gift']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);

                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }

                $imageSize = getimagesize($this->data['Gift']['file_id']['tmp_name']);

                if ($imageSize[0] <= 347 && $imageSize[1] <= 477)
                {
                    $this->Flash->error(__('Please upload image greater than 348 (w) X 478 (h) dimension.'));
                    return $this->redirect($this->referer());
                }

                $exten = explode('.', $this->data['Gift']['file_id']['name']);

                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {
                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['Gift']['file_id'];
                    $destination = 'img/GiftsImages/large/';
                    $destination2 = 'img/GiftsImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '480', 'jpg', '348', '478');

                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '180', 'jpg', '180', '180');

                    $files_data = $this->data['Gift']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/GiftsImages/', $filename);
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->Gift->create();
                        $this->request->data['Gift']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Gift->save($this->request->data))
                        {
                            $this->Flash->success(__('The gifts has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The gifts could not be saved. Please, try again.'));
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
                unset($this->request->data['Gift']['file_id']);
                if ($this->Gift->save($this->request->data))
                {
                    $this->Flash->success(__('The gifts has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The gifts could not be saved. Please, try again.'));
            }
        }
        else
        {
            $options = [
                'conditions' => [
                    'Gift.' . $this->Gift->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Gift->find('first', $options);
        }

        $files = $this->Gift->File->find('list');
        $gift_cat = $this->GiftCategory->find('list');
        $gift_cat['0'] = 'All';
        $location = $this->Location->find('list');
        $this->set(compact('gift_cat', 'location'));

        $sports = $this->Game->Sport->find('list', [
            'order' => 'Sport.name'
        ]);

        $tournaments = $this->Tournament->find('list', [
            'conditions' => [
                'Tournament.status' => Tournament::STATUS_ACTIVE,
                'Tournament.is_deleted' => 0,
            ],
            'order' => 'Tournament.name'
        ]);

        $leagues = $this->League->find('list', [
            'conditions' => [
                'League.status' => 1,
                'League.is_deleted' => 0,
            ],
            'order' => 'League.name'
        ]);

        $this->set(compact('sports', 'tournaments', 'leagues'));
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
        $this->set('title_for_layout', 'Delete Gifts');
        $this->Gift->id = $id;
        if (! $this->Gift->exists())
        {
            throw new NotFoundException(__('Invalid gifts'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Gift->delete())
        {
            $this->Flash->success(__('The gifts has been deleted.'));
        }
        else
        {
            $this->Flash->error(__('The gifts could not be deleted. Please, try again.'));
        }
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    /**
     * admin_changeToTopGifts method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_changeToTopGifts()
    {
        $this->autoRender = false;
        $this->Gift->id = $this->request->data['id'];
        if (! $this->Gift->exists())
        {
            throw new NotFoundException(__('Invalid gifts'));
        }

        $topGiftsCount = $this->Gift->find('count', [
            'conditions' => [
                'Gifts.top_gifts' => 1,
                'AND' => [
                    'Gifts.foreign_key' => $this->request->data['sportId']
                ]
            ]
        ]);
        if ($topGiftsCount == 2 && $this->request->data['value'] == 1)
        {
            echo $topGiftsCount;
        }
        else
        {
            if ($this->Gift->saveField('top_gifts', $this->request->data['value']))
            {
                echo 'saved';
            }
            else
            {
                echo 'error';
            }
        }
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function sports_index()
    {
        $this->set('title_for_layout', 'List Gifts');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'Gifts.top_gifts DESC');
    }

    /**
     * sports_add method
     *
     * @return void
     */
    public function sports_add()
    {
        $this->set('title_for_layout', 'Add Gifts');
        if ($this->request->is('post'))
        {
            $this->request->data['Gift']['user_id'] = AuthComponent::user('id');
            $this->request->data['Gift']['publish'] = 0;
            if ($this->data['Gift']['file_id']['name'])
            {
                $tmpName = $this->data['Gift']['file_id']['tmp_name'];
                $imgType = $this->checkMimeTypeApp($tmpName);
                if ($imgType == 0)
                {
                    $this->Flash->error(__('Invalid Image.'));
                    $this->redirect($this->referer());
                }
                $exten = explode('.', $this->data['Gift']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {

                    $imageSize = getimagesize($this->data['Gift']['file_id']['tmp_name']);
                    if ($imageSize[0] <= 347 && $imageSize[1] <= 477)
                    {
                        $this->Flash->error(__('Please upload image greater than 348 (w) X 478 (h) dimension.'));
                        return $this->redirect([
                            'controller' => 'gifts',
                            'action' => 'add',
                            'sports' => true
                        ]);
                    }
                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['Gift']['file_id'];
                    $destination = 'img/GiftsImages/large/';
                    $destination2 = 'img/GiftsImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '480', 'jpg', '348', '478');

                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '180', 'jpg', '180', '180');

                    $files_data = $this->data['Gift']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/GiftsImages/', $filename);
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->Gift->create();
                        $this->request->data['Gift']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        $this->request->data['Gift']['foreign_key'] = $this->Session->read('Auth.Sports.SportInfo.Sport.id');
                        if ($this->Gift->save($this->request->data))
                        {
                            $this->Flash->success(__('The gifts has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The gifts could not be saved. Please, try again.'));
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
                $this->Gift->create();
                if ($this->Gift->save($this->request->data))
                {
                    $this->Flash->success(__('The gifts has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The gifts could not be saved. Please, try again.'));
            }
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
        $this->set('title_for_layout', 'View Gifts');
        if (! $this->Gift->exists($id))
        {
            throw new NotFoundException(__('Invalid gifts'));
        }
        $options = [
            'conditions' => [
                'Gift.' . $this->Gift->primaryKey => $id
            ]
        ];
        $this->set('gifts', $this->Gift->find('first', $options));
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
        $this->set('title_for_layout', 'Update Gifts');
        if (! $this->Gift->exists($id))
        {
            throw new NotFoundException(__('Invalid gifts'));
        }

        if ($this->request->is([
            'post',
            'put'
        ]))
        {
            if ($this->data['Gift']['file_id']['name'])
            {

                $imageSize = getimagesize($this->data['Gift']['file_id']['tmp_name']);
                if ($imageSize[0] <= 347 && $imageSize[1] <= 477)
                {
                    $this->Flash->error(__('Please upload image greater than 348 (w) X 478 (h) dimension.'));
                    return $this->redirect([
                        'controller' => 'gifts',
                        'action' => 'edit',
                        $id
                    ]);
                }
                $exten = explode('.', $this->data['Gift']['file_id']['name']);
                if ($exten[1] == 'GIF' || $exten[1] == 'gif' || $exten[1] == 'jpg' || $exten[1] == 'jpeg' || $exten[1] == 'PNG' || $exten[1] == 'png' || $exten[1] == 'JPG' || $exten[1] == 'JPEG')
                {
                    $filename = time() . '.' . $exten[1];
                    $file1 = $this->data['Gift']['file_id'];
                    $destination = 'img/GiftsImages/large/';
                    $destination2 = 'img/GiftsImages/thumbnail/';

                    $this->Resizer->upload($file1, $destination, $filename);
                    $this->Resizer->image($file1, 'resize', '480', 'jpg', '348', '478');
                    $fileName = $this->Resizer->upload($file1, $destination2, $filename);
                    $this->Resizer->image($file1, 'resize', '180', 'jpg', '180', '180');

                    $files_data = $this->data['Gift']['file_id'];
                    $upload_info = $this->File->upload($files_data, WWW_ROOT . 'img/GiftsImages/');
                    if ($upload_info['uploaded'] == 1)
                    {
                        $this->Gift->create();
                        $this->request->data['Gift']['file_id'] = $upload_info['db_info']['Upload']['id'];
                        if ($this->Gift->save($this->request->data))
                        {
                            $this->Flash->success(__('The gifts has been saved.'));
                            return $this->redirect([
                                'action' => 'index'
                            ]);
                        }
                        $this->Flash->error(__('The gifts could not be saved. Please, try again.'));
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
                unset($this->request->data['Gift']['file_id']);
                if ($this->Gift->save($this->request->data))
                {
                    $this->Flash->success(__('The gifts has been saved.'));
                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }
                $this->Flash->error(__('The gifts could not be saved. Please, try again.'));
            }
        }
        else
        {
            $options = [
                'conditions' => [
                    'Gift.' . $this->Gift->primaryKey => $id
                ]
            ];
            $this->request->data = $this->Gift->find('first', $options);
        }

        $files = $this->Gift->File->find('list');
        $this->set(compact('files'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function editor_index()
    {
        $this->set('title_for_layout', 'List Gifts');
        $conditions = [];
        $conditions = $this->_getSearchConditions();
        $this->index($conditions, 'Gifts.top_gifts DESC');
    }

    /**
     * admin_changeToAddedBy method
     *
     * @param string $id
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function admin_changeToAddedBy()
    {
        $this->autoRender = false;
        $this->Gift->id = $this->request->data['id'];
        if (! $this->Gift->exists())
        {
            throw new NotFoundException(__('Invalid gifts'));
        }
        if ($this->request->data['value'] == '0')
        {
            $returnMessage = 'publish';
        }
        else
        {
            $returnMessage = 'unpublish';
        }

        if ($this->Gift->saveField('publish', $this->request->data['value']))
        {
            echo $returnMessage;
        }
        else
        {
            echo 'error';
        }
    }

    /**
     * *******************************Gifts Comment start****************************
     */
    /**
     * addComment method
     *
     * @return void
     */
    public function addComment()
    {
        $this->autoRender = false;
        if ($this->request->is('post'))
        {

            $this->request->data['GiftsComment']['user_id'] = AuthComponent::user('id');
            $this->request->data['GiftsComment']['gifts_id'] = $this->request->data['GiftsComment']['gifts_id'];
            // $this->request->data['GiftsComment']['content'] = Sanitize::escape($this->request->data['GiftsComment']['content']) ;
            $this->request->data['GiftsComment']['content'] = Sanitize::clean($this->request->data['GiftsComment']['content']);
            // pr($this->request->data);die;
            $this->GiftComment->create();
            if ($this->GiftComment->save($this->request->data))
            {
                $this->Flash->success(__('The gifts Comment has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The gifts comment could not be saved. Please, try again.'));
        }
        // pr($sports);
    }

    /**
     * admin_showlinks method
     *
     * @param mixed      $conditions
     * @param null|mixed $order
     *
     * @return void
     */
    public function showlinks($conditions = [], $order = null)
    {
        // configure::write("debug",2);
        $this->layout = false;
        $conditions = [];
        $conditions = $this->_getSearchConditions1();
        $this->index($conditions, 'Gift.id DESC', 3);

        if (@$_POST['ajaxpost'] == 'true')
        {
            $this->layout = false;
            if ($_REQUEST['type'] == 1 || $_REQUEST['type'] == '')
            {
                $this->render('/Gifts/ajax_view');
            }
            else
            {
                $this->render('/Gifts/ajax_view_cash');
            }
        }
    }

    /**
     * getTournamentsAjax method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function getTournamentsAjax($id = null)
    {
        $this->loadModel('Tournament');
        $this->layout = false;
        $this->autoRender = false;
        if ($id == '0')
        {
            $options = $this->Tournament->find('list', [
                'conditions' => [
                    'Tournament.status' => 1,
                    'Tournament.is_deleted' => 0
                ],
                'order' => 'Tournament.name'
            ]);
            $options[0] = 'All';
            echo $this->View->Form->input('Gift.tournament_id', [
                'class' => 'form-control',
                'label' => false,
                'default' => '0',
                'empty' => '-- select tournament --',
                'options' => $options,
                'onchange' => 'getLeagues(this);'
            ]);
        }
        else
        {
            $options = $this->Tournament->find('list', [
                'conditions' => [
                    'Tournament.sport_id' => $id,
                    'Tournament.status' => 1,
                    'Tournament.is_deleted' => 0
                ],
                'order' => 'Tournament.name'
            ]);
            $options[0] = 'All';
            echo $this->View->Form->input('Gift.tournament_id', [
                'class' => 'form-control',
                'label' => false,
                'empty' => '-- select tournament --',
                'options' => $options,
                'onchange' => 'getLeagues(this);'
            ]);
        }
    }

    /**
     * getLeaguesAjax method
     *
     * @param null|mixed $id
     *
     * @return void
     */
    public function getLeaguesAjax($id = null)
    {
        $this->loadModel('League');
        $this->layout = false;
        $this->autoRender = false;
        if ($id == '0')
        {
            $options = $this->League->find('list', [
                'conditions' => [
                    'League.end_date >=' => date('Y-m-d h:i:s'),
                    'League.is_deleted' => 0
                ],
                'order' => 'League.name'
            ]);
            $options[0] = 'All';
            echo $this->View->Form->input('Gift.league_id', [
                'class' => 'form-control',
                'label' => false,
                'default' => '0',
                'empty' => '-- select league --',
                'options' => $options
            ]);
        }
        else
        {
            $options = $this->League->find('list', [
                'conditions' => [
                    'League.tournament_id' => $id,
                    'League.end_date >=' => date('Y-m-d h:i:s'),
                    'League.is_deleted' => 0
                ],
                'order' => 'League.name'
            ]);
            $options[0] = 'All';
            echo $this->View->Form->input('Gift.league_id', [
                'class' => 'form-control',
                'label' => false,
                'empty' => '-- select league --',
                'options' => $options
            ]);
        }
    }

    /**
     * addComment method
     *
     * @return void
     */
    public function admin_addLocation()
    {
        $this->autoRender = true;
        $this->loadModel('Location');

        if ($this->request->is('post'))
        {
            $this->Location->create();
            if ($this->Location->save($this->request->data))
            {
                $this->Flash->success(__('The location has been saved.'));
                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
    }

    /**
     * admin_searchGiftLocation method
     *
     * @param null|mixed $term
     *
     * @return void
     */
    public function admin_searchGiftLocation($term = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('Location');
        $term = isset($_REQUEST['term']) ? $_REQUEST['term'] : NULL;
        $userData = $this->Location->find('list', [
            'fields' => [
                'Location.id',
                'Location.name'
            ],
            'conditions' => [
                'Location.name LIKE' => '%' . $term . '%',
                'Location.status' => 1
            ]
        ]);
        if (! empty($userData))
        {
            echo json_encode($userData);
        }
        else
        {
            echo '{"":"Gift location not exists"}';
        }
    }

    /**
     * searchGiftLocation method
     *
     * @param null|mixed $term
     *
     * @return void
     */
    public function searchGiftLocation($term = null)
    {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('Location');
        $userData = $this->Location->find('list', [
            'fields' => [
                'Location.id',
                'Location.name'
            ],
            'conditions' => [
                'Location.name LIKE' => '%' . $_GET['term'] . '%',
                'Location.status' => 1
            ]
        ]);
        // $userData = Hash::extract($userData,'{n}.Location');
        if (! empty($userData))
        {
            echo json_encode($userData);
        }
        else
        {
            echo '{"":"Gift location not exists."}';
        }
    }

        public function admin_importData(){
        $result = 'success';
        Configure::write('debug', 1);
        App::import('Vendor', 'PHPExcel');
        $objPHPExcel = new PHPExcel();

        $giftObjects = array();
        $sports = $this->Game->Sport->find('list', [
            'order' => 'Sport.name'
        ]);

        $sport_keys = self::covertArray($sports);
        $tournaments = $this->Game->Tournament->find('list', [
            'conditions' => [
                // 'Tournament.sport_id' => $id,
                'Tournament.status' => 1,
                'Tournament.is_deleted' => 0
            ],
            'order' => 'Tournament.name',
            'fields' => [
                'Tournament.id',
                'Tournament.name',
                'Tournament.sport_id'
            ]
        ]);

        $leagues = $this->Game->League->find('list', [
            'conditions' => [
                // 'League.tournament_id' => $id,
                'League.end_date >=' => date('Y-m-d h:i:s'),
                'League.is_deleted' => 0
            ],
            'order' => 'League.name',
            'fields' => [
                'League.id',
                'League.name',
                'League.tournament_id'
            ]
        ]);
        $teams = $this->Game->Team->find('list', [
            'conditions' => [
                // 'Team.league_id' => $id,
                'Team.status' => 1,
                'Team.is_deleted' => 0
            ],
            'order' => 'Team.name',
            'fields' => [
                'Team.id',
                'Team.name',
                'Team.league_id'
            ]
        ]);


        $colIndexArr = array(
            'B' => 'sport_id',
            'C' => 'tournament_id',
            'D' => 'league_id',
            'E' => 'start_time',
            'F' => 'end_time',
            'G' => 'type',
            'H' => 'gift_category_id',
            'I' => 'teams_gameday',
            'J' => 'status',
            'K' => 'name',
            'L' => 'location_id',
            'M' => 'amount',
            'N' => 'product_link',
            'O' => 'winning_no_game'

        );

        $status_arr = array(
            'inactive' => 0,
            'active' => 1,
            );

         $gifttype_arr = array(
            'Gifts' => 1,
            'Cash Order' => 2,
            );

        $giftcategory_arr = array(
            'All' => 0,
            'Male' => 1,
            'Female' => 2,
            );

        if ($this->request->is('post') && isset($_FILES['csv_filename']))
        {
            $file_addr = $_FILES['csv_filename']['tmp_name'];
            $excelReader = PHPExcel_IOFactory::createReaderForFile($file_addr);
            $excelObj = $excelReader->load($file_addr);
            $worksheet = $excelObj->getSheet(0);
            $lastRow = $worksheet->getHighestRow();
            $lastCol = $worksheet->getHighestDataColumn();

            for ($row = 2; $row <= $lastRow; $row++) {
                $gift_item = array();
                $is_rowValid = true;
                $sport_id = $tournament_id = $league_id = $game_day = null;
                for ($col = 'B'; $col <= 'O'; $col++) {
                    $value = trim(strtolower($worksheet->getCell($col.$row)->getFormattedValue()));
                    if($col == 'B')
                    {
                        if(isset($sport_keys[$value]))
                        {
                            $sport_id = $sport_keys[$value];
                            $value = $sport_id;

                        }else{
                            $is_rowValid = false;
                        }
                    }
                    if($col == 'C')
                    {

                        if(!is_null($sport_id))
                        {

                            $tournament_keys = self::covertArray($tournaments[$sport_id]);
                            if(isset($tournament_keys[$value]))
                            {

                                $tournament_id = $tournament_keys[$value];
                                $value = $tournament_id;
                                $is_rowValid = true;
                            }else{
                                $is_rowValid = false;
                            }
                        }
                    }
                    if($col == 'D')
                    {
                        if(!is_null($tournament_id))
                        {
                            $league_keys = self::covertArray($leagues[$tournament_id]);
                            if(isset($league_keys[$value]))
                            {
                                $league_id = $league_keys[$value];
                                $value = $league_id;
                                $is_rowValid = true;
                            }else{
                                $is_rowValid = false;
                            }
                        }
                    }
                    if($col == 'E')
                    {
                        try{
                           if (new DateTime($value)){
                                $start_time = new DateTime($value);
                                $value = date_format($start_time, 'Y-m-d H:i:s');

                            }else{
                                $is_rowValid = false;
                            }
                        }
                        catch(Exception $e){
                            $is_rowValid = false;
                            break;
                        }
                    }
                    if($col == 'F')
                    {
                        try{
                           if (new DateTime($value)){
                                $end_time = new DateTime($value);
                                $value = date_format($end_time, 'Y-m-d H:i:s');
                            }else{
                                $is_rowValid = false;
                            }
                        }
                        catch(Exception $e){
                            break;
                        }
                    }
                       if($col == 'G')
                    {
                        $value = isset($gifttype_arr[$value])? $gifttype_arr[$value] : 1;
                    }
                    if($col == 'H')
                    {
                        $value = isset($giftcategory_arr[$value])? $giftcategory_arr[$value] : 0;
                    }
                    if($col == 'I')
                    {
                        $value = intval($value);
                    }
                    if($col == 'J')
                    {
                        $value = isset($status_arr[$value])? $status_arr[$value] : 1;
                    }


                           if($col == 'M')
                    {
                       $value = intval($value);
                    }

                    if($col == 'O')
                    {
                       $value = intval($value);
                    }
                    if(!$is_rowValid)
                        break;
                    $gift_item[$colIndexArr[$col]] = $value;

                }

                if($is_rowValid){
                    $giftObjects[] = $gift_item;
                }
            }
        }

        if(count($giftObjects))
        {

            $this->Gift->saveAll($giftObjects);
        }
        if (count($giftObjects))
        {
            $this->Flash->success(__(count($giftObjects).' row(s) are imported successfully.'));
        }
        else
            $this->Flash->error(__('Error occured. Please, try again.'));

        return $this->redirect([
            'action' => 'index'
        ]);
    }

        private function covertArray($arr){
        $result = array();
        foreach($arr as $key => $value)
        {
            $key1 = trim(strtolower($value));
            {
                $result[$key1] = $key;
            }
        }
        return $result;
    }


}
