<div class="userTeams view">
<h2><?php echo __dbt('User Team'); ?></h2>
	<dl>
		<dt><?php echo __dbt('Id'); ?></dt>
		<dd>
			<?php echo h($userTeam['UserTeam']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userTeam['User']['name'], array('controller' => 'users', 'action' => 'view', $userTeam['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Tournament'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userTeam['Tournament']['name'], array('controller' => 'tournaments', 'action' => 'view', $userTeam['Tournament']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Sport'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userTeam['Sport']['name'], array('controller' => 'sports', 'action' => 'view', $userTeam['Sport']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('League'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userTeam['League']['name'], array('controller' => 'leagues', 'action' => 'view', $userTeam['League']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Team'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userTeam['Team']['name'], array('controller' => 'teams', 'action' => 'view', $userTeam['Team']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Rejoin Date'); ?></dt>
		<dd>
			<?php echo h($userTeam['UserTeam']['rejoin_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Leave Date'); ?></dt>
		<dd>
			<?php echo h($userTeam['UserTeam']['leave_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Status'); ?></dt>
		<dd>
			<?php echo h($userTeam['UserTeam']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Created'); ?></dt>
		<dd>
			<?php echo h($userTeam['UserTeam']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __dbt('Modified'); ?></dt>
		<dd>
			<?php echo h($userTeam['UserTeam']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __dbt('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__dbt('Edit User Team'), array('action' => 'edit', $userTeam['UserTeam']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__dbt('Delete User Team'), array('action' => 'delete', $userTeam['UserTeam']['id']), array('confirm' => __dbt('Are you sure you want to delete # %s?', $userTeam['UserTeam']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List User Teams'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New User Team'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Tournaments'), array('controller' => 'tournaments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Tournament'), array('controller' => 'tournaments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Sports'), array('controller' => 'sports', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Sport'), array('controller' => 'sports', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Leagues'), array('controller' => 'leagues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New League'), array('controller' => 'leagues', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Teams'), array('controller' => 'teams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Team'), array('controller' => 'teams', 'action' => 'add')); ?> </li>
	</ul>
</div>
