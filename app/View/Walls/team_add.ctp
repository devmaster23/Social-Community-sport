<section class="content-header">
	<h1><?php echo __dbt('Team Wall'); ?>
	  <small><?php echo __dbt('Post Content on Team Wall'); ?></small>
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
				<?php echo $this->Form->create('WallContent',array('class'=>'form-horizontal', 'autocomplete'=>"off", "enctype"=>"multipart/form-data")); ?>
                                       
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Post Content'); ?></label>
						<div class="col-sm-5">
						<?php echo $this->Form->textarea('name',array('class'=>'form-control','placeholder'=>'Enter post content','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
                                    <div class="form-group">
                                                <label class="col-sm-2 control-label"></label>
						<div class="col-sm-5">
                                                    <p>-<?php echo _('OR'); ?>-</p>
						</div>
					</div>
                                    
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Post Image'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('file_id',array('type'=>'file','label' => false,'accept'=>array("image/*"))); ?>
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
						<?php echo $this->Form->submit(__dbt('Submit'),array('id'=>'submitPost','type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
						<a class="btn btn-warning margin" href="/team/walls/post"><?php echo __dbt('Cancel'); ?></a>
                                                </div>
					</div>
			        </div>
		</div>
	  </div>
	</div>
</section>
<script>
    $(document).ready(function(){
        $('#submitPost').click(function(){
            var contentVal = $('#WallContentName').val();
            if(contentVal.trim() == '' && ($('#WallContentFileId').val() == '')){
                alert('Please enter some text or upload image.');
            }
        });
    })
</script>
