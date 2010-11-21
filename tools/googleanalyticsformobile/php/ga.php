<?php

/**
  Copyright 2009 Google Inc. All Rights Reserved.
**/

  // Tracker version.
  define("VERSION", "4.4sh");

  define("COOKIE_NAME", "__utmmobile");

  // The path the cookie will be available to, edit this to use a different
  // cookie path.
  define("COOKIE_PATH", "/");

  // Two years in seconds.
  define("COOKIE_USER_PERSISTENCE", 63072000);

  // 1x1 transparent GIF
  $GIF_DATA = array(
      chr(0x47), chr(0x49), chr(0x46), chr(0x38), chr(0x39), chr(0x61),
      chr(0x01), chr(0x00), chr(0x01), chr(0x00), chr(0x80), chr(0xff),
      chr(0x00), chr(0xff), chr(0xff), chr(0xff), chr(0x00), chr(0x00),
      chr(0x00), chr(0x2c), chr(0x00), chr(0x00), chr(0x00), chr(0x00),
      chr(0x01), chr(0x00), chr(0x01), chr(0x00), chr(0x00), chr(0x02),
      chr(0x02), chr(0x44), chr(0x01), chr(0x00), chr(0x3b)
  );

  // The last octect of the IP address is removed to anonymize the user.
  function getIP($remoteAddress) {
    if (empty($remoteAddress)) {
      return "";
    }

    // Capture the first three octects of the IP address and replace the forth
    // with 0, e.g. 124.455.3.123 becomes 124.455.3.0
    $regex = "/^([^.]+\.[^.]+\.[^.]+\.).*/";
    if (preg_match($regex, $remoteAddress, $matches)) {
      return $matches[1] . "0";
    } else {
      return "";
    }
  }

  // Generate a visitor id for this hit.
  // If there is a visitor id in the cookie, use that, otherwise
  // use the guid if we have one, otherwise use a random number.
  function getVisitorId($guid, $account, $userAgent, $cookie) {

    // If there is a value in the cookie, don't change it.
    if (!empty($cookie)) {
      return $cookie;
    }

    $message = "";
    if (!empty($guid)) {
      // Create the visitor id using the guid.
      $message = $guid . $account;
    } else {
      // otherwise this is a new user, create a new random id.
      $message = $userAgent . uniqid(getRandomNumber(), true);
    }

    $md5String = md5($message);

    return "0x" . substr($md5String, 0, 16);
  }

  // Get a random number string.
  function getRandomNumber() {
    return rand(0, 0x7fffffff);
  }

  // Writes the bytes of a 1x1 transparent gif into the response.
  function writeGifData() {
    global $GIF_DATA;
    header("Content-Type: image/gif");
    header("Cache-Control: " .
           "private, no-cache, no-cache=Set-Cookie, proxy-revalidate");
    header("Pragma: no-cache");
    header("Expires: Wed, 17 Sep 1975 21:32:10 GMT");
    echo join($GIF_DATA);
  }

  // Make a tracking request to Google Analytics from this server.
  // Copies the headers from the original request to the new one.
  // If request containg utmdebug parameter, exceptions encountered
  // communicating with Google Analytics are thown.
  function sendRequestToGoogleAnalytics($utmUrl) {
    $options = array(
      "http" => array(
          "method" => "GET",
          "user_agent" => $_SERVER["HTTP_USER_AGENT"],
          "header" => ("Accepts-Language: " . $_SERVER["HTTP_ACCEPT_LANGUAGE"]))
    );
    if (!empty($_GET["utmdebug"])) {
      $data = file_get_contents(
          $utmUrl, false, stream_context_create($options));
    } else {
      $data = @file_get_contents(
          $utmUrl, false, stream_context_create($options));
    }
  }

  // Track a page view, updates all the cookies and campaign tracker,
  // makes a server side request to Google Analytics and writes the transparent
  // gif byte data to the response.
  function trackPageView() {
    $timeStamp = time();
    $domainName = $_SERVER["SERVER_NAME"];
    if (empty($domainName)) {
      $domainName = "";
    }

    // Get the referrer from the utmr parameter, this is the referrer to the
    // page that contains the tracking pixel, not the referrer for tracking
    // pixel.
    $documentReferer = $_GET["utmr"];
    if (empty($documentReferer) && $documentReferer !== "0") {
      $documentReferer = "-";
    } else {
      $documentReferer = urldecode($documentReferer);
    }
    $documentPath = $_GET["utmp"];
    if (empty($documentPath)) {
      $documentPath = "";
    } else {
      $documentPath = urldecode($documentPath);
    }

    $account = $_GET["utmac"];
    $userAgent = $_SERVER["HTTP_USER_AGENT"];
    if (empty($userAgent)) {
      $userAgent = "";
    }

    // Try and get visitor cookie from the request.
    $cookie = $_COOKIE[COOKIE_NAME];

    $visitorId = getVisitorId(
        $_SERVER["HTTP_X_DCMGUID"], $account, $userAgent, $cookie);

    // Always try and add the cookie to the response.
    setrawcookie(
        COOKIE_NAME,
        $visitorId,
        $timeStamp + COOKIE_USER_PERSISTENCE,
        COOKIE_PATH);

    $utmGifLocation = "http://www.google-analytics.com/__utm.gif";

    // Construct the gif hit url.
    $utmUrl = $utmGifLocation . "?" .
        "utmwv=" . VERSION .
        "&utmn=" . getRandomNumber() .
        "&utmhn=" . urlencode($domainName) .
        "&utmr=" . urlencode($documentReferer) .
        "&utmp=" . urlencode($documentPath) .
        "&utmac=" . $account .
        "&utmcc=__utma%3D999.999.999.999.999.1%3B" .
        "&utmvid=" . $visitorId .
        "&utmip=" . getIP($_SERVER["REMOTE_ADDR"]);

    sendRequestToGoogleAnalytics($utmUrl);

    // If the debug parameter is on, add a header to the response that contains
    // the url that was used to contact Google Analytics.
    if (!empty($_GET["utmdebug"])) {
      header("X-GA-MOBILE-URL:" . $utmUrl);
    }
    // Finally write the gif data to the response.
    writeGifData();
  }
?><?php
  trackPageView();
?>
