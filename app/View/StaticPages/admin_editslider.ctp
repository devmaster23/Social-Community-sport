<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<section class="content-header">
	<h1><?php echo __dbt('Edit Slider'); ?>
	  <small><?php echo __dbt('Admin Edit Slider'); ?></small>
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
                                    <?php echo $this->Form->input('id'); ?>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Title'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('title',array('class'=>'form-control','placeholder'=>'Enter Title','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Content'); ?></label>
						<div class="col-sm-5">
						<?php echo $this->Form->textarea('content',array('class'=>'form-control','placeholder'=>'Enter slider content','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
					<?php echo $this->Form->hidden('update_file_id',array("value"=>$slider['File']['id'])); ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Slider Image'); ?></label>
						<div class="col-sm-4">
                                                        <div class="image-preview">
                                                        <?php echo $this->Html->image(BASE_URL.'img/BannerImages/thumbnail/'.$slider['File']['new_name'],array("id"=>"ImageDiv",'escape'=>false,'style'=>'width:100%')); ?>
                                                        </div>
                                                        <div class="actin-div">
                                                        <?php echo $this->Html->link('<span>Change</span>','javascript:void(0)',array("id"=>"changeImage",'escape'=>false));?>
                                                        </div>
                                                        <?php echo $this->Form->input('file_id',array('type'=>'file','label'=>false,'div'=>false,'accept'=>array("image/*"),'style'=>'display:none','id'=>'ItemAttachment')); ?>
                                                    <span id="sizeError"></span>
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
						<?php $status_options = array("0"=>"Inactive", "1"=>"Active");
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
$(document).on('click','#changeImage',function(){
	$("#ItemAttachment").css('display','block');
	$("#changeImage").css('display','none');
	$("#ImageDiv").css('display','none');
	$('.image-preview').css('display','none');
	$('.actin-div').css('display','none');
});
</script>
<script>
    var _URL = window.URL || window.webkitURL;
$("#ItemAttachment").change(function (e) {
    var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function () {
            if((this.width <= 1359) || (this.height <= 679)) {
            $('#sizeError').html('<p style="color:red">Please upload image greater than 1360 (w) X 680 (h) dimension.</p>');
            //alert(this.width + " " + this.height);
            }
        };
        img.src = _URL.createObjectURL(file);
    }
});
    </script>
    
    <script>
      $(function () {
        CKEDITOR.replace('slider1');
      });
</script>