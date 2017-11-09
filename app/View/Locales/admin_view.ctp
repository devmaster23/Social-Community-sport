<div class="locales view">
<h2><?php echo __dbt('Locale'); ?></h2>
	<dl>
		<dt><?php echo __dbt('Id'); ?></dt>
		<dd>
			<?php echo h($locale['Locale']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Name'); ?></dt>
		<dd>
			<?php echo h($locale['Locale']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Code'); ?></dt>
		<dd>
			<?php echo h($locale['Locale']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Status'); ?></dt>
		<dd>
			<?php echo h($locale['Locale']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Created'); ?></dt>
		<dd>
			<?php echo h($locale['Locale']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Modified'); ?></dt>
		<dd>
			<?php echo h($locale['Locale']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __dbt('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__dbt('Edit Locale'), array('action' => 'edit', $locale['Locale']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__dbt('Delete Locale'), array('action' => 'delete', $locale['Locale']['id']), array('confirm' => __dbt('Are you sure you want to delete # %s?', $locale['Locale']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Locales'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Locale'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Forums'), array('controller' => 'forums', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Forum'), array('controller' => 'forums', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Walls'), array('controller' => 'walls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Wall'), array('controller' => 'walls', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __dbt('Related Forums'); ?></h3>
	<?php if (!empty($locale['Forum'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __dbt('Id'); ?></th>
		<th><?php echo __dbt('Name'); ?></th>
		<th><?php echo __dbt('Tournament Id'); ?></th>
		<th><?php echo __dbt('Sport Id'); ?></th>
		<th><?php echo __dbt('Locale Id'); ?></th>
		<th><?php echo __dbt('League Id'); ?></th>
		<th><?php echo __dbt('Team Id'); ?></th>
		<th><?php echo __dbt('Status'); ?></th>
		<th><?php echo __dbt('Is Deleted'); ?></th>
		<th><?php echo __dbt('Created'); ?></th>
		<th><?php echo __dbt('Modified'); ?></th>
		<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	<?php foreach ($locale['Forum'] as $forum): ?>
		<tr>
			<td><?php echo $forum['id']; ?></td>
			<td><?php echo $forum['name']; ?></td>
			<td><?php echo $forum['tournament_id']; ?></td>
			<td><?php echo $forum['sport_id']; ?></td>
			<td><?php echo $forum['locale_id']; ?></td>
			<td><?php echo $forum['league_id']; ?></td>
			<td><?php echo $forum['team_id']; ?></td>
			<td><?php echo $forum['status']; ?></td>
			<td><?php echo $forum['is_deleted']; ?></td>
			<td><?php echo $forum['created']; ?></td>
			<td><?php echo $forum['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__dbt('View'), array('controller' => 'forums', 'action' => 'view', $forum['id'])); ?>
				<?php echo $this->Html->link(__dbt('Edit'), array('controller' => 'forums', 'action' => 'edit', $forum['id'])); ?>
				<?php echo $this->Form->postLink(__dbt('Delete'), array('controller' => 'forums', 'action' => 'delete', $forum['id']), array('confirm' => __dbt('Are you sure you want to delete # %s?', $forum['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__dbt('New Forum'), array('controller' => 'forums', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __dbt('Related Users'); ?></h3>
	<?php if (!empty($locale['User'])): ?>
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
	<?php foreach ($locale['User'] as $user): ?>
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
<div class="related">
	<h3><?php echo __dbt('Related Walls'); ?></h3>
	<?php if (!empty($locale['Wall'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __dbt('Id'); ?></th>
		<th><?php echo __dbt('Name'); ?></th>
		<th><?php echo __dbt('Tournament Id'); ?></th>
		<th><?php echo __dbt('Sport Id'); ?></th>
		<th><?php echo __dbt('Locale Id'); ?></th>
		<th><?php echo __dbt('League Id'); ?></th>
		<th><?php echo __dbt('Team Id'); ?></th>
		<th><?php echo __dbt('Status'); ?></th>
		<th><?php echo __dbt('Is Deleted'); ?></th>
		<th><?php echo __dbt('Created'); ?></th>
		<th><?php echo __dbt('Modified'); ?></th>
		<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	<?php foreach ($locale['Wall'] as $wall): ?>
		<tr>
			<td><?php echo $wall['id']; ?></td>
			<td><?php echo $wall['name']; ?></td>
			<td><?php echo $wall['tournament_id']; ?></td>
			<td><?php echo $wall['sport_id']; ?></td>
			<td><?php echo $wall['locale_id']; ?></td>
			<td><?php echo $wall['league_id']; ?></td>
			<td><?php echo $wall['team_id']; ?></td>
			<td><?php echo $wall['status']; ?></td>
			<td><?php echo $wall['is_deleted']; ?></td>
			<td><?php echo $wall['created']; ?></td>
			<td><?php echo $wall['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__dbt('View'), array('controller' => 'walls', 'action' => 'view', $wall['id'])); ?>
				<?php echo $this->Html->link(__dbt('Edit'), array('controller' => 'walls', 'action' => 'edit', $wall['id'])); ?>
				<?php echo $this->Form->postLink(__dbt('Delete'), array('controller' => 'walls', 'action' => 'delete', $wall['id']), array('confirm' => __dbt('Are you sure you want to delete # %s?', $wall['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__dbt('New Wall'), array('controller' => 'walls', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
