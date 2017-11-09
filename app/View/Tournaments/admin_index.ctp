<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Tournaments'); ?>
    <small><?php echo __dbt('List Tournaments'); ?></small>
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
					
					<?php echo $this->Form->create('Tournament', array('type' => 'get', 'url' => array('controller' => 'tournaments', 'action' => 'index', $this->params["prefix"] => true), "novalidate"=>"novalidate")); ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("League.name", array("label"=>false, "placeholder"=>"Search by Name", "div"=>false,'class'=>"form-control"))."</div>"; ?>
					    <?php echo "<div class='col-xs-3'>". $this->Form->input("League.sport_id", array("type"=>"select", "empty"=>"--Select Sport--","label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?>  
					    
						<div class='col-xs-3 col-xs-offset-7 admin-search-btn'>
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
					<th><?php echo $this->Paginator->sort('sport_id'); ?></th>
					<th><?php echo $this->Paginator->sort('description'); ?></th>
					<th><?php echo $this->Paginator->sort('status'); ?></th>
					<th class="actions"><?php echo __dbt('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($tournaments)) {
                                    //pr($tournaments);
                                    foreach ($tournaments as $tournament): ?>
					<tr>
						<td><?php echo h($tournament['Tournament']['name']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($tournament['Sport']['name'], array('controller' => 'sports', 'action' => 'view', base64_encode($tournament['Sport']['id']))); ?>
						</td>
						<td><?php if(strlen($tournament['Tournament']['description'])>50){
						echo h(substr($tournament['Tournament']['description'],0,50).'....');
					      }else{
						echo h($tournament['Tournament']['description']);
					      } ?>&nbsp;</td>
						<td><?php echo h($tournament['Tournament']['status_name']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__dbt(''), array('action' => 'view', base64_encode($tournament['Tournament']['id'])),array('class'=>'fa fa-eye','title'=>'View Tournament')); ?>
							<?php echo $this->Html->link(__dbt(''), array('action' => 'edit', base64_encode($tournament['Tournament']['id'])),array('class'=>'fa fa-edit','title'=>'Edit Tournament')); ?>
							<?php echo $this->Form->postLink(__dbt(''), array('action' => 'delete', base64_encode($tournament['Tournament']['id'])),array('class'=>'fa fa-remove','title'=>'Delete Tournament'), array(__dbt('Are you sure you want to delete this tournament?'))); ?>
						</td>
					</tr>
                                <?php endforeach; } else { ?>
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
<?php //echo $this->element('sql_dump'); ?>