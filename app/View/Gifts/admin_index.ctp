<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo __dbt('Gifts'); ?>
        <small><?php echo __dbt('List Gifts'); ?></small>
    </h1>
    <?php echo $this->element($elementFolder . '/breadcrumb'); ?>

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
                                <?php echo $this->Form->create('Gift', array('type' => 'get', 'url' => array('controller' => 'gifts', 'action' => 'index', $this->params["prefix"] => true, 'class' => "form-control"), "novalidate" => "novalidate")); ?>
                                
                                <?php echo "<div class='col-xs-2'>" . $this->Form->input("Gift.name", array("type" => "text", "placeholder" => __dbt("Name"), "label" => false, "div" => false, 'class' => "form-control")) . "</div>"; ?>
                                <?php echo "<div class='col-xs-2'>" . $this->Form->input("Gift.amount", array("type" => "text", "placeholder" => __dbt("Amount"), "label" => false, "div" => false, 'class' => "form-control")) . "</div>"; ?>
                                <?php 
                                $optionsType = array('1' => __dbt('Gifts'), '2' => __dbt('Cash Order'));
                                echo "<div class='col-xs-2'>" . $this->Form->input("Gift.type", array("type" => "select", "empty" => "--All Type--", "options" => $optionsType, "label" => false, "div" => false, 'class' => "form-control")) . "</div>"; ?>
                                <?php echo "<div class='col-xs-2'>" . $this->Form->input("Gift.status", array("type" => "select", "empty" => "--All Status--", "options" => $status, "label" => false, "div" => false, 'class' => "form-control")) . "</div>"; ?>
                                <div class='col-xs-3 admin-search-btn'>
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
                                
                                <th><?php echo $this->Paginator->sort('name'); ?></th>
                                <th><?php echo $this->Paginator->sort('GiftCategory.name'); ?></th>
                                <th><?php echo $this->Paginator->sort('type'); ?></th>
                                <th><?php echo $this->Paginator->sort('sport'); ?></th>
                                <th><?php echo $this->Paginator->sort('tournament'); ?></th>
                                <th><?php echo $this->Paginator->sort('league'); ?></th>
                                <th><?php echo $this->Paginator->sort('start date'); ?></th>
                                <th><?php echo $this->Paginator->sort('end date'); ?></th>
                                <th><?php echo $this->Paginator->sort('amount'); ?></th>
                                <th><?php echo $this->Paginator->sort('status'); ?></th>
                                <th class="actions"><?php echo __dbt('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($gifts)) { //pr($gifts);die;
                                foreach ($gifts as $gifts)
                                {
                                    
                                        ?>
                                        <tr>
                                            <td><?php echo h($gifts['Gift']['name']); ?>&nbsp;</td>
                                            <td><?php 
                                            if($gifts['Gift']['gift_category_id']==0)
                                            {
                                              echo h('All');
                                            }
                                            else{
                                            echo h($gifts['GiftCategory']['name']);} ?>&nbsp;</td>
                                            <td><?php 
                                            if($gifts['Gift']['type']==1){
                                                echo __dbt('Product Price');
                                            }else if($gifts['Gift']['type']==2){
                                                echo __dbt('Cash Order Amount');
                                            }else{
                                                echo __dbt('Amount');
                                            }
                                             ?>&nbsp;</td>
                                            <td><?php if($gifts['Sport']['id'] == 0){ echo h('NA');}else{ echo h($gifts['Sport']['name']); } ?></td>
                                            <td><?php if($gifts['Tournament']['id'] == 0){ echo h('NA');}else{ echo h($gifts['Tournament']['name']); } ?></td>
                                            <td><?php if($gifts['League']['id'] == 0){ echo h('NA');}else{ echo h($gifts['League']['name']); } ?></td>
                                            <td><?php echo h($gifts['Gift']['start_date']); ?>&nbsp;</td>
                                            <td><?php echo h($gifts['Gift']['end_date']); ?>&nbsp;</td>
                                            <td><?php echo h($gifts['Gift']['amount']); ?>&nbsp;</td>
                                            <td><?php echo h($gifts['Gift']['status_name']); ?>&nbsp;</td>
                                            <td class="actions">
                                                <?php echo $this->Html->link(__dbt(''), array('action' => 'view', $gifts['Gift']['id']), array('class' => 'fa fa-eye', 'title' => 'View Gifts')); ?>
                                                <?php echo $this->Html->link(__dbt(''), array('action' => 'edit', $gifts['Gift']['id']), array('class' => 'fa fa-edit', 'title' => 'Edit Gifts')); ?>
                                                <?php echo $this->Form->postLink(__dbt(''), array('action' => 'delete', $gifts['Gift']['id']), array('class' => 'fa fa-remove', 'title' => 'Delete Gifts'), array(__dbt('Are you sure you want to delete this gifts ?'))); ?>
                                                
                                            </td>

                                        </tr>
                                    <?php 
                                }
                            } 
                            else 
                            { ?>
                                <tr>    
                                    <td class="text-center" colspan="11"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
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
<?php echo $this->element('pagination', array('paging_action' => $this->here)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>