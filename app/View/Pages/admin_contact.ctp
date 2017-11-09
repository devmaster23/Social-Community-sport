<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Contact'); ?>
    <small><?php echo __dbt('List Contact');?></small>
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
			     <?php echo $this->Form->create('ContactUs', array('type' => 'get', 'url' => array('controller' => 'pages', 'action' => 'contact', $this->params["prefix"] => true,'class'=>"form-control"), "novalidate"=>"novalidate")); ?>
				<?php echo "<div class='col-xs-3'>". $this->Form->input("ContactUs.email", array("label"=>false, "placeholder"=>"Search by email", "div"=>false,'class'=>"form-control"))."</div>"; ?>
				<div class='col-xs-6 admin-search-btn'>
					<input type="submit" class="btn bg-olive margin" value="Search">	
					<a href="<?php echo $this->here; ?>" class="btn btn-warning" ><?php echo ('Reset'); ?></a>
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
                                           <th><?php echo $this->Paginator->sort('email'); ?></th>
                                           <th><?php echo $this->Paginator->sort('message'); ?></th>
                                           <th><?php echo $this->Paginator->sort('status'); ?></th>
                                           <th><?php echo $this->Paginator->sort('created'); ?></th>
                                           <th class="actions"><?php echo ('Actions'); ?></th>
                                        </tr>
				</thead>
				<tbody>
				<?php if(!empty($messages)) {
                                    foreach ($messages as $message): ?>
				<tr>
					<td><?php echo h($message['ContactUs']['email']); ?>&nbsp;</td>
					<td><?php if(strlen($message['ContactUs']['message'])>50){
						echo h(substr($message['ContactUs']['message'],0,50).'....');
					      }else{
						echo h($message['ContactUs']['message']);
					      } ?>&nbsp;
                                        </td>
					<td><?php echo h($message['ContactUs']['status_name']);?></td>
					<td><?php echo h($message['ContactUs']['created']); ?>&nbsp;</td>
					<td class="actions">
                                            <?php echo $this->Html->link((''), array('action' => 'replyMessage', base64_encode($message['ContactUs']['id'])),array('class'=>'fa fa-mail-reply','title'=>'Reply Message')); ?>
                                       </td>
                                       
				</tr>
                                <?php endforeach; } else { ?>
                                <tr>    
                                    <td class="text-center" colspan="5"><?php echo ('No result found.'); ?>&nbsp;</td>
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
