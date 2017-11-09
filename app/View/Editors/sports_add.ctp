<section class="content-header">
	<h1><?php echo __dbt('Add Blogger'); ?>
	  <small><?php echo __dbt('Add Sport Blogger'); ?></small>
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
				<?php echo $this->Form->create('User',array('class'=>'form-horizontal','autocomplete'=>"off")); ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Bloggers Name'); ?></label>
					<div class="col-sm-4">
					<?php echo $this->Form->select('id',$users,array('class'=>'form-control','label' => false,'empty'=>__dbt('-- Select Blogger --'))); ?>
					</div>
				</div>
				
				
				<div class="box-footer">
					<div class="col-sm-3 control-label">
					<?php echo $this->Form->submit(__dbt('Submit'),array('type' => 'submit','class'=>'btn btn-primary btn-flat','div'=>false)); ?>
					</div>
				</div>
				
			</div>
		</div>
	  </div>
	</div>
</section>