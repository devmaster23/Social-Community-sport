<div class="pollCategories index">
	<h2><?php echo __dbt('Poll Categories'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('is_deleted'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($pollCategories as $pollCategory): ?>
	<tr>
		<td><?php echo h($pollCategory['PollCategory']['id']); ?>&nbsp;</td>
		<td><?php echo h($pollCategory['PollCategory']['name']); ?>&nbsp;</td>
		<td><?php echo h($pollCategory['PollCategory']['status']); ?>&nbsp;</td>
		<td><?php echo h($pollCategory['PollCategory']['is_deleted']); ?>&nbsp;</td>
		<td><?php echo h($pollCategory['PollCategory']['created']); ?>&nbsp;</td>
		<td><?php echo h($pollCategory['PollCategory']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__dbt('View'), array('action' => 'view', $pollCategory['PollCategory']['id'])); ?>
			<?php echo $this->Html->link(__dbt('Edit'), array('action' => 'edit', $pollCategory['PollCategory']['id'])); ?>
			<?php echo $this->Form->postLink(__dbt('Delete'), array('action' => 'delete', $pollCategory['PollCategory']['id']), array('confirm' => __dbt('Are you sure you want to delete # %s?', $pollCategory['PollCategory']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __dbt('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __dbt('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__dbt('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __dbt('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__dbt('New Poll Category'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__dbt('List Polls'), array('controller' => 'polls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Poll'), array('controller' => 'polls', 'action' => 'add')); ?> </li>
	</ul>
</div>
