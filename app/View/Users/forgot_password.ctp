<div class="main-wrap">
    <div class="login-page-layout frgt-layout">
        <div class="container-fluid">
            <div class="row">
            	<h2 class="box-title"><span><?php echo __dbt('Forgot Password'); ?></span></h2>
                <?php echo $this->Form->create('User', array('action' => 'forgot_password')); ?>
                
                <div class="col-xs-12" >
                    <div class="form-field forget-password">
                        <?php echo $this->Form->input('email', array('type' => 'email','class'=>'form-control','placeholder'=>__dbt('Enter your registered email'),'label' => false)); ?>

                    </div>
                    <div class="forget-btn clearfix g-bk-t">
                        <div class="form-field">    
                            <div class="sign-in-btn">

				<?php echo $this->Html->link(__dbt('Go Back'), array('controller'=>'Pages','action'=>'home'), array( 'escape' => false,"class"=>"btn btn-info btn-sm pull-right"));?>
                            </div>               
                        </div>
                        <div class="form-field field-fix text-right">
                            <div class="sign-in-btn"> 
                                 <?php echo $this->Form->submit(__dbt('Submit'),array("class"=>"btn btn-info btn-sm pull-right")); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php echo $this->Form->end(); ?>
            </div>
            
        </div>
	</div>
</div>