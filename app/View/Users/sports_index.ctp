<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Users'); ?>
    <small>List Users</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li><?php echo $this->Html->link(__dbt('Users'), array('controller' => 'users', 'action' => 'index')); ?></li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
	<div class="box">
		<div class="box-header">
			<!-- filters starts-->
			<div class="UserAdminIndexForm">
				<div class="box-body">	
				   <div class="row">
					<?php echo $this->Form->create('User', array('type' => 'get', 'url' => array('controller' => 'users', 'action' => 'index', $this->params["prefix"] => true), "novalidate"=>"novalidate")); ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("User.name", array("label"=>false, "placeholder"=>"Search by name", "div"=>false,'class'=>"form-control"))."</div>"; ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("User.email", array("label"=>false, "placeholder"=>"Search by email", "div"=>false,'class'=>"form-control"))."</div>"; ?>  
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("User.role_id", array("type"=>"select", "empty"=>"--User Type--", "options"=>$roles, "label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("User.locale_id", array("type"=>"select", "empty"=>"--User Locale--", "options"=>$locales, "label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("User.gender", array("type"=>"select", "empty"=>"--All Gender--", "options"=>$gender, "label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("User.status", array("type"=>"select", "empty"=>"--All Status--", "options"=>$status, "label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?>
						<div class='col-xs-3 col-xs-offset-9 admin-search-btn'>
						  <input type="submit" class="btn bg-olive margin" value="Search">	
						  <a href="<?php echo $this->here; ?>" class="btn btn-warning" >Reset</a>
						</div>	
					<?php echo $this->Form->end(); ?>        
				   </div>
				</div>	   
			</div>
		</div>
		<div style="clear:both;"></div>
		<!-- filters ends-->
		<div class="box-body">
			<table id="example2" class="table table-striped">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('name'); ?></th>
						<th><?php echo $this->Paginator->sort('email'); ?></th>
						<th><?php echo $this->Paginator->sort('role_id'); ?></th>
						<th><?php echo $this->Paginator->sort('locale_id'); ?></th>
						<th><?php echo $this->Paginator->sort('status'); ?></th>
						<th class="actions"><?php echo __dbt('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $user): ?>
					<tr>
						<td><?php echo h($user['User']['title'].$user['User']['name']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
						<td><?php echo h($user['Role']['name']); ?></td>
						<td><?php echo h($user['Locale']['name']); ?></td>
						<td><?php echo h($user['User']['status_name']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__dbt(''), array('action' => 'view', base64_encode($user['User']['id'])),array('class'=>'fa fa-eye','title'=>'View User')); ?>
							<?php echo $this->Html->link(__dbt(''), array('action' => 'edit', base64_encode($user['User']['id'])),array('class'=>'fa fa-edit','title'=>'Edit User')); ?>
							<?php echo $this->Form->postLink(__dbt(''), array('action' => 'delete', base64_encode($user['User']['id'])),array('class'=>'fa fa-remove','title'=>'Delete User'), array(__dbt('Are you sure you want to delete this user ?'))); ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div class="row">
				<div class="col-sm-5">
					<div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
					</div>
				</div>
				<div class="col-sm-7">
					<?php
					echo $this->element('pagination',array('paging_action'=>$this->here));
					?>
				</div>
			</div>
		</div>
	</div>
    </div>
  </div>
</section>
