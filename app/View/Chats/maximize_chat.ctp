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
                        <?php echo $this->element($elementFolder . '/sidebar'); ?>
                    </div>  
                    <!-- MIDDLE CONTENT -->
                    <div class="col-sm-10">
                        <div class="profile-form-layout">

                            <div class="chat-wrap chat-floater btm0">
                                <div class="chat-content" style="padding:0;">
                                    <?php echo $this->element('chat_history_chat_element'); ?>

                                </div> 

                            </div>
                            <!--                            <div class="row">
                                                            <div class="col-lg-8 col-xs-offset-2">
                            <?php //echo $this->element('pagination', array('paging_action' => $this->here)); ?>
                                                            </div>    
                                                        </div>    -->

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



