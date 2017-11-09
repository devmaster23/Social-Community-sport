<!-- MAIN CONTENT -->
<div class="main-wrap">
    <div class="container">
        <?php echo $this->Common->topNavSports(AuthComponent::User('id')); ?>
        <div class="profile-page-wrap">

            <div class="event-title">
                <h4><?php echo __('Cricket Prediction'); ?></h4>
                <span><?php echo $this->Html->link(__("Download Schedule"),array('controller'=>'Games','action'=>'scheduleDownload'),array("style"=>"float:right;color:#000000;font-size:14px;font-weight:bold;"));?></span>
            </div>
            <!-- INNER WRAP -->
            <div class="inner-wrap">
                    <div class="row">
                    <!-- Sidebar start -->
                    <div class="col-sm-2">
                    <?php echo $this->element($elementFolder.'/sidebar'); ?>
                    </div>
                    <!-- MIDDLE CONTENT -->
                    <div class="col-sm-10">
                        <div class="profile-form-layout">
                            <div class="table-responsive">
                                    <table border="0" class="table table-hover table-bordered table-striped" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th><?php echo __('First Team');?></th>
                                        <th><?php echo __('Second Team');?></th>
                                        <th><?php echo __('Start Time');?></th>
                                        <th><?php echo __('End Time');?></th>
                                        <th><?php echo __('Time Remaining For Prediction');?></th>
                                        <th class="text-center" width="12%"><?php echo __('Action');?></th>
                                    </tr>
                                    <?php if(!empty($gameDatas)) { foreach($gameDatas as $gameData): ?>
                                    <tr>
                                        <td><?php echo $gameData['First_team']['name'];?> </td>
                                        <td><?php echo $gameData['Second_team']['name'];?> </td>
                                        <td><?php echo $gameData['Game']['start_time'];?></td>
                                        <td><?php echo $gameData['Game']['end_time'];?></td>

                                        <td><?php

                                            $minutes_to_add = 180; // 3hr before
                                            $time = new DateTime($gameData['Game']['start_time']);
                                            $time->sub(new DateInterval('PT' . $minutes_to_add . 'M'));
                                            $stopPrediction = $time->format('Y-m-d H:i:s');

                                            $t1 = StrToTime ($stopPrediction);
                                            $t2 = StrToTime (date('Y-m-d H:i:s') );
                                            $totalSeconds = $t1 - $t2;


                                            $days = floor($totalSeconds/(60*60*24));
                                            $hours = floor($totalSeconds / ( 60 * 60 ));
                                            $dateFormat = "d F Y -- g:i a";
                                            $duration = $hours; //in hours
                                            $targetDate = time() + (intval($duration)*60*60)+1;
                                            $actualDate = time();
                                            $secondsDiff = $t1 - $t2;
                                            $remainingDay     = floor($secondsDiff/60/60/24);
                                            $remainingHour    = floor(($secondsDiff-($remainingDay*60*60*24))/60/60);
                                            $remainingMinutes = floor(($secondsDiff-($remainingDay*60*60*24)-($remainingHour*60*60))/60);
                                            $remainingSeconds = floor(($secondsDiff-($remainingDay*60*60*24)-($remainingHour*60*60))-($remainingMinutes*60));
                                            $actualDateDisplay = date($dateFormat,$actualDate);
                                            $targetDateDisplay = date($dateFormat,$targetDate);
                                            if($hours >= 24) {

                                                   echo '<span style="color: rgb(166, 70, 134); margin-top: 10px;">00:00:00 </span>';
                                               } else {
                                                   echo '<span id="remain" style="color: rgb(166, 70, 134); margin-top: 10px;"></span>';
                                               }    

                                            ?>

                                        </td>
                                        <td class="text-center action-link">

                                            <?php $result = $this->Common->getPridictedOrNot($gameData['Game']['id'],$sport = 'cricket');

                                            if($result==0){
                                                if(($totalSeconds > 0) AND ($stopPrediction >= date('Y-m-d H:i:s')) AND ($hours <= 24)) {
                                                    echo $this->Html->link(__('Predict here'),'javascript:void(0)',array('class'=>'setPrediction','gameData'=>$gameData['Game']['id'],'leagueData'=>$gameData['League']['id'],'tournamentData'=>$gameData['Tournament']['id'],'sportData'=>$gameData['Sport']['id']));

                                                } else {
                                                        echo '<a href="javascript:void();" title=__("Prediction time over")><i class="fa fa-ban fa-fw"></i> </a>';
                                                       }
                                            } else {
                                                    echo $this->Html->link(__('Show Prediction'),'javascript:void(0)',array('class'=>'calcPrediction','dataGame'=>$gameData['Game']['id'],'firstTeam'=>$gameData['First_team']['name'],'secondTeam'=>$gameData['Second_team']['name']));   
                                            }?>

                                        </td>
                                    </tr>
                                    <?php endforeach; } else { ?>
                                     <tr>
                                        <td colspan="6" class="text-center"><?php echo __('Upcoming games are not ready for prediction.'); ?> </td>
                                     </tr>    
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- MIDDLE CONTENT END -->
                </div> 
            </div>  
            <!-- INNER WRAP END -->
        </div>
        <!-- PROFILE PAGE EMD --> 
                    </div>
</div>
<!-- MAIN CONTENT END -->
            
        
  
<div class="bloger-modal">
    <div class="modal fade" id="showPrediction" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?php echo __('Prediction Details'); ?></h4>
                    </div>
                    <div class="modal-body"></div>
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
                    <h4 class="modal-title"><?php echo __('Set Your Prediction'); ?></h4>
                </div>
                <div class="modal-body1"></div>
            </div>
        </div>
    </div>
</div>
<script>
$('.calcPrediction').click(function(){
	var gameId = Base64.encode($(this).attr("dataGame"));
	var firstTeam = Base64.encode($(this).attr("firstTeam"));
	var secondTeam = Base64.encode($(this).attr("secondTeam"));
    	$('.modal-body').load('/Games/findCricketPrediction/'+gameId +'/'+ firstTeam +'/'+ secondTeam,function(result){
	
        $('#showPrediction').modal({show:true});
	});
  
	
});

$('.setPrediction').click(function(){
	var gameId = $(this).attr("gameData");
	var leagueId = $(this).attr("leagueData");
	var tournamentId = $(this).attr("tournamentData");
	var sportId = $(this).attr("sportData");
  	$('.modal-body1').load('/Games/cricketPrediction/'+gameId +'/'+ leagueId +'/'+ tournamentId +'/'+ sportId,function(result){
	    $('#putPrediction').modal({show:true});
	});
  
	
});
</script>

<script type="text/javascript">
        var days = <?php echo $remainingDay; ?>  
        var hours = <?php echo $remainingHour; ?>  
        var minutes = <?php echo $remainingMinutes; ?>  
        var seconds = <?php echo $remainingSeconds; ?> 
        function setCountDown ()
        {
            seconds--;
            if (seconds < 0){
                minutes--;
                seconds = 59
            }
            if (minutes < 0){
                hours--;
                minutes = 59
            }
            if (hours < 0){
                days--;
                hours = 23
            }
            document.getElementById("remain").innerHTML = hours+":"+minutes+":"+seconds+" hours remaining";
            SD = window.setTimeout( "setCountDown()", 1000 );
            //if (hours == '00' && minutes == '00' && seconds == '00') { seconds = "00"; window.clearTimeout(SD);
            //    window.alert("Time is up. Press OK to continue.");
            //    document.getElementById("ExamAnswersForm").submit();
            //    
            //} 
        }
	$(document).ready(function(){
	    window.onload=setCountDown();
	});
    </script>
   