<?php 
echo $this->Form->create($model,array('class'=>'form-horizontal', 'novalidate')); 
echo $this->Form->input('id');
                                

?>
<td><?php echo $this->Form->input('text',array('class'=>'form-control','placeholder'=>'Enter Text','label' => false, 'autocomplete'=>"off","rows"=>1,"cols"=>5)); ?>&nbsp;</td>
<td><?php echo $this->Form->input('translation',array('class'=>'form-control','placeholder'=>'Enter Text','label' => false, 'autocomplete'=>"off","rows"=>1,"cols"=>5)); ?>&nbsp;</td>