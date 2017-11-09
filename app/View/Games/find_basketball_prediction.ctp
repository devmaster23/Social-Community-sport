<div class="space-15">
    <div class="row">
        <div class="col-xs-12 popup-table-formate">
            <div class="table-responsive">
                <table border="0" class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
                 
                    <tr> 
                        <th><?php echo __dbt('Teams & scores');?></th>
                        <!--th--><?php //echo __dbt('Score');?><!--/th-->
                        
                    </tr>
                   <?php  foreach ($dataExists as $dataExist)
                    {?>
                    <tr>

                       <td><?php echo __dbt($dataExist['team']['name'].'&nbsp &nbsp '.$dataExist['BasketballPrediction']['first_team_goals']).'&nbsp &nbsp<strong>V/S</strong>&nbsp &nbsp'. $dataExist['secondteam']['name'].'&nbsp &nbsp '.$dataExist['BasketballPrediction']['second_team_goals']?></td>
                      

                    </tr>
                 
                    <?php } ?>
                </table>
            </div>
        </div>  
    </div>
</div>
