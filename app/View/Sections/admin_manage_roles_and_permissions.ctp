<section class="grey_container">
	<h1 class="new_padd">Manage Roles And Permissions</h1>
	    <?php echo $this->Form->create('Section');?>
		<section class="grey_container_info">
		    <ul class="form">
			<li>
			    <label>Name:<span class="textred" style="font-size: 16px;">*&nbsp;</span></label>
				<?php $attributes = array('legend' => false,'value' => base64_encode('5'),'class'=>'input','label'=>false,'div'=>false);?>
				<?php echo $this->Form->radio('Role.id', $this->request->data, $attributes);?>
			</li>
                        <li class="padd_top">
                        <label><?php echo $this->Form->submit('Allow Access',array('name'=>'allow','class'=>'button'));?> </label>
			<label><?php echo $this->Form->submit('Deny Permissions',array('name'=>'deny','class'=>'button'));?></label>
			</li>
                    </ul>  
                </section>
	     <?php echo $this->Form->end();?>	    	
</section>
<style>
.input { 
    margin-left: 1%;
}
.form li label {
 
    width: 100px !important;
}
</style>