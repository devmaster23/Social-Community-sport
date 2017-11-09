<div class="space-15">
    <?php echo $this->Form->create('GamesResult', array('url' => array('controller' => 'games', 'action' => 'resultEdit'), "class" => "form-horizontal")); ?>
    <div class="row predicdion-box before-radio" id="before_radio">
        <?php echo $this->element('sports/sport_predictions_result'); ?>

    </div>
    
<?php echo $this->Form->end(); ?>
    
</div>





