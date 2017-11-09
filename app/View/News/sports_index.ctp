<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('News'); ?>
    <small><?php echo __dbt('List News');?></small>
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
			     <?php echo $this->Form->create('News', array('type' => 'get', 'url' => array('controller' => 'news', 'action' => 'index', $this->params["prefix"] => true,'class'=>"form-control"), "novalidate"=>"novalidate")); ?>
				<?php echo "<div class='col-xs-4'>". $this->Form->input("News.description", array("label"=>false, "placeholder"=>"Search by description", "div"=>false,'class'=>"form-control",'type'=>'text'))."</div>"; ?>
				<?php 
                                    $x = array_search('Blocked', $status);
                                unset($status[$x]);
                                echo "<div class='col-xs-2'>". $this->Form->input("News.status", array("type"=>"select", "empty"=>"--All Status--", "options"=>$status, "label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?>
				<div class='col-xs-6 admin-search-btn'>
					<input type="submit" class="btn bg-olive margin" value="Search">	
					<a href="<?php echo $this->here; ?>" class="btn btn-warning" ><?php echo __dbt('Reset'); ?></a>
				</div>	
			    <?php echo $this->Form->end(); ?>
			   </div>
			</div>	   
		</div>
		</div>
		<div style="clear:both;"></div>
		<!-- filters ends-->
		<div class="box-body">
			<table id="example2" class="table table-striped">
				<thead>
					<tr>      
                                           <th><?php echo $this->Paginator->sort('Sport.name','Sport'); ?></th>
                                       <th><?php echo $this->Paginator->sort('publish','Approved By Admin'); ?></th>
                                       <th><?php echo $this->Paginator->sort('description'); ?></th>
                                       <th><?php echo $this->Paginator->sort('status'); ?></th>
                                           <th class="actions"><?php echo __dbt('Actions'); ?></th>
                                        </tr>
				</thead>
				<tbody>
				<?php if(!empty($news)) {
                                    foreach ($news as $news): ?>
				<tr>
					<td><?php echo h($news['Sport']['name']); ?>&nbsp;</td>
                                        <td>
                                            <?php if($news['News']['publish']==1){
                                                    echo __dbt('approved');
                                                  }else{
                                                    echo __dbt('not approved');
                                                  } ?>&nbsp;
                                        </td>
					<td><?php if(strlen($news['News']['description'])>50){
						echo strip_tags(substr($news['News']['description'],0,50).'....');
					      }else{
						echo strip_tags($news['News']['description']);
					      } ?>&nbsp;</td>
					
					<td><?php echo h($news['News']['status_name']); ?>&nbsp;</td>
					<td class="actions">
                                            <?php echo $this->Html->link(__dbt(''), array('action' => 'view', base64_encode($news['News']['id'])),array('class'=>'fa fa-eye','title'=>'View News')); ?>
                                            <?php echo $this->Html->link(__dbt(''), array('action' => 'edit', base64_encode($news['News']['id'])),array('class'=>'fa fa-edit','title'=>'Edit News')); ?>
                                            <?php echo $this->Form->postLink(__dbt(''), array('action' => 'delete', base64_encode($news['News']['id'])),array('class'=>'fa fa-remove','title'=>'Delete News'), array(__dbt('Are you sure you want to delete this news ?'))); ?>
                                                </td>
                                       
				</tr>
                                <?php endforeach; } else { ?>
                                <tr>    
                                    <td class="text-center" colspan="5"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
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