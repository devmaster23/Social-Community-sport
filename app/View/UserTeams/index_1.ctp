<!-- MAIN CONTENT -->
<div class="main-wrap">
    <div class="container">
        <?php echo $this->Common->topNavSports(AuthComponent::User('id')); ?>
        <!-- PROFILE PAGE --> 
        <div class="profile-page-wrap">
            <div class="event-title">
                <h4><?php $teamName = AuthComponent::User('sportSession.teamName'); echo  !empty($teamName) ? $teamName .' '.__dbt('Team')  : __dbt('My Teams'); ?></h4>
            </div>

            <!-- INNER WRAP -->
            <div class="inner-wrap">
                <div class="row">
                    <!-- Sidebar start -->
                    <div class="col-sm-2">
                    <?php echo $this->element($elementFolder.'/sidebar'); ?>
                    </div>
                    <!-- SIDEBAR END -->

                    <!-- MIDDLE CONTENT -->
                    <div class="col-sm-10">
                            <div class="table-responsive">
                                    <table border="0" class="table table-hover table-bordered table-striped" cellpadding="0" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th style="width:13%"><?php echo $this->Paginator->sort('tournament_id'); ?></th>
                                                <th class="text-center" style="width:10%"><?php echo $this->Paginator->sort('sport_id'); ?></th>
                                                <th class="text-center" style="width:12%"><?php echo $this->Paginator->sort('league_id'); ?></th>
                                                <th class="text-center" style="width:12%"><?php echo $this->Paginator->sort('team_id'); ?></th>
                                                <!--<th class="text-center" style="width:12%"><?php //echo $this->Paginator->sort('rejoin_date'); ?></th>
                                                <th class="text-center" style="width:15%"><?php //echo $this->Paginator->sort('leave_date'); ?></th>-->
                                                <th class="text-center" style="width:16%"><?php echo __dbt('Actions'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php  if(!empty($userTeams)) {
                                                foreach ($userTeams as $userTeam): ?>
                                            <tr>
                                                <td>
                                                        <?php echo h(__dbt($userTeam['Tournament']['name'])); ?>
                                                </td>
                                                <td class="text-center">
                                                        <?php echo h(__dbt($userTeam['Sport']['name'])); ?>
                                                </td>
                                                <td class="text-center">
                                                        <?php echo h(__dbt($userTeam['League']['name'])); ?>
                                                </td>
                                                <td class="text-center">
                                                        <?php echo h(__dbt($userTeam['Team']['name'])); ?>
                                                </td>
                                                <!--<td class="text-center"><?php //if($userTeam['UserTeam']['rejoin_date']=='0000-00-00 00:00:00'){echo '--';}else{echo h(date('Y-m-d',strtotime($userTeam['UserTeam']['rejoin_date'])));} ?>&nbsp;</td>
                                                <td class="text-center"><?php //if($userTeam['UserTeam']['leave_date']=='0000-00-00 00:00:00'){echo '--';}else{echo h(date('Y-m-d',strtotime($userTeam['UserTeam']['leave_date'])));} ?>&nbsp;</td>-->

                                                
                                                <td class="text-center action-link">
                                                        <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users','title'=>'Team Members')) . "",array('action' => 'teamMembers',base64_encode($userTeam['UserTeam']['team_id'])),array('escape' => false)); ?>&nbsp;&nbsp;
                                                        <?php if($userTeam['UserTeam']['status'] == 1) echo $this->Form->postLink(__dbt('Leave Team'), array('action' => 'leave', base64_encode($userTeam['UserTeam']['id'])), array('confirm' => __dbt('Are you sure you want to leave this team ? Once you leave, you will not be able to join any other team of same league.'), $userTeam['UserTeam']['id'])); ?>
                                                        <?php if($userTeam['UserTeam']['status'] == 0) {
             
                                                                $leave_date = new DateTime($userTeam['UserTeam']['leave_date']);                                                 
                                                                $current_date = new DateTime(date('Y-m-d h:i:s'));
                                                                $difference = $leave_date->diff($current_date);
                                                                if($difference->days<=maxDays){
                                                                    echo $this->Form->postLink(__dbt('Rejoin Team'), array('action' => 'rejoin', base64_encode($userTeam['UserTeam']['id']))/*, array('confirm' => __dbt('Are you sure you want to join this team ?', $userTeam['UserTeam']['id']))*/);    
                                                                }
                                                            }?>
                                                </td>
                                            </tr>
                                            <?php endforeach; } else { ?>
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                        <?php echo __dbt('No record found'); ?>
                                                </td>
                                            </tr>    
                                            <?php } ?>
                                           
                                        </tbody>    
                                </table>
                            </div>
                    </div>
                    <!-- MIDDLE CONTENT END -->
                </div> 
            </div>  
            <!-- INNER WRAP END -->
        </div>
        <!-- PROFILE PAGE EMD --> 
                    </div>
</div>