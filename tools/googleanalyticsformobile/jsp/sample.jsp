<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<%@ page import="java.io.UnsupportedEncodingException,
                 java.net.URLEncoder" %>
<%!
  private static final String GA_ACCOUNT = "MO-3845491-5";
  private static final String GA_PIXEL = "ga.jsp";

  private String googleAnalyticsGetImageUrl(
      HttpServletRequest request) throws UnsupportedEncodingException {
    StringBuilder url = new StringBuilder();
    url.append(GA_PIXEL + "?");
    url.append("utmac=").append(GA_ACCOUNT);
    url.append("&utmn=").append(Integer.toString((int) (Math.random() * 0x7fffffff)));

    String referer = request.getHeader("referer");
    String query = request.getQueryString();
    String path = request.getRequestURI();

    if (referer == null || "".equals(referer)) {
      referer = "-";
    }
    url.append("&utmr=").append(URLEncoder.encode(referer, "UTF-8"));

    if (path != null) {
      if (query != null) {
        path += "?" + query;
      }
      url.append("&utmp=").append(URLEncoder.encode(path, "UTF-8"));
    }

    url.append("&guid=ON");

    return url.toString();
  }
%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Sample Mobile Analytics Page</title>
</head>
<body>

Publishers content here.
<%
  String googleAnalyticsImageUrl = googleAnalyticsGetImageUrl(request);
%>
<img src="<%= googleAnalyticsImageUrl %>" />
Testing: <%= googleAnalyticsImageUrl %>
</body>
</html>