<div class="roles form">
<?php echo $this->Form->create('Role'); ?>
	<fieldset>
		<legend><?php echo __dbt('Admin Edit Role'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__dbt('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __dbt('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__dbt('Delete'), array('action' => 'delete', $this->Form->value('Role.id')), array('confirm' => __dbt('Are you sure you want to delete # %s?', $this->Form->value('Role.id')))); ?></li>
		<li><?php echo $this->Html->link(__dbt('List Roles'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__dbt('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
