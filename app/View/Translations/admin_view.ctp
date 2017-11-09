<section class="content-header">
	<h1><?php echo __dbt('View Translation'); ?>
	  <small><?php echo __dbt('Admin View Translation'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo __dbt('Translations Details'); ?></h3>
                                        <a href="javascript:window.history.back();" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
				</div>
				<div class="box-body no-padding">
                                    <table class="table table-striped">
					<tbody>
						
						<tr>
						  <td><?php echo __dbt('Text'); ?></td>
						  <td><?php echo h($trans[$model]['text']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Description'); ?></td>
						  <td><?php echo h($trans[$model]['translation']); ?></td>
						</tr>
						
                                            </tbody>
                                      </table>
			        </div>
		</div>
	  </div>
	</div>
</section>