<div class="roles index">
	<h2><?php echo __dbt('Roles'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($roles as $role): ?>
	<tr>
		<td><?php echo h($role['Role']['id']); ?>&nbsp;</td>
		<td><?php echo h($role['Role']['name']); ?>&nbsp;</td>
		<td><?php echo h($role['Role']['created']); ?>&nbsp;</td>
		<td><?php echo h($role['Role']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__dbt('View'), array('action' => 'view', $role['Role']['id'])); ?>
			<?php echo $this->Html->link(__dbt('Edit'), array('action' => 'edit', $role['Role']['id'])); ?>
			<?php echo $this->Form->postLink(__dbt('Delete'), array('action' => 'delete', $role['Role']['id']), array('confirm' => __dbt('Are you sure you want to delete # %s?', $role['Role']['id']))); ?>
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
		<li><?php echo $this->Html->link(__dbt('New Role'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__dbt('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
