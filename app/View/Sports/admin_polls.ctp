<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Polls'); ?>
    <small><?php echo __dbt('List Polls'); ?></small>
  </h1>
  <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
  
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
	<div class="box">
		<div class="box-header">
		<!-- filters starts-->
		</div>
		<div style="clear:both;"></div>
                
		<!-- filters ends-->
		<div class="box-body">
			<table id="example2" class="table table-striped">
				<thead>
					<tr>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
                                        <th><?php echo $this->Paginator->sort('category'); ?></th>
					<th><?php echo $this->Paginator->sort('status'); ?></th>
					<th><?php echo __dbt('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($polls)) { foreach ($polls as $poll): ?>
				<tr>
					<td><?php echo strip_tags($poll['Poll']['name']); ?>&nbsp;</td>
                                        <td><?php echo h($poll['Poll']['post_type']); ?>&nbsp;</td>
                                        <td><?php echo h($poll['Poll']['status_name']); ?>&nbsp;</td>
					<td style="width:65px">
                                                <?php if($poll['Poll']['poll_category_id'] == 2 ){ echo $this->Html->link(__dbt(''), array('action' => 'viewPoll', base64_encode($poll['Poll']['id'])), array('class'=>'fa fa-eye','title'=>'View Poll'));} 
                                                      if($poll['Poll']['poll_category_id'] == 3 ){ echo $this->Html->link(__dbt(''), array('action' => 'viewForum', base64_encode($poll['Poll']['id'])), array('class'=>'fa fa-eye','title'=>'View Forum'));} 
                                                ?>
                                                <?php if($poll['Poll']['poll_category_id'] == 2 ){ echo $this->Html->link(__dbt(''), array('action' => 'editPoll', base64_encode($poll['Poll']['id'])), array('class'=>'fa fa-edit','title'=>'Edit Poll'));}
                                                      if($poll['Poll']['poll_category_id'] == 3 ){ echo $this->Html->link(__dbt(''), array('action' => 'editForum', base64_encode($poll['Poll']['id'])), array('class'=>'fa fa-edit','title'=>'Edit Forum'));}
                                                ?>
                                                
                                               <?php if($poll['Poll']['status'] == 1) { 
                                                            if($poll['Poll']['poll_category_id'] == 2 ) {
                                                                echo $this->Form->postLink(__dbt(''), array('action' => 'pollStatus', base64_encode($poll['Poll']['id']),base64_encode(0)), array('class'=>'fa fa-check','title'=>'Deactivate Poll'),array(__dbt('Are you sure you want to deactivate this poll?')));
                                                            } 
                                                            if($poll['Poll']['poll_category_id'] == 3 ){
                                                                 echo $this->Form->postLink(__dbt(''), array('action' => 'forumStatus', base64_encode($poll['Poll']['id']),base64_encode(0)), array('class'=>'fa fa-check','title'=>'Deactivate Forum'),array(__dbt('Are you sure you want to deactivate this forum?')));     
                                                             }     
                                               } else {
                                                   if($poll['Poll']['poll_category_id'] == 2 ) {
                                                        echo $this->Form->postLink(__dbt(''), array('action' => 'pollStatus', base64_encode($poll['Poll']['id']),base64_encode(1)), array('class'=>'fa fa-remove','title'=>'Activate Poll'),array(__dbt('Are you sure you want to activate this poll?')));
                                                    }
                                                    if($poll['Poll']['poll_category_id'] == 3 ) {
                                                        echo $this->Form->postLink(__dbt(''), array('action' => 'forumStatus', base64_encode($poll['Poll']['id']),base64_encode(1)), array('class'=>'fa fa-remove','title'=>'Activate Forum'),array(__dbt('Are you sure you want to activate this forum?')));
                                                    }
                                                    
                                                }
                                ?>
						
					</td>
				</tr>
                                <?php endforeach; } else { ?>
                                <tr>
                                    <td colspan="5" class="text-center"><?php echo __dbt('No result found.') ?></td>
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
				<?php echo $this->element('pagination',array('paging_action'=>$this->here));?>
				</div>
			</div>
		</div>
	</div>
    </div>
  </div>
</section>
