<div class="pollCategories form">
<?php echo $this->Form->create('PollCategory'); ?>
	<fieldset>
		<legend><?php echo __dbt('Admin Edit Poll Category'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('status');
		echo $this->Form->input('is_deleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__dbt('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __dbt('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__dbt('Delete'), array('action' => 'delete', $this->Form->value('PollCategory.id')), array('confirm' => __dbt('Are you sure you want to delete # %s?', $this->Form->value('PollCategory.id')))); ?></li>
		<li><?php echo $this->Html->link(__dbt('List Poll Categories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__dbt('List Polls'), array('controller' => 'polls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__dbt('New Poll'), array('controller' => 'polls', 'action' => 'add')); ?> </li>
	</ul>
</div>
