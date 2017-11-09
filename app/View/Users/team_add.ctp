<section class="content-header">
	<h1><?php echo __dbt('Add User'); ?>
	  <small><?php echo __dbt('Team Admin Add User'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
			</div>
			<div class="box-body">
				<?php echo $this->Form->create('User',array('class'=>'form-horizontal', "enctype"=>"multipart/form-data")); ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Name'); ?></label>
					<div class="col-sm-4">
					<?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Enter your name','label' => false)); ?>
					</div>
				</div>
				
				<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Profile Image'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('file_id',array('type'=>'file','label' => false,'accept'=>array("image/*"))); ?>
						</div>
					</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Email'); ?></label>
					<div class="col-sm-4">
					<?php echo $this->Form->input('email',array('class'=>'form-control','placeholder'=>'Enter your email','label' => false)); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Role'); ?></label>
					<div class="col-sm-4">
					<?php echo $this->Form->input('role_id',array('class'=>'form-control','label' => false,'empty' => '-- Select Role --')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Locale'); ?></label>
					<div class="col-sm-4">
					<?php echo $this->Form->input('locale_id',array('class'=>'form-control','label' => false,'empty' => '-- Select Language --')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Password'); ?></label>
					<div class="col-sm-4">
					<?php echo $this->Form->input('password',array('type'=>'password','class'=>'form-control','label' => false)); ?>
					</div>
				</div>

<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Confirm Password'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('confirm_password',array('type'=>'password','class'=>'form-control','label' => false, 'autocomplete'=>"off", 'value'=>'')); ?>
						</div>
					</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Gender'); ?></label>
					<div class="col-sm-4">
					<?php $gender_options = array(__dbt("Male"), __dbt("Female"));
					echo $this->Form->input('gender', array("type"=>"select", "options"=>$gender_options,"class"=>"form-control",'label' => false,'empty' => '-- Select Gender --')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
					<div class="col-sm-4">
					<?php $status_options = array("Inactive", "Active", "Blocked");
					echo $this->Form->input('status', array("type"=>"select", "options"=>$status_options,"class"=>"form-control",'label' => false,'value'=>'-1','empty' => '-- Select Status --')); ?>
					</div>
				</div>
				
				<div class="box-footer">
					<div class="col-sm-4 control-label">
					<?php echo $this->Form->submit('Submit',array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
					<a class="btn btn-warning margin" href="/team/users"><?php echo __dbt('Cancel'); ?></a>
                                        </div>
				</div>
				
			</div>
		</div>
	  </div>
	</div>
</section>
