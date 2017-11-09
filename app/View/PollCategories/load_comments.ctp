<?php 
    foreach ($polls as $poll): 
         $nextLoadPage = $poll['Poll']['id'];
      if($poll['Poll']['poll_category_id'] == 2){?>
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
                                            <p class="pull-right"><?php echo __dbt('Post Date: '.$poll['Poll']['created'])?></p> 
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
                                        <a class="comment-btn" href="javascript:void(0)">
                                            <?php echo $this->Poll->forumCommentCount($poll['Poll']['id']);?>
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
