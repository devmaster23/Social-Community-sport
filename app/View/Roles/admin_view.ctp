<div class="roles view">
<h2><?php echo __dbt('Role'); ?></h2>
	<dl>
		<dt><?php echo __dbt('Id'); ?></dt>
		<dd>
			<?php echo h($role['Role']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Name'); ?></dt>
		<dd>
			<?php echo h($role['Role']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Created'); ?></dt>
		<dd>
			<?php echo h($role['Role']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Modified'); ?></dt>
		<dd>
			<?php echo h($role['Role']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __dbt('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__dbt('Edit Role'), array('action' => 'edit', $role['Role']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__dbt('Delete Role'), array('action' => 'delete', $role['Role']['id']), array('confirm' => __dbt('Are you sure you want to delete # %s?', $role['Role']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Roles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Role'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __dbt('Related Users'); ?></h3>
	<?php if (!empty($role['User'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __dbt('Id'); ?></th>
		<th><?php echo __dbt('Name'); ?></th>
		<th><?php echo __dbt('Email'); ?></th>
		<th><?php echo __dbt('Role Id'); ?></th>
		<th><?php echo __dbt('Locale Id'); ?></th>
		<th><?php echo __dbt('Social Api Id'); ?></th>
		<th><?php echo __dbt('Gender'); ?></th>
		<th><?php echo __dbt('Password'); ?></th>
		<th><?php echo __dbt('File Id'); ?></th>
		<th><?php echo __dbt('Status'); ?></th>
		<th><?php echo __dbt('Is Deleted'); ?></th>
		<th><?php echo __dbt('Created'); ?></th>
		<th><?php echo __dbt('Modified'); ?></th>
		<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	<?php foreach ($role['User'] as $user): ?>
		<tr>
			<td><?php echo $user['id']; ?></td>
			<td><?php echo $user['name']; ?></td>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['role_id']; ?></td>
			<td><?php echo $user['locale_id']; ?></td>
			<td><?php echo $user['social_api_id']; ?></td>
			<td><?php echo $user['gender']; ?></td>
			<td><?php echo $user['password']; ?></td>
			<td><?php echo $user['file_id']; ?></td>
			<td><?php echo $user['status']; ?></td>
			<td><?php echo $user['is_deleted']; ?></td>
			<td><?php echo $user['created']; ?></td>
			<td><?php echo $user['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__dbt('View'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
				<?php echo $this->Html->link(__dbt('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
				<?php echo $this->Form->postLink(__dbt('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), array('confirm' => __dbt('Are you sure you want to delete # %s?', $user['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__dbt('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
