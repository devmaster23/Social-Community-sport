<style>
    .border-black{border: 1px solid #fcfcfc;}
</style>
<div >
<?php
if (!empty($gifts)) {
    if ($_GET['type'] == 1 || $_GET['type'] == '') {
        ?>
    <div class="row">
            <?php
            ini_set("allow_url_fopen", 1);

            $yahoo_rates = file_get_contents('http://download.finance.yahoo.com/d/quotes.csv?s=USDINR=X&f=sl1d1t1ba&e=.csv');
            $yahoo_rates = explode(",", $yahoo_rates);
            ?>
            <div class="col-sm-4"> <?php echo __dbt("FROM:");?> <select id="from" class="form-control"><option value="USD">USD</option></select></div>
            <div class="col-sm-4"><?php echo __dbt("TO:");?> <select id="to" class="form-control"><option value="USD">USD</option><option value="JPY">JPY</option><option value="BGN">BGN</option><option value="CZK">CZK</option><option value="DKK">DKK</option><option value="GBP">GBP</option><option value="HUF">HUF</option><option value="LTL">LTL</option><option value="LVL">LVL</option><option value="PLN">PLN</option><option value="RON">RON</option><option value="SEK">SEK</option><option value="CHF">CHF</option><option value="NOK">NOK</option><option value="HRK">HRK</option><option value="RUB">RUB</option><option value="TRY">TRY</option><option value="AUD">AUD</option><option value="BRL">BRL</option><option value="CAD">CAD</option><option value="CNY">CNY</option><option value="HKD">HKD</option><option value="IDR">IDR</option><option value="ILS">ILS</option><option value="INR">INR</option><option value="KRW">KRW</option><option value="MXN">MXN</option><option value="MYR">MYR</option><option value="NZD">NZD</option><option value="PHP">PHP</option><option value="SGD">SGD</option><option value="THB">THB</option><option value="ZAR">ZAR</option></select></div>
            <div class="col-sm-4 rates-col"> 
            	<label>GET RATES</label>
                <a href="javascript:void(0);" onclick="getRate();"><?php echo __dbt("GET RATES");?></a>
                <div id="yahoo-rates"></div>
            </div>
        <div class="clear"></div>
    </div>
    
    <div class="row space20">
    	<div id="example2" class="table-responsive col-xs-12">
        	<table class="table table-bordered">
                <thead>
                    <tr>      
    
                        <th>#</th>
                        <th><?php echo __dbt('Name'); ?></th>
                        <th><?php echo __dbt('For'); ?></th>
                        <th><?php echo __dbt('Type'); ?></th>
                        <th><?php echo __dbt('Amount'); ?></th>
                        
    
                    </tr>
                </thead>
                <tbody id="Gift">
                    <?php
                    if (!empty($gifts)) { //pr($gifts);die;
                        $listHTML = '';
                        foreach ($gifts as $gifts):
    
                            $amtPrice = $gifts['Gift']['type_status'];
                            $giftId = $gifts['Gift']['id'];
                            $giftname = $gifts['Gift']['name'];
                            $catname = $gifts['GiftCategory']['name'];
                            $amount = $gifts['Gift']['amount'];
                            $giftname = $gifts['Gift']['name'];
                            $href = $gifts['Gift']['product_link'];
    
                            $listHTML .= '<tr>
                                            <td><input type="radio" name="data[CricketPrediction][gift_id]" id="selectGift" value="' . $this->Text->truncate($giftId) . '" class="radioinput">&nbsp;</td>
<td><a target="_blank" href="' . $href . '">' . $this->Text->truncate($giftname) . '</a></td>                                            

                                            <td>' . $this->Text->truncate(ucFirst($catname)) . '&nbsp;</td>
                                            <td>' . $this->Text->truncate($amtPrice) . '&nbsp;</td>
                                            <td class="calcamount" id="amount_id_' . $this->Text->truncate($giftId) . '" data-amount="' . $this->Text->truncate($amount) . '">' . $amount . '&nbsp;</td>
                                           
                                        </tr>';
                        endforeach;
                        echo $listHTML;
                    } else {
                        ?>
    
                        <tr>    
                            <td class="text-center" colspan="100%"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
                        </tr>
    
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div id="moreButton" class="col-xs-12 text-center">
            <?php
            if (!empty($this->params["paging"]["Gift"]["nextPage"])) {

                echo $this->Paginator->next('LOAD MORE GIFTS', array('onclick' => 'return gohere(this.href);'), null);
            }
            ?>                                
        </div>
	</div>
        <?php
        echo '<div class="clear"></div>';
        echo '</div>';
    } else {
        ?>
    <div class="row">
        
            <?php
            ini_set("allow_url_fopen", 1);

            $yahoo_rates = file_get_contents('http://download.finance.yahoo.com/d/quotes.csv?s=USDINR=X&f=sl1d1t1ba&e=.csv');
            $yahoo_rates = explode(",", $yahoo_rates);
            ?>
            <div class="col-sm-4"> <?php echo __dbt("FROM:");?> <select id="from" class="form-control"><option value="USD">USD</option></select></div>
            <div class="col-sm-4"><?php echo  __dbt("TO:");?> <select id="to" class="form-control"><option value="USD">USD</option><option value="JPY">JPY</option><option value="BGN">BGN</option><option value="CZK">CZK</option><option value="DKK">DKK</option><option value="GBP">GBP</option><option value="HUF">HUF</option><option value="LTL">LTL</option><option value="LVL">LVL</option><option value="PLN">PLN</option><option value="RON">RON</option><option value="SEK">SEK</option><option value="CHF">CHF</option><option value="NOK">NOK</option><option value="HRK">HRK</option><option value="RUB">RUB</option><option value="TRY">TRY</option><option value="AUD">AUD</option><option value="BRL">BRL</option><option value="CAD">CAD</option><option value="CNY">CNY</option><option value="HKD">HKD</option><option value="IDR">IDR</option><option value="ILS">ILS</option><option value="INR">INR</option><option value="KRW">KRW</option><option value="MXN">MXN</option><option value="MYR">MYR</option><option value="NZD">NZD</option><option value="PHP">PHP</option><option value="SGD">SGD</option><option value="THB">THB</option><option value="ZAR">ZAR</option></select></div>
            <div class="col-sm-4 rates-col"> 
                <a href="javascript:void(0);" onclick="getRate();"> <?php __dbt("GET RATES");?></a>
                <div id="yahoo-rates"></div>
            </div>
            <div class="clear"></div>
        
    </div>

        
    <div class="row space20">
    	<div id="example2" class="table-responsive col-xs-12">
    <table id="example2" class="table table-bordered table-responsive">
            <thead>
                <tr>      

                    <th>#</th>
                    <th><?php echo __dbt('For'); ?></th>
                    <th><?php echo __dbt('Type'); ?></th>
                    <th><?php echo __dbt('Amount'); ?></th>

                </tr>
            </thead>
            <tbody id="Gift">
                <?php
                if (!empty($gifts)) { //pr($gifts);die;
                    $listHTML = '';
                    foreach ($gifts as $gifts):

                        $amtPrice =  $gifts['Gift']['type_status'];
                        $giftId = $gifts['Gift']['id'];
                        $catname = $gifts['GiftCategory']['name'];
                        $amount = $gifts['Gift']['amount'];
                        $giftname = $gifts['Gift']['name'];
                        
                        $listHTML .= '<tr>
                                        <td><input type="radio" name="data[CricketPrediction][amount]" id="selectGift" value="' . $this->Text->truncate($amount) . '" class="radioinput">&nbsp;</td>
                                        <td>' . $this->Text->truncate(ucFirst($catname)) . '&nbsp;</td>
                                        <td>' . $this->Text->truncate($amtPrice) . '&nbsp;</td>
                                        <td class="calcamount" id="amount_id_' . $this->Text->truncate($giftId) . '" data-amount="' . $this->Text->truncate($amount) . '">' . $amount . '&nbsp;</td>
                                    </tr>';
                    endforeach;
                    echo $listHTML;
                } else {
                    ?>

                    <tr>    
                        <td class="text-center" colspan="100%"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
                    </tr>

                <?php }
                ?>
            </tbody>
        </table>
            </div>
       <div id="moreButton" class="col-xs-12 text-center">
            <?php
            if (!empty($this->params["paging"]["Gift"]["nextPage"])) {

                echo $this->Paginator->next('LOAD MORE GIFTS', array('onclick' => 'return gohere(this.href);'), null);
            }
            ?>                                
        </div>
        </div>
        <?php
        echo '<div class="clear"></div>';
        echo '</div>';
    }
}else{
    echo "<ul><li>".__dbt('No result Found')."</li></ul>";
}
?>
</div>

<script>
    function gohere(href) {
        if (typeof (href) === 'undefined') {
            return false;
        }
        $.post(href, {ajaxpost: 'true'}, function(data) {
            var response = $.parseJSON(data);
            $("#Gift").append(response.html);
            if (response.page != "0") {
                $("#moreButton").html(response.page);
            } else {
                $("#moreButton").remove();
            }
            
            if(document.getElementById("yahoo-rates").innerHTML!=''){
                var data = document.getElementById("yahoo-rates").innerHTML;
                $('.calcamount').each(function(){
                    var amt = data*parseFloat($(this).data('amount'));
                    $(this).html(amt);
                });
            } 
                
                
            
            
            
        });
        return false;
    }
</script>