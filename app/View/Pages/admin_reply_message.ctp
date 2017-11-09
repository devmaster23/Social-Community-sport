<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<section class="content-header">
	<h1><?php echo __dbt('Message Reply'); ?>
	  <small><?php echo __dbt('Admin Message Reply'); ?></small>
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
				<?php echo $this->Form->create('ContactUs',array('class'=>'form-horizontal', 'autocomplete'=>"off")); ?>
				<?php echo $this->Form->input('id'); ?>	
                                   
                                        <div class="form-group">
						<label class="col-sm-2 control-label"><?php echo __dbt('Reply To'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('email',array('class'=>'form-control','label' => false, 'autocomplete'=>"off","readonly"=>"readonly",'value'=>$message['ContactUs']['email'])); ?>
						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" ><?php echo __dbt('Query To Us'); ?></label>
						<div class="col-sm-4">
						<?php echo $message['ContactUs']['message']; ?>
						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label"><?php echo __dbt('Reply Message'); ?></label>
						<div class="col-sm-9">
						<?php echo $this->Form->textarea('reply',array('type'=>'textarea','id'=> 'editor1','class'=>'form-control','placeholder'=>'Enter reply message','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
					<div class="box-footer">
						<div class="col-sm-4 control-label">
						<?php echo $this->Form->submit('send',array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
						<a class="btn btn-warning margin" href="/admin/pages/contact"><?php echo ('Cancel'); ?></a>
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