<section class="content-header">
	<h1><?php echo __dbt('Predictions'); ?>
	  <small><?php echo __dbt('View Football Predictions'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('Football Predictions Details'); ?></h3>
                          <a href="/admin/games/footballPrediction" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
                        </div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
					    	
						<tr>
						  <td><?php echo __dbt('Predict By'); ?></td>
						  <td><?php echo h($football['User']['name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Tournament'); ?></td>
                                                  <td><?php echo $this->Html->link($football['Tournament']['name'], array('controller' => 'tournaments', 'action' => 'view', base64_encode($football['Tournament']['id']))); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Sport'); ?></td>
                                                  <td><?php echo $this->Html->link($football['Sport']['name'], array('controller' => 'sports', 'action' => 'view', base64_encode($football['Sport']['id']))); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('First Team Run'); ?></td>
						  <td><?php echo h($football['FootballPrediction']['first_team_goals']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Second Team Run'); ?></td>
						  <td><?php echo h($football['FootballPrediction']['second_team_goals']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Status'); ?></td>
						  <td><?php echo h($football['FootballPrediction']['status']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Is Deleted'); ?></td>
						  <td><?php echo h($football['FootballPrediction']['is_deleted']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Created'); ?></td>
						  <td><?php echo h($football['FootballPrediction']['created']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Modified'); ?></td>
						  <td><?php echo h($football['FootballPrediction']['modified']); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>	  	