<div class="pollCategories view">
<h2><?php echo __dbt('Poll Category'); ?></h2>
	<dl>
		<dt><?php echo __dbt('Id'); ?></dt>
		<dd>
			<?php echo h($pollCategory['PollCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Name'); ?></dt>
		<dd>
			<?php echo h($pollCategory['PollCategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Status'); ?></dt>
		<dd>
			<?php echo h($pollCategory['PollCategory']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Is Deleted'); ?></dt>
		<dd>
			<?php echo h($pollCategory['PollCategory']['is_deleted']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Created'); ?></dt>
		<dd>
			<?php echo h($pollCategory['PollCategory']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Modified'); ?></dt>
		<dd>
			<?php echo h($pollCategory['PollCategory']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __dbt('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__dbt('Edit Poll Category'), array('action' => 'edit', $pollCategory['PollCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__dbt('Delete Poll Category'), array('action' => 'delete', $pollCategory['PollCategory']['id']), array('confirm' => __dbt('Are you sure you want to delete # %s?', $pollCategory['PollCategory']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Poll Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Poll Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Polls'), array('controller' => 'polls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Poll'), array('controller' => 'polls', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __dbt('Related Polls'); ?></h3>
	<?php if (!empty($pollCategory['Poll'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __dbt('Id'); ?></th>
		<th><?php echo __dbt('Name'); ?></th>
		<th><?php echo __dbt('Options'); ?></th>
		<th><?php echo __dbt('Answer'); ?></th>
		<th><?php echo __dbt('Trend'); ?></th>
		<th><?php echo __dbt('Poll Category Id'); ?></th>
		<th><?php echo __dbt('Status'); ?></th>
		<th><?php echo __dbt('Is Deleted'); ?></th>
		<th><?php echo __dbt('Created'); ?></th>
		<th><?php echo __dbt('Modified'); ?></th>
		<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	<?php foreach ($pollCategory['Poll'] as $poll): ?>
		<tr>
			<td><?php echo $poll['id']; ?></td>
			<td><?php echo $poll['name']; ?></td>
			<td><?php echo $poll['options']; ?></td>
			<td><?php echo $poll['answer']; ?></td>
			<td><?php echo $poll['trend']; ?></td>
			<td><?php echo $poll['poll_category_id']; ?></td>
			<td><?php echo $poll['status']; ?></td>
			<td><?php echo $poll['is_deleted']; ?></td>
			<td><?php echo $poll['created']; ?></td>
			<td><?php echo $poll['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__dbt('View'), array('controller' => 'polls', 'action' => 'view', $poll['id'])); ?>
				<?php echo $this->Html->link(__dbt('Edit'), array('controller' => 'polls', 'action' => 'edit', $poll['id'])); ?>
				<?php echo $this->Form->postLink(__dbt('Delete'), array('controller' => 'polls', 'action' => 'delete', $poll['id']), array('confirm' => __dbt('Are you sure you want to delete # %s?', $poll['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__dbt('New Poll'), array('controller' => 'polls', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
