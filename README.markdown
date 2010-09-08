HTML5 Boilerplate for Wordpress
===============================

This theme is built on the [HTML5 Boilerplate](http://html5boilerplate.com/) by Paul Irish and Divya Manian. The sole purpose of this theme is to save developers the time it takes to apply the HTML5 Boilerplate to WordPress. The "HTML5 Boilerplate" name is used with permission from Paul Irish.

The layout is based on Bruce Lawson's [Designing a Blog with HTML5](http://html5doctor.com/designing-a-blog-with-html5/)

Instead of using only DIVs for content layout, it uses new HTML5 tags, including [header](http://html5doctor.com/the-header-element/), 
[footer](http://www.w3schools.com/html5/tag_footer.asp), 
[nav](http://www.w3schools.com/html5/tag_nav.asp), 
[article](http://www.w3schools.com/html5/tag_article.asp), 
and [section](http://html5doctor.com/the-section-element/).

It's a very bare layout, including only the base styles that come with the boilerplate and required WordPress styles, so layout is up to you. Alternatively, you could apply the methods used here to other themes.

Getting Started
---------------
1. Add the html5-boilerplate-for-wordpress folder to your wp-content/themes folder.
2. Activate the theme. WP-Admin > Appearance > Themes
3. Add some of the "Root Files" to the root directory of your website (explained below).
4. Style away, knowing that you're building on a super solid base with HTML5 awesomeness.

Root Files
----------
These files can be found in the html5-boilerplate folder in the theme (html5-boilerplate-for-wordpress/html5-boilerplate). Some of the files listed here should be (carefully) moved to the root of your site (same level as the wp-content directory). Read on for specific instructions.

### 404 Page
If you use permanlinks (WP-Admin > Settings > Permalinks), then WordPress handles any 404s with the 404.php included in the theme. If you don't use permalinks, then add the 404.html file to the root of your site.

### .htaccess
**Do not copy to the root of your site.** This may overwrite the WordPress htaccess, and break Wordpress. Instead, copy and paste the contents of this file to the .htaccess already at the root of your site, after the existing content. It would be good to make a comment where the Boilerplate content begins, like "# Begin HTML5 Boilerplate". Read htaccess file for more info on what it does.
**This file may not be visible if you're viewing the folder on your computer. Files that start with a "." are often hidden. It should be visible through your FTP browser once uploaded.**

### nginx.conf
Used for a different type of web server than Apache. You don't need it.

### crossdomain.xml
If you don't know what this is, you probably don't need it.
www.adobe.com/devnet/flashplayer/articles/cross_domain_policy.html

### robots.txt
Tells all search engines that they can read and index all pages. This is handled by WordPress so you shouldn't need to move this to the root.

Root Images
-----------
These aren't included with the HTML5 Boilerplate, but links to them are, so these were created so that you don't return a 404 when the browser requests them. Better to include these or make your own, than not include any. The can be found in the images folder of the theme (html5-boilerplate-for-wordpress/images).

### favicon.ico
The favicon is the icon shown to the left of the URL at the top of your browser window.

### apple-touch-icon.png
On iPhones and iPads you can book mark a web page and have it show up on the home screen as an icon. The apple-touch-icon.png becomes this icon if used. Rounded corners and glossy finish are added by the device.

