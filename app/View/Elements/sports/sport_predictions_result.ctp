<span id="findscoreForm"></span>
<div class="col-sm-12">
<div class="col-sm-6">
<?php //print_r($dataExist);?>
  <label><?php echo $firstTeam;?></label>
    <?php
     echo $this->Form->input('first_team_goals', array('class' => 'form-control ','type'=>'number','value'=>$dataExist['GamesResult']['first_team_goals'],'label' => false,'min' =>'0' ));
    ?>
  
</div>
<div class="col-sm-6">
<label><?php echo $secondTeam;?></label>
<?php
     echo $this->Form->input('second_team_goals', array('class' => 'form-control ',"type"=>"number",'value'=>$dataExist['GamesResult']['second_team_goals'],'label' => false,'min' =>'0' ));
  
   echo $this->Form->input('game_id', array('value' => $dataExist['GamesResult']['game_id'], 'type' => 'hidden')); ?>

    <div class="clear"></div>
</div>
 <div class="box-footer">
            <div class="col-sm-12 control-label" style="text-align:center;padding-top:19px;">
            <?php echo $this->Form->submit(__dbt('Submit'),array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
            
            </div>
          </div>
</div>      

