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
                        <?php if($poll['Poll']['poll_category_id'] == 3){ ?>
                        <div class="row post-main cmnt-sbmt-dsn">  
                            <div class="user-post">
                                <div class="post-sb-main">
                                    <div class="post-user">
                                        <p class="pull-right"><?php echo __dbt('Post Date: '.$poll['Poll']['created'])?></p> 
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
                                        <a class="comment-btn" href="javascript:void(0)"><span id="commentCount25">0</span> Comment</a>
                                      </span>
                                    </div>
                                    <div class="col-xs-6 cmnt-btn-pls">
                                          <a class="comment-btn1" href="javascript:void(0);"><i class="fa fa-plus"> </i></a> 

                                     </div>
                                </div>
                            </div> 
                            <div class="comment-list clearfix hide">
                                
                                    <?php echo $this->Poll->showForumComments($poll['Poll']['id'],$page = 'detail');?>
                                
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
                        <?php  } ?>
                    </div>
                    <!-- MIDDLE CONTENT END -->
                    
                    <?php echo $this->element($elementFolder.'/chatbox'); ?>
                </div> 
            </div>  
            <!-- INNER WRAP END -->
        
    </div>
</div>
<script>
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
        
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $(document).on('click', '.comment-btn1', function(){
               $(this).toggleClass("plusimg");
               $(this).closest('.post-main').find('.comment-list').toggleClass('hide');
            });  
        });

</script>

