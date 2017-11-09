<?php
?>

<script>
    $(document).ready(function(){
        $("#chk").click(function(){
            $("input[type=checkbox]").prop("checked", !$("input[type=checkbox]").prop("checked"));
        });
    });
</script>
 <section class="grey_container">
                    	<h1 class="new_padd"></h1>
			<section class="grey_container_info">
<section class="fl_rt">
<?php
echo $this->Form->create('Section');

echo $this->Form->input('Section.role_id',array('type'=>'select','div'=>'false', "label"=>false, 'options'=>$roles ,'class'=>'select'));
?>
</section>
 <section class="table_data">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabulardata">
    <tr>
        <th><?php echo $this->Paginator->sort("id","Sr.No"); ?></th>
        <th><?php echo $this->Paginator->sort("SectionList.name","Name"); ?></th>
        <th><?php echo $this->Paginator->sort("SectionList.","Controller Name"); ?></th>
        <th><?php echo $this->Paginator->sort("SectionList.action","Method Name"); ?></th>
        <th><span id="tggl"><p id="chk">Check/Un-check All</p></span></th>
    </tr>
<?php
foreach($Section as $memcat){
    $string = $memcat['SectionList']['action'];
    if(strpos($memcat['SectionList']['action'], "admin_")===0){
        $route = explode('admin_', $string);
        $action = $route['1'];
        $prefix = 'admin';
    }
    else if(strpos($memcat['SectionList']['action'], "sports_")===0){
        $route = explode('sports_', $string);
        $action = $route['1'];
        $prefix = 'sports';        
    }
    else if(strpos($memcat['SectionList']['action'], "league_")===0){
        $route = explode('league_', $string);
        $action = $route['1'];
        $prefix = 'league';        
    }
    else if(strpos($memcat['SectionList']['action'], 'team_')===0){
        $route = explode('team_', $string);
        $action = $route['1'];
        $prefix = 'team';
    }
    else if(strpos($memcat['SectionList']['action'], 'blogger_')===0){
        $route = explode('blogger_', $string);
        $action = $route['1'];
        $prefix = 'blogger';
    }
    else{
        $action = $memcat['SectionList']['action'];
        $prefix = false;     
    }
    echo "<tr>
            <td>
                ".$memcat['SectionList']['id']."
            </td>
            <td>
                ".$memcat['SectionList']['name']."<br><span style='color:green;'>";
                if($prefix != false){
                echo 'https://'.$_SERVER['HTTP_HOST'].Router::url(array($prefix=>true,'controller'=>$memcat['SectionList']['controller'], 'action'=>$action));
                }else{
                echo 'https://'.$_SERVER['HTTP_HOST'].Router::url(array('admin'=>false,'controller'=>$memcat['SectionList']['controller'], 'action'=>$action)); }
            echo "
            </td>
            <td>
                ".$memcat['SectionList']['controller']."
            </td>
            <td>
                ".$memcat['SectionList']['action']."
            </td>            
            <td>
                <input type='checkbox' name='data[Section][section_list_id][]' id='SectionSectionListID' value='".$memcat['Section']['id']."'>
            </td>            
        </tr>";
}
echo "</table>"."</section>";?>
<section class="fl_rt" style="margin-top:1%;">
<?php echo $this->Form->submit('Allow',array('class'=>'button'));?>
</section>
<?php echo $this->Form->end();
echo $this->element('pagination',array('paging_action'=>'/admin/sections/allowAccess')); ?>
 </section></section>
 </section>