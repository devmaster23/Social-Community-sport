<!-- FLEX SLIDER -->
<div id="mainSlider" class="flexslider">
    <ul class="slides">
       <?php if(!empty($slider)){ foreach($slider as $slide):?>
        <li>
            <img src="<?php echo BASE_URL.'img/BannerImages/large/'.$slide['File']['new_name'] ; ?>" alt="<?php echo __dbt($slide['File']['new_name']); ?>" />
            <div class="flex-caption">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2><?php 
                                $sliderLink = __dbt(trim($slide['Slider']['title']));
                                echo $this->Html->link($sliderLink,array('controller'=>'StaticPages','action'=>'view',base64_encode($slide['Slider']['id']))); ?></h2>
                                <p><?php if(!empty($slide['Slider']['content'])) echo __dbt(trim($slide['Slider']['content'])); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </li>
       <?php endforeach; } ?>
    </ul>
</div>
            <!-- /FLEX SLIDER -->
<div class="flipper-section background parallax" data-img-width="1600" data-img-height="1212" data-diff="75" style="background-image:url(img/flipper-bg.jpg); background-attachment:fixed;">
    <div class="container">
        <!-- ADD WORD -->
        <div class="row">
            <div class="col-xs-12 space-bottom-40 text-center">
                    <div class="add-word-box"><a href="javascript:void(0);"><img src="/img/add-word.jpg" alt="add-word" /></a></div>
            </div>
        </div>
        
        <!--div class="row"-->
            <!--?php foreach($topLeagues as $league) :?-->
            <!--div class="col-md-4"-->
                  <!-- Info Boxes Style 2 -->
                  <!--div class="info-box bg-yellow"-->
                    <!--span class="info-box-icon"><!--i class="fa fa-trophy"></i--></span-->
                    <!--div class="info-box-content">
                      <span class="info-box-text"><?php echo __dbt($league['League']['name']);?></span>
                      <span class="info-box-number"><?php  if($league[0]['userCount'] == 1) echo $league[0]['userCount'] . __dbt('User'); else echo $league[0]['userCount'] . __dbt('Users'); ?></span>
                    </div-->
                  <!--/div--><!-- /.info-box -->
            <!--/div-->
            <!--?php endforeach; ?-->
        <!--/div-->   
         <!-- FLIPPER BOXES START -->
        <div class="row section__content flipper">
            <?php  
            
                if($search){ if(!empty($news)) { 
                    $searchCount = 0; foreach($news as $newsearch):  $searchCount++;?>
                    <div class="col-xs-4 space-bottom-40">
                        	<div class="card effect__click">
                                <div class="card__front">
                                    <div class="card__text">
                                    	<img src="<?php if(isset($newsearch['File']['new_name']) && $newsearch['File']['new_name']!='')  echo BASE_URL.'img/NewsImages/large/'.$newsearch['File']['new_name']; else echo ''; ?>"  alt="<?php if(isset($newsearch['File']['name'])) echo __dbt($newsearch['File']['name']); ?>">
                                        <p class="text-bottom minHt"><?php if(isset($newsearch['News']['description']) && $newsearch['News']['description']!='') { 
                                            $newsCardDescriptionL50 = $this->Common->wordTruncate(strip_tags(__dbtnews($newsearch['News']['id'])),25);
                                            echo $newsCardDescriptionL50;  
                                        }  ?> <?php if(isset($newsearch['News']['id'])) echo $this->Html->link(__dbt('more...'), array('controller'=>'Sports','action' => 'news', base64_encode($newsearch['News']['id'])), array('title'=>__dbt('View News'),'div'=>false));  ?> </p>
                                    </div>
                                </div>
                                   
                            </div>
                        </div>
                <?php endforeach;
                } else {?>
                     <div class="alert alert-success alert-dismissable">
                            <h4><i class="icon fa fa-check"></i> <?php echo __dbt('Alert!');?></h4>
                            <?php echo __dbt('No Result Found');?>
                        </div>
                <?php }  
                
                } else { ?>
                    	<div class="col-xs-4 space-bottom-40">
                            <div class="card effect__click">
                        <?php
				$intSr = 0;
			    foreach($news as $news):
			 $strDivClass = ($intSr % 2 == 0) ? 'card__front' : 'card__back'; 
				if ($intSr % 2 == 0 && $intSr != 0) {?>
				</div>
				</div>
				<div class="col-xs-4 space-bottom-40">
				<div class="card">
			    <?php } ?>
				<div class="<?php echo $strDivClass; ?>">
                                    <div class="card__text">
                                    	<img src="<?php if($news['File']['new_name']!='')  echo BASE_URL.'img/NewsImages/large/'. __dbt($news['File']['new_name']); else echo ''; ?>"  alt="<?php echo __dbt($news['File']['name']); ?>">
                                        <p class="text-bottom minHt"><?php echo substr(__dbt($news['News']['description']),0,130); ?> <?php echo $this->Html->link(__dbt('more...'), array('action' => 'news', base64_encode( $news['News']['id'])), array('title'=>__dbt('View News'),'div'=>false)); ?> </p>
                                    </div>
                                </div>
			<?php
				$intSr++;
			    endforeach;
			?>
                            </div>
                        </div>
                    <?php } 
             ?>  
        </div> 

        <!-- FLIPPER BOXES END -->

    </div>
</div>
            <!-- FLIPPER BOX END -->
<?php if(!$this->Session->check("Auth.Editor") &&  !$this->Session->check("Auth.Blogger") && !$this->Session->check("Auth.User")) { ?>
<script>
    $(document).ready(function () {
	    $('#sign-up').modal('show');
    });
</script>
<?php } ?>