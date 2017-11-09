<section class="content-header">
	<h1><?php echo __dbt('Edit User'); ?>
	  <small><?php echo __dbt('League Edit User'); ?></small>
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
				<?php echo $this->Form->create('User', array("novalidate"=>"novalidate","class"=>"form-horizontal", "enctype"=>"multipart/form-data"));
					echo $this->Form->hidden('id'); ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Name'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Enter your name','label' => false)); ?>
						</div>
					</div>
					<?php echo $this->Form->hidden('update_file_id',array("value"=>$this->request->data['File']['id'])); ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Profile Image'); ?></label>
						<div class="col-sm-4">
							
							<?php if(!empty($this->request->data['File']['name'])){ ?>
                                                        <div class="image-preview">
                                                        <?php echo $this->Html->image(BASE_URL.'img/ProfileImages/large/'.$this->request->data['File']['new_name'],array("id"=>"ImageDiv",'escape'=>false)); ?>
                                                        </div>
                                                        <div class="actin-div">
                                                        <?php echo $this->Html->link('<span>Change</span>','javascript:void(0)',array("id"=>"changeImage",'escape'=>false));?>
                                                        </div>
                                                        <?php echo $this->Form->input('file_id',array('type'=>'file','label'=>false,'div'=>false,'accept'=>array("image/*"),'style'=>'display:none','id'=>'ItemAttachment')); ?>
                                                    <?php } else {
                                                        echo $this->Form->input("file_id", array('type'=>'file','label'=>false,'div'=>false,'accept'=>array("image/*")));  } ?>
						
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
						<?php echo $this->Form->input('role_id',array('class'=>'form-control','label' => false,'empty'=>'-- Select Role --')); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Locale'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('locale_id',array('class'=>'form-control','label' => false,'empty'=>'-- Select Language --')); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Gender'); ?></label>
						<div class="col-sm-4">
						<?php $gender_options = array(__dbt("Male"), __dbt("Female"));
						echo $this->Form->input('gender', array("type"=>"select",'class'=>'form-control','label' => false, "options"=>$gender_options,'empty'=>'-- Select Gender --')); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Gender'); ?></label>
						<div class="col-sm-4">
						<?php $status_options = array("Inactive", "Active", "Blocked");
						echo $this->Form->input('status', array("type"=>"select",'class'=>'form-control','label' => false, "options"=>$status_options,'empty'=>'-- Select Status --')); ?>
						</div>
					</div>	
					<div class="box-footer">
						<div class="col-sm-4 control-label">
						<?php echo $this->Form->submit('Submit',array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
						<a class="btn btn-warning margin" href="/league/users"><?php echo __dbt('Cancel'); ?></a>
                                                </div>
					</div>
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