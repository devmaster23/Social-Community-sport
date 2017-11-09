<div class="main-wrap">
   <div class="container">
        <div class="page-title"><h2>Cricket</h2></div>
        <!--Event Nav start -->
        <nav class="navbar navbar-default nav-ovryd">
            <div class="container-fluid">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <h4>Select Events:</h4>
              </div>
              <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                  <li class="active"><a href="#">Ipl t20</a></li>
                  <li><a href="#">Odi series</a></li>
                  <li><a href="#">Test match</a></li>
                  <li><a href="#">Domestics </a></li>
                  <li><a href="#">International</a></li>
                  <li><a href="#">Domestics</a></li>
                </ul>
              </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
      </nav>
      <!--Event Nav end --> 
      <div class="event-title">
            <h4><?php echo __dbt('Event Title');?></h4>
      </div>  
      <!-- Inner wrap start -->
      <div class="inner-wrap">
            <div class="row">
          <!-- Sidebar start -->
          <div class="col-sm-2">

          <?php echo $this->element($elementFolder.'/sidebar'); ?>
          </div>

          <!-- Sidebar end -->
          <!-- Main content start -->
          <div class="col-sm-10">
          <div class="main-content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="post-title">
                            <h4><?php echo __dbt('Most Recent'); ?></h4>
                        </div>
                    </div> 
                </div>

                <div class="post-main">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="post-cntnt clearfix">
                                <div class="comment-list">
                                    <ul>
                                        <?php if(!empty($wallContent)) { foreach($wallContent as $content): ?>
                                        <li>
                                            
                                            <div class="clearfix">
                                                <span class="profile_img">
                                                    <?php if($content['WallContent']['content_type'] == 'video') { 
                                                        parse_str( parse_url( $content['WallContent']['content'], PHP_URL_QUERY ), $video_id );
                                                        $url ='http://www.youtube.com/embed/'.$video_id['v'];
                                                    ?>
                                                    <iframe id="preview_frame" width="120" height="120" src="<?php echo $url ?>" frameborder="0"></iframe>
                                                    <?php } else if($content['WallContent']['content_type'] == 'image') {
                                                        echo $this->Html->image('/img/sample-img1.jpg', array('alt' =>__dbt('sample image')));
                                                    }?>
                                                </span>
                                                <div class="main-comment">
                                                    <div class="clearfix">
                                                        <span class="name"><?php echo __dbt($content['WallContent']['title']); ?></span>
                                                        <span class="comment-time pull-right"></span>
                                                    </div>
                                                    <div class="coment-content"><?php echo __dbt('Post:'). __dbt($content['WallContent']['created']); ?> </div>
                                                </div>
                                            </div>
                                            <div class="pull-right">
                                                <div class="text-right del-edit">
                                                        
                                                </div>
                                            </div>
                                        </li>
                                        <?php  endforeach; } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    
            </div>
            </div>
          <!-- Main content end -->
         
      </div> 
      </div>  
      <!-- Inner wrap end -->
   </div>
</div>   


<!-- Middle end -->
