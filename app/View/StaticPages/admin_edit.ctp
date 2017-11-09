<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<section class="content-header">
	<h1><?php echo __dbt('Edit Page'); ?>
	  <small><?php echo __dbt('Admin Edit Static Page'); ?></small>
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
				<?php echo $this->Form->create('StaticPage',array('class'=>'form-horizontal', 'autocomplete'=>"off")); ?>
				<?php echo $this->Form->input('id'); ?>	
                                    <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Name'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Enter page name','label' => false, 'autocomplete'=>"off","readonly"=>"readonly")); ?>
						</div>
					</div>

                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Page Content'); ?></label>
						<div class="col-sm-9">
						<?php echo $this->Form->input('description',array('id'=> 'editor1','class'=>'form-control','placeholder'=>'Enter page description','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
					<div class="box-footer">
						<div class="col-sm-4 control-label">
						<?php echo $this->Form->submit('Update',array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
						<a class="btn btn-warning margin" href="/admin/staticPages"><?php echo __dbt('Cancel'); ?></a>
                                                </div>
					</div>
			        </div>
		</div>
	  </div>
	</div>
</section>
<script>
      $(function () {
        CKEDITOR.replace('editor1');
      });
</script>