<section class="content-header">
	<h1><?php echo __dbt('League'); ?>
	  <small><?php echo __dbt('View League Details'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('League Details'); ?></h3>
                          <a href="javascript:window.history.back();" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
			</div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						<tr>
						  <td><?php echo __dbt('Name'); ?></td>
						  <td><?php echo h($league['League']['name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Tournament'); ?></td>
                                                  <td><?php echo $this->Html->link($league['Tournament']['name'], array('controller' => 'tournaments', 'action' => 'view', base64_encode($league['Tournament']['id']))); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Sport'); ?></td>
                                                  <td><?php echo $this->Html->link($league['Sport']['name'], array('controller' => 'sports', 'action' => 'view', base64_encode($league['Sport']['id']))); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('No Of Teams'); ?></td>
						  <td><?php echo h($league['League']['no_of_teams']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Start Date'); ?></td>
						  <td><?php echo h($league['League']['start_date']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('End Date'); ?></td>
						  <td><?php echo h($league['League']['end_date']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Host'); ?></td>
						  <td><?php echo h($league['League']['host']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('User'); ?></td>
						  <td><?php echo $this->Html->link($league['User']['name'], array('controller' => 'users', 'action' => 'view', base64_encode($league['User']['id']))); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Created'); ?></td>
						  <td><?php echo h($league['League']['created']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Modified'); ?></td>
						  <td><?php echo h($league['League']['modified']); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>	  	