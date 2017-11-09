<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<section class="content-header">
    <h1><?php echo __dbt('Edit News'); ?>
        <small><?php echo __dbt('Admin Edit News'); ?></small>
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
                    <?php
                    
                    echo $this->Form->create('News', array('class' => 'form-horizontal', "enctype" => "multipart/form-data"));
                    echo $this->Form->hidden('id');
                    $y = $available_lang;
                    $x = array_keys($y);
                    if(!empty($x)){
                        foreach($x as $key=>$value){
                            $langName = ucfirst($value);
                            $langVar = $langName."News";
                            echo $this->Form->hidden($langVar.'.id',array($langVar.'.value'=>(isset($this->request->data[$langVar]['id'])?$this->request->data[$langVar]['id']:'')));
                        }
                    }
                    
                    ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Language'); ?></label>
                        <div class="col-sm-4">
                            <?php echo $this->Form->input('language', array('options' => $available_lang, 'class' => 'form-control', 'label' => false,'multiple'=>'multiple', 'empty' => '-- Select Language --')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Sports'); ?></label>
                        <div class="col-sm-4">
                            <?php echo $this->Form->input('foreign_key', array('options' => $sports, 'class' => 'form-control', 'label' => false, 'empty' => __dbt('-- Select Sport --'))); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Description'); ?></label>
                        <div class="col-sm-8">
                            <?php echo $this->Form->textarea('description', array('id' => 'editor1', 'class' => 'form-control', 'placeholder' => __dbt('Enter news description'), 'label' => false, 'autocomplete' => "off")); ?>
                            <span id="emptyError" ></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('External URL'); ?></label>
                        <div class="col-sm-4">
                                <?php echo $this->Form->input('external_url', array("type"=>"text",'data-field'=>'datetime',"class"=>"form-control",'label' => false));  ?>
                        </div>
                    </div>
                    <?php ?>
                    <div style="display: none;" id="contentForOtherLang"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('News Image'); ?></label>
                        <div class="col-sm-4">

                            <?php if (!empty($this->request->data['File']['name'])) { ?>
                                <div class="image-preview">
                                    <?php echo $this->Html->image($this->request->data['File']['path'], array("id" => "ImageDiv", 'escape' => false, 'style' => 'width:50%')); ?>
                                </div>
                                <div class="actin-div">
                                    <?php echo $this->Html->link('<span>Change</span>', 'javascript:void(0)', array("id" => "changeImage", 'escape' => false)); ?>
                                </div>
                                <?php echo $this->Form->input('file_id', array('type' => 'file', 'label' => false, 'div' => false, 'accept' => array("image/*"), 'style' => 'display:none', 'id' => 'ItemAttachment')); ?>
                            <?php } else {
                                echo $this->Form->input("file_id", array('type' => 'file', 'label' => false, 'div' => false, 'accept' => array("image/*")));
                            }
                            ?>

                        </div>
                    </div>
                    <div class="form-group">
                    <?php if (!empty($this->request->data['SecondFile']['name'])) { ?>
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Second Image'); ?></label>
                        <div class="col-sm-4">

                            <?php if (!empty($this->request->data['SecondFile']['name'])) { ?>
                                <div class="image-previews">
                                    <?php echo $this->Html->image($this->request->data['SecondFile']['path'], array("id" => "Image_Div", 'escape' => false, 'style' => 'width:50%')); ?>
                                </div>
                                <div class="actin-divs">
                                    <?php echo $this->Html->link('<span>Change</span>', 'javascript:void(0)', array("id" => "change_Image", 'escape' => false)); ?>
                                </div>
                                <?php echo $this->Form->input('second_file_id', array('type' => 'file', 'label' => false, 'div' => false, 'accept' => array("image/*"), 'style' => 'display:none', 'id' => 'ItemAttachments')); ?>
                            <?php } else {
                                echo $this->Form->input("second_file_id", array('type' => 'file', 'label' => false, 'div' => false, 'accept' => array("image/*")));
                            }
                            ?>

                        </div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
                        <div class="col-sm-4">
<?php $status_options = array("Inactive", "Active");
echo $this->Form->input('status', array("type" => "select", 'class' => 'form-control', 'label' => false, "options" => $status_options, 'empty' => '-- Select Status --'));
?>
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
<script>
    $(document).on('click', '#changeImage', function() {
        $("#ItemAttachment").css('display', 'block');
        $("#changeImage").css('display', 'none');
        $("#ImageDiv").css('display', 'none');
        $('.image-preview').css('display', 'none');
        $('.actin-div').css('display', 'none');
    });
</script>
<script>
    $(document).on('click', '#change_Image', function() {
        $("#ItemAttachments").css('display', 'block');
        $("#change_Image").css('display', 'none');
        $("#Image_Div").css('display', 'none');
        $('.image-previews').css('display', 'none');
        $('.actin-divs').css('display', 'none');
    });
</script>
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
            {
                $('#emptyError').html('<?php echo __dbt("You can not enter more then 1000 character."); ?>');
                valid = false;
            }

            return valid;
        });
        
        
        $(document).on('change','#NewsLanguage',function(){
            var other_lang = $(this).val();
            var news_id = "<?php echo (isset($this->request->data['News']['id'])?$this->request->data['News']['id']:'');?>";
            $.ajax({
                url:"/news/otherlang/",
                method:"post",
                data:{other_lang:other_lang,news_id:news_id},
                success:function(result){
                    
                    $('#contentForOtherLang').html(result);
                    $('#contentForOtherLang').css('display','block');
                    
                    for(var i=0;i<other_lang.length;i++){
                        var editorname = 'editor'+other_lang[i];
                        var editorid = 'hinNews'+other_lang[i];
                        CKEDITOR.replace(editorname);
                        //$('#'+editorname).val("<?php //echo Sanitize::stripTags(nl2br($this->request->data['HinNews']['description']), 'b', 'p', 'div');//strip_tags($this->request->data['HinNews']['description']);?>");
                        //$('#'+editorid).val("<?php //echo $this->request->data['HinNews']['id'];?>");
                    }
                }
            });
        });
    });

</script>