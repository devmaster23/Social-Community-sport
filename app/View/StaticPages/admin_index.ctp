<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Static Pages'); ?>
    <small><?php echo __dbt('List Static Pages'); ?></small>
  </h1>
  <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
  
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
                                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                                    <th><?php echo $this->Paginator->sort('description'); ?></th>
                                    <th><?php echo $this->Paginator->sort('status'); ?></th>
                                    <th><?php echo $this->Paginator->sort('created'); ?></th>
                                    <th><?php echo $this->Paginator->sort('modified'); ?></th>
                                    <th class="actions"><?php echo __dbt('Actions'); ?></th>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($staticPages as $page): ?>
                                    <tr>
                                        <td><?php echo h($page['StaticPage']['id']); ?>&nbsp;</td>
                                        <td><?php echo h($page['StaticPage']['name']); ?>&nbsp;</td>
                                        <td><?php echo html_entity_decode($page['StaticPage']['description']); ?>&nbsp;</td>
                                        <td><?php echo h($page['StaticPage']['status']); ?>&nbsp;</td>
                                        <td><?php echo h($page['StaticPage']['created']); ?>&nbsp;</td>
                                        <td><?php echo h($page['StaticPage']['modified']); ?>&nbsp;</td>
                                        <td class="actions">

                                                <?php echo $this->Html->link(__dbt(''), array('action' => 'view',  base64_encode($page['StaticPage']['id'])), array('class'=>'fa fa-eye','title'=>'View Sport')); ?>
                                                <?php echo $this->Html->link(__dbt(''), array('action' => 'edit', base64_encode($page['StaticPage']['id'])), array('class'=>'fa fa-edit','title'=>'Edit Sport')); ?>

                                        </td>
                                    </tr>
                                 <?php endforeach; ?>
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
