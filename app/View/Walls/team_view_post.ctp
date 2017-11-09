<section class="content-header">
	<h1><?php echo __dbt('View Post'); ?>
	  <small><?php echo __dbt('Team Post Details'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('Post Details'); ?></h3>
                          <a href="/team/walls/post" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
			</div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						<tr>
						  <td><?php echo __dbt('Title'); ?></td>
						  <td><?php echo __dbt($wallPost['WallContent']['name']); ?></td>
						</tr>
						<?php if($wallPost['WallContent']['file_id']) { ?>
                                                <tr>
						  <td><?php echo __dbt('Post Image '); ?></td>
                                                  <td>
                                                  <div class="col-sm-4 img-Preview">
                                                    <?php echo $this->Wall->showPostUpload($wallPost['WallContent']['file_id'],$wallPost['WallContent']['content_type']); ?>
                                                   </div>
                                                  </td>
                                                  
						</tr>
                                                <?php } ?>
                                                <tr>
						  <td><?php echo __dbt('Status'); ?></td>
						  <td><?php echo h($wallPost['WallContent']['status_name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Created'); ?></td>
						  <td><?php echo h($wallPost['WallContent']['created']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Modified'); ?></td>
						  <td><?php echo h($wallPost['WallContent']['modified']); ?></td>
						</tr>
				      </tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>

