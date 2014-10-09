<?
// iCMS - Big Picture Group
// Operations V2.2

$mcms = array();

$mcms["pageFull"] = $_SERVER['PHP_SELF'];
$mcms["page"] = substr($mcms["pageFull"], strrpos($mcms["pageFull"], "/")+1);
$mcms["site"] = (substr($_SERVER["SERVER_NAME"],0,4)=="www." ? substr($_SERVER["SERVER_NAME"],4) : $_SERVER["SERVER_NAME"]);

require_once("config.php");

if(!session_id()) { session_start(); }

$mcms["loggedin"] = $_SESSION["cms"];

// If call is a curl request
if($_GET["curlp"]) {
	$p = $_GET["curlp"];
	$vars = "";
	foreach($_GET as $k => $v) {
		if($k != "curlp") {
			$vars .= "&$k=".urlencode($v);
		}
	}
	foreach($_POST as $k => $v) {
		if($k != "curlp") {
			$vars .= "&$k=".urlencode($v);
		}
	}
	$cs = curl_init("http$sec://cms.emotedigital.com.au/$p");
	curl_setopt($cs, CURLOPT_POST, 1);
	curl_setopt($cs, CURLOPT_POSTFIELDS, $vars);
	curl_exec($cs);
	curl_close($cs);

// If the call is to login
} else if($_GET["action"] == "login") {
	$u = strtolower($_POST["username"]);
	$p = strtolower($_POST["password"]);

	if ($u == $mcms["username"] && $p == $mcms["password"]) {
		$_SESSION["cms"] = true;
		if($_POST["remember"]) {
			setcookie("user", $u, time() + 2500000, "/");
		}
		?>
		<h4>Logged In</h4>
		<b>Please wait...</b> &nbsp; &nbsp; If you're not automatically redirected please <a href="./">click here</a>.
		<script type="text/javascript">
			t = setTimeout("window.location.reload();", 1000);
		</script>
		<?
	} else {
		?>
		<h4>Your username and/or password was incorrect</h4>
		<b>What's next?</b> &nbsp; &nbsp; <a href="javascript:;" onclick="loadConsole('login.php');">Try Again</a>
		<?
	}

// If the call is to logout
} else if($_GET["action"] == "logout") {
	session_destroy();
	?>
	<h4>Logged Out</h4>
	<b>Please wait...</b> &nbsp; &nbsp; If you're not automatically redirected please <a href="./">click here</a>.
	<script type="text/javascript">
		t = setTimeout("window.location = './';", 1000);
	</script>
	<?

// If the call is for files
} else if($_GET["action"] == "fileslist") {
	$url = "http$sec://cms.emotedigital.com.au/cms/cms-filelist.php";

	// Set Directory + Vars
	$dire = "../storage/cms-files/";
	$files = array();

	if(file_exists($dire)) {
		// Find + Insert Files
		if ($handle = opendir($dire)) {
			while (false !== ($file = readdir($handle))) {
				if (!is_dir($dire.$file)) {
					$ext = strtolower(substr($file, strrpos($file, ".")));
					$content = $nd.time().rand(1,99).$ext;
					copy($dire.$file, $content);
					array_push($files, "storage/cms-files/$file");
				}
			}
		}
	}

	foreach($files as $key=>$value) { $mcms_set .= $key.'='.urlencode($value).'&'; }
	rtrim($mcms_set,'&');
	$ch = curl_init();

	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_POST,count($files));
	curl_setopt($ch,CURLOPT_POSTFIELDS,$mcms_set);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$mcms_data_orig = curl_exec($ch);

	curl_close($ch);

	echo $mcms_data_orig;

// If the call is none of the above
} else {
	$url = "http$sec://cms.emotedigital.com.au/cms/cms-package.php";

	foreach($mcms as $key=>$value) { $mcms_set .= $key.'='.urlencode($value).'&'; }
	rtrim($mcms_set,'&');
	$ch = curl_init();

	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_POST,count($mcms));
	curl_setopt($ch,CURLOPT_POSTFIELDS,$mcms_set);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$mcms_data_orig = curl_exec($ch);

	$mcms_data_s2 = explode("~---|*|---~", $mcms_data_orig);
	foreach($mcms_data_s2 as $item) {
		$items = explode("~-*|*-~", $item);
		$mcms_data[$items[0]] = $items[1];
	}
	curl_close($ch);

	function cms_head() {
		global $mcms_data;
		echo $mcms_data["cms-head"];
	}

	function cms_init() {
		global $mcms_data;
		echo $mcms_data["cms-init"];
	}

	function cms($id) {
		global $mcms_data;
		global $mcms;
		?>
		<div id="cms-ele-<? echo $id; ?>" class="cms-ele">
			<? echo $mcms_data[$id]; ?>
		</div>
		<?
		if(!$mcms_data[$id] && $mcms["loggedin"]) {
			?>
			<script type="text/javascript">
				updateElementCMS("<? echo $id; ?>");
			</script>
			<?
		}
	}
}
?>