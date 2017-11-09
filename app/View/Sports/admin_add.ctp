<section class="content-header">
	<h1><?php echo __dbt('Add Sport'); ?>
	  <small><?php echo __dbt('Admin Add Sport'); ?></small>
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

				<?php echo $this->Form->create('Sport',array('class'=>'form-horizontal', 'autocomplete'=>"off", "enctype"=>"multipart/form-data")); ?>
						<label class="col-sm-2 control-label" ><?php echo __dbt('Name'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>__dbt('Enter sports name'),'label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
                                      
					<div class="form-group">
						<label class="col-sm-2 control-label" ><?php echo __dbt('Tile Image'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('tile_image',array('class'=>'','placeholder'=>__dbt('Enter tile image'),'label' => false, 'autocomplete'=>"off",'type'=>'file')); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><?php echo __dbt('Banner Image'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('banner_image',array('class'=>'','label' => false,'type'=>'file')); ?>
						</div>
					</div>  
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('User'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('user_id',array('class'=>'form-control','label' => false)); ?>
						</div>
					</div>
					<div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
							<div class="col-sm-4" id="tournament-box">
								<?php $status_options = array("Inactive", "Active");
									echo $this->Form->input('status', array("type"=>"select", "value"=>"1", "options"=>$status_options,"class"=>"form-control",'label' => false,"empty"=>__dbt("Select Status")));  ?>
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