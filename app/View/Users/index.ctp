<div class="users index">
	<h2><?php echo __dbt('Users'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('role_id'); ?></th>
			<th><?php echo $this->Paginator->sort('locale_id'); ?></th>
			<th><?php echo $this->Paginator->sort('social_api_id'); ?></th>
			<th><?php echo $this->Paginator->sort('gender'); ?></th>
			<th><?php echo $this->Paginator->sort('password'); ?></th>
			<th><?php echo $this->Paginator->sort('file_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('is_deleted'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
		<td><?php echo h(__dbt($user['User']['name'])); ?>&nbsp;</td>
		<td><?php echo h(__dbt($user['User']['email'])); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link(__dbt($user['Role']['name']), array('controller' => 'roles', 'action' => 'view', $user['Role']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link(__dbt($user['Locale']['name']), array('controller' => 'locales', 'action' => 'view', $user['Locale']['id'])); ?>
		</td>
		<td><?php echo h(__dbt($user['User']['social_api_id'])); ?>&nbsp;</td>
		<td><?php echo h(__dbt($user['User']['gender'])); ?>&nbsp;</td>
		<td><?php echo h(__dbt($user['User']['password'])); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link(__dbt($user['File']['name']), array('controller' => 'files', 'action' => 'view', $user['File']['id'])); ?>
		</td>
		<td><?php echo h(__dbt($user['User']['status'])); ?>&nbsp;</td>
		<td><?php echo h(__dbt($user['User']['is_deleted'])); ?>&nbsp;</td>
		<td><?php echo h(__dbt($user['User']['created'])); ?>&nbsp;</td>
		<td><?php echo h(__dbt($user['User']['modified'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__dbt('View'), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__dbt('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Form->postLink(__dbt('Delete'), array('action' => 'delete', $user['User']['id']), array(__dbt('Are you sure you want to delete # %s?', $user['User']['id']))); ?>
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
		<li><?php echo $this->Html->link(__dbt('New User'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__dbt('List Roles'), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Locales'), array('controller' => 'locales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Locale'), array('controller' => 'locales', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Files'), array('controller' => 'files', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New File'), array('controller' => 'files', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Leagues'), array('controller' => 'leagues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New League'), array('controller' => 'leagues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Poll Responses'), array('controller' => 'poll_responses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Poll Response'), array('controller' => 'poll_responses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Sports'), array('controller' => 'sports', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Sport'), array('controller' => 'sports', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Teams'), array('controller' => 'teams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Team'), array('controller' => 'teams', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Wall Contents'), array('controller' => 'wall_contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Wall Content'), array('controller' => 'wall_contents', 'action' => 'add')); ?> </li>
	</ul>
</div>
