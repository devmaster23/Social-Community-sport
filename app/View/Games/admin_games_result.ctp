<section class="content-header">
    <h1><?php echo __dbt('Game'); ?>
      <small><?php echo __dbt('Add Games Result'); ?></small>
    </h1>
     <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
    <div class="row">
    <div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <div class="UserAdminIndexForm">
            <div class="box-body">  
               <div class="row">
                 <?php echo $this->Form->create('Game',array('class'=>'form-horizontal','novalidate')); ?>
                            <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Sport'); ?></label>
                        <div class="col-sm-4">
                        <?php echo $this->Form->input('sport_id',array('class'=>'form-control','empty'=>__dbt('-- Select Sports --'),'label' => false, "onchange"=>"getTournaments(this);")); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Tournament'); ?></label>
                        <div class="col-sm-4" id="tournament-box">
                        <?php echo $this->Form->input('tournament_id',array('class'=>'form-control','empty'=>__dbt('--Select Tournament--'),'label' => false,"onchange"=>"getLeagues(this);")); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('League'); ?></label>
                        <div class="col-sm-4" id="league-box">
                        <?php echo $this->Form->input('league_id',array('class'=>'form-control','label' => false,'empty'=>__dbt('-- Select League --'),"onchange"=>"getTeams(this);")); ?>
                        </div>
                    </div>            
                         <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Game Day'); ?></label>
                        <div class="col-sm-4" id="gameday">
                            
                                                        <?php  
                                                        
                                                        echo $this->Form->input('teams_gameday', array("type"=>"select", "value"=>"0",'options' => array_combine(range(1,99,1),range(1,99,1)),
                                                        'empty' =>__dbt('-- Select Game Day --'),"class"=>"form-control",'label' => false));
                                                       
                                                        ?>
                                                

                        </div>
                    </div>
                        <div class='col-xs-3 col-xs-offset-2 admin-search-btn'>
                          <input type="submit" class="btn bg-olive margin" value="Search">  
                          <a href="<?php echo $this->here; ?>" class="btn btn-warning" ><?php echo __dbt("Reset"); ?></a>
                        </div>  
                <?php echo $this->Form->end(); ?>    
               </div>
               <div class="box-body">
                <?php 
echo $this->Form->create('GamesResult', array('url' => array('controller' => 'Games', 'action' => 'gamesResultAdd'), "class" => "form-horizontal" )); 
?>
            <table class="table table-striped">
                <thead>
                    <tr>
                                            <th><?php echo $this->Paginator->sort('tournament_id'); ?></th>
                                            <th><?php echo $this->Paginator->sort('sport_id'); ?></th>
                                            <th><?php echo $this->Paginator->sort('first_team'); ?></th>
                                            <th><?php echo $this->Paginator->sort('second_team'); ?></th>
                                            <th><?php echo $this->Paginator->sort('start_time'); ?></th>
                                            <th><?php echo $this->Paginator->sort('end_time'); ?></th>
                                           
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($gamedata)) {
                                 $game_counter = 0;
                                    foreach ($gamedata as $game): $game_counter += 1;  ?>
                    <tr>
                        <td>
                            <?php echo $this->Html->link($game['Tournament']['name'], array('controller' => 'tournaments', 'action' => 'view', base64_encode($game['Tournament']['id']))); ?>
                        </td>
                        <td>
                            <?php echo $this->Html->link($game['Sport']['name'], array('controller' => 'sports', 'action' => 'view', base64_encode($game['Sport']['id']))); ?>
                        </td>
                        <td><?php echo h($game['First_team']['name']); ?>&nbsp;<?php
                                                
                                                 echo $this->Form->input("GamesResult.{$game_counter}.first_team_goals", array("type"=>"number","class"=>"form-control",'label' => false, 'min' =>'0')); 
                                               

                                                 ?></td>
                        <td><?php echo h($game['Second_team']['name']); ?>&nbsp;<?php
                                
                                                 echo $this->Form->input("GamesResult.{$game_counter}.second_team_goals", array("type"=>"number","class"=>"form-control",'label' => false, 'min' =>'0'));

                                                  echo $this->Form->input("GamesResult.{$game_counter}.sport_id", array("type"=>"hidden","class"=>"form-control","value" => 
                                                $game['Sport']['id'],'label' => false));
                                                 echo $this->Form->input("GamesResult.{$game_counter}.league_id", array("type"=>"hidden","class"=>"form-control","value" => 
                                                $game['League']['id'],'label' => false));
                                                 echo $this->Form->input("GamesResult.{$game_counter}.tournament_id", array("type"=>"hidden","class"=>"form-control","value" => 
                                                $game['Tournament']['id'],'label' => false));
                                                 echo $this->Form->input("GamesResult.{$game_counter}.game_id", array("type"=>"hidden","class"=>"form-control","value" => 
                                                $game['Game']['id'],'label' => false));
                                                echo $this->Form->input("GamesResult.{$game_counter}.game_day", array("type"=>"hidden","class"=>"form-control","value" => 
                                                $game['Game']['teams_gameday'],'label' => false));?>
                                                 </td>
                        <td><?php echo h($game['Game']['start_time']); ?>&nbsp;</td>
                        <td><?php echo h($game['Game']['end_time']); ?>&nbsp;</td>
                       
                    </tr>
                     <?php endforeach;  ?>

                    <tr>    
                                        <td class="text-center" colspan="8"><?php echo $this->Form->submit(__dbt('Submit'),array('type' => 'submit','class'=>'btn btn-primary','id' => 'confirmationbutton','div'=>false)); ?>&nbsp;</td>
                    </tr>
                               
                                <?php }else { ?>
                                        <tr>    
                                        <td class="text-center" colspan="8"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
                    </tr>
                                <?php } ?>        
                </tbody>
                </table>
                       

                             <?php  echo $this->Form->end(); ?>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <?php //echo $this->element('pagination',array('paging_action'=>$this->here));?>
                    </div>
                </div>
            </div>     
            </div>
        </div>  
</section>


<script type="text/javascript">

      
    function getTournaments(obj){
    $('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"Games", "action"=>"getTournamentsAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){
        $('.admin-amzn-loader').hide();
            $("#tournament-box").html(data);
        });
    }
    
    function getLeagues(obj){
    $('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"Games", "action"=>"getLeaguesAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){
        $('.admin-amzn-loader').hide();
            $("#league-box").html(data);
        });        
    }
    
    function getTeams(obj){
    $('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"Games", "action"=>"getTeamsAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){
        $('.admin-amzn-loader').hide();
            $("#team-box").html(data);
        });        
    }
    
 
</script>
 