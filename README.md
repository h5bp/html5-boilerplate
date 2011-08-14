#  HTML5 Boilerplate [http://html5boilerplate.com](http://html5boilerplate.com)

## Changelog:

### v.2.0 : August 10th, 2011

### v2.0 HIGHLIGHTS

#### NORMALIZE.CSS

We are now using [normalize.css](http://github.com/necolas/normalize.css/) developed by Nicolas Gallagher along with Jonathan Neal instead of the traditional CSS Reset stylesheet.

normalize.css retains useful browser defaults and includes several common fixes to improve cross-browser (desktop and mobile) styling consistency.

Lots of research has gone into normalize, verifying what are the default user agent styles provided by each browser. We can very specifically change only the ones we need to instead of the bulldozer approach.

##### Why this is great news:

* Who likes being so damn redundant and declaring: em, i { font-style: italic; }
* By using normalization instead of a reset + building up default styles, we use less styles and save bytes
* Less noise in your dev tools: when debugging, you don't have to trawl through every reset selector to reach the actual style that is causing the issue.
* More details here: http://necolas.github.com/normalize.css/


#### PROMPT CHROME FRAME FOR IE6
* With the latest release of Chrome frame which does not require admin access to be installed, we felt it was a good time to prompt IE 6 users to install Chrome Frame. (Using protocol-relative url and exact version for higher expires headers)


####BUILD SCRIPT++: Faster, @import inlining, appcache generation
*  If 15 seconds was too long to wait before, you'll be happy with the changes. Via a new "intermediate" folder, we cut down build time by 80% or more.
*  If you use <code>@import</code>s in your CSS to author in multiple files, the build script will inline all these together. This way, you have a maintainable authoring experience, and still a highly performant production version.
* Making an app that works offline is a badge of honor. Now with a flick of a config switch, the H5BP build script can autogenerate your cache manifest file with all the right info and wire it up. It'll also keep the manifest revved as you deploy new changes.

##### ADDING RESPOND.JS
* Add respond.js as a shift to a responsive approach. Updated it to improved, comment-free version which would enable IEs to also apply styles using media queries.


#### PNGFIX & HANDHELD REMOVED
* Remove handheld.css as we do not think it was useful among the diverse feature phones
* We feel tools like imagealpha and pngquant are more useful than using stopgap fixes like belatedpng.

### detailed 2.0 changelog

#### .HTACCESS
* Disable directory browsing by default
* removed trailing slash redirects in htaccess. More: https://github.com/paulirish/html5-boilerplate/wiki/Proper-usage-of-trailing-slash-redirects #493 #515
* Updating TTF mimetype to fix Google Chrome warning
* Improved support for all versions of Apache, incl workaround for bug in mod_filter: Fixes #441. Fixes #499. Fixes #535. Closes #549. (the grouping ticket) Ref #576
* Use substring matching in gzip filter_module and re-enable gzip for some common MIME-types
* mod_deflate trigger rules modifications
* Add gzip support for XHTML, RSS, Atom
* Move font & SVG compression from FilesMatch to FilterProvider / AddOutputFilterByType
* Added m4a (Need it for IE9) and m4v (HandBrake default) MIME types.
* moved ETag removal configs closer
* added Header unset ETag In some servers setting "FileETag None" alone, is not enough. Removing header and setting it to None fixes the issue.
* Add `Options +FollowSymlinks` when `RewriteEngine` is used. Fixes #489.
* Some more security for PHP: turn off error display and turn on error logging
* Allow Blackberry to read vCards


#### BUILD SCRIPT
* CSSLint, JSLint, JSHint tools are now optionally available in the build script
* New features in build script:
* Added a files.bypass property  which when set, will not compress the listed JavaScript files, but just silently passes it on to the publish folder without any change.
* Added a images.bypass with a list of image files or folders within the img directory that you do not want to be optimized. Fixes #564
* Build script is compatible with php files now. it appears. fixes #392.
* Build script now generates appcache manifest. see #652
* Test for ant version to head off problems with ant < 1.8.2
* removes concatenated css files from index.html when they are linked to with link tag. Fixes #452
* Added DOCTYPE so Eclipse and other IDE's do not complain about the lack of schema. http://stackoverflow.com/questions/363768/disable-dtd-warning-for-ant-scripts-in-eclipse
* Updated Windows optipng and jpegtran paths to include ${basedir}
* Minification affects all .css and .js files in /css and /js dirs,  not just the ones explicitly included in concatenation.
* Build script: compress all images in subfolders, too.
* Added gae.js_dir and gae.css_dir so that App Engine projects can have the correct directory names swapped in their templates.
* added a second replace token statement so that "/css/style.css" gets swapped too.
* change *.png and *.jpg to **/*.png and **/*.jpg so that optimize commands reach subdirectories.
* Improved build script compatibility with Netbeans IDE. default.properties: added IDE generated files/folders to exclude from build script .gitignore: Filename case correction for Windows generated Thumb.db Fix #374
* Adding properties to project.properties so that Google App Engine builds don't have "static" prepended when swapping for minified versions.
* console.log messages are no longer commented out. use log() instead

* Much faster build process

Intermediate stages are stored in a new intermediate folder, and only
files that should be published are copied into the publish folder.

Files are not deleted at the beginning of every build, and files that
have already been processed will not be reprocessed unless the source
has changed.

* Files are revved by SHA, not incrementally at each build

Versioned files are referenced by a SHA-1 hash of the content rather
than a build number. This means that changing your HTML and rebuilding
will not cause your users to redownload the same CSS and JavaScript, and
a reverted change may cause users to use a copy that was previously
downloaded. It may be better to use only part of the hash so the HTTP
request is shorter.

* copy files last This slightly simplifies copying because we don't have to exclude PNG, JPEG, or HTML files from the copy stage. it comes preminified, and we don't need to minify it again This also updates the HTML so that the script is not missing if the unminified scripts are unavailable on the server. This commit requires a change to existing HTML files :/
* change the source htaccess rather than updating it
* update yuicompressor to 2.4.5. fixes media query minification issue.
* update htmlcompressor to 1.1 which uses the new yuicompressor for CSS.
* try not to re-optimize the same images every time
* Lots of bug fixes for edge cases and improved techniques..



#### INDEX.HTML
* Use minified jQuery by default. / jQuery updated to 1.6.2
* Add respond.js as part of shift to 'mobile first' approach.
* Updated to Modernizr 2.0 Complete, Production minified.
* Prompt IE 6 users to install Chrome Frame, update chromeframe install to 1.0.3.  Move chromeframe to bottom of page after the other scripts. also reference exact version for higher expires headers. Use protocol-relative url for chrome frame URL Fixes #495
* Removing touch icon link tags and retaining only the comment.
* Encourage people to send the X-UA-Compatible HTTP header instead of leaving it in the HTML, to avoid edge case issues. Fixes #378.
* Remove the cache-busting query parameters from the HTML.
* Simplify the conditional comment containing code for IE 9+ and modern browsers
* Simpler escape for `</script>`. See http://mathiasbynens.be/notes/etago for more information.
* Encourage people to use a custom Modernizr build containing only the features they need for that particular project.
* Added maximum touch-icon support as per http://mathiasbynens.be/notes/touch-icons#sizes
* Add a link to optional <meta> tags that could be added to the <head> element: https://github.com/paulirish/html5-boilerplate/issues/482
* Standardize the use of single and double quotes as per http://h5bp.com/d/The-markup★quotes
* Added Site Speed tracking for Google Analytics
* Using Modernizr.load/yepnope for loading Google Analytics. Fixes #542
* Google Analytics now retrieved with <code>Modernizr.load()</code> for byte brevity and optimal speed

#### STYLE.CSS
* Major: Now using css normalization instead of css reset + building up default styles.  Fixes #412, #500, #534. Closes #456. Links #566
* Add `'oldie'` class to conditional `<html>` classnames. Fix #522
* Add `img { max-width: 100%; }` to print styles to prevent images from getting cut off.
* Update clearfix to use 'micro' clearfix http://nicolasgallagher.com/micro-clearfix-hack/
* Add placeholder CSS MQs for mobile-first approach
* Tweaking our hot pink ::selection. It is now #fe57a1, which is Festal (adj): pertaining to or befitting a feast, festival, holiday, or gala occasion.
* Use black for links when printing, refs #147
* added vertical-align: middle to fix borders on image containers. Fixes #440
* Add `<svg>` overflow fix for IE9. Group `<img>` and `<svg>` rules in an 'embedded content' section of CSS file. Add {cursor:pointer} to <label> element.
* Switch to outline:0 for accesible focus treatment. Avoids Opera bug when combined with transitions. Also saves bytes.
* Set `{overflow:auto}` for `<button>` and `<input>` in `<table>` in IE6/7. Avoids numerous layout and whitespace issues that result from setting {overflow:visible} to fix the odd inner spacing of those form elements.
* Add `{resize: vertical}` to `<textarea>`. Only allow vertical resizing


#### MISC

* gitignore additions: textmate project folder, older CVS folders,  sass_cache.
* Update HTML elements demo: reduce repetition, remove deprecated elements, add certain HTML5 elements, add more comprehensive collection of HTML5 input types, include different form markup styles, add form elements box-sizing test
* Add .gitattributes to help with consistent line endings
* Changed curly quotes to straight quotes in crossdomain.xml


#### Significant commits:

* 26a391c60d0356e2e0dcf1929381583622e1be9c Revert "Added native iOS inertia scrolling"
* ddaf66a515c09f835603f95fe723d7da691324e6 Major: Now using css normalization instead of css reset + building up default styles
* e5e057e53815ed55f4ecfaef3057bf2940c7c0b2 Change our conditional comments around the HTML tag to use a single .oldie class.
* 7f53f98ec734e6b655d7a50fd245277d388fac1e Revert "Change our conditional comments around the HTML tag to use a single .oldie class."
* 648026d780dc6b9ecad8d37d61a92b69be5fd654 Tweaking our hot pink ::selection based on a suggestion from David Murdoch and research from Adam Diehm.
* 0e1c7ba929caddec63971cccfb7de7c0d343e060 Use minified jQuery by default.
* a0ac99a4d96453e68ff4e650fca3055767ec26aa optimize build process
* bb22ca66a8619808a87c1b5438845ed44baa4d3e Remove the cache-busting query parameters from the HTML.


#### CONTRIBUTORS
[alrra](https://github.com/alrra) [Adeel Ejaz](http://adeelejaz.com/) [David Murdoch](http://www.vervestudios.co/) [Jonathan Fielding](https://github.com/jonathan-fielding) [Robert Ros](https://github.com/rros) [Rob Larsen](http://htmlcssjavascript.com/) [William Meleyal](http://meleyal.com/) [Bruno De Barros](http://terraduo.com/) [Mike Almond](http://mikealmond.com/) [Frank](https://github.com/thatcoolguy) [Joey Baker](http://byjoeybaker.com/) [Ben Word](http://benword.com/) [Mike Botsko](http://www.botsko.net/) [Carlos Rosquillas](https://github.com/disusered) [Todd H. Gardner](https://github.com/toddhgardner) [rdeknijf](https://github.com/rdeknijf) [John Attebury](https://github.com/johnattebury) [Calvin Rien](https://github.com/darktable) [Ryan Seddon](https://github.com/ryanseddon) [Dayle Rees](http://www.daylerees.com/) [Ryan Smith-Roberts](https://lab.net/) [Brian Blakely](https://github.com/brianblakely) [Steve Heffernan](http://www.steveheffernan.com) [Barney Carroll](http://barneycarroll.com/) [Osman Gormus](https://github.com/gormus) [Jason Tokoph](http://www.mozes.com/) [See Guo Lin](http://see.guol.in/) [Jeremey Hustman](http://www.ukontrol.com/) [James Williams](http://jameswilliams.be/blog) [John-Scott Atlakson](https://github.com/jsma) [stereobooster](https://github.com/stereobooster) [walker](http://walkerhamilton.com/) [François Robichet](http://www.francois.robichet.com/) [leobetosouza](http://leobetosouza.com/) [Matthew Donoughe](http://static.dyndns.org/~mdonoughe/) [Patrick Hall](http://lotsofwords.org/) [Andy Dawson](http://www.ad7six.com/) [Daniel Filho](http://danielfilho.info/blog/) [Clément](https://github.com/clemos) [Joe Morgan](https://github.com/JoeMorgan) [Han Lin Yap](http://www.zencodez.net/) [Gregg Gajic](https://github.com/gg) [Michael Cetrulo](http://www.linkedin.com/in/web2samus) [Robert Doucette](https://github.com/robbyrice) [lexadecimal.com](http://lexadecimal.com/) [Adam Diehm](http://twitter.com/atdiehm)


### v.1.0 : March 21st, 2011

#### Build Script
<ul>
	<li>Files linked via <code>@import</code> will be inlined into the files they are imported to using Corey Hart's CSS Compressor.</li>
	<li>Environments are definable.</li>
	<li>htaccess Expires headers are upgraded to 1year, as the filenames are revved</li>
	<li>Massive rewrite so you can define which HTML, CSS, and JS files to operate on in your configurable project.properties files. This allows you to let the build script operate on unique folder architectures (including non-H5BP projects).</li>
	<li>Added a source directory option in the build config, so your source files can be in a different directory from the final generated files. (Useful for other CMSes/frameworks like Django.) </li>
</ul>

#### index.html
<ul>
	<li>We use a <a href="http://paulirish.com/2010/the-protocol-relative-url/">protocol-relative URL</a> for the jQuery include, to prevent the mixed content warning.</li>
	<li>The order of <code>&lt;meta></code> tags, <code>&lt;title></code>, and <code>charset</code> has been <a href="https://github.com/paulirish/html5-boilerplate/wiki/The-markup">documented more extensively now</a>. TL;DR: You are <a href="https://github.com/paulirish/html5-boilerplate/commit/4b67ea5cabb8c2b75faf2e255344cdffdf190464">safe to use the boilerplate's order of tags</a>.</li>
	<li>We've shortened up the Google Analytics snippet.</li>
	<li>Added an ARIA <code>role</code> attribute to <code>div#main</code>. This assumes your main content goes within that container.</li>
	<li>IE9 doesn't get its own conditional class! Yay!</li>
</ul>

#### style.css
<ul>
	<li>Added <code>.focusable</code> helper class, which extends <code>.visuallyhidden</code> to allow the element to be focusable when navigated to via the keyboard.</li>
	<li>Anchor links are no longer reset. Basically our reset is effectively merged with Eric Meyer's recent CSS reset update, and the HTML5 Doctor reset.</li>
	<li>An unordered list within a <code>&lt;nav></code> element will no longer have a margin.</li>
	<li>All helper classes are now after primary styles to ensure correct overrides and not be burdened with resets. </li>
	<li><code>.visuallyhidden</code> is no longer camelCase for consistency with other classname formats.</li>
	<li>Updated the specificity of <code>.visuallyhidden</code> to make sure it overrides all other declarations. </li>
	<li>Removed reset on <code>&lt;img></code> elements within table cells as they look ugly alongside multiline texts. Browsers default to baseline alignment for images, which works better than top alignment.</li>
	<li>Increased margin-left on <code>&lt;ol></code>, to allow for 2-digit list numbers.</li>
	<li>Added a print reset on IE's proprietary filters.</li>
	<li>Print styles no longer prints hash links or JavaScript links.</li>
	<li>Updated <code>&lt;sub></code>/<code>&lt;sup></code> CSS so that they're not impacted by <code>line-height</code>, so now you can do sub/superscripts without worrying.</li>
</ul>

#### Project
<ul>
	<li>Added a <a href="http://humanstxt.org">humans.txt</a> so you can clarify authorship and tools used.</li>
	<li>Removed YUI profiling. You probably weren't using it anyway.</li>
	<li>Removed QUnit's unit tests. There is no need to ship with them, really.</li>
</ul>

#### Webserver Configs
#### .htaccess
<ul>
	<li>.htaccess is far more documented now. Take a read through it!</li>
	<li><a href="https://github.com/paulirish/html5-boilerplate/commit/37b5fec090d00f38de64b591bcddcb205aadf8ee">Changed mimetype of <code>.ico</code> files to <code>image/x-icon</code></a>.</li>
	<li>HTML Manifest files now use <code>.appcache</code> extension instead of <code>.manifest</code>, as per <a href="http://html5.org/r/5812">http://html5.org/r/5812</a>.</li>
	<li>Force deflate for accept-encoding headers mangled by turtle tappers, courtesy of <a href="http://developer.yahoo.com/blogs/ydn/posts/2010/12/pushing-beyond-gzipping/">Yahoo!'s research</a></li>
	<li>We nerfed some of the directives in case you're on a server without <code>mod_headers</code>. (Which is totally crazy, man!)</li>
	<li>Block access to <code>.git</code> and <code>.svn</code> folders.</li>
	<li>Eradicating Chrome's console warning on WOFF font downloads.</li>
	<li>More optimizations available if you set the <code>.htaccess</code> details up in your <code>httpd.conf</code></li>
	<li><code>.htaccess</code> now caches <code>.htc</code> files</li>

	<li>Moved all server configurations (except Apache's <code>.htaccess</code>) over to <a href ="https://github.com/paulirish/html5-boilerplate-server-configs">the new html5-boilerplate-server-configs repo</a>. Head over there if you're not using Apache. </li>

	<li>Updated <code>.htaccess</code> and <code>mime.types</code> for <code>ogg</code> formats.</li>
	<li>Fixed regression where EOT fonts had been excluded from DEFLATE compression</li>
	<li>Apache version independence: Use <code>mod_filter</code> for compression, with fallback to AddOutputFilterByType directive for legacy versions</li>
	<li>Added plugin/extension mime types for Safari, Chrome, Firefox</li>
</ul>
#### nginx
<ul>
	<li>Cleaned up cache expires directives.</li>
	<li>Now includes SVG and font formats for gzipping.</li>
	<li>expires header bug fixed.</li>
</ul>
#### IIS
<ul>
	<li>Added Flash video mime types to IIS server</li>
	<li>Fixed some mimetype weirdness that was preventing proper caching</li>
</ul>

<ul>
	<li>Also Google App Engine, Lighttpd, and NodeJS <a href="https://github.com/paulirish/html5-boilerplate-server-configs">configurations were added</a></li>
</ul>

<p>Basically a lot of great updates were made for 1.0. <a href="https://github.com/paulirish/html5-boilerplate/compare/v0.9.5...v1.0">Here are all 220 commits since last release.</a>. You may ask though, <a href="http://html5boilerplate.com/docs/#FAQs★do-i-need-to-upgrade-my-sites-to-a-new-version">do I need to upgrade existing sites</a>? Short answer: nah, you're good.</p>

#### Contributors
[Mickael Daniel](http://blog.mklog.fr/), Dave Kirk, [Jonathan Verrecchia](http://www.html5-css3.fr/), [nlogax](https://github.com/nlogax), [Rob Larsen](http://htmlcssjavascript.com/),
[David Murdoch](http://www.vervestudios.co/), [AD7six](http://www.ad7six.com/),
[Mathias Bynens](http://mathiasbynens.be/), [Michael van Laar](http://www.michael-van-laar.de/), [Mike West](http://mikewest.org/), [Mikko Tikkanen](http://www.mintusability.com/), [Velir](http://velir.com/), [Stephen Gariepy](http://garowetz.ca/)

##### Boilerplate
[Adam J. McIntyre](http://www.amodernfable.com/), [Adeel Ejaz](http://adeelejaz.com/), akolesnikov, [Alex Dunae](http://dialect.ca/), [Andrew Le](http://andrewdle.com/), [ashnur](https://github.com/ashnur), [Ben Truyman](http://bentruyman.com/), [Bruno Aguirre](http://brunoaguirre.com/), [Chris Hager](http://metachris.org/), [Corey Ward](http://blog.coreyward.net/), [Craig Barnes](https://github.com/craigbarnes), crappish, [Daniel Schildt](http://autiomaa.org/), [Dave DeSandro](https://github.com/daveatnclud), [Dustin Whittle](http://dustinwhittle.com/), grigio, [Irakli Nadareishvili](http://freshblurbs.com/), [Jaime Bueza](http://jaime.bueza.com/), [Jake Ingman](https://github.com/jingman), [James A. Rosen](http://jamesarosen.com/), [Jeremy Balch](https://github.com/balchjd), [joe bartlett](http://twitter.com/jdbartlett), [Joe Sak](http://www.joesak.com/), [John Bacon](https://github.com/johnbacon)
[Jonathan Fielding](https://github.com/jonathan-fielding), [Jonathan Neal](http://iecss.com/), [kblomqvist](https://github.com/kblomqvist), [Kenneth Nordahl](http://nordahl.me/), [Maarten Verbaarschot](https://github.com/mverbaar), [Manuel Strehl](http://www.manuel-strehl.de/), [Marcel Turi](http://marcel.turi.co/), [Martin Hintzmann](https://github.com/Hintzmann), [mikealmond](https://github.com/mikealmond)
[mikkotikkanen](http://www.mintusability.com/), [Nic Pottier](https://github.com/nicpottier), [Paul Neave](http://www.neave.com/), [Peter Beverloo](http://peter.sh/), [Rick Waldron](http://weblog.bocoup.com/), [Rob Flaherty](http://www.ravelrumba.com/), [S Anand](http://www.s-anand.net/), [Sam Sherlock](http://samsherlock.com/), [Michael Cetrulo](http://www.linkedin.com/in/web2samus), [simshaun](https://github.com/simshaun), [Sirupsen](http://sirupsen.com/), [Stephen Gariepy](http://garowetz.ca/), [timemachine3030 ](https://github.com/timemachine3030), [Vinay](http://www.artminister.com/), [Weston Ruter](http://weston.ruter.net/), [WraithKenny](http://unfocus.com/), [Yann Mainier](http://yann.mainier.com/), [Michael van Laar](http://www.michael-van-laar.de/), [Massimo Lombardo](http://unwiredbrain.com/), [Ivan Nikolić ](http://twitter.com/niksy), [Kaelig](http://kaelig.fr/), [Richard Bradshaw](http://bradshawenterprises.com/), [SammyK](http://sammyk.me/), [alrra](https://github.com/alrra), [Rizky Syazuli](http://id.linkedin.com/in/rizky), [iszak](https://github.com/Iszak), [aaron peters](https://github.com/aaronpeters), [Swaroop C H](http://www.swaroopch.com/), [Mike Połtyn](http://mike.poltyn.com/), Marco d'Itri, Mike Lamb , [BIG Folio](http://bigfolio.com/), Philip von Bargen, Meander, Daniel Harttman, rse, timwillison, ken nordahl, [Erik Dahlström](http://my.opera.com/macdev_ed), christopherjacob, [Chew Choon Keat](http://blog.choonkeat.com/), benalman, stoyan, Markus, [Vladimir Carrer](http://www.vcarrer.com/), [aristidesfl](https://github.com/aristidesfl), [Trevor Norris](http://blog.trevorjnorris.com/) [Miloš Gavrilović](http://www.arvag.net/)



#####Configs
[Dusan Hlavaty](http://sk.linkedin.com/in/dusanhlavaty), [Sean Caetano Martin](http://www.xonecas.com/), [yaph](http://www.ramiro.org/), [michaud](https://github.com/michaud), Paul Sarena, [Graham Weldon](http://grahamweldon.com/), [Ron. Adams](http://visual-assault.org/)

#####Translators
[alrra](http://twitter.com/alrra), [Anton Kovalyov](http://self.kovalyov.net/), [Milos Gavrilovic](http://www.arvag.net/), [jorge-vitrubio](https://github.com/jorge-vitrubio), Julian Wachholz, [laviperchik](https://github.com/laviperchik), [lenzcom](https://github.com/lenzcom), [Mathias Bynens](http://mathiasbynens.be/), [Mickael Daniel](http://blog.mklog.fr/), [Mike West](http://mikewest.org/), [Niels Bom](http://www.nielsbom.com/), Ricardo Tomasi, [skill83 ](https://github.com/skill83), [Sean Caetano Martin](http://www.xonecas.com/), [Yuya Saito](http://css.studiomohawk.com/), [Zee-Julien](https://github.com/Zee-Julien)


### v.0.9.5 : October 25th, 2010

Major changes:

<ul>
<li>Removed <code>-webkit-font-smoothing: antialiased;</code> it makes monospace too thin.</li>
<li>IE conditional classes have moved from the <code>&lt;body&gt;</code> tag to the <code>&lt;html&gt;</code> tag ( #44 ).</li>
<li>Dropped <code>text-rendering: <a href="http://www.aestheticallyloyal.com/public/optimize-legibility/">optimizeLegibility</a></code> as it breaks small-caps, looks odd on Linux machines, and goes invisible on WebOS.</li>
<li>Added a IE6 call for the minified <code>dd_belatedpng</code>.</li>
<li>Revised viewport declaration to allow user scaling and clear Webkit console errors ( #37 ).</li>
<li>Updated Modernizr to 1.6 </li>
<li>Added <code>web.config</code> file for Microsoft IIS</li>
<li>Beta release of the <a href="http://github.com/paulirish/html5-boilerplate/wiki/Build-script">Build Script</a> (this is HUGE)</li>
<li>New project scaffolding <a href="http://github.com/paulirish/html5-boilerplate/wiki/makep.sh">bash script</a>.</li>
</ul>

#### General
* Updated Modernizr to 1.6 (smaller and faster)
* Added web.config file for Microsoft IIS. Now forcing latest IE version and ChromeFrame, if installed.
* Added <code>favicon</code> and <code>default icon</code> for iOS.
* Updated <code>crossdomain.xml</code> wording for better security guidelines ( #124 ).
* Expires value for <code>nginx.conf</code> corrected.
* License clarified.

#### style.css
* Removed <code>-webkit-font-smoothing: antialiased</code> as it made monospace too thin.
* Updated fonts normalization to YUI 3.2.0 PR1.
* Table Header set explicitly for IE6, and table row now has <code>page-break: avoid</code> in print CSS.
* <code>text-shadow:none !important</code> set for all text in print CSS.
* Removed scrollbar from <code>&lt;textarea></code>s in IE.
* Fixed <code>&lt;textarea></code> stylings and form field treatment for validity. Added default <code>background-color</code>.
* New robust clearfix solution without IE 5.5 hack ( #45 #126 ).
* Margins for form-elements explicitly set to <code>0</code> as webkit adds 2px space around form elements' chrome.
* Dropped <code>text-rendering: optimizeLegibility</code> as it breaks <code>small-caps</code> and looks odd on Linux machines.
* Lists now have a left margin of <code>1.8em</code>. Default <code>list-style-type</code> for ordered list is <code>decimal</code>.
* Image Replacement now works with right-to-left text ( #68 ).
* Removed "Star Hack" for checkboxes in favor of <code>.ie7</code> selector.

#### index.html
* IE conditional classes have moved from the <code>&lt;body></code> tag to the <code>&lt;html></code> tag ( #44 ).
* Added a IE6 call for the minified <code>dd_belatedpng</code>.
* Google Analytics script will now work with SSL in IE6.
* Added protocol independent absolute path for cdn jquery, with improved fallback-to-local code to protect against edge case IE bug.
* Commented out handheld CSS ( #73 ).
* Mobile viewport and textsize styles adjusted per group feedback ( #37 ).

#### .htaccess
* More files are served via gzip like <code>.htc</code> ( #55 ).
* Added Expires header for content types image/gif and video/webm.
* Fixed favicon display in IE6 ( #113 ).
* Corrected mimetypes for fonts.
* Removed caching for files of type json/xml.
* Better use of <code>ifmodule</code> for more stability in different Apache environments.

[View full diff and commit history](http://github.com/paulirish/html5-boilerplate/compare/v0.9.1...v0.9.5)


#### Contributors
Shi Chuan, Rob Larsen, Ivan Nikolić, Mikko Tikkanen, Velir, Paul Neave, Weston Ruter, Jeffrey Barke, Robert Meissner, SirFunk, Philip von Bargen, Kroc Camen, Rick Waldron, Andreas Madsen, Marco d'Itri, Adeelejaz, James Rosen, Dave DeSandro, Ken Newman, Daniel Lenz, Swaroop C H, Yann Mainier, Joe Sak, Irakli, Rob Flaherty, Jeff Starr, Mike Lamb, Holek, Aaron Peters, Kaelig, Meander, Charlie Ussery, Ciney, Région Wallonne, Sirupsen, and Paul Hayes.



### v.0.9.1 : August 13th, 2010
* HTML5 Boilerplate is now in the Public Domain
* Nginx configuration added
* Font stacks (sans-serif and monospace) simplified
* Very accessible <code>a:focus</code> styles.
* Corrected IE=edge,chromeframe enabling (As a result, the base HTML [does not validate](http://bit.ly/cGSSgr))
* ServerSideIncludes disabled by default.
* Apache config bugfixes
* Conditional body tag class combined
* dd_belatedPNG updated to 0.0.8. Redundant BackgroundImageCache fix removed.

[View full diff and commit history](http://github.com/paulirish/html5-boilerplate/compare/v0.9...v0.9.1)

##### Thanks:

voodootikigod, garowetz, fearphage, christopherjacob, mathias bynens, daniel harttman, rse, chris dary, erik dahlstrom, timwillison, kenneth nordahl, riddle, elcuervo, andreas kuckartz, 3rdEden, riley willis, majic3

### v0.9 : August 10th, 2010 - Initial release


## License:

Major components:

* Modernizr: MIT/BSD license
* jQuery: MIT/GPL license
* DD_belatedPNG: MIT license
* YUI Profiling: BSD license
* HTML5Doctor CSS reset: Public Domain
* CSS Reset Reloaded: Public Domain

Everything else:

* [The Unlicense](http://unlicense.org) (aka: public domain)


## Summary:

This is a set of files that a front-end developer can use to get started on a website, with following included:

1. Cross-browser compatible (IE6? Yeah, we got that.)
2. HTML5 ready. Use the new tags with certainty.
3. Optimal caching and compression rules for Grade-A performance
4. Best practice site configuration defaults
5. Think there's too much? The HTML5 Boilerplate is delete-key friendly. :)
6. Mobile browser optimizations
7. Progressive enhancement graceful degredation ........ yeah yeah we got that
8. IE-specific classes for maximum cross-browser control
9. Want to write unit tests but lazy? A full, hooked up test suite is waiting for you.
10. Javascript profiling…in IE6 and IE7? Sure, no problem.
11. Console.log nerfing so you won't break anyone by mistake.
12. Never go wrong with your doctype or markup!
13. An optimal print stylesheet, performance optimized
14. iOS, Android, Opera Mobile-adaptable markup and CSS skeleton.
15. IE6 pngfix baked in.
16. jQuery, waiting for you

## Releases

There are two releases: a documented release (which is exactly what you see here), and a "stripped" release (with most of the descriptive comments stripped out).

Watch the [current tickets](http://github.com/paulirish/html5-boilerplate/issues) to view the areas of active development.

