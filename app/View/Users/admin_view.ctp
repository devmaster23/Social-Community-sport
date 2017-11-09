<section class="content-header">
	<h1><?php echo __dbt('View User'); ?>
	  <small><?php echo __dbt('Users Details'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('Users Details'); ?></h3>
			  <?php echo $this->Html->link(__dbt('Back'),'javascript:window.history.back();', array('class'=>'btn btn-warning pull-right','title'=>'Back to listing')); ?>
			  <?php echo $this->Html->link(__dbt('Mange Permissions'), array('controller'=>'userSections','action' => 'managePermissions', base64_encode($user['User']['id'])), array('class'=>'btn btn bg-olive margin','title'=>'Manage Permissions')); ?>
			</div>
                    
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
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
						  <td><?php echo $user['Locale']['name']; //$this->Html->link($user['Pocale']['name'], array('controller' => 'locales', 'action' => 'view', $user['Pocale']['id'])); ?></td>
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
						  <td><?php if($user['File']['new_name']){echo $this->Html->image(BASE_URL.'img/ProfileImages/large/'.$user['File']['new_name']);}else{echo $this->Html->image(DEFAULT_PROFILE_IMG);} ?></td>
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
