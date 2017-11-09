<div class="space-15">
    <div class="row">
        <div class="col-xs-12 popup-table-formate">
            <div class="table-responsive">
                <table border="0" class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
                 
                    <tr> 
                        <th><?php echo __dbt('Teams & Scores');?></th>
                        
                        
                    </tr>
                   <?php  foreach ($dataExists as $dataExist)
                    {?>
                    <tr> 
                  
                       <td><?php echo __dbt($dataExist['team']['name'].'&nbsp &nbsp '.$dataExist['SoccerPrediction']['first_team_goals']).'&nbsp &nbsp<strong>V/S</strong>&nbsp &nbsp'. $dataExist['secondteam']['name'].'&nbsp &nbsp '.$dataExist['SoccerPrediction']['second_team_goals']?></td>
                    </tr>
                 
                    <?php } ?>
                </table>
            </div>
        </div>  
    </div>
</div>
