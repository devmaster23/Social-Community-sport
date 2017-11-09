<section class="content-header">
	<h1><?php echo __dbt('View Team'); ?>
	  <small><?php echo __dbt('Team Details'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?php echo __dbt('Team Details'); ?></h3>
                          <a href="/team/walls" class="btn btn-warning pull-right"><?php echo __dbt('Back'); ?></a>
			</div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tbody>
						<tr>
						  <td><?php echo __dbt('Title'); ?></td>
						  <td><?php echo __dbt($videoDetail['WallContent']['title']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Video Link'); ?></td>
						  <td><?php
                                                      if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoDetail['WallContent']['name'], $match)) {
                                                            ?>
                                                      <iframe id="preview_frame" width="560" height="315" src="http://www.youtube.com/embed/<?php echo $match[1]; ?>" frameborder="0"></iframe>
                                                       <?php }
                                                      ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('League'); ?></td>
						  <td><?php echo $videoDetail['Wall']['league_id']; ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Team'); ?></td>
						  <td><?php echo $videoDetail['Wall']['team_id']; ?></td>
                                                </tr>
                                                <tr>
						  <td><?php echo __dbt('Status'); ?></td>
						  <td><?php echo h($videoDetail['WallContent']['status']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Created'); ?></td>
						  <td><?php echo h($videoDetail['WallContent']['created']); ?></td>
						</tr>
						<tr>
						  <td><?php echo __dbt('Modified'); ?></td>
						  <td><?php echo h($videoDetail['WallContent']['modified']); ?></td>
						</tr>
				      </tbody>
				</table>
			</div>
		</div>	
	  </div>
	 </div>
</section>