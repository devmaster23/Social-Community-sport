<section class="grey_container">
	<h1 class="new_padd">Add Section Listing</h1>
	    <?php echo $this->Form->create("SectionList", array('action'=>'admin_add'));?>
		<section class="grey_container_info">
		    <ul class="form">
			<li>
			    <label>Name:<span class="textred" style="font-size: 16px;">*&nbsp;</span></label>
			    <?php echo $this->Form->input("SectionList.name",array('label'=>false,'class'=>'input','div'=>false));?>
			</li>
                       <li>
			    <label>Controller:<span class="textred" style="font-size: 16px;">*&nbsp;</span></label>
			    <?php echo $this->Form->input("SectionList.controller",array('label'=>false,'class'=>'input','div'=>false));?>
			</li>
			<li>
			    <label>Action:<span class="textred" style="font-size: 16px;">*&nbsp;</span></label>
			    <?php echo $this->Form->input("SectionList.action",array('label'=>false,'class'=>'input','div'=>false));?>
			</li>
                        <li class="padd_top">
                            <label>&nbsp;</label>
			    <?php echo $this->Form->submit('Add Section Listing',array('class'=>'button'));?>
			</li>
                    </ul>  
                </section>
	     <?php echo $this->Form->end();?>	    	
</section>