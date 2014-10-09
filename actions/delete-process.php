<?php
include_once("../functions/functions-in.php");
$id = $_GET["id"];

if($id) {
    mysql_query("DELETE FROM `process_images` WHERE `process_id` = '$id' LIMIT 1");
    mysql_query("DELETE FROM `process` WHERE `id` = '$id' LIMIT 1");
    $dire = "../storage/process-images/$id/";
    if(file_exists($dire)) {
        removeDir($dire);
    }
    ?>
    <h4>Process Deleted</h4>
    <b>What's next?</b> &nbsp; &nbsp; <a href="javascript:;" onclick="closeConsole();">Close This</a>
    <script type="text/javascript">
        window.location.reload();
    </script>
    <?php
} else {
    ?>
    <h4>Failed To Delete Process</h4>
    <b>What's next?</b> &nbsp; &nbsp; <a href="javascript:;" onclick="closeConsole();">Close This</a> &nbsp; | &nbsp; <a href="javascript:;" onclick="consoleAction('delete-process.php?id=<?= $id ?>');">Try Again</a>
    <?php
}
?>