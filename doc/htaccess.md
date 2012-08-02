[HTML5 Boilerplate homepage](http://html5boilerplate.com) | [Documentation
table of contents](README.md)

# .htaccess

In Apache HTTP server, `.htaccess` (hypertext access) is the configuration file
that allows for web server configuration. HTML5 Boilerplate includes a number
of best practice server rules for making web pages fast and secure, these rules
can be applied by configuring `.htaccess` file.

**You'll want to have these modules enabled for optimum performance:**

* `mod_setenvif.c` (setenvif_module)
* `mod_headers.c` (headers_module)
* `mod_deflate.c` (deflate_module)
* `mod_filter.c` (filter_module)
* `mod_expires.c` (expires_module)
* `mod_rewrite.c` (rewrite_module)


## On Windows

You've got a couple of options that depend on how you installed Apache.

1. **WampServer**. This is by far the simplest option. If you have installed
   WampServer just click on the icon in the task bar, hover over the Apache
   section in the menu that comes up and then hover over the modules section.
   You will be presented with a list of modules. Simply click on a module name
   to enable it (or disable it if it is already enabled). A check mark next to
   a module indicates that it is enabled. WampServer will automatically restart
   the Apache service after you enable a module.
2. **Manually editing `httpd.conf`**. This assumes that you have manually
   installed Apache. You will need to locate the `httpd.conf` file which is
   normally in the `conf` folder in the folder where you installed Apache (for
   example `C:\apache\conf\httpd.conf`). Open up this file in a text editor. Near
   the top (after a bunch of comments) you will see a long list of modules. Check
   to make sure that the modules listed above are not commented out. If they
   are, go ahead and uncomment them and restart Apache.

That's it, you're done!


## On Linux

These instructions should work on any distribution where `apt-get` has been
used to install Apache.

1. Open up a terminal and type the following command. Enter your password when
   prompted.

    `sudo a2enmod setenvif headers deflate filter expires rewrite include`

1. Restart apache by using the following command so the new configuration takes
   effect.

    `sudo /etc/init.d/apache2 restart`

That's it, you're done!


## On Mac

Coming soon...


## Security

Do not turn off your ServerSignature (i.e., the `Server:` HTTP header). Serious
attackers can use other kinds of fingerprinting methods to figure out the
actual server and components running behind a port. Instead, as a site owner,
you should keep track of what's listening on ports on hosts that you control.
Run a periodic scanner to make sure nothing suspicious is running on a host you
control, and use the ServerSignature to determine if this is the web server and
version that you expect.

## Performance

### Configure ETags

```apache
FileETag None
```

Entity tags (ETags) is a mechanism that web servers and browsers use to
determine whether the component in the browser's cache matches the one on the
origin server. (An "entity" is another word a "component": images, scripts,
stylesheets, etc.) ETags were added to provide a mechanism for validating
entities that is more flexible than the last-modified date. An `ETag` is a
string that uniquely identifies a specific version of a component. The only
format constraints are that the string be quoted. The origin server specifies
the component's `ETag` using the `ETag` response header.

```http
HTTP/1.1 200 OK
Last-Modified: Tue, 12 Dec 2006 03:03:59 GMT
ETag: "10c24bc-4ab-457e1c1f"
Content-Length: 12195
```

Later, if the browser has to validate a component, it uses the `If-None-Match`
header to pass the `ETag` back to the origin server. If the ETags match, a 304
status code is returned reducing the response by 12195 bytes for this
example.

```http
GET /i/yahoo.gif HTTP/1.1
Host: us.yimg.com
If-Modified-Since: Tue, 12 Dec 2006 03:03:59 GMT
If-None-Match: "10c24bc-4ab-457e1c1f"
HTTP/1.1 304 Not Modified
```

The problem with ETags is that they typically are constructed using attributes
that make them unique to a specific server hosting a site. ETags won't match
when a browser gets the original component from one server and later tries to
validate that component on a different server, a situation that is all too
common on web sites that use a cluster of servers to handle requests. By
default, both Apache and IIS embed data in the ETag that dramatically reduces
the odds of the validity test succeeding on web sites with multiple servers.

The ETag format for Apache 1.3 and 2.x is inode-size-timestamp. Although a
given file may reside in the same directory across multiple servers, and have
the same file size, permissions, timestamp, etc., its inode is different from
one server to the next.

IIS 5.0 and 6.0 have a similar issue with ETags. The format for ETags on IIS is
Filetimestamp:ChangeNumber. A ChangeNumber is a counter used to track
configuration changes to IIS. It's unlikely that the ChangeNumber is the same
across all IIS servers behind a web site.

The end result is ETags generated by Apache and IIS for the exact same
component won't match from one server to another. If the ETags don't match, the
user doesn't receive the small, fast 304 response that ETags were designed for;
instead, they'll get a normal 200 response along with all the data for the
component. If you host your web site on just one server, this isn't a problem.
But if you have multiple servers hosting your web site, and you're using Apache
or IIS with the default ETag configuration, your users are getting slower
pages, your servers have a higher load, you're consuming greater bandwidth, and
proxies aren't caching your content efficiently. Even if your components have a
far future Expires header, a conditional GET request is still made whenever the
user hits Reload or Refresh.

If you're not taking advantage of the flexible validation model that ETags
provide, it's better to just remove the ETag altogether. The Last-Modified
header validates based on the component's timestamp. And removing the ETag
reduces the size of the HTTP headers in both the response and subsequent
requests. This Microsoft Support article describes how to remove ETags. In
Apache, this is done by simply adding the above line to your Apache
configuration file.


### Gzip Components

Compression reduces response times by reducing the size of the HTTP response.

Starting with HTTP/1.1, web clients indicate support for compression with the
Accept-Encoding header in the HTTP request.

```
Accept-Encoding: gzip, deflate
```

If the web server sees this header in the request, it may compress the response
using one of the methods listed by the client. The web server notifies the web
client of this via the Content-Encoding header in the response.

```
Content-Encoding: gzip
```

Gzip is the most popular and effective compression method at this time. It was
developed by the GNU project and standardized by RFC 1952. The only other
compression format you're likely to see is deflate, but it's less effective and
less popular.

Gzipping generally reduces the response size by about 70%. Approximately 90% of
today's Internet traffic travels through browsers that claim to support gzip.
If you use Apache, the module configuring gzip depends on your version: Apache
1.3 uses `mod_gzip` while Apache 2.x uses `mod_deflate`.

There are known issues with browsers and proxies that may cause a mismatch in
what the browser expects and what it receives with regard to compressed
content. Fortunately, these edge cases are dwindling as the use of older
browsers drops off. The Apache modules help out by adding appropriate Vary
response headers automatically.

Servers choose what to gzip based on file type, but are typically too limited
in what they decide to compress. Most web sites gzip their HTML documents. It's
also worthwhile to gzip your scripts and stylesheets, but many web sites miss
this opportunity. In fact, it's worthwhile to compress any text response
including XML and JSON. Image and PDF files should not be gzipped because they
are already compressed. Trying to gzip them not only wastes CPU but can
potentially increase file sizes.

Gzipping as many appropriate file types as possible is an easy way to reduce
page weight and accelerate the user experience.


### Cache busting

A first-time visitor to your page may have to make several HTTP requests, but
by using the Expires header you make those components cacheable. This avoids
unnecessary HTTP requests on subsequent page views. Expires headers are most
often used with images, but they should be used on all components including
scripts, stylesheets, etc.

Traditionally, if you use a far future Expires header you have to change the
component's filename whenever the component changes.

The H5BP `.htaccess` has built-in filename cache busting. To use it, uncomment
the relevant lines in the `.htaccess` file.

Doing so will route all requests for `/path/filename.20120101.ext` to
`/path/filename.ext`. To use this, just add a time-stamp number (or your own
numbered versioning system) into your resource filenames in your HTML source
whenever you update those resources.

#### Example:

```html
<script src="/js/myscript.20120305.js"></script>
<script src="/js/jqueryplugin.45.js"></script>
<link rel="stylesheet" href="css/somestyle.49559939932.css">
<link rel="stylesheet" href="css/anotherstyle.2.css">
```

**N.B. You do not have to rename the resource on the filesystem.** All you have
to do is add the timestamp number to the filename in your HTML source. The
`.htaccess` directive will serve up the proper file.

Traditional cache busting involved adding a query string to the end of your
JavaScript or CSS filename whenever you updated it.

```html
<script src="/js/all.js?v=12"></script>
```

However, as [Steve Souders](http://stevesouders.com/) explains in [*Revving
Filenames: don’t use
querystring*](http://www.stevesouders.com/blog/2008/08/23/revving-filenames-dont-use-querystring/),
the query string approach is not always reliable for clients behind a Squid
Proxy Server.


## Trailing slash redirects

Trailing slash redirects can be done by adding one of the options below in `.htaccess`.

### Option 1
Rewrite `domain.com/foo` -> `domain.com/foo/`.

```apache
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_URI} !(\.[a-zA-Z0-9]{1,5}|/|#(.*))$
RewriteRule ^(.*)$ $1/ [R=301,L]
```

### Option 2
Rewrite `domain.com/foo/` -> `domain.com/foo`

```apache
RewriteRule ^(.*)/$ $1 [R=301,L]
```

Here are some tips to show you how to integrate the rewrite rules with
different CMS tools. There are four areas you need to look out for:

### 1. Keep a backup

If you use trailing slash redirects on an existing site, always keep a backup
of your `.htaccess` and test thoroughly on your staging server before using it on
a production server.

### 2. Don't replace existing rules, merge

For example, if you use CodeIgniter you may have existing URL rewrite rules like:

```apache
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1
```

Merge the above with H5BP rules below:

```apache
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_URI} !(\.[a-zA-Z0-9]{1,5}|/|#(.*))$
RewriteRule ^(.*)$ $1/ [R=301,L]
```

### 3. Be careful of the order

Make sure you test thoroughly in your staging environment. For the above
example, the order is add trailing slash first, and add your existing rule
after:

```apache
# this adds trailing slash
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_URI} !(\.[a-zA-Z0-9]{1,5}|/|#(.*))$
RewriteRule ^(.*)$ $1/ [R=301,L]

# this gets rid of index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1
```

### 4. Double-check `RewriteBase` path is correct

Make sure your `RewriteBase` path points to the correct location and sits above
any rewrite rules. This usually happens to those have WordPress and ran the
auto install. For instance, if you have a site at `example.com/blog`, your
RewriteBase may look like:

```apache
RewriteBase /blog/
```

If you already have a working RewriteBase, keep that and don't remove it.
