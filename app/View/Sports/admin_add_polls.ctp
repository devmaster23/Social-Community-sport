<section class="content-header">
	<h1><?php echo __dbt('Add Poll'); ?>
	  <small><?php echo __dbt('Admin Add Poll'); ?></small>
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
						<label class="col-sm-2 control-label" ><?php echo __dbt('Poll'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>__dbt('Enter poll question'),'label' => false, 'autocomplete'=>"off")); ?>
                                                <span class="error"></span>
                                                </div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" ><?php echo __dbt('Option 1'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('options.',array('id'=>'option1','class'=>'form-control','placeholder'=>__dbt('Enter option 1'),'label' => false, 'autocomplete'=>"off")); ?>
						<span class="error"></span>
                                                </div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" ><?php echo __dbt('Option 2'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('options.',array('id'=>'option2','class'=>'form-control','placeholder'=>__dbt('Enter option 2'),'label' => false, 'autocomplete'=>"off")); ?>
						<span class="error"></span>
                                                </div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" ><?php echo __dbt('Option 3'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('options.',array('id'=>'option3','class'=>'form-control','placeholder'=>__dbt('Enter option 3'),'label' => false, 'autocomplete'=>"off")); ?>
						<span class="error"></span>
                                                </div>
					</div>
                                        <div class="form-group">
                                                    <label class="col-sm-2 control-label" ><?php echo __dbt('Option 4'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('options.',array('id'=>'option4','class'=>'form-control','placeholder'=>__dbt('Enter option 4'),'label' => false, 'autocomplete'=>"off")); ?>
						<span class="error"></span>
                                                </div>
					</div>
                                        <div class="form-group">
                                                    <label class="col-sm-2 control-label" ><?php echo __dbt('Poll Answer'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('answer',array('class'=>'form-control','placeholder'=>__dbt('Enter poll answer'),'label' => false, 'autocomplete'=>"off")); ?>
						<span class="error"></span>
                                                </div>
					</div>
                                        <div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
							<div class="col-sm-4" id="tournament-box">
								<?php $status_options = array(1=>"Active",0=>"Inactive");
									echo $this->Form->input('status', array("type"=>"select", "options"=>$status_options,"class"=>"form-control",'label' => false,"empty"=>"Select Status"));  ?>
							<span class="error"></span>
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
$(document).ready(function(){
    $('#submitPoll').on('click',function(){
        $('.error').html('');
        var valid = true;
        if($('#PollName').val()=="")
        {
            $('#PollName').parent().next().html('Please enter poll.');
            valid = false;
        } 

        if($('#option1').val()=="")
        { $('#option1').parent().next().html('Please enter option.');
            valid = false;
        }
        if($('#option2').val()=="")
        { $('#option2').parent().next().html('Please enter option.');
            valid = false;
        }
        if($('#option3').val()=="")
        { $('#option3').parent().next().html('Please enter option.');
            valid = false;
        }
        if($('#option4').val()=="")
        { $('#option4').parent().next().html('Please enter option.');
            valid = false;
        }
        if($('#PollAnswer').val()=="")
        { $('#PollAnswer').parent().next().html('Please enter option.');
            valid = false;
        }
        if($('#PollStatus').val()=="")
        { $('#PollStatus').parent().next().html('Please enter option.');
            valid = false;
        }
        
        if(($('#PollAnswer').val() != $('#option1').val()) && ($('#PollAnswer').val() != $('#option2').val()) && ($('#PollAnswer').val() != $('#option3').val()) && ($('#PollAnswer').val() != $('#option4').val())){
            $('#PollAnswer').parent().next().html('Poll anwser not mathched with any poll options.');
            valid = false;
        }
        return valid;
        
        
    });
});

</script>