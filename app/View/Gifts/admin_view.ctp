<section class="content-header">
	<h1><?php echo __dbt('View Gift'); ?>
	  <small><?php echo __dbt('Gifts Details'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('Gifts Details'); ?></h3>
                           <a href="/admin/gifts" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
			</div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						<tr>
						  <td><?php echo __dbt('Gift Category'); ?></td>
						  <td><?php echo h($gifts['GiftCategory']['name']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Name'); ?></td>
						  <td><?php echo h($gifts['Gift']['name']); ?></td>
						</tr>
						<tr>
						  
						  <td><?php if($gifts['Gift']['type']==1){
                                                                echo __dbt('Product Price');
                                                            }else if($gifts['Gift']['type']==2){
                                                                echo __dbt('Cash Order Amount');
                                                            }?></td>
                                                  <td><?php echo $gifts['Gift']['amount']; ?></td>
						</tr>
                                                
                                                <?php if($gifts['Gift']['type']==1){?>
						<tr>
						  <td><?php echo __dbt('Product Link'); ?></td>
						  <td><?php echo h($gifts['Gift']['product_link']); ?></td>
						</tr>
                                                <?php } ?>
                                                <tr>
						  <td><?php echo __dbt('Sport'); ?></td>
						  <td><?php if($gifts['Sport']['id'] == 0){ echo h('NA');}else{ echo h($gifts['Sport']['name']); } ?></td>
						</tr>
                                                <tr>
						  <td><?php echo __dbt('Tournament'); ?></td>
						  <td><?php if($gifts['Tournament']['id'] == 0){ echo h('NA');}else{ echo h($gifts['Tournament']['name']); } ?></td>
						</tr>
                                                <tr>
						  <td><?php echo __dbt('League'); ?></td>
						  <td><?php if($gifts['League']['id'] == 0){ echo h('NA');}else{ echo h($gifts['League']['name']); } ?></td>
						</tr>
                                                <tr>
						  <td><?php echo __dbt('Start Date'); ?></td>
						  <td><?php echo h($gifts['Gift']['start_date']); ?></td>
						</tr>
                                                <tr>
						  <td><?php echo __dbt('End Date'); ?></td>
						  <td><?php echo h($gifts['Gift']['end_date']); ?></td>
						</tr>
                                                
                                                <?php if($gifts['Gift']['type']==1){?>
						<tr>
						  <td><?php echo __dbt('Gift Image'); ?></td>
						  <td><?php echo $this->Html->image($gifts['File']['path'],array('style'=>'width:30%'));?></td>
						</tr>
                                                <?php }?>
						<tr>
						  <td><?php echo __dbt('Status'); ?></td>
						  <td><?php echo h($gifts['Gift']['status_name']); ?></td>
						</tr>
		
						<tr>
						  <td><?php echo __dbt('Created'); ?></td>
						  <td><?php echo h($gifts['Gift']['created']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Modified'); ?></td>
						  <td><?php echo h($gifts['Gift']['modified']); ?></td>
						</tr>
				      </tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>