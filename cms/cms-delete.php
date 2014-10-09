<?
// Impossibility CMS © 2011 Impossibility Inc
// File Delete V1.0

if(!session_id()) { session_start(); }

if($_SESSION["cms"] && $_GET["confirm"] && $_GET["file"]) {
	?>
	<h4>Confirm Deletion</h4>
	Are you sure you want to remove the file "<? echo $_GET["file"]; ?>"?
	<br/><br/>
	<a href="javascript:;" onclick="closeConsole();">No, Don't Delete.</a> &nbsp; | &nbsp; <a href="javascript:;" onclick="loadConsole('cms-delete.php?file=<? echo $_GET["file"]; ?>&go=true', 'cms/')">Yes, Please Delete.</a>
	<?

// If the call is for files
} else if($_SESSION["cms"] && $_GET["go"] && $_GET["file"]) {
	@unlink("../".$_GET["file"]);
	?>
	<h4>File Deleted</h4>
	<a href="javascript:;" onclick="closeConsole();">Close This</a>
	<script type="text/javascript">
		$("#cms-fileslist").load(anticache("cms/cms.php?action=fileslist"));
	</script>
	<?
}
?>