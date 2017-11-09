<section class="grey_container">
	<h1 class="new_padd">Update Section Listing</h1>
	    <?php echo $this->Form->create("SectionList", array('id'=>'SectionListAdminEditForm','action'=>'admin_edit/'.base64_encode($data['SectionList']['id'])));
            echo $this->Form->input("SectionList.id", array('value'=>$data['SectionList']['id'],'type'=>'hidden'));?>
		<section class="grey_container_info">
		    <ul class="form">
			<li>
			    <label>Name:<span class="textred" style="font-size: 16px;">*&nbsp;</span></label>
			    <?php echo $this->Form->input("SectionList.name",array('value'=>$data['SectionList']['name'],'label'=>false,'class'=>'input','div'=>false));?>
			</li>
                       <li>
			    <label>Controller:<span class="textred" style="font-size: 16px;">*&nbsp;</span></label>
			    <?php echo $this->Form->input("SectionList.controller",array('value'=>$data['SectionList']['controller'],'label'=>false,'class'=>'input','div'=>false));?>
			</li>
			<li>
			    <label>Action:<span class="textred" style="font-size: 16px;">*&nbsp;</span></label>
			    <?php echo $this->Form->input("SectionList.action",array('value'=>$data['SectionList']['action'],'label'=>false,'class'=>'input','div'=>false));?>
			</li>
                        <li class="padd_top">
                            <label>&nbsp;</label>
			    <?php echo $this->Form->submit('Update Section Listing',array('class'=>'button'));?>
			</li>
                    </ul>  
                </section>
	     <?php echo $this->Form->end();?>	    	
</section>