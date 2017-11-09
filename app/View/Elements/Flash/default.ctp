<?php
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
?>
<div id="<?php echo h($key) ?>Message"><div class="<?php echo h($class) ?> normal-message"><?php echo h($message) ?><span onclick="closeMessage(this);">&nbsp;</span></div></div>

<style>
.normal-message span:after {
    content: "\2612";
    float: right;
    cursor:pointer;
}
</style>
<script>
    function closeMessage(obj){
        var jQ = $(obj);
        jQ.parent().remove();
    }
</script>