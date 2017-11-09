<?php if(!empty($other_lang)){?>
    <?php foreach ($other_lang as $other_lang){//pr($other_lang);
        $lcl = strtolower($other_lang['Pocale']['code']);
                $lcl = ucfirst($lcl)."News";
                $newsId = array();
                if(!empty($news_id))
                $newsId = $this->Common->findNewsId($lcl,array('id','description'),$news_id);
                //$newsDescription = $this->Common->findNewsId($lcl,'description',$news_id);
                echo $this->Form->input("$lcl.id",array('type'=>'hidden','value'=>(isset($newsId[$lcl]['id'])?$newsId[$lcl]['id']:''),'id' => 'hinNews'.$other_lang['Pocale']['code']));
        ?>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inputEmail3"><?php echo ($other_lang['Pocale']['name']); ?></label>
            <div class="col-sm-8">
                <?php 
                
                echo $this->Form->textarea("$lcl.description", array('id' => 'editor'.$other_lang['Pocale']['code'], 'class' => 'form-control', 'placeholder' => __dbt('Enter news description'), 'label' => false, 'autocomplete' => "off",'value'=>(isset($newsId[$lcl]['description'])?$newsId[$lcl]['description']:''))); ?>
                <span id="emptyError<?php echo $lcl;?>" ></span>
            </div>
        </div>
    <?php }?>
<?php }?>