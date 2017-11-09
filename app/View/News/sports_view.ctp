<section class="content-header">
	<h1><?php echo __dbt('View User'); ?>
	  <small><?php echo __dbt('Users Details'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('Users Details'); ?></h3>
                           <a href="/sports/news" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
			</div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						<tr>
						  <td><?php echo __dbt('Name'); ?></td>
						  <td><?php echo h($news['News']['name']); ?></td>
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