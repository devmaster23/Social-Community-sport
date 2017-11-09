<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Inactivate',    <?php echo $totle[0][0]['count(id)'] - $loging[0][0]['count(user_id)']; ?>],
          ['Activate ',     <?php echo $loging[0][0]['count(user_id)']; ?>]
      
        ]);

        var options = {
          title: 'Users Monthly Analysis (<?php echo  $to; ?> to <?php echo  $from; ?>)'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

  
    <hr>



    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
         
          ['<?php echo $sixthday[0][0]['day'];?>', 0, 0, <?php echo $sixthday[0][0]['count(user_id)'];?>, <?php echo $sixthday[0][0]['count(user_id)'];?>],
          ['<?php echo $fifthday[0][0]['day'];?>', 0, 0, <?php echo $fifthday[0][0]['count(user_id)'];?>, <?php echo $fifthday[0][0]['count(user_id)'];?>],
          ['<?php echo $forthday[0][0]['day'];?>', 0, 0, <?php echo $forthday[0][0]['count(user_id)'];?>, <?php echo $forthday[0][0]['count(user_id)'];?>],
          ['<?php echo $thirdday[0][0]['day'];?>', 0, 0, <?php echo $thirdday[0][0]['count(user_id)'];?>, <?php echo $thirdday[0][0]['count(user_id)'];?>],
          ['<?php echo $secondday[0][0]['day'];?>', 0, 0, <?php echo $secondday[0][0]['count(user_id)'];?>, <?php echo $secondday[0][0]['count(user_id)'];?>],
          ['<?php echo $firstday[0][0]['day'];?>', 0, 0, <?php echo $firstday[0][0]['count(user_id)'];?>, <?php echo $firstday[0][0]['count(user_id)'];?>],
          ['<?php echo $today[0][0]['day'];?>', 0, 0, <?php echo $today[0][0]['count(user_id)'];?>, <?php echo $today[0][0]['count(user_id)'];?>],
          // Treat the first row as data.
        ], true);

 
        var options = {
          title: 'Users Weekly Analysis (<?php echo  $sevenday; ?> to <?php echo  $from; ?>)',
          legend: 'none',
          bar: { groupWidth: '100%' }, // Remove space between bars.
         
           hAxis:{"maxAlternation":1},
          vAxis: {  minValue: 4,                   
                viewWindow:{min:0}, /*this also makes 0 = min value*/        
                format: '0',                    
            },
          candlestick: {
            fallingColor: { strokeWidth: 0, fill: '#a52714' }, // red
            risingColor: { strokeWidth: 0, fill: '#0f9d58' }   // green
          }
        };

        var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
   <div class="col-md-12" style="text-align:center;">
    <div class="col-md-4" id="piechart" style="width: 40%; height: 300px;"></div>
    <div class="col-md-8" id="chart_div" style="width: 60%; height: 300px;"></div>
    </div>
    <hr>
    <div style="clear:both;"></div>
                <!-- filters ends-->
                <div class="col-md-12" style="text-align:center;">
                <div class="box-body">
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>     
                                <th style="text-align:center;"><?php echo $this->Paginator->sort('User Name'); ?></th>
                                <th style="text-align:center;"><?php echo $this->Paginator->sort('Follow Teams'); ?></th>
                               
                                <th style="text-align:center;"><?php echo $this->Paginator->sort('Last Active On'); ?></th>
                                <th style="text-align:center;"><?php echo $this->Paginator->sort('No of logged IN'); ?></th>
                             
                        </thead>
                        <tbody>
                          <?php
                            if (!empty($data)) {
                                foreach ($data as $row)
                                {
                                   
                                        ?>
                                        <tr>
                                            <td><?php echo h($row['users']['name']); ?>&nbsp;</td>
                                            <td><?php echo h($row['0']['team']); ?>&nbsp;</td>
                                            <td><?php echo h($row['0']['L_time']); ?>&nbsp;</td>
                                            <td><?php echo h($row['0']['login_count']); ?>&nbsp;</td>
                                        

                                        </tr>
                                    <?php
                                }
                            }
                            else
                            { ?>
                                <tr>   
                                    <td class="text-center" colspan="11"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
                                </tr>
<?php } ?>

                             
            
                        </tbody>
                    </table>
                  
                    </div>
        </div>

