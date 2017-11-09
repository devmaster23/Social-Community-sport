<?php
echo $this->Html->script(array('front/tag-it'));
?>
<section>
    <div class="lp">
<?php echo $this->Common->topNavSports(AuthComponent::User('id')); ?> 
        <div class="event-title">
            
            <div class="inn-title">
                    <h2><i class="fa fa-check" aria-hidden="true"></i> <?php $teamName = AuthComponent::User('sportSession.teamName');
echo!empty($teamName) ? $teamName . ' ' . __dbt('Wall') : __dbt('Sport Wall');
?></h2>

                </div>
            
            
        </div>   
        <!-- Inner wrap start -->
        <div class="inner-wrap">
            <div class="row">
                <!-- Sidebar start -->
                <div class="col-sm-2 sidebar-new tab-blk-wdth">
<?php echo $this->element($elementFolder . '/sidebar'); ?>
                </div>

                <!-- Sidebar end -->
                <!-- Main content start -->
                <div class="col-sm-7 custom-wdth">
                    <div class="main-content tag-pos">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="post-title">
                                    <h4><?php echo __dbt('My Wall'); ?></h4>                              
                                </div>
                            </div> 
                        </div>
                       <div class="sticky-notes">
                        <!--div class="wall-post-ct"-->
                            <!-- Add new post box start-->
                            <div class="status-post clearfix pst-dft-dsgn">
                                <div class="wall-pst-hd"><h4><img src="/img/pro-user.png" alt="default image"><?php echo __dbt('Write Post'); ?></h4></div>
<?php echo $this->Form->create('WallContent', array('url' => array('controller' => 'walls', 'action' => 'addPost'), 'class' => 'form-horizontal', 'novalidate', "enctype" => "multipart/form-data", "runat" => "server")); ?>
                                <!--div class="attach-post clearfix"-->
                                <div>
                                    <!--span  class="user-image"><a href="#"><?php //echo $this->Wall->userImage(AuthComponent::User('id')); ?></a></span-->
                                    <div class="post-content">
                                        <?php
                                        echo $this->Form->textarea('name', array('placeholder' => __dbt('Write post here.'), 'class' => 'form-control'));
                                        echo $this->Form->textarea('tagUsersEmail', array('id' => 'tagUserPost', 'class' => 'tag-emails'));
                                        ?>
                                        <?php echo $this->Form->input('file_id', array('class' => 'content-hidden', 'type' => 'file', 'label' => false, 'id' => 'fileInput', 'div' => false, 'accept' => array("image/*"))); ?>

<?php echo $this->Form->input('troll_id', array('class' => 'inbox slct-pst-btn form-control', 'options' => $teams, 'div' => false, 'label' => false, 'empty' => __dbt('-- Select Team --'), 'id' => 'troll-Box', 'style' => 'display:none')); ?>    
                                    </div>
                                </div>



                                <div class="post-border clearfix">
                                    <div class="post-icons new-post post-txt-bxwdth">
                                        <a href="javascript:void(0);" id="toggle-troll-widget" data-toggle="tooltip" title="<?php echo __dbt('Troll'); ?>" data-placement="bottom"><i class="fa  fa-commenting-o"></i></a>
                                        <a href="javascript:void(0);" id="open-tag-widget" data-toggle="tooltip" title="<?php echo __dbt('Tag'); ?>" data-placement="bottom"><i class="fa fa-tag"></i></a>
                                        <!-- <a href="javascript:void(0);" id="addFile" data-toggle="tooltip" title="<?php //echo __dbt('Attach files');  ?>" data-placement="bottom"><i class="fa fa-paperclip"></i></a> -->
                                        <a href="javascript:void(0);"><i class="fa fa-paperclip"></i><input type="file" name="data[WallContent][file_id]" data-toggle="tooltip" title="<?php echo __dbt('Attach files'); ?>" data-placement="bottom"  id="addFile"/></a>
                                        <span id="uploaded-img"><?php echo __dbt('jpeg, jpg, gif, png format supported.'); ?><img id="blah" src="#" alt="<?php echo __dbt('your image'); ?>" height="50" width="50" style="display:none;"/></span>
                                    </div>
                                    <span id="newpostError"></span>  
                                <?php echo $this->Form->button(__dbt('Post'), array('type' => 'submit', 'id' => 'postBtn', 'class' => 'post-btn pull-right sticky-post hvr-sweep-to-right')); ?>    
                                </div>    
<?php echo $this->Form->end(); ?>

                            </div>

                            <script>
                                $(function () {
                                    var sampleTags = [<?php echo rtrim($tagUsers, ',') ?>];
                                    $('#tagUserPost').tagit({
                                        availableTags: sampleTags,
                                        beforeTagAdded: function (event, ui) {
                                            var result = isEmail(ui.tagLabel);
                                            if (!result) {
                                                $("#emailErrorMsg").html("<?php echo __dbt('Please enter valid Email address.'); ?>");
                                                return false;
                                            } else {
                                                $("#emailErrorMsg").html('');
                                            }
                                        }
                                    });
                                });
                            </script>
                            <?php $nextLoadPage = 0;
                            if (!empty($wallContents)) {
                                ?>  
                                <!-- Add new post box ends-->
                                <?php
                                foreach ($wallContents as $content):
                                    $nextLoadPage = $content['WallContent']['id'];
                                    ?>  
                                    <div class="post-main cmnt-sbmt-dsn" id="postId_<?php echo $nextLoadPage; ?>" style="background-color:#f4f3b3;">  
                                        <div class="user-post">
                                            <div class="post-sb-main">
                                                <div class="post-user" style="background-color:#f4f3b3;">

                                                    <div class="post-avatar">
                                                        <a href="javascript:void(0);"><?php echo $this->Wall->userImage($content['User']['id']); ?></a>
                                                    </div>
                                                    <div class="post-usr-dtl">
                                                        <div class="pull-left">
                                                            <h4><a href="javascript:void(0);"><?php echo isset($content['User']['name']) ? $content['User']['name'] : __dbt('Unknown'); ?></a></h4>
                                                            <p><?php echo __dbt('Post Date:') . date('Y-F-d', strtotime($content['WallContent']['created'])); ?></p>
                                                        </div>
                                                        <div class="pull-right">
        <?php if (AuthComponent::User('id') == $content['WallContent']['user_id']) { ?>  
                                                                <ul class="nav navbar-nav">
                                                                    <li class="dropdown "><a href="#"  data-toggle="dropdown" class="dropdown-toggle" role="button"><?php echo __dbt('Action'); ?> <b class="caret"></b></a>
                                                                        <ul role="menu" class="dropdown-menu" aria-labelledby="drop1">
                                                                            <li role="presentation"><a class="deletePostBtn" href="javascript:void(0)" id="postDiv_<?php echo $content['WallContent']['id']; ?>" role="menuitem"><?php echo __dbt('Delete'); ?></a></li>

                                                                        </ul>
                                                                    </li>
                                                                </ul>
        <?php } ?>  
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div> 
                                            <div class="post-cntnt clearfix">

                                                <div class="post-card">
                                                    <div class="card-image">
                                                        <?php
                                                        echo $this->Wall->showMedia($content['User']['id'], $contentType = $content['WallContent']['content_type'], $contentId = $nextLoadPage);
                                                        //fan or blog post  
                                                        if ($content['WallContent']['file_id'] != 0) {
                                                            echo '<p class="wll-post-content">' . __dbt($content['WallContent']['name']) . '</p>';
                                                            echo $this->Wall->showPostUpload($content['WallContent']['file_id'], $content['WallContent']['content_type']);
                                                        }
                                                        ?>
                                                    </div>                                            
                                                </div>
                                            </div>
        <?php echo $this->Wall->getTaggedUser($nextLoadPage, $content['User']['id']); ?>
                                            <div class="comment-section comment-btn clearfix">
                                                <div class="col-xs-6">
                                                    <span><img src="/img/comment.png" alt="" /></span>
                                                    <span>
                                                        <a href="javascript:void(0)"  class="comment-btn"><?php
                                                            if (!empty($content['WallComment'])) {
                                                                echo '<span id="commentCount' . $nextLoadPage . '">' . count($content['WallComment']) . '</span>' . __dbt('Comments');
                                                            } else {
                                                                echo '<span id="commentCount' . $nextLoadPage . '">0</span>' . __dbt('Comment');
                                                            }
                                                            ?></a>
                                                    </span>
                                                </div>
                                                <div class="col-xs-6 cmnt-btn-pls">
                                                    <a class="comment-btn1" href="javascript:void(0);" title="<?php echo __dbt('show comment') ?>"><i class="fa fa-plus"> </i></a> 

                                                </div>
                                            </div>
                                        </div> 
                                        <div class="comment-list clearfix hide">
                                            <ul>
        <?php
        $commentCount = 0;
        if (!empty($content['WallComment'])) {
            foreach ($content['WallComment'] as $comment):
                ?>
                                                        <li id="commentId_<?php echo $comment['id'] ?>">
                                                            <div class="clearfix">
                                                                <span class="profile_img"><a href="javascript:void(0);"><?php echo $this->Wall->userImage($comment['user_id']); ?></a></span>
                                                                <div class="main-comment">
                                                                    <div class="clearfix">
                                                                        <div class="pull-left">
                                                                            <span class="name"><a href="javascript:void(0);"><?php echo $this->Wall->showName($comment['user_id']); ?></a></span>
                                                                            <span class="comment-time"><?php echo date('Y-F-d', strtotime($comment['created'])); ?></span>
                                                                        </div>
                                                                        <div class="pull-right">
                <?php if ($comment['user_id'] == AuthComponent::User('id')) { ?>
                                                                                <a href="javascript:void(0)" title="delete comment" class="delete-comment del-hover" id="delete_<?php echo $comment['id'] ?>"><i class="fa fa-trash-o"></i></a>
                                                                                <a href="javascript:void(0)" title="edit comment" class="edit-comment edit-hover" id="edit_<?php echo $comment['id'] ?>"><i class="fa fa-pencil-square-o"></i></a>
                <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="coment-content CommentBoxShow" id="comment_<?php echo $comment['id'] ?>"><?php echo __dbt($comment['comment']); ?></div>
                                                                    <div id="commentBox_<?php echo $comment['id'] ?>" class="CommentBoxHide"></div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <?php
                                                        $commentCount++;
                                                        if ($commentCount >= 6) {
                                                            break;
                                                        }
                                                    endforeach;
                                                }
                                                ?> 
                                                <li class="add-more-comment" id="addNewComment_<?php echo $nextLoadPage ?>"></li>
                                            </ul>
                                            <div class="full-post-link">  
        <?php
        if (isset($commentCount) && $commentCount >= 6) {
            echo $this->Html->link(__dbt('View More'), array('controller' => 'walls', 'action' => 'post', base64_encode($content['WallContent']['id'])), array('title' => __dbt('View Post')));
        }
        ?>
                                            </div>    

                                                        <?php if (!in_array($content['WallContent']['user_id'], $notCommentOnPostUser)) { ?>    
                                                <div class="attach-post post-comment clearfix">
                                                    <span class="comment-user comment-div"><a href="javascript:void(0);"><?php echo $this->Wall->userImage(AuthComponent::User('id')); ?></a></span>
                                                    <div class="post-content user-comment-area">
                                                        <div class="comment-wrapper">
                                                            <?php
                                                            echo $this->Form->create('WallComment', array('id' => 'addComment_' . $content['WallContent']['id'], 'class' => 'form-horizontal', 'novalidate'));
                                                            echo $this->Form->hidden('wall_id', array('value' => $content['WallContent']['wall_id']));
                                                            echo $this->Form->hidden('content_id', array('value' => $content['WallContent']['id']));
                                                            echo $this->Form->textarea('name', array('id' => 'tagUsersEmail_' . $content['WallContent']['id'], 'placeholder' => __dbt('Comment here...'), 'class' => 'form-control postCmt'));
                                                            echo $this->Form->textarea('tagUsersEmail', array('id' => 'tagUser_' . $content['WallContent']['id'], 'class' => 'tag-emails'));
                                                            ?>
                                                            <script>
                                                                $(function () {
                                                                    var sampleTags = [<?php echo rtrim($tagUsers, ',') ?>];
                                                                    $('#tagUser_<?php echo $content['WallContent']['id'] ?>').tagit({
                                                                        availableTags: sampleTags,
                                                                        beforeTagAdded: function (event, ui) {
                                                                            var result = isEmail(ui.tagLabel);
                                                                            if (!result) {
                                                                                $("#tagError_<?php echo $content['WallContent']['id'] ?>").html("<?php echo __dbt('Please enter valid Email address.') ?>");
                                                                                return false;
                                                                            } else {
                                                                                $("#tagError_<?php echo $content['WallContent']['id'] ?>").html('');
                                                                            }
                                                                        }
                                                                    });
                                                                });


                                                            </script>

                                                            <div class="post-icons">
                                                                <span><a href="javascript:void(0);" class="tag-in-comment" id="<?php echo $content['WallContent']['id'] ?>" data-toggle="tooltip" title="<?php echo __dbt("Tag"); ?>" data-placement="bottom"><i class="fa fa-tag"></i></a></span>  

                                                            </div>  
                                                            <div class="attach-file">

                                                                <span id="postError_<?php echo $content['WallContent']['id']; ?>"></span>
            <?php echo $this->Form->button(__dbt('Comment'), array('id' => 'cmtBtn_' . $content["WallContent"]["id"], 'type' => 'button', 'title' => __dbt('Add comment'), 'class' => 'post-btn pull-right postCommentBtn')); ?>
                                                            </div>
                                                <?php echo $this->Form->end(); ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php } else { ?>
                                                <div class="attach-post post-comment clearfix">
                                                    <p class="text-center text-danger">
            <?php echo __dbt('You can not comment here. You are blocked by') . ' ' . $content['User']['name']; ?>
                                                    </p>
                                                </div>    
                                    <?php } ?>   


                                        </div> 
                                    </div>
    <?php endforeach;
}
?>
                            <div id="loadMoreComments" data-page="<?php echo!empty($nextLoadPage) ? $nextLoadPage : ''; ?>"></div>
                        </div>
                    </div>




                </div>


                <!-- Main content end -->


                <div class="col-sm-3 custom-wdth-col3"> 
                    <div class="rgt-sidebar">
                        <div class="top-banner">
                            <img src="/img/top-banner.jpg" />
                        </div>
                    </div>
                </div>	

            </div> 
        </div>  
        <!-- Inner wrap end -->
    </div>
</section>   


<!-- Middle end -->

<div id="loadmoreajaxloader" style="display:none;"><center><img src="/img/loader.gif" /></center></div>
<script>
    // load more blogs 
    $(window).scroll(function ()
    {
        if ($(window).scrollTop() == $(document).height() - $(window).height())
        {
            var loadPageFrom = $('#loadMoreComments').data('page');
            if (loadPageFrom == '')
            {
                $('#loadMoreComments').html("<span class='comment-error'><?php echo __dbt('No more posts to show.'); ?></span>");
                return false;
            }
            $('#loadmoreajaxloader').show();
            var url = "<?php echo $this->Html->url(array("controller" => "walls", "action" => "loadComments", $this->params["prefix"] => false)); ?>";
            $.ajax({
                url: url,
                method: "POST",
                data: {loadfrom: loadPageFrom},
                success: function (html)
                {

                    if (html)
                    {
                        $("#loadMoreComments").replaceWith(html);
                        $('#loadmoreajaxloader').hide();
                    } else
                    {
                        $('#loadmoreajaxloader').html("<center><?php echo __dbt('No more posts to show.'); ?></center>");
                    }
                }
            });
        }
    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }


    $(document).ready(function () {
        var openTagVidget = parseInt(0);
        $("#WallContentName").keyup(function (event) {
            if (event.keyCode == 13) {
                $("#postBtn").trigger('click');
            }
        });

        $('#postBtn').on('click', function () { //alert('wrong');
            var cmntval = $('#WallContentName').val().trim();
            //if(cmntval == '' && ($('#fileInput').val() == '')) {
            if (cmntval == '') {
                $('#WallContentName').css('border', '1px solid red');
                return false;
            }
        });

        $(document).click(function () {
            $('#WallContentName').css('border', '1px solid #ccc');
        });

        $(".postCmt").keyup(function (event) {
            if (event.keyCode == 13) {
                var id = $(this).attr('id').split("_").pop();
                var textAreaVal = $(this).attr('id');
                var cmntVal = $('#' + textAreaVal).val();
                $('#postError_' + id).html('');
                if ($(this).val().trim().length > 179) {
                    $('#postError_' + id).html("<?php echo __dbt('you can not comment more then 180 character.'); ?>");
                    return false;
                }
                if (cmntVal.trim() == '') {
                    //alert();
                    $('#postError_' + id).html("<?php echo __dbt('Please enter comment.'); ?>");
                    return false;
                }
                $("#cmtBtn_" + id).trigger('click');
            }
        });

        // display comment form for edit   
        $(document).on('click', '.edit-comment', function () {
            var id = $(this).attr('id').split("_").pop();
            $('.CommentBoxHide').html('');
            $('.coment-content').show();
            $('#comment_' + id).next().html('<?php
echo $this->Form->create('WallComment', array('class' => 'form-horizontal', 'novalidate'));
echo $this->Form->hidden('id', array('id' => 'editFormID'));
echo $this->Form->textarea('name', array('id' => 'editFormContent', 'placeholder' => __dbt('Comment here...'), 'class' => 'form-control'));
echo $this->Form->button(__dbt('Cancel'), array('type' => 'button', 'id' => 'resetBtn', 'class' => 'post-btn pull-right'));
echo $this->Form->button(__dbt('Update'), array('type' => 'button', 'id' => 'editPostBtn', 'class' => 'post-btn pull-right'));
echo $this->Form->end();
?>');
            $('#editFormID').val(id);
            $('#editFormContent').text($('#comment_' + id).html());
            $('#comment_' + id).hide();
            $('#delete_' + id).hide();
            $('#edit_' + id).hide();
        });


        // delete comment
        $(document).on('click', '.delete-comment', function () {
            if (!confirm("<?php echo __dbt('Are you sure you want to delete this comment.'); ?>")) {
                return false;
            }
            var id = $(this).attr('id').split("_").pop();

            $('.CommentBoxHide').html('');
            var commentFormId = $(this).closest('.post-main').attr('id').split("_").pop();
            $('.coment-content').show();
            var url = "<?php echo $this->Html->url(array("controller" => "walls", "action" => "deleteComment", $this->params["prefix"] => false)); ?>";
            $.post(url, {data: id}, function (data) {
                if (data == 'success') {
                    $('#commentId_' + id).remove();
                    $('#commentCount' + commentFormId).text(parseInt($('#commentCount' + commentFormId).text()) - 1);
                } else {
                    $('#status_' + id).html("<span class='comment-error'><?php echo __dbt('Error in comment deletion! Please try again.'); ?></span>");
                }

            });

        });



        // edit comment script 
        $(document).on('click', '#editPostBtn', function () {
            var formData = $('#WallCommentIndexForm').serializeArray();
            var editId = formData[1]['value'];
            var cmntVal = $('#editFormContent').val();
            if (cmntVal.trim() == '') {
                alert("<?php echo __dbt('Please enter comment.') ?>");
                return false;
            }
            var url = "<?php echo $this->Html->url(array("controller" => "walls", "action" => "editComment", $this->params["prefix"] => false)); ?>";
            $.post(url, {data: formData}, function (data) {
                $('.CommentBoxHide').html('');
                $('.coment-content').show();
                if (data != 'error')
                {
                    $('#delete_' + editId).show();
                    $('#edit_' + editId).show();
                    $('#status_' + editId).html("<span class='comment-success'><?php echo __dbt('Comment has been updated.'); ?></span>");
                    $('#comment_' + editId).html(data);
                } else {
                    $('#status_' + editId).html("<span class='comment-error'><?php echo __dbt('Error in comment updation! Please try again.'); ?></span>");
                }

            });
        });

        //disble button script
        var enableSubmit = function (ele) {
            $(ele).removeAttr("disabled");
        }

        // post new comments
        $(document).on('click', '.postCommentBtn', function () {
            //disble button for some time
            var that = this;
            $(this).attr("disabled", true);
            setTimeout(function () {
                enableSubmit(that)
            }, 1000);
            var formId = $(this).closest("form").attr('id');
            var commentFormId = $('#' + formId + ' #WallCommentContentId').val();
            var formData = $('#' + formId).serializeArray();
            var wallId = formData[1]['value'].trim();
            var commentValue = formData[3]['value'].trim();
            var cmtID = $(this).attr('id').split("_").pop();
            $('#postError_' + cmtID).html('');
            if (commentValue.length > 179) {
                $('#postError_' + cmtID).html("<?php echo __dbt('you can not comment more then 180 character.') ?>");
                return false;
            }

            if (commentValue == '') {
                $('#postError_' + cmtID).html("<?php echo __dbt('Please enter comment.') ?>");
                return false;
            }
            var cDate = new Date();
            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var date = cDate.getFullYear() + '-' + months[cDate.getMonth()] + '-' + cDate.getDate();

            var url = "<?php echo $this->Html->url(array("controller" => "walls", "action" => "comment", $this->params["prefix"] => false)); ?>";
            $.post(url, {data: formData}, function (data) {

                if (data !== 'error')
                {
                    if ($('#tagUser_' + commentFormId).val() != '') {
                        $('#' + commentFormId).trigger('click');
                        $('#tagUser_' + commentFormId).val('');
                    }
                    $('#postError_' + commentFormId).html('');
                    $('#commentCount' + commentFormId).text(parseInt($('#commentCount' + commentFormId).text()) + 1);
                    $('#tagUsersEmail_' + commentFormId).val('');

                    $('#addNewComment_' + commentFormId).replaceWith('<li id="commentId_' + data + '"><div class="clearfix"><span class="profile_img"><a href="javascript:void(0);"><?php echo $this->Wall->userImage(AuthComponent::User("id")); ?></a></span><div class="main-comment"><div class="clearfix"><span class="name"><a href="javascript:void(0);"><?php echo $this->Wall->showName(AuthComponent::User("id")); ?></a></span> <span class="comment-time pull-right">' + date + '</span> </div><div class="coment-content CommentBoxShow" id="comment_' + data + '">' + commentValue + '</div><div id="commentBox_' + data + '" class="CommentBoxHide"></div></div></div>  <div class="pull-right"> <a class="delete-comment" href="javascript:void(0);" id="delete_' + data + '"><i class="fa fa-trash-o"></i></a>&nbsp;<a href="javascript:void(0);" class="edit-comment" id="edit_' + data + '"><i class="fa fa-pencil-square-o"></i></a> </div></li><div id="addNewComment_' + commentFormId + '"></div>');
                } else {
                    $('#postError_' + commentFormId).replaceWith("<span class='comment-error'><?php echo __dbt('Error in saving comment! Please try again.'); ?></span>");
                }

            });
        });



        //cancel edit
        $(document).on('click', '#resetBtn', function () {
            var editId = $('#editFormID').val();
            $('.CommentBoxHide').html('');
            $('.coment-content').show();
            $('#delete_' + editId).show();
            $('#edit_' + editId).show();
        });

//      $(document).on('click','#addFile',function(){
//     
//        //$('#fileInput').trigger( "click" );
//          
//      });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).on('change', '#addFile', function () {
            $('#blah').show();
            readURL(this);
        });

        $(document).on('click', '#open-tag-widget', function () {
            $("#tagUserPost").val('');

            console.log($(".tagit-new").closest("li"));
            if (openTagVidget % 2 == 0) {
                $('.tagit').show();
            } else {
                $(".tagit-new").prevAll("li").hide();
                $('.tagit').hide();
            }
            openTagVidget = parseInt(openTagVidget) + parseInt(1);

            //$('.tagit').toggle();
//         if ( $('.tagit').css('display') == 'none' ){
//            $('.tagit').hide();
//            $(".tagUserPost").val('');
//            console.log($('.tagit').val());
//         }else{
//            $('.tagit').show();
//            
//         }
        });

        //open tag box in comment section
        $(document).on('click', '.tag-in-comment', function () {
            var commentId = $(this).attr('id');
            //alert('#addComment_'+commentId+' .tagit');
            $('#addComment_' + commentId + ' .tagit').toggle();

        });

        // delete my post
        $(document).on('click', '.deletePostBtn', function () {
            if (!confirm("<?php echo __dbt('Are you sure you want to delete this post.') ?>")) {
                return false;
            }

            var id = $(this).attr('id').split("_").pop();
            var url = "<?php echo $this->Html->url(array("controller" => "walls", "action" => "deletePost", $this->params["prefix"] => false)); ?>";
            $.post(url, {data: id}, function (data) {
                if (data == 'success') {
                    $('#postId_' + id).remove();
                }
            });

        });

        $(document).on('click', '#toggle-troll-widget', function () {
            $('#troll-Box').toggle();

            if ($('#troll-Box').css('display') == 'none') {
                $('#troll-Box').hide();
                $("#troll-Box option[value='']").prop('selected', true);
            } else {
                $('#troll-Box').show();

            }
        });

    });




//tootip
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $(document).on('click', '.comment-btn', function () {
            $(this).toggleClass("plusimg");
            $(this).closest('.post-main').find('.comment-list').toggleClass('hide');
        });
    });
    /* When the user clicks on the button, 
     toggle between hiding and showing the dropdown content */
</script>
<style>
    .sticky-notes .wall-pst-hd {
        background-color: #f4f3b3;
        border: medium none;
        color: #000000;
    }
    .sticky-notes .wall-pst-hd h4 {
        color: #000000;
        display: inline-block;
        font-size: 18px;
        font-weight: 600;
    }
    .sticky-notes .wall-pst-hd h4 img {
        margin-right: 4px;
        width: 20px;
    }
    .sticky-notes textarea {
        background-color: #fcfaaf;
        border: medium none !important;
        border-radius: 0;
        box-shadow: none;
        color: #000000;
        min-height: 145px;
    }
    .sticky-notes .status-post.clearfix.pst-dft-dsgn {
        background-color: #fcfaaf;
    }
    .sticky-notes .sticky-post {
        background: #be0d0d none repeat scroll 0 0;
        padding: 10px 25px;
    }
    .sticky-notes .status-post .post-border a {
        display: inline-block;
        float: left;
        height: 46px;
        margin: 0;
        overflow: hidden;
        padding: 14px 6px 16px;
        position: relative;
        width: 34px;
    }
</style>
