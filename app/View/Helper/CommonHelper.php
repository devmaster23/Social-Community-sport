<?php

/* * *********************************************
  @Classname: Custom Helper
  @Description  : Custom Helper functions defined
  @Created Date : Feb 29 2016
 * ********************************************* */
App::uses('CakeTime', 'Utility');

class CommonHelper extends AppHelper {
    public $helpers = ['Session', 'Html'];

    public function getPridictedOrNot($gameId = null, $sport = null) {
        if ($sport == 'cricket') {
            $CricketPrediction = ClassRegistry::init('CricketPrediction');
            return $CricketPrediction->find('count', ['conditions' => ['CricketPrediction.user_id' => AuthComponent::User('id'), 'CricketPrediction.game_id' => $gameId]]);
        } else if ($sport == 'football') {
            $FootballPrediction = ClassRegistry::init('FootballPrediction');
            return $FootballPrediction->find('count', ['conditions' => ['FootballPrediction.user_id' => AuthComponent::User('id'), 'FootballPrediction.game_id' => $gameId]]);
        } else if ($sport == 'soccer') {
            $SoccerPrediction = ClassRegistry::init('SoccerPrediction');
            return $SoccerPrediction->find('count', ['conditions' => ['SoccerPrediction.user_id' => AuthComponent::User('id'), 'SoccerPrediction.game_id' => $gameId]]);
        } else if ($sport == 'hockey') {
            $HockeyPrediction = ClassRegistry::init('HockeyPrediction');
            return $HockeyPrediction->find('count', ['conditions' => ['HockeyPrediction.user_id' => AuthComponent::User('id'), 'HockeyPrediction.game_id' => $gameId]]);
        } else if ($sport == 'basketball') {
            $BasketballPrediction = ClassRegistry::init('BasketballPrediction');
            return $BasketballPrediction->find('count', ['conditions' => ['BasketballPrediction.user_id' => AuthComponent::User('id'), 'BasketballPrediction.game_id' => $gameId]]);
        } else if ($sport == 'baseball') {
            $BaseballPrediction = ClassRegistry::init('BaseballPrediction');
            return $BaseballPrediction->find('count', ['conditions' => ['BaseballPrediction.user_id' => AuthComponent::User('id'), 'BaseballPrediction.game_id' => $gameId]]);
        }
            return __dbt('No result found');

    }

    public function showName($id = null) {
        $this->UserObj = ClassRegistry::init('User');
        $userName = $this->UserObj->find('first', ['conditions' => ['User.id' => $id], 'fields' => ['User.name']]);
        if (!$this->UserObj->exists($id)) {
            $this->Flash->error(__dbt('Invalid user.'));
            return ['success' => 0, 'redirect' => false];
        }
        return __dbt($userName['User']['name']);
    }

    public function topNavSports($id = null) {
        $this->UserTeamObj = ClassRegistry::init('UserTeam');
        $getdate = new DateTime('15 days ago');
        $dateBefore = $getdate->format('Y-m-d h:i:s');
        $sports = $this->UserTeamObj->find('all', ['conditions' => ['UserTeam.status !=' => 0, 'UserTeam.user_id' => AuthComponent::user('id'), 'OR' => ['UserTeam.leave_date' => '0000-00-00 00:00:00', 'UserTeam.leave_date >=' => $dateBefore], 'AND' => ['OR' => ['UserTeam.request_date' => NULL, 'UserTeam.leave_date >=' => $dateBefore]]], 'fields' => ['Sport.id', 'Sport.name'], 'group'=>'Sport.name']);
        $sportArr = '';
        if (!empty($sports)) {
            foreach ($sports as $sport) {
                $sportArr .= '<li class="">' . $this->Html->link(__dbt($sport['Sport']['name'] . ' News'), ['controller' => 'Sports', 'action' => 'sport', $sport['Sport']['id']]) . '</li>';
            }
            $sportArr .= '<li class=""><a href="' . BASE_URL . '#sportTile">' . __dbt('News') . '</a></li>';
            return '<nav class="navbar navbar-default nav-ovryd">
                        <div class="container-fluid">
                          <div class="navbar-header">
                          <a class="navbar-brand" href="#"><h4 class="headernewsh3">News</h4></a>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                              <span class="sr-only">Toggle navigation</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                            </button>
                            
                          </div>
                          <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">' . $sportArr . '</ul>
                          </div><!--/.nav-collapse -->
                        </div><!--/.container-fluid -->
                    </nav>';
        }
            return '<nav class="navbar navbar-default nav-ovryd">
                           <div class="container-fluid">
                             <div class="navbar-header">
                               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                 <span class="sr-only">Toggle navigation</span>
                                 <span class="icon-bar"></span>
                                 <span class="icon-bar"></span>
                                 <span class="icon-bar"></span>
                               </button>
                               
                             </div>
                             <div id="navbar" class="navbar-collapse collapse">
                                <ul class="nav navbar-nav">
                                    <li class="active"><a href="' . BASE_URL . '#sportTile">' . __dbt('News') . '</a></li>
                                </ul>
                             </div><!--/.nav-collapse -->
                           </div><!--/.container-fluid -->
                       </nav>';

    }

    public function wordTruncate($text, $words) {
        $strText = '';
        if (!empty($text)) {
            if (count(explode(' ', $text)) > $words) {
                $arrText = array_slice(explode(' ', $text), 0, $words);
                $arrText = array_map('trim', $arrText);
                $arrText = array_filter($arrText);
                $strText = implode(' ', $arrText);
                $strText = $strText . '...';
            } else {
                $strText = $text;
            }
        }
        return $strText;
    }

    public function findNewsId($modelName = null, $field = [], $modelId = null) {
        //$this->loadModel($modelName);
        $this->$modelName = ClassRegistry::init($modelName);
        $data = $this->$modelName->find('first', ['conditions' => ["$modelName.news_id" => $modelId], 'fields' => $field]);
        return $data;
    }

}