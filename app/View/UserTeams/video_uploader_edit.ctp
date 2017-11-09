<div class="main-wrap">
    
        <div class="container-fluid">
            <div class="row">
<?php echo $this->Form->create('UserTeam'); ?>
	<fieldset>
		<legend><?php echo __dbt('Edit User Team'); ?></legend>
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
</div></div>
