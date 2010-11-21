<%@ page language="java"
    contentType="image/gif"
    import="java.io.ByteArrayOutputStream,
            java.io.IOException,
            java.io.OutputStream,
            java.io.UnsupportedEncodingException,
            java.math.BigInteger,
            java.net.HttpURLConnection,
            java.net.URLConnection,
            java.net.URL,
            java.net.URLEncoder,
            java.net.URLDecoder,
            java.security.MessageDigest,
            java.security.NoSuchAlgorithmException,
            javax.servlet.http.Cookie,
            java.util.regex.Pattern,
            java.util.regex.Matcher,
            java.util.UUID" %><%!

/**
  Copyright 2009 Google Inc. All Rights Reserved.
**/

  // Tracker version.
  private static final String version = "4.4sj";

  private static final String COOKIE_NAME = "__utmmobile";

  // The path the cookie will be available to, edit this to use a different
  // cookie path.
  private static final String COOKIE_PATH = "/";

  // Two years in seconds.
  private static final int COOKIE_USER_PERSISTENCE = 63072000;

  // 1x1 transparent GIF
  private static final byte[] GIF_DATA = new byte[] {
      (byte)0x47, (byte)0x49, (byte)0x46, (byte)0x38, (byte)0x39, (byte)0x61,
      (byte)0x01, (byte)0x00, (byte)0x01, (byte)0x00, (byte)0x80, (byte)0xff,
      (byte)0x00, (byte)0xff, (byte)0xff, (byte)0xff, (byte)0x00, (byte)0x00,
      (byte)0x00, (byte)0x2c, (byte)0x00, (byte)0x00, (byte)0x00, (byte)0x00,
      (byte)0x01, (byte)0x00, (byte)0x01, (byte)0x00, (byte)0x00, (byte)0x02,
      (byte)0x02, (byte)0x44, (byte)0x01, (byte)0x00, (byte)0x3b
  };

  // A string is empty in our terms, if it is null, empty or a dash.
  private static boolean isEmpty(String in) {
    return in == null || "-".equals(in) || "".equals(in);
  }

  // The last octect of the IP address is removed to anonymize the user.
  private static String getIP(String remoteAddress) {
    if (isEmpty(remoteAddress)) {
      return "";
    }
    // Capture the first three octects of the IP address and replace the forth
    // with 0, e.g. 124.455.3.123 becomes 124.455.3.0
    String regex = "^([^.]+\\.[^.]+\\.[^.]+\\.).*";
    Pattern getFirstBitOfIPAddress = Pattern.compile(regex);
    Matcher m = getFirstBitOfIPAddress.matcher(remoteAddress);
    if (m.matches()) {
      return m.group(1) + "0";
    } else {
      return "";
    }
  }

  // Generate a visitor id for this hit.
  // If there is a visitor id in the cookie, use that, otherwise
  // use the guid if we have one, otherwise use a random number.
  private static String getVisitorId(
      String guid, String account, String userAgent, Cookie cookie)
      throws NoSuchAlgorithmException, UnsupportedEncodingException {

    // If there is a value in the cookie, don't change it.
    if (cookie != null && cookie.getValue() != null) {
      return cookie.getValue();
    }

    String message;
    if (!isEmpty(guid)) {
      // Create the visitor id using the guid.
      message = guid + account;
    } else {
      // otherwise this is a new user, create a new random id.
      message = userAgent + getRandomNumber() + UUID.randomUUID().toString();
    }

    MessageDigest m = MessageDigest.getInstance("MD5");
    m.update(message.getBytes("UTF-8"), 0, message.length());
    byte[] sum = m.digest();
    BigInteger messageAsNumber = new BigInteger(1, sum);
    String md5String = messageAsNumber.toString(16);

    // Pad to make sure id is 32 characters long.
    while (md5String.length() < 32) {
      md5String = "0" + md5String;
    }

    return "0x" + md5String.substring(0, 16);
  }

  // Get a random number string.
  private static String getRandomNumber() {
    return Integer.toString((int) (Math.random() * 0x7fffffff));
  }

  // Writes the bytes of a 1x1 transparent gif into the response.
  private void writeGifData(HttpServletResponse response) throws IOException {
    response.addHeader(
        "Cache-Control",
        "private, no-cache, no-cache=Set-Cookie, proxy-revalidate");
    response.addHeader("Pragma", "no-cache");
    response.addHeader("Expires", "Wed, 17 Sep 1975 21:32:10 GMT");
    ServletOutputStream output = response.getOutputStream();
    output.write(GIF_DATA);
    output.flush();
  }

  // Make a tracking request to Google Analytics from this server.
  // Copies the headers from the original request to the new one.
  // If request containg utmdebug parameter, exceptions encountered
  // communicating with Google Analytics are thown.
  private void sendRequestToGoogleAnalytics(
      String utmUrl, HttpServletRequest request) throws Exception {
    try {
      URL url = new URL(utmUrl);
      URLConnection connection = url.openConnection();
      connection.setUseCaches(false);

      connection.addRequestProperty("User-Agent",
          request.getHeader("User-Agent"));
      connection.addRequestProperty("Accepts-Language",
          request.getHeader("Accepts-Language"));

      connection.getContent();
    } catch (Exception e) {
      if (request.getParameter("utmdebug") != null) {
        throw new Exception(e);
      }
    }
  }

  // Track a page view, updates all the cookies and campaign tracker,
  // makes a server side request to Google Analytics and writes the transparent
  // gif byte data to the response.
  private void trackPageView(
      HttpServletRequest request, HttpServletResponse response)
      throws Exception {
    String timeStamp = Long.toString(System.currentTimeMillis() / 1000);
    String domainName = request.getServerName();
    if (isEmpty(domainName)) {
      domainName = "";
    }

    // Get the referrer from the utmr parameter, this is the referrer to the
    // page that contains the tracking pixel, not the referrer for tracking
    // pixel.
    String documentReferer = request.getParameter("utmr");
    if (isEmpty(documentReferer)) {
      documentReferer = "-";
    } else {
      documentReferer = URLDecoder.decode(documentReferer, "UTF-8");
    }
    String documentPath = request.getParameter("utmp");
    if (isEmpty(documentPath)) {
      documentPath = "";
    } else {
      documentPath = URLDecoder.decode(documentPath, "UTF-8");
    }

    String account = request.getParameter("utmac");
    String userAgent = request.getHeader("User-Agent");
    if (isEmpty(userAgent)) {
      userAgent = "";
    }

    // Try and get visitor cookie from the request.
    Cookie[] cookies = request.getCookies();
    Cookie cookie = null;
    if (cookies != null) {
      for(int i = 0; i < cookies.length; i++) {
        if (cookies[i].getName().equals(COOKIE_NAME)) {
          cookie = cookies[i];
        }
      }
    }

    String visitorId = getVisitorId(
        request.getHeader("X-DCMGUID"), account, userAgent, cookie);

    // Always try and add the cookie to the response.
    Cookie newCookie = new Cookie(COOKIE_NAME, visitorId);
    newCookie.setMaxAge(COOKIE_USER_PERSISTENCE);
    newCookie.setPath(COOKIE_PATH);
    response.addCookie(newCookie);

    String utmGifLocation = "http://www.google-analytics.com/__utm.gif";

    // Construct the gif hit url.
    String utmUrl = utmGifLocation + "?" +
        "utmwv=" + version +
        "&utmn=" + getRandomNumber() +
        "&utmhn=" + URLEncoder.encode(domainName, "UTF-8") +
        "&utmr=" + URLEncoder.encode(documentReferer, "UTF-8") +
        "&utmp=" + URLEncoder.encode(documentPath, "UTF-8") +
        "&utmac=" + account +
        "&utmcc=__utma%3D999.999.999.999.999.1%3B" +
        "&utmvid=" + visitorId +
        "&utmip=" + getIP(request.getRemoteAddr());

    sendRequestToGoogleAnalytics(utmUrl, request);

    // If the debug parameter is on, add a header to the response that contains
    // the url that was used to contact Google Analytics.
    if (request.getParameter("utmdebug") != null) {
      response.setHeader("X-GA-MOBILE-URL", utmUrl);
    }
    // Finally write the gif data to the response.
    writeGifData(response);
  }
%><%
  // Let exceptions bubble up to container, for better debugging.
  trackPageView(request, response);
%>
