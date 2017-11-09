<!-- MAIN CONTENT -->
<div class="main-wrap">
    <div class="container">
        <?php echo $this->Common->topNavSports(AuthComponent::User('id')); ?>
       <!-- PROFILE PAGE --> 
        <div class="profile-page-wrap">
            <div class="event-title">
                <h4><?php $teamName = AuthComponent::User('sportSession.teamName'); echo  !empty($teamName) ? $teamName .__dbt('Team Members')  : __dbt('My Team Members'); ?></h4>
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
                        <div class="profile-form-layout">
                            <div class="table-responsive">
                                    <table border="0" class="table table-hover table-bordered table-striped" cellpadding="0" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo $this->Paginator->sort('user_id'); ?></th>
                                                <th><?php echo $this->Paginator->sort('tournament_id'); ?></th>
                                                <th><?php echo $this->Paginator->sort('sport_id'); ?></th>
                                                <th><?php echo $this->Paginator->sort('league_id'); ?></th>
                                                <th class="actions"><?php echo __dbt('Actions'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($userTeams as $userTeam): ?>
                                            <tr>
                                                <td>
                                                        <?php echo __dbt($userTeam['User']['name']); ?>
                                                </td>
                                                <td>
                                                        <?php echo __dbt($userTeam['Tournament']['name']); ?>
                                                </td>
                                                <td>
                                                        <?php echo __dbt($userTeam['Sport']['name']); ?>
                                                </td>
                                                <td>
                                                        <?php echo __dbt($userTeam['League']['name']); ?>
                                                </td>
                                                <td class="actions">
                                                        <?php echo $this->Html->link(__dbt('View'), array('action' => 'view', base64_encode($userTeam['UserTeam']['id']))); ?>

                                                </td>
                                        </tr>
                                    <?php endforeach; ?>
                                           
                                        </tbody>    
                                </table>
                            </div>
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
<!-- MAIN CONTENT END -->