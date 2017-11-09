
<span id="findForm"></span>

<div class="col-sm-6">
    <?php
    $options2 = array('1' => __dbt('Gifts'), '2' => __dbt('Cash Order'));
    echo $this->Form->input('type', array('class' => 'form-control type-location-category', 'options' => $options2, 'id' => 'gifttype','empty' => __dbt('--Select One--'), "onchange"=>"getGiftlist(this);"));
    ?>
</div>
<div class="col-sm-6" style="visibility:hidden;">
    <?php
    //$location = array_map("ucwords", $location);

    echo $this->Form->input('location_id', array('class' => 'form-control type-location-category gift-location', 'type'=>'text', 'placeholder' => __dbt('Enter location')));
    ?>
    <div class="clear"></div>
</div>

<div class="col-sm-6">
    <?php
    $gift_cat = array_map("ucwords", $gift_cat);
    echo $this->Form->input('gift_category_id', array('class' => 'form-control type-location-category', 'id' => 'gift_cat','options' => $gift_cat, 'empty' => __dbt('--Select One--'),"onchange"=>"getGiftlist(this);"));
    ?> 

    <div class="clear"></div>
</div>
<div class="col-sm-6" id="gift-box">
    <?php
    echo $this->Form->input('Gifts Name', array('class' => 'form-control type-location-category',  'empty' => __dbt('--Select One--'),"onchange"=>"getGiftImages(this);"));
    ?>
</div>
<div class="col-sm-12" id="giftimagesrow" style="display:none;">
<div class="col-sm-4">
<a href="#" class="thumbnail">
      <img alt="Sports" src="/img/sports-logo.png" style="height:50px; width:100px;"/>      
</a>
<div class="checkbox" style="position: absolute; left: 21px; top: -6px;">
  <label><input type="checkbox" class="selectbox" value="" style="position:static !important;"></label>
</div>
</div>

<div class="col-sm-4">
<a href="#" class="thumbnail">
        <img alt="Sports" src="/img/sports-logo.png" style="height:50px; width:100px;"/>
</a>
<div class="checkbox"  style="position: absolute; left: 21px; top: -6px;">
  <label><input type="checkbox" class="selectbox" value="" style="position:static !important;"></label>
</div>

</div>
<div class="col-sm-4" id="realimage-box">
    <a href="#" class="thumbnail">
     <img alt="Sports" src="/img/sports-logo.png" style="height:50px; width:100px;"/>
</a>
<div class="checkbox" style="position:static;">
  <label><input type="checkbox" value="" style="position:static !important;"></label>
</div>
</div>

</div>
<div class="col-sm-12" id="notificationbox" style="display:none;text-align:center;">
</div>

    <div class="col-sm-4" id="save_button" style="display:none; margin-left:200px;">
    <?php echo $this->Form->input('sport_id', array('value' => $sportId, 'type' => 'hidden')); ?>
    <?php echo $this->Form->input('game_id', array('value' => $gameId, 'type' => 'hidden')); ?>
    <?php echo $this->Form->input('league_id', array('value' => $leagueId, 'type' => 'hidden')); ?>
    <?php echo $this->Form->input('tournament_id', array('value' => $tournamentId, 'type' => 'hidden')); ?>
    <?php echo '&nbsp;' . $this->Form->submit(__dbt('Save'), array('class' => 'btn from-btn', 'div' => false, 'id'=>'savebtn')); ?>
     </div>
 <?php echo $this->Form->end(); ?>    
<div class="col-sm-12" id="contentHere"></div>
<div class="bloger-modal">
    <div class="modal fade" id="putErrorBox" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __dbt('Alert'); ?></h4>
                </div>
                <div class="modal-body2" style="height:50px;">
                <div class="errorbox" style="text-align:center"><p>you checked wrong checkbox</p></div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>#ui-id-1{z-index: 9999 !important;}</style>
<script>
    $(".gift-location").autocomplete({
    source: "<?php echo $this->Html->url(array('controller' => 'Gifts', 'action' => 'searchGiftLocation')); ?>",
    minLength: 2

    });

    function getGiftlist(obj){
    $('.admin-amzn-loader').show();
        var gift_cat = $('#gift_cat').val();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"Gifts", "action"=>"getGiftListAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val())+"/"+Base64.encode(gift_cat);
        $.post(url, {id:"id",gift_cat:"gift_cat"}, function(data){
        $('.admin-amzn-loader').hide();
            $("#gift-box").html(data);
        });
    }
    function getGiftImages(obj){
    $('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"Gifts", "action"=>"getGiftImagesAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){
       
        $('.admin-amzn-loader').hide();
       // $('#gift_id').val(id);
        $('#giftimagesrow').show();
        $('#notificationbox').show();

        $('#save_button').show();
        result=JSON.parse(data);
         $('#realimage-box').html('');
         if(result.file.path=="")
         var giftimage='/img/sports-logo.png';
         else
         var giftimage=result.file.path;
         var rowHtml='<a class="thumbnail" href=http://'+result.Gift.product_link+'><img src='+giftimage+' style="height:50px; width:100px;" alt="Sports"></a><div class="checkbox" style="position: absolute; left: 21px; top: -6px;"><label><input type="checkbox" value="" style="position:static !important;"></label></div>';
         
         $('#realimage-box').append(rowHtml);
         $('#notificationbox').html('');
         if(result.Gift.winning_no_game=="") 
         var winninggames='No data';
         else
         var winninggames=result.Gift.winning_no_game;
         var rowsHtml='<p class="form-control" style="text-align:center;">'+winninggames+'</p>';
         
         $('#notificationbox').append(rowsHtml);
        });
    
    }
    $(".selectbox").change(function() {
    if(this.checked) {
       $('#putErrorBox').modal({show: true});
    }
});

    
</script>
 <script type="text/javascript">
    $(document).ready(function(){
        $('#formdata').submit(function(){
           var formData = $(this).serialize();
            //get form action
            var formUrl = $(this).attr('action');
            
            $.ajax({
                type: 'POST',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
                        alert('You successfully submitted gift form');
                },
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
            }); 
                
            return false;
         
        });
    });
    </script>