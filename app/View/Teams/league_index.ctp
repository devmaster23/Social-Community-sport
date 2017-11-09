<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Teams'); ?>
    <small><?php echo __dbt('List Teams'); ?></small>
  </h1>
  <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
  
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
	<div class="box">
		<div class="box-header">
		    <div class="UserAdminIndexForm">
			<div class="box-body">	
			   <div class="row">
			     <?php echo $this->Form->create('Team', array('type' => 'get', 'url' => array('controller' => 'teams', 'action' => 'index', $this->params["prefix"] => true), "novalidate"=>"novalidate")); ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("Team.name", array("label"=>false, "placeholder"=>"Search by Name", "div"=>false,'class'=>"form-control"))."</div>"; ?>
					    <?php echo "<div class='col-xs-3'>". $this->Form->input("Tournament.tournament_id", array("type"=>"select", "empty"=>"--Select Tournament--","label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?>  
						<div class='col-xs-3 col-xs-offset-4 admin-search-btn'>
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
                                            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
                                            <th class="actions"><?php echo __dbt('Actions'); ?></th>            
                                            
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($teams)) { foreach ($teams as $team): ?>
                                        <tr>
                                            <td><?php echo h($team['Team']['name']); ?>&nbsp;</td>
                                            <td>
                                                <?php echo $this->Html->link($team['Tournament']['name'], array('controller' => 'tournaments', 'action' => 'view', base64_encode($team['Tournament']['id']))); ?>&nbsp;</td>
                                            <td>
                                                    <?php echo $this->Html->link($team['User']['name'], array('controller' => 'users', 'action' => 'view', base64_encode($team['User']['id']))); ?>
                                            </td>
                                            <td class="actions">
							<?php echo $this->Html->link(__dbt(''), array('action' => 'view', base64_encode($team['Team']['id'])),array('class'=>'fa fa-eye','title'=>'View Team')); ?>
							<?php echo $this->Html->link(__dbt(''), array('action' => 'edit', base64_encode($team['Team']['id'])),array('class'=>'fa fa-edit','title'=>'Edit Team')); ?>
							<?php echo $this->Form->postLink(__dbt(''), array('action' => 'delete', base64_encode($team['Team']['id']),base64_encode($team['Tournament']['id'])),array('class'=>'fa fa-remove','title'=>'Delete Team'), array(__dbt('Are you sure you want to delete this team?'))); ?>
						</td>
                                    </tr>
					
                                <?php endforeach; } else {?>
                                    <tr>    
                                    <td class="text-center" colspan="4"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
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