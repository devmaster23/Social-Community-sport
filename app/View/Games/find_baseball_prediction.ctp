<div class="space-15">
    <div class="row">
        <div class="col-xs-12 popup-table-formate">
            <div class="table-responsive">
                <table border="0" class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
                    <tr> 
                        <th><?php echo __dbt('Team Name');?></th>
                        <th><?php echo __dbt('Score');?></th>
                    </tr>
                    <tr> 
                        <td><?php echo __dbt($firstTeam);?></td>
                        <td><?php echo __dbt($dataExist['BaseballPrediction']['first_team_score']);?></td>
                    </tr>
                    <tr> 
                        <td><?php echo __dbt($secondTeam);?></td>
                        <td><?php echo __dbt($dataExist['BaseballPrediction']['second_team_score']);?></td>
                    </tr>
                </table>
            </div>
        </div>  
    </div>
</div>

