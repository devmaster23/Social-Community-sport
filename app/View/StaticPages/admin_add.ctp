<section class="content-header">
	<h1><?php echo __dbt('Add Page'); ?>
	  <small><?php echo __dbt('Admin Add Static Page'); ?></small>
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
				<?php echo $this->Form->create('StaticPage',array('class'=>'form-horizontal', 'novalidate')); ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Name'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Enter page name','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Page Slug'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('slug',array('class'=>'form-control','placeholder'=>'Enter page slug','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Page Content'); ?></label>
						<div class="col-sm-9">
						<?php echo $this->Form->input('description',array('id'=> 'editor1','class'=>'form-control','placeholder'=>'Enter page description','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
						<div class="col-sm-4">
							<?php $status_options = array("Inactive", "Active");
							echo $this->Form->input('status', array("type"=>"select", "options"=>$status_options,"empty"=>"-- Select Status --","class"=>"form-control",'label' => false)); ?>
                                                       
                                                </div>
					</div>
					<div class="box-footer">
						<div class="col-sm-4 control-label">
						<?php echo $this->Form->submit('Submit',array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
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
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
        //bootstrap WYSIHTML5 - text editor
       // $(".textarea").wysihtml5();
      });
</script>