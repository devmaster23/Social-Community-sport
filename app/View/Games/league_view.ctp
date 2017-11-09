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
                          <a href="/league/games" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
                        </div>
			<div class="box-body no-padding">
                            <table class="table table-striped">
                                <tbody>
                                        <tr>
                                          <td><?php echo __dbt('Tournament'); ?></td>
                                          <td><?php echo $this->Html->link($game['Tournament']['name'], array('controller' => 'tournaments', 'action' => 'view', base64_encode($game['Tournament']['id']))); ?></td>
                                        </tr>
                                        <tr>
                                          <td><?php echo __dbt('Sport'); ?></td>
                                          <td><?php echo $this->Html->link($game['Sport']['name'], array('controller' => 'sports', 'action' => 'view', base64_encode($game['Sport']['id']))); ?></td>
                                        </tr>
                                        <tr>
                                          <td><?php echo __dbt('First Team'); ?></td>
                                          <td><?php echo h($game['First_team']['name']); ?></td>
                                        </tr>
                                        <tr>
                                          <td><?php echo __dbt('Second Team'); ?></td>
                                          <td><?php echo h($game['Second_team']['name']); ?></td>
                                        </tr>
                                        <tr>
                                          <td><?php echo __dbt('Satrt Date'); ?></td>
                                          <td><?php echo h($game['Game']['start_time']); ?></td>
                                        </tr>
                                        <tr>
                                          <td><?php echo __dbt('End Date'); ?></td>
                                          <td><?php echo h($game['Game']['end_time']); ?></td>
                                        </tr>
                                        <tr>
                                          <td><?php echo __dbt('Status'); ?></td>
                                          <td><?php echo h($game['Game']['status_name']); ?></td>
                                        </tr>
                                        <tr>
                                          <td><?php echo __dbt('Is Deleted'); ?></td>
                                          <td><?php echo h($game['Game']['is_deleted']); ?></td>
                                        </tr>
                                        <tr>
                                          <td><?php echo __dbt('Created'); ?></td>
                                          <td><?php echo h($game['Game']['created']); ?></td>
                                        </tr>
                                        <tr>
                                          <td><?php echo __dbt('Modified'); ?></td>
                                          <td><?php echo h($game['Game']['modified']); ?></td>
                                        </tr>
                                </tbody>
                            </table>
			</div>
		</div>	
	  </div>
	 </div>
</section>	  	