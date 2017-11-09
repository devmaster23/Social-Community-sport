<!-- MAIN CONTENT -->
<div class="main-wrap">
    <div class="container">
        <?php echo $this->Common->topNavSports(AuthComponent::User('id')); ?>
            <div class="event-title">
                <h4><?php echo __dbt('Forum & Poll'); ?></h4>
            </div>

            <!-- INNER WRAP -->
            <div class="inner-wrap">
                <div class="row">
                    <!-- Sidebar start -->
                    <div class="col-sm-2 sidebar-new">
                    <?php echo $this->element($elementFolder.'/sidebar'); ?>
                    </div>
                    <!-- SIDEBAR END -->

                    <!-- MIDDLE CONTENT -->
                    <div class="col-sm-7">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="post-title">
                                    <h4><?php echo __dbt('Forum & Poll'); ?></h4>

                                </div>
                            </div> 
                        </div>
                        <?php 
                       
                        foreach ($polls as $poll): 
                          $nextLoadPage = $poll['Poll']['id'];
                          if($poll['Poll']['poll_category_id'] == 2){
                            ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="post-main cmnt-sbmt-dsn well">
                                <div class="poll-qs" id="pollConatiner_<?php echo $nextLoadPage;?>">  
                                    <div class="row">
                                      <div class="col-md-12">
                                          <p><em><?php echo __dbt('Q.');?></em> <?php echo h(__dbt($poll['Poll']['name'])); ?></p>
                                      </div>
                                    </div><!--/row--> 
                                    <?php  echo $this->Form->create('PollResponse',array('class'=>'form-horizontal', 'autocomplete'=>"off"));  ?>
                                    <div class="row">
                                        <?php 
                                       
                                        echo $this->Form->hidden('poll_id',array('id'=>'pollId_'.$nextLoadPage,'value'=>$poll['Poll']['id']));
                                        $options = unserialize($poll['Poll']['options']); 
                                        $str = _('A');
                                        $att = 0;
                                        foreach($options as $option) {?>
                                        <div class="col-md-3 poll-ans">
                                            <span><?php echo __dbt($str++) .' ';?></span>
                                            <input name="name" class="poll-options" type="radio" value="<?php echo $option ?>" >
                                            <label><?php echo __dbt($option);?></label>
                                        </div>
                                        <?php $att++;} ?>
                                    </div>
                                    <div class="row poll-trend">
                                       <?php $str = __dbt('A'); foreach($options as $pollTrend) {  ?> 
                                            <div class="col-md-3">
                                                 <?php echo "<div class='poll-opt'>". __dbt($str++) . "</div>". ' '.$this->Poll->getPollTrend($poll['Poll']['id'],$pollTrend).'%'; ?>
                                            </div>    
                                       <?php } ?> 
                                        
                                    </div>
                                    <div class="post-user-cmnt">
                                            <p class="pull-right"><?php echo __dbt('Post Date:').' '.$poll['Poll']['created']?></p> 
                                        </div>
                                    <?php echo $this->Form->submit(__dbt('Submit'),array('id'=>'pollSave_'.$nextLoadPage,'type' => 'submit','class'=>'post-btn pull-right savePoll pollBtn','div'=>true,'style'=>'display:none;')); 
                                        echo $this->Form->end(); ?>
                                    
                                </div>
                                </div>
                            </div><!--/col-12-->
                        </div><!--/row-->
                        <?php } else if($poll['Poll']['poll_category_id'] == 3){ ?>
                        <div class="row post-main cmnt-sbmt-dsn">  
                            <div class="user-post">
                                <div class="post-sb-main">
                                    <div class="post-user">
                                        <p class="pull-right"><?php echo __dbt('Post Date:').' '.$poll['Poll']['created']?></p> 
                                    </div>
                                </div> 
                                <div class="post-cntnt clearfix">
                                    <div class="post-card">
                                      <div class="card-image">
                                      <?php echo __(strip_tags($poll['Poll']['name']));?>                          
                                      </div>                                            
                                    </div>
                                </div>
                                <div class="comment-section clearfix">
                                    <div class="col-xs-6">
                                      <span><img alt="" src="/img/comment.png"></span>
                                      <span>
                                        <a class="comment-btn" href="javascript:void(0)">
                                            <?php echo $this->Poll->forumCommentCount($poll['Poll']['id']);?>
                                        </a>
                                      </span>
                                    </div>
                                    <div class="col-xs-6 cmnt-btn-pls">
                                          <a class="comment-btn1" href="javascript:void(0);"><i class="fa fa-plus"> </i></a> 

                                     </div>
                                </div>
                            </div> 
                            <div class="comment-list clearfix hide">
                                
                                    <?php echo $this->Poll->showForumComments($poll['Poll']['id'],$page = null);?>
                                
                                <div class="attach-post post-comment clearfix">
                                    <div class="post-content user-comment-area">
                                        <div class="comment-wrapper">
                                            <?php echo $this->Form->create('ForumComment',array('url'=>array('controller'=>'PollCategories','action'=>'addComment'),'id'=>$poll['Poll']['id'],'class'=>'form-horizontal', 'novalidate'));
                                                echo $this->Form->hidden('forum_id',array('value'=>$poll['Poll']['id'])); 
                                                echo $this->Form->textarea('name',array('id'=>"commentBox_".$poll['Poll']['id'],'placeholder'=>__dbt('Comment here...'),'class'=>'form-control postCmt')); 
                                            ?>
                                            <span id="commentError_<?php echo $poll['Poll']['id']?>"></span>
                                            <div class="attach-file">
                                               <?php echo $this->Form->submit(__dbt('Submit'),array('type' => 'button','id'=>'saveForum_'.$poll['Poll']['id'],'class'=>'post-btn pull-right saveForum','div'=>true)); 
                                            ?>
                                            </div>
                                            <?php echo $this->Form->end(); ?>
                                        </div>
                                    </div>
                                </div>
                              <div class="full-post-link"></div>
                            </div> 
                        </div>
                              
                              
                        <?php  }
                          endforeach; ?>
                        <div id="loadMoreComments" data-page="<?php echo !empty($nextLoadPage) ? $nextLoadPage : '';?>"></div>
                    </div>
                    <!-- MIDDLE CONTENT END -->
                    <div class="col-sm-3">
                        <?php //echo $this->element('chat_element'); ?>
                    </div>
                    
                </div> 
            </div>  
            <!-- INNER WRAP END -->
        
    </div>
</div>
<script>
   // load more blogs 
   $(window).scroll(function()
    {
        if($(window).scrollTop() == $(document).height() - $(window).height())
        {
            var loadPageFrom = $('#loadMoreComments').data('page');
            if(loadPageFrom == '')
            {
                $('#loadMoreComments').html("<span class='comment-error'><?php echo __dbt('No more data to show.');?></span>");
                return false;
            }
            $('#loadmoreajaxloader').show();
            var url = "<?php echo $this->Html->url(array("controller"=>"PollCategories", "action"=>"loadComments", $this->params["prefix"] => false)); ?>";
            $.ajax({
            url: url,
            method: "POST",
            data: { loadfrom: loadPageFrom },
            success: function(html)
            {
                //alert(html);

                if(html)
                {
                    $("#loadMoreComments").replaceWith(html);
                    $('#loadmoreajaxloader').hide();
                }else
                {
                    $('#loadmoreajaxloader').html("<center><?php echo __dbt('No more posts to show.');?></center>");
                }
            }
            });
        }
    });
    
        // click for poll option
        $(document).on('click',"input:radio",function() {
            $("input:radio").prop("checked", false);
            $('.pollBtn').hide();
            $(this).prop("checked", true);
            $(this).closest('form').find(':submit').show();
       });
           
        // add new comment using ajax
        $(document).on('click','.saveForum',function(){
            var cDate = new Date();
            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var date = cDate.getFullYear()+'-'+ months[cDate.getMonth()] +'-'+cDate.getDate();

            var formId = $(this).closest("form").attr('id');
            var formData = $('#'+formId).serialize();
            var commentValue = $('#commentBox_'+formId).val();
                if(commentValue == '')
                {
                    $('#commentError_'+formId).html("<?php echo __dbt('Please enter comment.');?>");
                    return false;
                }
                if(commentValue.length >= 255){
                    $('#commentError_'+formId).html("<?php echo __dbt('Comment text cannot contain more than 255 characters.');?>");
                    return false;
                }
            
                var url = "<?php echo $this->Html->url(array("controller"=>"PollCategories", "action"=>"addComment", $this->params["prefix"] => false)); ?>";
                $.post(url, {data:formData}, function(data){
                   if(data != 0) {   
                       $('#commentContainer_'+ formId +' li:last-child').after('<li id="li_'+data+'"><div class="clearfix"><span class="profile_img"><a href="javascript:void(0);"><?php echo $this->Wall->userImage(AuthComponent::User("id")); ?></a></span><div class="main-comment"><div class="clearfix"><span class="name"><a href="javascript:void(0);"><?php echo $this->Wall->showName(AuthComponent::User("id")); ?></a></span> <span class="comment-time pull-right">'+date+'</span> </div><div class="coment-content CommentBoxShow" id="comment_'+data+'">'+commentValue+'</div><div id="commentBox_'+data+'" class="CommentBoxHide"></div></div></div>  <div class="pull-right"> <a class="delete-comment" href="javascript:void(0);" id="delete_'+data+'"><i class="fa fa-trash-o"></i></a>&nbsp;<a href="javascript:void(0);" class="edit-comment" id="edit_'+data+'"><i class="fa fa-pencil-square-o"></i></a> </div></li>');
                       $('#commentBox_'+ formId).val('');
                        } else {
                       $('#commentContainer_'+ formId +' li:last-child').after("<?php __dbt('Error in saving comment.') ?>");
                   }

                });
        });
            
        // edit comment using ajax
        $(document).on('click','.edit-comment',function(){
        var editId = $(this).attr('id').split("_").pop();
        var commentVaule = $('#comment_'+editId).text();
            $('#comment_'+editId).replaceWith('<textarea required="required" class="form-control postCmt" placeholder="Comment here..." id="commentBox_'+editId+'" name="data[ForumComment][name]">'+commentVaule+'</textarea><button class="post-btn pull-right restBtn" id="resetBtn_'+editId+'" type="button">Cancel</button><button class="post-btn pull-right updateBtn" id="editPostBtn_'+editId+'" type="button">Update</button>');
            $('#edit_'+editId).hide();
            $('#delete_'+editId).hide();
        });
        
         // cancel edit comment using ajax
        $(document).on('click','.restBtn',function(){
        var resetId = $(this).attr('id').split("_").pop();
        var commentVaule = $('#commentBox_'+resetId).val();
            $('#commentBox_'+resetId).replaceWith('<div class="coment-content CommentBoxShow" id="comment_'+resetId+'">'+commentVaule+'</div>');
            $('#resetBtn_'+resetId).hide();
            $('#editPostBtn_'+resetId).hide();
            $('#delete_'+resetId).show();
            $('#edit_'+resetId).show();
         });
        
        // update comment using ajax
        $(document).on('click','.updateBtn',function(){
        var editId = $(this).attr('id').split("_").pop();
        var commentVaule = $('#commentBox_'+editId).val();
        $('#commentError_'+editId).remove();
        if(commentVaule.trim() == '') {
            $('#commentBox_'+editId).after("<span id='commentError_"+editId+"'><?php echo __dbt('Please enter comment.');?></span>");
            return false;
        }
        if(commentVaule.trim() >= 255) {
            $('#commentBox_'+editId).after("<span id='commentError_"+editId+"'><?php echo __dbt('Comment text cannot contain more than 255 characters.');?></span>");
            return false;
        }
        var formData = {"id": editId, "value": commentVaule}
            var url = "<?php echo $this->Html->url(array("controller"=>"PollCategories", "action"=>"saveEditComment", $this->params["prefix"] => false)); ?>";
                $.post(url, {data:formData}, function(data){
                   if(data == 0) {   
                       $('#commentBox_'+editId).after("<span id='commentError_"+editId+"'><?php echo __dbt('Error in updating comment.');?></span>");
                   } else {
                        $('#commentBox_'+editId).replaceWith('<div class="coment-content CommentBoxShow" id="comment_'+editId+'">'+commentVaule+'</div>');
                        $('#resetBtn_'+editId).hide();
                        $('#editPostBtn_'+editId).hide();
                        $('#edit_'+editId).show();
                        $('#delete_'+editId).show();
                   }

                });
         });
        
        // delete comment using ajax
        $(document).on('click','.delete-comment',function(){
            var deleteId = $(this).attr('id').split("_").pop();
            var formData = {"id": deleteId}
            var url = "<?php echo $this->Html->url(array("controller"=>"PollCategories", "action"=>"deleteComment", $this->params["prefix"] => false)); ?>";
                $.post(url, {data:formData}, function(data){
                   if(data == 0) {   
                       $('#comment_'+deleteId).after("<span id='commentError_"+deleteId+"'><?php echo __dbt('Error in deleting comment.');?></span>");
                   } else {
                        $('#li_'+deleteId).remove();   
                   }
                });
        });
        
        
       $(document).on('click','.savePoll',function(event){
        event.preventDefault();
        var pollAnswer = $('.poll-options:checked').val();
        var pollId = $(this).attr('id').split("_").pop();
        var formData = {"poll_id": pollId, "name": pollAnswer}
        var url = "<?php echo $this->Html->url(array("controller"=>"PollCategories", "action"=>"savePoll", $this->params["prefix"] => false)); ?>";   
            $.post(url, {data:formData}, function(data){
            $('#ErrorMsg_'+pollId).remove();    
                if(data == 'exist') {  
                    $('#pollConatiner_'+ pollId).after("<span class='text-warning' id='ErrorMsg_"+pollId+"'><?php echo __dbt('You have already submitted poll.');?></span>");
                } else if(data == 0) {
                     $('#pollConatiner_'+ pollId).after("<span class='text-danger' id='ErrorMsg_"+pollId+"'><?php echo __dbt('Error in saving poll poll.Please try again!');?></span>");
                     } else if(data > 0) {
                         $('#pollConatiner_'+ pollId).after("<span class='text-success' id='ErrorMsg_"+pollId+"'><?php echo __dbt('Your poll has been saved.');?></span>");
                        }
            });
        });
        
    $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $(document).on('click', '.comment-btn1', function(){
               $(this).toggleClass("plusimg");
               $(this).closest('.post-main').find('.comment-list').toggleClass('hide');
            });  
    });

</script>

