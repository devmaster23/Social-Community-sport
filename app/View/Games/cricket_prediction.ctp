<style>

</style>
<div class="space-15">
    <?php echo $this->Form->create('CricketPrediction', array('url' => array('controller' => 'Games', 'action' => 'cricketPrediction'), "class" => "form-horizontal")); ?>
  
    <div class="row predicdion-box  after-radio" id="after_radio">
        
       <div class="col-xs-12 col-sm-6">
            <?php echo $this->Form->input('first_team_score', array('class' => 'inbox form-control','div' => false)); ?>
        </div>
        <div class="col-xs-12 col-sm-6">
            <?php echo $this->Form->input('second_team_score', array('class' => 'inbox form-control','div' => false)); ?>

            <?php echo $this->Form->input('sport_id', array('value' => $sportId, 'type' => 'hidden')); ?>
            <?php echo $this->Form->input('game_id', array('value' => $gameId, 'type' => 'hidden')); ?>
            <?php echo $this->Form->input('league_id', array('value' => $leagueId, 'type' => 'hidden')); ?>
            <?php echo $this->Form->input('tournament_id', array('value' => $tournamentId, 'type' => 'hidden')); ?>
        </div>
        <div class="col-lg-12" id="innhtmlhere"></div>

    </div>
      <div class="row predicdion-box before-radio" id="before_radio">
        <?php echo $this->element('sports/sport_prediction'); ?>
    </div>
    <div class="row predicdion-box before-radio" id="before_radio">      <div class="col-xs-12"><?php echo '&nbsp;' . $this->Form->submit(__dbt('Save Prediction'), array('type' => 'submit', 'class' => 'btn from-btn', 'div' => false)); ?>
</div>
                <div class="col-lg-12 text-right goback" style="margin-bottom:20px;"><?php echo __dbt("Go Back");?></div>
</div>
    <?php echo $this->Form->end(); ?>
</div>

<script>
    $("#CricketPredictionCricketPredictionForm").validate({
        rules: {
            "data[CricketPrediction][first_team_score]":
                    {
                        required: true,
                        digits: true,
                    },
            "data[CricketPrediction][second_team_score]":
                    {
                        required: true,
                        digits: true,
                    }
        },
        messages: {
            "data[CricketPrediction][first_team_score]":
                    {
                        required: "<?php echo __dbt('Please Enter Score.'); ?>",
                        digits: "<?php echo __dbt('Integers only.'); ?>",
                    },
            "data[CricketPrediction][second_team_score]":
                    {
                        required: "<?php echo __dbt('Please Enter Score.'); ?>",
                        digits: "<?php echo __dbt('Integers only.'); ?>",
                    }
        }
    });



</script>
<script type="text/javascript">
    //diable firebug

//        function getRate(){
//            document.getElementById("yahoo-rates").innerHTML = "<img src='/img/loader.gif'>";
//            from = document.getElementById('from').value;
//            to = document.getElementById('to').value;
//            $.post("<?php echo $this->Html->url(array("controller" => "games", "action" => "getCurrencyRate")); ?>",{'from':from,'to':to,'access_Token':'OO0OO0OO0O0O0O0O0OO0O'},function(data){
//                document.getElementById("yahoo-rates").innerHTML = data;
//                
//                $('.calcamount').each(function(){
//                    var amt = data*parseFloat($(this).data('amount'));
//                    $(this).html(amt);
//                });
//            });
//        }
</script>
