
<?php echo $this->Form->create('User',array('url'=> array( 'controller'=>'users','action'=>'signup'),'id'=>'signUpId','class'=>'form-horizontal loginClass','enctype' => 'multipart/form-data','inputDefaults'=>array('autocopmlete'=>'off','label'=>false,'div'=>true)));
echo 'Sport'.$this->Form->input('sport_id',array('class'=>'inbox form-control','empty'=>__dbt('Select Sport'))); 
echo 'League'.$this->Form->input('league_id',array('class'=>'inbox form-control','empty'=>__dbt('Select League'))); 
echo 'Tournaments'.$this->Form->input('tournament_id',array('class'=>'inbox form-control','empty'=>__dbt('Select Tournament'))); 
 
echo $this->Form->input('role_id',array('type'=>'hidden','class'=>'inbox form-control','div'=>false,'value'=>5));
echo $this->Form->end(); 
?>

                                        
                                       