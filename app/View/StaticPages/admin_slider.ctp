<!-- Content Header (Page header) -->
<?php //pr($sliders); ?>
<section class="content-header">
  <h1>
    <?php echo __dbt('Slider'); ?>
    <small><?php echo __dbt('List Slider');?></small>
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
			   
			</div>	   
		</div>
		</div>
		<div style="clear:both;"></div>
		<!-- filters ends-->
		<div class="box-body">
			<table id="example2" class="table table-striped">
				<thead>
					<tr>      
                                           <th><?php echo $this->Paginator->sort('id'); ?></th>
                                           <th><?php echo $this->Paginator->sort('title'); ?></th>
                                           <th><?php //echo $this->Paginator->sort('path'); ?></th>
                                           <th><?php echo $this->Paginator->sort('status'); ?></th>
                                           <th><?php echo $this->Paginator->sort('foreign_key'); ?></th>
                                           <th><?php echo $this->Paginator->sort('created'); ?></th>
                                           <th><?php echo $this->Paginator->sort('modified'); ?></th>
                                           <th class="actions"><?php echo __dbt('Actions'); ?></th>
                                        </tr>
				</thead>
				<tbody>
				<?php if(!empty($sliders)) { foreach ($sliders as $slide): ?>
				<tr>
					<td><?php echo h($slide['Slider']['id']);  ?>&nbsp;</td>
					<td><?php echo h($slide['Slider']['title']); ?>&nbsp;</td>
					<td><?php //echo h($slide['Slider']['path']); ?>&nbsp;</td>
					<td><?php echo h($slide['Slider']['status_name']); ?>&nbsp;</td>
                                        <td><?php echo isset($slide['Sport']['name']) ?  $slide['Sport']['name'] : __dbt('Home'); ?>&nbsp;</td>
					<td><?php echo h($slide['Slider']['created']); ?>&nbsp;</td>
					<td><?php echo h($slide['Slider']['modified']); ?>&nbsp;</td>
					<td class="actions">
                                            <?php echo $this->Html->link(__dbt(''), array('action' => 'viewSlider', base64_encode($slide['Slider']['id'])),array('class'=>'fa fa-eye','title'=>'View Slider'));
                                                  echo $this->Form->postLink(__dbt(''), array('action' => 'deleteslider', base64_encode($slide['Slider']['id'])),array('class'=>'fa fa-remove','title'=>'Delete Slider'), array(__dbt('Are you sure you want to delete this slider?'))); 
                                            if($slide['Slider']['foreign_key']) {  
                                                    echo $this->Html->link(__dbt(''), array('action' => 'editSportSlider', base64_encode($slide['Slider']['id'])),array('class'=>'fa fa-edit','title'=>'Edit  Sport Slider'));
                                            } else {
                                                    echo $this->Html->link(__dbt(''), array('action' => 'editslider', base64_encode($slide['Slider']['id'])),array('class'=>'fa fa-edit','title'=>'Edit Slider'));
                                            }
                                            ?>
                                         </td>
                                       
				</tr>
                                <?php endforeach; } else { ?>
                                <tr><td colspan="7" class="text-center"><?php echo __dbt('No record found.');?></td></tr>
                                <?php } ?>
				</tbody>
			</table>
			<div class="row">
				<div class="col-sm-5">
					<div class="dataTables_info" id="example2_info" role="status" aria-live="polite"><?php
					//echo $this->Paginator->counter(array('format' => __dbt('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
					</div>
				</div>
				<div class="col-sm-7">
				<?php
				echo $this->element('pagination',array('paging_action'=>$this->here));
				?>
				</div>
			</div>
		</div>
	</div>
    </div>
  </div>
</section>


