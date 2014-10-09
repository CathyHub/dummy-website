<?php
// PHP FUNCTIONS 2.0
// 3/10/2008
// © Jason Stockton 2008
// PHP 5+ ONLY

// CHECK BROWSER
$useragent = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('|MSIE ([0-6].[0-9]{1,2})|',$useragent,$matched)) {
	$IE6 = true;
} else {
	$IE6 = false;
}
if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
	$IE = true;
} else {
	$IE = false;
}

if (preg_match('|MSIE ([0-8].[0-9]{1,2})|',$useragent,$matched)) {
	$IE8 = true;
} else {
	$IE8 = false;
}

// SET TIMEZONE
date_default_timezone_set("Australia/Sydney");
$date = date('d/m/Y');
$dateFormat = date('Ymd');
$time = date('H:i:s');
$phptime = time();

$ip = $_SERVER['REMOTE_ADDR'];

$unique = substr(md5($ip.microtime()), 0, 15).rand(1000, 9999);

// BR
function br($val) {
	return str_replace("\n", " <br/>", $val);
}

// GENERATE SLUG FROM STRING
if(!function_exists("generateSlug")) {
	function generateSlug($phrase, $maxLength = 100) {
	    $result = strtolower($phrase);
	    $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
	    $result = trim(preg_replace("/[\s-]+/", " ", $result));
	    $result = trim(substr($result, 0, $maxLength));
	    $result = preg_replace("/\s/", "-", $result);
	    return $result;
	}
}

// CURRENT PAGE
function url() {
	$pageURL = "http";
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
$pageFull = $_SERVER['PHP_SELF'];
$urlFull = url();
$page = substr($pageFull, strrpos($pageFull, "/")+1);
$urlDir = substr($urlFull, 0, strrpos($urlFull, "/"));

// Create Directory
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

// Remove Directory
function removeDir($dir) {
    $structure = glob(rtrim($dir, "/").'/*');
    if (is_array($structure)) {
        foreach($structure as $file) {
            if (is_dir($file)) removeDir($file);
            elseif (is_file($file)) unlink($file);
        }
    }
    rmdir($dir);
}

function dir_check($file) {
	if(file_exists($file)) {
		return $file;
	} else if(file_exists("../".$file)) {
		return "../".$file;
	} else if(file_exists("../../".$file)) {
		return "../../".$file;
	} else if(file_exists("../../../".$file)) {
		return "../../../".$file;
	} else if(file_exists("../../../../".$file)) {
		return "../../../../".$file;
	} else {
		return false;
	}
}

// Create Uploader 
$uploader_num = 0;
function createUploader($filesize, $filenum, $ext, $req = false) {
	global $unique;
	global $uploader_num;
	$uploader_num++;
	?>
	<div id="up-but<? echo $uploader_num; ?>" class="up-but">
		<div class="console-button" onclick="showUploader('<? echo $unique.$uploader_num; ?>', 'storage/temp', <? echo $filesize; ?>, <? echo $filenum; ?>, '<? echo $ext; ?>', 'setUploaded<? echo $uploader_num; ?>();');">
			Upload
		</div>
	</div>
	<div id="up-com<? echo $uploader_num; ?>" class="form-text up-com">
		Image(s) Uploaded
	</div>
	<input type="hidden" name="upload<? echo $uploader_num; ?>" value="<? echo $unique.$uploader_num; ?>" />
	<input type="hidden" name="ufile<? echo $uploader_num; ?>" id="ufile<? echo $uploader_num; ?>"<? if($req) { ?> class="required"<? } ?> />
	<script type="text/javascript">
		function setUploaded<? echo $uploader_num; ?>() {
			$("#ufile<? echo $uploader_num; ?>").val("1");
			$("#up-but<? echo $uploader_num; ?>").hide();
			$("#up-com<? echo $uploader_num; ?>").show();
		}
	</script>
	<?
}

function date_form($name, $s_y, $e_y, $d="", $m="", $y="") {
	?>
	<select name="<? echo $name; ?>_day" class="main-input" style="display:inline; width:75px;">
		<option value="">DD</option>
		<? for($i=1; $i<=31; $i++) {
			$r = $i;
			if($i < 10) {
				$r = "0".$i;
			}
		?>
		<option value="<? echo $i; ?>" <? if($d && $r == $d) { ?>selected="selected"<? } ?>><? echo $r; ?></option>
		<? } ?>
	</select>
	<select name="<? echo $name; ?>_month" class="main-input" style="display:inline; width:75px;">
		<option value="">MM</option>
		<? for($i=1; $i<=12; $i++) {
			$r = $i;
			if($i < 10) {
				$r = "0".$i;
			}
		?>
		<option value="<? echo $i; ?>" <? if($m && $r == $m) { ?>selected="selected"<? } ?>><? echo $r; ?></option>
		<? } ?>
	</select>
	<select name="<? echo $name; ?>_year" class="main-input" style="display:inline; width:100px;">
		<option value="">YYYY</option>
		<? 
		if($s_y < $e_y) {
			for($i=$s_y; $i<=$e_y; $i++) { ?>
			<option value="<? echo $i; ?>" <? if($y && $i == $y) { ?>selected="selected"<? } ?>><? echo $i; ?></option>
		<? 	}
		} else  {
			for($i=$s_y; $i>=$e_y; $i--) { ?>
			<option value="<? echo $i; ?>" <? if($y && $i == $y) { ?>selected="selected"<? } ?>><? echo $i; ?></option>
		<? 	}
		} ?>
	</select>
	<?
}

// TIME AGO
function timeAgo($ptime) {
	$time = time() - $ptime;
	if($time < 1) { $time = 1; }
	if ($time < 60) {
		echo "Just now";
	} elseif ($time < 3600) {
		$a = floor($time/60);
		if($a > 1) {
			$s = "s";
		}
		echo "$a minute$s ago";
	} elseif ($time < 86400) {
		$a = floor($time/3600);
		if($a > 1) {
			$s = "s";
		}
		echo "$a hour$s ago";
	} elseif ($time < 2592000) {
		$a = floor($time/86400);
		if($a > 1) {
			$s = "s";
		}
		echo "$a day$s ago";
	} elseif ($time < 31536000) {
		$a = floor($time/2592000);
		if($a > 1) {
			$s = "s";
		}
		echo "$a month$s ago";
	} else {
		$a = floor($time/31536000);
		if($a > 1) {
			$s = "s";
		}
		echo "$a year$s ago";
	}
}

// CONVERT SIZE
function convertSize($s, $e=0) {
	if($s < 1024) {
		$ns = $s;
		if($e) {
			$ns .= "b";
		}
	} elseif($s < 1048576) {
		$ns = ceil($s/1024);
		if($e) {
			$ns .= "kb";
		}
	} elseif($s < 1073741824) {
		$ns = round($s/1048576,2);
		if($e) {
			$ns .= "mb";
		}
	} else {
		$ns = round($s/1073741824);
		if($e) {
			$ns .= "gb";
		}
	}
	return $ns;
}

// SUB WORDS
function subStrWord($text, $start, $count) {
	if(strlen($text) > $count - $start) {
		$edited = substr($text, $start, $count);
		$editedPos = strrpos($edited, " ");
		return str_replace("\"", "'", substr($edited, 0, $editedPos)."...");
	} else {
		return str_replace("\"", "'", $text);
	}
}

$countries = array("Afghanistan" ,"Albania" ,"Algeria" ,"American Samoa" ,"Andorra" ,"Angola" ,"Anguilla" ,"Antigua &amp; Barbuda" ,"Argentina" ,"Armenia" ,"Aruba" ,"Australia" ,"Austria" ,"Azerbaijan" ,"Bahamas" ,"Bahrain" ,"Bangladesh" ,"Barbados" ,"Belarus" ,"Belgium" ,"Belize" ,"Benin" ,"Bermuda" ,"Bhutan" ,"Bolivia" ,"Bonaire" ,"Bosnia &amp; Herzegovina" ,"Botswana" ,"Brazil" ,"British Indian Ocean Ter" ,"Brunei" ,"Bulgaria" ,"Burkina Faso" ,"Burundi" ,"Cambodia" ,"Cameroon" ,"Canada" ,"Canary Islands" ,"Cape Verde" ,"Cayman Islands" ,"Central African Republic" ,"Chad" ,"Channel Islands" ,"Chile" ,"China" ,"Christmas Island" ,"Cocos Island" ,"Colombia" ,"Comoros" ,"Congo" ,"Cook Islands" ,"Costa Rica" ,"Cote D'Ivoire" ,"Croatia" ,"Cuba" ,"Curacao" ,"Cyprus" ,"Czech Republic" ,"Denmark" ,"Djibouti" ,"Dominica" ,"Dominican Republic" ,"East Timor" ,"Ecuador" ,"Egypt" ,"El Salvador" ,"Equatorial Guinea" ,"Eritrea" ,"Estonia" ,"Ethiopia" ,"Falkland Islands" ,"Faroe Islands" ,"Fiji" ,"Finland" ,"France" ,"French Guiana" ,"French Polynesia" ,"French Southern Ter" ,"Gabon" ,"Gambia" ,"Georgia" ,"Germany" ,"Ghana" ,"Gibraltar" ,"Great Britain" ,"Greece" ,"Greenland" ,"Grenada" ,"Guadeloupe" ,"Guam" ,"Guatemala" ,"Guinea" ,"Guyana" ,"Haiti" ,"Hawaii" ,"Honduras" ,"Hong Kong" ,"Hungary" ,"Iceland" ,"India" ,"Indonesia" ,"Iran" ,"Iraq" ,"Ireland" ,"Isle of Man" ,"Israel" ,"Italy" ,"Jamaica" ,"Japan" ,"Jordan" ,"Kazakhstan" ,"Kenya" ,"Kiribati" ,"Korea North" ,"Korea South" ,"Kuwait" ,"Kyrgyzstan" ,"Laos" ,"Latvia" ,"Lebanon" ,"Lesotho" ,"Liberia" ,"Libya" ,"Liechtenstein" ,"Lithuania" ,"Luxembourg" ,"Macau" ,"Macedonia" ,"Madagascar" ,"Malaysia" ,"Malawi" ,"Maldives" ,"Mali" ,"Malta" ,"Marshall Islands" ,"Martinique" ,"Mauritania" ,"Mauritius" ,"Mayotte" ,"Mexico" ,"Midway Islands" ,"Moldova" ,"Monaco" ,"Mongolia" ,"Montserrat" ,"Morocco" ,"Mozambique" ,"Myanmar" ,"Nambia" ,"Nauru" ,"Nepal" ,"Netherland Antilles" ,"Netherlands (Holland, Europe)" ,"Nevis" ,"New Caledonia" ,"New Zealand" ,"Nicaragua" ,"Niger" ,"Nigeria" ,"Niue" ,"Norfolk Island" ,"Norway" ,"Oman" ,"Pakistan" ,"Palau Island" ,"Palestine" ,"Panama" ,"Papua New Guinea" ,"Paraguay" ,"Peru" ,"Philippines" ,"Pitcairn Island" ,"Poland" ,"Portugal" ,"Puerto Rico" ,"Qatar" ,"Republic of Montenegro" ,"Republic of Serbia" ,"Reunion" ,"Romania" ,"Russia" ,"Rwanda" ,"St Barthelemy" ,"St Eustatius" ,"St Helena" ,"St Kitts-Nevis" ,"St Lucia" ,"St Maarten" ,"St Pierre &amp; Miquelon" ,"St Vincent &amp; Grenadines" ,"Saipan" ,"Samoa" ,"Samoa American" ,"San Marino" ,"Sao Tome &amp; Principe" ,"Saudi Arabia" ,"Senegal" ,"Seychelles" ,"Sierra Leone" ,"Singapore" ,"Slovakia" ,"Slovenia" ,"Solomon Islands" ,"Somalia" ,"South Africa" ,"Spain" ,"Sri Lanka" ,"Sudan" ,"Suriname" ,"Swaziland" ,"Sweden" ,"Switzerland" ,"Syria" ,"Tahiti" ,"Taiwan" ,"Tajikistan" ,"Tanzania" ,"Thailand" ,"Togo" ,"Tokelau" ,"Tonga" ,"Trinidad &amp; Tobago" ,"Tunisia" ,"Turkey" ,"Turkmenistan" ,"Turks &amp; Caicos Is" ,"Tuvalu" ,"Uganda" ,"Ukraine" ,"United Arab Emirates" ,"United Kingdom" ,"United States of America" ,"Uruguay" ,"Uzbekistan" ,"Vanuatu" ,"Vatican City State" ,"Venezuela" ,"Vietnam" ,"Virgin Islands (Brit)" ,"Virgin Islands (USA)" ,"Wake Island" ,"Wallis &amp; Futana Is" ,"Yemen" ,"Zaire" ,"Zambia" ,"Zimbabwe");

// CREATE SELECT OPTIONS
function createSelOptions($ops, $sel="") {
	foreach($ops as $op) { ?>
		<option value="<? echo $op; ?>"<? if($op == $sel) { ?> selected="true"<? } ?>><? echo $op; ?></option>
	<? } 
}

// Add Uploader
function uploader($maxsize=10, $maxfiles=1, $ext=0, $required=0, $id="") {
	global $unique;
	?>
	<div id="up-but<? echo $id; ?>" class="up-but">
		<div class="console-button" onclick="showUploader('<? echo $unique.$id; ?>', 'storage/temp', <? echo $maxsize; ?>, <? echo $maxfiles; ?>, '<? echo $ext; ?>', 'setUploaded<? echo $id; ?>();');">
			Upload
		</div>
	</div>
	<div id="up-com<? echo $id; ?>" class="up-com" class="form-text">
		Images Uploaded
	</div>
	<input type="hidden" name="upload<? echo $id; ?>" value="<? echo $unique.$id; ?>" />
	<input type="hidden" name="ufile<? echo $id; ?>" id="ufile<? echo $id; ?>" <? if($required) { ?>class="required"<? } ?> />
	<script type="text/javascript">
		function setUploaded<? echo $id; ?>() {
			$("#ufile<? echo $id; ?>").val("1");
			$("#up-but<? echo $id; ?>").hide();
			$("#up-com<? echo $id; ?>").show();
		}
	</script>
	<?
}

// -----------------------------------------------------------------------

// AES
function Cipher($input, $w) { $Nb = 4; $Nr = count($w)/$Nb - 1; $state = array(); for ($i=0; $i<4*$Nb; $i++) $state[$i%4][floor($i/4)] = $input[$i]; $state = AddRoundKey($state, $w, 0, $Nb); for ($round=1; $round<$Nr; $round++) { $state = SubBytes($state, $Nb); $state = ShiftRows($state, $Nb); $state = MixColumns($state, $Nb); $state = AddRoundKey($state, $w, $round, $Nb); } $state = SubBytes($state, $Nb); $state = ShiftRows($state, $Nb); $state = AddRoundKey($state, $w, $Nr, $Nb); $output = array(4*$Nb); for ($i=0; $i<4*$Nb; $i++) $output[$i] = $state[$i%4][floor($i/4)]; return $output; } function AddRoundKey($state, $w, $rnd, $Nb) { for ($r=0; $r<4; $r++) { for ($c=0; $c<$Nb; $c++) $state[$r][$c] ^= $w[$rnd*4+$c][$r]; } return $state; } function SubBytes($s, $Nb) { global $Sbox; for ($r=0; $r<4; $r++) { for ($c=0; $c<$Nb; $c++) $s[$r][$c] = $Sbox[$s[$r][$c]]; } return $s; } function ShiftRows($s, $Nb) { $t = array(4); for ($r=1; $r<4; $r++) { for ($c=0; $c<4; $c++) $t[$c] = $s[$r][($c+$r)%$Nb]; for ($c=0; $c<4; $c++) $s[$r][$c] = $t[$c]; } return $s; } function MixColumns($s, $Nb) { for ($c=0; $c<4; $c++) { $a = array(4); $b = array(4); for ($i=0; $i<4; $i++) { $a[$i] = $s[$i][$c]; $b[$i] = $s[$i][$c]&0x80 ? $s[$i][$c]<<1 ^ 0x011b : $s[$i][$c]<<1; } $s[0][$c] = $b[0] ^ $a[1] ^ $b[1] ^ $a[2] ^ $a[3]; $s[1][$c] = $a[0] ^ $b[1] ^ $a[2] ^ $b[2] ^ $a[3]; $s[2][$c] = $a[0] ^ $a[1] ^ $b[2] ^ $a[3] ^ $b[3]; $s[3][$c] = $a[0] ^ $b[0] ^ $a[1] ^ $a[2] ^ $b[3]; } return $s; } function KeyExpansion($key) { global $Rcon; $Nb = 4; $Nk = count($key)/4; $Nr = $Nk + 6; $w = array(); $temp = array(); for ($i=0; $i<$Nk; $i++) { $r = array($key[4*$i], $key[4*$i+1], $key[4*$i+2], $key[4*$i+3]); $w[$i] = $r; } for ($i=$Nk; $i<($Nb*($Nr+1)); $i++) { $w[$i] = array(); for ($t=0; $t<4; $t++) $temp[$t] = $w[$i-1][$t]; if ($i % $Nk == 0) { $temp = SubWord(RotWord($temp)); for ($t=0; $t<4; $t++) $temp[$t] ^= $Rcon[$i/$Nk][$t]; } else if ($Nk > 6 && $i%$Nk == 4) { $temp = SubWord($temp); } for ($t=0; $t<4; $t++) $w[$i][$t] = $w[$i-$Nk][$t] ^ $temp[$t]; } return $w; } function SubWord($w) { global $Sbox; for ($i=0; $i<4; $i++) $w[$i] = $Sbox[$w[$i]]; return $w; } function RotWord($w) { $tmp = $w[0]; for ($i=0; $i<3; $i++) $w[$i] = $w[$i+1]; $w[3] = $tmp; return $w; } $Sbox = array(0x63,0x7c,0x77,0x7b,0xf2,0x6b,0x6f,0xc5,0x30,0x01,0x67,0x2b,0xfe,0xd7,0xab,0x76, 0xca,0x82,0xc9,0x7d,0xfa,0x59,0x47,0xf0,0xad,0xd4,0xa2,0xaf,0x9c,0xa4,0x72,0xc0, 0xb7,0xfd,0x93,0x26,0x36,0x3f,0xf7,0xcc,0x34,0xa5,0xe5,0xf1,0x71,0xd8,0x31,0x15, 0x04,0xc7,0x23,0xc3,0x18,0x96,0x05,0x9a,0x07,0x12,0x80,0xe2,0xeb,0x27,0xb2,0x75, 0x09,0x83,0x2c,0x1a,0x1b,0x6e,0x5a,0xa0,0x52,0x3b,0xd6,0xb3,0x29,0xe3,0x2f,0x84, 0x53,0xd1,0x00,0xed,0x20,0xfc,0xb1,0x5b,0x6a,0xcb,0xbe,0x39,0x4a,0x4c,0x58,0xcf, 0xd0,0xef,0xaa,0xfb,0x43,0x4d,0x33,0x85,0x45,0xf9,0x02,0x7f,0x50,0x3c,0x9f,0xa8, 0x51,0xa3,0x40,0x8f,0x92,0x9d,0x38,0xf5,0xbc,0xb6,0xda,0x21,0x10,0xff,0xf3,0xd2, 0xcd,0x0c,0x13,0xec,0x5f,0x97,0x44,0x17,0xc4,0xa7,0x7e,0x3d,0x64,0x5d,0x19,0x73, 0x60,0x81,0x4f,0xdc,0x22,0x2a,0x90,0x88,0x46,0xee,0xb8,0x14,0xde,0x5e,0x0b,0xdb, 0xe0,0x32,0x3a,0x0a,0x49,0x06,0x24,0x5c,0xc2,0xd3,0xac,0x62,0x91,0x95,0xe4,0x79, 0xe7,0xc8,0x37,0x6d,0x8d,0xd5,0x4e,0xa9,0x6c,0x56,0xf4,0xea,0x65,0x7a,0xae,0x08, 0xba,0x78,0x25,0x2e,0x1c,0xa6,0xb4,0xc6,0xe8,0xdd,0x74,0x1f,0x4b,0xbd,0x8b,0x8a, 0x70,0x3e,0xb5,0x66,0x48,0x03,0xf6,0x0e,0x61,0x35,0x57,0xb9,0x86,0xc1,0x1d,0x9e, 0xe1,0xf8,0x98,0x11,0x69,0xd9,0x8e,0x94,0x9b,0x1e,0x87,0xe9,0xce,0x55,0x28,0xdf, 0x8c,0xa1,0x89,0x0d,0xbf,0xe6,0x42,0x68,0x41,0x99,0x2d,0x0f,0xb0,0x54,0xbb,0x16); $Rcon = array( array(0x00, 0x00, 0x00, 0x00), array(0x01, 0x00, 0x00, 0x00), array(0x02, 0x00, 0x00, 0x00), array(0x04, 0x00, 0x00, 0x00), array(0x08, 0x00, 0x00, 0x00), array(0x10, 0x00, 0x00, 0x00), array(0x20, 0x00, 0x00, 0x00), array(0x40, 0x00, 0x00, 0x00), array(0x80, 0x00, 0x00, 0x00), array(0x1b, 0x00, 0x00, 0x00), array(0x36, 0x00, 0x00, 0x00) ); function AESEncryptCtr($plaintext, $password, $nBits) { $blockSize = 16; if (!($nBits==128 || $nBits==192 || $nBits==256)) return ''; $nBytes = $nBits/8; $pwBytes = array(); for ($i=0; $i<$nBytes; $i++) $pwBytes[$i] = ord(substr($password,$i,1)) & 0xff; $key = Cipher($pwBytes, KeyExpansion($pwBytes)); $key = array_merge($key, array_slice($key, 0, $nBytes-16)); $counterBlock = array(); $nonce = floor(microtime(true)*1000); $nonceSec = floor($nonce/1000); $nonceMs = $nonce%1000; for ($i=0; $i<4; $i++) $counterBlock[$i] = urs($nonceSec, $i*8) & 0xff; for ($i=0; $i<4; $i++) $counterBlock[$i+4] = $nonceMs & 0xff; $ctrTxt = ''; for ($i=0; $i<8; $i++) $ctrTxt .= chr($counterBlock[$i]); $keySchedule = KeyExpansion($key); $blockCount = ceil(strlen($plaintext)/$blockSize); $ciphertxt = array(); for ($b=0; $b<$blockCount; $b++) { for ($c=0; $c<4; $c++) $counterBlock[15-$c] = urs($b, $c*8) & 0xff; for ($c=0; $c<4; $c++) $counterBlock[15-$c-4] = urs($b/0x100000000, $c*8); $cipherCntr = Cipher($counterBlock, $keySchedule); $blockLength = $b<$blockCount-1 ? $blockSize : (strlen($plaintext)-1)%$blockSize+1; $cipherByte = array(); for ($i=0; $i<$blockLength; $i++) { $cipherByte[$i] = $cipherCntr[$i] ^ ord(substr($plaintext, $b*$blockSize+$i, 1)); $cipherByte[$i] = chr($cipherByte[$i]); } $ciphertxt[$b] = implode('', $cipherByte); } $ciphertext = $ctrTxt . implode('', $ciphertxt); $ciphertext = base64_encode($ciphertext); return $ciphertext; } function AESDecryptCtr($ciphertext, $password, $nBits) { $blockSize = 16; if (!($nBits==128 || $nBits==192 || $nBits==256)) return ''; $ciphertext = base64_decode($ciphertext); $nBytes = $nBits/8; $pwBytes = array(); for ($i=0; $i<$nBytes; $i++) $pwBytes[$i] = ord(substr($password,$i,1)) & 0xff; $key = Cipher($pwBytes, KeyExpansion($pwBytes)); $key = array_merge($key, array_slice($key, 0, $nBytes-16)); $counterBlock = array(); $ctrTxt = substr($ciphertext, 0, 8); for ($i=0; $i<8; $i++) $counterBlock[$i] = ord(substr($ctrTxt,$i,1)); $keySchedule = KeyExpansion($key); $nBlocks = ceil((strlen($ciphertext)-8) / $blockSize); $ct = array(); for ($b=0; $b<$nBlocks; $b++) $ct[$b] = substr($ciphertext, 8+$b*$blockSize, 16); $ciphertext = $ct; $plaintxt = array(); for ($b=0; $b<$nBlocks; $b++) { for ($c=0; $c<4; $c++) $counterBlock[15-$c] = urs($b, $c*8) & 0xff; for ($c=0; $c<4; $c++) $counterBlock[15-$c-4] = urs(($b+1)/0x100000000-1, $c*8) & 0xff; $cipherCntr = Cipher($counterBlock, $keySchedule); $plaintxtByte = array(); for ($i=0; $i<strlen($ciphertext[$b]); $i++) { $plaintxtByte[$i] = $cipherCntr[$i] ^ ord(substr($ciphertext[$b],$i,1)); $plaintxtByte[$i] = chr($plaintxtByte[$i]); } $plaintxt[$b] = implode('', $plaintxtByte); } $plaintext = implode('',$plaintxt); return $plaintext; } function urs($a, $b) { $a &= 0xffffffff; $b &= 0x1f; if ($a&0x80000000 && $b>0) { $a = ($a>>1) & 0x7fffffff; $a = $a >> ($b-1); } else { $a = ($a>>$b); } return $a; }
?>