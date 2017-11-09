<div id="<?php echo h($key) ?>Message"><div class="message error" ><?php echo h($message) ?><span onclick="closeMessage(this);">&nbsp;</span></div></div>
<style>
.message.error span:after {
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