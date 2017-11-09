 <!-- MAIN CONTENT -->
<div class="main-wrap">
    <div class="container">
        <?php echo $this->Common->topNavSports(AuthComponent::User('id')); ?>
        <!-- PROFILE PAGE --> 
        <div class="profile-page-wrap">
            <div class="event-title">
                <h4><?php echo __dbt('Team User'); ?></h4>
            </div>

            <!-- INNER WRAP -->
            <div class="inner-wrap">
                <div class="row">
                    <!-- Sidebar start -->
                    <div class="col-sm-2">
                    <?php echo $this->element($elementFolder.'/sidebar'); ?>
                    </div>
                    <!-- SIDEBAR END -->

                    <!-- MIDDLE CONTENT -->
                        <div class="col-sm-10">
                            <div class="profile-form-layout user-description">
                                <div class="fb-profile">
                                    
                                    <?php echo $this->Sport->sportBannerImage($userTeam['Sport']['banner_image']); ?>
                                    <?php echo $this->Wall->profileImage($userTeam['User']['id']); ?>

                                    <div class="fb-profile-text">
                                        <h1><?php echo __dbt($userTeam['User']['title']).' '.__dbt($userTeam['User']['name']);?></h1>
                                        <p><?php echo __dbt('Joined Team :'). __dbt($userTeam['UserTeam']['created']); ?></p>
                                    </div>

                                    <div class="row">
                                        <div class=" col-md-9 col-lg-9 "> 
                                            <table class="table table-user-information">
                                              <tbody>
                                                  <tr>
                                                    <td><?php echo __dbt('Name'); ?> : </td>
                                                    <td><?php echo __dbt($userTeam['User']['title']).' '.__dbt($userTeam['User']['name']); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td><?php echo __dbt('Email'); ?> :</td>
                                                    <td><?php echo __dbt($userTeam['User']['email']); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td><?php echo __dbt('Sport'); ?> :</td>
                                                    <td><?php echo __dbt($userTeam['Sport']['name']); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td><?php echo __dbt('Tournament'); ?> :</td>
                                                    <td><?php echo __dbt($userTeam['Tournament']['name']); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td><?php echo __dbt('League'); ?> :</td>
                                                    <td><?php echo __dbt($userTeam['League']['name']); ?></td>
                                                  </tr>
                                                  <tr>
                                                    <td><?php echo __dbt('User Since'); ?> :</td>
                                                    <td><?php echo __dbt($userTeam['User']['created']); ?></td>
                                                  </tr>
                                                   <tr>
                                                    <td><?php echo __dbt('Restrict to view post'); ?> :</td>
                                                    <td>
                                                    <?php if($data['UserPermission']['see_post']==1){
                                                        echo $this->Form->input('',array('class'=>'checkValue','id'=>'see_post','checked'=>true,'type'=>'checkbox'));
                                                        }else{
                                                            echo $this->Form->input('',array('class'=>'checkValue','id'=>'see_post','checked'=>false,'type'=>'checkbox'));
                                                        }?></td>
                                                  </tr>
                                                    <tr>
                                                    <td><?php echo __dbt('Restrict to comment on post'); ?> :</td>
                                                    <td><?php if($data['UserPermission']['comment_post']==1){echo $this->Form->input('',array('class'=>'checkValue','id'=>'comment_post','checked'=>true,'type'=>'checkbox'));}else{
                                                        echo $this->Form->input('',array('class'=>'checkValue','id'=>'comment_post','checked'=>false,'type'=>'checkbox'));
                                                        }?></td>
                                                  </tr>
                                                     <tr>
                                                    <td><?php echo __dbt('Restrict to tag on posts'); ?> :</td>
                                                    <td><?php if($data['UserPermission']['tag_post']==1){echo $this->Form->input('',array('class'=>'checkValue','id'=>'tag_post','checked'=>true,'type'=>'checkbox'));}else{
                                                        echo $this->Form->input('',array('class'=>'checkValue','id'=>'tag_post','checked'=>false,'type'=>'checkbox'));
                                                        }?></td>
                                                  </tr>
                                                  
                                              </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    <!-- MIDDLE CONTENT END -->
                </div> 
            </div>  
            <!-- INNER WRAP END -->
        </div>
        <!-- PROFILE PAGE EMD --> 
                    </div>
</div>
<script>
    
    $(document).ready(function(){
        $(document).on('click','.checkValue',function(){
            
            var changeData = $(this).attr('id');
            var UserId = "<?php echo $userTeam['User']['id'];?>";
            
            jQuery.ajax({
                url: '/UserTeams/updatePermissionStatus/'+changeData+'/'+UserId,
                type:'POST',
                success: function(data) {

            }
            });
        })
    })
</script>