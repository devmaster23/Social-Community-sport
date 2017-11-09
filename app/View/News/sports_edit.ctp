<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<section class="content-header">
	<h1><?php echo __dbt('Edit News'); ?>
	  <small><?php echo __dbt('Admin Edit News'); ?></small>
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
				<?php echo $this->Form->create('News',array('class'=>'form-horizontal', "enctype"=>"multipart/form-data")); ?>
					
					<?php echo $this->Form->hidden('id'); ?>
                                    
					
                                         <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Description'); ?></label>
						<div class="col-sm-8">
						<?php echo $this->Form->textarea('description',array('id'=> 'editor1','class'=>'form-control','placeholder'=>__dbt('Enter news description'),'label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('News Image'); ?></label>
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
					</div>
					
                                    <?php if($this->request->data['News']['publish']==0){?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
						<div class="col-sm-4">
						<?php $status_options = array("Inactive", "Active");
						echo $this->Form->input('status', array("type"=>"select",'class'=>'form-control','label' => false, "options"=>$status_options,'empty'=>'-- Select Status --')); ?>
						</div>
					</div>	
                                    <?php }?>
					<div class="box-footer">
						<div class="col-sm-4 control-label">
						<?php echo $this->Form->submit('Submit',array('type' => 'submit','class'=>'btn btn-primary','div'=>false,'id'=>'submitPoll')); ?>
						<a class="btn btn-warning margin" href="/admin/news"><?php echo __dbt('Cancel'); ?></a>
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
<script>
    $(function () {
        CKEDITOR.replace('editor1');
      });
      
    $(document).ready(function(){
    
   $('#submitPoll').on('click',function(){
        var valid = true;    
        $('#emptyError').html('');
        var textval = CKEDITOR.instances.editor1.document.getBody().getChild(0).getText().trim();
        if(textval=="")
        {
            $('#emptyError').html('<?php echo __dbt("Please enter description.");?>');
            valid = false;
        } 
        if(textval.length >= 255)
        {
            $('#emptyError').html('<?php echo __dbt("You can not enter more then 255 character.");?>');
            valid = false;
        } 
        
        return valid;
    });  
});

</script>