<!--SECTION: HEADER AND BANNER-->
    <section>
        <div class="home">
            <div class="h_l">
                <!-- BRAND LOGO AND EVENT NAMES -->
                <img src="images/logo.png" alt="" />
                <h2>Current Match Events</h2>
                <p>Lorem ipsum dolor sit amet, cons ecte tuer adipiscing elit, sed diam non ummy nibh euismod tinc idunt ut laoreet dolore magna ali quam erat volutpat.</p>
                <ul>
                    <li><a href="soccer.html"><span>1</span>Soccer Training For Beginners</a>
                    </li>
                    <li><a href="cycling.html"><span>2</span>Cycling & Bike Racing</a>
                    </li>
                    <li><a href="swimming.html"><span>3</span>Swimming Competition, 2017</a>
                    </li>
                    <li><a href="athletics.html"><span>4</span>Athletics open competitions,USA</a>
                    </li>
                    <li><a href="boxing.html"><span>5</span>Boxing League - Register Now!</a>
                    </li>
                </ul>
                <a href="all-sports.html" class="aebtn">View All Events</a>
            </div>
            <div class="h_r">
                <!-- SLIDER -->
                <div class="slideshow-container">
                    <!-- FIRST SLIDER -->
                    <div class="mySlides fade">
                        <div class="numbertext">1 / 8</div>
                        <a href="#"><img src="images/banner/b3.jpg" alt="">
                        </a>
                        <!--<div class="text">Caption Text</div>-->
                    </div>
                    <!-- SECOND SLIDER -->
                    <div class="mySlides fade">
                        <div class="numbertext">2 / 8</div>
                        <a href="#"><img src="images/banner/b2.jpg" alt="">
                        </a>
                        <!--<div class="text">Caption Text</div>-->
                    </div>
                    <!-- THIRD SLIDER -->
                    <div class="mySlides fade">
                        <div class="numbertext">3 / 8</div>
                        <a href="#"><img src="images/banner/b1.jpg" alt="">
                        </a>
                        <!--<div class="text">Caption Text</div>-->
                    </div>
                    <!-- FOURTH SLIDER -->
                    <div class="mySlides fade">
                        <div class="numbertext">4 / 8</div>
                        <a href="#"><img src="images/banner/b4.jpg" alt="">
                        </a>
                        <!--<div class="text">Caption Text</div>-->
                    </div>
                    <!-- FOURTH SLIDER -->
                    <div class="mySlides fade">
                        <div class="numbertext">5 / 8</div>
                        <a href="#"><img src="images/banner/b5.jpg" alt="">
                        </a>
                        <!--<div class="text">Caption Text</div>-->
                    </div>
                    <div class="mySlides fade">
                        <div class="numbertext">6 / 8</div>
                        <a href="#"><img src="images/banner/b6.jpg" alt="">
                        </a>
                        <!--<div class="text">Caption Text</div>-->
                    </div>
           
            
                    <!-- YOU CAN ADD MULTIPLE SLIDERS NOW-->
                    <!-- SLIDER NAVIGATION -->
                    <a class="prev" onclick="plusSlides(-1)">❮</a>
                    <a class="next" onclick="plusSlides(1)">❯</a>
                </div>
            </div>
        </div>
    </section>
 <!-- SEARCH BOX -->
    <section>
        <div class="hom-search lp">
            <div class="row">
                <div class="hom-search-inn">
                    <form>
                        <ul>
                            <li>
                                <input type="text" placeholder="Search Sports Events Now!">
                            </li>
                            <li>
                                <input type="submit" value="SEARCH">
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </section>

<!-- FLEX SLIDER -->
<div id="mainSlider" class="flexslider">
    <ul class="slides">
       <?php if(!empty($slider)){ foreach($slider as $slide):?>
        <li>
            <div class="slider-container">
                <img src="<?php echo BASE_URL.'img/BannerImages/large/'.$slide['File']['new_name'] ; ?>" alt="<?php echo $slide['File']['name'] ; ?>" />
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
            </div>
        </li>
       <?php endforeach; } ?>
    </ul>
</div>
<!-- /FLEX SLIDER -->

<!-- FLIPPER BOX -->
<div class="flipper-section background parallax" data-img-width="1600" data-img-height="1212" data-diff="75" style="background-image:url(img/flipper-bg.jpg); background-attachment:fixed;">
    <div class="container">
        <!-- ADD WORD -->
        <div id="sportTile" class="row">
            <div class="col-xs-12 space-bottom-40 text-center">
                    <div class="add-word-box"><a href="javascript:void(0);"><img src="/img/add-word.jpg" alt="add-word" /></a></div>
            </div>
        </div>
       
         <!-- FLIPPER BOXES START -->
        <div  class="row section__content flipper">
            <?php 
            if($search){ // if search is set then show serch result
                $countSearch = 0;
                foreach($news as $newsearch):
                    if(!empty($newsearch)) {
                    $countSearch++;
            ?>      <div class="col-xs-4 space-bottom-40">
                        <div class="card">
                            <div class="card__front">
                                <div class="card__text">
                                    <img src="<?php if(isset($newsearch['File']['new_name']) && $newsearch['File']['new_name']!='')  echo BASE_URL.'img/NewsImages/large/'.$newsearch['File']['new_name']; else echo ''; ?>"  alt="<?php if(isset($newsearch['File']['name'])) echo __dbt($newsearch['File']['name']); ?>">
                                    <p class="text-bottom minHt"><?php if(isset($newsearch['News']['description']) && $newsearch['News']['description']!='') { 
                                        $newsCardDescriptionL50 = $this->Common->wordTruncate(strip_tags(__dbtnews($newsearch['News']['id'])),25);
                                echo $newsCardDescriptionL50;
                                        //echo __dbtnews(mb_substr($newsearch['News']['description'], 0, 30, 'UTF-8'));
                                          }  ?> <?php if(isset($newsearch['News']['id'])) echo $this->Html->link(__dbt('more...'), array('controller'=>'Sports','action' => 'news', base64_encode($newsearch['News']['id'])), array('title'=>__dbt('View News'),'div'=>false));  ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                   <?php } 
                endforeach; 
                if(!$countSearch){ ?>
                    <div class="alert alert-success alert-dismissable">
                    <h4><i class="icon fa fa-check"></i> <?php echo __dbt('Alert!');?></h4>
                    <?php echo __dbt('No Result Found');?>
                  </div>
            <?php    }
            } else {  // condition for withput search
            $countNews = 0;
              foreach($news as $newscard):
              if(!empty($newscard)) { 
                 $countNews++;
            ?>
            <div class="col-xs-4 space-bottom-40">
                <div class="card effect__click">
                    <div class="card__front">
                        <div class="card__text">
                            <img src="<?php if(isset($newscard[0]['File']['new_name']) && $newscard[0]['File']['new_name']!='')  echo BASE_URL.'img/NewsImages/large/'.$newscard[0]['File']['new_name']; else echo ''; ?>"  alt="<?php if(isset($newscard[0]['File']['name'])) echo __dbt($newscard[0]['File']['name']); ?>">
                            <p class="text-bottom "><?php if(isset($newscard[0]['News']['description']) && $newscard[0]['News']['description']!='') { 
                                $newsCardDescriptionL78 = $this->Common->wordTruncate(strip_tags(__dbtnews($newscard[0]['News']['id'])),25);
                                echo $newsCardDescriptionL78;
                                //echo __dbtnewsnews(mb_substr($newscard[0]['News']['description'], 0, 30, 'UTF-8'));  
                                
                            }  
                            ?>
                            <?php if(isset($newscard[0]['News']['external_url']) && $newscard[0]['News']['external_url'] !=''){ 
                                     echo $this->Html->link(__dbt('more...'), $newscard[0]['News']['external_url'], array('target'=>'_blank','title'=>__dbt('View News'),'div'=>false)); 
                                 }else{
                                     if(isset($newscard[0]['News']['id'])) echo $this->Html->link(__dbt('more...'), array('controller'=>'Sports','action' => 'news', base64_encode($newscard[0]['News']['id'])), array('title'=>__dbt('View News'),'div'=>false)); 
                                 } ?>
                            </p> 
                        </div>
                    </div>
                    <?php if(!isset($newscard[1]['File']['new_name'])) { ?> 
                    <div class="card__back">
                        <div class="card__text">
                            <img src="<?php if(isset($newscard[0]['File']['new_name']) && $newscard[0]['File']['new_name'] != '' ) echo BASE_URL.'img/NewsImages/large/'.$newscard[0]['File']['new_name']; else echo ''; ?>" alt="<?php  if(isset($newscard[0 ]['File']['name'])) echo $newscard[0]['File']['name']; ?>"/>
                            <p class="text-bottom "> <?php  if(isset($newscard[0]['News']['description']) && $newscard[0]['News']['description'] != '' ) {
                                $newsCardDescriptionL83 = $this->Common->wordTruncate(strip_tags(__dbtnews($newscard[0]['News']['id'])),25);
                                echo $newsCardDescriptionL83;
                            }?>
                            <?php if(isset($newscard[0]['News']['external_url']) && $newscard[0]['News']['external_url'] !='' ){ 
                                     echo $this->Html->link(__dbt('more...'), $newscard[0]['News']['external_url'], array('target'=>'_blank','title'=>__dbt('View News'),'div'=>false)); 
                                 }else{
                                     if(isset($newscard[0]['News']['id'])) echo $this->Html->link(__dbt('more...'), array('controller'=>'Sports','action' => 'news', base64_encode($newscard[0]['News']['id'])), array('title'=>__dbt('View News'),'div'=>false)); 
                                 } ?>
                            </p>
                        </div>
                    </div>
                    <?php } else { ?>    
                    <div class="card__back">
                        <div class="card__text">
                            <img src="<?php if(isset($newscard[1]['File']['new_name']) && $newscard[1]['File']['new_name'] != '' ) echo BASE_URL.'img/NewsImages/large/'.$newscard[1]['File']['new_name']; else echo ''; ?>" alt="<?php  if(isset($newscard[1]['File']['name'])) echo __dbt($newscard[1]['File']['name']); ?>"/>
                            <p class="text-bottom "> <?php if(isset($newscard[1]['News']['description']) && $newscard[1]['News']['description'] != '' ){ 
                                $newsCardDescriptionL92 = $this->Common->wordTruncate(strip_tags(__dbtnews($newscard[1]['News']['id'])),25);
                                echo $newsCardDescriptionL92;
                                //echo __dbtnews(mb_substr($newscard[1]['News']['description'], 0, 30, 'UTF-8'));
                            }?> 
                            <?php if(isset($newscard[1]['News']['external_url']) && $newscard[1]['News']['external_url'] !=''){ 
                                     echo $this->Html->link(__dbt('more...'), $newscard[1]['News']['external_url'], array('target'=>'_blank','title'=>__dbt('View News'),'div'=>false)); 
                                 }else{
                                     if(isset($newscard[1]['News']['id'])) echo $this->Html->link(__dbt('more...'), array('controller'=>'Sports','action' => 'news', base64_encode($newscard[1]['News']['id'])), array('title'=>__dbt('View News'),'div'=>false)); 
                                 } ?>
                            </p>
                        </div>
                    </div>
                    <?php } ?>    
                </div>
            </div>
             <?php } 
                endforeach;   ?>   

        <?php 
        if($countNews) {
         for($count = $countNews; $count <= (6-$countNews); $count--) {
             if($countNews > 5) break;
              foreach($news as $newscard[$count]):
              if(!empty($newscard[$count])) { 
                         $countNews++;                      
            ?>
            <div class="col-xs-4 space-bottom-40">
                <div class="card effect__click">
                    <div class="card__front">
                        <div class="card__text">
                            <img src="<?php if(isset($newscard[$count][0]['File']['new_name']) && $newscard[$count][0]['File']['new_name']!='')  echo BASE_URL.'img/NewsImages/large/'.$newscard[$count][0]['File']['new_name']; else echo ''; ?>"  alt="<?php if(isset($newscard[$count][0]['File']['name'])) echo __dbt($newscard[$count][0]['File']['name']); ?>">
                            <p class="text-bottom "><?php if(isset($newscard[$count][0]['News']['description']) && $newscard[$count][0]['News']['description']!='') {  
                                $newsCardDescriptionL119 = $this->Common->wordTruncate(strip_tags(__dbtnews($newscard[$count][0]['News']['id'])),25);
                                echo $newsCardDescriptionL119;
                                //echo __dbtnews(mb_substr($newscard[$count][0]['News']['description'], 0, 30, 'UTF-8'));  
                                }  ?> 
                                <?php if(isset($newscard[$count][0]['News']['external_url']) && $newscard[$count][0]['News']['external_url'] !=''){ 
                                        echo $this->Html->link(__dbt('more...'), $newscard[$count][0]['News']['external_url'], array('target'=>'_blank','title'=>__dbt('View News'),'div'=>false)); 
                                    }else{
                                        if(isset($newscard[$count][0]['News']['id'])) echo $this->Html->link(__dbt('more...'), array('controller'=>'Sports','action' => 'news', base64_encode($newscard[$count][0]['News']['id'])), array('title'=>__dbt('View News'),'div'=>false));
                                    } ?>
                            </p>
                        </div>
                    </div>
                    <?php if(!isset($newscard[$count][1]['File']['new_name'])) { ?> 
                    <div class="card__back">
                        <div class="card__text">
                            <img src="<?php if(isset($newscard[$count][0]['File']['new_name']) && $newscard[$count][0]['File']['new_name'] != '' ) echo BASE_URL.'img/NewsImages/large/'.$newscard[$count][0]['File']['new_name']; else echo ''; ?>" alt="<?php  if(isset($newscard[$count][0 ]['File']['name'])) echo __dbt($newscard[$count][0]['File']['name']); ?>"/>
                            <p class="text-bottom "> <?php if(isset($newscard[$count][0]['News']['description']) && $newscard[$count][0]['News']['description'] != '' ) {
                                 $newsCardDescriptionL130 = $this->Common->wordTruncate(strip_tags(__dbtnews($newscard[$count][0]['News']['id'])),25);
                                echo $newsCardDescriptionL130;
                                //echo __dbtnews(mb_substr($newscard[$count][0]['News']['description'], 0, 30, 'UTF-8')); 
                            }?>
                            <?php if(isset($newscard[$count][0]['News']['external_url']) && $newscard[$count][0]['News']['external_url'] !=''){ 
                                        echo $this->Html->link(__dbt('more...'), $newscard[$count][0]['News']['external_url'], array('target'=>'_blank','title'=>__dbt('View News'),'div'=>false)); 
                                    }else{
                                        if(isset($newscard[$count][0]['News']['id'])) echo $this->Html->link(__dbt('more...'), array('controller'=>'Sports','action' => 'news', base64_encode($newscard[$count][0]['News']['id'])), array('title'=>__dbt('View News'),'div'=>false)); 
                                    } ?>
                            </p>
                        </div>
                    </div>
                    <?php } else { ?>    
                    <div class="card__back">
                        <div class="card__text">
                            <img src="<?php if(isset($newscard[1]['File']['new_name']) && $newscard[1]['File']['new_name'] != '' ) echo BASE_URL.'img/NewsImages/large/'.$newscard[1]['File']['new_name']; else echo ''; ?>" alt="<?php  if(isset($newscard[1]['File']['name'])) echo __dbt($newscard[1]['File']['name']); ?>"/>
                            <p class="text-bottom "> <?php if(isset($newscard[1]['News']['description']) && $newscard[1]['News']['description'] != '' ) { 
                                $newsCardDescriptionL140 = $this->Common->wordTruncate(strip_tags(__dbtnews($newscard[1]['News']['id'])),25);
                                echo $newsCardDescriptionL140;
                                //echo __dbtnews(mb_substr($newscard[1]['News']['description'], 0, 30, 'UTF-8'));
                            
                            }?> 
                            <?php if(isset($newscard[$count][0]['News']['external_url']) && $newscard[$count][0]['News']['external_url'] !=''){ 
                                        echo $this->Html->link(__dbt('more...'), $newscard[$count][0]['News']['external_url'], array('target'=>'_blank','title'=>__dbt('View News'),'div'=>false)); 
                                    }else{
                                        if(isset($newscard[$count][0]['News']['id'])) echo $this->Html->link(__dbt('more...'), array('controller'=>'Sports','action' => 'news', base64_encode($newscard[$count][0]['News']['id'])), array('title'=>__dbt('View News'),'div'=>false)); 
                                    } ?>
                            </p>
                        </div>
                    </div>
                    <?php } ?>    
                </div>
            </div>
             <?php } 
                    endforeach; 
                } // for loop for result end
              } // counter loop for repeate result end
            } // if search end  ?> 
        </div>
        <!-- FLIPPER BOXES END -->
    </div>
</div>
<!-- FLIPPER BOX END -->