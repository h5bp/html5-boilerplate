<?php


include_once './inc/header.inc';


function printDeviceDetails($device) {

	if (isset($device)) {
		print"<ul>";
		print"<li>ID: $device->id</li>";
		print"<li>Brand Name: " . $device->getCapability("brand_name") . "</li>";
		print"<li>Model Name: " . $device->getCapability('model_name') . "</li>";
		print"<li>Xhtml Preferred Markup:" .  $device->getCapability('preferred_markup') . "</li>";
		print"<li>Resolution Width:" .  $device->getCapability('resolution_width') . "</li>";
		print"<li>Resolution Height:" .  $device->getCapability('resolution_height') . "</li>";
		print"<li>MP3:" .  $device->getCapability('mp3') . "</li>";
		print"</ul>";
	}

}


$device = NULL;

if ($_GET['userAgent']) {
	$userAgent = $_GET['userAgent'];
	$device = $wurflManager->getDeviceForUserAgent($userAgent);		
	
}


?>

<div id="content">

<p><b>Query wurfl by providing the user agent:</b></p>
<form method="get" action="devices.php">
<div>User Agent : <input type="text" name="userAgent" size="40" value="" />
<input type="submit" /></div>
</form>

<?php printDeviceDetails($device); ?>

</div>
<?php
include_once 'inc/footer.inc';
?>