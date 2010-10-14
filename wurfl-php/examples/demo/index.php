<?php


include_once './inc/header.inc';

//$_SERVER["HTTP_USER_AGENT"] = "Mozilla";

$requestingDevice = $wurflManager->getDeviceForHttpRequest($_SERVER);
?>

<div id="content">

Requesting Browser User Agent: <b> <?php echo $_SERVER["HTTP_USER_AGENT"] ?> </b>


<ul>
<li>ID: <?php echo $requestingDevice->id ?> </li>
<li>Brand Name: <?php echo $requestingDevice->getCapability("brand_name") ?> </li>
<li>Model Name: <?php echo $requestingDevice->getCapability("model_name") ?> </li>
<li>Xhtml Preferred Markup: <?php echo $requestingDevice->getCapability("preferred_markup") ?> </li>
<li>Resolution Width: <?php echo $requestingDevice->getCapability("resolution_width") ?> </li>
<li>Resolution Height: <?php echo $requestingDevice->getCapability("resolution_height") ?> </li>
</ul>

<p><b>Query wurfl by providing the user agent:</b></p>
<form method="get" action="devices.php">
<div>User Agent : <input type="text" name="userAgent" size="40" value="" />
<input type="submit" /></div>
</form>
</div>
<?php
include_once 'inc/footer.inc';
?>
