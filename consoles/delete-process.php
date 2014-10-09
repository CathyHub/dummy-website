<?php
include_once("../functions/functions-in.php");
$id = $_GET["id"];

$a = mysql_query("SELECT * FROM process WHERE id = '$id' LIMIT 1");

if($id && mysql_num_rows($a)) {
    $b = mysql_fetch_array($a);
?>
    <h4>Are Your Sure?</h4>
    You have requested to delete the process "<? echo $b["title"]; ?>"? Please confirm this is what you want to do.
    <br/><br/><br/>
    <b>What's next?</b> &nbsp; &nbsp; <a href="javascript:;" onclick="closeConsole();">No, Don't Delete.</a> &nbsp; | &nbsp; <a href="javascript:;" onclick="consoleAction('delete-process.php?id=<? echo $id; ?>')">Yes, Please Delete.</a>
<?php
} else {
?>
    <h4>Could not find item to delete.</h4>
    <b>What's next?</b> &nbsp; &nbsp; <a href="javascript:;" onclick="closeConsole();">Close This.</a> &nbsp; | &nbsp; <a href="javascript:;" onclick="loadConsole('delete-process.php?id=<? echo $id; ?>');">Try Again.</a>
<?php
}
?>