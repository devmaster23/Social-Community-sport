<div class="locales form">
<?php echo $this->Form->create('Locale'); ?>
	<fieldset>
		<legend><?php echo __dbt('Admin Add Locale'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('code');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__dbt('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __dbt('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__dbt('List Locales'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__dbt('List Forums'), array('controller' => 'forums', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Forum'), array('controller' => 'forums', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('List Walls'), array('controller' => 'walls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Wall'), array('controller' => 'walls', 'action' => 'add')); ?> </li>
	</ul>
</div>
