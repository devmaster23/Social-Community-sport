<?php echo $this->Html->script(array('front/tag-it')); 
echo $this->Html->css(array("front/base-min", "front/brawler", "front/reset-fonts", "front/jquery.tagit","front/tagit.ui-zendesk.css")); ?>
<div class="main-wrap">
   <div class="container">
       <?php echo $this->Common->topNavSports(AuthComponent::User('id')); ?>
      <div class="event-title">
            <h4><?php echo __dbt('Post Details'); ?></h4>
      </div>  
      <!-- Inner wrap start -->
      <div class="inner-wrap">
            <div class="row">
          <!-- Sidebar start -->
          <div class="col-sm-2 sidebar-new">
          <?php echo $this->element($elementFolder.'/sidebar'); ?>
          </div>

          <!-- Sidebar end -->
          <!-- Main content start -->
          <div class="col-sm-7 custom-wdth">
            <div class="main-content">
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="post-title">
                              <h4><?php echo __dbt('My Wall'); ?></h4>
                          </div>
                      </div> 
                  </div>
                  <?php if(!empty($wallContents)) $nextLoadPage = 0; { foreach($wallContents as $content): 
                      $nextLoadPage = $content['WallContent']['id'];
                      ?>    
                   <div class="post-main pst-dt-wal" id="postId_<?php echo $nextLoadPage; ?>">  
                    <div class="user-post">
                      <div class="post-user">
                        <div class="post-avatar">
                          <a href="javascript:void(0);"><?php echo $this->Wall->userImage($content['User']['id']); ?></a>
                        </div>
                        <div class="post-usr-dtl">
                          <div class="pull-left">
                            <h4><a href="javascript:void(0);"><?php echo __dbt($content['User']['name']); ?></a></h4>
                            <p><?php echo __dbt('Post Date:'). __dbt($content['WallContent']['created']); ?></p>
                          </div>
                          <div class="pull-right">
                            <?php if(AuthComponent::User('id') == $content['WallContent']['user_id']) { ?>  
                              <ul class="nav navbar-nav">
                                <li class="dropdown "><a href="#"  data-toggle="dropdown" class="dropdown-toggle" role="button"><?php echo __dbt('Action');?> <b class="caret"></b></a>
                                    <ul role="menu" class="dropdown-menu" aria-labelledby="drop1">
                                        <!--li role="presentation"><a class="deletPost" href="javascript:void(0)" id="< ?php echo $content['WallContent']['id']; ?>" role="menuitem"><?php echo __dbt('Delete'); ?></a></li-->
                                        <li role="presentation"><a class="deletePostBtn" href="javascript:void(0)" id="postDiv_<?php echo $content['WallContent']['id']; ?>" role="menuitem"><?php echo __dbt('Delete'); ?></a></li>
                                    </ul>
                                </li>
                              </ul>
                            <?php } ?>  
                          </div>
                        </div>  
                      </div>
                      <div class="post-cntnt clearfix">
                        <div class="post-top"><!--h4> Lorem ipsum dolor sit amet :-)</h4--></div>
                        <div class="post-card">
                          <div class="card-image">
                            <?php echo $this->Wall->showMedia($content['User']['id'],$contentType = $content['WallContent']['content_type'],$contentId = $nextLoadPage); 
                            //fan or blog post  
                            if( $content['WallContent']['file_id'] != 0) {
                                echo '<p class="wll-post-content">'.__dbt($content['WallContent']['name']).'</p>'; 
                                echo $this->Wall->showPostUpload($content['WallContent']['file_id'],$content['WallContent']['content_type']); 
                              }
                            ?>
                          </div>                                            
                        </div>
                      </div>
                        <?php echo $this->Wall->getTaggedUser($nextLoadPage,$content['User']['id']); ?>
                      <div class="comment-section clearfix">
                        <div class="col-xs-6">
                          <span><img src="/img/comment.png" alt="" /></span>
                          <span>
                            <a href="javascript:void(0)" class="comment-btn"><?php if(!empty($content['WallComment'])) { 
                              echo '<span id="commentCount'.$nextLoadPage.'">'.count($content['WallComment']).'</span>'.' '. __dbt('Comments'); } else { echo '<span id="commentCount'.$nextLoadPage.'">0</span>'.' '.__dbt('Comments'); } ?></a>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="comment-list clearfix">
                      <ul>
                        <?php if(!empty($content['WallComment'])) { 
                                            foreach($content['WallComment'] as $comment): ?>
                        <li id="commentId_<?php echo $comment['id'] ?>">
                        <div class="clearfix">
                          <span class="profile_img"><a href="javascript:void(0);"><?php echo $this->Wall->userImage($comment['user_id']); ?></a></span>
                          <div class="main-comment">
                            <div class="clearfix">
                              <div class="pull-left">
                                <span class="name"><a href="javascript:void(0);"><?php echo $this->Wall->showName($comment['user_id']); ?></a></span>
                                <span class="comment-time"><?php echo __dbt($comment['created']);?></span>
                              </div>
                              <div class="pull-right">
                                <?php if($comment['user_id'] == AuthComponent::User('id')) { ?>
                                <a href="javascript:void(0)" title="delete comment" class="delete-comment del-hover" id="delete_<?php echo $comment['id'] ?>"><i class="fa fa-trash-o"></i></a>
                                <a href="javascript:void(0)" title="edit comment" class="edit-comment edit-hover" id="edit_<?php echo $comment['id'] ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <?php } ?>
                              </div>
                            </div>
                            <div class="coment-content CommentBoxShow" id="comment_<?php echo $comment['id'] ?>"><?php echo __dbt($comment['comment']);?></div>
                            <div id="commentBox_<?php echo $comment['id'] ?>" class="CommentBoxHide"></div>
                          </div>
                        </div>
                        </li>
                        <?php endforeach; } ?> 
                        <span class="add-more-comment" id="addNewComment_<?php echo $nextLoadPage ?>"></span>
                      </ul>
                      <?php if(!in_array($content['WallContent']['user_id'],$notCommentOnPostUser)) { ?>        
                      <div class="attach-post post-comment clearfix">
                      <span class="comment-user comment-div"><a href="javascript:void(0);"><?php echo $this->Wall->userImage(AuthComponent::User('id')); ?></a></span>
                      <div class="post-content user-comment-area">
                        <div class="comment-wrapper">
                          <?php echo $this->Form->create('WallComment',array('id'=>'addComment_'.$content['WallContent']['id'],'class'=>'form-horizontal', 'novalidate'));
                                echo $this->Form->hidden('wall_id',array('value'=>$content['WallContent']['wall_id'])); 
                                echo $this->Form->hidden('content_id',array('value'=>$content['WallContent']['id'])); 
                                echo $this->Form->textarea('name',array('id'=>'tagUsersEmail_'.$content['WallContent']['id'],'placeholder'=>__dbt('Comment here...'),'class'=>'form-control postCmt'));
                                echo $this->Form->textarea('tagUsersEmail',array('id'=>'tagUser_'.$content['WallContent']['id'],'class'=>'tag-emails'));
                          
                                ?>
                            <script>
                                $(function(){
                                    var sampleTags = [<?php echo rtrim($tagUsers, ',')?>];
                                    $('#tagUser_<?php echo $content['WallContent']['id'] ?>').tagit({
                                        availableTags: sampleTags,
                                        beforeTagAdded: function(event, ui) {
                                              var result = isEmail(ui.tagLabel);
                                              if (!result) {    
                                              $("#tagError_<?php echo $content['WallContent']['id'] ?>").html('Please enter valid Email address.');
                                              return false;
                                              } else {
                                                  $("#tagError_<?php echo $content['WallContent']['id'] ?>").html('');
                                             }
                                          }
                                    });
                                });


                            </script>  
                          <div class="post-icons">
                            <span><a href="javascript:void(0);" class="tag-in-comment" id="<?php echo $content['WallContent']['id'] ?>" data-toggle="tooltip" title="Tag" data-placement="bottom"><i class="fa fa-tag"></i></a></span>  
                            
                          </div>    
                          <div class="attach-file">
                            <span id="postError_<?php echo $content['WallContent']['id']; ?>"></span>
                            <?php echo $this->Form->button(__dbt('Comment'),array('type'=>'button','id'=>'cmtBtn_'.$content["WallContent"]["id"],'class'=>'post-btn pull-right postComment')); ?>
                          </div>
                          <?php echo $this->Form->end(); ?>
                          </div>
                        </div>
                      <?php } else { ?>
                              <div class="attach-post post-comment clearfix">
                                  <p class="text-center text-danger">
                                      <?php echo __dbt('You can not comment here. You are blocked by '.$content['User']['name'].'.'); ?>
                                  </p>
                              </div>    
                          <?php } ?>   
                      
                      </div>
                  </div> 
                    </div>
                  <?php  endforeach; } ?>
            </div>
              
            </div>
          <!-- Main content end -->
          <div class="col-sm-3 custom-wdth-col3"> 
            <div class="rgt-sidebar">
               <div class="top-banner">
                  <img src="/img/top-banner.jpg" />
               </div>
            <?php //echo $this->element('chat_element'); ?>
            </div>
         </div>	
      </div> 
      </div> 
      </div>  
      <!-- Inner wrap end -->
   </div>
</div>   


<!-- Middle end -->

<div id="loadmoreajaxloader" style="display:none;"><center><img src="/img/loader.gif" /></center></div>
<script>
    $(document).ready(function(){
        
       $(".postCmt").keyup(function(event){
            if(event.keyCode == 13){
                var id = $(this).attr('id').split("_").pop();
                
                var textAreaVal = $(this).attr('id');
                var cmntVal = $('#'+textAreaVal).val();
                $('#postError_'+id).html('');
                $('#postError_'+id).html('');
                if($(this).val().trim().length>179){
                    $('#postError_'+id).html("<?php echo __dbt('you can not comment more then 180 character.')?>");    
                    return false;
                 }
                
                if(cmntVal.trim() == ''){
                    //alert();
                        $('#postError_'+id).html("<?php echo __dbt('Please enter comment.')?>");
                        return false;
                    }
                $("#cmtBtn_"+id).trigger('click');
            }
        });
         
        
       // display comment form for edit   
       $(document).on('click','.edit-comment',function(){
        var id = $(this).attr('id').split("_").pop();  
        
            $('.CommentBoxHide').html(''); 
            $('.coment-content').show(); 
            $('#comment_'+id).next().html('<?php echo $this->Form->create('WallComment',array('class'=>'form-horizontal', 'novalidate'));
                                echo $this->Form->hidden('id',array('id'=>'editFormID')); 
                                echo $this->Form->textarea('comment',array('id'=>'editFormContent','placeholder'=>__dbt('Comment here...'),'class'=>'form-control'));
                                echo $this->Form->button(__dbt('Cancel'),array('type'=>'button','id'=>'resetBtn','class'=>'post-btn pull-right'));
                                echo $this->Form->button(__dbt('Update'),array('type'=>'button','id'=>'editPostBtn','class'=>'post-btn pull-right'));
                                echo $this->Form->end();
                                ?>');
            $('#editFormID').val(id); 
            $('#editFormContent').text($('#comment_'+id).html());
            $('#comment_'+id).hide();
            
            $('#delete_'+id).hide();
            $('#edit_'+id).hide();
       });
       
       
      
       // delete comment
       $(document).on('click','.delete-comment',function(){
        if (!confirm("<?php echo __dbt('Are you sure you want to delete this comment.')?>")) { 
                return false;
               }   
        var id = $(this).attr('id').split("_").pop();  
            $('.CommentBoxHide').html(''); 
            var commentFormId = $(this).closest('.post-main').attr('id').split("_").pop(); 
            $('.coment-content').show(); 
            var url = "<?php echo $this->Html->url(array("controller"=>"walls", "action"=>"deleteComment", $this->params["prefix"] => false)); ?>";
            $.post(url, {data:id}, function(data){
                if(data == 'success'){
                    $('#commentId_'+id).remove();
                    $('#commentCount'+commentFormId).text(parseInt($('#commentCount'+commentFormId).text()) - 1);
                } else {
                    $('#status_'+id).html("<span class='comment-error'><?php echo __dbt('Error in comment deletion! Please try again.')?></span>");
                }
               
            });
            
       });
       
       
       
      // edit comment script 
      $(document).on('click','#editPostBtn',function(){
           var formData = $('#WallCommentPostForm').serializeArray();
           var editId = formData[1]['value'];
           var cmntVal = $('#editFormContent').val();
           if(cmntVal.trim() == ''){
                        alert("<?php echo __dbt('Please enter comment.')?>");
                        return false;
                    }
           var url = "<?php echo $this->Html->url(array("controller"=>"walls", "action"=>"editComment", $this->params["prefix"] => false)); ?>";
            $.post(url, {data:formData}, function(data){
               $('.CommentBoxHide').html(''); 
               $('.coment-content').show();  
                if(data != 'error')
                {   
                    $('#delete_'+editId).show();
                    $('#edit_'+editId).show();
                    $('#status_'+editId).html("<span class='comment-success'><?php echo __dbt('Comment has been updated')?></span>");
                    $('#comment_'+editId).html(data);
                } else {
                        $('#status_'+editId).html("<span class='comment-error'><?php echo __dbt('Error in comment updation! Please try again.')?></span>");
                       }
           
            });
      });
      //disble button script
      var enableSubmit = function(ele) {
            $(ele).removeAttr("disabled");
        }

      // post new comments
      $(document).on('click','.postComment',function(){
        //disble button for some time
        var that = this;
        $(this).attr("disabled", true);
        setTimeout(function() { enableSubmit(that) }, 1000);  
           var formId = $(this).closest("form").attr('id');
           var commentFormId = $('#'+formId+' #WallCommentContentId').val(); 
           var formData = $('#'+formId).serializeArray();
           var wallId = formData[1]['value'].trim();
           var cmtID = $(this).attr('id').split("_").pop();  
           var commentValue = formData[3]['value'].trim();
           $('#postError_'+cmtID).html('');
           if(commentValue.length>179){
                    $('#postError_'+cmtID).html("<?php echo __dbt('you can not comment more then 180 character.')?>");    
                    return false;
                    } 
           if(commentValue == ''){
               $('#postError_'+cmtID).html("<?php echo __dbt('Please enter comment.')?>");
               return false;
           }
            var cDate = new Date();
            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var date = cDate.getFullYear()+'-'+ months[cDate.getMonth()] +'-'+cDate.getDate();
 
            var url = "<?php echo $this->Html->url(array("controller"=>"walls", "action"=>"comment", $this->params["prefix"] => false)); ?>";
            $.post(url, {data:formData}, function(data){
               if(data !== 'error')
               {
                   
                   if($('#tagUser_'+commentFormId).val() != '') {
                       $('#'+commentFormId).trigger('click');
                       $('#tagUser_'+commentFormId).val('');
                   }
                   $('#postError_'+commentFormId).html('');
                   $('#tagUsersEmail_'+commentFormId).val('');
                   $('#addNewComment_'+commentFormId).replaceWith('<li id="commentId_'+data+'"><div class="clearfix"><span class="profile_img"><a href="javascript:void(0);"><?php echo $this->Wall->userImage(AuthComponent::User("id")); ?></a></span><div class="main-comment"><div class="clearfix"><span class="name"><a href="javascript:void(0);"><?php echo $this->Wall->showName(AuthComponent::User("id")); ?></a></span> <span class="comment-time pull-right">'+date+'</span> </div><div class="coment-content CommentBoxShow" id="comment_'+data+'">'+commentValue+'</div><div id="commentBox_'+data+'" class="CommentBoxHide"></div></div></div>  <div class="pull-right"> <a class="delete-comment" href="javascript:void(0);" id="delete_'+data+'"><i class="fa fa-trash-o"></i></a>&nbsp;<a href="javascript:void(0);" class="edit-comment" id="edit_'+data+'"><i class="fa fa-pencil-square-o"></i></a> </div></li><div id="addNewComment_'+commentFormId+'"></div>');                    
               } else {
                   $('#postError_'+commentFormId).replaceWith("<span class='comment-error'><?php echo __dbt('Error in saving comment! Please try again.')?></span>");
               }
               
            });
      });
      
      //cancel edit
      $(document).on('click','#resetBtn',function(){
      var editId = $('#editFormID').val();
        $('.CommentBoxHide').html(''); 
        $('.coment-content').show();  
        $('#delete_'+editId).show();
        $('#edit_'+editId).show();
        });
      
      
      // delete my post
       $(document).on('click','.deletePostBtn',function(){
           if (!confirm("<?php echo __dbt('Are you sure you want to delete this post.')?>")) { 
                return false;
               }
               
            var id =  $(this).attr('id').split("_").pop();  
            var url = "<?php echo $this->Html->url(array("controller"=>"walls", "action"=>"deletePost", $this->params["prefix"] => false)); ?>";
            $.post(url, {data:id}, function(data){
                if(data == 'success'){
                   $('#postId_'+id).remove();
                } 
            });
            
       });
      
      //open tag box in comment section
      $(document).on('click','.tag-in-comment',function(){
        var commentId = $(this).attr('id');  
        $('#addComment_'+commentId+' .tagit').toggle();
         
      });
      
      
      
      
    });
    
    
function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
        }    
    
</script>