HTML5 Boilerplate for Wordpress
===============================

This is template based on the [HTML5 Boilerplate](http://html5boilerplate.com/) by Paul Irish and Divya Manian, and Bruce Lawson's [Designing a Blog with HTML5](http://html5doctor.com/designing-a-blog-with-html5/)

Instead of using only DIVs for content layout, it uses new HTML5 tags, including [header](http://html5doctor.com/the-header-element/), 
[footer](http://www.w3schools.com/html5/tag_footer.asp), 
[nav](http://www.w3schools.com/html5/tag_nav.asp), 
[article](http://www.w3schools.com/html5/tag_article.asp), 
and [section](http://html5doctor.com/the-section-element/).

It's a very bare layout, including only the base styles that come with the boilerplate, so layout is up to you.

Getting Started
---------------
1. Add the html-boilerplate-for-wordpress folder to your wp-content/themes folder.
2. Activate the theme. WP-Admin > Appearance > Themes
2. Add the items in the "root" folder to the root of your website (read the Root Files section below).
3. Style away, knowing that you're building on a super solid base with HTML5 awesomeness.

Root Files
----------
### 404 Pages
If you use permanlinks (WP-Admin > Settings > Permalinks), then WordPress handles any 404s with the 404.php included in the theme. If you don't use permalinks, then you need to add the 404.html file from the "root" folder to the root of your site.

### .htaccess
In the root folder you'll fin _htaccess.txt. Add the contents of this file to the .htaccess already at the root of your site, after the existing content. htaccess files are sometimes hidden because they begin with a period (.), so if you don't see one at the root of your site you may need an FTP browser to view/edit it. Read _htaccess.txt for more info on what it does.

### favicon.ico
The favicon is the icon shown to the left of the URL at the top of your browser window. An example is provided. Better to use that one than none at all.

### apple-touch-icon.png
On iPhones and iPads you can book mark a web page and have it show up on the home screen as an icon. The apple-touch-icon.png becomes this icon if used. Rounded corners and glossy finish are added by the device.

### crossdomain.xml
If you don't know what this is, you probably don't need it.
www.adobe.com/devnet/flashplayer/articles/cross_domain_policy.html

### robots.txt
Tells all search engines that they can read and index all pages.