#!/usr/bin/perl -w
#
#  Copyright 2009 Google Inc. All Rights Reserved.

use strict;
use URI::Escape;

use constant GA_ACCOUNT => 'MO-3845491-5';
use constant GA_PIXEL => 'ga.pl';

sub google_analytics_get_image_url {
  my $url = '';
  $url .= GA_PIXEL . '?';
  $url .= 'utmac=' . GA_ACCOUNT;
  $url .= '&utmn=' . int(rand(0x7fffffff));

  my $referer = $ENV{'HTTP_REFERER'};
  my $query = $ENV{'QUERY_STRING'};
  my $path = $ENV{'REQUEST_URI'};

  if ($referer eq "") {
    $referer = '-';
  }

  $url .= '&utmr=' . uri_escape($referer);
  $url .= '&utmp=' . uri_escape($path);
  $url .= '&guid=ON';

  $url;
}

print "Content-Type: text/html; charset=ISO-8859-1\n\n";
print '<html><head></head><body>';
print '<img src="' . google_analytics_get_image_url() . '" />';
print google_analytics_get_image_url();
print '</body></html>';

exit (0);
