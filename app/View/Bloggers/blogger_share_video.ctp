<div class="main-wrap">
   <div class="container">
      <div class="event-title">
            <h4><?php echo __dbt('YouTube Video Share'); ?></h4>
      </div> 
        <div class="inner-wrap">
            <div class="row">
                <!-- Sidebar start -->
                <div class="col-sm-2 sidebar-new">
                <?php echo $this->element($elementFolder.'/sidebar'); ?>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="box-body">
                        <?php echo $this->Form->create('WallContent',array('class'=>'form-horizontal','novalidate')); ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="inputEmail3"><?php echo __dbt('YouTube Link'); ?></label>
                                    <div class="col-sm-8">
                                            <?php echo $this->Form->input('name',array('class'=>'inbox form-control','placeholder'=>__dbt('Enter youtube link'),'label' => false,'target'=>"preview_frame")); ?>
                                        <span id='video-error' class='error'></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="inputEmail3"><?php echo __dbt('Video Title'); ?></label>
                                    <div class="col-sm-8">
                                            <?php echo $this->Form->input('title',array('class'=>'inbox form-control','placeholder'=>__dbt('Title for video'),'label' => false)); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="inputEmail3"><?php echo __dbt('Video Status'); ?></label>
                                    <div class="col-sm-8">
                                            <?php 
                                            $status_options = array("Inactive", "Active");
                                            $status_new_array = array();
                                            foreach ($status_options as $key1 => $value1) {
                                                $status_new_array[$key1] = __dbt($value1);
                                            }
                                            
                                                echo $this->Form->input('status', array("type"=>"select",'class'=>'form-control','label' => false, "options"=>$status_new_array,'empty'=>__dbt('-- Select Status --')));  ?>
                                    </div>
                                </div>
                                <div class="box-footer">
						<div class="col-sm-12 control-label">
                                                <?php 
                                                echo $this->Form->submit(__dbt('Save'),array('id'=>'savelink','type' => 'submit','class'=>'btn btn-info btn-sm pull-right','div'=>false));
                                                echo $this->Form->button(__dbt('Preview'),array('id'=>'preview_btn','class'=>'btn btn-info btn-sm pull-right','div'=>false,'disabled')); ?>    
						
                                                </div>
                                </div>
                       <?php echo $this->Form->end();?>

                    </div>
                 </div>
                 <div class="col-sm-4 col-md-4 preview vdo-blg-edt">
                     <iframe id="preview_frame" width="100%" height="220" src="" frameborder="0"></iframe>
                 </div>    
            </div>
        </div>    
    </div>
</div>
<style>
    .preview {border: 1px solid #ddd;}
</style>
<script type='text/javascript'>
$(document).ready(function(){
    
    $('#preview_btn').click(function(e) {
       e.preventDefault();
       var playLink = '';
       var url = $('#WallContentName').val();
       var videoid = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
        if(videoid != null) {
        playLink = 'http://www.youtube.com/embed/'+videoid[1];
        } else { 
            alert("<?php echo __dbt('Invalid youtube url.')?>");
            return false;
        }
       $('#preview_frame').attr("src", playLink);
      
    });
    
  
    $('#savelink').click(function() {
        var url = ($('#WallContentName').val()).trim();
        if(url== ''){

            $('#video-error').html("<?php echo __dbt('Video url can not be empty.')?>");

            return false;
        }
        
        var videoid = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
       
        if(videoid == null) {

         $('#video-error').html("<?php echo __dbt('Invalid youtube url.'); ?>");
            return false;
        }  
        
    });
    
    $('#WallContentName').on('keyup',function(e){
        var regexp = /(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=))([\w-]{10,12})/g;;
         var video_url = $(this).val();
         var matches_array = video_url.match(regexp);
          if(matches_array == null)
                {
                    $('#WallContentName').css('border','1px solid #FF0000');
                    $('#preview_btn').attr('disabled', true);
                    return false;
                   
                } else {
                    $('#preview_btn').removeAttr('disabled');
                    return true;
                }
        
    });
});    
</script>