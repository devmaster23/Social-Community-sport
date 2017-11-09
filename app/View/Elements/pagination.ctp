<div id='pagination'>
<?php
$model_name = array_keys($this->params['paging']);
$model_name = $model_name[0];
if($this->params['paging'][$model_name]['count'] > $this->params['paging'][$model_name]['current']){
?>
<?php

$named_params = array();
foreach($this->params['named'] as $key=>$value){
    $named_params[] = $key.":".$value;
}

$named_param_str  = implode('/',$named_params);
$paging_action  = ltrim($paging_action,'/');
$url_array['action']  = $paging_action;

if(isset($paginate_limit_admin) && !empty($paginate_limit_admin)){
  $url_array['paginate_limit_admin']  = $paginate_limit_admin;
  //$this->Session->write('paging_limit', $paginate_limit_admin);
  //echo $paginate_limit_admin;
  
}
//print_r($this->Session);
foreach($this->params['named'] as $key=>$value){
    $url_array[$key] = $value;
   // echo $value;
}

if(isset($pass)){
 $url_array = array_merge($url_array,$pass);
}

//$paginator->options(array("url"=>$url_array));
//if ($this->Paginator->hasPage(2)) { 
//  echo $this->Paginator->first("First Page",array('tag'=>'<li>','separator'=>'&nbsp;'));  
//  echo $this->Paginator->prev('Previous',array('tag'=>'<li>'));  
//  echo $this->Paginator->numbers(array('separator'=>'&nbsp;','tag'=>'<li>'));  
//  echo $this->Paginator->next("Next",array('tag'=>'<li>'));  
//  echo $this->Paginator->last("Last Page",array('tag'=>'<li>'));
// }
?>
<!-- Shows the next and previous links -->
<?php echo $this->Paginator->first("First Page",null, null);?>
<?php echo $this->Paginator->prev('« Previous', null, null, array('class' => 'previousoff')); ?>
<?php echo $this->Paginator->numbers(array('separator'=>''));?>
<?php echo $this->Paginator->next('Next »', null, null, array('class' => 'next-off')); ?>
<!-- prints X of Y, where X is current page and Y is number of pages -->
<?php echo $this->Paginator->last("Last Page");?>
<?php } ?>
</div>