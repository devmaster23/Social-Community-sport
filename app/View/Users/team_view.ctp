<section class="content-header">
	<h1><?php echo __dbt('View User'); ?>
	  <small><?php echo __dbt('View User Details'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('User Details'); ?></h3>
                          <a href="/team/users" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
			</div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						<tr>
						  <td><?php echo __dbt('Id'); ?></td>
						  <td><?php echo h($user['User']['id']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Name'); ?></td>
						  <td><?php echo h($user['User']['title'].$user['User']['name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Email'); ?></td>
						  <td><?php echo h($user['User']['email']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Role'); ?></td>
						  <td><?php echo $user['Role']['name']; //$this->Html->link($user['Role']['name'], array('controller' => 'roles', 'action' => 'view', $user['Role']['id'])); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Locale'); ?></td>
						  <td><?php echo $user['Locale']['name']; //$this->Html->link($user['Locale']['name'], array('controller' => 'locales', 'action' => 'view', $user['Locale']['id'])); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Social Api Id'); ?></td>
						  <td><?php echo h($user['User']['social_api_id']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Gender'); ?></td>
						  <td><?php echo h($user['User']['sex']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('File'); ?></td>
<td><?php if($user['File']['name']){echo $this->Html->image($user['File']['path'],array('style'=>'width:30%'));}else{echo $this->Html->image(DEFAULT_PROFILE_IMG,array('style'=>'width:30%'));} ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Status'); ?></td>
						  <td><?php echo h($user['User']['status_name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Created'); ?></td>
						  <td><?php echo h($user['User']['created']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Modified'); ?></td>
						  <td><?php echo h($user['User']['modified']); ?></td>
						</tr>
				      </tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>	  













