<?php echo $this->Form->create('User',array('url'=>array('controller'=>'users','action'=>'changePassword'),'novalidate')); ?> 
    <table class="table table-striped">
            <tbody>
                    <tr>
                      <td><?php echo __dbt('Current Password'); ?></td>
                      <td><?php echo $this->Form->input('User.current_password',array('type'=>'password','class'=>'form-control','placeholder'=>__dbt('Enter current password'),'label' => false)); ?></td>
                    </tr>
                    <tr>
                      <td><?php echo __dbt('New Password'); ?></td>
                      <td><?php echo $this->Form->input('User.new_password',array('type'=>'password','class'=>'form-control','placeholder'=>__dbt('Enter new password'),'label' => false)); ?></td>
                    </tr>
                    <tr>
                      <td><?php echo __dbt('Re-enter Password'); ?></td>
                      <td><?php echo $this->Form->input('User.re_enter_password',array('type'=>'password','class'=>'form-control','placeholder'=>__dbt('Confirm your password'),'label' => false)); ?></td>
                    </tr>
                    
            </tbody>
    </table>
 
<div class="box-footer">
    <div class="col-sm-3 control-label">
    <?php echo $this->Form->submit(__dbt('Change'),array('type' => 'submit','class'=>'btn btn-primary bg-olive btn-flat','div'=>false)); ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>
