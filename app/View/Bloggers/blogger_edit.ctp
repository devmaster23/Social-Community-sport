<div class="main-wrap">
   <div class="container">
       <div class="row">
            <div class="col-md-6">
            <?php echo $this->Form->create('WallContent', array("novalidate"=>"novalidate","class"=>"form-horizontal")); ?>
            <?php  
            $status_options = array("Inactive", "Active", "Archived");
            $status_new_array = array();
            foreach ($status_options as $key1 => $value1) {
                $status_new_array[$key1] = __dbt($value1);
            }
                    echo $this->Form->hidden('id');
                    echo $this->Form->input('name',array('class'=>'inbox form-control','placeholder'=>__dbt('Enter YouTube link'),'label' => false,'target'=>"preview_frame")); 
                   echo $this->Form->input('title',array('class'=>'inbox form-control','placeholder'=>__dbt('Title for video'),'label' => false)); 
                   
                   echo $this->Form->input('status', array("type"=>"select",'class'=>'form-control','label' => false, "options"=>$status_new_array,'empty'=>__dbt('-- Select Status --'))); 

                    echo $this->Form->button(__dbt('Cancel'), array('type' => 'reset','class'=>'btn from-btn')); 
                    echo '&nbsp;'.$this->Form->submit(__dbt('Save'),array('type' => 'submit','class'=>'btn from-btn','div'=>false));
                    echo '&nbsp;'.$this->Form->button(__dbt('Preview'),array('id'=>'preview_btn','class'=>'btn from-btn','div'=>false)); ?>
            <?php echo $this->Form->end();?>

               
            </div>
            <div class="col-md-6">
                <iframe id="preview_frame" width="560" height="315" src="" frameborder="0"></iframe>
            </div>    
       </div>
       
     
 
</div>
</div>

<script>
$(document).ready(function(){
    $('#preview_btn').click(function(e) {
       e.preventDefault();
       var playLink = '';
       var url = $('#WallContentName').val();
       var videoid = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
        if(videoid != null) {
        playLink = 'http://www.youtube.com/embed/'+videoid[1];
        } else { 
            console.log("<?php echo __dbt('Not a valid YouTube url.');?>");
        }
       $('#preview_frame').attr("src", playLink);
      
    });
    
    $('#YoutubeShareName').on('keyup',function(e){
        var regexp = /(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=))([\w-]{10,12})/g;;
         var video_url = $(this).val();
         var matches_array = video_url.match(regexp);
          if(matches_array == null)
                {
                    var msg = "<?php echo __dbt('Please enter Correct Url') ?>";
                    $('#YoutubeShareName').css('border','1px solid #FF0000');
                    $('#preview_btn').attr('disabled', true);
                    return false;
                } else {
                    $('#preview_btn').removeAttr('disabled');
                    return true;
                }
        
        
    });
    
});    

</script>
