 <?php if(!empty($wallContents)) { $nextLoadPage = 0;  
 foreach($wallContents as $content): 
     $nextLoadPage = isset($content['WallContent']['id']) ? $content['WallContent']['id'] : ''; ?>    
                 <div class="post-main cmnt-sbmt-dsn" id="postId_<?php echo $nextLoadPage; ?>">  
                    <div class="user-post">
                      <div class="post-sb-main">          
                      <div class="post-user ">
                        <div class="post-avatar">
                          <a href="javascript:void(0);"><?php echo $this->Wall->userImage($content['User']['id']); ?></a>
                        </div>
                        <div class="post-usr-dtl">
                          <div class="pull-left">
                            <h4><a href="javascript:void(0);"><?php echo __dbt($content['User']['name']); ?></a></h4>
                            <p><?php echo __dbt('Post Date:'). date('Y-F-d',  strtotime(__dbt($content['WallContent']['created']))); ?></p>
                          </div>
                          <div class="pull-right">
                              <?php if(AuthComponent::User('id') == $content['WallContent']['user_id']) { ?>  
                              <ul class="nav navbar-nav">
                                <li class="dropdown "><a href="#"  data-toggle="dropdown" class="dropdown-toggle" role="button"><?php echo __dbt('Action');?> <b class="caret"></b></a>
                                    <ul role="menu" class="dropdown-menu" aria-labelledby="drop1">
                                        <li role="presentation"><a class="deletePostBtn" href="javascript:void(0)" id="<?php echo $content['WallContent']['id']; ?>" role="menuitem"><?php echo __dbt('Delete'); ?></a></li>
                                        
                                    </ul>
                                </li>
                              </ul>
                            <?php } ?>  
                            <!--div class="editdropdown">
                              <button onclick="myFunction()" class="dropbtn"><i class="caret"></i></button>
                                <div id="myDropdown" class="dropdown-content">
                                  <a href="javascript:void(0)"><?php echo __dbt('Delete');?></a>
                                </div>
                            </div-->
                          </div>
                        </div>  
                      </div>
                      </div>
                      <div class="post-cntnt clearfix">
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
                      <div class="comment-section comment-btn clearfix">
                        <div class="col-xs-6">
                          <span><img src="/img/comment.png" alt="" /></span>
                          <span>
                            <a href="javascript:void(0)"  class="comment-btn"><?php if(!empty($content['WallComment'])) { 
                              echo '<span id="commentCount'.$nextLoadPage.'">'.count($content['WallComment']).'</span>'.' '. __dbt('Comments'); } else { echo '<span id="commentCount'.$nextLoadPage.'">0</span>'.' '. __dbt('Comments'); } ?></a>
                          </span>
                        </div>
                        <div class="col-xs-6 cmnt-btn-pls">
                           <a class="comment-btn1" href="javascript:void(0);" title="<?php echo __dbt('show comment')?>"><i class="fa fa-plus"> </i></a> 
                        </div>  
                      </div>
                    </div>
                    <div class="comment-list clearfix hide">
                      <ul>
                        <?php if(!empty($content['WallComment'])) { 
                            $commentCount = 0;
                                            foreach($content['WallComment'] as $comment): ?>
                        <li id="commentId_<?php echo $comment['id'] ?>">
                        <div class="clearfix">
                          <span class="profile_img"><a href="javascript:void(0);"><?php echo $this->Wall->userImage($comment['user_id']); ?></a></span>
                          <div class="main-comment">
                            <div class="clearfix">
                              <div class="pull-left">
                                <span class="name"><a href="javascript:void(0);"><?php echo $this->Wall->showName($comment['user_id']); ?></a></span>
                                <span class="comment-time"><?php echo date('Y-F-d',strtotime(__dbt($comment['created'])));?></span>
                              </div>
                              <div class="pull-right">
                                <?php if($comment['user_id'] == AuthComponent::User('id')) { ?>
                                <a href="javascript:void(0)" title="delete comment" class="delete-comment del-hover" id="delete_<?php echo $comment['id'] ?>"><i class="fa fa-trash-o"></i></a>
                                <a href="javascript:void(0)" title="edit comment" class="edit-comment edit-hover" id="edit_<?php echo $comment['id'] ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <?php } ?>
                              </div>
                            </div>
                            <div class="coment-content CommentBoxShow" id="comment_<?php echo $comment['id'] ?>"><?php echo $comment['comment'];?></div>
                            <div id="commentBox_<?php echo $comment['id'] ?>" class="CommentBoxHide"></div>
                          </div>
                        </div>
                        </li>
                        <?php $commentCount++; 
                            if($commentCount >= 6) {
                            break;
                            }
                        endforeach; } ?> 
                        <li class="add-more-comment" id="addNewComment_<?php echo $nextLoadPage ?>"></li>
                      </ul>
                      <div class="full-post-link">  
                        <?php if(isset($commentCount) && $commentCount >= 6) { 
                            echo $this->Html->link(__dbt('View More'), array('controller' => 'walls','action' => 'post', base64_encode($content['WallContent']['id'])),array('title'=>__dbt('View Post'))); 
                        } ?>
                      </div>  
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
                                              $("#tagError_<?php echo $content['WallContent']['id'] ?>").html("<?php echo __dbt('Please enter valid Email address.')?>");
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
                            <span id="Error_addComment_<?php echo $content['WallContent']['id'] ?>" ></span>
                            <span id="postError_<?php echo $content['WallContent']['id']; ?>"></span>
                            <?php echo $this->Form->button(__dbt('Comment'),array('id'=>'cmtBtn_'.$content["WallContent"]["id"],'type'=>'button','class'=>'post-btn pull-right postCommentBtn')); ?>
                          </div>
                          <?php echo $this->Form->end(); ?>
                          </div>
                        </div>
                        <?php } else { ?>
                            <div class="attach-post post-comment clearfix">
                                <p class="text-center text-danger">
                                    <?php echo __dbt('You can not comment here. You are blocked by').' '.$content['User']['name']; ?>
                                </p>
                            </div>    
                        <?php } ?>   
                      </div>
                      
                      
                  </div> 
                    </div>
                <?php  endforeach; } ?> 
              <div id="loadMoreComments" data-page="<?php if(isset($nextLoadPage)) echo $nextLoadPage;?>"></div>