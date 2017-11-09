<div class="main-wrap">
   <div class="container">
      <div class="event-title">
            <h4><?php echo __dbt('YouTube Video'); ?></h4>
      </div>  
      <!-- Inner wrap start -->
      <div class="inner-wrap">
            <div class="row">
          <!-- Sidebar start -->
                <div class="col-sm-2">
                <?php echo $this->element($elementFolder.'/sidebar'); ?>
                </div>
                <div class="col-sm-10">
                      <table class="table table-striped vdo-mbl-tb">
                              <tbody>

                                      <tr>
                                        <td><?php echo __dbt('YouTube Url'); ?></td>
                                        <td><?php preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $videos['WallContent']['name'], $matches);
                                                                    
                                            ?>
                                            <iframe width="400" height="220" src="<?php echo 'http://www.youtube.com/embed/'.$matches[1]; ?>" frameborder="0"></iframe>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><?php echo __dbt('Title'); ?></td>
                                        <td><?php echo h(__dbt($videos['WallContent']['title'])); ?></td>
                                      </tr>

                                      <tr>
                                        <td><?php echo __dbt('Status'); ?></td>
                                        <td><?php if($videos['WallContent']['status']==0){echo __dbt('Inactive');}else{echo __dbt('Active');} ?></td>
                                      </tr>
                                      <tr>
                                        <td><?php echo __dbt('Created'); ?></td>
                                        <td><?php echo h($videos['WallContent']['created']); ?></td>
                                      </tr>
                                      <tr>
                                        <td><?php echo __dbt('Modified'); ?></td>
                                        <td><?php echo h($videos['WallContent']['modified']); ?></td>
                                      </tr>
                            </tbody>
                      </table>    
                </div>    
           </div> 
      </div>  
      <!-- Inner wrap end -->
   </div>
</div>   
