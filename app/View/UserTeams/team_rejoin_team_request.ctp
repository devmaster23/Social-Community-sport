<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Rejoin Team Request'); ?>
    <small><?php echo __dbt('Users list'); ?></small>
  </h1>
  <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
  
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
	<div class="box">
		
		<div style="clear:both;"></div>
		<!-- filters ends-->
		<div class="box-body">
			<table id="example2" class="table table-striped">
				<thead>
					<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id'); ?></th>
					<th><?php echo $this->Paginator->sort('sport_id'); ?></th>
					<th><?php echo $this->Paginator->sort('tournament_id'); ?></th>
					<th><?php echo $this->Paginator->sort('league_id'); ?></th>
					<th><?php echo $this->Paginator->sort('team_id'); ?></th>
					<th><?php echo $this->Paginator->sort('status'); ?></th>
					<th><?php echo $this->Paginator->sort('request date'); ?></th>
					<th><?php echo __dbt('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($userTeams as $user): ?>
				<tr>
					<td><?php echo h($user['UserTeam']['id']); ?>&nbsp;</td>
					<td><?php echo h($user['User']['title'].$user['User']['name']); ?>&nbsp;</td>
					<td><?php echo h($user['Sport']['name']); ?>&nbsp;</td>
					<td>
                                                <?php echo $user['Tournament']['name']; ?>
						<?php //echo $this->Html->link($user['Role']['name'], array('controller' => 'roles', 'action' => 'view', $user['Role']['id'])); ?>
					</td>
					<td>
                                                <?php echo $user['League']['name']; ?>
						<?php //echo $this->Html->link($user['Locale']['name'], array('controller' => 'locales', 'action' => 'view', $user['Locale']['id'])); ?>
					</td>
					<td><?php echo h($user['Team']['name']); ?>&nbsp;</td>
					<td><?php echo h($user['UserTeam']['status_name']); ?>&nbsp;</td>
					<td><?php echo h($user['UserTeam']['rejoin_date']); ?>&nbsp;</td>
					<td>
						<?php //echo $this->Html->link(__dbt(''), array('action' => 'view', base64_encode($user['User']['id'])), array('class'=>'fa fa-eye','title'=>'View User')); ?>
						<?php //echo $this->Html->link(__dbt(''), array('action' => 'edit', base64_encode($user['User']['id'])), array('class'=>'fa fa-edit','title'=>'Edit User')); ?>
                                                <?php echo $this->Form->postLink(__dbt(''), array('action' => 'approveRejoinRequest', base64_encode($user['UserTeam']['id'])), array('class'=>'fa fa-check','title'=>'Approve User'),array(__dbt('Are you sure you want to approve user rejoin team request?'))); ?>
                                        </td>
				</tr>
				<?php endforeach; ?> 
				</tbody>
			</table>
			<div class="row">
				<div class="col-sm-5">
					<div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
					</div>
				</div>
				<div class="col-sm-7">
				<?php
				//
                                //echo $this->element('pagination',array('paging_action'=>$this->here));
				?>
				</div>
			</div>
		</div>
	</div>
    </div>
  </div>
</section>