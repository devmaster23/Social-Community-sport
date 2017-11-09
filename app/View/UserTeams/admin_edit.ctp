<div class="userTeams form">
<?php echo $this->Form->create('UserTeam'); ?>
	<fieldset>
		<legend><?php echo __dbt('Admin Edit User Team'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('tournament_id');
		echo $this->Form->input('sport_id');
		echo $this->Form->input('league_id');
		echo $this->Form->input('team_id');
		echo $this->Form->input('rejoin_date');
		echo $this->Form->input('leave_date');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__dbt('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __dbt('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__dbt('Delete'), array('action' => 'delete', $this->Form->value('UserTeam.id')), array('confirm' => __dbt('Are you sure you want to delete # %s?', $this->Form->value('UserTeam.id')))); ?></li>
		<li><?php echo $this->Html->link(__dbt('List User Teams'), array('action' => 'index')); ?></li>
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
