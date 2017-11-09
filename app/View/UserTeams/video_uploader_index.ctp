<div class="main-wrap">
    
        <div class="container-fluid">
            <div class="row">
	<h2><?php echo __dbt('User Teams'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('tournament_id'); ?></th>
			<th><?php echo $this->Paginator->sort('sport_id'); ?></th>
			<th><?php echo $this->Paginator->sort('league_id'); ?></th>
			<th><?php echo $this->Paginator->sort('team_id'); ?></th>
			<th><?php echo $this->Paginator->sort('rejoin_date'); ?></th>
			<th><?php echo $this->Paginator->sort('leave_date'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __dbt('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($userTeams as $userTeam): ?>
	<tr>
		<td><?php echo h($userTeam['UserTeam']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($userTeam['User']['name'], array('controller' => 'users', 'action' => 'view', $userTeam['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($userTeam['Tournament']['name'], array('controller' => 'tournaments', 'action' => 'view', $userTeam['Tournament']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($userTeam['Sport']['name'], array('controller' => 'sports', 'action' => 'view', $userTeam['Sport']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($userTeam['League']['name'], array('controller' => 'leagues', 'action' => 'view', $userTeam['League']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($userTeam['Team']['name'], array('controller' => 'teams', 'action' => 'view', $userTeam['Team']['id'])); ?>
		</td>
		<td><?php echo h($userTeam['UserTeam']['rejoin_date']); ?>&nbsp;</td>
		<td><?php echo h($userTeam['UserTeam']['leave_date']); ?>&nbsp;</td>
		<td><?php echo h($userTeam['UserTeam']['status']); ?>&nbsp;</td>
		<td><?php echo h($userTeam['UserTeam']['created']); ?>&nbsp;</td>
		<td><?php echo h($userTeam['UserTeam']['modified']); ?>&nbsp;</td>
		<td class="actions">
                        <?php echo $this->Html->link(__dbt('TeamMembers'), array('action' => 'teamMembers', base64_encode($userTeam['UserTeam']['team_id']))); ?>
			<?php echo $this->Html->link(__dbt('View'), array('action' => 'view', base64_encode($userTeam['UserTeam']['id']))); ?>
			<?php echo $this->Html->link(__dbt('Edit'), array('action' => 'edit', base64_encode($userTeam['UserTeam']['id']))); ?>
			<?php if($userTeam['UserTeam']['status'] == 1) echo $this->Form->postLink(__dbt('Leave'), array('action' => 'delete', base64_encode($userTeam['UserTeam']['id'])), array('confirm' => __dbt('Are you sure you want to leave # %s?', $userTeam['UserTeam']['id']))); ?>
                        <?php if($userTeam['UserTeam']['status'] == 2) echo $this->Form->postLink(__dbt('Rejoin'), array('action' => 'rejoin', base64_encode($userTeam['UserTeam']['id'])), array('confirm' => __dbt('Are you sure you want to leave # %s?', $userTeam['UserTeam']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	
</div>
</div></div>
