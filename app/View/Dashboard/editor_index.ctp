<div class="main-wrap">
   <div class="container">
      <div class="event-title">
            <h4><?php echo __dbt('Dashboard'); ?></h4>
      </div>  
      <!-- Inner wrap start -->
      <div class="inner-wrap">
          <div class="row">
          <!-- Sidebar start -->
          <div class="col-sm-2">
          <?php echo $this->element($elementFolder.'/sidebar'); ?>
          </div>

          <!-- Sidebar end -->
          <!-- Main content start -->
          <div class="col-sm-10">
          <div class="main-content">
            <div class="profile-form-layout">
                    <div class="box-body">
                    <table id="example2" class="table table-hover table-bordered table-striped">
                            <thead>
                                    <tr>    
                                       <th><?php echo $this->Paginator->sort('title'); ?></th>
                                       <th><?php echo $this->Paginator->sort('name'); ?></th>
                                       <th><?php echo $this->Paginator->sort('status'); ?></th>
                                       <th class="actions"><?php echo __dbt('Actions'); ?></th>
                                    </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($videos)) { foreach ($videos as $video): ?>
                            <tr>
                                    <td><?php echo h($video['WallContent']['title']); ?>&nbsp;</td>
                                    <td><?php echo __dbt($video['WallContent']['name']); ?>&nbsp;</td>
                                    <td><?php echo h($video['WallContent']['status_name']); ?>&nbsp;</td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__dbt(''), array('action' => 'view', base64_encode($video['WallContent']['id'])),array('class'=>'fa fa-eye','title'=>__dbt('View Video'))); ?>
                                        <?php echo $this->Html->link(__dbt(''), array('action' => 'edit', base64_encode($video['WallContent']['id'])),array('class'=>'fa fa-edit','title'=>__dbt('Edit Video'))); ?>
                                        <?php echo $this->Form->postLink(__dbt(''), array('action' => 'delete', base64_encode($video['WallContent']['id'])),array('class'=>'fa fa-remove','title'=>__dbt('Delete Video')), array(__dbt('Are you sure you want to delete video ?'))); ?>
                                     </td>

                            </tr>
                            <?php endforeach; } else {?>
                            <tr>
                                <td colspan="4" class="text-center"><?php echo __dbt('No record available.');?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                    </table>
                    <div class="row">
                            <div class="col-sm-5">
                                    <div class="dataTables_info" id="example2_info" role="status" aria-live="polite"><?php
                                    //echo $this->Paginator->counter(array('format' => __dbt('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
                                    </div>
                            </div>
                            <div class="col-sm-7">
                            </div>
                    </div>
            </div>
            </div>
                   

                   
            </div>
            </div>
          <!-- Main content end -->
        
      </div> 
      </div>  
      <!-- Inner wrap end -->
   </div>
</div>   
               
          
            <!-- Middle end -->
