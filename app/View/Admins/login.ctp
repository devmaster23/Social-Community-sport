<?php
$admin = (strtolower($this->params["prefix"]) == __dbt('admin'))?"": __dbt('Admin');

?>
<div class="login-box">
      <div class="login-logo">
          <a href="javascript:void(0)"><b><?php echo Inflector::humanize($this->params["prefix"]).' '.$admin.' '. ('Login');  ?></b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg"><?php echo ('Sign in to start your session'); ?></p>
        <?php echo $this->Form->create('User', array('url' => array("controller"=>"admins", "action"=>$this->params['action']))); ?>
          <div class="form-group has-feedback">
            <?php echo $this->Form->input('email', array('type' => 'email','class'=>'form-control','placeholder'=>'Email','label' => false,'value'=>isset($_COOKIE['email']) ? $_COOKIE['email'] : '' )); ?>
            <!--input type="email" class="form-control" placeholder="Email"-->
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <?php echo $this->Form->input('password', array('type' => 'password','class'=>'form-control','placeholder'=>'Password','label' => false,'value'=>isset($_COOKIE['password']) ? $_COOKIE['password'] : '')); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" value="1" class="rememberme-box" name="data[User][remember_me]"><?php echo ('Remember Me');?>
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
                <?php echo $this->Form->submit(('Login'),array('type' => 'submit','class'=>'btn btn-primary btn-block btn-flat'));?>
             
            </div><!-- /.col -->
          </div>
        <?php echo $this->Form->end(); ?>


        <a href="/admins/forgot_password/<?php echo Inflector::humanize($this->params["prefix"]);?>"><?php echo ('I forgot my password');?></a><br>
       

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
