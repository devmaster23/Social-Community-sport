<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __dbt('Add User'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('email');
		echo $this->Form->input('role_id');
		echo $this->Form->input('locale_id');
		echo $this->Form->input('social_api_id');
		echo $this->Form->input('gender');
		echo $this->Form->input('password');
		echo $this->Form->input('file_id');
		echo $this->Form->input('status');
		echo $this->Form->input('is_deleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__dbt('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __dbt('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__dbt('List Users'), array('action' => 'index')); ?></li>
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
