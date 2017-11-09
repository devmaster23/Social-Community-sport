<div class="space-15">
    <div class="row">
        <div class="col-xs-12 popup-table-formate">

            <div class="table-responsive">
                <table border="0" class="table table-bordered table" cellpadding="0" cellspacing="0">
                 
                    <tr> 
                        <th><?php echo __dbt('Name :');?></th>
                        <td><?php echo __dbt($dataExists['User']['name']);?></td>
                                  
                    </tr>
                   <?php  //foreach ($dataExists as $dataExist)
                    //{ //echo '<pre>';print_r($dataExists);?>
                      
                  <tr> 
                       <th><?php echo __dbt('Email :');?></th>
                        <td><?php echo __dbt($dataExists['User']['email']);?></td>
                    </tr>
                    <?php //} ?>
                </table>
            </div>
        </div>  
    </div>
</div>
