<section class="content-header">
	<h1><?php echo __dbt('View Sports'); ?>
	  <small><?php echo __dbt('Sports Details'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('Sports Details'); ?></h3>
                          <a class="btn btn-warning pull-right" href="javascript:window.history.back();"><?php echo __dbt('Back');?></a>
			</div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						
						<tr>
						  <td><?php echo __dbt('Name'); ?></td>
						  <td><?php echo h($sport['Sport']['name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Tile Image'); ?></td>
                                                  <td ><div class="img-Preview"><?php   echo $this->Sport->showTileImage($sport['Sport']['tile_image']);?></div></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Banner Image'); ?></td>
						  <td><div class="img-Preview"><?php  echo $this->Sport->sportBannerImage($sport['Sport']['banner_image']);?></div></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('User'); ?></td>
						  <td><?php echo $this->Html->link($sport['User']['name'], array('controller' => 'users', 'action' => 'view', base64_encode($sport['User']['id']))); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Status'); ?></td>
						  <td><?php echo h($sport['Sport']['status_name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Created'); ?></td>
						  <td><?php echo h($sport['Sport']['created']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Modified'); ?></td>
						  <td><?php echo h($sport['Sport']['modified']); ?></td>
						</tr>
				      </tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>