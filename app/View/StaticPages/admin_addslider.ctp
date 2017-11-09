<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<section class="content-header">
	<h1><?php echo __dbt('Add Slider'); ?>
	  <small><?php echo __dbt('Admin Add Slider'); ?></small>
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
				<?php echo $this->Form->create('Slider',array('class'=>'form-horizontal', 'autocomplete'=>"off", "enctype"=>"multipart/form-data")); ?>
                                       <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Title'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('title',array('class'=>'form-control','placeholder'=>'Enter page name','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Content'); ?></label>
						<div class="col-sm-5">
						<?php echo $this->Form->textarea('content',array('class'=>'form-control','placeholder'=>'Enter slider content','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Slider Image'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('file_id',array('type'=>'file','label' => false,'accept'=>array("image/*"))); ?>
						</div>
					</div>
                                    
                                    <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Description'); ?></label>
						<div class="col-sm-9">
						<?php echo $this->Form->input('description',array('id'=> 'slider1','class'=>'form-control','placeholder'=>'Enter page description','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
                                    
                                    
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
						<div class="col-sm-4">
						<?php $status_options = array('1'=>"Active",'0'=>"Inactive");
						echo $this->Form->input('status', array("type"=>"select", "options"=>$status_options,"class"=>"form-control",'label' => false,'empty'=>'-- Select status --')); ?>
						</div>
					</div>
					
					<div class="box-footer">
						<div class="col-sm-4 control-label">
						<?php echo $this->Form->submit('Submit',array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
						<a class="btn btn-warning margin" href="/admin/staticPages/slider"><?php echo __dbt('Cancel'); ?></a>
                                                </div>
					</div>
			        </div>
		</div>
	  </div>
	</div>
</section>

<script>
      $(function () {
        CKEDITOR.replace('slider1');
      });
</script>