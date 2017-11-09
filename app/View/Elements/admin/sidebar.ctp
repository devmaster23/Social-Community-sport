<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
<?php if(AuthComponent::user("File.new_name")) {
        $profileImg =  BASE_URL.'img/ProfileImages/thumbnail/'.AuthComponent::user("File.new_name");
    } else {
        $profileImg = BASE_URL.'img/default_profile.png';
    }
?>
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo $profileImg; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php  echo $this->Session->read('Auth.Admin.name');?></p>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">

            <li class="header"><?php echo ('MAIN NAVIGATION'); ?></li>
            <!-- Optionally, you can add icons to the links -->
            <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-envelope')) . "<span>".('Contact Us')."</span>",array('controller' => 'pages', 'action' => 'contact'),array('escape' => false)); ?></li>
	    <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-pie-chart"></i><span><?php echo ('Forums / Polls'); ?></span></a>
		  <ul class="treeview-menu" >
                    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pie-chart')) . "<span>".('View Polls')."</span>",array('controller' => 'sports', 'action' => 'polls'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . "<span>".('Add Poll')."</span>",array('controller' => 'sports', 'action' => 'addPolls'),array('escape' => false)); ?></li>
                    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . "<span>".('Add Fourm')."</span>",array('controller' => 'sports', 'action' => 'addFourms'),array('escape' => false)); ?></li>
		  </ul>

	    </li>
	    <li class="treeview"><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users')) . "<span>Games</span>",array('controller' => 'games', 'action' => 'index'),array('escape' => false)); ?>
		  <ul class="treeview-menu" >
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users')) . "<span>".('List Games')."</span>",array('controller' => 'games', 'action' => 'index'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . "<span>".('Add Game')."</span>",array('controller' => 'games', 'action' => 'add'),array('escape' => false)); ?></li>

		  </ul>

	    </li>

            <li class="treeview"><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-gift')) . "<span>Gifts</span>",array('controller' => 'gifts', 'action' => 'index'),array('escape' => false)); ?>
		  <ul class="treeview-menu" >
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-gift')) . "<span>".('List Gifts')."</span>",array('controller' => 'gifts', 'action' => 'index'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . "<span>".('Add Gifts')."</span>",array('controller' => 'gifts', 'action' => 'add'),array('escape' => false)); ?></li>
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . "<span>".('Add Gift Location')."</span>",array('controller' => 'gifts', 'action' => 'addLocation'),array('escape' => false)); ?></li>

		  </ul>

	    </li>
            <li class="treeview"><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-list')) . "<span>".('League')."</span>",array('controller' => 'leagues', 'action' => 'index'),array('escape' => false)); ?>
		  <ul class="treeview-menu" >
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-list')) . "<span>".('List League')."</span>",array('controller' => 'leagues', 'action' => 'index'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . "<span>".('Add League')."</span>",array('controller' => 'leagues', 'action' => 'add'),array('escape' => false)); ?></li>

		  </ul>

	    </li>
            <li class="treeview"><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-newspaper-o')) . "<span>".('News')."</span>",array('controller' => 'news', 'action' => 'index'),array('escape' => false)); ?>
		  <ul class="treeview-menu" >
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-newspaper-o')) . "<span>".('List News')."</span>",array('controller' => 'news', 'action' => 'index'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . "<span>".('Add News')."</span>",array('controller' => 'news', 'action' => 'add'),array('escape' => false)); ?></li>

		  </ul>

	    </li>
            <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-question-circle"></i><span><?php echo ('Predictions'); ?></span></a>
		  <ul class="treeview-menu" >
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Baseball Predictions')."</span>",array('controller' => 'games', 'action' => 'baseballPrediction'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Basketball Predictions')."</span>",array('controller' => 'games', 'action' => 'basketballPrediction'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Basketball Predictions')."</span>",array('controller' => 'games', 'action' => 'basketballPredictions'),array('escape' => false)); ?></li>
                    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Cricket Predictions')."</span>",array('controller' => 'games', 'action' => 'cricketPrediction'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Football Predictions')."</span>",array('controller' => 'games', 'action' => 'footballPrediction'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Football Predictions')."</span>",array('controller' => 'games', 'action' => 'footballPredictions'),array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Hockey Predictions')."</span>",array('controller' => 'games', 'action' => 'hockeyPrediction'),array('escape' => false)); ?></li>
             <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Hockey Predictions')."</span>",array('controller' => 'games', 'action' => 'hockeyPredictions'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Soccer Predictions')."</span>",array('controller' => 'games', 'action' => 'soccerPrediction'),array('escape' => false)); ?></li>
		     <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Soccer Predictions')."</span>",array('controller' => 'games', 'action' => 'soccerWinner'),array('escape' => false)); ?></li>

		     
		  </ul>

	    </li>
         <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-circle"></i><span><?php echo ('Scores'); ?></span></a>
         <ul class="treeview-menu" >
         <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users')) . "<span>".('List Scores')."</span>",array('controller' => 'games', 'action' => 'admin_listPredictions'),array('escape' => false)); ?></li>
         <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . "<span>".('Add Soccers')."</span>",array('controller' => 'games', 'action' => 'admin_gamesResult'),array('escape' => false)); ?></li>
         
         </ul>
         </li>
          <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-trophy"></i><span><?php echo ('winners'); ?></span></a>
         <ul class="treeview-menu" >
         <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Basketball Winner')."</span>",array('controller' => 'games', 'action' => 'basketballResults'),array('escape' => false)); ?></li>
          <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Football Winner')."</span>",array('controller' => 'games', 'action' => 'footballResults'),array('escape' => false)); ?></li>
         <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Hockey Winner')."</span>",array('controller' => 'games', 'action' => 'hockeyResults'),array('escape' => false)); ?></li>
         <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-trophy')) . "<span>".('Soccer Winner')."</span>",array('controller' => 'games', 'action' => 'soccerResults'),array('escape' => false)); ?></li>
         
         

         </ul>
         </li>

            <li class="treeview"><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-list')) . "<span>".('Teams')."</span>",array('controller' => 'teams', 'action' => 'index'),array('escape' => false)); ?>
		  <ul class="treeview-menu" >
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-list')) . "<span>".('List Teams')."</span>",array('controller' => 'teams', 'action' => 'index'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . "<span>".('Add Teams')."</span>",array('controller' => 'teams', 'action' => 'add'),array('escape' => false)); ?></li>

		  </ul>

	    </li>

            <li class="treeview"><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-list')) . "<span>".('Translation')."</span>",array('controller' => 'translations', 'action' => 'index','HinTranslation'),array('escape' => false)); ?>
		  <ul class="treeview-menu" >
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-list')) . "<span>".('List Hindi Translations')."</span>",array('controller' => 'translations', 'action' => 'index','HinTranslation'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-plus')) . "<span>".('Add Hindi Translation')."</span>",array('controller' => 'translations', 'action' => 'add','HinTranslation'),array('escape' => false)); ?></li>

		  </ul>

	    </li>
	    <li class="treeview"><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-list')) . "<span>".('Tournament')."</span>",array('controller' => 'tournaments', 'action' => 'index'),array('escape' => false)); ?>
		  <ul class="treeview-menu" >
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-list')) . "<span>".('List Tournament')."</span>",array('controller' => 'tournaments', 'action' => 'index'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-plus')) . "<span>".('Add Tournament')."</span>",array('controller' => 'tournaments', 'action' => 'add'),array('escape' => false)); ?></li>

		  </ul>

	    </li>

	    <li class="treeview"><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-link')) . "<span>".('Sports')."</span>",array('controller' => 'sports', 'action' => 'index'),array('escape' => false)); ?>
		  <ul class="treeview-menu" >
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-link')) . "<span>".('List Sport')."</span>",array('controller' => 'sports', 'action' => 'index'),array('escape' => false)); ?></li>

		  </ul>

	    </li>

	    <li class="treeview"><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-circle-o')) . "<span>".('Static Sections')."</span>",array('controller' => 'staticPages', 'action' => 'index'),array('escape' => false)); ?>
		  <ul class="treeview-menu" >
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-circle-o')) . "<span>".('Static Pages')."</span>",array('controller' => 'staticPages', 'action' => 'index'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-circle-o')) . "<span>".('Sliders')."</span>",array('controller' => 'staticPages', 'action' => 'slider'),array('escape' => false)); ?></li>
                    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-plus')) . "<span>".('Add Home Slider')."</span>",array('controller' => 'staticPages', 'action' => 'addslider'),array('escape' => false)); ?></li>
                    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-plus')) . "<span>".('Add Sport Slider')."</span>",array('controller' => 'staticPages', 'action' => 'addSportSlider'),array('escape' => false)); ?></li>

		  </ul>

	    </li>
	    <li class="treeview"><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users')) . "<span>".('Users')."</span>",array('controller' => 'users', 'action' => 'index'),array('escape' => false)); ?>
		  <ul class="treeview-menu" >
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users')) . "<span>".('List Users')."</span>",array('controller' => 'users', 'action' => 'index'),array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-user-plus')) . "<span>".('Add Users')."</span>",array('controller' => 'users', 'action' => 'add'),array('escape' => false)); ?></li>
		     <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-user-plus')) . "<span>".('Deleted Users')."</span>",array('controller' => 'users', 'action' => 'deleted'),array('escape' => false)); ?></li>
		  </ul>

	    </li>
        <li class="treeview"><a href="javascript:void(0)"><i class="fa fa-desktop"></i><span><?php echo ('Monitoring'); ?></span></a>
         <ul class="treeview-menu" >
         <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil')) . "<span>".('List Writer')."</span>",array('controller' => 'news', 'action' => 'writerlist'),array('escape' => false)); ?></li>
        <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users')) . "<span>".('List online users')."</span>",array('controller' => 'users', 'action' => 'graph'),array('escape' => false)); ?></li>
        
         

         </ul>
         </li>

          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
