    <?php
    ini_set("allow_url_fopen", 1);
    echo "<h1>As Per Yahoo! Finance Rates:</h1>";
    $yahoo_rates = file_get_contents('http://download.finance.yahoo.com/d/quotes.csv?s=USDINR=X&f=sl1d1t1ba&e=.csv');
    $yahoo_rates = explode(",", $yahoo_rates);
    
    __dbt("FROM:");?> <select id="from"><option value="USD">USD</option><option value="JPY">JPY</option><option value="BGN">BGN</option><option value="CZK">CZK</option><option value="DKK">DKK</option><option value="GBP">GBP</option><option value="HUF">HUF</option><option value="LTL">LTL</option><option value="LVL">LVL</option><option value="PLN">PLN</option><option value="RON">RON</option><option value="SEK">SEK</option><option value="CHF">CHF</option><option value="NOK">NOK</option><option value="HRK">HRK</option><option value="RUB">RUB</option><option value="TRY">TRY</option><option value="AUD">AUD</option><option value="BRL">BRL</option><option value="CAD">CAD</option><option value="CNY">CNY</option><option value="HKD">HKD</option><option value="IDR">IDR</option><option value="ILS">ILS</option><option value="INR">INR</option><option value="KRW">KRW</option><option value="MXN">MXN</option><option value="MYR">MYR</option><option value="NZD">NZD</option><option value="PHP">PHP</option><option value="SGD">SGD</option><option value="THB">THB</option><option value="ZAR">ZAR</option></select>
    <?php __dbt("TO:");?> <select id="to"><option value="USD">USD</option><option value="JPY">JPY</option><option value="BGN">BGN</option><option value="CZK">CZK</option><option value="DKK">DKK</option><option value="GBP">GBP</option><option value="HUF">HUF</option><option value="LTL">LTL</option><option value="LVL">LVL</option><option value="PLN">PLN</option><option value="RON">RON</option><option value="SEK">SEK</option><option value="CHF">CHF</option><option value="NOK">NOK</option><option value="HRK">HRK</option><option value="RUB">RUB</option><option value="TRY">TRY</option><option value="AUD">AUD</option><option value="BRL">BRL</option><option value="CAD">CAD</option><option value="CNY">CNY</option><option value="HKD">HKD</option><option value="IDR">IDR</option><option value="ILS">ILS</option><option value="INR">INR</option><option value="KRW">KRW</option><option value="MXN">MXN</option><option value="MYR">MYR</option><option value="NZD">NZD</option><option value="PHP">PHP</option><option value="SGD">SGD</option><option value="THB">THB</option><option value="ZAR">ZAR</option></select>
    <a href="javascript:void(0);" onclick="getRate();">GET RATES</a>
    <div id="yahoo-rates">
    <table>
        <tr>
            <th>Params</th>
            <th>Value</th>
        </tr>
        <?php
            $i=0;
            $keyy = array("FROM-TO","VALUE","DATE","TIME","PARAM1","PARAM2");
            foreach($yahoo_rates as $yr){
                echo "<tr><td>$keyy[$i]</td><td>".$yr."</td></tr>";
                $i++;
            }
        ?>
    </table>
    </div>
    <br>
    <br>
    <h1>As Per ECB Stats:</h1>
    <table>
        <tr>
            <th>Currency</th>
            <th>Rate</th>
        </tr>
    <?php
    $xml=simplexml_load_file("http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml");
    $i=0;
    $option = "";
    foreach($xml->Cube[0]->Cube->Cube as $vals){
        if($i%2==0)
        {echo "<tr>";}
        foreach($vals->attributes() as $key=>$rates){
            echo "<td>".$rates."</td>";       
        }
        if($i%2==0){
        echo "</tr>";}
        $i++;
    }
    ?>
    </table>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript">
        //diable firebug
       
        function getRate(){
            document.getElementById("yahoo-rates").innerHTML = "<img src='/img/loading.gif'>";
            from = document.getElementById('from').value;
            to = document.getElementById('to').value;
            $.post("<?php echo $this->Html->url(array("controller"=>"tests","action"=>"getCurrencyRate")); ?>",{'from':from,'to':to,'access_Token':'OO0OO0OO0O0O0O0O0OO0O'},function(data){
                document.getElementById("yahoo-rates").innerHTML = data;
            });
        }
    </script>

