<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<section class="content-header">
    <h1><?php echo __dbt('Add News'); ?>
        <small><?php echo __dbt('Admin Add News'); ?></small>
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
                    <?php echo $this->Form->create('News', array('class' => 'form-horizontal', 'autocomplete' => "off", "enctype" => "multipart/form-data")); ?>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Language'); ?></label>
                        <div class="col-sm-4">
                            <?php echo $this->Form->input('language', array('options' => $available_lang, 'class' => 'form-control', 'label' => false, 'multiple' => 'multiple', 'empty' => '-- Select Language --')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Sport'); ?></label>
                        <div class="col-sm-4">
                            <?php echo $this->Form->input('foreign_key', array("options" => $sports, 'class' => 'form-control', 'label' => false, 'empty' => __dbt('-- Select Sport --'))); ?>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Template'); ?></label>
                        <div class="col-sm-4">
                          <?php  echo $this->Form->input('template_id', array("type" => "select", "options" => $newstemplate, "class" => "form-control",'onchange'=>"selectTemplate(this);", 'label' => false, 'empty' => '-- Select status --'));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Description'); ?></label>
                        <div class="col-sm-8">
                            <?php echo $this->Form->textarea('description', array('id' => 'editor1', 'class' => 'form-control', 'placeholder' => __dbt('Enter news description'), 'label' => false, 'autocomplete' => "off")); ?>
                            <span id="emptyError" style="color:red"; ></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('External URL'); ?></label>
                        <div class="col-sm-4">
                                <?php echo $this->Form->input('external_url', array("type"=>"text",'data-field'=>'datetime',"class"=>"form-control",'label' => false));  ?>
                        </div>
                    </div>
                    <div style="display: none;" id="contentForOtherLang"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('News Image'); ?></label>
                        <div class="col-sm-4">
                           <?php echo $this->Form->input('file_id', array('type' => 'file', 'label' => false,'id' => 'firstimg','onchange'=>"readURL(this);" , 'accept' => array("image/*"))); ?>
                           
                        </div>
                    </div>
                    <div class="form-group" id="templateclass">
                       
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
                        <div class="col-sm-4">
                            <?php $status_options = array("Inactive", "Active");
                            echo $this->Form->input('status', array("type" => "select", "options" => $status_options, "class" => "form-control", 'label' => false, 'empty' => '-- Select status --'));
                            ?>
                        </div>
                        <div class="col-sm-4" style="float:right;">
                        <input type="button" value="preview" class="btn btn-primary" id="showpreview"/>
                       </div>
                    </div>

                    <div class="box-footer">
                        <div class="col-sm-4 control-label">
<?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'btn btn-primary', 'div' => false, 'id' => 'submitPoll')); ?>
                            <a class="btn btn-warning margin" href="/admin/news"><?php echo __dbt('Cancel'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="bloger-modal">
           <div class="modal fade" id="putPrediction" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#3C8DBC;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:white;"><?php echo __dbt('New Template Preview'); ?></h4>
                </div>
                <div class="modal-bodys">
                <div id="newstemplate" style="text-align:center;padding:50px 10px;">
                </div>
                
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        CKEDITOR.replace('editor1');
    });

    $(document).ready(function() {

        $('#submitPoll').on('click', function() {
            var valid = true;
            $('#emptyError').html('');
            var textval = CKEDITOR.instances.editor1.document.getBody().getChild(0).getText().trim();
            if (textval == "")
            {
                $('#emptyError').html('<?php echo __dbt("Please enter description."); ?>');
                valid = false;
            }
            if (textval.length >= 1000)
            {alert(textval.length);
                $('#emptyError').html('<?php echo __dbt("You can not enter more then 1000 character."); ?>');
                valid = false;
            }

            return valid;
        });
        $(document).on('change', '#NewsLanguage', function() {
            var other_lang = $(this).val();
            var news_id = "<?php echo (isset($this->request->data['News']['id']) ? $this->request->data['News']['id'] : ''); ?>";
            $.ajax({
                url: "/news/otherlang/",
                method: "post",
                data: {other_lang: other_lang, news_id: news_id},
                success: function(result) {
                    //console.log(result);
                    $('#contentForOtherLang').html(result);
                    $('#contentForOtherLang').css('display', 'block');

                    for (var i = 0; i < other_lang.length; i++) {
                        var editorname = 'editor' + other_lang[i];
                        var editorid = 'hinNews' + other_lang[i];
                        CKEDITOR.replace(editorname);
                        //$('#'+editorname).val("<?php //echo Sanitize::stripTags(nl2br($this->request->data['HinNews']['description']), 'b', 'p', 'div');//strip_tags($this->request->data['HinNews']['description']); ?>");
                        //$('#'+editorid).val("<?php //echo $this->request->data['HinNews']['id']; ?>");
                    }
                }
            });
        });
    });

</script>
<script>
function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img_one')
                        .attr('src', e.target.result)
                        .width(100 +'%')
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        function readsURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img_two')
                        .attr('src', e.target.result)
                        .width(100 +'%')
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
       
</script>
<script>
function selectTemplate(obj){
    $('.admin-amzn-loader').show();
        var newstemplateid = $('#NewsTemplateId').val();
        var firstimage= $('#firstimg').val();
          $('#firstimg').val(null);
       // alert('ok');
        var jQ = $(obj);
        var newstemplate= jQ.val();
        if(newstemplateid==2)
        {        
          $("#templateclass").append('<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt("Second Image"); ?></label><div class="col-sm-4"><?php echo $this->Form->input("second_file_id", array('type' => "file", "label" => false, "id" =>"secondimg","onchange"=>"readsURL(this);" ,"accept" => array("image/*"))); ?></div>');
         
          
        }
        else
        {
         $("#templateclass").html('');
        }
        if(newstemplateid!=""){
        var url = "<?php echo $this->Html->url(array("controller"=>"News", "action"=>"getAjaxTemplate", $this->params["prefix"] => false)); ?>/"+Base64.encode(newstemplateid);
        $.post(url, {newstemplateid:"newstemplateid"}, function(data){
        $('.admin-amzn-loader').hide();
            $("#newstemplate").html(data);
            

        });
        }
       
       
    }
     $('#showpreview').click(function () {
     
            $('#putPrediction').modal({show: true});
            var str = document.getElementById("description_value").innerHTML; 
            var  description =  CKEDITOR.instances.editor1.document.getBody().getChild(0).getText().trim();
           
            var textdata = str.replace("{DESCRIPTION}",description);
            document.getElementById("description_value").innerHTML = textdata;
        });

</script>