<div class="main-wrap">
   <div class="container">
		
           <div class="row">
                <div class="col-xs-12 static-page-formate para-img-text">
                	<div class="static-page-title"><h2><?php echo __dbt($bannerData['Slider']['title']); ?></h2></div>
                        
                        <?php echo $this->Sport->sportBannerImage($bannerData['Slider']['file_id']); ?>
	                <?php echo html_entity_decode($bannerData['Slider']['description']); ?>
                </div>
            </div>
       
    </div>
</div>