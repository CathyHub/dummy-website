<?php
// Impossibility CMS © 2011 Impossibility Inc
// Config V1.1

// Include Items
$mcms["cms"]		= true;
$mcms["console"] 	= true;
$mcms["uploader2"]	= true;
$mcms["tinyeditor"]	= true;
$mcms["jquery"] 	= true;
$mcms["filesman"]	= true;
$mcms["secure"] 	= false;
$mcms["site"]       = "primalsurfacing.com.au"; // Domain override

// Set Branding
$mcms["brand"] 		= "bigpicturegroup";

// Set pin using keycodes
/* Get keycodes from http://www.mooglemedia.com.au/cms/keycode/ */
$mcms["pin"]		= "112, 113, 115"; //pqs

// Set username and password
$mcms["username"]	= "primalsurfacing";
$mcms["password"] 	= "primal2014surfacing";

// Pass HTML to put into the CMS bar
$mcms["cms_extras"] = '<a href="javascript:;" onclick="loadConsole(\'add-process.php\');">Add Process</a>';

// Default meta data
$mcms["title"]		= "Primal Surfacing";
$mcms["description"]= "Primal Surfacing";
$mcms["nokeywords"] = true;
?>