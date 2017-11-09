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
				<?php echo $this->Form->create('Tournament',array('class'=>'form-horizontal', "enctype"=>"multipart/form-data")); ?>
					<?php echo $this->Form->input('id'); ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Tournament Name'); ?></label>
						<div class="col-sm-4">
							<?php echo $this->Form->input('name', array("class"=>"form-control",'label' => false)); ?>
						</div>
					</div>
                                        <?php echo $this->Form->hidden('update_file_id',array("value"=>$this->request->data['File']['id'])); ?>
					<?php /*
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt(' File Upload'); ?></label>
						<div class="col-sm-4">
							
							<?php if(!empty($this->request->data['File']['name'])){ ?>
                                                        <div class="image-preview">
                                                        <?php echo $this->Html->image($this->request->data['File']['path'],array("id"=>"ImageDiv",'escape'=>false,'style'=>'width:50%')); ?>
                                                        </div>
                                                        <div class="actin-div">
                                                        <?php echo $this->Html->link('<span>Change</span>','javascript:void(0)',array("id"=>"changeImage",'escape'=>false));?>
                                                        </div>
                                                        <?php echo $this->Form->input('file_id',array('type'=>'file','label'=>false,'div'=>false,'accept'=>array("image/*"),'style'=>'display:none','id'=>'ItemAttachment')); ?>
                                                    <?php } else {
                                                        echo $this->Form->input("file_id", array('type'=>'file','label'=>false,'div'=>false,'accept'=>array("image/*")));  } ?>

						</div>
					</div> */?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Description'); ?></label>
						<div class="col-sm-4">
							<?php echo $this->Form->input('description', array("class"=>"form-control",'label' => false)); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
						<div class="col-sm-4">
							<?php $status_options = array("Inactive", "Active");
							echo $this->Form->input('status', array("type"=>"select","options"=>$status_options,"class"=>"form-control",'label' => false,"empty"=>"Select Status")); ?>
						</div>
					</div>
					<div class="box-footer">
						<div class="col-sm-4 control-label">
						<?php echo $this->Form->submit('Submit',array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
						<a class="btn btn-warning margin" href="/sports/tournaments"><?php echo __dbt('Cancel'); ?></a>
                                                </div>
					</div>
					<?php echo $this->Form->end(); ?>



			</div>
		</div>
	  </div>
	</div>
</section>
<script>
$(document).on('click','#changeImage',function(){
	$("#ItemAttachment").css('display','block');
	$("#changeImage").css('display','none');
	$("#ImageDiv").css('display','none');
	$('.image-preview').css('display','none');
	$('.actin-div').css('display','none');
});
</script>
