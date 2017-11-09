<section class="content-header">
	<h1><?php echo __dbt('Tournament'); ?>
	  <small><?php echo __dbt('Add Tournament'); ?></small>
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
				<?php echo $this->Form->create('Tournament',array('class'=>'form-horizontal','novalidate',"enctype"=>"multipart/form-data")); ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Tournament Name'); ?></label>
						<div class="col-sm-4">
							<?php echo $this->Form->input('name', array("class"=>"form-control",'label' => false)); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('File Upload'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('file_id',array('type'=>'file','label' => false,'accept'=>array("image/*"))); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Description'); ?></label>
						<div class="col-sm-4">
							<?php echo $this->Form->input('description', array("class"=>"form-control",'label' => false)); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
						<div class="col-sm-4">
							<?php $status_options = array("Inactive", "Active", "Archived");
							echo $this->Form->input('status', array("type"=>"select", "value"=>"1", "options"=>$status_options,"class"=>"form-control",'label' => false, "empty"=>"-- Select Status --"));?>
							
						</div>
					</div>
					<div class="box-footer">
						<div class="col-sm-4 control-label">
						<?php echo $this->Form->submit('Submit',array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
						<a class="btn btn-warning margin" href="/league/tournaments"><?php echo __dbt('Cancel'); ?></a>
                                                </div>
					</div>
					<?php echo $this->Form->end(); ?>



			</div>
		</div>
	  </div>
	</div>
</section>