<section class="content-header">
	<h1><?php echo __dbt('Edit Translation'); ?>
	  <small><?php echo __dbt('Admin Edit Translation'); ?></small>
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
				<?php echo $this->Form->create($model,array('class'=>'form-horizontal', 'novalidate')); 
                                echo $this->Form->input('id');
                                ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Text'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('text',array('class'=>'form-control','placeholder'=>'Enter Text','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Description'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('translation',array('class'=>'form-control','placeholder'=>'Enter Text','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
					<div class="box-footer">
						<div class="col-sm-4 control-label">
						<?php echo $this->Form->submit('Submit',array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
						<a class="btn btn-warning margin" href="/admin/translations/index/<?php echo $model;?>"><?php echo __dbt('Cancel'); ?></a>
                                                </div>
					</div>
                                    <?php echo $this->Form->end();?>
			        </div>
		</div>
	  </div>
	</div>
</section>
<script>
    var model  = "<?php echo $model;?>";
    $("#<?php echo $model;?>AdminEditForm").validate({
        rules: {  
          "data[<?php echo $model;?>][text]": "required",
          "data[<?php echo $model;?>][translation]": "required"
          
        },
        messages: {
          "data[<?php echo $model;?>][text]": "<?php echo __dbt('Please add Text.')?>",
          "data[<?php echo $model;?>][translation]": "<?php echo __dbt('Please add Translation.')?>"
         
        }
      });
</script>