<div class="login-box">
      <div class="login-logo">
          <a href="javascript:void(0)"><b><?php echo __dbt('Forgot Password'); ?></b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg"><?php echo __dbt('Enter your email to get new password.') ?></p>
        <?php echo $this->Form->create('User', array('url' => array("controller"=>"admins", "action"=>$this->params['action']))); ?>
          <div class="form-group has-feedback">
            <?php echo $this->Form->input('email', array('type' => 'email','class'=>'form-control','placeholder'=>__dbt('Email'),'label' => false,'value'=>isset($_COOKIE['email']) ? $_COOKIE['email'] : '' )); ?>
            <!--input type="email" class="form-control" placeholder="Email"-->
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
          
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
                <?php 
               
                echo $this->Form->hidden('prefix',array('value'=>$prefix));
                echo $this->Form->submit(__dbt('Submit'),array('type' => 'submit','class'=>'btn btn-primary btn-block btn-flat'));?>
             
            </div><!-- /.col -->
          </div>
       <?php echo $this->Form->end(); ?>


      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
