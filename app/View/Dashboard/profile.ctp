 <!-- MAIN CONTENT -->
            <div class="main-wrap">
            	<div class="container">
                    <!-- ADD WORD -->
                    <div class="row">
                    	<div class="col-xs-12 space-bottom-40 text-center">
                        	<div class="add-word-box"><a href="javascript:void(0);"><img src="/img/add-word.jpg" alt="add-word" /></a></div>
                        </div>
                    </div>
                    <!-- ADD WORD END -->
                    
                    <!-- PROFILE PAGE --> 
                    <div class="profile-page-wrap">
                        <div class="event-title">
                            <h4>Profile Setting</h4>
                        </div>
                    
                        <!-- INNER WRAP -->
                        <div class="inner-wrap">
			<div class="row">
                            <?php echo $this->Form->create('User', array("novalidate"=>"novalidate","class"=>"form-horizontal", "enctype"=>"multipart/form-data")); ?>
                            <?php echo $this->Form->hidden('id'); ?>  <!-- SIDEBAR -->
                                <aside class="col-sm-2">
                                    <div class="sidebar">                      	
                                        <figure class="profile-avtar">
                                        	<img src="/img/sample-img1.jpg" alt="profile avtar" />
                                            <figcaption><a href="javascript:void(0);">Edit Image</a> <input type="file" /></figcaption>
                                        </figure>
                                    </div>
                                </aside>
                                <!-- SIDEBAR END -->
                                
                                <!-- MIDDLE CONTENT -->
                                <div class="col-sm-10">
                                    <div class="profile-form-layout">
                                    	<div class="col-2">
                                        	<div class="pull-left">
                                            	<div class="form-field"><?php echo $this->Form->input('name',array('class'=>'inbox form-control',)); ?></div>
                                                
                                                <div class="form-field"> 
                                                    <?php $gender_options = array("Male", "Female");
                                                        echo $this->Form->input('gender', array("type"=>"select",'class'=>'form-control','label' => false,'default'=>'-- Select Gender -- ', "options"=>$gender_options)); ?> 
                                                	
                                                </div>
                                            </div>
                                            <div class="pull-right">
                                            	<div class="form-field">
                                                	<p><?php echo $users['User']['email']; ?></p>
                                                </div>
                                                <div class="form-field">
                                                	<p><?php echo __('LANG ').':'. $users['Locale']['name'] .' ('. $users['Locale']['code'] .')' ?></p>
                                                </div>
                                                <div class="form-field">
                                                    <?php
                                                    echo $this->Form->button('Cancel', array('type' => 'reset','class'=>'btn from-btn')); 
                                                    echo '&nbsp;'.$this->Form->submit('Save',array('type' => 'submit','class'=>'btn from-btn','div'=>false)); ?>
                                                    <?php echo $this->Form->end();?>
                                                	
                                                </div>
                                            </div>
                                            <div class="clr"></div>
                                        </div>
                                        
                                        <div class="col-2">
                                        	<h3 class="box-title"><span>Changes Password</span></h3>
                                        	<div class="pull-left">
                                            	<div class="form-field"><input class="inbox form-control" placeholder="CURRENT PASSWORD" value=""/></div>
                                                <div class="form-field"><input class="inbox form-control" placeholder="NEW PASSWORD"/></div>
                                                <div class="form-field"><input class="inbox form-control" placeholder="RE-ENTER PASSWORD"/></div>
                                                <div class="form-field"><input class="btn from-btn" type="submit" value="CHANGE" /></div>
                                            </div>
                                            <div class="clr"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- MIDDLE CONTENT END -->
                        <?php echo $this->Form->end(); ?>
                        </div> 
                        </div>  
                        <!-- INNER WRAP END -->
                    </div>
                    <!-- PROFILE PAGE EMD --> 
				</div>
            </div>
            <!-- MAIN CONTENT END -->
            
