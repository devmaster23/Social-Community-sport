<style>
    .rates-col a{
        color: #00a7d0;
        font-weight: bold;
    }
</style>
<!-- MAIN CONTENT -->
<div class="main-wrap">
    <div class="container">
        <?php echo $this->Common->topNavSports(AuthComponent::User('id')); ?>
        <div class="profile-page-wrap">

            <div class="event-title">
                <h4><?php echo __dbt('Cricket Prediction'); ?></h4>
                <span><?php echo $this->Html->link(__dbt("Download Schedule"), array('controller' => 'Games', 'action' => 'scheduleDownload'), array("style" => "float:right;color:#000000;font-size:14px;font-weight:bold;")); ?></span>
            </div>
            <!-- INNER WRAP -->
            <div class="inner-wrap">
                <div class="row">
                    <!-- Sidebar start -->
                    <div class="col-sm-2">
                        <?php echo $this->element($elementFolder . '/sidebar'); ?>
                    </div>
                    <!-- MIDDLE CONTENT -->
                    <div class="col-sm-10">
                        <div class="profile-form-layout">
                            <div class="table-responsive">
                                <table border="0" class="table table-hover table-bordered table-striped" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th><?php echo $this->Paginator->sort('First_team.name', __dbt('First Team')); ?></th>
                                        <th><?php echo $this->Paginator->sort('Second_team.name', __dbt('Second Team')); ?></th>
                                        <th><?php echo $this->Paginator->sort('Game.start_time', __dbt('Start Time')); ?></th>
                                        <th><?php echo $this->Paginator->sort('Game.end_date', __dbt('End Time')); ?></th>
                                        <th><?php echo __dbt('Time Remaining For Prediction'); ?></th>
                                        <th class="text-center" width="12%"><?php echo __dbt('Actions'); ?></th>
                                    </tr>
                                    <?php
                                    if (!empty($gameDatas)) {
                                        foreach ($gameDatas as $gameData):
                                            ?>

                                            <tr>
                                                <td><?php echo __dbt($gameData['First_team']['name']); ?> </td>
                                                <td><?php echo __dbt($gameData['Second_team']['name']); ?> </td>
                                                <td><?php echo $gameData['Game']['start_time']; ?></td>
                                                <td><?php echo $gameData['Game']['end_time']; ?></td>

                                                <td><?php
                                                    $minutes_to_add = 180; // 3hr before
                                                    $time = new DateTime($gameData['Game']['start_time']);

                                                    $time->sub(new DateInterval('PT' . $minutes_to_add . 'M'));
                                                    $stopPrediction = $time->format('Y-m-d H:i:s');

                                                    $minutes_to_start = 24 * 60; // 24hr before
                                                    $time = new DateTime($gameData['Game']['start_time']);
                                                    $time->sub(new DateInterval('PT' . $minutes_to_start . 'M'));
                                                    $startPrediction = $time->format('Y-m-d H:i:s');


                                                    $time = $gameData['Game']['start_time'];
                                                    $t1 = StrToTime($time);
                                                    $t2 = StrToTime(date('Y-m-d H:i:s'));
                                                    $totalSeconds = $t2 - $t1;
                                                    $days = floor($totalSeconds / (60 * 60 * 24));
                                                    $hours = floor($totalSeconds / ( 60 * 60 ));

                                                    $dateFormat = "d F Y -- g:i a";
                                                    $duration = $hours; //in hours
                                                    $targetDate = time() + (intval($duration) * 60 * 60) + 1;
                                                    $actualDate = time();
                                                    $secondsDiff = $t1 - $t2;
                                                    $remainingDay = floor($secondsDiff / 60 / 60 / 24);
                                                    $remainingHour = floor(($secondsDiff - ($remainingDay * 60 * 60 * 24)) / 60 / 60);
                                                    $remainingMinutes = floor(($secondsDiff - ($remainingDay * 60 * 60 * 24) - ($remainingHour * 60 * 60)) / 60);
                                                    $remainingSeconds = floor(($secondsDiff - ($remainingDay * 60 * 60 * 24) - ($remainingHour * 60 * 60)) - ($remainingMinutes * 60));
                                                    $actualDateDisplay = date($dateFormat, $actualDate);
                                                    $targetDateDisplay = date($dateFormat, $targetDate);


                                                    $cur_time = date('Y-m-d H:i:s');
                                                    if ($cur_time < $startPrediction) {

                                                        echo '<span style="color: rgb(166, 70, 134); margin-top: 10px;">Prediction not started yet</span>';
                                                    } else if ($cur_time >= $startPrediction && $cur_time <= $stopPrediction) {
                                                        $endtimeT = date("Y-m-d H:i:s", (strtotime($gameData['Game']['start_time']) - 3600 * 3));
                                                        echo '<span data-endtime="' . $endtimeT . '" class="recHere" style="color: rgb(166, 70, 134); margin-top: 10px;"></span>';
                                                    } else {
                                                        echo '<span style="color: rgb(166, 70, 134); margin-top: 10px;">Prediction time over</span>';
                                                    }
                                                    ?>

                                                </td>
                                                <td class="text-center action-link">

                                                    <?php
                                                    $result = $this->Common->getPridictedOrNot($gameData['Game']['id'], $sport = 'cricket');
                                                    if ($result == 0) {

                                                        if ($cur_time < $startPrediction) {

                                                            echo '<a href="javascript:void();" title="' . __dbt("Prediction time not started yet") . '"><i class="fa fa-ban fa-fw"></i> </a>';
                                                        } else if ($cur_time >= $startPrediction && $cur_time <= $stopPrediction) {
                                                            echo $this->Html->link(__dbt('Predict here'), 'javascript:void(0)', array('class' => 'setPrediction', 'gameData' => $gameData['Game']['id'], 'leagueData' => $gameData['League']['id'], 'tournamentData' => $gameData['Tournament']['id'], 'sportData' => $gameData['Sport']['id']));
                                                        } else {
                                                            echo '<a href="javascript:void();" title="' . __dbt("Prediction time over") . '"><i class="fa fa-ban fa-fw"></i> </a>';
                                                        }
                                                    } else {
                                                        echo $this->Html->link(__dbt('Show Prediction'), 'javascript:void(0)', array('class' => 'calcPrediction', 'dataGame' => $gameData['Game']['id'], 'firstTeam' => $gameData['First_team']['name'], 'secondTeam' => $gameData['Second_team']['name']));
                                                    }
                                                    ?>

                                                </td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="6" class="text-center"><?php echo __dbt('Upcoming games are not ready for prediction.'); ?> </td>
                                        </tr>    
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
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



<div class="bloger-modal">
    <div class="modal fade" id="showPrediction" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __dbt('Prediction Details'); ?></h4>
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
                    <h4 class="modal-title"><?php echo __dbt('Set Your Prediction'); ?></h4>
                </div>
                <div class="modal-body1"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.calcPrediction').click(function () {
        var gameId = Base64.encode($(this).attr("dataGame"));
        var firstTeam = Base64.encode($(this).attr("firstTeam"));
        var secondTeam = Base64.encode($(this).attr("secondTeam"));
        $('.modal-body').load('/Games/findCricketPrediction/' + gameId + '/' + firstTeam + '/' + secondTeam, function (result) {

            $('#showPrediction').modal({show: true});
        });


    });

    $('.setPrediction').click(function () {
        var gameId = $(this).attr("gameData");
        var leagueId = $(this).attr("leagueData");
        var tournamentId = $(this).attr("tournamentData");
        var sportId = $(this).attr("sportData");
        $('.modal-body1').load('/Games/cricketPrediction/' + gameId + '/' + leagueId + '/' + tournamentId + '/' + sportId, function (result) {
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
            } else {
                pointer.html(event.offset.hours + ' Hours ' + event.offset.minutes + ' minutes ' + event.offset.seconds + ' seconds');
            }
        }).on('finish.countdown', function (event) {
            if (event.elapsed) { // Either true or false
                // Counting up...
            } else {
                // Countdown...
            }
        });
    });
</script>