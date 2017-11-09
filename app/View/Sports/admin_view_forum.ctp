<section class="content-header">
	<h1><?php echo __dbt('View Forum'); ?>
	  <small><?php echo __dbt('Forum Details'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('Forum Details'); ?></h3>
                          <a class="btn btn-warning pull-right" href="/admin/sports/polls"><?php echo __dbt('Back');?></a>
			</div>
                    
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						
						<tr>
						  <td><?php echo __dbt('Fourm Content'); ?></td>
						  <td><?php echo strip_tags($poll['Poll']['name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Status'); ?></td>
						  <td><?php echo h($poll['Poll']['status_name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Created'); ?></td>
						  <td><?php echo h($poll['Poll']['created']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Modified'); ?></td>
						  <td><?php echo h($poll['Poll']['modified']); ?></td>
						</tr>
				      </tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>