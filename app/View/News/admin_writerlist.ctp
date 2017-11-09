<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo __dbt('News'); ?>
        <small><?php echo __dbt('List Writer'); ?></small>
    </h1>
    <?php echo $this->element($elementFolder . '/breadcrumb'); ?>

</section>
<?php 

foreach($new as $writer_option)
{
    $user[$writer_option['User']['id']]=$writer_option['User']['name'];
    
}

?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <!-- filters starts-->
                    <div class="UserAdminIndexForm">
                        <div class="box-body">	
                            <div class="row">
                              <?php  echo $this->Form->create('News', array('type' => 'get', 'url' => array('controller' => 'News', 'action' => 'writerlist', $this->params["prefix"] => true), "novalidate"=>"novalidate")); ?>
                               <?php echo "<div class='col-xs-3'>". $this->Form->input("News.user_id", array("label"=>false, "placeholder"=>"Search by Name", "div"=>false,'empty'=>'Select Name', 'options' => @$user,'class'=>"form-control"))."</div>"; ?>
                               
                                <div class='col-xs-3 admin-search-btn'>
                                    <input type="submit" class="btn bg-olive margin" value="Search">    
                                    <a href="<?php echo $this->here; ?>" class="btn btn-warning" ><?php echo __dbt('Reset'); ?></a>
                                </div>  
                               
                               
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>	   
                    </div>
                </div>
                <div style="clear:both;"></div>
                <!-- filters ends-->
                <div class="box-body">
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>      
                                <th><?php echo $this->Paginator->sort('Users.name', 'Name'); ?></th>
                                <th><?php echo $this->Paginator->sort('Nums', 'Number of news'); ?></th>
                                <th class="actions"><?php echo __dbt('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($writerdata)) { //pr($writerdata);die;
                                foreach ($writerdata as $writerdata):
                                   // if (($writerdata['News']['status'] == AuthComponent::user('id') && $news['News']['user_id'] != AuthComponent::user('id') ) || ($news['News']['user_id'] == AuthComponent::user('id'))) {
                                        ?>
                                        <tr>
                                            
                                            <td><?php echo h($writerdata['Users']['name']); ?>&nbsp;</td>
                                            <td><?php echo h($writerdata['0']['Nums']); ?>&nbsp;</td>
                                           
                                            
                                            <td class="actions">
                                                <?php echo $this->Html->link(__dbt(''), array('action' => 'newsDetails', base64_encode($writerdata['Users']['id'])), array('class' => 'fa fa-eye', 'title' => 'View News')); ?></td>
                                             

                                       
                                                    
                                            </td>

                                        </tr>
                                    <?php //} 
                                    endforeach;
                                    //echo $this->element('admin/legends');
                            } else { ?>
                                <tr>    
                                    <td class="text-center" colspan="5"><?php echo __dbt('No result found.'); ?>&nbsp;</td>
                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                            </div>
                        </div>
                        <div class="col-sm-7">
<?php echo $this->element('pagination', array('paging_action' => $this->here)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).on('click', '.change-status', function () {
        var newsId = $(this).attr("data-uri");
        var value = $(this).attr("data-value");
        var sportId = $(this).attr("data-sport");
        var sid = $(this).attr('id');

        var url = "<?php echo $this->Html->url(array("controller" => "News", "action" => "changeToTopNews", $this->params["prefix"] => true)); ?>/";
        $.post(url, {id: newsId, value: value, sportId: sportId}, function (data) {
            if (data == 'saved')
            {
                if (value == 1) {
                    $('#' + sid).replaceWith('<a id="' + sid + '" data-uri="' + newsId + '"  data-value="0" data-sport="' + sportId + '" href="javascript:void(0)" class="change-status fa fa-star" title="Set Normal News"></a>');
                } else {
                    $('#' + sid).replaceWith('<a id="' + sid + '" data-uri="' + newsId + '"  data-value="1" data-sport="' + sportId + '" href="javascript:void(0)" class="change-status fa fa-arrow-up" title="Set Top News"></a>');
                }

            } else if (data == 2)
            {
                alert('You cannot create more than 2 top news for a category.');
            } else {
                alert('News status not changed! Please, try again');
            }

        });


    });
    $(document).on('click', '.change-addedby', function () {
        var newsId = $(this).attr("data-uri");
        var value = $(this).attr("data-value");
        var sid = $(this).attr('id');

        var url = "<?php echo $this->Html->url(array("controller" => "News", "action" => "changeToAddedBy", $this->params["prefix"] => true)); ?>/";
        $.post(url, {id: newsId, value: value}, function (data) {
            if (data == 'unpublish')
            {

                $('#' + sid).replaceWith('<a id="' + sid + '" data-uri="' + newsId + '"  data-value="0" href="javascript:void(0)" class="change-addedby fa fa-power-off" title="publish News"></a>');
            } else {
                $('#' + sid).replaceWith('<a id="' + sid + '" data-uri="' + newsId + '"  data-value="1" href="javascript:void(0)" class="change-addedby fa fa-th" title="Unpublish News"></a>');
            }



        });


    });
</script>