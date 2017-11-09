<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Predictions'); ?>
    <small><?php echo __dbt('Football Predictions'); ?></small>
  </h1>
  <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
  
</section>
<?php 

foreach($new as $football_option)
{
    $tournament[$football_option['Tournament']['id']]=$football_option['Tournament']['name'];
    $league[$football_option['League']['id']]=$football_option['League']['name'];
}

?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
	<div class="box">
		<div class="box-header">
		    <div class="UserAdminIndexForm">
			<div class="box-body">	
			   <div class="row">
			     <?php  echo $this->Form->create('FootballPrediction', array('type' => 'get', 'url' => array('controller' => 'games', 'action' => 'footballPrediction', $this->params["prefix"] => true), "novalidate"=>"novalidate")); ?>
					    <?php echo "<div class='col-xs-3'>". $this->Form->input("FootballPrediction.tournament_id", array("label"=>false, "placeholder"=>"Search by League", "div"=>false,'empty'=>'Select Tournament', 'options' => @$tournament,'class'=>"form-control"))."</div>"; ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("FootballPrediction.league_id", array("label"=>false, "div"=>false,'empty'=>'Select League', 'options' => @$league,"placeholder"=>"Search by Game",'class'=>"form-control"))."</div>"; ?>
					    
						<div class='col-xs-3 col-xs-offset-4 admin-search-btn'>
						  <input type="submit" class="btn bg-olive margin" value="Search">	
						  <a href="<?php echo $this->here; ?>" class="btn btn-warning" ><?php echo __dbt("Reset"); ?></a>
						</div>	
			    <?php echo $this->Form->end(); ?>    
			   </div>
			</div>	   
		    </div>
		</div>	
		<!-- filters starts-->
		<div class="box-body">
			<table class="table table-striped">
				<thead>
					<tr>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('tournament_id'); ?></th>
							<th><?php echo $this->Paginator->sort('league_id'); ?></th>
							<th><?php echo $this->Paginator->sort('first_team run'); ?></th>
							<th><?php echo $this->Paginator->sort('second_team run'); ?></th>
							<th class="actions"><?php echo __dbt('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($football)) {
                                    foreach ($football as $football): ?>
					<tr>
						<td><?php echo h($football['User']['name']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($football['Tournament']['name'], array('controller' => 'tournaments', 'action' => 'view', base64_encode($football['Tournament']['id']))); ?>
						</td>
						<td>
							<?php echo $this->Html->link($football['League']['name'], array('controller' => 'leagues', 'action' => 'view', base64_encode($football['League']['id']))); ?>
						</td>
						<td><?php echo h($football['FootballPrediction']['first_team_goals']); ?>&nbsp;</td>
						<td><?php echo h($football['FootballPrediction']['second_team_goals']); ?>&nbsp;</td>

						<td class="actions">
							<?php echo $this->Html->link(__dbt(''), array('action' => 'viewFootballPrediction', base64_encode($football['FootballPrediction']['id'])),array('class'=>'fa fa-eye','title'=>'View Game')); ?>
							<?php echo $this->Form->postLink(__dbt(''), array('action' => 'deleteFootballPrediction', base64_encode($football['FootballPrediction']['id'])),array('class'=>'fa fa-remove','title'=>'Delete Game'), array(__dbt('Are you sure you want to delete this prediction ?'))); ?>
                                                        <?php if($football['FootballPrediction']['winner'] == 1 ) {
                                                                echo $this->Form->postLink(__dbt(''), array('action' => 'predictionWinner', base64_encode($football['FootballPrediction']['id']),'FootballPrediction'),array('class'=>'fa fa-trophy','title'=>'Prediction Winner'));
                                                           } else {
                                                            echo $this->Form->postLink(__dbt(''), array('action' => 'predictionWinner', base64_encode($football['FootballPrediction']['id']),'FootballPrediction'),array('class'=>'fa fa-check-circle-o','title'=>'set Winner'), array(__dbt('Are you sure you want to declare a user prediction winner ?')));
                                                             } ?>
                                                </td>
					</tr>
                                <?php endforeach; } else { ?>
                                        <tr>    
                                        <td class="text-center" colspan="6"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
					</tr>
                                <?php } ?>        
				</tbody>
				</table>
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
  </div>
</section>
	
	
