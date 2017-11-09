<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Games'); ?>
    <small><?php echo __dbt('List Games'); ?></small>
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
			     <?php  echo $this->Form->create('Game', array('type' => 'get', 'url' => array('controller' => 'games', 'action' => 'index', $this->params["prefix"] => true), "novalidate"=>"novalidate")); ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("Game.team_id", array('name'=>'first_team',"label"=>false,"empty"=>"--First Team--", "div"=>false,'class'=>"form-control"))."</div>"; ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("Game.team_id", array('name'=>'second_team',"label"=>false,"empty"=>"--Second Team--", "div"=>false,'class'=>"form-control"))."</div>"; ?>
                        <?php echo "<div class='col-xs-2'>". $this->Form->input("Game.sport_id", array("type"=>"select", "empty"=>"--Select Sport--","label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?> 
                        <?php echo "<div class='col-xs-2'>". $this->Form->input("Game.teams_gameday", array("type"=>"select", "empty"=>"--Select Day--","options" => array_combine(range(1,99,1),range(1,99,1)),"label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?>  
						<div class='col-xs-offset-3 admin-search-btn'>
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
                                            <th><?php echo $this->Paginator->sort('tournament_id'); ?></th>
                                            <th><?php echo $this->Paginator->sort('sport_id'); ?></th>
                                            <th><?php echo $this->Paginator->sort('first_team'); ?></th>
                                            <th><?php echo $this->Paginator->sort('second_team'); ?></th>
                                            <th><?php echo $this->Paginator->sort('start_time'); ?></th>
                                            <th><?php echo $this->Paginator->sort('end_time'); ?></th>
                                            <th><?php echo $this->Paginator-> sort('teams_gameday'); ?></th>
                                            <th class="actions"><?php echo __dbt('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php if(!empty($games)) {

                                    foreach ($games as $game): ?>
					<tr>
						<td>
							<?php echo $this->Html->link($game['Tournament']['name'], array('controller' => 'tournaments', 'action' => 'view', base64_encode($game['Tournament']['id']))); ?>
						</td>
						<td>
							<?php echo $this->Html->link($game['Sport']['name'], array('controller' => 'sports', 'action' => 'view', base64_encode($game['Sport']['id']))); ?>
						</td>
						<td><?php echo h($game['First_team']['name']); ?>&nbsp;</td>
						<td><?php echo h($game['Second_team']['name']); ?>&nbsp;</td>
						<td><?php echo h($game['Game']['start_time']); ?>&nbsp;</td>
						<td><?php echo h($game['Game']['end_time']); ?>&nbsp;</td>
						<td><?php echo h($game['Game']['teams_gameday']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__dbt(''), array('action' => 'view', base64_encode($game['Game']['id'])),array('class'=>'fa fa-eye','title'=>'View Game')); ?>
							<?php echo $this->Html->link(__dbt(''), array('action' => 'edit', base64_encode($game['Game']['id'])),array('class'=>'fa fa-edit','title'=>'Edit Game')); ?>
							<?php echo $this->Form->postLink(__dbt(''), array('action' => 'delete', base64_encode($game['Game']['id'])),array('class'=>'fa fa-remove','title'=>'Delete Game'), array(__dbt('Are you sure you want to delete this game?'))); ?>
                                                        <?php if(!$this->Chat->getTeamsChatStatus($game['Game']['first_team'],$game['Game']['second_team'])){ 
                                                                echo $this->Form->postLink(__dbt(''), array('action' => 'allowTeamChat', base64_encode($game['Game']['first_team']),base64_encode($game['Game']['second_team']),base64_encode($game['Game']['sport_id']),base64_encode($game['Game']['tournament_id']),base64_encode($game['Game']['league_id'])),array('class'=>'fa fa-whatsapp','title'=>'Allow Team Chat'), array(__dbt('Are you sure you want to allow teams chat?'))); 
                                                                } else {
                                                                    echo $this->Form->postLink(__dbt(''), array('action' => 'closeTeamChat', base64_encode($game['Game']['first_team']),base64_encode($game['Game']['second_team']),base64_encode($game['Game']['sport_id']),base64_encode($game['Game']['tournament_id']),base64_encode($game['Game']['league_id'])),array('class'=>'fa fa-chain-broken','title'=>'Close Team Chat'), array(__dbt('Are you sure you want to close teams chat room?')));                 }
                                                        ?>
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
	
	
