<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Leagues'); ?>
    <small><?php echo __dbt('List Leagues'); ?></small>
  </h1>
  <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
	<div class="box">
		<div class="box-header">
			<!-- filters starts-->
			<div class="UserAdminIndexForm">
				<div class="box-body">	
				   <div class="row">
					<?php echo $this->Form->create('League', array('type' => 'get', 'url' => array('controller' => 'leagues', 'action' => 'index', $this->params["prefix"] => true), "novalidate"=>"novalidate")); ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("League.name", array("label"=>false, "placeholder"=>__dbt("Search by Name"), "div"=>false,'class'=>"form-control"))."</div>"; ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("League.host", array("label"=>false, "placeholder"=>__dbt("Search by Host"), "div"=>false,'class'=>"form-control"))."</div>"; ?>
					    <?php echo "<div class='col-xs-3'>". $this->Form->input("League.tournament_id", array("type"=>"select", "empty"=>__dbt("--Select Tournament--"),"label"=>false, "placeholder"=>"Search by To", "div"=>false,'class'=>"form-control"))."</div>"; ?>  
					    
						<div class='col-xs-3 col-xs-offset-2 admin-search-btn'>
						  <input type="submit" class="btn bg-olive margin" value="Search">	
						  <a href="<?php echo $this->here; ?>" class="btn btn-warning" ><?php echo __dbt("Reset"); ?></a>
						</div>	
					<?php echo $this->Form->end(); ?>        
				   </div>
				</div>	   
			</div>
		</div>	
		<!-- filters starts-->
		<div class="box-body">
			<table class="table table-striped">
				<thead>
					<tr>

						<th><?php echo $this->Paginator->sort('name'); ?></th>
						<th><?php echo $this->Paginator->sort('tournament_id'); ?></th>
						<th><?php echo $this->Paginator->sort('no_of_teams'); ?></th>
						<th><?php echo $this->Paginator->sort('start_date'); ?></th>
						<th><?php echo $this->Paginator->sort('end_date'); ?></th>
						<th><?php echo $this->Paginator->sort('host'); ?></th>
						<th><?php echo $this->Paginator->sort('user_id'); ?></th>
						<th class="actions"><?php echo __dbt('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($leagues)) { foreach ($leagues as $league): ?>
					<tr>
						<td><?php echo h($league['League']['name']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($league['Tournament']['name'], array('controller' => 'tournaments', 'action' => 'view', base64_encode($league['Tournament']['id']))); ?>
						</td>
						<td><?php echo h($league['League']['no_of_teams']); ?>&nbsp;</td>
						<td><?php echo h($league['League']['start_date']); ?>&nbsp;</td>
						<td><?php echo h($league['League']['end_date']); ?>&nbsp;</td>
						<td><?php echo h($league['League']['host']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($league['User']['name'], array('controller' => 'users', 'action' => 'view', base64_encode($league['User']['id']))); ?>
						</td>
						<td class="actions">
							<?php echo $this->Html->link(__dbt(''), array('action' => 'view', base64_encode($league['League']['id'])), array('class'=>'fa fa-eye','title'=>__dbt('View User'))); ?>
							<?php echo $this->Html->link(__dbt(''), array('action' => 'edit', base64_encode($league['League']['id'])), array('class'=>'fa fa-edit','title'=>__dbt('Edit User'))); ?>
							<?php echo $this->Form->postLink(__dbt(''), array('action' => 'delete', base64_encode($league['League']['id'])), array('class'=>'fa fa-remove','title'=>__dbt('Delete User')), array(__dbt('Are you sure you want to delete this league ?'))); ?>
						</td>
					</tr>
                                        <?php endforeach; } else { ?>
                                         <tr>    
                                            <td class="text-center" colspan="8"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
                                         </tr>  
                                        <?php } ?>
				</tbody>
			</table>
			<div class="row">
				<div class="col-sm-5">
					<div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
					</div>
				</div>
				<div class="col-sm-7">
					<?php echo $this->element('pagination',array('paging_action'=>$this->here));?>
				</div>
			</div>
		</div>
		
	</div>
    </div>
  </div>
</section>
	
	
	
	
	