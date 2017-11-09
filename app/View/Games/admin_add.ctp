<section class="content-header">
	<h1><?php echo __dbt('Game'); ?>
	  <small><?php echo __dbt('Add Game Schedule'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>
				<a class="btn btn-success margin pull-right" href="#import_data_modal" data-toggle="modal" class="config"><?php echo __dbt('Import CSV'); ?></a>
			</div>
			<div class="box-body">
							
                                <?php echo $this->Form->create('Game',array('class'=>'form-horizontal','novalidate')); ?>
                            <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Sport'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('sport_id',array('class'=>'form-control','empty'=>__dbt('-- Select Sports --'),'label' => false, "onchange"=>"getTournaments(this);")); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Tournament'); ?></label>
						<div class="col-sm-4" id="tournament-box">
						<?php echo $this->Form->input('tournament_id',array('class'=>'form-control','empty'=>__dbt('--Select Tournament--'),'label' => false,"onchange"=>"getLeagues(this);")); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('League'); ?></label>
						<div class="col-sm-4" id="league-box">
						<?php echo $this->Form->input('league_id',array('class'=>'form-control','label' => false,'empty'=>__dbt('-- Select League --'),"onchange"=>"getTeams(this);")); ?>
						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Start Time'); ?></label>
						<div class="col-sm-4">
                                                        <?php echo $this->Form->input('start_time', array("type"=>"text",'data-field'=>'datetime',"class"=>"form-control",'label' => false));  ?>

						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('End Time'); ?></label>
						<div class="col-sm-4">
                                                        <?php echo $this->Form->input('end_time', array("type"=>"text",'data-field'=>'datetime',"class"=>"form-control",'label' => false));  ?>

						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('First Team'); ?></label>
						<div class="col-sm-4" id="team-box">
                                                  <?php echo $this->Form->input('first_team', array("type"=>"select", "value"=>"0",'empty' =>__dbt('-- Select Team --'),"class"=>"form-control",'label' => false,"onchange"=>"getTeamsFilter(this);"));?>
     
                                                </div>
					</div>
                        <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Second Team'); ?></label>
						<div class="col-sm-4" id="team2-box">
							
                                                        <?php   echo $this->Form->input('second_team', array("type"=>"select", "value"=>"0",'empty' =>__dbt('-- Select Team --'),"class"=>"form-control",'label' => false));?>
                                                

						</div>
					</div>
					 <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Game Day'); ?></label>
						<div class="col-sm-4" id="gameday">
							
                                                        <?php  
                                                        
                                                        echo $this->Form->input('teams_gameday', array("type"=>"select", "value"=>"0",'options' => array_combine(range(1,99,1),range(1,99,1)),
                                                        'empty' =>__dbt('-- Select Game Day --'),"class"=>"form-control",'label' => false));
                                                       
                                                        ?>
                                                

						</div>
					</div>
                       <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
						<div class="col-sm-4">
							<?php $status_options = array("Inactive", "Active");
							echo $this->Form->input('status', array("type"=>"select", "value"=>"1", "options"=>$status_options,"empty"=>__dbt("-- Select Status --"),"class"=>"form-control",'label' => false)); ?>
                                                       
                       </div>
					</div>
					<div class="box-footer">
						<div class="col-sm-4 control-label">
						<?php echo $this->Form->submit(__dbt('Submit'),array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
						<a class="btn btn-warning margin" href="/admin/games"><?php echo __dbt('Cancel'); ?></a>
                                                </div>
					</div>
                            <input type="hidden" name="stdate" id="stdate">
                            <input type="hidden" name="enddate" id="enddate">
					<?php echo $this->Form->end(); ?>
					<div class="loader-cntnt admin-amzn-loader" style="display:none;">
				<img src="/img/loading.gif" class="loader-cntnt-loader">
				</div>
			</div>
		</div>
	  </div>
	</div>
</section>

<div class="modal fade" id="import_data_modal" tabindex="-1" role="dialog" aria-labelledby="import_data_modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Import Game List</h4>
			</div>
			<form action="/admin/games/importData" enctype='multipart/form-data' id="import_data_form" method="post" class="form-horizontal" >
			<div class="modal-body">
					<div class="form-body">
						<div class="form-group">
							<p class="col-md-12">Select CSV file to be imported!!</p>
						</div>
						<div class="alert alert-danger display-hide">
							<button class="close" data-close="alert"></button>
							Please select file to be imported(CSV file).
						</div>
						<div class="alert alert-success display-hide">
							<button class="close" data-close="alert"></button>
							Your form validation is successful!
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" for="csv_filename" required>File Name</label>
							<div class="col-md-4" style="margin-top:10px;">
								<input type="file" name="csv_filename" accept=".xls">
							</div>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn blue">Import</button>
				<button type="button" class="btn default" data-dismiss="modal">Close</button>
			</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div id="dtBox1"></div><!-- this div used for date picker  -->

<script type="text/javascript">
$(document).ready(function(){
	$("#dtBox1").DateTimePicker({					
		dateTimeFormat: "yyyy-MM-dd hh:mm:ss"			
	});
        
        $(document).on('change','#GameLeagueId',function(){
            var league_id = $(this).val();
            $.ajax({
                url:"/games/checkleaguedate",
                method:"POST",
                data:{league_id:league_id},
                success:function(result){
                    console.log(result);
                    result = result.split("###");
                    var stdate = result[0];
                    var enddate = result[1];
                    $("#stdate").val(stdate);
                    $("#enddate").val(enddate);
                }
            });
        });
    });

    $(document).on('submit','#import_data_form',function(e){
    	var alert = $(this).find('.alert-danger');
    	var filename = $(this).find("input[name='csv_filename']").val();
    	if(filename == '')
    	{
    		alert.show();
    		return false;
    	}  	
    	return true;
    });
      
    function getTournaments(obj){
	$('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"Games", "action"=>"getTournamentsAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){
	    $('.admin-amzn-loader').hide();
            $("#tournament-box").html(data);
        });
    }
    
    function getLeagues(obj){
	$('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"Games", "action"=>"getLeaguesAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){
	    $('.admin-amzn-loader').hide();
            $("#league-box").html(data);
        });        
    }
    
    function getTeams(obj){
	$('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"Games", "action"=>"getTeamsAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){
	    $('.admin-amzn-loader').hide();
            $("#team-box").html(data);
        });        
    }
    
    function getTeamsFilter(obj){
	$('.admin-amzn-loader').show();
        var leagueId = null;
        var jQ = $(obj);
        leagueId = $('#GameLeagueId').val();
        var url = "<?php echo $this->Html->url(array("controller"=>"Games", "action"=>"getTeamsFilterAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val())+'/'+Base64.encode(leagueId);
        $.post(url, {id:"id"}, function(data){
	$('.admin-amzn-loader').hide();
        $("#team2-box").html(data);
        });        
    }
</script>
 