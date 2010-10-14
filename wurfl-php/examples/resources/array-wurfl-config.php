<?php


$wurfl['main-file'] = "wurfl-regression.zip";
$wurfl['patches'] = array("web_browsers_patch.xml");


$persistence['provider'] = "memcache";
$persistence['dir'] = "cache";


$cache['provider'] = "null";


$configuration["wurfl"] = $wurfl;
$configuration["persistence"] = $persistence;
$configuration["cache"] = $cache;




?>