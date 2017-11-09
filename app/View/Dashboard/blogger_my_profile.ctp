 <!-- MAIN CONTENT -->

<div class="main-wrap">
    
    <div class="container">
<?php echo $this->Flash->render();?>  
       <div class="event-title">
            <h4><?php  echo __dbt('Profile Settings'); ?></h4>
        </div>
        <!-- PROFILE PAGE --> 
        <div class="profile-page-wrap">
            <!-- INNER WRAP -->
            <div class="inner-wrap">
                <div class="row">
                    <!-- Sidebar start -->
                    <aside class="col-sm-2">
                        <?php echo $this->element($elementFolder.'/sidebar'); ?>
                    </aside>
                    <!-- MIDDLE CONTENT -->
                <div class="col-sm-10 profile-form-layout tab-layout-ryt">
                        <!-- SIDEBAR -->
                        <aside class="col-sm-3">
                            <div class="sidebar"> 
                               <?php echo $this->Form->create('User', array("novalidate"=>"novalidate","id"=>"imageUploadFan","class"=>"form-horizontal", "enctype"=>"multipart/form-data")); ?>
                                <?php echo $this->Form->hidden('id'); ?> 
                                <?php  if(!empty($this->request->data['File']['name'])){ ?>
                                 <figure class="profile-avtar pro-img-hytato">
                                         <?php echo $this->Html->image($this->request->data['File']['path'],array('escape'=>false)); ?>
                                    <figcaption id="editImage">
                                        <a href="javascript:void(0);"><?php echo __dbt('Edit Image'); ?></a>  <?php echo $this->Form->input('file_id',array('type'=>'file','label'=>false,'div'=>false,'accept'=>array("image/*"))); ?>
                                    </figcaption>
                                    <figcaption id="editImageSave" style="display:none">
                                        <?php 
                                              echo $this->Form->hidden('update_file_id',array('value'=>$this->request->data['File']['id']));
                                              echo $this->Form->button(__dbt('Cancel'), array('type' => 'reset','id'=>'cancelUpload')); 
                                              echo '&nbsp;'.$this->Form->button(__dbt('Save'),array('type' => 'submit','class'=>'','div'=>false)); ?>
                                    </figcaption>
                                  </figure>               

                               <?php } else { ?>
                                 <figure class="profile-avtar pro-img-hytato">
                                     <img src="/img/default_profile.png" alt="default image">    
                                    <figcaption id="editImage"><a href="javascript:void(0);"><?php echo __dbt('Edit Image'); ?></a>  <?php echo $this->Form->input('file_id',array('type'=>'file','label'=>false,'div'=>false,'accept'=>array("image/*"))); ?></figcaption>
                                    <figcaption id="editImageSave" style="display:none">
                                        <?php echo $this->Form->button(__dbt('Cancel'), array('type' => 'reset')); 
                                              echo '&nbsp;'.$this->Form->button(__dbt('Save'),array('type' => 'submit','class'=>'','div'=>false)); ?>
                                    </figcaption>
                                 </figure>        
                               <?php } ?>

                            <?php echo $this->Form->end();?>        

                            </div>
                        </aside>
                        <!-- SIDEBAR END -->
                        <div class="col-md-9">
                            <?php echo $this->Form->create('User', array("novalidate"=>"novalidate","class"=>"form-horizontal", "enctype"=>"multipart/form-data")); ?>
                            <?php echo $this->Form->hidden('id'); ?> 
                            <div class="pull-left col-md-6">
                                <div class="form-field">
                                        <p><label><?php echo __dbt('Email'); ?></label> <?php if($users['User']['email']){echo $users['User']['email'];}else{ echo 'Twitter User';} ?></p>
                                </div>
                                <div class="form-field">
                                        <p><label><?php echo __dbt('LANG'); ?></label> <?php echo __dbt(' ').''. $users['Locale']['name'] .' ('. $users['Locale']['code'] .')' ?></p>
                                </div>
                            </div>
                            <div class="pull-right lbl-pro-dsbd col-md-6">
                                <div class="form-field">
                                <label><?php echo __dbt('Name'); ?></label>
                                <?php echo $this->Form->input('name',array('class'=>'inbox form-control', 'label'=>false)); ?></div>
                            </div>
                            
                             <div class="pull-left lbl-pro-dsbd col-md-6 sv-btn-ipad">
                                <div class="form-field text-right">
                                    <?php
                                    //echo $this->Form->button('Cancel', array('type' => 'reset','class'=>'btn from-btn')); 
                                    echo '&nbsp;'.$this->Form->submit(__dbt('Save'),array('type' => 'submit','class'=>'btn from-btn','div'=>false)); ?>


                                </div>
                            </div>
                         <?php echo $this->Form->end();?>    
                            <div class="clr"></div>
                        </div>
                        <div class="col-md-12 three-row-ipt">
                                    <h3 class="box-title"><span><?php echo __dbt('Change Password'); ?></span></h3>
                                    <div class="pull-left">
                                    <?php echo $this->Form->create('User',array('url'=>array('controller'=>'dashboard','action'=>'changePassword'),'novalidate',"id"=>"UserFanChangePasswordForm")); 
                                     if(!empty($users['User']['password'])) {    ?>     
                                    <div class="form-field"><?php echo $this->Form->input('User.current_password',array('type'=>'password','class'=>'inbox form-control','placeholder'=>__dbt('Enter current password'),'label' => false)); ?></div>
                                    <?php } ?>
                                    <div class="form-field"><?php echo $this->Form->input('User.new_password',array('type'=>'password','class'=>'inbox form-control','placeholder'=>__dbt('Enter new password'),'label' => false)); ?></div>
                                    <div class="form-field"><?php echo $this->Form->input('User.re_enter_password',array('type'=>'password','class'=>'inbox form-control','placeholder'=>__dbt('Confirm your password'),'label' => false)); ?></div>
                                    <div class="form-field"><?php echo $this->Form->submit(__dbt('Change'),array('type' => 'submit','class'=>'btn from-btn','div'=>false)); ?></div>
                                    <?php echo $this->Form->end(); ?>
                                    </div>

                                <div class="clr"></div>
                            </div>    
                </div>
                <!-- MIDDLE CONTENT END -->
            <!-- INNER WRAP END -->
        </div>
        <!-- PROFILE PAGE EMD --> 
    </div>
</div>
<!-- MAIN CONTENT END -->
            
<script>
    $(document).ready(function(){
        $('#editImage').on('change',function(){
           $(this).css('display','none');
           $('#editImageSave').css('display','block');
        });

        $('#cancelUpload').on('click',function(){
           $('#editImageSave').css('display','none');
           $('#editImage').css('display','block');
        });
        
        $('#backToDashboard').on('click',function(){
           window.location.href = '<?php echo BASE_URL."blogger/dashboard" ?>';
        });
    });

</script>
