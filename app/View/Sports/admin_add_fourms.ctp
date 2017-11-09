<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<section class="content-header">
	<h1><?php echo __dbt('Add Fourm'); ?>
	  <small><?php echo __dbt('Admin Add Fourm'); ?></small>
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

				<?php echo $this->Form->create('Poll',array('class'=>'form-horizontal', 'autocomplete'=>"off",'novalidate')); ?>
                                        <div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Select Language'); ?></label>
							<div class="col-sm-4" id="tournament-box">
								<?php 
                                                                $locale = array_map("ucwords", $locale);
									echo $this->Form->input('locale_id', array("type"=>"select","options"=>$locale,"class"=>"form-control",'label' => false,"empty"=>"Select Status"));  ?>
							
                                                        </div>
                                        </div>
                                    
                                        
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Fourm Content'); ?></label>
						<div class="col-sm-9">
						<?php echo $this->Form->textarea('name',array('id'=> 'editor1','class'=>'form-control','placeholder'=>__dbt('Enter fourm text'),'label' => false, 'autocomplete'=>"off")); ?>
                                                    <span id="emptyError" ></span>
                                                </div>
					</div>
                                        <div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
							<div class="col-sm-4" id="tournament-box">
								<?php $status_options = array(1=>"Active",0=>"Inactive");
									echo $this->Form->input('status', array("type"=>"select", "value"=>"1","options"=>$status_options,"class"=>"form-control",'label' => false,"empty"=>"Select Status"));  ?>
							<span id="errorcls"></span>
                                                        </div>
                                        </div>
					<div class="box-footer">
						<div class="col-sm-3 control-label">
						<?php echo $this->Form->submit(__dbt('Submit'),array('type' => 'submit','id'=>'submitPoll','class'=>'btn btn-primary btn-flat','div'=>false)); ?>
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
      
    $(document).ready(function(){
    
    $('#submitPoll').on('click',function(){
        var valid = true;    
        $('#emptyError').html('');
        var textval = CKEDITOR.instances.editor1.document.getBody().getChild(0).getText().trim();
        if(textval=="")
        {
            $('#emptyError').html('Please enter fourm text.');
            valid = false;
        } 
        if(textval.length >= 255)
        {
            $('#emptyError').html('You can not neter more then 255 character.');
            valid = false;
        } 
        if($('#PollStatus').val() == '')
        {
            
            $('#errorcls').html('Please select status.');
            valid = false;
        } 
        return valid;
    });
    
    
});

</script>