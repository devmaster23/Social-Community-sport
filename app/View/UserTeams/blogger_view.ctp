<div class="main-wrap">
    
        <div class="container-fluid">
            <div class="row">
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
</div></div>
