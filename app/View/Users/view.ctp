<div class="users view">
<h2><?php echo __dbt('User'); ?></h2>
	<dl>
		<dt><?php echo __dbt('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Name'); ?></dt>
		<dd>
			<?php echo h(__dbt($user['User']['name'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Email'); ?></dt>
		<dd>
			<?php echo h(__dbt($user['User']['email'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Role'); ?></dt>
		<dd>
			<?php echo $this->Html->link(__dbt($user['Role']['name']), array('controller' => 'roles', 'action' => 'view', $user['Role']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Locale'); ?></dt>
		<dd>
			<?php echo $this->Html->link(__dbt($user['Locale']['name']), array('controller' => 'locales', 'action' => 'view', $user['Locale']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Social Api Id'); ?></dt>
		<dd>
			<?php echo h(__dbt($user['User']['social_api_id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Gender'); ?></dt>
		<dd>
			<?php echo h(__dbt($user['User']['gender'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Password'); ?></dt>
		<dd>
			<?php echo h(__dbt($user['User']['password'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('File'); ?></dt>
		<dd>
			<?php echo $this->Html->link(__dbt($user['File']['name']), array('controller' => 'files', 'action' => 'view', $user['File']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Status'); ?></dt>
		<dd>
			<?php echo h(__dbt($user['User']['status'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Is Deleted'); ?></dt>
		<dd>
			<?php echo h(__dbt($user['User']['is_deleted'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Created'); ?></dt>
		<dd>
			<?php echo h(__dbt($user['User']['created'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Modified'); ?></dt>
		<dd>
			<?php echo h(__dbt($user['User']['modified'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __dbt('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__dbt('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__dbt('Delete User'), array('action' => 'delete', $user['User']['id']), array(__dbt('Are you sure you want to delete # %s?', $user['User']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New User'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __dbt('Related Leagues'); ?></h3>
	<?php if (!empty($user['League'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __dbt('Id'); ?></th>
		<th><?php echo __dbt('Name'); ?></th>
		<th><?php echo __dbt('Tournament Id'); ?></th>
		<th><?php echo __dbt('Sport Id'); ?></th>
		<th><?php echo __dbt('No Of Teams'); ?></th>
		<th><?php echo __dbt('Start Date'); ?></th>
		<th><?php echo __dbt('End Date'); ?></th>
		<th><?php echo __dbt('Host'); ?></th>
		<th><?php echo __dbt('User Id'); ?></th>
		<th><?php echo __dbt('Status'); ?></th>
		<th><?php echo __dbt('Is Deleted'); ?></th>
		<th><?php echo __dbt('Created'); ?></th>
		<th><?php echo __dbt('Modified'); ?></th>
		<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	<?php foreach ($user['League'] as $league): ?>
		<tr>
			<td><?php echo __dbt($league['id']); ?></td>
			<td><?php echo __dbt($league['name']); ?></td>
			<td><?php echo __dbt($league['tournament_id']); ?></td>
			<td><?php echo __dbt($league['sport_id']); ?></td>
			<td><?php echo __dbt($league['no_of_teams']); ?></td>
			<td><?php echo __dbt($league['start_date']); ?></td>
			<td><?php echo __dbt($league['end_date']); ?></td>
			<td><?php echo __dbt($league['host']); ?></td>
			<td><?php echo __dbt($league['user_id']); ?></td>
			<td><?php echo __dbt($league['status']); ?></td>
			<td><?php echo __dbt($league['is_deleted']); ?></td>
			<td><?php echo __dbt($league['created']); ?></td>
			<td><?php echo __dbt($league['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__dbt('View'), array('controller' => 'leagues', 'action' => 'view', $league['id'])); ?>
				<?php echo $this->Html->link(__dbt('Edit'), array('controller' => 'leagues', 'action' => 'edit', $league['id'])); ?>
				<?php echo $this->Form->postLink(__dbt('Delete'), array('controller' => 'leagues', 'action' => 'delete', $league['id']), array(__dbt('Are you sure you want to delete # %s?', $league['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__dbt('New League'), array('controller' => 'leagues', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __dbt('Related Poll Responses'); ?></h3>
	<?php if (!empty($user['PollResponse'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __dbt('Id'); ?></th>
		<th><?php echo __dbt('Name'); ?></th>
		<th><?php echo __dbt('User Id'); ?></th>
		<th><?php echo __dbt('Poll Id'); ?></th>
		<th><?php echo __dbt('Status'); ?></th>
		<th><?php echo __dbt('Is Deleted'); ?></th>
		<th><?php echo __dbt('Created'); ?></th>
		<th><?php echo __dbt('Modified'); ?></th>
		<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	<?php foreach ($user['PollResponse'] as $pollResponse): ?>
		<tr>
			<td><?php echo __dbt($pollResponse['id']); ?></td>
			<td><?php echo __dbt($pollResponse['name']); ?></td>
			<td><?php echo __dbt($pollResponse['user_id']); ?></td>
			<td><?php echo __dbt($pollResponse['poll_id']); ?></td>
			<td><?php echo __dbt($pollResponse['status']); ?></td>
			<td><?php echo __dbt($pollResponse['is_deleted']); ?></td>
			<td><?php echo __dbt($pollResponse['created']); ?></td>
			<td><?php echo __dbt($pollResponse['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__dbt('View'), array('controller' => 'poll_responses', 'action' => 'view', $pollResponse['id'])); ?>
				<?php echo $this->Html->link(__dbt('Edit'), array('controller' => 'poll_responses', 'action' => 'edit', $pollResponse['id'])); ?>
				<?php echo $this->Form->postLink(__dbt('Delete'), array('controller' => 'poll_responses', 'action' => 'delete', $pollResponse['id']), array('confirm' => __dbt('Are you sure you want to delete # %s?', $pollResponse['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__dbt('New Poll Response'), array('controller' => 'poll_responses', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __dbt('Related Sports'); ?></h3>
	<?php if (!empty($user['Sport'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __dbt('Id'); ?></th>
		<th><?php echo __dbt('Name'); ?></th>
		<th><?php echo __dbt('Tile Image'); ?></th>
		<th><?php echo __dbt('Banner Image'); ?></th>
		<th><?php echo __dbt('User Id'); ?></th>
		<th><?php echo __dbt('Status'); ?></th>
		<th><?php echo __dbt('Created'); ?></th>
		<th><?php echo __dbt('Modified'); ?></th>
		<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Sport'] as $sport): ?>
		<tr>
			<td><?php echo __dbt($sport['id']); ?></td>
			<td><?php echo __dbt($sport['name']); ?></td>
			<td><?php echo __dbt($sport['tile_image']); ?></td>
			<td><?php echo __dbt($sport['banner_image']); ?></td>
			<td><?php echo __dbt($sport['user_id']); ?></td>
			<td><?php echo __dbt($sport['status']); ?></td>
			<td><?php echo __dbt($sport['created']); ?></td>
			<td><?php echo __dbt($sport['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__dbt('View'), array('controller' => 'sports', 'action' => 'view', $sport['id'])); ?>
				<?php echo $this->Html->link(__dbt('Edit'), array('controller' => 'sports', 'action' => 'edit', $sport['id'])); ?>
				<?php echo $this->Form->postLink(__dbt('Delete'), array('controller' => 'sports', 'action' => 'delete', $sport['id']), array('confirm' => __dbt('Are you sure you want to delete # %s?', $sport['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__dbt('New Sport'), array('controller' => 'sports', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __dbt('Related Teams'); ?></h3>
	<?php if (!empty($user['Team'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __dbt('Id'); ?></th>
		<th><?php echo __dbt('Name'); ?></th>
		<th><?php echo __dbt('Tournament Id'); ?></th>
		<th><?php echo __dbt('Sport Id'); ?></th>
		<th><?php echo __dbt('League Id'); ?></th>
		<th><?php echo __dbt('User Id'); ?></th>
		<th><?php echo __dbt('Status'); ?></th>
		<th><?php echo __dbt('Is Deleted'); ?></th>
		<th><?php echo __dbt('Created'); ?></th>
		<th><?php echo __dbt('Modified'); ?></th>
		<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Team'] as $team): ?>
		<tr>
			<td><?php echo __dbt($team['id']); ?></td>
			<td><?php echo __dbt($team['name']); ?></td>
			<td><?php echo __dbt($team['tournament_id']); ?></td>
			<td><?php echo __dbt($team['sport_id']); ?></td>
			<td><?php echo __dbt($team['league_id']); ?></td>
			<td><?php echo __dbt($team['user_id']); ?></td>
			<td><?php echo __dbt($team['status']); ?></td>
			<td><?php echo __dbt($team['is_deleted']); ?></td>
			<td><?php echo __dbt($team['created']); ?></td>
			<td><?php echo __dbt($team['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__dbt('View'), array('controller' => 'teams', 'action' => 'view', $team['id'])); ?>
				<?php echo $this->Html->link(__dbt('Edit'), array('controller' => 'teams', 'action' => 'edit', $team['id'])); ?>
				<?php echo $this->Form->postLink(__dbt('Delete'), array('controller' => 'teams', 'action' => 'delete', $team['id']), array(__dbt('Are you sure you want to delete team.'))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__dbt('New Team'), array('controller' => 'teams', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __dbt('Related Wall Contents'); ?></h3>
	<?php if (!empty($user['WallContent'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __dbt('Id'); ?></th>
		<th><?php echo __dbt('Name'); ?></th>
		<th><?php echo __dbt('Wall Id'); ?></th>
		<th><?php echo __dbt('Post Type'); ?></th>
		<th><?php echo __dbt('Content'); ?></th>
		<th><?php echo __dbt('Content Type'); ?></th>
		<th><?php echo __dbt('Title'); ?></th>
		<th><?php echo __dbt('File Id'); ?></th>
		<th><?php echo __dbt('User Id'); ?></th>
		<th><?php echo __dbt('Status'); ?></th>
		<th><?php echo __dbt('Is Deleted'); ?></th>
		<th><?php echo __dbt('Created'); ?></th>
		<th><?php echo __dbt('Modified'); ?></th>
		<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	<?php foreach ($user['WallContent'] as $wallContent): ?>
		<tr>
			<td><?php echo __dbt($wallContent['id']); ?></td>
			<td><?php echo __dbt($wallContent['name']); ?></td>
			<td><?php echo __dbt($wallContent['wall_id']); ?></td>
			<td><?php echo __dbt($wallContent['post_type']); ?></td>
			<td><?php echo __dbt($wallContent['content']); ?></td>
			<td><?php echo __dbt($wallContent['content_type']); ?></td>
			<td><?php echo __dbt($wallContent['title']); ?></td>
			<td><?php echo __dbt($wallContent['file_id']); ?></td>
			<td><?php echo __dbt($wallContent['user_id']); ?></td>
			<td><?php echo __dbt($wallContent['status']); ?></td>
			<td><?php echo __dbt($wallContent['is_deleted']); ?></td>
			<td><?php echo __dbt($wallContent['created']); ?></td>
			<td><?php echo __dbt($wallContent['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__dbt('View'), array('controller' => 'wall_contents', 'action' => 'view', $wallContent['id'])); ?>
				<?php echo $this->Html->link(__dbt('Edit'), array('controller' => 'wall_contents', 'action' => 'edit', $wallContent['id'])); ?>
				<?php echo $this->Form->postLink(__dbt('Delete'), array('controller' => 'wall_contents', 'action' => 'delete', $wallContent['id']), array(__dbt('Are you sure you want to delete wall content'))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__dbt('New Wall Content'), array('controller' => 'wall_contents', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
