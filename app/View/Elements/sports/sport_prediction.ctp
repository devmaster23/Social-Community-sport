<?php
error_reporting(0);
ini_set("allow_url_fopen", 1);
    $yahoo_rates = file_get_contents('http://download.finance.yahoo.com/d/quotes.csv?s=USDINR=X&f=sl1d1t1ba&e=.csv');
    $yahoo_rates = explode(",", $yahoo_rates);
?>
<span id="findForm"></span>

<div class="col-sm-6 col-xs-12">
    <?php
    $options2 = array('1' => __dbt('Gifts'), '2' => __dbt('Cash Order'));
    echo $this->Form->input('type', array('class' => 'form-control type-location-category', 'options' => $options2, 'id' => 'gifttype','empty' => __dbt('--Select One--'), "onchange"=>"getGiftlist(this);"));
    ?>
</div>
<div class="col-sm-6 col-xs-12" style="visibility:hidden;">
    <?php
    //$location = array_map("ucwords", $location);

    echo $this->Form->input('location_id', array('class' => 'form-control type-location-category gift-location', 'type'=>'text', 'placeholder' => __dbt('Enter location')));
    ?>
    <div class="clear"></div>
</div>

<div class="col-sm-6 col-xs-12" id="gift_category">
    <?php
    $gift_cat = array_map("ucwords", $gift_cat);
    echo $this->Form->input('gift_category_id', array('class' => 'form-control type-location-category', 'id' => 'gift_cat','options' => $gift_cat, 'empty' => __dbt('--Select One--'),"onchange"=>"getGiftlist(this);"));
    ?>

    <div class="clear"></div>
</div>

<div class="col-sm-6 col-xs-12" id="gift-box">
    <?php
    echo $this->Form->input('Gifts Name', array('class' => 'form-control type-location-category',  'empty' => __dbt('--Select One--'),"onchange"=>"getGiftImages(this);",'div' => false));
    ?>
</div>

<div class="col-sm-12" id="giftimagesrow" style="display:none;">
<div class="col-sm-4" class="giftimagesrowfirst">
<a href="#" class="thumbnail">
      <img alt="Sports" src="/img/sports-logo.png" style="height:50px; width:100px;"/>
</a>
<div class="checkbox" style="position: absolute; left: 21px; top: -6px;">
  <label><input type="checkbox"  value="" style="position:static !important;"></label>
</div>
</div>

<div class="col-sm-4" class="giftimagesrowfirst">
<a href="#" class="thumbnail">
        <img alt="Sports" src="/img/sports-logo.png" style="height:50px; width:100px;"/>
</a>
<div class="checkbox"  style="position: absolute; left: 21px; top: -6px;">
  <label><input type="checkbox"  value="" style="position:static !important;"></label>
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
<div class="col-sm-12" id="yahoo-rates" tyle="display:none;text-align:center;">
</div>
<div class="col-sm-12" id="notificationbox" style="display:none;text-align:center;float:left;width:100%;">
</div>

    <div class="col-sm-4" id="save_button" style="display:none;text-align:center;width:100%;">
    <?php if(isset($gameday)){
     echo $this->Form->input('teams_gameday', array('value' => $gameDay, 'type' => 'hidden','id' =>'gift_gameday')); }
     else
     {
      echo $this->Form->input('teams_gameday', array('value' => 0, 'type' => 'hidden','id' =>'gift_gameday'));
      } ?>

    <?php echo $this->Form->input('sport_id', array('value' => $sportId, 'type' => 'hidden')); ?>
    <?php echo $this->Form->input('league_id', array('value' => $leagueId, 'type' => 'hidden')); ?>
    <?php echo $this->Form->input('tournament_id', array('value' => $tournamentId, 'type' => 'hidden')); ?>
   <?php echo $this->Form->input('controller',array('value' => $controllerName, 'type' => 'hidden')); ?>
    <?php echo '&nbsp;' . $this->Form->submit(__dbt('Save'), array('class' => 'btn from-btn', 'div' => false, 'id'=>'savebtn')); ?>
 <button type="button" class="btn from-btn" data-dismiss="modal">Cancel</button>
     </div>
 <?php echo $this->Form->end(); ?>
<div class="col-sm-12" id="contentHere"></div>
 <div class="bloger-modal">
    <div class="modal fade" id="putErrorGiftBox" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width:60%;left:20%;">
                <div class="modal-header">
                <button type="button" class="close" onClick="ClosePutErrorGiftBox();">x</button>
                    <h4 class="modal-title"><?php echo __dbt('Alert'); ?></h4>
                </div>
                <div class="modal-body2" style="height:min-height;">
                <div class="errorbox" id="errorbox" style="text-align:center;padding-top:14px;padding-bottom:14px;"><strong>you checked wrong checkbox</strong></div>
                <center><button type="button" class="btn btn-info" onClick="ClosePutErrorGiftBox();" style="padding:3px 12px;margin-top:5px;margin-bottom:5px;">ok</button></center>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>#ui-id-1{z-index: 9999 !important;}</style>

<script>

/*$(('.selectbox').prop('checked')) {
        alert('ok');
        //Redirect by box1
}*/
  $(".gift-location").autocomplete({
    source: "<?php echo $this->Html->url(array('controller' => 'Gifts', 'action' => 'searchGiftLocation')); ?>",minLength: 2

    });
    function getGiftlist(obj){
        $('.admin-amzn-loader').show();
        var gift_cat = $('#gift_cat').val();
        var gifttype = $('#gifttype').val();
        var giftgameday = $('#gift_gameday').val();
        var jQ = $(obj);
        var giftid= jQ.val();
        if(gifttype==2)
        {
          $('#gift_category').hide();
        }
        else
        {
        $('#gift_category').show();
        }
        $('#giftimagesrow').hide();
        $('#notificationbox').hide();
        $('#yahoo-rates').hide();
        $('#save_button').hide();
        var url = "<?php echo $this->Html->url(array("controller"=>"Gifts", "action"=>"getGiftListAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(gifttype)+"/"+Base64.encode(giftgameday)+"/"+Base64.encode(gift_cat);
        $.post(url, {gifttype:"gifttype",giftgameday:"giftgameday",gift_cat:"gift_cat"}, function(data){
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

        $('#giftimagesrow').show();



        $('#giftimagesrow').show();
        if(jQ.val()=="")
        {
           $('#giftimagesrow').html('');
           $('#notificationbox').html('');
           $('#save_button').hide();
        }
        else
        {
          $('#notificationbox').show();
           $('#save_button').show();
          $('#giftimagesrow').html('');
                  obj = JSON.parse(data);

                 var length = Object.keys(obj).length;
                if(length!=3){
                  var roweHtml='<div class="col-md-4"><a class="thumbnail" target="blank" href="#"><img src="/img/sports-logo.png" style="height:50px; width:100px;" alt="Sports"></a><div class="checkbox" style="position: absolute; left: 21px; top: -6px;"><label><input type="checkbox" class="filecheck" value="" style="position:static !important;"></label></div></div><div class="col-md-4"><a class="thumbnail" target="blank" href="#"><img src="/img/sports-logo.png" style="height:50px; width:100px;" alt="Sports"></a><div class="checkbox" style="position: absolute; left: 21px; top: -6px;"><label><input type="checkbox" class="filecheck" value="" style="position:static !important;"></label></div></div>';
                  $('#giftimagesrow').append(roweHtml);

                }

                  $.each(obj, function (key, data) {
                  var rowHtml='<div class="col-md-4 _col'+key+'"><a class="thumbnail" target="blank" href='+data.Gift.product_link+'><img src='+data.file.path+' style="height:50px; width:100px;" alt="Sports"></a><div class="checkbox" style="position: absolute; left: 21px; top: -6px;"><label><input type="checkbox" class="filecheck" value="" style="position:static !important;"></label></div></div>';
                  $('#giftimagesrow').append(rowHtml);
                  var classes = ['_g1','_g2','_g3','_g4','_g5','_g6']; var randomnumber = Math.floor(Math.random()*classes.length); $('#giftimagesrow').removeClass().addClass(classes[randomnumber]);

                   $('#notificationbox').html('');
                   if(data.Gift.winning_no_game=="")
                   var winninggames='No data';
                   else
                   var winninggames=data.Gift.winning_no_game;
                   var rowsHtml='<p class="form-control" style="text-align:center;">You should predict&nbsp;'+winninggames+'&nbsp;games correct.</p>';

                   $('#notificationbox').append(rowsHtml);
                  /*  $("#filecheck-0").change(function(event){
                  if (this.checked){
                  document.getElementById('errorbox').innerHTML="you checked wrong checkbox";
                  $('#putErrorGiftBox').modal({show: true});

                  }

                  //});

                  });
                  $("#filecheck-1").change(function(event){
                  if (this.checked){
                  document.getElementById('errorbox').innerHTML="you checked wrong checkbox";
                  $('#putErrorGiftBox').modal({show: true});

                  }

                  //});

                  });
                   $("#filecheck-2").change(function(event){
                  if (this.checked){
                  document.getElementById('errorbox').innerHTML="This is Your Gift.";
                  $('#putErrorGiftBox').modal({show: true});


                  }
                  });*/



        });
                  $("#giftimagesrow div:last-child div input:last-child").addClass("last");

                  $(".filecheck").change(function(event){
                  if (this.checked){
                  document.getElementById('errorbox').innerHTML="you checked wrong checkbox";
                  $('#putErrorGiftBox').modal({show: true});

                  }
                  });

                  $(".last").change(function(event){
                  if (this.checked){
                  document.getElementById('errorbox').innerHTML="This is Your Gift.";
                  $('#putErrorGiftBox').modal({show: true});


                  }
                  });

        }
      });

    }

 function getRate(){
          //  document.getElementById("yahoo-rates").innerHTML = "<img src='/img/loading.gif'>";
            from = 'USD';
            to = document.getElementById('countryid').value;
            cashprice = $('#cashpriceid option:selected').text();

            cashamount = document.getElementById('cashpriceid').value;
            $.post("<?php echo $this->Html->url(array("controller"=>"tests","action"=>"getCurrencyRate")); ?>",{'from':from,'to':to,'access_Token':'OO0OO0OO0O0O0O0O0OO0O'},function(data){
                 var Currency=(cashprice*data);
                //document.getElementById("yahoo-rates").innerHTML = Math.round(Currency);
              if(cashamount!=""){

                 $.post("<?php echo $this->Html->url(array("controller"=>"Gifts","action"=>"getcashImagesAjax"));?>",{'cashamount':cashamount},function(result){

                  //alert(result);
                  $('.giftimagesrowfirst').hide();
                  $('#giftimagesrow').show();
                  $('#yahoo-rates').show();
                  $('#notificationbox').show();
                  $('#save_button').show();
                  $('#giftimagesrow').html('');

                 obj = JSON.parse(result);
                  var cashlength = Object.keys(obj).length;

                  $.each(obj, function (key, data) {
                   // console.log(data);
                  if(cashlength!=3){
                     var rowHtml='<div class="col-md-4"><a class="thumbnail" target="blank" href="#"><img src="/img/sports-logo.png" style="height:50px; width:100px;" alt="Sports"></a><div class="checkbox" style="position: absolute; left: 21px; top: -6px;"><label><input type="checkbox" class="checkboxcheck" value="" style="position:static !important;"></label></div></div><div class="col-md-4"><a class="thumbnail" target="blank" href="#"><img src="/img/sports-logo.png" style="height:50px; width:100px;" alt="Sports"></a><div class="checkbox" style="position: absolute; left: 21px; top: -6px;"><label><input type="checkbox" class="checkboxcheck" value="" style="position:static !important;"></label></div></div><div class="col-md-4"><a class="thumbnail" target="blank" href="#"><img src="/img/GiftsImages/1487601352.png" style="height:50px; width:100px;" alt="Sports"></a><div class="checkbox" style="position: absolute; left: 21px; top: -6px;"><label><input type="checkbox" class="select-box" value="" style="position:static !important;"></label></div></div>';
                 //  $('#giftimagesrow').append(rowHtml);

                  }
                 else if(key!=2){
                  var rowHtml='<div class="col-md-4 _col'+key+'"><a class="thumbnail" target="blank" href=http://'+data.Gift.product_link+'><img src='+data.file.path+' style="height:50px; width:100px;" alt="Sports"></a><div class="checkbox" style="position: absolute; left: 21px; top: -6px;"><label><input id="filecheck-'+key+'" type="checkbox" class="checkboxcheck" value="" style="position:static !important;"></label></div></div>';
                }
                else
                {

                   var rowHtml='<div class="col-md-4 _col2"><a class="thumbnail" target="blank" href="#"><img src="/img/GiftsImages/1487601352.png" style="height:50px; width:100px;" alt="Sports"></a><div class="checkbox" style="position: absolute; left: 21px; top: -6px;"><label><input type="checkbox" class="select-box" value="" style="position:static !important;"></label></div></div>';
                }
                  $('#giftimagesrow').append(rowHtml);
                  var classes = ['_g1','_g2','_g3','_g4','_g5','_g6']; var randomnumber = Math.floor(Math.random()*classes.length); $('#giftimagesrow').removeClass().addClass(classes[randomnumber]);
                  $('#yahoo-rates').html('<p class="form-control" style="text-align:center;margin-bottom:5px;">Cash in your currency'+' '+Math.round(Currency)+'('+to+')</p><input type="hidden" name="data[GamesGiftPrediction][cashamount]" value='+Math.round(Currency)+'('+to+')>');

                  $('#notificationbox').html('');
                 if(data.Gift.winning_no_game=="")
                 var winninggames='No data';
                 else
                 var winninggames=data.Gift.winning_no_game;
                 var rowsHtml='<p class="form-control" style="text-align:center;">You should predict&nbsp;'+winninggames+'&nbsp;games correct.</p>';

                 $('#notificationbox').append(rowsHtml);

                  });

                   $(".checkboxcheck").change(function(event){
                  if (this.checked){
                   document.getElementById('errorbox').innerHTML="you checked wrong checkbox";
                  $('#putErrorGiftBox').modal({show: true});

                  }
                  //});

                  });
                  $(".select-box").change(function(event){
                  if (this.checked){
                  document.getElementById('errorbox').innerHTML="This is Your Gift.";
                  $('#putErrorGiftBox').modal({show: true});
                  }

                  });

                  });
               }

            });

        }
  function ClosePutErrorGiftBox()
{ //alert('ok');
  $('#putErrorGiftBox').modal('hide');
}

</script>
<style>

#giftimagesrow{ width: 100%; float: left; }
#giftimagesrow .col-md-4{
  float: none;
  display:inline-block;
  }

/*#giftimagesrow._g1 ._col0{
  }
#giftimagesrow._g1 ._col1{
  }
#giftimagesrow._g1 ._col2{
  }*/

#giftimagesrow._g2 ._col0{
  float: right;
  }
/*#giftimagesrow._g2 ._col1{
  }*/
#giftimagesrow._g2 ._col2{
 float: left;
  }

 #giftimagesrow._g3 ._col0{
float: right;
  }
#giftimagesrow._g3 ._col1{
  float: left;
  }
/*#giftimagesrow._g3 ._col2{
  } */

#giftimagesrow._g4 ._col0{
float: right;
  }
/*#giftimagesrow._g4 ._col1{
  }*/
#giftimagesrow._g4 ._col2{
   float: left;
  }


#giftimagesrow._g5 ._col0{
float: left;
  }
#giftimagesrow._g5 ._col1{
     float: right;
  }
/*#giftimagesrow._g5 ._col2{
  } */


/*#giftimagesrow._g6 ._col0{

  }*/
#giftimagesrow._g6 ._col1{
     float: left;
  }
#giftimagesrow._g6 ._col2{
  float: right;
}


</style>
