<style>
    .only-for-gift-none{display: none;}
    .only-for-gift-block{display: block;}
</style>
<section class="content-header">
    <h1><?php echo __dbt('Edit Gifts'); ?>
        <small><?php echo __dbt('Admin Edit Gifts'); ?></small>
    </h1>
    <?php echo $this->element($elementFolder . '/breadcrumb', array('title' => 'Gifts', 'controller' => 'gifts')); ?>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                </div>
                <div class="box-body">
                    <?php
                    echo $this->Form->create('Gift', array('class' => 'form-horizontal', "enctype" => "multipart/form-data"));
                    $this->Form->inputDefaults(array('required' => false));
                    echo $this->Form->hidden('id'); ?>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputSportid"><?php echo __dbt('Sport'); ?></label>
                        <div class="col-sm-4">
                        <?php echo $this->Form->input('sport_id',array('class'=>'form-control','empty'=>__dbt('-- select sports --'),'label' => false, "onchange"=>"getTournaments(this);")); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputtournamentid"><?php echo __dbt('Tournament'); ?></label>
                        <div class="col-sm-4" id="tournament-box">
                        <?php echo $this->Form->input('tournament_id', array('class'=>'form-control','empty'=>__dbt('--select tournament--'),'label' => false, 'options'=> $tournaments ,"onchange"=>"getLeagues(this);")); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputleagueid"><?php echo __dbt('League'); ?></label>
                        <div class="col-sm-4" id="league-box">
                        <?php echo $this->Form->input('league_id',array('class'=>'form-control','label' => false, 'options'=>$leagues, 'empty'=>__dbt('-- select league --'))); ?>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Game Day'); ?></label>
                        <div class="col-sm-4" id="gameday">

                                                        <?php
                                                        $no_options=array_combine(range(1,99,1),range(1,99,1));
                                                        array_unshift($no_options, "All");
                                                        echo $this->Form->input('game_day', array("type"=>"select", 'options' =>$no_options ,
                                                        'empty' =>__dbt('-- Select Game Day --'),"class"=>"form-control",'label' => false,"onchange"=>"changewinninggames(this);"));

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
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Type');

                        ?></label>
                        <div class="col-sm-4">
                            <?php
                            $options = array('1' => __dbt('Gifts'), '2' => __dbt('Cash Order'));
                            echo $this->Form->input('type', array('class' => 'form-control', 'label' => false, 'options' => $options, 'empty' => '--select one--'));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label amt" for="inputEmail3"><?php
                        if($this->request->data['Gift']['type']==1){
                            echo __dbt('Product Price');
                        }else if($this->request->data['Gift']['type']==2){
                            echo __dbt('Cash Order Amount');
                        }else{
                            echo __dbt('Amount');
                        }
                         ?></label>
                        <div class="col-sm-4">
<?php echo $this->Form->input('amount', array('class' => 'form-control', 'label' => false,'type'=>'text')); ?>
                        </div>
                    </div>
                    <div class="form-group <?php if($this->request->data['Gift']['type']==2){echo 'only-for-gift-none';}else{echo 'only-for-gift-block';}?>" id="pl">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Product Link'); ?></label>
                        <div class="col-sm-4">
<?php echo $this->Form->input('product_link', array('class' => 'form-control', 'label' => false)); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Number of game to win this gift'); ?></label>
                        <div class="col-sm-4">
                            <?php echo $this->Form->input('winning_no_game', array("type"=>"number",'min' =>'1','class' => 'form-control', 'label' => false,"onblur"=>"getwinninggameno(this);")); ?>
                            <span style="color: red;display:none;" id="gameno_errors"></span>
                        </div>
                        </div>

                    <div class="form-group <?php if($this->request->data['Gift']['type']==2){echo 'only-for-gift-none';}else{echo 'only-for-gift-block';}?>" id="gi">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Gifts Image'); ?></label>
                        <div class="col-sm-4">

                                <?php if (!empty($this->request->data['File']['name'])) { ?>
                                <div class="image-preview">
                                    <?php echo $this->Html->image($this->request->data['File']['path'], array("id" => "ImageDiv", 'escape' => false, 'style' => 'width:50%')); ?>
                                </div>
                                <div class="actin-div">
                                <?php echo $this->Html->link('<span>Change</span>', 'javascript:void(0)', array("id" => "changeImage", 'escape' => false)); ?>
                                </div>
                                <?php echo $this->Form->input('file_id', array('type' => 'file', 'label' => false, 'div' => false, 'accept' => array("image/*"), 'style' => 'display:none', 'id' => 'ItemAttachment')); ?>
<?php } else {
    echo $this->Form->input("file_id", array('type' => 'file', 'label' => false, 'div' => false, 'accept' => array("image/*")));
}
?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
                        <div class="col-sm-4">
<?php $status_options = array("Inactive", "Active");
echo $this->Form->input('status', array("type" => "select", 'class' => 'form-control', 'label' => false, "options" => $status_options, 'empty' => '-- select status --'));
?>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-sm-4 control-label">
<?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'btn btn-primary', 'div' => false, 'id' => 'submitPoll')); ?>
                            <a class="btn btn-warning margin" href="/admin/gifts"><?php echo __dbt('Cancel'); ?></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<div id="dtBox1"></div><!-- this div used for date picker  -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
    $("#GiftLocationId").autocomplete({
    source: "<?php echo $this->Html->url(array('controller' => 'Gifts', 'action' => 'admin_searchGiftLocation')); ?>",
    minLength: 2,
    });

    $(document).on('click', '#changeImage', function() {
        $("#ItemAttachment").css('display', 'block');
        $("#changeImage").css('display', 'none');
        $("#ImageDiv").css('display', 'none');
        $('.image-preview').css('display', 'none');
        $('.actin-div').css('display', 'none');
    });


    $(document).ready(function(){
        $("#dtBox1").DateTimePicker({
            dateTimeFormat: "yyyy-MM-dd hh:mm:ss"
        });
        $(document).on('change','#GiftType',function(){
            var gifttype = $(this).select();
            if(gifttype.val()==1){
                $('.amt').html("<?php echo __dbt('Product Price');?>");
                $('.only-for-gift').show();
                $('#pl').removeClass('only-for-gift-none');
                $('#gi').removeClass('only-for-gift-none');
                $('#pl').addClass('only-for-gift-block');
                $('#gi').addClass('only-for-gift-block');
            }else if(gifttype.val()==2){
                $('.amt').html("<?php echo __dbt('Cash Order Amount');?>");
                $('.only-for-gift').hide();
                $('#pl').removeClass('only-for-gift-block');
                $('#gi').removeClass('only-for-gift-block');
                $('#pl').addClass('only-for-gift-none');
                $('#gi').addClass('only-for-gift-none');
            }else{
                $('.amt').html("<?php echo __dbt('Amount');?>");
                $('.only-for-gift').show();
                $('#pl').removeClass('only-for-gift-none');
                $('#gi').removeClass('only-for-gift-none');
                $('#pl').addClass('only-for-gift-block');
                $('#gi').addClass('only-for-gift-block');
            }
        });
    });

    function getTournaments(obj){
        $('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"Gifts", "action"=>"getTournamentsAjax", $this->params["prefix"] => false)); ?>/"+jQ.val();
        $.post(url, {id:"id"}, function(data){
            $('.admin-amzn-loader').hide();
            $("#GiftWinningNoGame").val('');
            $("#tournament-box").html(data);
        });
    }

    function getLeagues(obj){
    $('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"Gifts", "action"=>"getLeaguesAjax", $this->params["prefix"] => false)); ?>/"+jQ.val();
        $.post(url, {id:"id"}, function(data){
        $('.admin-amzn-loader').hide();
        $("#GiftWinningNoGame").val('');
        $("#league-box").html(data);
        });
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


            });

}
}
function changewinninggames()
{
$("#GiftWinningNoGame").val('');
}
</script>
