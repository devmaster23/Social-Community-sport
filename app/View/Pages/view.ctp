<div class="main-wrap">
    <?php echo $this->Flash->render(); ?>
   <div class="container">
		<?php foreach($pages as $page) { ?>
           <div class="row">
                <div class="col-xs-12 static-page-formate">
                	<div class="static-page-title"><h2><?php 
                        echo __dbt($page['StaticPage']['name']); ?></h2></div>
	                <?php echo html_entity_decode($page['StaticPage']['description']); ?>
                </div>
            </div>
        <?php } ?>
       
       
       <?php if($this->params['action'] == 'view' && $this->request->pass[0] == 'contact_us') { ?>
       <div class="row"> 
            <div class="col-md-6 col-md-offset-3">
                <?php echo $this->Form->create('ContactUs', array('url' => array('controller' => 'pages', 'action' => 'contactUs'),"novalidate"=>"novalidate","class"=>"form-horizontal", "enctype"=>"multipart/form-data")); ?>
                <div class="form-field">  
                    <?php echo $this->Form->input('email', array("type"=>"email","placeholder"=>__dbt("Enter Email"),"class"=>"form-control",'label' => false));  ?>
                </div>
                <div class="form-field"> 
                    <?php echo $this->Form->input('message', array("type"=>"textarea","placeholder"=>__dbt("Your Message..."),"class"=>"form-control",'label' => false));  ?>
                   
                </div>   
        <?php echo $this->Form->submit(__dbt('Submit'),array('type' => 'submit','class'=>'btn btn-primary bg-olive btn-flat','div'=>false));
              echo $this->Form->end();?>
            </div>
        </div>    
        <?php } ?>
       
       
    </div>
</div>
<script>
$(document).ready(function(){
   $("#ContactUsViewForm").validate({
        rules: {
          "data[ContactUs][email]": "required",
          "data[ContactUs][message]": "required"          
        },
        messages: {
          "data[ContactUs][email]": "Please enter email.",
          "data[ContactUs][message]": "Please enter message."
        }
      }); 
});
</script>
