<!-- FOOTER -->
            <footer class="footer">
            	<div class="footer-top-content">
                	<div class="container">
                    	<div class="row " <?php if(!AuthComponent::User('id')){?>style="padding: 0px 15px !important;"<?php }?>>
                        	<div class="col-xs-8" style="width:auto;">
                            	<h2><?php echo __('Quick Links');?></h2>
                                <ul>         
                                    <li><?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-chevron-right')) . "<span>".__('About Us')."</span>",array('controller' => 'pages', 'action' => 'view','about_us'),array('escape' => false)); ?></li>
                                    <li><?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-chevron-right')) . "<span>".__('Contact Us')."</span>",array('controller' => 'pages', 'action' => 'view','contact_us'),array('escape' => false)); ?></li>
                                    <li><?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-chevron-right')) . "<span>".__('Help')."</span>",array('controller' => 'pages', 'action' => 'view','help'),array('escape' => false)); ?></li>
                                    <li><?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-chevron-right')) . "<span>".__('Privacy Policy')."</span>",array('controller' => 'pages', 'action' => 'view','privacy_policy'),array('escape' => false)); ?></li>
                                    <li><?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-chevron-right')) . "<span>".__('Terms and Conditions')."</span>",array('controller' => 'pages', 'action' => 'view','terms_conditions'),array('escape' => false)); ?></li>
                                </ul>
                            </div>
                            
                            <div class="col-xs-4"  style="width:auto;float: right;">
                            	<h2><?php echo __('Sport Category');?></h2>
                                <ul>
                                    <?php foreach($footerSports as $sports): ?>
                                    <li><?php echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-chevron-right')) . "<span>".__($sports['Sport']['name'])."</span>",array('controller' => 'Sports', 'action' => 'sport',$sports['Sport']['id']),array('escape' => false)); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            	<div class="copyright">
                	<div class="container">
                    	<div class="row">
                        	<p class="col-xs-12"><?php echo __('Copyright &copy; ' . date('Y') . '. All Right Reserved.');?></p>
                        </div>
                    </div>
                </div>
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="http://arrow.scrolltotop.com/arrow59.js"></script>
<noscript><a href="http://www.scrolltotop.com/">Scroll to Top Button</a></noscript>


            </footer>
            <!-- FOOTER END -->
        
        
        <!--  LOGIN MODAL  -->
        <div class="login-modal">
            <!-- line modal -->
            <div class="modal fade login-modal" id="log-in" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                            <h3 class="modal-title" id="lineModalLabel"><?php echo __('SIGN IN');?></h3>
                        </div>
                        <div class="modal-body">
                            <?php $loginErrorMsg = $this->Flash->render('loginError'); 
                            echo $loginErrorMsg;?>
                            <!-- content goes here -->
                            <div class="panel panel-info">
                                <div class="panel-body">            
                                    <div class="row">
                                        <div class="col-xs-7 form-layout">
                                            
						<?php echo $this->Form->create('User',array('url'=> array( 'controller'=>'users','action'=>'login'),'id'=>'signInId','class'=>'form-horizontal','inputDefaults'=>array('label'=>false,'div'=>true))); ?>
                                                <fieldset> 
                                                    <div class="text-box">                
							    <?php echo $this->Form->input('email',array('class'=>'form-control input-md inbox','placeholder'=>__('Enter Email'),'required'=>false,'maxlength'=>70,'minlength'=>6,'value'=>isset($_COOKIE['email']) ? $_COOKIE['email'] : '' )); ?>
                                                    </div>
                                                    <div class="text-box">
                                                        <?php echo $this->Form->input('password',array('class'=>'form-control input-md inbox','placeholder'=>__('Enter Password'),'required'=>false,'maxlength'=>70,'minlength'=>6,'value'=>isset($_COOKIE['password']) ? $_COOKIE['password'] : '')); ?>

                                                    </div>
                                                    <div class="spacing">
                                                        <p><input type="checkbox" id="test9" value="1" class="form-control" name="data[User][remember_me]"><label for="test9"><?php echo __('Remember Me');?></label> </p>
                                                        <a href="/users/forgot_password"><small> <?php echo __('Forgot Password?');?></small></a>            
                                                    </div>            
                                                    <button class="btn btn-info btn-sm pull-right" name="Sign In" id="SignIn"><?php echo __('Sign In');?></button>
                                                </fieldset>
                                            <?php echo $this->Form->end(); ?>
                                        </div>
                                        <div class="col-xs-5">
                                            <div class="social-btn">
                                               <?php echo $this->Html->link($this->Html->image('facebook.jpg',array('class'=>'facebookuser','fb-id'=>'5')), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => 'Facebook', 'escape' => false));?>
                                                <?php echo $this->Html->link($this->Html->image('google-plus.jpg',array('class'=>'googleuser','my-id'=>'5')), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => 'Google', 'escape' => false));?>
                                                <?php echo $this->Html->link($this->Html->image('twitter.jpg',array('class'=>'twitteruser','tw-id'=>'5')), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => 'Twitter', 'escape' => false));?>
                                            </div>
                                        </div>                                          
                                    </div>            
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- line modal -->
            <div class="modal fade login-modal" id="blog-log-in" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only"><?php echo __('Close');?></span></button>
                            <h3 class="modal-title" id="lineModalLabel"><?php echo __('VIDEO UPLOADER SIGN IN');?></h3>
                        </div>
                        <div class="modal-body">
                             <?php $videoBloginError = $this->Flash->render('videoBloginError'); 
                                echo $videoBloginError;?>
                            <!-- content goes here -->
                            <div class="panel panel-info">
                                <div class="panel-body">            
                                    <div class="row">
                                        <div class="col-xs-7 form-layout">
						<?php echo $this->Form->create('User',array('url'=> array( 'controller'=>'users','action'=>'login','blogger'=>true),'id'=>'blogSignInId','class'=>'form-horizontal','inputDefaults'=>array('label'=>false,'div'=>true))); ?>
                                                <fieldset> 
                                                    <div class="text-box">                
							    <?php echo $this->Form->input('email',array('class'=>'form-control input-md','placeholder'=>__('Enter Email'),'required'=>false,'maxlength'=>70,'minlength'=>6,)); ?>
                                                    </div>
                                                    <div class="text-box">
                                                        <?php echo $this->Form->input('password',array('class'=>'form-control input-md','placeholder'=>__('Enter Password'),'required'=>false,'maxlength'=>70,'minlength'=>6,)); ?>

                                                    </div>
                                                    <div class="spacing">
                                                        <p><input type="checkbox" id="test9"> <label for="test9"><?php echo __('Remember Me');?></label> </p>
                                                        <a href="/users/forgot_password"><small><?php echo __('Forgot Password?');?></small></a>            
                                                    </div>            
                                                    <button class="btn btn-info btn-sm pull-right" name="Sign In" id="SignIn"><?php echo __('Sign In');?></button>
                                                </fieldset>
                                            <?php echo $this->Form->end(); ?>
                                        </div>
                                        <div class="col-xs-5">
                                            <div class="social-btn">
                                                <?php echo $this->Html->link($this->Html->image('facebook.jpg',array('class'=>'facebookuser','fb-id'=>'6')), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => 'Facebook', 'escape' => false));?>
                                                <?php echo $this->Html->link($this->Html->image('google-plus.jpg',array('class'=>'googleuser','my-id'=>'6')), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => 'Google', 'escape' => false));?>
                                                <?php echo $this->Html->link($this->Html->image('twitter.jpg',array('class'=>'twitteruser','tw-id'=>'6')), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => 'Twitter', 'escape' => false));?>
                                            </div>
                                        </div>                                          
                                    </div>            
                                </div>
                                <div class="form-field field-fix text-right">
                                    <small><?php echo __('Not Registered?');?> <a href="javascript:void(0);" data-target="#become-blogger" data-dismiss="modal" data-toggle="modal"><span class="link"><?php echo __('Sign Up here');?></span></a></small>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- LOGIN MODAL END -->
        
		<!-- SIGN UP MODAL -->
        <div class="signup-modal">
            <div class="modal fade" id="sign-up" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only"><?php echo __('Close');?></span></button>
                            <h3 class="modal-title" id="lineModalLabel"><?php echo __('SIGN UP');?></h3>
                        </div>
                        <div class="modal-body">
                            <!-- content goes here -->
                            <div class="panel panel-info">
                                <div class="panel-body">            
                                    <div class="row">                    
                                        <div style="border-bottom:1px solid #ccc;" class="col-xs-12">
						<?php echo $this->Form->create('User',array('url'=> array( 'controller'=>'users','action'=>'signup'),'id'=>'fanSignUpId','class'=>'form-horizontal loginClass','novalidate' => true,'enctype' => 'multipart/form-data','inputDefaults'=>array('label'=>false,'div'=>false))); ?>

                                            	<div class="form-field">
                                                	<?php echo $this->Form->input('name',array('class'=>'inbox form-control','placeholder'=>__('Name'),'required'=>false,'maxlength'=>25,'label'=>false,'div'=>false)); ?>
                                                </div>

						
                                                <div class="form-field field-fix">
                                                	<?php echo $this->Form->input('email',array('class'=>'inbox form-control','placeholder'=>__('Email'),'required'=>false,'maxlength'=>50)); ?>
                                                        <label id="UserEmailExist-error" class="error"></label>
                                                </div>
						
						
						<!--div class="gndr-rw"> <label>
                                                        
                                                        :</label> <span><input type="radio" name="gender" />Male</span> <span><input type="radio" name="gender" />Female</span></div-->
                                            
                                                <div class="form-field">
                                                	<?php echo $this->Form->input('password',array('id'=>'fanPassword','class'=>'inbox form-control','placeholder'=>__('Enter Password'),'maxlength'=>70,'minlength'=>6,'required'=>false,'type'=>'password')); ?>
							
                                                </div>
						
                                                <div class="form-field field-fix">
                                                	<?php echo $this->Form->input('confirm_password',array('class'=>'inbox form-control','placeholder'=>__('Re-enter Password'),'maxlength'=>70,'minlength'=>6,'required'=>false,'type'=>'password')); ?>
							
                                                </div>
                                                <div class="form-field">
							<?php echo $this->Form->input('locale_id',array('type'=>'select','class'=>'inbox form-control','div'=>false,"empty"=>__("Preferred Language"),'options'=>$LanguageArray,'required'=>false)); ?>
                                                </div>
                                                <div class="form-field field-fix">
                                                	<?php $genderArray = array('0'=>'Male','1'=>'Female');
                                                        echo $this->Form->input('gender',array('type'=>'select','class'=>'inbox form-control','div'=>false,"empty"=>__("Gender"),'options'=>$genderArray,'required'=>false)); ?>
                                                </div>
						<div class="form-field ">
                                                	<div class="upload-btn">
                                                        <a href="javascript:void(0)"><?php echo __('Profile Image');?></a>
                                                        <?php echo $this->Form->input('file_id',array('type'=>'file','label' => false,'accept'=>array("image/*"))); ?>
                                                        <!--input type="file" name="Upload Profile Image" class="inbox form-control" /-->
                                                    </div>
                                                </div>
                                                <div class="form-field field-fix">
                                                	<small><?php echo __('Already Registered?');?> <a data-toggle="modal" data-dismiss="modal" data-target="#log-in" href="javascript:void(0);"><span class="link"><?php echo __('Sign In here');?></span></a></small>
                                                </div>
                                                
                                                
                                                                                                
                                                <div class="form-field field-fix">
                                                	<div class="sign-in-btn">   
                                                        <button class="btn btn-info btn-sm pull-right" name="Register"><?php echo __('Sign Up');?></button>         
                                                    </div>
                                                </div>
						<?php echo $this->Form->input('role_id',array('type'=>'hidden','class'=>'inbox form-control','div'=>false,'value'=>5)); ?>
                                            <?php echo $this->Form->end(); ?>
                                        </div>
                                        
                                        <div class="col-xs-12">
                                            <div class="social-btn"> <span><?php echo __('OR');?></span>
                                                <ul class="footer-li">

						    <li><?php echo $this->Html->link($this->Html->image('facebook.jpg',array('class'=>'facebookuser','fb-id'=>'5')), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => 'Facebook', 'escape' => false));?></li>
                                                    <li><?php echo $this->Html->link($this->Html->image('google-plus.jpg',array('class'=>'googleuser','my-id'=>'5')), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => 'Google', 'escape' => false));?></li>
                                                    <li><?php echo $this->Html->link($this->Html->image('twitter.jpg',array('class'=>'twitteruser','tw-id'=>'5')), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => 'Twitter', 'escape' => false));?></li>
                                                </ul>
                                            </div>
                                        </div>  
                                    </div>            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- BLOGER MODAL -->
        <div class="bloger-modal">
            <div class="modal fade" id="become-blogger" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                            <h3 class="modal-title" id="lineModalLabel"><?php echo __('BECOME A VIDEO UPLOADER');?></h3>
                        </div>
                        <div class="modal-body">
                            <!-- content goes here -->
                            <div class="panel panel-info">
                                <div class="panel-body">            
                                    <div class="row">
                                    	<?php echo $this->Form->create('User',array('url'=> array( 'controller'=>'users','action'=>'signup'),'id'=>'bloggerSignUpId','class'=>'form-horizontal loginClass','enctype' => 'multipart/form-data','inputDefaults'=>array('label'=>false,'div'=>true))); ?>
                                            <div class="col-xs-12" style="border-bottom:1px solid #ccc;">
                                            	<div class="form-field">
						<?php echo $this->Form->input('name',array('class'=>'inbox form-control','placeholder'=>'Name','required'=>false,'maxlength'=>25)); ?>
                                                </div>
                                                <div class="form-field field-fix ">
                                                	<?php echo $this->Form->input('email',array('class'=>'inbox form-control','placeholder'=>__('Email'),'required'=>false,'maxlength'=>50)); ?>
                                                        <label id="UserEmailExist-error1" class="error"></label>
                                                </div>
                                                <div class="form-field">
                                                	<?php echo $this->Form->input('password',array('type'=>'password','id'=>'BloggerPassword','class'=>'inbox form-control','placeholder'=>__('Enter Password'),'required'=>false,'maxlength'=>70,'minlength'=>6,)); ?>
                                                </div>
                                                
                                            	<div class="form-field field-fix">
                                                	<?php echo $this->Form->input('confirm_password',array('type'=>'password','class'=>'inbox form-control','placeholder'=>__('Re-enter Password'),'required'=>false,'maxlength'=>70,'minlength'=>6,)); ?>
                                                </div>
                                                <div class="form-field">
                                                	<?php echo $this->Form->input('locale_id',array('type'=>'select','class'=>'inbox form-control','div'=>false,"empty"=>__("Preferred Language"),'options'=>$LanguageArray,'required'=>false)); ?>
                                                </div>
                                                <div class="form-field field-fix">
                                                	<?php $genderArray = array('0'=>'Male','1'=>'Female');
                                                        echo $this->Form->input('gender',array('type'=>'select','class'=>'inbox form-control','div'=>false,"empty"=>__("Gender"),'options'=>$genderArray,'required'=>false)); ?>
                                                </div>
                                                <div class="form-field">
                                                	<div class="upload-btn">
                                                        <a href="javascript:void(0)"><?php echo __('Profile Image');?></a>
                                                        <?php echo $this->Form->input('file_id',array('type'=>'file','label' => false,'accept'=>array("image/*"))); ?>

                                                    </div>
                                                </div>
                                                
                                                <div class="form-field field-fix">
							
							<small><?php echo __('Already Registered?');?> <a data-toggle="modal" data-dismiss="modal" data-target="#blog-log-in" href="javascript:void(0);"><span class="link"><?php echo __('Sign In here');?></span></a></small>
                                                </div>   
                                                <div class="clr"></div>
                                                <div class="form-field field-fix">
                                                	<div class="sign-in-btn">   
                                                        <button class="btn btn-info btn-sm pull-right" name="Become Video Uploader"><?php echo __('Become a VIDEO Uploader');?></button>         
                                                    </div>
                                                </div>
                                            </div>
                                        <?php echo $this->Form->input('role_id',array('type'=>'hidden','class'=>'inbox form-control','div'=>false,'value'=>6)); ?>
                                            <?php echo $this->Form->end(); ?>
                                    </div>
				    <div class="col-xs-12">
                                            <div class="social-btn"> <span><?php echo __('OR'); ?></span>
                                                <ul class="footer-li">
                                                    <li>
							<?php echo $this->Html->link($this->Html->image('facebook.jpg',array('class'=>'facebookuser','fb-id'=>'6')), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => 'Facebook', 'escape' => false));?></li>
                                                    <li><?php echo $this->Html->link($this->Html->image('google-plus.jpg',array('class'=>'googleuser','my-id'=>'6')), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => 'Google', 'escape' => false));?> </li>
                                                    <li><?php echo $this->Html->link($this->Html->image('twitter.jpg',array('class'=>'twitteruser','tw-id'=>'6')), 'javascript:void(0);', array('class' => 'lusn-icon lusn-facebook', 'Title' => 'Twitter', 'escape' => false));?> </li>
						    
						    
                                                </ul>
                                            </div>
                                        </div>
				    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BLOGER MODAL END -->
    <?php if($loginErrorMsg) { ?>    
    <script>$('#log-in').modal('show');</script>
    <?php } ?>  
    <?php if($videoBloginError) { ?>    
    <script>$('#blog-log-in').modal('show');</script>
    <?php } ?> 
    <?php echo $this->Html->script(array("front/custom")); ?>
    
    <?php
    if(isset($auth_error)){
        echo "<script> loginForm(); </script>";
    }
    if(isset($reg_errors)){?>
	
        <script> $('#sign-up').modal('show'); </script>
	
 <?php   }?>

<script>
jQuery(document).ready(function(){
    function createCookie(name,value,days) {
	if (days) {
	    var date = new Date();
	    date.setTime(date.getTime()+(days*24*60*60*1000));
	    var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
    }
    
    $(document).on('click','.facebookuser',function(){
	var val = $(this).attr("fb-id");
	if(val==6){
	    createCookie('fbid','6',1);
	}
	else{
	    createCookie('fbid','5',1);
	}
	location.href = "/users/loginbyfacebook";
    })

    $(document).on('click','.googleuser',function(){
	var val = $(this).attr("my-id");
	if(val==6){
	    createCookie('myid','6',1);
	}
	else{
	    createCookie('myid','5',1);
	}
	
	window.location.href = "<?php echo $authUrl;?>"
    });
    
    $(document).on('click','.twitteruser',function(){
	var val = $(this).attr("tw-id");
	if(val==6){
	    createCookie('twid','6',1);
	}
	else{
	    createCookie('twid','5',1);
	}
	
	location.href = "/users/twitterLogin";
    });
    
    
}); 
</script>