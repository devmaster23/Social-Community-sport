    <!--SECTION: HEADER AND BANNER-->
    <section>
        <div class="home">
            <div class="h_r">
                <!-- SLIDER -->
                <div class="slideshow-container">
                      <?php if(!empty($slider)){ foreach($slider as $slide):?>
                    
                         <div class="mySlides">
                  
                       <img src="<?php echo BASE_URL.'img/BannerImages/large/'.$slide['File']['new_name'] ; ?>" alt="<?php echo $slide['File']['name'] ; ?>">
                       
                   
                            <div class="text">
                                <h2><?php 
                                $sliderLink = __dbt(trim($slide['Slider']['title']));
                                echo $this->Html->link($sliderLink,array('controller'=>'StaticPages','action'=>'view',base64_encode($slide['Slider']['id']))); ?></h2>
                                <p><?php if(!empty($slide['Slider']['content'])) echo __dbt(trim($slide['Slider']['content'])); ?></p>
                            </div>
                   
                    </div>
                    
                     <?php endforeach; } ?>

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
                           <?php 
                            if(($this->params['controller'] == 'pages' || $this->params['controller'] == 'Sports') && ($this->params['action'] == 'home' || $this->params['action'] == 'sport'))
                            { ?>
                          <?php echo $this->Form->create('News',array('id'=>"search",'novalidate')); ?>

                        <ul>
                     <li>
                        
                              <?php echo $this->Form->input('search',array('id'=>'search-terms','placeholder'=>__dbt('Enter search terms...'),'label' => false)); ?>
                                
                                
                    
                       
                               </li>
                                       <li>
                                <input type="submit" value="SEARCH">
                            </li>
                                                        <?php echo $this->Form->end(); ?> 

                                 </ul>
                       <?php  } ?>
                        
                </div>
            </div>
        </div>
    </section>



<!-- FLIPPER BOX -->

        <!-- ADD WORD -->
        <div id="sportTile" class="row">
            <div class="col-xs-12 space-bottom-40 text-center">
                    <div class="add-word-box"><a href="javascript:void(0);"><img src="/img/add-word.jpg" alt="add-word" /></a></div>
            </div>
        </div>
       
          <section>
        <div class="lp spe-bot-red-3">
            <?php 
            if($search){ // if search is set then show serch result
                $countSearch = 0;
                $newsrow = 4;
                foreach($news as $newsearch):
                    if(!empty($newsearch)) {
                    $countSearch++;
    
            ?>      
                       
         <?php if ($newsrow % 4 == 0){ echo '<div class="hom-top-trends row">'; }?>

                      <div class="col-md-3">
                        <div class="hom-trend">
                            <div class="hom-trend-img">
                                <img class="img-responsive" src="<?php if(isset($newsearch['File']['new_name']) && $newsearch['File']['new_name']!='')  echo BASE_URL.'img/NewsImages/large/'.$newsearch['File']['new_name']; else echo ''; ?>" alt="<?php if(isset($newsearch['File']['name'])) echo __dbt($newsearch['File']['name']); ?>">
                            </div>
                            <div class="hom-trend-con">
            
                                <p><?php if(isset($newsearch['News']['description']) && $newsearch['News']['description']!='') { 
                                        $newsCardDescriptionL50 = $this->Common->wordTruncate(strip_tags(__dbtnews($newsearch['News']['id'])),25);
                                echo $newsCardDescriptionL50;
                                        //echo __dbtnews(mb_substr($newsearch['News']['description'], 0, 30, 'UTF-8'));
                                          }  ?> <?php if(isset($newsearch['News']['id'])) echo $this->Html->link(__dbt('more...'), array('controller'=>'Sports','action' => 'news', base64_encode($newsearch['News']['id'])), array('title'=>__dbt('View News'),'div'=>false));  ?> </p>
                            </div>
                        </div>
                    </div>
          <?php $newsrow++; if ($newsrow % 4 == 0){ echo '</div>'; }  ?>

                
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
            $newsrow = 4;
              foreach($news as $newscard):
              if(!empty($newscard)) { 
                 $countNews++;
            ?>
            
                     <?php if ($newsrow % 4 == 0){ echo '<div class="hom-top-trends row">'; }?>

                          <div class="col-md-3">
                        <div class="hom-trend">
                            <div class="hom-trend-img">
                            <img src="<?php if(isset($newscard[0]['File']['new_name']) && $newscard[0]['File']['new_name']!='')  echo BASE_URL.'img/NewsImages/large/'.$newscard[0]['File']['new_name']; else echo ''; ?>"  alt="<?php if(isset($newscard[0]['File']['name'])) echo __dbt($newscard[0]['File']['name']); ?>">
                            </div>
                            <div class="hom-trend-con">

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
                    </div>

      <?php $newsrow++; if ($newsrow % 4 == 0){ echo '</div>'; }  ?>

             <?php } 
                endforeach;   ?>   

  <?php
            } // if search end  ?> 
        </div>
         </div>
</section>

<!-- FLIPPER BOX END -->
<script>
$( document ).ready(function() {
          setInterval(function(){ plusSlides(1); }, 6000);

});
</script>