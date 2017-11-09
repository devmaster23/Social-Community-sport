<section class="content-header">
	<h1><?php echo __dbt('View News'); ?>
	  <small><?php echo __dbt('News Details'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('News Details'); ?></h3>
                           <a href="/admin/news/writerlist" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
			</div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						
                      <?php 
						if (!empty($userdata)) { 
                                foreach ($userdata as $userdatas):?>
                         <tr>
						  <td><?php echo __dbt('Name'); ?></td>
						  <td><?php echo h($userdatas['User']['name']);?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Email'); ?></td>
						  <td><?php echo ($userdatas['User']['email']); ?></td>
						</tr>
                         <?php endforeach;} else {?>
                          <tr>
						  <td><?php echo __dbt('Name'); ?></td>
						  <td><?php echo 'Not found';?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Email'); ?></td>
						  <td><?php echo 'Not found'; ?></td>
						</tr>

						<?php }
						if (!empty($newsdata)) { 
                                foreach ($newsdata as $newsdatas):?>
						
						<tr>
						  <td><?php echo __dbt('Description'); ?></td>
						  <?php if(!empty($newsdatas['News']['external_url'])){
						  $url=$newsdatas['News']['external_url'];
						  }
						  else
						  {
						  $url=Router::fullbaseUrl().'/Sports/news/'.base64_encode($newsdatas['News']['id']);
						  
						  }
						 ?>
						 <td><a href='<?php echo $url;?>' target='blank'><?php if(strlen($newsdatas['News']['description'])>100){
						echo strip_tags(substr($newsdatas['News']['description'],0,100).'....');
					      }else{
						echo strip_tags($newsdatas['News']['description']);
					      } ?>&nbsp;</a></td>

						</tr>

						
					
						<?php endforeach;} else {?>
						<tr>
						  <td><?php echo __dbt('Description'); ?></td>
						  <td><?php echo 'No Description'; ?></td>
						</tr>
						<?php }?>
				      </tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>