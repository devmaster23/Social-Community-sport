<div class="space-15">
    <?php echo $this->Form->create('SoccerPrediction', array('url' => array('controller' => 'Games', 'action' => 'soccerPrediction'), "class" => "form-horizontal")); ?>
    <div class="row predicdion-box before-radio" id="before_radio">
        <!--?php echo $this->element('sports/sport_prediction'); ?-->
    </div>
    <div class="row predicdion-box  after-radio" id="after_radio">
        <div class="col-lg-12 text-right goback" style="margin-bottom:20px;"><?php echo __dbt("Go Back");?></div>
        <div class="col-lg-12" id="innhtmlhere"></div>
        <div class="col-sm-6">
            <?php echo $this->Form->input('first_team_goals', array('class' => 'inbox form-control',)); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $this->Form->input('second_team_goals', array('class' => 'inbox form-control',)); ?>

        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

<?php echo $this->Form->end(); ?>

<script>
    $("#SoccerPredictionSoccerPredictionForm").validate({
        rules: {
            "data[SoccerPrediction][first_team_goals]": {
                required: true,
                digits: true,
            },
            "data[SoccerPrediction][second_team_goals]": {
                required: true,
                digits: true,
            }
        },
        messages: {
            "data[SoccerPrediction][first_team_goals]": {
                required: "<?php echo __dbt('Please Enter Score.'); ?>",
                digits: "<?php echo __dbt('Integers only.'); ?>",
            },
            "data[SoccerPrediction][second_team_goals]": {
                required: "<?php echo __dbt('Please Enter Score.'); ?>",
                digits: "<?php echo __dbt('Integers only.'); ?>",
            }
        }
    });
</script>
