<div class="main-wrap">
   <div class="container">
           <div class="row">
                <div class="col-xs-12 static-page-formate para-img-text">
                    <div class="static-page-title sport-title">
                        <h2 class=""><?php echo __dbt($leagueData[0]['Sport']['name']).' '.__dbt('Leagues');?></h2>
                        <a href="javascript:history.back()"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Go Back</a>
                    </div>
                    <ul class="sport-cat-listing">
                        <?php foreach($leagueData as $leagueData){?>
                        <li class="col-xs-6 col-sm-4 col-md-3"><i class="fa fa-angle-right"></i> <?php echo __dbt($leagueData['League']['name']); ?></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
       
    </div>
</div>