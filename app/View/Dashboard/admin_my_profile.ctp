<section class="content-header">
	<h1><?php echo __dbt('Profile'); ?>
	  <small><?php echo __dbt('Admin Profile'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title"><?php echo __dbt('Admin Profile'); ?></h3>
			</div>
			<div class="box-body box-profile">
				<?php echo $this->Form->create('User', array("novalidate"=>"novalidate","class"=>"form-horizontal", "enctype"=>"multipart/form-data")); ?>
				<?php echo $this->Form->hidden('id');
                                      echo $this->Form->hidden('update_file_id',array('value'=>$this->request->data['File']['id']));
                                ?>
                               <div class="col-md-2">
				<div class="image-preview">
                                    <?php if(!empty($this->request->data['File']['name'])){ ?>
                                                        
					<?php echo $this->Html->image($this->request->data['File']['path'],array("alt"=>"profile image","id"=>"ImageDiv",'escape'=>false,'style'=>'width:80%',"class"=>"img-responsive profile-user-img")); ?><?php }else{
					 echo $this->Html->image(DEFAULT_PROFILE_IMG,array("alt"=>"profile image","id"=>"ImageDiv",'escape'=>false,'style'=>'width:80%',"class"=>"img-responsive profile-user-img"));
						} ?>
                                </div>
							 
					<div class="actin-div change-img-text">
					<?php echo $this->Html->link('<span>'.__dbt('Change').'</span>','javascript:void(0)',array("id"=>"changeImage",'escape'=>false));?>
					</div>
                                <?php echo $this->Form->input('file_id',array('type'=>'file','label'=>false,'div'=>false,'accept'=>array("image/*"),'style'=>'display:none','id'=>'ItemAttachment')); ?>
                               </div>
                                
                                <div class="col-md-5">
				<table class="table table-striped">
					<tbody>
						<tr>
						  <td><?php echo __dbt('Name'); ?></td>
						  <td><?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Enter your name','label' => false)); ?></td>
						</tr>
                                                <tr>
						  <td><?php echo __dbt('Gender'); ?></td>
						  <td><?php $gender_options = array("Male", "Female");
						echo $this->Form->input('gender', array("type"=>"select",'class'=>'form-control','label' => false, "options"=>$gender_options)); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Lang'); ?></td>
						  <td><?php echo $this->Form->input('locale_id',array('class'=>'form-control','label' => false)); ?></td>
						</tr>
						
				      </tbody>
				</table>
                               </div>
                                <div class="col-md-5">
                                <table class="table table-striped">
					<tbody>
						<tr>
						  <td><?php echo __dbt('Email'); ?></td>
						  <td><?php echo AuthComponent::user("email") ?></td>
						</tr>
				      </tbody>
				</table>
                                
                               </div>
                                <div class="box-footer">
                                    <div class="col-sm-3 control-label">
                                    <?php
                                    echo $this->Html->link(__dbt('Cancel'),'/admin/dashboard/index',['class' => 'btn btn-primary btn-flat btn-warning margin']);
                                    echo $this->Form->submit(__dbt('Submit'),array('type' => 'submit','class'=>'btn btn-primary bg-olive btn-flat','div'=>false)); ?>
                                    <?php echo $this->Form->end();?>
                                    </div>
                                </div>       
			</div>
		</div>	
	  </div>
	 </div>
</section>

<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title"><?php echo __dbt('Change Password'); ?></h3>
			</div>
			<div class="box-body box-profile">
                                <div class="col-md-12">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                     <?php echo $this->Form->create('Dashboard',array('url'=>array('controller'=>'dashboard','action'=>'changePassword'),'novalidate')); ?> 
                                        <table class="table table-striped">
                                                <tbody>
                                                        <tr>
                                                          <td><?php echo __dbt('Current Password'); ?></td>
                                                          <td><?php echo $this->Form->input('User.current_password',array('type'=>'password','class'=>'form-control','placeholder'=>'Enter current password','label' => false)); ?></td>
                                                        </tr>
                                                        <tr>
                                                          <td><?php echo __dbt('New Password'); ?></td>
                                                          <td><?php echo $this->Form->input('User.new_password',array('type'=>'password','class'=>'form-control','placeholder'=>'Enter new password','label' => false)); ?></td>
                                                        </tr>
                                                        <tr>
                                                          <td><?php echo __dbt('Re-enter Password'); ?></td>
                                                          <td><?php echo $this->Form->input('User.re_enter_password',array('type'=>'password','class'=>'form-control','placeholder'=>'Confirm your password','label' => false)); ?></td>
                                                        </tr>
                                                        
                                                </tbody>
                                        </table>
                                     
                                    <div class="box-footer">
					<div class="col-sm-3 control-label">
					<?php echo $this->Form->submit(__dbt('Change'),array('type' => 'submit','class'=>'btn btn-primary bg-olive btn-flat','div'=>false)); ?>
					</div>
				    </div>
                                    <?php echo $this->Form->end(); ?>
                                    </div>
                                    <div class="col-md-3"></div>
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