<div class="space-15">
    <div class="row">
        <div class="col-xs-12 popup-table-formate">
         <div class="table-responsive">
                <table border="0" class="table table-bordered table" cellpadding="0" cellspacing="0">
                 <tr> 
                        <th><?php echo __dbt('Type');?></th>
                        <th><?php echo __dbt('Name/amount');?></th>
                        <th><?php echo __dbt('No. of games must be correct');?></th>
                        
                    </tr>
                   
                    <tr>
                    <?php if($giftdata[0]['gift']['type']==1){
                    $giftname="Gift";
                    $giftvalue=$giftdata[0]['gift']['name'];
                    } if($giftdata[0]['gift']['type']==2){
                    $giftname="Cash";
                    $giftvalue=$giftdata[0]['gift']['amount'].'(USD)-<span style="font-weight:bold;">Payable amount</bold>:'.$giftdata[0]['GamesGiftPrediction']['cashamount'];
                    }
                    ?>
                    <td><?php echo __dbt($giftname);?></td>
                    <td><?php echo __dbt($giftvalue);?></td>
                    <td><?php echo __dbt($giftdata[0]['gift']['winning_no_game']);?></td>
                    </tr>

            </div>
            <div class="table-responsive">
                <table border="0" class="table table-bordered table" cellpadding="0" cellspacing="0">
                 
                    <tr> 
                        <th><?php echo __dbt('Team Name');?></th>
                        <th><?php echo __dbt('Original Score');?></th>
                        <th><?php echo __dbt('Predicted score');?></th>
                        
                    </tr>
                   <?php  foreach ($dataExists as $dataExist)
                    { //echo '<pre>';print_r($dataExist);?>
                      <?php $orignalscore = $dataExist['gameresult']['first_team_goals'].'/'.$dataExist['gameresult']['second_team_goals'];?>
                      <?php $predictedscore = $dataExist['SoccerPrediction']['first_team_goals'].'/'.$dataExist['SoccerPrediction']['second_team_goals'];
                      if($orignalscore==$predictedscore){
                      ?>

                   <tr bgcolor="#AAC442" style="color:white;"> 
                    

                       <td><?php echo __dbt($dataExist['team']['name'].'<strong>V/S</strong>' .$dataExist['secondteam']['name']);?></td>
                      
                       <td><?php echo $orignalscore;?></td>
                       <td><?php echo $predictedscore;?></td>
                    </tr>
                  <?php } else {?>
                  <tr> 
                    

                       <td><?php echo __dbt($dataExist['team']['name'].'<strong>V/S</strong>' .$dataExist['secondteam']['name']);?></td>
                      
                       <td><?php echo $orignalscore;?></td>
                       <td><?php echo $predictedscore;?></td>
                    </tr>
                    <?php } }?>
                </table>
            </div>
        </div>  
    </div>
</div>
