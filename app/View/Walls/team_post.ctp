<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Team Wall'); ?>
    <small><?php echo __dbt('Team Wall Post'); ?></small>
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
					<th><?php echo $this->Paginator->sort('status'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
					<th><?php echo __dbt('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($wallPost)) {
                                    foreach ($wallPost as $post): ?>
				<tr>

					<td><?php echo h($post['WallContent']['name']); ?>&nbsp;</td>
					<td><?php echo h($post['WallContent']['status_name']); ?>&nbsp;</td>
					<td><?php echo h($post['WallContent']['created']); ?>&nbsp;</td>
					<td><?php echo h($post['WallContent']['modified']); ?>&nbsp;</td>
					<td>
						<?php echo $this->Html->link(__dbt(''), array('action' => 'viewPost', base64_encode($post['WallContent']['id'])), array('class'=>'fa fa-eye','title'=>'View post')); ?>
						<?php echo $this->Html->link(__dbt(''), array('action' => 'editPost', base64_encode($post['WallContent']['id'])), array('class'=>'fa fa-edit','title'=>'Edit post')); ?>
						<?php
                                                if($post['WallContent']['status'] == 2){
                                                    echo $this->Form->postLink(__dbt(''), array('action' => 'postStatus', base64_encode($post['WallContent']['id']),base64_encode(1)), array('class'=>'fa fa-remove','title'=>'View Post'),array('Are you sure you want to publish this post.')); 
                                                } else {
                                                    echo $this->Form->postLink(__dbt(''), array('action' => 'postStatus', base64_encode($post['WallContent']['id']),base64_encode(2)), array('class'=>'fa fa-comment','title'=>'UnPublish Post'),array('Are you sure you want to unpublish this post.')); 
                                                } ?>
                                        </td>
				</tr>
                                <?php endforeach; } else { ?>
                                <tr>    
                                    <td class="text-center" colspan="5"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
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
				echo $this->element('pagination',array('paging_action'=>$this->here));
				?>
				</div>
			</div>
		</div>
	</div>
    </div>
  </div>
</section>