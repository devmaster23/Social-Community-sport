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
			  <h3 class="box-title"><?php echo __dbt($slider['Slider']['title'].' Details'); ?></h3>
                          <a href="/admin/staticPages/slider" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
                        </div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						
						<tr>
						  <td><?php echo __dbt('SLider Title'); ?></td>
						  <td><?php echo h($slider['Slider']['title']); ?></td>
						</tr>
                                                <tr>
						  <td><?php echo __dbt('SLider Image'); ?></td>
						  <td>
                                                  <?php echo $this->Html->image(BASE_URL.'img/BannerImages/thumbnail/'.$slider['File']['new_name'],array('escape'=>false)); ?>
                                                  </td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Status'); ?></td>
                                                  <td><?php echo $slider['Slider']['status_name']; ?></td>
						</tr>
                                                <tr>
						  <td><?php echo __dbt('Created'); ?></td>
                                                  <td><?php echo $slider['Slider']['created']; ?></td>
						</tr>
                                                <tr>
						  <td><?php echo __dbt('Modified'); ?></td>
                                                  <td><?php echo $slider['Slider']['modified']; ?></td>
						</tr>
                                                
						
				      </tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>