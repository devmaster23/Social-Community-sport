<div id="flashMessage" style="display:none;">
<div class="message error">
</div>
</div>
<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<section class="content-header">
    <h1><?php echo __dbt('Add Gifts'); ?>
        <small><?php echo __dbt('Admin Add Gifts'); ?></small>
    </h1>
    <?php echo $this->element($elementFolder . '/breadcrumb'); ?>
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
                    <?php
                    echo $this->Form->create('Gift', array('class' => 'form-horizontal', 'novalidate','autocomplete' => "off", "enctype" => "multipart/form-data"));
                    $this->Form->inputDefaults(array('required' => false));
                    ?>
                     <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputSportid"><?php echo __dbt('Sport'); ?></label>
                        <div class="col-sm-4">
                        <?php echo $this->Form->input('sport_id',array('class'=>'form-control','empty'=>__dbt('-- select sports --'),'label' => false, "onchange"=>"getTournaments(this);")); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputtournamentid"><?php echo __dbt('Tournament'); ?></label>
                        <div class="col-sm-4" id="tournament-box">
                        <?php echo $this->Form->input('tournament_id',array('class'=>'form-control','empty'=>__dbt('--select tournament--'),'label' => false,"onchange"=>"getLeagues(this);")); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputleagueid"><?php echo __dbt('League'); ?></label>
                        <div class="col-sm-4" id="league-box">
                        <?php echo $this->Form->input('league_id',array('class'=>'form-control','label' => false,'empty'=>__dbt('-- select league --'))); ?>
                         </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputStartDate"><?php echo __dbt('Start Date'); ?></label>
                        <div class="col-sm-4">
                                <?php echo $this->Form->input('start_date', array("type"=>"text",'data-field'=>'datetime',"class"=>"form-control",'label' => false));  ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEndDate"><?php echo __dbt('End Date'); ?></label>
                        <div class="col-sm-4">
                                <?php echo $this->Form->input('end_date', array("type"=>"text",'data-field'=>'datetime',"class"=>"form-control",'label' => false));  ?>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Game Day'); ?></label>
                        <div class="col-sm-4" id="gameday">
                            
                                                        <?php  
                                                        $options=array_combine(range(1,99,1),range(1,99,1));
                                                        array_unshift($options, "All");
                                                        echo $this->Form->input('game_day', array("type"=>"select", "value"=>"",'options' => $options,
                                                        'empty' =>__dbt('-- Select Game Day --'),"class"=>"form-control",'label' => false,"onchange"=>"changewinninggames(this);"));
                                                       
                                                        ?>
                                                

                        </div>
                    </div>
                    <div id="dynamicFormContent">

                     <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Type'); ?></label>
                        <div class="col-sm-4">
                            <?php
                            $options = array('1' => __dbt('Gifts'), '2' => __dbt('Cash Order'));
                            echo $this->Form->input('type', array('class' => 'form-control', 'label' => false, 'options' => $options, 'empty' => '--select one--'));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Gift Category');

                        ?></label>
                        <div class="col-sm-4">
                            <?php
                            $gift_cat = array_map("ucwords", $gift_cat);
                            echo $this->Form->input('gift_category_id', array('class' => 'form-control', 'label' => false, 'options' => $gift_cat, 'empty' => '--select one--'));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Name'); ?></label>
                        <div class="col-sm-4">
                            <?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => false)); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Location');

                        ?></label>
                        <div class="col-sm-4">
                            <?php
                            //$gift_cat = array_map("ucwords", $location);
                            echo $this->Form->input('location_id', array('type'=>'text','class' => 'form-control', 'label' => false, 'placeholder' => 'Enter gift location'));
                            ?>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-sm-2 control-label amt" for="inputEmail3"><?php echo __dbt('Amount'); ?></label>
                        <div class="col-sm-4">
<?php echo $this->Form->input('amount', array('class' => 'form-control', 'label' => false,'type'=>'text')); ?>
                        </div>
                    </div>

                    <div class="form-group only-for-gift">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Product Link'); ?></label>
                        <div class="col-sm-4">
<?php echo $this->Form->input('product_link', array('class' => 'form-control', 'label' => false)); ?>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Number of game to win this gift'); ?></label>
                        <div class="col-sm-4">
                            <?php echo $this->Form->input('winning_no_game', array("type"=>"number",'min' =>'1','class' => 'form-control', 'label' => false ,"onblur"=>"getwinninggameno(this);")); ?>
                             <span style="color: red;display:none;" id="gameno_errors"></span>
                        </div>
                        </div>


                    <div class="form-group only-for-gift">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Gifts Image'); ?></label>
                        <div class="col-sm-4">
                            <?php echo $this->Form->input('file_id', array('type' => 'file', 'label' => false, 'accept' => array("image/*"))); ?>
                            <span style="color: red;display:none;" id="file_errors"></span>
                        </div>
                    </div>
             
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
                        <div class="col-sm-4">
                            <?php
                            $status_options = array("Inactive", "Active");
                            echo $this->Form->input('status', array("type" => "select", "options" => $status_options, "class" => "form-control", 'label' => false, 'empty' => '-- select status --'));
?>
                        </div>
                    </div>
                    </div>
          
                  <a href="javascript:void(0)" class="addmore" style="display:none;" onclick=" return addmore();">ADD More Gift +</a>
                    <div class="box-footer">
                        <div class="col-sm-4 control-label">
                            <?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'submit','div' => false, 'id' => 'submitPoll')); ?>
                            <a class="btn btn-warning margin" href="/admin/gifts"><?php echo __dbt('Cancel'); ?></a>
                        </div>
                    </div>
                  <?php echo $this->Form->end(); ?>

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
				<h4 class="modal-title">Import Gifts List</h4>
			</div>
			<form action="/admin/gifts/importData" enctype='multipart/form-data' id="import_data_form" method="post" class="form-horizontal" >
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

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>

</script>
<script>
    $("#GiftLocationId").autocomplete({
    source: "<?php echo $this->Html->url(array('controller' => 'Gifts', 'action' => 'admin_searchGiftLocation')); ?>",
    minLength: 2,
    });

    $(document).ready(function(){

        $("#dtBox1").DateTimePicker({
            dateTimeFormat: "yyyy-MM-dd hh:mm:ss",
        });

        $(document).on('change','#GiftType',function(){
            var gifttype = $(this).select();
            if(gifttype.val()==1){
                $('.amt').html("<?php echo __dbt('Product Price');?>");
                $('.only-for-gift').show();
            }else if(gifttype.val()==2){
                $('.amt').html("<?php echo __dbt('Cash Order Amount');?>");
                $('.only-for-gift').hide();
               // $('#cash_fileid').val(173);

            }else{
                $('.amt').html("<?php echo __dbt('Amount');?>");
                $('.only-for-gift').show();
            }
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
       // if all sport selected then select all tournament and league 
       if(jQ.val() == 0){
                var url = "<?php echo $this->Html->url(array("controller"=>"Gifts", "action"=>"getTournamentsAjax", $this->params["prefix"] => false)); ?>/"+'0';
                $.post(url, {id:"id"}, function(data){
                $('.admin-amzn-loader').hide();
                $("#GiftWinningNoGame").val('');
                $("#tournament-box").html(data);
                
                });
                
                var url = "<?php echo $this->Html->url(array("controller"=>"Gifts", "action"=>"getLeaguesAjax", $this->params["prefix"] => false)); ?>/"+'0';
                $.post(url, {id:"id"}, function(data){
                    $('.admin-amzn-loader').hide();
                    $("#GiftWinningNoGame").val('');
                    $("#league-box").html(data);
                });
           
       } else {
                var url = "<?php echo $this->Html->url(array("controller"=>"Gifts", "action"=>"getTournamentsAjax", $this->params["prefix"] => false)); ?>/"+jQ.val();
                $.post(url, {id:"id"}, function(data){
                $('.admin-amzn-loader').hide();
                $("#GiftWinningNoGame").val('');
                $("#tournament-box").html(data);
                });
            }
    }

    function getLeagues(obj){
    $('.admin-amzn-loader').show();
        var jQ = $(obj);
        if(jQ.val() == 0){
             var url = "<?php echo $this->Html->url(array("controller"=>"Gifts", "action"=>"getLeaguesAjax", $this->params["prefix"] => false)); ?>/"+'0';
                $.post(url, {id:"id"}, function(data){
                $('.admin-amzn-loader').hide();
                $("#GiftWinningNoGame").val('');
                $("#league-box").html(data);
            });
        } else {
            var url = "<?php echo $this->Html->url(array("controller"=>"Gifts", "action"=>"getLeaguesAjax", $this->params["prefix"] => false)); ?>/"+jQ.val();
                $.post(url, {id:"id"}, function(data){
                $('.admin-amzn-loader').hide();
                $("#GiftWinningNoGame").val('');
                $("#league-box").html(data);
            });
        }
    }

function getwinninggameno(obj)
{
    $('.admin-amzn-loader').show();
    var jQ = $(obj);
   var sport_id = $('#GiftSportId').val();
   var tournament_id=$('#GiftTournamentId').val();
    var league_id=$('#GiftLeagueId').val();
    var winning_game =jQ.val();
    var gameday =$('#GiftGameDay').val();
    if((sport_id!='')&& (tournament_id!='') && (league_id!='') && (winning_game!='') && (gameday!='')){
    var url = "<?php echo $this->Html->url(array("controller"=>"Gifts", "action"=>"getGamesDaysAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(sport_id)+"/"+Base64.encode(tournament_id)+"/"+Base64.encode(league_id)+"/"+Base64.encode(winning_game)+"/"+Base64.encode(gameday);
                $.post(url, {sport_id:"sport_id",tournament_id:"tournament_id",league_id:"league_id",winning_game:"winning_game",gameday:"gameday"}, function(data){
                 
                 $('.admin-amzn-loader').hide();
                   if(parseInt(data)==0)
                 {
                  $("#gameno_errors").hide();
                  $("#gameno_errors").html('');
                 }
                 else
                 {
                 var comparison=parseInt(data)<parseInt(winning_game);
                 if(comparison==true){
                 $("#gameno_errors").show();
                 $("#gameno_errors").html('your game number not be exceed from total games.');
                 }
                 else
                 {
                  $("#gameno_errors").hide();
                  $("#gameno_errors").html('');
                 }
                 }
                 
                
            });
  
}
}
  

  $("form#GiftAdminAddForm").submit(function(){

    var formData = new FormData($(this)[0]);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
       // alert(data);
         if(data=='uploadbigimage')
         {
         $("#file_errors").show();
          $("#file_errors").html('Please upload image greater than 348 (w) X 478 (h) dimension.');
         }
         if(data=='unabletouploadimage'){
           $("#file_errors").show();
          $("#file_errors").html('Unable to upload Image and save record. Please, try again.');
         }
         if(data=='selectvalidimage')
         {
           $("#file_errors").show();
          $("#file_errors").html('Please select a valid image format. gif, jpg, png, jpeg are allowed only');
         }
          if(data=='save'){
         $(".addmore").show();
         $("#dynamicFormContent").hide();
         }       

        },
        cache: false,
        contentType: false, 
        processData: false
    });

    return false;
});

function addmore()
{
  $("#dynamicFormContent").show();
    $("#dynamicFormContent").html($("#dynamicFormContent").html());
    $(".addmore").hide();
}
function changewinninggames()
{
$("#GiftWinningNoGame").val('');
}
 </script>