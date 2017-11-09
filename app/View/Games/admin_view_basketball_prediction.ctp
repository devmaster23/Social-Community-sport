<section class="content-header">
	<h1><?php echo __dbt('Predictions'); ?>
	  <small><?php echo __dbt('View Basketball Predictions'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('Basketball Predictions Details'); ?></h3>
                          <a href="/admin/games/basketballPrediction" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
                        </div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
					    	
						<tr>
						  <td><?php echo __dbt('Predict By'); ?></td>
						  <td><?php echo h($basketball['User']['name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Tournament'); ?></td>
                                                  <td><?php echo $this->Html->link($basketball['Tournament']['name'], array('controller' => 'tournaments', 'action' => 'view', base64_encode($basketball['Tournament']['id']))); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Sport'); ?></td>
                                                  <td><?php echo $this->Html->link($basketball['Sport']['name'], array('controller' => 'sports', 'action' => 'view', base64_encode($basketball['Sport']['id']))); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('First Team Run'); ?></td>
						  <td><?php echo h($basketball['BasketballPrediction']['first_team_goals']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Second Team Run'); ?></td>
						  <td><?php echo h($basketball['BasketballPrediction']['second_team_goals']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Status'); ?></td>
						  <td><?php echo h($basketball['BasketballPrediction']['status']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Is Deleted'); ?></td>
						  <td><?php echo h($basketball['BasketballPrediction']['is_deleted']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Created'); ?></td>
						  <td><?php echo h($basketball['BasketballPrediction']['created']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Modified'); ?></td>
						  <td><?php echo h($basketball['BasketballPrediction']['modified']); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>	  	