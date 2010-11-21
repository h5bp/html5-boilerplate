<%@ Page Language="C#" %>
<script language="C#" runat="server">
  private const string GaAccount = "MO-3845491-5";
  private const string GaPixel = "ga.aspx";

  private string GoogleAnalyticsGetImageUrl() {
    System.Text.StringBuilder url = new System.Text.StringBuilder();
    url.Append(GaPixel + "?");
    url.Append("utmac=").Append(GaAccount);

    Random RandomClass = new Random();
    url.Append("&utmn=").Append(RandomClass.Next(0x7fffffff));

    string referer = "-";
    if (Request.UrlReferrer != null
         && "" != Request.UrlReferrer.ToString()) {
      referer = Request.UrlReferrer.ToString();
    }
    url.Append("&utmr=").Append(HttpUtility.UrlEncode(referer));

    if (HttpContext.Current.Request.Url != null) {
      url.Append("&utmp=").Append(HttpUtility.UrlEncode(Request.Url.PathAndQuery));
    }

    url.Append("&guid=ON");

    return url.ToString();
  }
</script>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Sample Mobile Analytics Page</title>
</head>
<body>

Publisher's content here.
<%
  string googleAnalyticsImageUrl = GoogleAnalyticsGetImageUrl();
%>
<img src="<%= googleAnalyticsImageUrl %>" />
Testing: <%= googleAnalyticsImageUrl %>
</body>
</html>