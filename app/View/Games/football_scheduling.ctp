<!-- MAIN CONTENT -->
<div class="main-wrap">
    <div class="container">
        <?php echo $this->Common->topNavSports(AuthComponent::User('id')); ?>
        <div class="profile-page-wrap">
            <div class="event-title">
                <h4><?php echo __dbt('Football Prediction'). ' - ' . $tournament_name; 
                 ?></h4>
                <span><?php echo $this->Html->link(__dbt("Download Schedule"), array('controller' => 'Games', 'action' => 'scheduleDownload'), array("style" => "float:right;color:#000000;font-size:14px;font-weight:bold;")); ?></span>
            </div>
            <!-- INNER WRAP -->
            <div class="inner-wrap">
                <div class="row">
                    <div class="col-sm-2">
                        <?php echo $this->element($elementFolder . '/sidebar'); ?>
                    </div>  
                        <!-- MIDDLE CONTENT -->
                     <div class="col-sm-10">
                        <div class="profile-form-layout">
                            <div class="table-responsive">
                            <?php if(!empty($maxgameddays)){?>
                            <span style="color:red; "><?php echo __dbt('Game Day') . ' - ' . $maxgameddays;?></span>  
                            <?php }
                            if(!empty($game_id))
                            {
                            echo '<span style="color:red; float:right; cursor:pointer;>'.$this->Html->link(__dbt('Show Prediction'), 'javascript:void(0)', array('class' => 'calcPrediction', 'gameDay' => $maxgameddays)).'</span>';
                             }
                            if (!empty($gameDatas)) {?>
                                              
                            <?php 
                            $minutes_to_add = 60; // 3hr before
                            $time = new DateTime($gameDatas[0]['Game']['start_time']);

                            $time->sub(new DateInterval('PT' . $minutes_to_add . 'M'));

                            $stopPrediction = $time->format('Y-m-d H:i:s');

                            $minutes_to_start = 72 * 60; // 72hr before
                            $time = new DateTime($gameDatas[0]['Game']['start_time']);
                            $time->sub(new DateInterval('PT' . $minutes_to_start . 'M'));
                            $startPrediction = $time->format('Y-m-d H:i:s');
                             
                            $cur_time = date('Y-m-d H:i:s');
                            if ($cur_time >= $startPrediction && $cur_time <= $stopPrediction && (empty($gift_id)))
                            {  
                            ?>
                            <span style="color:red; float:right; font-weight:14px;"><?php echo $this->Html->link(__dbt('Choose Gift'), 'javascript:void(0)', array('class' => 'setPrediction',  'leagueData' => $gameDatas[0]['League']['id'], 'tournamentData' => $gameDatas[0]['Tournament']['id'],'sportData' => $gameDatas[0]['Sport']['id'],'gameDay' => $gameDatas[0]['Game']['teams_gameday']));
                            ?></span>
                           <?php }
                            //elseif(!empty($game_id))
                           // {
                            //echo '<span style="color:red; float:right;>'.$this->Html->link(__dbt('Show Prediction'), 'javascript:void(0)', array('class' => 'calcPrediction', 'gameDay' => $gameDatas[0]['Game']['teams_gameday'])).'</span>';
                             //}
                            } 

                            ?>
                             
                            <?php 
                              
                            echo $this->Form->create('FootballPrediction', array('url' => array('controller' => 'Games', 'action' => 'footballPrediction'), "class" => "form-horizontal" )); 

                            ?>
                                <table border="0" class="table table-hover table-bordered table-striped" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th><?php echo __dbt('# Game'); ?></th>
                                        <th><?php echo $this->Paginator->sort('First_team.name', __dbt('First Team')); ?></th>
                                        <th><?php echo $this->Paginator->sort('Second_team.name', __dbt('Second Team')); ?></th>
                                        <th><?php echo $this->Paginator->sort('Game.start_time', __dbt('Start Time')); ?></th>
                                        <th><?php echo $this->Paginator->sort('Game.end_date', __dbt('End Time')); ?></th>
                                        <th><?php echo __dbt('Time Remaining For Prediction'); ?></th>
                                        <th class="text-center" width="12%" style="display:none;"><?php echo __dbt('Action'); ?></th>
                                    </tr>
                                   <?php if (!empty($gameDatas)) {
                                        
                                        $game_counter = 0;
                                        foreach ($gameDatas as $gameData)
                                        {
                                            $game_counter += 1;
                                            ?>
                                            <tr>
                                               <td><?php echo $game_counter; ?> </td>
                                                <td><?php echo __dbt($gameData['First_team']['name']); ?> <?php
                                                 if(!empty($gift_id) &&  empty($game_id)){ 
                                                 echo $this->Form->input("FootballPrediction.{$game_counter}.first_team_goals", array("type"=>"number","class"=>"form-control",'label' => false ,'min' =>'0')); 
                                                 }

                                                 ?></td>
                                                <td><?php echo __dbt($gameData['Second_team']['name']); ?> 
                                                <?php
                                                if(!empty($gift_id) && empty($game_id)){
                                                 echo $this->Form->input("FootballPrediction.{$game_counter}.second_team_goals", array("type"=>"number","class"=>"form-control",'label' => false ,'min' =>'0'));
                                                echo $this->Form->input("FootballPrediction.{$game_counter}.gift_id", array("type"=>"hidden",'data-field'=>'datetime',"class"=>"form-control","value" => "$gift_id",'label' => false)); 
                                                echo $this->Form->input("FootballPrediction.{$game_counter}.sport_id", array("type"=>"hidden",'data-field'=>'datetime',"class"=>"form-control","value" => 
                                                $gameData['Sport']['id'],'label' => false)); 
                                                echo $this->Form->input("FootballPrediction.{$game_counter}.tournament_id", array("type"=>"hidden",'data-field'=>'datetime',"class"=>"form-control","value" => $gameData['Tournament']['id'],'label' => false));
                                                echo $this->Form->input("FootballPrediction.{$game_counter}.league_id", array("type"=>"hidden",'data-field'=>'datetime',"class"=>"form-control","value" => $gameData['League']['id'],'label' => false));
                                                echo $this->Form->input("FootballPrediction.{$game_counter}.user_id", array("type"=>"hidden",'data-field'=>'datetime',"class"=>"form-control","value" => $user_id,'label' => false));
                                                echo $this->Form->input("FootballPrediction.{$game_counter}.game_day", array("type"=>"hidden",'data-field'=>'datetime',"class"=>"form-control","value" => $maxgameddays,'label' => false));
                                                echo $this->Form->input("FootballPrediction.{$game_counter}.game_id", array("type"=>"hidden",'data-field'=>'datetime',"class"=>"form-control","value" =>$gameData['Game']['id'],'label' => false));
                                                }
                                                ?></td>
                                                <td><?php echo $gameData['Game']['start_time']; ?></td>
                                                <td><?php echo $gameData['Game']['end_time']; ?></td>
                                                <td><?php
                       
                                                    $minutes_to_add = 60; // 3hr before
                                                    $time = new DateTime($gameData['Game']['start_time']);

                                                    $time->sub(new DateInterval('PT' . $minutes_to_add . 'M'));

                                                    $stopPrediction = $time->format('Y-m-d H:i:s');

                                                    $minutes_to_start = 72 * 60; // 72hr before
                                                    $time = new DateTime($gameData['Game']['start_time']);
                                                    $time->sub(new DateInterval('PT' . $minutes_to_start . 'M'));
                                                    $startPrediction = $time->format('Y-m-d H:i:s');
                                                     
                                                    $cur_time = date('Y-m-d H:i:s');
                                                    //print_r($cur_time);exit;
                                                    $page = $_SERVER['PHP_SELF'];
                                                    if (($cur_time < $startPrediction) || ($cur_time == $startPrediction)) {
                                                    
                                                        echo '<span style="color: rgb(166, 70, 134); margin-top: 10px;">Prediction not started yet</span>'; 

                                                    } else if ($cur_time >= $startPrediction && $cur_time <= $stopPrediction) {
                                                        $endtimeT = date("Y-m-d H:i:s", (strtotime($gameData['Game']['start_time'])+(3600*4)+(60*30)));
                                                         
                                                        echo '<span data-endtime="' . $endtimeT . '" class="recHere" style="color: rgb(166, 70, 134); margin-top: 10px;"></span>';
                                                    } else {
                                                        echo '<span style="color: rgb(166, 70, 134); margin-top: 10px;">Prediction time over</span>';
                                                    }
                                                    ?>

                                                </td>
                                           
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="6" class="text-center"><?php echo __dbt(' Games are not ready for prediction.'); ?> </td>
                                        </tr>    
                                    <?php } ?>
                                </table>

 <?php if(!empty($gift_id) &&  empty($game_id)){?>
                                <div class="col-sm-4 control-label">
                                <?php echo $this->Form->submit(__dbt('Submit'),array('type' => 'submit','class'=>'btn btn-primary','id' => 'confirmationbutton','div'=>false)); 

                                ?>
                            </div>

                             <?php } echo $this->Form->end(); ?>
                            </div>
                        </div>
                        <?php if($maxgameddays!==0){ ?>
                        <span style="float:left;"><?php echo $this->Html->link(__dbt('Previous'),'javascript:void(0)',array('class'=>'getpreviousdays',"onclick"=>"getpreviousdays($maxgameddays)")); ?></span>

                        <span style="float:right;"><?php echo $this->Html->link(__dbt('Next'),'javascript:void(0)',array('class'=>'getnextdays',"onclick"=>"getnextdays($maxgameddays)")); ?></span>
                        <?php }elseif($maxgameddays==0){ ?>
                        <span style="float:right;"><?php echo $this->Html->link(__dbt('Next'),'javascript:void(0)',array('class'=>'getnextdays',"onclick"=>"getnextdays($maxgameddays)")); ?></span>
                      <?php  } ?>

                    </div>
                    <!-- MIDDLE CONTENT END -->
                    </div> 
                 <div class="row">
                    <div class="col-lg-12">
                        <div class="pull-right">
                            <?php
                            if ($this->Paginator->param('pageCount') > 1) {
                                echo $this->element('front_pagination');
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>  
            <!-- INNER WRAP END -->
        </div>
        <!-- PROFILE PAGE EMD --> 
    </div>
</div>
<!-- MAIN CONTENT END -->


<<div class="bloger-modal">
    <div class="modal fade" id="showPrediction" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __dbt('Prediction Details'); ?></h4>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bloger-modal">
    <div class="modal fade" id="putPrediction" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __dbt('Set Your Prediction'); ?></h4>
                </div>
                <div class="modal-body1"></div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->create(null, array('url' => '/games/footballScheduling','id' => 'myform1')); ?>
<input type="hidden" id="id1" name="postid" value="" />
<input type="hidden" id="ids" name="postt" value="" />
<?php $this->Form->end(); ?>
<script>
function getpreviousdays(days){     
    $("#id1").val(days);
    $( "#myform1" ).submit();
} 
function getnextdays(nextdays)
{

     $("#ids").val(nextdays);
     $("#myform1").submit(); 
}
    $('.calcPrediction').click(function () {
       // var gameId = Base64.encode($(this).attr("dataGame"));
      //  var firstTeam = Base64.encode($(this).attr("firstTeam"));
       // var secondTeam = Base64.encode($(this).attr("secondTeam"));
          var gameDay = Base64.encode($(this).attr("gameDay"));
        $('.modal-body').load('/games/findFootballPrediction/' + gameDay, function (result) {
            $('.modal-body').html(result);
            $('#showPrediction').modal({show: true});
        });


    });


       $('.setPrediction').click(function () {
        var gameId = $(this).attr("gameData");
        var leagueId = $(this).attr("leagueData");
        var tournamentId = $(this).attr("tournamentData");
        var sportId = $(this).attr("sportData");
        var gameDay = $(this).attr("gameDay");
        var controllerName='footballScheduling';
        $('.modal-body1').load('/games/GamesGiftsPrediction/' + leagueId + '/' + tournamentId + '/' + sportId + '/' + gameDay + '/'+controllerName, function (result) {
            $('#putPrediction').modal({show: true});
        });


    });
</script>
<?php echo $this->Html->script('jquery.countdown'); ?>
<script>
     $('.recHere').each(function () {
        var pointer = $(this);
        var tim = $(this).data('endtime');

        $(this).countdown(tim).on('update.countdown', function (event) {
        
            if (event.elapsed) { // Either true or false
                pointer.html('-');
                 location.reload();
            } else {
              
               // pointer.html(event.offset.days + ' Days ' +event.offset.hours + ' Hours ' + event.offset.minutes + ' minutes ' + event.offset.seconds + ' seconds');
                pointer.html(event.offset.days + ' Days ' +event.offset.hours + ' Hours ' + event.offset.minutes + ' minutes ');
                $('.activefield').show();

            }
        }).on('finish.countdown', function (event) {
            if (event.elapsed) { // Either true or false
                 location.reload();
                // Counting up...
            } else {
                 
                // Countdown...
            }
        });
    });
</script>