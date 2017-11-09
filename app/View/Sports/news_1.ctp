<?php echo $this->Html->css(array("front/base-min", "front/brawler")); ?>
<?php echo $this->Html->script(array('front/jquery.bxslider.min')); ?> 
<div class="main-wrap">
    <div class="container news-logo">
    
        <div class="logo-ct">
            <a  href="<?php echo HTTP_ROOT; ?>"><img class="img-responsive" src="/img/blk-sports-logo.png" alt="Sports" /></a>
        </div>      
        <div class="event-title"><h4><?php echo __dbt('News'); ?></h4> </div>
        <div class="row news-page">
            <!--  Top trending News  --> 
            <!-- ADD WORD -->

            <div class="col-xs-12 space-bottom-40 text-center">
        
                <div class="add-word-box"><a href="javascript:void(0);"><img src="/img/add-word.jpg" alt="add-word" /></a></div>
            </div>

            <!-- ADD WORD END -->
            <div class="col-xs-3">
                <div class="news-sticker-wrp">
            <div class="box box-solid news-tricker">
            <div class="box-header with-border">
                <h3 class="box-title" style="color: #000"><?php echo __dbt('Top Trending News'); ?></h3>
            </div>    
            <div id="newsTrend">
                <?php foreach ($newsTrends as $trend): ?>
                <div  class="slide">
                    <?php
                    $newsname=$this->Text->truncate(__dbtnews($trend['News']['id']), 70, array('ellipsis' => '...', 'exact' => false));
                    echo $this->Html->link(__dbt($newsname), array('controller' => 'Sports', 'action' => 'news', base64_encode($trend['News']['id']), 'full_base' => true));
                    ?>
    
                   <p><?php 
                    //echo __dbtnews($trend['News']['id']);
                     //echo $this->Text->truncate(__dbtnews($trend['News']['id']), 90, array('ellipsis' => '...', 'exact' => false)); ?>
                    </p>
                </div>     
    
    
                <?php endforeach; ?>
            </div>
            </div>
        </div>
            </div> <!--  Top trending News  --> 
            
            <div class="col-xs-9 static-page-formate">
                <div class="white-box-frame clearfix">
                    <div class="static-header">
                        <!-- commented for next phase >-->
                            <span class='st_sharethis_large' displayText='ShareThis'></span> 
                        
                        <p class="text-right text-info"><!--?php
                            if ($news['News']['most_read'] <= 1)
                                echo $news['News']['most_read'] .' '. __dbt('user visited this topic.');
                            else
                                echo $news['News']['most_read'] .' '. __dbt('users visited this topic.');
                            
                                ?-->
<!--                            <a href="/news/abusenews/<?php //echo base64_encode($news['News']['id']); ?>"><i style="cursor:pointer; float: left; margin: 20px;" title="<?php //echo __dbt('Abuse News');?>" id="abuse" data-news_id="<?php //echo $news['News']['id']; ?>" class="thumb-down" aria-hidden="true"></i></a>-->
                            <a href="/news/abusenews/<?php echo base64_encode($news['News']['id']); ?>"><img src='../../img/thumb-down.jpeg' style="cursor:pointer; float: left;" height="35px" width="35px" title="<?php echo __dbt('Unlike News');?>" id="abuse" data-news_id="<?php echo $news['News']['id']; ?>" class="thumb-down" aria-hidden="true"></a>
                                   
                        </p>
                    </div>
                     <?php $dummycontent=$news['NewsTemplate']['description'];
                        $image1content=str_replace("{IMAGE1}",$news['File']['path'],$dummycontent);

                        $imagedescriptioncontent= str_replace("{DESCRIPTION}",$news['News']['description'],$image1content);

                       //echo str_replace("{DESCRIPTION}",$news['News']['description'],$image1content);
                        if(!empty($news['SecondFile']['path']))
                        {
                         echo str_replace("{IMAGE2}",$news['SecondFile']['path'],$imagedescriptioncontent);
                        }
                        else
                        {
                        echo str_replace("{DESCRIPTION}",$news['News']['description'],$image1content);
                        }

                    ?>
                </div>
                
                <!-- COMMENT SECTION -->
                <div class="status-post clearfix pst-dft-dsgn">
                    <div class="wall-pst-hd"><h3><?php echo __dbt("Comments");?> </h3></div>
                    <ul class="comment-list clearfix">
                        <?php if (!empty($newsCom)) {
                            $i = 0;
                            ?>
                            
                            <?php
                            foreach ($newsCom as $key => $value) {
                                
                                $bgColor = "#cccccc";
                                if ($i % 2 == 0) {
                                    $bgColor = "#fff";
                                }
                                ?>
                                <li>
                                    <div class="col-xs-8 col-md-10"> 
                                        <span class="msg-small"><?php echo strip_tags(substr($value['NewsComment']['content'], 0, 500)); ?></span>
                                        &nbsp;<span class="small"><?php// echo  $value['User']['email']; ?></span>
                                    </div>
                                    <div class="col-xs-4 col-md-2 text-center"> <?php
                                        if (!empty($value['User']['File'])) {
                                            //echo $this->Html->Image($value['User']['File']['path'], array('class'=>'img-circle','escape' => false, 'width' => 50, 'height' => 50, 'title' => $value['User']['name']));
                                        } else {
                                            echo $this->Html->Image('/img/default_profile.png', array('class'=>'img-circle','escape' => false, 'width' => 50, 'height' => 50, 'title' => 'Users image'//$value['User']['name']));
                                                ));
                                        }
                                        echo '<br /><span class="smallTime">';
                    $ptime = strtotime($value['NewsComment']['created']);
                    $timeTaken = $this->requestAction(array('controller' => 'news', 'action' => 'time_elapsed_string', $ptime));
                                        echo $timeTaken."</span>";
                                        ?>
                                    </div>
                                </li>
                            <?php $i++;
                            }
                        ?>    
                        <?php }else{ 
                        $forthisuser = '';
                        if(isset($uId)){
                            //$forthisuser = " by you";
                        }
                        echo '<li>'.__dbt("There is no comment on this news").'</li>';} ?>
                    </ul>
                </div>
                <!-- COMMENT SCTION END -->
                
                <!-- ELSE COMMENT SECTION -->
                <?php if(isset($uId)){?>
                    <div class="status-post clearfix pst-dft-dsgn">
                        <div class="wall-pst-hd"><h4><?php echo __dbt('Add Comment'); ?></h4></div>
                        <?php
                            echo $this->Form->Create('News', array('controller' => 'news', 'action' => 'addComment', 'inputDefaults' => array('required' => false)));
                            //$this->Form->inputDefaults(array( 'required' => false));
                            echo $this->Form->input('NewsComment.news_id', array('type' => 'hidden', 'value' => (isset($news['News']['id']) ? base64_encode($news['News']['id']) : '')));
                        ?>
                        <div class="attach-post clearfix">
                            <div class="post-content">
                                <?php echo $this->Form->textarea('NewsComment.content', array('id' => 'editorworng', 'class' => 'form-control ', 'placeholder' => __dbt('Post Comment'), 'label' => false, 'autocomplete' => "off")); ?>
                                <span id="emptyError" ></span>
                            </div>
                            <?php echo $this->Form->submit(__dbt('Add'), array('div' => false, 'class' => 'post-btn pull-right', 'title' => __dbt('Add Comment'), 'id' => 'postBtnt')); ?>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                <?php }?>
                <!-- ELSE COMMENT SECTION END -->
            </div>
        </div>
        
        
    </div>
</div>
<!-- commented for next phase >-->
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>


<style>
    .small{font-size: 13px; color:#ccc;float: right; vertical-align: bottom; margin-right: 35px;}
    .smallTime{font-size: 12px; color:#ccc;float: left; vertical-align: bottom; margin-right: 35px;}
    .comment-list.clearfix{border-top: none;}
    .comment-list.clearfix > li:last-child{border: none;}
    .img-circle{border-radius: 50%; height: 50px;}
    .col-lg-10{padding-right: 0; padding-left: 0;}
    .pushmenu-push{margin: 0;}
    .thumb-down{background: url('../img/thumb-down.jpeg');}
    #img_one{width:100%;height:auto;}
     #img_two{width:100%;height:auto;}
</style>

<script>
    $(document).ready(function() {
        $('#newsTrend').bxSlider({
            mode: 'vertical',
            slideWidth: 300,
            minSlides: 4,
            slideMargin: 10,
            auto: true,
            pager: false,
            controls: false,
            moveSlides: 1, // no of slide move at a time 

        });
        
//        $(document).on('click','#abuse',function(){
//            var news_id = $(this).data('news_id');
//            $.ajax({
//                url:"/news/abusenews/",
//                data:{news_id:news_id},
//                type:"post",
//                success:function(result){
//                    console.log(result);
//                    location.reload();
//                }
//            });
//        });
    });
</script>