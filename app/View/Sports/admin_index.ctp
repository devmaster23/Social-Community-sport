<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Sports'); ?>
    <small><?php echo __dbt('List Sports'); ?></small>
  </h1>
  <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
  
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
	<div class="box">
		<div class="box-header">
		<div class="box-body">
			<table id="example2" class="table table-striped">
				<thead>
					<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>					
					<th><?php echo $this->Paginator->sort('user_id'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
					<th class="actions"><?php echo __dbt('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
	<?php foreach ($sports as $sport): ?>
	<tr>
		<td><?php echo h($sport['Sport']['id']); ?>&nbsp;</td>
		<td><?php echo h($sport['Sport']['name']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($sport['User']['name'], array('controller' => 'users', 'action' => 'view', base64_encode($sport['User']['id']))); ?></td>
		<td><?php echo h($sport['Sport']['created']); ?>&nbsp;</td>
		<td><?php echo h($sport['Sport']['modified']); ?>&nbsp;</td>
		<td class="actions">
			
			<?php echo $this->Html->link(__dbt(''), array('action' => 'view',  base64_encode($sport['Sport']['id'])), array('class'=>'fa fa-eye','title'=>'View Sport')); ?>
			
			<?php echo $this->Html->link(__dbt(''), array('action' => 'edit', base64_encode($sport['Sport']['id'])), array('class'=>'fa fa-edit','title'=>'Edit Sport')); ?>
						<?php //echo $this->Form->postLink(__dbt(''), array('action' => 'delete',$sport['Sport']['id']), array('class'=>'fa fa-remove','title'=>'Delete Sport'),array('confirm' => __dbt('Are you sure you want to delete %s?', $sport['Sport']['name']))); ?>
			
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
			</table>
			<div class="row">
				<div class="col-sm-5">
					<div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
					</div>
				</div>
				<div class="col-sm-7">
				<?php  echo $this->element('pagination',array('paging_action'=>$this->here)); ?>
				</div>
			</div>
		</div>
	</div>
    </div>
  </div>
</section>
