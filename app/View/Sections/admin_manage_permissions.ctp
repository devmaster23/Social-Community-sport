<?php
?>

<script>
    $(document).ready(function(){
        $("#chk").click(function(){
            $("input[type=checkbox]").prop("checked", !$("input[type=checkbox]").prop("checked"));
        });
    });
</script>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Manage Permissions'); ?>
    <small><?php echo __dbt('Manage Permissions'); ?></small>
  </h1>
  <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
  
</section>
<section class="content">
  <div class="row">
    <?php
            echo $this->Form->create('Section');
            echo $this->Form->input('Section.role_id',array('type'=>'select', "label"=>false, 'options'=>$roles,'class'=>'select','div'=>false));
    ?>
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
                                            <th><span id="tggl"><p id="chk">Check/Un-check All</p></span></th>
					</tr>
				</thead>
				<tbody>

	<tr>
            <?php
			foreach($Section as $memcat){
			    $string = $memcat['SectionList']['action'];
			    if(strpos($memcat['SectionList']['action'], "admin_")===0){
				$route = explode('admin_', $string);
				$action = $route['1'];
				$prefix = 'admin';
			    }
			    else if(strpos($memcat['SectionList']['action'], "sports_")===0){
				$route = explode('sports_', $string);
				$action = $route['1'];
				$prefix = 'sports';        
			    }
			    else if(strpos($memcat['SectionList']['action'], "league_")===0){
				$route = explode('league_', $string);
				$action = $route['1'];
				$prefix = 'league';        
			    }
			    else if(strpos($memcat['SectionList']['action'], 'team_')===0){
				$route = explode('team_', $string);
				$action = $route['1'];
				$prefix = 'team';
			    }  
                            else if(strpos($memcat['SectionList']['action'], 'blogger_')===0){
                                $route = explode('blogger_', $string);
                                $action = $route['1'];
                                $prefix = 'blogger';
                            }
			    else{
				$action = $memcat['SectionList']['action'];
				$prefix = false;     
			    }
			    
			    echo "<tr>
				    <td>
					".$memcat['SectionList']['id']."
				    </td>
				    <td>
					".$memcat['SectionList']['name']."<br><span style='color:green;'>";
						if($prefix != false){
						echo 'https://'.$_SERVER['HTTP_HOST'].Router::url(array($prefix=>true,'controller'=>$memcat['SectionList']['controller'], 'action'=>$action));
						}else{
						echo 'https://'.$_SERVER['HTTP_HOST'].Router::url(array('admin'=>false,'controller'=>$memcat['SectionList']['controller'], 'action'=>$action)); }
					echo "
					</td>
					<td>
						".$memcat['SectionList']['controller']."
					</td>
					<td>
						".$memcat['SectionList']['action']."
					 </td>            
					<td>
						<input type='checkbox' name='data[Section][section_list_id][]' id='SectionSectionListID' value='".$memcat['SectionList']['id']."'>
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
                                            <?php echo $this->Form->submit('Deny',array('class'=>'button'));?>
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
      <?php echo $this->Form->end();?>
  </div>
</section>