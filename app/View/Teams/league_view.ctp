<section class="content-header">
	<h1><?php echo __dbt('View Team'); ?>
	  <small><?php echo __dbt('Team Details'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('Team Details'); ?></h3>
                          <a href="/league/teams" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
			</div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						<tr>
						  <td><?php echo __dbt('Team Name'); ?></td>
						  <td><?php echo h($team['Team']['name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Tournament'); ?></td>
						  <td><?php echo h($team['Tournament']['name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Team Admin'); ?></td>
                                                  <td><?php echo $this->Html->link($team['User']['name'], array('controller' => 'users', 'action' => 'view', base64_encode($team['User']['id']))); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Created'); ?></td>
						  <td><?php echo h($team['Team']['created']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Modified'); ?></td>
						  <td><?php echo h($team['Team']['modified']); ?></td>
						</tr>
				      </tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>

