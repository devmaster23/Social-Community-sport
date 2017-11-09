<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Blogger Video'); ?>
    <small><?php echo __dbt('Blogger post video'); ?></small>
  </h1>
  <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
  
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
	<div class="box">
		<div class="box-header">
		<!-- filters starts-->
		<div class="UserAdminIndexForm">
			<div class="box-body">	
			   <div class="row">	
			     
			   </div>
			</div>	   
		</div>
		</div>
		<div style="clear:both;"></div>
		<!-- filters ends-->
		<div class="box-body">
			<table id="example2" class="table table-striped">
				<thead>
					<tr>
					<th><?php echo $this->Paginator->sort('title'); ?></th>
					<th><?php echo $this->Paginator->sort('Link'); ?></th>
					<th><?php echo $this->Paginator->sort('league_id'); ?></th>
					<th><?php echo $this->Paginator->sort('team_id'); ?></th>
					<th><?php echo $this->Paginator->sort('status'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
					<th><?php echo __dbt('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($videoDetail)) {
                                    foreach ($videoDetail as $video): ?>
				<tr>
					
					<td><?php echo h($video['WallContent']['title']); ?>&nbsp;</td>
					<td><?php echo __dbt($video['WallContent']['name']); ?>&nbsp;</td>
					<td><?php echo $video['Wall']['league_id']; ?></td>
					<td><?php echo h($video['Wall']['team_id']); ?>&nbsp;</td>
					<td><?php echo h($video['WallContent']['status']); ?>&nbsp;</td>
					<td><?php echo h($video['WallContent']['created']); ?>&nbsp;</td>
					<td><?php echo h($video['WallContent']['modified']); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link(__dbt(''), array('action' => 'view', base64_encode($video['WallContent']['id'])), array('class'=>'fa fa-eye','title'=>__dbt('View Video'))); ?>
						
						<?php
                                                if($video['WallContent']['status'] == 2){
                                                    echo $this->Form->postLink(__dbt(''), array('action' => 'delete', base64_encode($video['WallContent']['id']),base64_encode(1)), array('class'=>'fa fa-remove','title'=>'Publish Video'),array(__dbt('Are you sure you want to publish this video.'))); 
                                                } else {
                                                    echo $this->Form->postLink(__dbt(''), array('action' => 'delete', base64_encode($video['WallContent']['id']),base64_encode(2)), array('class'=>'fa fa-video-camera','title'=>__dbt('UnPublish Video')),array(__dbt('Are you sure you want to unpublish this video.'))); 
                                                } ?>
                                        </td>
				</tr>
                                <?php endforeach; } else { ?>
                                <tr>    
                                    <td class="text-center" colspan="8"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
                                    </tr>
                                <?php } ?>
				</tbody>
			</table>
			<div class="row">
				<div class="col-sm-5">
					<div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
					</div>
				</div>
				<div class="col-sm-7">
				<?php
				//echo $this->element('pagination',array('paging_action'=>$this->here));
				?>
				</div>
			</div>
		</div>
	</div>
    </div>
  </div>
</section>