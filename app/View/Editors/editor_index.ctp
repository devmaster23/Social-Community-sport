<div class="main-wrap">
   <div class="container">
       
        <?php 
            if(!isset($auth_error) && !isset($reg_errors)){
                echo $this->Flash->render(); 
            }
        ?>
       <?php echo $this->Common->topNavSports(AuthComponent::User('id')); ?>
      <div class="event-title">
            <h4><?php echo __dbt('Dashboard'); ?></h4>
      </div>  
      <!-- Inner wrap start -->
      <div class="inner-wrap">
          <div class="row">
          <!-- Sidebar start -->
          <div class="col-xs-12 col-sm-2">
          	<?php echo $this->element($elementFolder.'/sidebar'); ?>
          </div>

          <!-- Sidebar end -->
          <!-- Main content start -->
          <div class="col-xs-12 col-sm-10">
              <div class="main-content">
                <div class="profile-form-layout">
                    <!-- filters starts-->
            <div class="UserAdminIndexForm">
                <div class="box-body">
                   <div class="row">
                     <?php echo $this->Form->create('News', array('type' => 'get', 'url' => array('controller' => 'editors', 'action' => 'index', $this->params["prefix"] => true,'class'=>"form-control"), "novalidate"=>"novalidate")); ?>
    
                    <?php 
                    $sports_new_array = array();
                    foreach ($sports as $key => $value) {
                        $sports_new_array[$key] = __dbt($value);
                    }
                    $status_new_array = array();
                    foreach ($status as $key1 => $value1) {
                        $status_new_array[$key1] = __dbt($value1);
                    }
                    echo "<div class='col-md-3 col-xs-6 col-sm-mbl'>". $this->Form->input("News.foreign_key", array("type"=>"select", "empty"=>__dbt("-- Select Sport --"), "options"=>$sports_new_array, "label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?>
                    <?php echo "<div class='col-md-3 col-xs-6 col-sm-mbl'>". $this->Form->input("News.status", array("type"=>"select", "empty"=>__dbt("-- Select Status --"), "options"=>$status_new_array, "label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?>
                    <div class='col-md-3 col-xs-6 admin-search-btn'>
                        <input type="<?php echo __dbt('submit');?>" class="btn bg-olive margin pospad" value="<?php echo __dbt('Search')?>">	
                        <a href="<?php echo $this->here; ?>" class="btn btn-warning pospad" ><?php echo __dbt('Reset'); ?></a>
                    </div>	
                    <?php echo $this->Form->end(); ?>
                                   <?php echo $this->Html->link(__dbt("Add"),array('controller' => 'editors', 'action' => 'add','editor'=>true),array('escape' => false,'class'=>'btn btn-warning pospad')); ?>
                   </div>
                                
                </div>
                        <div class="clear"></div>
            </div>
                    <div class="clear"></div>
                        <div class="table-responsive">
                <table id="example2" class="table table-hover table-bordered table-striped">
                                <thead>
                                        <tr>    
                                           
                                           <th><?php echo $this->Paginator->sort('Sport.name',__dbt('Sport')); ?></th>
                                           <th><?php echo $this->Paginator->sort('publish',__dbt('Approved By Admin')); ?></th>
                                           <th><?php echo $this->Paginator->sort(__dbt('description')); ?></th>
                                           <th><?php echo $this->Paginator->sort(__dbt('status')); ?></th>
                                           <th class="actions"><?php echo __dbt('Actions'); ?></th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($news)) { //pr($news);die;
                                            foreach ($news as $news): ?>
                    <tr>
                        <td><?php echo __dbt($news['Sport']['name']); ?>&nbsp;</td>
                        <td>
                                                <?php if($news['News']['publish']==1){
                                                        echo "<span style='color:green'>".__dbt('Approved by admin')."</span>";
                                                      }else{
                                                       echo "<span style='color:red
                                                           '>".__dbt('Pending for admin approval')."</span>";
                                                      } ?>&nbsp;
                                            </td>
                        <td><?php if(strlen($news['News']['description'])>50){
                            echo strip_tags(substr($news['News']['description'],0,50).'....');
                              }else{
                            echo strip_tags($news['News']['description']);
                              } ?>&nbsp;</td>
                        
                        <td><?php echo h(__dbt($news['News']['status_name'])); ?>&nbsp;</td>
                        <td class="actions">
                                                <?php echo $this->Html->link(__dbt(''), array('action' => 'view', base64_encode($news['News']['id'])),array('class'=>'fa fa-eye','title'=>__dbt('View News'))); ?>
                                                <?php echo $this->Html->link(__dbt(''), array('action' => 'edit', base64_encode($news['News']['id'])),array('class'=>'fa fa-edit','title'=>__dbt('Edit News'))); ?>
                                                <?php echo $this->Form->postLink(__dbt(''), array('action' => 'delete', base64_encode($news['News']['id'])),array('class'=>'fa fa-remove','title'=>__dbt('Delete News')), array(__dbt('Are you sure you want to delete this news ?'))); ?>
                                                
                                                    </td>
                                           
                    </tr>
                                    <?php endforeach; } else {?>
                                    <tr>    
                                        <td class="text-center" colspan="5"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                        </table>
                </div>
                        <div class="row">
                                <div class="col-sm-5">
                                        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite"><?php echo $this->element('pagination',array('paging_action'=>$this->here));?>                                                                                                                
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
            <style>
/*                .pospad{padding: 4px 20px 3px 20px ;}
                .clear{display: inline-block;}*/
            </style>