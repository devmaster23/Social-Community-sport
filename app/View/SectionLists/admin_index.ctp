<?php
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Manage Section Listing'); ?>
    <small>Manage Section Listing</small>
  </h1>
  <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
<?php echo $this->Html->link('Add Section List','/admin/sectionLists/add',array('class'=>'button'));?>  
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
	<div class="box">
		<div class="box-header">
		<div class="box-body">
			<table id="example2" class="table table-striped">
				<thead>
					<tr>
                                                <th><?php echo $this->Paginator->sort("id","Sr.No"); ?></th>
                                                <th><?php echo $this->Paginator->sort("name","Name"); ?></th>
                                                <th><?php echo $this->Paginator->sort("controller","Controller Name"); ?></th>
                                                <th><?php echo $this->Paginator->sort("action","Method Name"); ?></th>        
                                                <th><?php echo $this->Paginator->sort("created","Created"); ?></th>
                                                <th><?php echo __dbt('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
<?php
foreach($SectionList as $memcat){
    if($memcat['SectionList']['created'] == '0000-00-00 00:00:00'){
        $memcat['SectionList']['created'] = 'N/A';
    }
    else{
        $memcat['SectionList']['created'] = date("l, F j, Y", strtotime($memcat['SectionList']['created']));
    }
    echo "<tr>
            <td>
                ".$memcat['SectionList']['id']."
            </td>
            <td>
                ".$memcat['SectionList']['name']."
            </td>
            <td>
                ".$memcat['SectionList']['controller']."
            </td>
            <td>
                ".$memcat['SectionList']['action']."
            </td>            
            <td>
                ".$memcat['SectionList']['created']."
            </td>            
            <td class='actions'>
                ".$this->Html->link($this->Html->image('edit.png',array('title'=>'Edit Section','height'=>'15','width'=>'15', 'alt'=>"Edit")),'/admin/sectionLists/edit/'.  base64_encode($memcat['SectionList']['id']),array('escape'=>false))."
                ".$this->Html->link($this->Html->image('delete.png',array('title'=>'Delete Section','height'=>'15','width'=>'15', 'alt'=>"Del")),'/admin/sectionLists/remove/'.  base64_encode($memcat['SectionList']['id']), array('escape'=>false,"onclick"=>"if(!confirm('Are you sure you want to proceed')){return false;};"))."
                ".$this->Html->link($this->Html->image('view.png',array('title'=>'View Section','height'=>'15','width'=>'15', 'alt'=>"View")),'/admin/sectionLists/view/'.  base64_encode($memcat['SectionList']['id']),array('escape'=>false))."    
            </td>            
        </tr>";
}
?>
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
				//echo $this->Paginator->prev('< ' . __dbt('previous'), array(), null, array('class' => 'paginate_button previous disabled'));
				//echo $this->Paginator->numbers(array('separator' => '','class'=>'paginate_button '));
				//echo $this->Paginator->next(__dbt('next') . ' >', array(), null, array('class' => 'paginate_button next'));
				?>
				</div>
			</div>
		</div>
	</div>
    </div>
  </div>
</section>