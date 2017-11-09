<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Translation'); ?>
    <small><?php echo __dbt('List Translations'); ?></small>
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
                                <?php echo $this->Form->create($model, array('type' => 'get', 'url' => array('controller' => 'translations', 'action' => 'index',$model, $this->params["prefix"] => true, 'class' => "form-control"), "novalidate" => "novalidate")); ?>
                                
                                <?php echo "<div class='col-xs-3'>" . $this->Form->input("$model.text", array("type" => "text", "placeholder" => __dbt("Text"), "label" => false, "div" => false, 'class' => "form-control")) . "</div>"; ?>
                                <?php echo "<div class='col-xs-3'>" . $this->Form->input("$model.translation", array("type" => "text", "placeholder" => __dbt("Translation"), "label" => false, "div" => false, 'class' => "form-control")) . "</div>"; ?>
                                
                                
                                <div class='col-xs-4 admin-search-btn'>
                                    <input type="submit" class="btn bg-olive margin" value="Search">	
                                    <a href="<?php echo $this->here; ?>" class="btn btn-warning" ><?php echo __dbt('Reset'); ?></a>
                                    <a href="<?php echo '/admin/translations/index/'.$model.'/add'; ?>" class="btn bg-olive margin" title="Add Translation"><?php echo __dbt("Add New"); ?></a>
                                </div>	
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>	   
                    </div>
                </div>
                <div style="clear:both;"></div>
                
		
		<div class="box-body">
			<table id="example2" class="table table-striped">
				<thead>
					<tr>
					<th width="10%"><?php echo $this->Paginator->sort('id'); ?></th>
					<th width="35%"><?php echo $this->Paginator->sort('text'); ?></th>					
					<th width="35%"><?php echo $this->Paginator->sort('translation'); ?></th>
					<?php /*<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>*/?>
					<th class="actions" width="20%"><?php echo __dbt('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
                                    <?php if(isset($this->request->params['pass']['1']) && $this->request->params['pass']['1']!='' && $this->request->params['pass']['1']=='add'){ ?>
                                    <tr>
                                        <td>&nbsp;</td>
                    <?php echo $this->element('translations/index_edit');?>
                                        <td><?php echo $this->Form->submit('Submit',array('type' => 'submit','class'=>'btn btn-primary','div'=>false));?><a class="btn btn-warning margin" href="/admin/translations/index/<?php echo $model;?>"><?php echo __dbt('Cancel'); ?></a><?php  echo $this->Form->end();?></td>
                                        </tr>
                                    <?php }?>
	<?php foreach ($trans as $trans): ?>
                                    <tr id="<?php echo $trans[$model]['id'];?>">
		<td><?php echo h($trans[$model]['id']); ?>&nbsp;</td>
                <?php if(isset($this->request->params['pass']['1']) && $this->request->params['pass']['1']!='' && base64_decode($this->request->params['pass']['1'])==h($trans[$model]['id'])){?>
                    <?php echo $this->element('translations/index_edit');?>
                <?php }else{?>
		<td><?php echo h($trans[$model]['text']); ?>&nbsp;</td>
		<td><?php echo h($trans[$model]['translation']); ?>&nbsp;</td>
                <?php }?>
		<?php /*<td><?php echo h($trans[$model]['created']); ?>&nbsp;</td>
		<td><?php echo h($trans[$model]['modified']); ?>&nbsp;</td>*/?>
		<td class="actions">
                    <?php if(isset($this->request->params['pass']['1']) && $this->request->params['pass']['1']!='' && base64_decode($this->request->params['pass']['1'])==h($trans[$model]['id'])){?>
                    <?php echo $this->Form->submit('Submit',array('type' => 'submit','class'=>'btn btn-primary','div'=>false));?><a class="btn btn-warning margin" href="/admin/translations/index/<?php echo $model;?>"><?php echo __dbt('Cancel'); ?></a><?php  echo $this->Form->end();?>
                    <?php }else{?>
                    <a href="<?php echo '/admin/translations/index/'.$model.'/'.base64_encode($trans[$model]['id']).'#'.$trans[$model]['id']; ?>" class="fa fa-pencil" title="Edit Translation"></a>                
                    <?php echo $this->Html->link(__dbt(''), array('action' => 'view',$model,  base64_encode($trans[$model]['id'])), array('class'=>'fa fa-eye','title'=>'View Translation')); ?>
			
			<?php 
                        //echo $this->request->params['pass'][0];
                        echo $this->Html->link(__dbt(''), array('action' => 'edit',$model, base64_encode($trans[$model]['id'])), array('class'=>'fa fa-edit','title'=>'Edit Sport')); ?>
						<?php echo $this->Form->postLink(__dbt(''), array('action' => 'delete',$model,base64_encode($trans[$model]['id'])), array('class'=>'fa fa-remove','title'=>'Delete Translation'),array('confirm' => __dbt('Are you sure you want to delete %s?'))); ?>
                    <?php }?>
			
			
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
				<?php  echo $this->element('pagination',array('paging_action'=>$this->here)); ?>
				</div>
			</div>
		</div>
	
    </div>
  </div>
</section>

<script>
    var model  = "<?php echo $model;?>";
    $("#<?php echo $model;?>AdminIndexForm").validate({
        rules: {  
          "data[<?php echo $model;?>][text]": "required",
          "data[<?php echo $model;?>][translation]": "required"
          
        },
        messages: {
          "data[<?php echo $model;?>][text]": "<?php echo __dbt('Please add Text.')?>",
          "data[<?php echo $model;?>][translation]": "<?php echo __dbt('Please add Translation.')?>"
         
        }
      });
</script>