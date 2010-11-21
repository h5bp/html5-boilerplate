<% @Page Language="C#" ContentType="image/gif"%><%
   @Import Namespace="System.Net" %><%
   @Import Namespace="System.Security.Cryptography" %><%
   @Import Namespace="System.Text" %><script runat="server" language="c#">
  /**
    Copyright 2009 Google Inc. All Rights Reserved.
  **/

  // Tracker version.
  private const string Version = "4.4sa";

  private const string CookieName = "__utmmobile";

  // The path the cookie will be available to, edit this to use a different
  // cookie path.
  private const string CookiePath = "/";

  // Two years in seconds.
  private readonly TimeSpan CookieUserPersistence = TimeSpan.FromSeconds(63072000);

  // 1x1 transparent GIF
  private readonly byte[] GifData = {
      0x47, 0x49, 0x46, 0x38, 0x39, 0x61,
      0x01, 0x00, 0x01, 0x00, 0x80, 0xff,
      0x00, 0xff, 0xff, 0xff, 0x00, 0x00,
      0x00, 0x2c, 0x00, 0x00, 0x00, 0x00,
      0x01, 0x00, 0x01, 0x00, 0x00, 0x02,
      0x02, 0x44, 0x01, 0x00, 0x3b
  };

  private static readonly Regex IpAddressMatcher =
      new Regex(@"^([^.]+\.[^.]+\.[^.]+\.).*");

  // A string is empty in our terms, if it is null, empty or a dash.
  private static bool IsEmpty(string input) {
    return input == null || "-" == input || "" == input;
  }

  // The last octect of the IP address is removed to anonymize the user.
  private static string GetIP(string remoteAddress) {
    if (IsEmpty(remoteAddress)) {
      return "";
    }
    // Capture the first three octects of the IP address and replace the forth
    // with 0, e.g. 124.455.3.123 becomes 124.455.3.0
    Match m = IpAddressMatcher.Match(remoteAddress);
    if (m.Success) {
      return m.Groups[1] + "0";
    } else {
      return "";
    }
  }

  // Generate a visitor id for this hit.
  // If there is a visitor id in the cookie, use that, otherwise
  // use the guid if we have one, otherwise use a random number.
  private static string GetVisitorId(
      string guid, string account, string userAgent, HttpCookie cookie) {

    // If there is a value in the cookie, don't change it.
    if (cookie != null && cookie.Value != null) {
      return cookie.Value;
    }

    String message;
    if (!IsEmpty(guid)) {
      // Create the visitor id using the guid.
      message = guid + account;
    } else {
      // otherwise this is a new user, create a new random id.
      message = userAgent + GetRandomNumber() + Guid.NewGuid().ToString();
    }

    MD5CryptoServiceProvider md5 = new MD5CryptoServiceProvider();
    byte[] messageBytes = Encoding.UTF8.GetBytes(message);
    byte[] sum = md5.ComputeHash(messageBytes);

    string md5String = BitConverter.ToString(sum);
    md5String = md5String.Replace("-","");

    md5String = md5String.PadLeft(32, '0');

    return "0x" + md5String.Substring(0, 16);
  }

  // Get a random number string.
  private static String GetRandomNumber() {
    Random RandomClass = new Random();
    return RandomClass.Next(0x7fffffff).ToString();
  }

  // Writes the bytes of a 1x1 transparent gif into the response.
  private void WriteGifData() {
    Response.AddHeader(
        "Cache-Control",
        "private, no-cache, no-cache=Set-Cookie, proxy-revalidate");
    Response.AddHeader("Pragma", "no-cache");
    Response.AddHeader("Expires", "Wed, 17 Sep 1975 21:32:10 GMT");
    Response.Buffer = false;
    Response.OutputStream.Write(GifData, 0, GifData.Length);
  }

  // Make a tracking request to Google Analytics from this server.
  // Copies the headers from the original request to the new one.
  // If request containg utmdebug parameter, exceptions encountered
  // communicating with Google Analytics are thown.
  private void SendRequestToGoogleAnalytics(string utmUrl) {
    try {
      WebRequest connection = WebRequest.Create(utmUrl);

      ((HttpWebRequest)connection).UserAgent = Request.UserAgent;
      connection.Headers.Add("Accepts-Language",
          Request.Headers.Get("Accepts-Language"));

      using (WebResponse resp = connection.GetResponse()) {
        // Ignore response
      }
    } catch (Exception ex) {
      if (Request.QueryString.Get("utmdebug") != null) {
        throw new Exception("Error contacting Google Analytics", ex);
      }
    }
  }

  // Track a page view, updates all the cookies and campaign tracker,
  // makes a server side request to Google Analytics and writes the transparent
  // gif byte data to the response.
  private void TrackPageView() {
    TimeSpan timeSpan = (DateTime.Now - new DateTime(1970, 1, 1).ToLocalTime());
    string timeStamp = timeSpan.TotalSeconds.ToString();
    string domainName = Request.ServerVariables["SERVER_NAME"];
    if (IsEmpty(domainName)) {
      domainName = "";
    }

    // Get the referrer from the utmr parameter, this is the referrer to the
    // page that contains the tracking pixel, not the referrer for tracking
    // pixel.
    string documentReferer = Request.QueryString.Get("utmr");
    if (IsEmpty(documentReferer)) {
      documentReferer = "-";
    } else {
      documentReferer = HttpUtility.UrlDecode(documentReferer);
    }
    string documentPath = Request.QueryString.Get("utmp");
    if (IsEmpty(documentPath)) {
      documentPath = "";
    } else {
      documentPath = HttpUtility.UrlDecode(documentPath);
    }

    string account = Request.QueryString.Get("utmac");
    string userAgent = Request.UserAgent;
    if (IsEmpty(userAgent)) {
      userAgent = "";
    }

    // Try and get visitor cookie from the request.
    HttpCookie cookie = Request.Cookies.Get(CookieName);

    string visitorId = GetVisitorId(
        Request.Headers.Get("X-DCMGUID"), account, userAgent, cookie);

    // Always try and add the cookie to the response.
    HttpCookie newCookie = new HttpCookie(CookieName);
    newCookie.Value = visitorId;
    newCookie.Expires = DateTime.Now + CookieUserPersistence;
    newCookie.Path = CookiePath;
    Response.Cookies.Add(newCookie);

    string utmGifLocation = "http://www.google-analytics.com/__utm.gif";

    // Construct the gif hit url.
    string utmUrl = utmGifLocation + "?" +
        "utmwv=" + Version +
        "&utmn=" + GetRandomNumber() +
        "&utmhn=" + HttpUtility.UrlEncode(domainName) +
        "&utmr=" + HttpUtility.UrlEncode(documentReferer) +
        "&utmp=" + HttpUtility.UrlEncode(documentPath) +
        "&utmac=" + account +
        "&utmcc=__utma%3D999.999.999.999.999.1%3B" +
        "&utmvid=" + visitorId +
        "&utmip=" + GetIP(Request.ServerVariables["REMOTE_ADDR"]);

    SendRequestToGoogleAnalytics(utmUrl);

    // If the debug parameter is on, add a header to the response that contains
    // the url that was used to contact Google Analytics.
    if (Request.QueryString.Get("utmdebug") != null) {
      Response.AddHeader("X-GA-MOBILE-URL", utmUrl);
    }
    // Finally write the gif data to the response.
    WriteGifData();
  }
</script><% TrackPageView(); %>
