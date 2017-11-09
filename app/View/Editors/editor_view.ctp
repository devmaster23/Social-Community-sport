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
<section class="content-header">
	<h1><?php echo __dbt('View User'); ?>
	  <small><?php echo __dbt('Users Details'); ?></small>
	</h1>
	 
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('Users Details'); ?></h3>
                           <a href="/editor/editors" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
			</div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						<tr>
						  <td><?php echo __dbt('Sport'); ?></td>
						  <td><?php echo h($news['Sport']['name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Description'); ?></td>
						  <td><?php echo strip_tags($news['News']['description']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('News Image'); ?></td>
						  <td><?php echo $this->Html->image($news['File']['path'],array('style'=>'width:30%'));?></td>
						</tr>
						
						<tr>
						  <td><?php echo __dbt('Status'); ?></td>
						  <td><?php echo h($news['News']['status_name']); ?></td>
						</tr>
		
						<tr>
						  <td><?php echo __dbt('Created'); ?></td>
						  <td><?php echo h($news['News']['created']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Modified'); ?></td>
						  <td><?php echo h($news['News']['modified']); ?></td>
						</tr>
				      </tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>
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