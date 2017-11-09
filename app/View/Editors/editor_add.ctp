<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<div class="main-wrap">
   <div class="container">
      <div class="event-title">
            <h4><?php echo __dbt('Dashboard'); ?></h4>
      </div>  
      <!-- Inner wrap start -->
      <div class="inner-wrap">
          <div class="row">
          <!-- Sidebar start -->
          <div class="col-sm-2">
          <?php echo $this->element($elementFolder.'/sidebar'); ?>
          </div>

          <!-- Sidebar end -->
          <!-- Main content start -->
          <div class="col-sm-10">
          <div class="main-content">
            <div class="profile-form-layout">
<section class="content-header">
	<h1><?php echo __dbt('Add News'); ?></h1>
	 
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"></h3>
				</div>
				<div class="box-body">
				<?php echo $this->Form->create('News',array('class'=>'form-horizontal', 'autocomplete'=>"off", "enctype"=>"multipart/form-data")); 
                                $this->Form->inputDefaults(array( 'required' => false)); 
                                $sports_new_array = array();
                                foreach ($sports as $key => $value) {
                                    $sports_new_array[$key] = __dbt($value);
                                }
                                $status_new_array = array();
                                $status_options = array("Inactive", "Active");
                                foreach ($status_options as $key1 => $value1) {
                                    $status_new_array[$key1] = __dbt($value1);
                                }
                                ?>
                                    
                                    
                                        <div class="form-group">
						<label class="col-sm-3 col-md-2 control-label" for="inputEmail3"><?php echo __dbt('Sport'); ?></label>
						<div class="col-sm-9 col-md-4">
						<?php echo $this->Form->input('foreign_key',array("options"=>$sports_new_array,'class'=>'form-control','label' => false,'empty'=>__dbt('-- Select Sport --'))); ?>
						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-3 col-md-2 control-label" for="inputEmail3"><?php echo __dbt('Description'); ?></label>
						<div class="col-sm-9 col-md-8">
                                                    <?php echo $this->Form->textarea('description',array('id'=> 'editor1','class'=>'form-control','placeholder'=>__dbt('Enter news description'),'label' => false, 'autocomplete'=>"off")); ?>
                                                    <span id="emptyError" ></span>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 col-md-2 control-label" for="inputEmail3"><?php echo __dbt('News Image'); ?></label>
						<div class="col-sm-9 col-md-4">
						<?php echo $this->Form->input('file_id',array('type'=>'file','label' => false,'accept'=>array("image/*"))); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 col-md-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
						<div class="col-sm-9 col-md-4">
						<?php 
						echo $this->Form->input('status', array("type"=>"select", "options"=>$status_new_array,"class"=>"form-control",'label' => false,'empty'=>__dbt('-- Select status --'))); ?>
						</div>
					</div>
					<div class="form-group">
					<div class="box-footer">
					     <label class="col-sm-3 col-md-2">&nbsp;</label> 
						<div class="col-sm-9 col-md-4">
						<?php echo $this->Form->submit(__dbt('Submit'),array('type' => 'submit','class'=>'btn btn-primary pospad','div'=>false,'id'=>'submitPoll')); ?>
						<a class="btn btn-warning margin pospad" href="/editor/editors"><?php echo __dbt('Cancel'); ?></a>
                                                </div>
					</div>
					</div>
			        </div>
		</div>
	  </div>
	</div>
</section>
               </div>
            </div>
                   

                   
            </div>
            </div>
          <!-- Main content end -->
        
      </div> 
      </div>  
      <!-- Inner wrap end -->
   </div>
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