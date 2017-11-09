<section class="content-header">
	<h1><?php echo __dbt('View Page'); ?>
	  <small><?php echo __dbt('Static Page Details'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt($pages['StaticPage']['name'].' Details'); ?></h3>
                          <a href="/admin/staticPages" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
                        </div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						
						<tr>
						  <td><?php echo __dbt('Name'); ?></td>
						  <td><?php echo h($pages['StaticPage']['name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Description'); ?></td>
                                                  <td><?php echo html_entity_decode($pages['StaticPage']['description']); ?></td>
						</tr>
						
				      </tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>