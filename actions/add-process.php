<?php
include_once("../functions/functions-in.php");

extract($_POST);

if($title && $description) {
    $phptime = time();
    // $slug = generateSlug($title, 60);
    mysql_query("INSERT INTO process(`title`, `description`, `order`, `date_added`) VALUES('$title', '$description', '$order', '$phptime')") or die(mysql_error());
    $process_id = mysql_insert_id();

    mysql_query("INSERT INTO process_images(`process_id`, `order`) VALUES('$process_id', '999')") or die(mysql_error());

    if($ufile1) {
        $nd = "../storage/process-images/$process_id/";
        createDir($nd);

        $dire = "../storage/temp/$upload1/";
        if ($handle = opendir($dire)) {
            while (false !== ($file = readdir($handle))) {
                if (!is_dir($dire.$file)) {
                    $ext = strtolower(substr($file, strrpos($file, ".")));
                    cropAndResize($dire.$file, 300, 205, $nd."process-feature-image".$ext);
                    mysql_query("UPDATE `process` SET `image_ext` = '$ext' WHERE `id` = '$process_id'");
                    mysql_query("UPDATE `process_images` SET `image_ext` = '$ext' WHERE `process_id` = '$process_id'");
                }
            }
        }
        removeDir($dire);
    }

    ?>
    <h4>Process Added</h4>
    <b>What's next?</b> &nbsp; &nbsp; <a href="javascript:;" onclick="closeConsole();">Close This</a> &nbsp; | &nbsp; <a href="javascript:;" onclick="loadConsole('add-process.php');">Add More process</a>
    <script type="text/javascript">
        window.location.reload();
    </script>
    <?php
} else {
    ?>
    <h4>Failed To Add Process</h4>
    <b>What's next?</b> &nbsp; &nbsp; <a href="javascript:;" onclick="closeConsole();">Close This</a> &nbsp; | &nbsp; <a href="javascript:;" onclick="loadConsole('add-process.php');">Try Again</a>
    <?php
}
?>