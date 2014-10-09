<?php
include_once("../functions/functions-in.php");

$ed = $_GET["ed"];
$t = "add";

if($ed) {
    $t = "edit";
    $a = mysql_query("SELECT * FROM `process` WHERE `id` = '$ed' LIMIT 1");
    $b = mysql_fetch_array($a);
}

$n = "$t-process";
?>
<form id="<? echo $n; ?>" action="javascript:sendForm('<? echo $n; ?>');">
    <h4><? echo ucwords($t); ?> Process</h4>
    <input type="hidden" name="id" value="<? echo $ed; ?>"/>

    <div class="form-title">Title<span class="req">*</span></div>
    <input type="text" name="title" class="required" value="<? echo $b["title"]; ?>">

    <div class="form-title">Description<span class="req">*</span></div>
    <textarea rows="7" name="description" style="height:100px;" class="redactor-text required">
        <? echo $b["description"]; ?>
    </textarea>

    <br>

    <div class="from-title">Process Featured Image (for best results use dimensions 300 x 205) <span class="req">*</span></div>
    <?php createUploader(10, 10, "jpg|jpeg|png|gif", ($ed ? false : true)); ?>

    <div class="form-title">Order (Please specify the order of process)</div>
    <input type="text" name="order" value="<? echo $b["order"]; ?>" class="number">

    <div class="console-button console-right" onclick="$('form#<? echo $n; ?>').submit();">
        <? echo ucwords($t); ?>
    </div>
</form>
<script type="text/javascript">
    $("form#<? echo $n; ?>").validate();

    var buttons = ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', '|', 'link', '|', 'alignment'];
    $('.redactor-text').redactor({
        buttons: buttons
    });
</script>