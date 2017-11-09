<div id="content">
        <div class="outer">
          <div class="inner bg-light lter">
            <div class="text-center">
              <ul class="stats_box">
                <li>
                  <a href='/admin/games'>
                    <div class="sparkline"><i class="fa fa-gamepad"></i></div>
                    <div class="stat_text">
                      <span class="percent down"><?php echo __dbt('Games'); ?></span> 
                    </div>
                  </a>
                </li>
                <li>
                  <a href='/admin/leagues'>
                    <div class="sparkline"><i class="fa fa-flag-checkered"></i></div>
                    <div class="stat_text">
                      <span class="percent down"><?php echo __dbt('Leagues'); ?></span> 
                    </div>
                  </a>
                </li>
                <li>
                  <a href='/admin/news'>
                    <div class="sparkline"><i class="fa fa-newspaper-o"></i></div>
                    <div class="stat_text">
                      <span class="percent down"><?php echo __dbt('News'); ?>(<?php echo $total_news; ?>)</span> 
                    </div>
                  </a>
                </li>
                <li>
                  <a href='/admin/sports/polls'>
                    <div class="sparkline"><i class="fa fa-pie-chart"></i></div>
                    <div class="stat_text">
                      <span class="percent down"><?php echo __dbt('Polls'); ?></span> 
                    </div>
                  </a>
                </li>
                <li>
                  <a href='/admin/teams'>
                    <div class="sparkline"><i class="fa fa fa-users"></i></div>
                    <div class="stat_text">
                      <span class="percent down"><?php echo __dbt('Teams'); ?></span> 
                    </div>
                  </a>
                </li>
                <li>
                  <a href='/admin/tournaments'>
                    <div class="sparkline"><i class="fa fa-futbol-o"></i></div>
                    <div class="stat_text">
                      <span class="percent down"><?php echo __dbt('Tournaments'); ?></span> 
                    </div>
                  </a>
                </li>
                <li>
                  <a href='/admin/staticPages'>
                    <div class="sparkline"><i class="fa fa-map-o"></i></div>
                    <div class="stat_text">
                      <span class="percent down"><?php echo __dbt('Static Pages'); ?></span> 
                    </div>
                  </a>
                </li>
                <li>
                  <a href='/admin/staticPages/slider'>
                    <div class="sparkline"><i class="fa fa-slideshare"></i></div>
                    <div class="stat_text">
                      <span class="percent down"><?php echo __dbt('Slider'); ?></span> 
                    </div>
                  </a>
                </li>
                <li>
                  <a href='/admin/users'>
                    <div class="sparkline"><i class="fa fa fa-users"></i></div>
                    <div class="stat_text">
                      <span class="percent down"><?php echo __dbt('User'); ?>(<?php echo $total_users; ?>)</span> 
                    </div>
                  </a>
                </li>
                <li>
                  <a href='/admin/gifts'>
                    <div class="sparkline"><i class="fa fa fa-gift"></i></div>
                    <div class="stat_text">
                      <span class="percent down"><?php echo __dbt('Gifts'); ?></span> 
                    </div>
                  </a>
                </li>
                
              </ul>
            </div>
            <hr style="border-bottom: 1px solid #3c8dbc;margin: 0 10px;">
            
            <div class="text-center">
                <h2><?php echo __dbt('Predictions'); ?></h2>
                <ul class="stats_box">
                    <li>
                        <a href='/admin/games/baseballPrediction'>
                          <div class="sparkline"><i class="fa fa-question-circle"></i></div>
                          <div class="stat_text">
                            <span class="percent down"><?php echo __dbt('Baseball'); ?></span> 
                          </div>
                        </a>
                    </li>
                    <li>
                      <a href='/admin/games/basketballPrediction'>
                        <div class="sparkline"><i class="fa fa-question-circle"></i></div>
                        <div class="stat_text">
                          <span class="percent down"><?php echo __dbt('Basketball'); ?></span> 
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href='/admin/games/cricketPrediction'>
                        <div class="sparkline"><i class="fa fa-question-circle"></i></div>
                        <div class="stat_text">
                          <span class="percent down"><?php echo __dbt('Cricket'); ?></span> 
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href='/admin/games/footballPrediction'>
                        <div class="sparkline"><i class="fa fa-question-circle"></i></div>
                        <div class="stat_text">
                          <span class="percent down"><?php echo __dbt('Football'); ?></span> 
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href='/admin/games/hockeyPrediction'>
                        <div class="sparkline"><i class="fa fa-question-circle"></i></div>
                        <div class="stat_text">
                          <span class="percent down"><?php echo __dbt('Hockey'); ?></span> 
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href='/admin/games/soccerPrediction'>
                        <div class="sparkline"><i class="fa fa-question-circle"></i></div>
                        <div class="stat_text">
                          <span class="percent down"><?php echo __dbt('Soccer'); ?></span> 
                        </div>
                      </a>
                    </li>
                </ul>
            </div>    
          </div><!-- /.inner -->
        </div><!-- /.outer -->
      </div>