<?php
include_once("../functions/functions-in.php");
include_once("../functions/gd-images.php");

extract($_POST);

if($title && $description && $id) {

    mysql_query("UPDATE `process` SET `title` = '$title', `description` = '$description', `order` = '$order' WHERE id = '$id' LIMIT 1") or die(mysql_error());

    if($ufile1) {
        $nd = "../storage/process-images/$id/";
        createDir($nd);

        $dire = "../storage/temp/$upload1/";
        if ($handle = opendir($dire)) {
            while (false !== ($file = readdir($handle))) {
                if (!is_dir($dire.$file)) {
                    $ext = strtolower(substr($file, strrpos($file, ".")));
                    cropAndResize($dire.$file, 300, 205, $nd."process-feature-image".$ext);
                    mysql_query("UPDATE `process` SET `image_ext` = '$ext' WHERE `id` = '$id'");
                    mysql_query("UPDATE `process_images` SET `image_ext` = '$ext' WHERE `process_id` = '$id'");
                }
            }
        }
        removeDir($dire);
    }
    ?>
    <h4>Process Edited</h4>
    <b>What's next?</b> &nbsp; &nbsp; <a href="javascript:;" onclick="closeConsole();">Close This</a>
    <script type="text/javascript">
        window.location.reload();
    </script>
    <?php
} else {
    ?>
    <h4>Failed To Edit Process</h4>
    <b>What's next?</b> &nbsp; &nbsp; <a href="javascript:;" onclick="closeConsole();">Close This</a> &nbsp; | &nbsp; <a href="javascript:;" onclick="loadConsole('add-process.php?ed=<?= $id; ?>');">Try Again</a>
    <?php
}
?>