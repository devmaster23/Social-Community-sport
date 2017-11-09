<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __dbt('Games'); ?>
    <small><?php echo __dbt('Games Result List'); ?></small>
  </h1>
  <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
  
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
	<div class="box">
		<div class="box-header">
		    <div class="UserAdminIndexForm">
			<div class="box-body">	
			   <div class="row">
			     <?php  echo $this->Form->create('GameResult', array('type' => 'get', 'url' => array('controller' => 'games', 'action' => 'listPredictions', $this->params["prefix"] => true), "novalidate"=>"novalidate")); ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("GameResult.team_id", array('name'=>'first_team',"label"=>false,"empty"=>"--First Team--", "div"=>false,'class'=>"form-control"))."</div>"; ?>
					    <?php echo "<div class='col-xs-2'>". $this->Form->input("GameResult.team_id", array('name'=>'second_team',"label"=>false,"empty"=>"--Second Team--", "div"=>false,'class'=>"form-control"))."</div>"; ?>
                        <?php echo "<div class='col-xs-2'>". $this->Form->input("GameResult.sport_id", array("type"=>"select", "empty"=>"--Select Sport--","label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?> 
                        <?php echo "<div class='col-xs-2'>". $this->Form->input("GameResult.game_day", array("type"=>"select", "empty"=>"--Select Day--","options" => array_combine(range(1,99,1),range(1,99,1)),"label"=>false, "div"=>false,'class'=>"form-control"))."</div>"; ?> 
						<div class='col-xs-offset-3 admin-search-btn'>
						  <input type="submit" class="btn bg-olive margin" value="Search">	
						  <a href="<?php echo $this->here; ?>" class="btn btn-warning" ><?php echo __dbt("Reset"); ?></a>
						</div>	
			    <?php echo $this->Form->end(); ?>    
			   </div>
			</div>	   
		    </div>
		</div>	
		<!-- filters starts-->
		<div class="box-body">
			<table class="table table-striped" id="prodlist">
				<thead>
					<tr>
                                            <th><?php echo $this->Paginator->sort('tournament_id'); ?></th>
                                            <th><?php echo $this->Paginator->sort('sport_id'); ?></th>
                                            <th><?php echo $this->Paginator->sort('first_team'); ?></th>
                                            <th><?php echo $this->Paginator->sort('second_team'); ?></th>
                                            <th><?php echo $this->Paginator->sort('first_team_goals'); ?></th>
                                            <th><?php echo $this->Paginator->sort('second_team_goals'); ?></th>
                                            <th><?php echo $this->Paginator->sort('Game Day'); ?></th>
                                            <th class="actions"><?php echo __dbt('Actions'); ?></th>
                                            

					</tr>
				</thead>
				<tbody>
				<?php if(!empty($games)) {

                                    foreach ($games as $game):?>
					<tr>
						<td>
							<?php echo $this->Html->link($game['Tournament']['name'], array('controller' => 'tournaments', 'action' => 'view', base64_encode($game['Tournament']['id']))); ?>
						</td>
						<td>
							<?php echo $this->Html->link($game['Sport']['name'], array('controller' => 'sports', 'action' => 'view', base64_encode($game['Sport']['id']))); ?>
						</td>
						<td><?php echo h($game['team']['name']); ?>&nbsp;</td>
						<td><?php echo h($game['secondteam']['name']); ?>&nbsp;</td>
						<td><?php echo h($game['GamesResult']['first_team_goals']); ?>&nbsp;</td>
						<td><?php echo h($game['GamesResult']['second_team_goals']); ?>&nbsp;</td>
						<td><?php echo h($game['GamesResult']['game_day']); ?>&nbsp;</td>
						<td class="actions">
						<?php echo $this->Html->link(__dbt(''), 'javascript:void(0)',array('class'=>'fa fa-edit editresult','title'=>'Edit Game','gameId' 
						=>base64_encode($game['GamesResult']['game_id']),'firstteam' =>base64_encode($game['team']['name']),'secondteam'=>base64_encode($game['secondteam']['name']),'id'=>base64_encode($game['GamesResult']['id']))); ?>
						</td>
						
						
					</tr>
                                <?php endforeach; } else { ?>
                                        <tr>    
                                        <td class="text-center" colspan="8"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
					</tr>
                                <?php } ?>        
				</tbody>
				</table>
				<div class="row">
					<div class="col-sm-5">
						<div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
						</div>
					</div>
					<div class="col-sm-7">
						<?php echo $this->element('pagination',array('paging_action'=>$this->here));?>
					</div>
				</div>
			</div>
		
	</div>
    </div>
  </div>
</section>
<div class="bloger-modal">
    <div class="modal fade" id="putPrediction" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo __dbt('Edit Scores'); ?></h4>
                </div>
                <div class="modal-bodys">

                </div>
            </div>
        </div>
    </div>
</div>
<script>



    $('.editresult').click(function () {
        var game_Id = $(this).attr("gameId");
        var first_team = $(this).attr("firstteam");
        var second_team = $(this).attr("secondteam");
        var  first_team_goals = $(this).attr("firstteamgoals");
        var second_team_goals = $(this).attr("secondteamgoals");
        var id = $(this).attr("id");

        var base_url = window.location.origin;
        $('.modal-bodys').load(base_url+'/'+'admin/games/gameResultEdit/' + first_team + '/'+ second_team +'/'+game_Id +'/'+ id, function (result) {
            $('#putPrediction').modal({show: true});
        });

   
    });
</script>

	
	

