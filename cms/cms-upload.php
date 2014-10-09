<?
// Impossibility CMS © 2011 Impossibility Inc
// Uploader V1.2

// Functions
function createDir($d) {
	$da = explode("/", $d);
	$dir = "";
	foreach($da as $di) {
		$dir .= "$di/";
		if(!file_exists($dir)) {
			mkdir($dir, 0777);
		}
	}
}

// Variables
$upload = $_GET["u"];
$type = $_GET["t"];

// Set + Create Directories
$dire = "../storage/temp/$upload/";
$nd = "../storage/cms-".$type."s/";
createDir($nd);

// Find + Insert Files
$files = "";
if ($handle = opendir($dire)) { 
	while (false !== ($file = readdir($handle))) {
		if (!is_dir($dire.$file)) {
			$ext = strtolower(substr($file, strrpos($file, ".")));
			if($type == "image") {
				$content = $nd.time().rand(1,99).$ext;
			} else {
				$content = $nd.$file;
			}
			copy($dire.$file, $content);
			unlink($dire.$file);
			$files .= "storage/cms-".$type."s/$file<br/>";
		}
	}
	rmdir($dire);
}

// Do Final Uploads
if($type == "image") {
	?>
	<img src="<? echo substr($content,3); ?>" alt="" class="cms-img-upload" />
	<script type="text/javascript">
		$("#cms_content").val("<? echo substr($content,3); ?>");
	</script>
	<? 
} else if($type == "file") {
	?>
	<br/>
	<b>Just Uploaded</b><br/>
	<?
	echo $files;
}
?>