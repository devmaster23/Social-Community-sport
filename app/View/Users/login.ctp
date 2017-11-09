<section>
<div class="lp">
<?php echo $this->Flash->render();?>  
    <?php echo $this->Flash->render('loginError');  ?>
    <?php echo $this->Flash->render('videoBloginError');  ?>
    <?php echo $this->Flash->render('editorError');  ?>
    <br/>
    <div class="login-page-layout">
        <div class="container-fluid">
            <div class="row">

                
                     <div class="event-title">
     <div class="inn-title">
            <h2><i class="fa fa-check" aria-hidden="true"></i><?php echo __dbt('Sign In'); ?></h2>
      </div>  
</div>
                <?php echo $this->Form->create('User',array('id'=>'signInId','class'=>'form-horizontal loginClass','novalidate' => true,'div'=>false)); ?>
                
                <div class="col-xs-12" style="border-bottom:1px solid #ccc;">
                    <div class="form-field">
                        <?php echo $this->Form->input('email',array('class'=>'inbox form-control','placeholder'=>__dbt('Enter Email'),'required'=>false,'maxlength'=>70,'value'=>isset($_COOKIE['email']) ? $_COOKIE['email'] : '','div'=>false )); ?>
                    </div>
                    
                    <div class="form-field field-fix ">
                        <?php echo $this->Form->input('password',array('class'=>'inbox form-control','placeholder'=>__dbt('Enter Password'),'required'=>false,'maxlength'=>70,'value'=>isset($_COOKIE['password']) ? $_COOKIE['password'] : '')); ?>
                        
                    </div>
                    <div class="form-field">
                        <?php echo $this->Form->input('remember_me',array('type'=>'checkbox','checked'=>!empty($_COOKIE['email']) ? true : false));  ?>
                                                        
                    </div>
                   
                    <div class="form-field field-fix">
                        <small><a href="/users/forgot_password"><?php echo __dbt('Forgot Password?');?> </a></small>
                    </div> 
                    <div class="clearfix"></div>    
<!--                    <div class="form-field">
                        <?php //echo $this->Html->link(__dbt('Go Back'), array('controller'=>'Pages','action'=>'home','blogger'=>false), array( 'escape' => false,"class"=>"btn btn-info btn-sm pull-right",'style'=>'float:left !important'));?>
                                                        
                    </div>-->
                    <div class="form-field field-fix">
                        <div class="sign-in-btn"> 
                            <?php echo $this->Form->submit(__dbt('Sign In'),array('class'=>'btn btn-info btn-sm pull-right'));?>
                            <!--button class="btn btn-info btn-sm pull-right" name="Become Blog Poster"><?php echo __dbt('Become a Video Uploader');?></button-->
                        </div>
                    </div>
                </div>
                
                <?php echo $this->Form->end(); ?>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="social-btn"> <span><?php echo __dbt('OR');?></span>
                        <ul class="footer-li">
                            <li>
                            <?php echo $this->Html->link($this->Html->image('facebook.jpg',array('class'=>'facebookuser','fb-id'=>(isset($socialRoleSet)?$socialRoleSet:6))), array('controller'=>'SocialMedias','action'=>'loginWithFacebook'), array('class' => 'lusn-icon lusn-facebook', 'Title' => __dbt('Facebook'), 'escape' => false));?></li>
                            <li><?php echo $this->Html->link($this->Html->image('google-plus.jpg',array('class'=>'googleuser','my-id'=>(isset($socialRoleSet)?$socialRoleSet:6))), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => __dbt('Google'), 'escape' => false));?> </li>
                            <li><?php echo $this->Html->link($this->Html->image('twitter.jpg',array('class'=>'twitteruser','tw-id'=>(isset($socialRoleSet)?$socialRoleSet:6))), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => __dbt('Twitter'), 'escape' => false));?> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
</section>
