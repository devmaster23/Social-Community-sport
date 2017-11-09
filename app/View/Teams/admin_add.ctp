<section class="content-header">
    <h1><?php echo __dbt('Add Team'); ?>
        <small><?php echo __dbt('Admin Edit Team'); ?></small>
    </h1>
    <?php echo $this->element($elementFolder . '/breadcrumb'); ?>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                </div>
                <div class="box-body">
                    <?php echo $this->Form->create('Team', array('class' => 'form-horizontal', 'novalidate')); ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Sport'); ?></label>
                        <div class="col-sm-4">
                            <?php echo $this->Form->input('sport_id', array('class' => 'form-control', 'label' => false, "onchange" => "getTournaments(this);", 'empty' => '-- Select Sport --')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Tournament'); ?></label>
                        <div class="col-sm-4" id="tournament-box">
                            <?php echo $this->Form->input('tournament_id', array('class' => 'form-control', 'empty' => 'Select Tournament ', 'label' => false, "onchange" => "getLeagues(this);")); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('League'); ?></label>
                        <div class="col-sm-4" id="league-box">
                            <?php echo $this->Form->input('league_id', array('class' => 'form-control', 'label' => false, 'empty' => '-- Select League --')); ?>
                        </div>
                    </div>

                    <div class="form-group teamOptionClass" style="display:none;">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Team Option'); ?></label>
                        <div class="col-sm-4">
                            <?php echo $this->Form->input('optionid', array('class' => 'form-control', 'label' => false, 'empty' => '-- Select Team Option --', 'options' => array('1' => 'New Team', '2' => 'Existing Teams'), "onchange" => "getTeamOptions(this);")); ?>
                        </div>
                    </div>


                    <div id="newTeam" style="display:block;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Team Name'); ?></label>
                            <div class="col-sm-4">
                                <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Enter team name', 'label' => false, 'autocomplete' => "off")); ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Team Moderator'); ?></label>
                            <div class="col-sm-4" id="team-box">
                                <?php echo $this->Form->input('user_id', array('class' => 'form-control', 'label' => false, 'empty' => '-- Select Team Moderator --')); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
                            <div class="col-sm-4">
                                <?php
                                $status_options = array("Inactive", "Active");
                                echo $this->Form->input('status', array("type" => "select", "value" => "1", "options" => $status_options, "class" => "form-control", 'label' => false, 'empty' => '-- Select status --'));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div id="newTeamSelect" style="display:none;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Team Name'); ?></label>
                            <div class="col-sm-4" id="existing-team-box">
                                <?php echo $this->Form->input('name1', array("type" => "select", 'class' => 'form-control', 'label' => false, 'empty' => '-- Select Team --', 'validate' => 'novalidate')); ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Team Moderator'); ?></label>
                            <div class="col-sm-4">
                                <?php echo $this->Form->input('user_id1', array("type" => "select", 'class' => 'form-control', 'empty' => '-- Select Moderator -- ', 'label' => false, 'autocomplete' => "off", "id" => "moderator-box")); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
                            <div class="col-sm-4">
                                <?php
                                $status_options = array("Inactive", "Active");
                                echo $this->Form->input('status1', array("type" => "select", "value" => "1", "options" => $status_options, "class" => "form-control", 'label' => false, 'empty' => '-- Select status --'));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="col-sm-4 control-label">
                            <?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'btn btn-primary', 'div' => false)); ?>
                            <a class="btn btn-warning margin" href="/admin/teams"><?php echo __dbt('Cancel'); ?></a>
                        </div>
                    </div>
                    <?php echo $this->Form->end();?>
                    <div class="loader-cntnt admin-amzn-loader" style="display:none;">
				<img src="/img/loading.gif" class="loader-cntnt-loader">
				</div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    function getTournaments(obj) {
	$('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller" => "Teams", "action" => "getTournamentsAjax", $this->params["prefix"] => false)); ?>/" + Base64.encode(jQ.val());
        $.post(url, {id: "id"}, function (data) {
            $('.admin-amzn-loader').hide();
	    $("#tournament-box").html(data);
        });
	$("#TeamOptionid").val('');
    }


    function getLeagues(obj) {
        $('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller" => "Teams", "action" => "getLeaguesAjax", $this->params["prefix"] => false)); ?>/" + Base64.encode(jQ.val());
        $.post(url, {id: "id"}, function (data) {
            $('.admin-amzn-loader').hide();
	    $("#league-box").html(data);
        });
	$("#TeamOptionid").val('');
    }


    function getTeamAdmin(obj) {
        $('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller" => "Teams", "action" => "getTeamAdminAjax", $this->params["prefix"] => false)); ?>/" + Base64.encode(jQ.val());
        $.post(url, {id: "id"}, function (data) {
           $('.admin-amzn-loader').hide();
	   $("#team-box").html(data);
        });
        $('.teamOptionClass').show();
	$("#TeamOptionid").val('');
    }


    function getTeamOptions(obj) {
    
        var jQ = $(obj);
        if (jQ.val() == 1) {
            $('#newTeam').show();
            $('#newTeamSelect').hide();
        } else if (jQ.val() == 2) {
	    $('.admin-amzn-loader').show();
            $('#newTeam').hide();
            $('#newTeamSelect').show();

            $('#TeamName').val("");

            var sportID = $('#TeamSportId').val();
            var leagueID = $('#TeamLeagueId').val();

            var url = "<?php echo $this->Html->url(array("controller" => "Teams", "action" => "getExistingTeamAjax", $this->params["prefix"] => false)); ?>/" + sportID + '/' + leagueID;
            $.post(url, {sportID: "sportID", leagueID: "leagueID"}, function (data) {
                $('.admin-amzn-loader').hide();
		$("#existing-team-box").html(data);
            });
             
        }
    }

    function getModerator(obj) {
	$('.admin-amzn-loader').show();
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller" => "Teams", "action" => "getModeratorAjax", $this->params["prefix"] => false)); ?>/" + jQ.val();
        $.post(url, {id: "id", sportID: "sportID", leagueID: "leagueID"}, function (data) {
            $('.admin-amzn-loader').hide();
	    $("#moderator-box").html(data);
        });
    }
</script>
