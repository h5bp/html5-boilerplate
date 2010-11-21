#!/usr/bin/perl -w
#
#  Copyright 2009 Google Inc. All Rights Reserved.

use CGI;
use Digest::MD5 qw(md5_hex);
use LWP::UserAgent;
use URI::Escape;
use strict;

# Tracker version.
use constant VERSION => '4.4sp';

use constant COOKIE_NAME => '__utmmobile';

# The path the cookie will be available to, edit this to use a different
# cookie path.
use constant COOKIE_PATH => '/';

# Two years.
use constant COOKIE_USER_PERSISTENCE => '+2y';

# 1x1 transparent GIF
my @GIF_DATA = (
    0x47, 0x49, 0x46, 0x38, 0x39, 0x61,
    0x01, 0x00, 0x01, 0x00, 0x80, 0xff,
    0x00, 0xff, 0xff, 0xff, 0x00, 0x00,
    0x00, 0x2c, 0x00, 0x00, 0x00, 0x00,
    0x01, 0x00, 0x01, 0x00, 0x00, 0x02,
    0x02, 0x44, 0x01, 0x00, 0x3b);

my $query = new CGI;

# The last octect of the IP address is removed to anonymize the user.
sub get_ip {
  my ($remote_address) = @_;
  if ($remote_address eq "") {
    return "";
  }

 # Capture the first three octects of the IP address and replace the forth
 # with 0, e.g. 124.455.3.123 becomes 124.455.3.0
  if ($remote_address =~ /^((\d{1,3}\.){3})\d{1,3}$/) {
    return $1 . "0";
  } else {
    return "";
  }
}

# Generate a visitor id for this hit.
# If there is a visitor id in the cookie, use that, otherwise
# use the guid if we have one, otherwise use a random number.
sub get_visitor_id {
  my ($guid, $account, $user_agent, $cookie) = @_;

  # If there is a value in the cookie, don't change it.
  if ($cookie ne "") {
    return $cookie;
  }

  my $message = "";
  if ($guid ne "") {
  # Create the visitor id using the guid.
    $message = $guid . $account;
  } else {
  # otherwise this is a new user, create a new random id.
    $message = $user_agent . get_random_number();
  }

  my $md5_string = md5_hex($message);

  return "0x" . substr($md5_string, 0, 16);
}

# Get a random number string.
sub get_random_number {
  return int(rand(0x7fffffff));
}

# Writes the bytes of a 1x1 transparent gif into the response.
sub write_gif_data {
  my ($cookie, $utm_url) = @_;

  my @header_args = (
      -type => 'image/gif',
      -Cache_Control =>
          'private, no-cache, no-cache=Set-Cookie, proxy-revalidate',
      -Pragma => 'no-cache',
      -cookie => $cookie,
      -expires => '-1d');

  # If the debug parameter is on, add a header to the response that contains
  # the url that was used to contact Google Analytics.
  if (defined($query->param('utmdebug'))) {
    push(@header_args, -X_GA_MOBILE_URL => $utm_url);
  }
  print $query->header(@header_args);
  print pack("C35", @GIF_DATA);
}

# Make a tracking request to Google Analytics from this server.
# Copies the headers from the original request to the new one.
# If request containg utmdebug parameter, exceptions encountered
# communicating with Google Analytics are thown.
sub send_request_to_google_analytics {
  my ($utm_url) = @_;
  my $ua = LWP::UserAgent->new;

  if (exists($ENV{'HTTP_ACCEPT_LANGUAGE'})) {
    $ua->default_header('Accepts-Language' => $ENV{'HTTP_ACCEPT_LANGUAGE'});
  }
  if (exists($ENV{'HTTP_USER_AGENT'})) {
    $ua->agent($ENV{'HTTP_USER_AGENT'});
  }

  my $ga_output = $ua->get($utm_url);

  if (defined($query->param('utmdebug')) && !$ga_output->is_success) {
    print $ga_output->status_line;
  }
}

# Track a page view, updates all the cookies and campaign tracker,
# makes a server side request to Google Analytics and writes the transparent
# gif byte data to the response.
sub track_page_view {
  my $domain_name = "";
  if (exists($ENV{'SERVER_NAME'})) {
    $domain_name = $ENV{'SERVER_NAME'};
  }

  # Get the referrer from the utmr parameter, this is the referrer to the
  # page that contains the tracking pixel, not the referrer for tracking
  # pixel.
  my $document_referer = "-";
  if (defined($query->param('utmr'))) {
    $document_referer = uri_unescape($query->param('utmr'));
  }
  my $document_path = "";
  if (defined($query->param('utmp'))) {
    $document_path = uri_unescape($query->param('utmp'));
  }

  my $account = $query->param('utmac');
  my $user_agent = "";
  if (exists($ENV{'HTTP_USER_AGENT'})) {
    $user_agent = $ENV{'HTTP_USER_AGENT'};
  }

  # Try and get visitor cookie from the request.
  my $cookie = "";
  if (defined($query->cookie(COOKIE_NAME))) {
    $cookie = $query->cookie(COOKIE_NAME);
  }

  my $guid = "";
  if (exists($ENV{'HTTP_X_DCMGUID'})) {
    $guid = $ENV{'HTTP_X_DCMGUID'};
  }

  my $visitor_id = get_visitor_id($guid, $account, $user_agent, $cookie);

  # Always try and add the cookie to the response.
  my $new_cookie = $query->cookie(
      -name => COOKIE_NAME,
      -value => $visitor_id,
      -path => COOKIE_PATH,
      -expires => COOKIE_USER_PERSISTENCE);

  my $utm_gif_location = "http://www.google-analytics.com/__utm.gif";

  my $remote_address = "";
  if (exists($ENV{'REMOTE_ADDR'})) {
    $remote_address = $ENV{'REMOTE_ADDR'};
  }

  # Construct the gif hit url.
  my $utm_url = $utm_gif_location . '?' .
      'utmwv=' . VERSION .
      '&utmn=' . get_random_number() .
      '&utmhn=' . uri_escape($domain_name) .
      '&utmr=' . uri_escape($document_referer) .
      '&utmp=' . uri_escape($document_path) .
      '&utmac=' . $account .
      '&utmcc=__utma%3D999.999.999.999.999.1%3B' .
      '&utmvid=' . $visitor_id .
      '&utmip=' . get_ip($remote_address);

  send_request_to_google_analytics($utm_url);

  # Finally write the gif data to the response.
  write_gif_data($new_cookie, $utm_url);
}

track_page_view();
