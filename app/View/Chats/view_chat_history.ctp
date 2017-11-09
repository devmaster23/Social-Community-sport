<!-- MAIN CONTENT -->
<div class="main-wrap">
    <div class="container">
        <?php echo $this->Common->topNavSports(AuthComponent::User('id')); ?>
        <div class="profile-page-wrap">
            <div class="event-title">
                <h4><?php echo __dbt('Chat History'); ?></h4>
            </div>
            <!-- INNER WRAP -->
            <div class="inner-wrap">
                <div class="row">
                    <div class="col-sm-2">
                    <?php echo $this->element($elementFolder.'/sidebar'); ?>
                    </div>  
                    <!-- MIDDLE CONTENT -->
                    <div class="col-sm-10">
                        <div class="profile-form-layout">
                            
                                    <div class="chat-wrap chat-floater btm0">
                                        <div class="chat-content">
                                        <?php 
                                        if(!empty($chats))  {  
                                        foreach($chats as $chat) :
                                            $timeElapsed = humanTiming(strtotime($chat['Chat']['created']));
                                            if($chat['Chat']['user_id'] == AuthComponent::User('id')) { 
                                            ?>
                                            <!-- right side chat -->
                                            <div class="chat-rpt">
                                                <div class="chat-usr-dtl pull-right">
                                                    <div class="chat-avtar">
                                                        <?php echo $this->Chat->getUserImage($chat['User']['file_id'])?>
                                                    </div>
                                                    <div class="chat-user">
                                                        <h4><?php echo __dbt($chat['User']['name'])?> </h4>
                                                        <p><?php echo $timeElapsed .' ago';?></p>
                                                    </div>
                                                </div>
                                                <div class="chat-desc my-txt">
                                                   <?php echo __dbt($chat['Chat']['name'])?>
                                                </div>
                                            </div>
                                           <?php } else { ?>
                                            <!-- Left side chat -->
                                            <div class="chat-rpt">
                                                <div class="chat-usr-dtl ">
                                                    <div class="chat-avtar">
                                                        <?php echo $this->Chat->getUserImage($chat['User']['file_id'])?>
                                                    </div>
                                                    <div class="chat-user">
                                                        <h4><?php echo __dbt($chat['User']['name'])?> </h4>
                                                        <p><?php echo $timeElapsed .' ago';?></p>
                                                    </div>
                                                </div>
                                                <div class="chat-desc ">
                                                   <?php echo __dbt($chat['Chat']['name'])?>
                                                </div>
                                            </div>
                                            
                                       
                                           <?php } endforeach; 
                                        } else {
                                            
                                            echo __dbt('Chat history not available.');
                                        } ?>
                                             
                                         </div> 
                                        
                                </div>
                                <div class="row">
                                    <div class="col-lg-8 col-xs-offset-2">
                                        <?php echo $this->element('pagination',array('paging_action'=>$this->here));?>
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
<!-- MAIN CONTENT END -->



